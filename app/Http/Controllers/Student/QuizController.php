<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * List active quizzes for students.
     */
    public function index()
    {
        $user = auth()->user();

        $quizzes = Quiz::where('is_active', true)
            ->with(['lesson.subject', 'questions'])
            ->orderBy('title')
            ->get();

        $latestAttempts = QuizAttempt::where('user_id', $user->id)
            ->with('quiz')
            ->latest('created_at')
            ->get()
            ->unique('quiz_id')
            ->keyBy('quiz_id');

        return view('student.quizzes.index', [
            'quizzes' => $quizzes,
            'latestAttempts' => $latestAttempts,
        ]);
    }

    /**
     * Show a quiz and its questions.
     */
    public function show(Quiz $quiz)
    {
        if (!$quiz->is_active) {
            abort(404);
        }

        $quiz->load(['lesson.subject', 'questions']);

        return view('student.quizzes.show', [
            'quiz' => $quiz,
        ]);
    }

    /**
     * Submit quiz answers and store attempt score.
     */
    public function submit(Request $request, Quiz $quiz)
    {
        if (!$quiz->is_active) {
            abort(404);
        }

        $quiz->load('questions');

        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        $total = $quiz->questions->count();
        $correct = 0;
        $feedback = [];

        foreach ($quiz->questions as $question) {
            $answer = $validated['answers'][$question->id] ?? null;
            $isCorrect = $answer !== null && $answer === $question->correct_answer;

            if ($isCorrect) {
                $correct++;
            }

            $feedback[] = [
                'question' => $question->question,
                'selected_answer' => $answer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect,
            ];
        }

        $score = $total > 0 ? (int) round(($correct / $total) * 100) : 0;

        QuizAttempt::create([
            'user_id' => auth()->id(),
            'quiz_id' => $quiz->id,
            'overall_score' => $score,
        ]);

        return view('student.quizzes.results', [
            'quiz' => $quiz,
            'attempt' => $attempt,
            'score' => $score,
            'correct' => $correct,
            'total' => $total,
            'feedback' => $feedback,
        ]);
    }
}
