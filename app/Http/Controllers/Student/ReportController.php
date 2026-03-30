<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LessonProgress;
use App\Models\PretestAttempt;
use App\Models\QuizAttempt;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    /**
     * Student reports panel.
     */
    public function index()
    {
        $payload = $this->buildReportPayload();

        return view('student.reports.index', $payload);
    }

    /**
     * Printable report view.
     */
    public function print()
    {
        $payload = $this->buildReportPayload();

        return view('student.reports.print', $payload);
    }

    /**
     * Download report as CSV.
     */
    public function download(): StreamedResponse
    {
        $payload = $this->buildReportPayload();

        return response()->streamDownload(function () use ($payload) {
            $stream = fopen('php://output', 'w');

            fputcsv($stream, ['Metric', 'Value']);
            fputcsv($stream, ['Lessons Completed', $payload['lessonCompletedCount']]);
            fputcsv($stream, ['Quiz Attempts', $payload['quizAttempts']->count()]);
            fputcsv($stream, ['Average Quiz Score', $payload['averageQuizScore'] . '%']);
            fputcsv($stream, ['Latest Pretest Overall', ($payload['pretestAttempt']?->overall_score ?? 0) . '%']);

            if ($payload['pretestAttempt']) {
                fputcsv($stream, ['Math Level', $payload['pretestAttempt']->math_level]);
                fputcsv($stream, ['Science Level', $payload['pretestAttempt']->science_level]);
                fputcsv($stream, ['English Level', $payload['pretestAttempt']->english_level]);
            }

            fputcsv($stream, []);
            fputcsv($stream, ['Quiz Title', 'Subject', 'Score', 'Date']);

            foreach ($payload['quizAttempts'] as $attempt) {
                fputcsv($stream, [
                    $attempt->quiz->title,
                    $attempt->quiz->lesson->subject->name,
                    $attempt->overall_score,
                    $attempt->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($stream);
        }, 'academic-progress-report.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    /**
     * Build data payload for report views and download.
     */
    private function buildReportPayload(): array
    {
        $user = auth()->user();

        $pretestAttempt = PretestAttempt::latestForUser($user->id);

        $lessonCompletedCount = LessonProgress::where('user_id', $user->id)
            ->where('completed', true)
            ->count();

        $quizAttempts = QuizAttempt::where('user_id', $user->id)
            ->with('quiz.lesson.subject')
            ->latest()
            ->get();

        $averageQuizScore = $quizAttempts->count() > 0
            ? (int) round($quizAttempts->avg('overall_score'))
            : 0;

        return [
            'pretestAttempt' => $pretestAttempt,
            'lessonCompletedCount' => $lessonCompletedCount,
            'quizAttempts' => $quizAttempts,
            'averageQuizScore' => $averageQuizScore,
        ];
    }
}
