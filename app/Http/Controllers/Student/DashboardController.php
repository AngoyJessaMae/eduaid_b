<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LessonProgress;
use App\Models\PretestAttempt;
use App\Models\QuizAttempt;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the student dashboard with analytics.
     */
    public function index()
    {
        $user = auth()->user();

        // Get pretest attempt data
        $pretestAttempt = PretestAttempt::latestForUser($user->id);
        $pretestCompleted = $pretestAttempt !== null;

        // Get overall stats
        $lessonsCompleted = LessonProgress::where('user_id', $user->id)
            ->where('completed', true)
            ->count();

        $totalLessons = \App\Models\Lesson::where('is_active', true)->count();

        $quizzesCompleted = QuizAttempt::where('user_id', $user->id)->count();

        // Get recent quiz attempts
        $recentQuizzes = QuizAttempt::where('user_id', $user->id)
            ->with('quiz.lesson')
            ->latest()
            ->limit(5)
            ->get();

        // Performance trends for the last 7 days
        $trendMap = QuizAttempt::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as date, AVG(overall_score) as avg_score')
            ->groupBy('date')
            ->pluck('avg_score', 'date');

        $trendLabels = [];
        $trendScores = [];

        foreach (range(6, 0) as $dayOffset) {
            $date = Carbon::today()->subDays($dayOffset);
            $key = $date->toDateString();
            $trendLabels[] = $date->format('D');
            $trendScores[] = (int) round($trendMap[$key] ?? 0);
        }

        // Weekly streak based on lesson completion days
        $completedDays = LessonProgress::where('user_id', $user->id)
            ->where('completed', true)
            ->whereNotNull('completed_at')
            ->orderByDesc('completed_at')
            ->get()
            ->map(fn ($item) => Carbon::parse($item->completed_at)->toDateString())
            ->unique()
            ->values();

        $streak = 0;
        $cursor = Carbon::today();
        while ($completedDays->contains($cursor->toDateString())) {
            $streak++;
            $cursor->subDay();
        }

        if ($streak >= 5) {
            $streakRecommendation = 'Excellent consistency. Keep your streak alive by completing at least one quiz today.';
        } elseif ($streak >= 2) {
            $streakRecommendation = 'Great momentum. Complete one short lesson today to grow your weekly streak.';
        } else {
            $streakRecommendation = 'Start a new streak by finishing one lesson and one quiz this week.';
        }

        // Get learning progress by subject
        $subjectProgress = \DB::table('subjects')
            ->leftJoin('lessons', 'subjects.id', '=', 'lessons.subject_id')
            ->leftJoin('lesson_progress', 'lessons.id', '=', 'lesson_progress.lesson_id')
            ->where('lesson_progress.user_id', $user->id)
            ->groupBy('subjects.id', 'subjects.name')
            ->select(
                'subjects.id',
                'subjects.name',
                \DB::raw('COUNT(DISTINCT lessons.id) as total_lessons'),
                \DB::raw('COUNT(DISTINCT CASE WHEN lesson_progress.completed = 1 THEN lessons.id END) as completed_lessons')
            )
            ->get();

        return view('student.dashboard', [
            'user' => $user,
            'pretestCompleted' => $pretestCompleted,
            'pretestAttempt' => $pretestAttempt,
            'lessonsCompleted' => $lessonsCompleted,
            'totalLessons' => $totalLessons,
            'quizzesCompleted' => $quizzesCompleted,
            'recentQuizzes' => $recentQuizzes,
            'subjectProgress' => $subjectProgress,
            'trendLabels' => $trendLabels,
            'trendScores' => $trendScores,
            'weeklyStreakDays' => $streak,
            'streakRecommendation' => $streakRecommendation,
            'completionPercentage' => $totalLessons > 0 ? round(($lessonsCompleted / $totalLessons) * 100) : 0,
        ]);
    }
}
