@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-gray-900 mb-2">Welcome, {{ auth()->user()->name }}! 👋</h1>
    <p class="text-gray-600 mb-8">Your learning journey continues here</p>

    @if(!$pretestCompleted)
        <div class="bg-gradient-to-r from-secondary-500 to-secondary-600 text-white rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold mb-2">Start Your Diagnostic Pretest</h2>
            <p class="mb-4">Take our initial assessment to personalize your learning path</p>
            <a href="{{ route('student.pretest.index') }}" class="inline-block bg-white text-secondary-500 px-6 py-2 rounded-lg font-semibold hover:bg-gray-100 transition">
                Begin Pretest
            </a>
        </div>
    @else
        <div class="bg-blue-50 border border-primary-200 rounded-lg p-6 mb-8">
            <h2 class="text-xl font-bold text-primary-700 mb-2">Your Assessment Results</h2>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Math Level</p>
                    <p class="text-2xl font-bold text-primary-500">{{ $pretestAttempt->math_level ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Science Level</p>
                    <p class="text-2xl font-bold text-primary-500">{{ $pretestAttempt->science_level ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">English Level</p>
                    <p class="text-2xl font-bold text-primary-500">{{ $pretestAttempt->english_level ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Lessons Completed</p>
            <p class="text-4xl font-bold text-primary-500">{{ $lessonsCompleted }}/{{ $totalLessons }}</p>
            <div class="mt-4 bg-gray-200 rounded-full h-2">
                <div class="bg-primary-500 h-2 rounded-full" style="width: {{ $completionPercentage }}%"></div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Quizzes Completed</p>
            <p class="text-4xl font-bold text-secondary-500">{{ $quizzesCompleted }}</p>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <p class="text-gray-600 text-sm mb-2">Learning Level</p>
            <p class="text-2xl font-bold text-primary-700">{{ $user->learning_level ?? 'Not Set' }}</p>
            <p class="text-xs text-gray-600 mt-2">Grade {{ $user->grade_level ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Progress by Subject -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-2xl font-bold mb-4">Progress by Subject</h2>
        <div class="space-y-4">
            @foreach($subjectProgress as $subject)
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <p class="font-semibold text-gray-900">{{ $subject->name }}</p>
                        <p class="text-sm text-gray-600">
                            {{ $subject->completed_lessons }}/{{ $subject->total_lessons }} completed
                        </p>
                    </div>
                    <div class="bg-gray-200 rounded-full h-2">
                        <div class="bg-primary-500 h-2 rounded-full" style="width: {{ $subject->total_lessons > 0 ? round(($subject->completed_lessons / $subject->total_lessons) * 100) : 0 }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Recent Quiz Attempts</h2>
            @if($recentQuizzes->count() > 0)
                <div class="space-y-3">
                    @foreach($recentQuizzes as $attempt)
                        <div class="flex justify-between items-center p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                            <div>
                                <p class="font-semibold">{{ $attempt->quiz->title }}</p>
                                <p class="text-sm text-gray-600">{{ $attempt->quiz->lesson->subject->name }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-primary-500">{{ $attempt->overall_score }}%</p>
                                <p class="text-xs text-gray-600">{{ $attempt->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 mb-4">No quiz attempts yet. Start with the lessons above!</p>
            @endif
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Performance Trend (7 days)</h2>
            <div class="grid grid-cols-7 gap-2 items-end h-40 mb-4">
                @foreach($trendScores as $score)
                    <div class="bg-primary-100 rounded-t-md flex items-end justify-center" style="height: {{ max(10, $score) }}%;">
                        <span class="text-[10px] font-semibold text-primary-700 mb-1">{{ $score }}</span>
                    </div>
                @endforeach
            </div>
            <div class="grid grid-cols-7 gap-2 text-xs text-gray-500 text-center">
                @foreach($trendLabels as $label)
                    <span>{{ $label }}</span>
                @endforeach
            </div>

            <div class="mt-6 p-4 bg-secondary-50 border border-secondary-100 rounded-lg">
                <p class="text-sm text-gray-700"><span class="font-bold">Weekly streak:</span> {{ $weeklyStreakDays }} day(s)</p>
                <p class="text-sm text-gray-700 mt-2">{{ $streakRecommendation }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        <a href="{{ route('student.lessons.index') }}" class="bg-gradient-to-br from-primary-500 to-primary-700 text-white rounded-lg p-6 hover:shadow-lg transition">
            <p class="text-lg font-bold mb-2">📚 Continue Learning</p>
            <p class="text-sm">Access your lessons</p>
        </a>
        <a href="{{ route('student.quizzes.index') }}" class="bg-gradient-to-br from-accent-500 to-accent-700 text-white rounded-lg p-6 hover:shadow-lg transition">
            <p class="text-lg font-bold mb-2">📝 Take Quizzes</p>
            <p class="text-sm">Practice and track your score</p>
        </a>
        <a href="{{ route('student.tutor.index') }}" class="bg-gradient-to-br from-secondary-500 to-secondary-600 text-white rounded-lg p-6 hover:shadow-lg transition">
            <p class="text-lg font-bold mb-2">🤖 AI Tutor</p>
            <p class="text-sm">Get instant help</p>
        </a>
        <a href="{{ route('student.reports.index') }}" class="bg-gradient-to-br from-highlight-500 to-secondary-500 text-white rounded-lg p-6 hover:shadow-lg transition">
            <p class="text-lg font-bold mb-2">📈 Reports</p>
            <p class="text-sm">View your performance insights</p>
        </a>
        <a href="{{ route('profile.edit') }}" class="bg-gradient-to-br from-gray-600 to-gray-700 text-white rounded-lg p-6 hover:shadow-lg transition">
            <p class="text-lg font-bold mb-2">⚙️ Settings</p>
            <p class="text-sm">Manage your profile</p>
        </a>
    </div>
</div>
@endsection
