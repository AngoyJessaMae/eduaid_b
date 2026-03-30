<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\PretestAnswer;
use App\Models\PretestAttempt;
use App\Models\PretestQuestion;
use App\Models\Subject;
use Illuminate\Http\Request;

class PretestController extends Controller
{
    /**
     * Show pretest start page with subject selection.
     */
    public function index()
    {
        $user = auth()->user();
        $subjects = Subject::with('pretestQuestions')->get();
        $latestAttempt = PretestAttempt::latestForUser($user->id);

        return view('student.pretest.index', [
            'subjects' => $subjects,
            'latestAttempt' => $latestAttempt,
        ]);
    }

    /**
     * Display pretest questions for a subject.
     */
    public function start(Subject $subject)
    {
        $questions = $subject->pretestQuestions()->get();

        if ($questions->isEmpty()) {
            return redirect()->route('student.pretest.index')
                ->with('error', 'No pretest questions available for this subject.');
        }

        return view('student.pretest.test', [
            'subject' => $subject,
            'questions' => $questions,
        ]);
    }

    /**
     * Submit pretest answers and calculate scores.
     */
    public function submit(Request $request, Subject $subject)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string',
        ]);

        // Create pretest attempt
        $attempt = PretestAttempt::create([
            'user_id' => $user->id,
            'overall_score' => 0,
            'math_score' => 0,
            'science_score' => 0,
            'english_score' => 0,
        ]);

        // Process answers
        $correctCount = 0;
        $totalCount = 0;

        foreach ($validated['answers'] as $questionId => $answer) {
            $question = PretestQuestion::find($questionId);

            if (!$question) continue;

            $isCorrect = $question->correct_answer === $answer;

            PretestAnswer::create([
                'pretest_attempt_id' => $attempt->id,
                'pretest_question_id' => $questionId,
                'selected_answer' => $answer,
                'is_correct' => $isCorrect,
            ]);

            if ($isCorrect) {
                $correctCount++;
            }
            $totalCount++;
        }

        // Calculate scores
        $score = $totalCount > 0 ? round(($correctCount / $totalCount) * 100) : 0;

        // Update attempt with subject-specific score
        $scoreField = match ($subject->name) {
            'Math' => 'math_score',
            'Science' => 'science_score',
            'English' => 'english_score',
            default => null,
        };

        if ($scoreField) {
            $attempt->update([$scoreField => $score]);
        }

        // Calculate overall score
        $attempt->overall_score = round(($attempt->math_score + $attempt->science_score + $attempt->english_score) / 3);
        $attempt->save();

        // Determine learning levels
        $this->updatePretestLevels($attempt);

        return redirect()->route('student.pretest.results', $attempt->id);
    }

    /**
     * Display pretest results.
     */
    public function results(PretestAttempt $attempt)
    {
        $this->authorize('view', $attempt);

        $answers = $attempt->answers()->with('question')->get();

        return view('student.pretest.results', [
            'attempt' => $attempt,
            'answers' => $answers,
        ]);
    }

    /**
     * Update learning levels based on pretest scores.
     */
    private function updatePretestLevels(PretestAttempt $attempt)
    {
        $attempt->math_level = $this->determineLevelFromScore($attempt->math_score);
        $attempt->science_level = $this->determineLevelFromScore($attempt->science_score);
        $attempt->english_level = $this->determineLevelFromScore($attempt->english_score);
        $attempt->save();

        // Also update user's learning level
        $user = $attempt->user;
        $user->overall_diagnostic_score = $attempt->overall_score;
        $user->learning_level = $this->determineLevelFromScore($attempt->overall_score);
        $user->save();
    }

    /**
     * Determine learning level based on score.
     */
    private function determineLevelFromScore($score): string
    {
        if ($score >= 80) {
            return 'Advanced';
        } elseif ($score >= 60) {
            return 'Intermediate';
        } else {
            return 'Beginner';
        }
    }
}
