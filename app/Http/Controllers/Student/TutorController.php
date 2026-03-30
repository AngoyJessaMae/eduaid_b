<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AIChatMessage;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TutorController extends Controller
{
    /**
     * Display the AI tutor chat interface.
     */
    public function index(Request $request)
    {
        $lessonId = $request->query('lesson_id');
        $lesson = null;

        if ($lessonId) {
            $lesson = Lesson::find($lessonId);
        }

        $user = auth()->user();
        $messages = AIChatMessage::getConversationHistory($user->id);
        $lessons = Lesson::where('is_active', true)->orderBy('title')->get(['id', 'title']);

        return view('student.tutor.chat', [
            'messages' => $messages,
            'lesson' => $lesson,
            'lessons' => $lessons,
        ]);
    }

    /**
     * Send a message to the AI tutor.
     */
    public function sendMessage(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:2000',
            'lesson_id' => 'nullable|integer|exists:lessons,id',
        ]);

        $user = auth()->user();

        // Store user message
        $userMessage = AIChatMessage::create([
            'user_id' => $user->id,
            'lesson_id' => $validated['lesson_id'] ?? null,
            'role' => 'user',
            'message' => $validated['message'],
        ]);

        // Get safety-filtered AI response
        $aiResponse = $this->generateAIResponse($validated['message'], $validated['lesson_id'] ?? null);

        // Store assistant message
        $assistantMessage = AIChatMessage::create([
            'user_id' => $user->id,
            'lesson_id' => $validated['lesson_id'] ?? null,
            'role' => 'assistant',
            'message' => $aiResponse,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'userMessage' => $userMessage,
                'assistantMessage' => $assistantMessage,
            ]);
        }

        return redirect()->route('student.tutor.index', [
            'lesson_id' => $validated['lesson_id'] ?? null,
        ]);
    }

    /**
     * Get conversation history.
     */
    public function getHistory(Request $request)
    {
        $user = auth()->user();
        $limit = $request->query('limit', 50);

        $messages = AIChatMessage::where('user_id', $user->id)
            ->latest()
            ->limit($limit)
            ->get()
            ->reverse();

        return response()->json($messages);
    }

    /**
     * Generate AI tutor response with safety filters.
     */
    private function generateAIResponse($userMessage, $lessonId = null): string
    {
        // Apply safety filters
        if ($this->isSuspiciousContent($userMessage)) {
            return "I appreciate the question, but I'm designed to help with educational content. Let's focus on your studies. How can I help you with your lessons?";
        }

        // Get lesson context if provided
        $lessonContent = '';
        if ($lessonId) {
            $lesson = Lesson::find($lessonId);
            if ($lesson) {
                $lessonContent = $lesson->content_text;
            }
        }

        $ollamaBaseUrl = rtrim(config('services.ollama.base_url', 'http://127.0.0.1:11434'), '/');
        $ollamaModel = config('services.ollama.model', 'llama3.2:3b');
        $ollamaTimeout = (int) config('services.ollama.timeout', 30);

        $systemPrompt = "You are EduAid Tutor, a helpful academic tutor for Grade 7-12 students. " .
            "Keep answers concise, lesson-focused, and safe. " .
            "If unsure, suggest reviewing lesson basics first.";

        if ($lessonContent !== '') {
            $systemPrompt .= " Use this lesson context when relevant: " . mb_substr($lessonContent, 0, 1200);
        }

        try {
            $response = Http::timeout($ollamaTimeout)
                ->post($ollamaBaseUrl . '/api/chat', [
                    'model' => $ollamaModel,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userMessage],
                    ],
                    'stream' => false,
                    'options' => [
                        'temperature' => 0.4,
                        'num_predict' => 300,
                    ],
                ]);

            if (!$response->successful()) {
                return $this->generatePlaceholderResponse($userMessage, $lessonContent);
            }

            $content = data_get($response->json(), 'message.content');

            if (is_string($content) && trim($content) !== '') {
                return trim($content);
            }
        } catch (\Throwable $exception) {
            // Fall back to deterministic local response when API is unavailable.
        }

        return $this->generatePlaceholderResponse($userMessage, $lessonContent);
    }

    /**
     * Check for suspicious or off-topic content.
     */
    private function isSuspiciousContent($message): bool
    {
        $suspiciousKeywords = [
            'hack', 'crack', 'exploit', 'malware',
            'inappropriate', 'offensive', 'hate',
            'violence', 'suicide', 'self-harm'
        ];

        $lowercaseMessage = strtolower($message);

        foreach ($suspiciousKeywords as $keyword) {
            if (str_contains($lowercaseMessage, $keyword)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Generate placeholder AI response.
     * TODO: Replace with actual LLM API call
     */
    private function generatePlaceholderResponse($userMessage, $lessonContent = ''): string
    {
        $responses = [
            "That's a great question! Let me explain this concept...",
            "Good thinking! Here's another way to look at it...",
            "I understand your question. Let me break it down...",
            "Excellent observation! This relates to...",
            "Let's explore this step by step...",
        ];

        return $responses[array_rand($responses)] . " [AI Tutor Response - Ready for LLM Integration]";
    }
}
