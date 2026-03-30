<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\PretestAttempt;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Subject;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Admin dashboard overview panel.
     */
    public function index()
    {
        $stats = $this->buildStats();

        return view('admin.dashboard', [
            'stats' => $stats,
            'chartData' => $this->buildChartData(),
        ]);
    }

    /**
     * Admin analytics page with content/performance sections.
     */
    public function analytics()
    {
        $stats = $this->buildStats();

        $topLessons = Lesson::withCount('studentProgress')
            ->orderByDesc('student_progress_count')
            ->limit(8)
            ->get();

        $topQuizzes = Quiz::withCount('attempts')
            ->orderByDesc('attempts_count')
            ->limit(8)
            ->get();

        return view('admin.analytics', [
            'stats' => $stats,
            'chartData' => $this->buildChartData(),
            'topLessons' => $topLessons,
            'topQuizzes' => $topQuizzes,
        ]);
    }

    private function buildStats(): array
    {
        return [
            'total_students' => User::where('role', 'student')->count(),
            'total_subjects' => Subject::count(),
            'total_lessons' => Lesson::count(),
            'active_lessons' => Lesson::where('is_active', true)->count(),
            'total_quizzes' => Quiz::count(),
            'active_quizzes' => Quiz::where('is_active', true)->count(),
            'pretest_attempts' => PretestAttempt::count(),
            'quiz_attempts' => QuizAttempt::count(),
        ];
    }

    private function buildChartData(): array
    {
        $subjectLessonCounts = Subject::withCount('lessons')
            ->orderBy('name')
            ->get()
            ->map(fn ($subject) => [
                'label' => $subject->name,
                'value' => $subject->lessons_count,
            ]);

        $scoreBands = [
            '0-39' => QuizAttempt::whereBetween('overall_score', [0, 39])->count(),
            '40-59' => QuizAttempt::whereBetween('overall_score', [40, 59])->count(),
            '60-79' => QuizAttempt::whereBetween('overall_score', [60, 79])->count(),
            '80-100' => QuizAttempt::whereBetween('overall_score', [80, 100])->count(),
        ];

        return [
            'subjectLessonCounts' => $subjectLessonCounts,
            'scoreBands' => $scoreBands,
        ];
    }
}
