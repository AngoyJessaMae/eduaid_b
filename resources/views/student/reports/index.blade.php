@extends('layouts.app')

@section('title', 'My Reports')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">📈 My Reports</h1>
            <p class="text-gray-600">See your diagnostic and quiz performance in one place</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('student.reports.print') }}" target="_blank" class="btn-muted">Print Report</a>
            <a href="{{ route('student.reports.download') }}" class="btn-primary">Download CSV</a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="kpi-card"><p class="text-sm text-gray-500">Lessons Completed</p><p class="text-3xl font-bold text-primary-700">{{ $lessonCompletedCount }}</p></div>
        <div class="kpi-card"><p class="text-sm text-gray-500">Quiz Attempts</p><p class="text-3xl font-bold text-secondary-600">{{ $quizAttempts->count() }}</p></div>
        <div class="kpi-card"><p class="text-sm text-gray-500">Average Quiz Score</p><p class="text-3xl font-bold text-accent-700">{{ $averageQuizScore }}%</p></div>
        <div class="kpi-card"><p class="text-sm text-gray-500">Latest Pretest</p><p class="text-3xl font-bold text-highlight-600">{{ $pretestAttempt?->overall_score ?? 0 }}%</p></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="panel p-6">
            <h2 class="text-xl font-bold mb-4">Diagnostic Levels</h2>
            @if($pretestAttempt)
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span>Math</span><span class="font-semibold">{{ $pretestAttempt->math_level }}</span></div>
                    <div class="flex justify-between"><span>Science</span><span class="font-semibold">{{ $pretestAttempt->science_level }}</span></div>
                    <div class="flex justify-between"><span>English</span><span class="font-semibold">{{ $pretestAttempt->english_level }}</span></div>
                </div>
            @else
                <p class="text-gray-600">No pretest data yet.</p>
            @endif
        </div>

        <div class="panel p-6">
            <h2 class="text-xl font-bold mb-4">Recent Quiz Attempts</h2>
            <div class="space-y-2 max-h-72 overflow-y-auto">
                @forelse($quizAttempts as $attempt)
                    <div class="border rounded-lg p-3 flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-gray-900">{{ $attempt->quiz->title }}</p>
                            <p class="text-xs text-gray-500">{{ $attempt->quiz->lesson->subject->name }}</p>
                        </div>
                        <span class="font-bold text-primary-700">{{ $attempt->overall_score }}%</span>
                    </div>
                @empty
                    <p class="text-gray-600">No attempts yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
