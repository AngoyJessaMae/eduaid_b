@extends('layouts.app')

@section('title', 'Admin Analytics')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">📊 Analytics & Content Management</h1>
            <p class="text-gray-600 mt-1">Track learner outcomes and content usage trends</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="text-primary-600 hover:underline font-semibold">Back to Dashboard</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="kpi-card"><p class="text-sm text-gray-500">Students</p><p class="text-3xl font-bold text-primary-700">{{ $stats['total_students'] }}</p></div>
        <div class="kpi-card"><p class="text-sm text-gray-500">Pretest Attempts</p><p class="text-3xl font-bold text-secondary-600">{{ $stats['pretest_attempts'] }}</p></div>
        <div class="kpi-card"><p class="text-sm text-gray-500">Quiz Attempts</p><p class="text-3xl font-bold text-accent-600">{{ $stats['quiz_attempts'] }}</p></div>
        <div class="kpi-card"><p class="text-sm text-gray-500">Active Content</p><p class="text-3xl font-bold text-highlight-600">{{ $stats['active_lessons'] }} Lessons</p></div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="panel p-6">
            <h2 class="text-xl font-bold mb-4">Score Distribution</h2>
            <div class="space-y-3">
                @foreach($chartData['scoreBands'] as $band => $count)
                    <div>
                        <div class="flex justify-between mb-1 text-sm"><span>{{ $band }}</span><span>{{ $count }}</span></div>
                        <div class="h-2 bg-gray-200 rounded-full"><div class="h-2 bg-primary-500 rounded-full" style="width: {{ max(8, min(100, $count * 10)) }}%"></div></div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="panel p-6">
            <h2 class="text-xl font-bold mb-4">Lessons by Subject</h2>
            <div class="space-y-3">
                @foreach($chartData['subjectLessonCounts'] as $item)
                    <div class="flex items-center justify-between border-b pb-2">
                        <span class="font-medium text-gray-800">{{ $item['label'] }}</span>
                        <span class="text-primary-700 font-bold">{{ $item['value'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="panel p-6">
            <h2 class="text-xl font-bold mb-4">Top Lessons by Engagement</h2>
            <div class="space-y-2">
                @forelse($topLessons as $lesson)
                    <div class="flex items-center justify-between border rounded p-3">
                        <span class="font-medium">{{ $lesson->title }}</span>
                        <span class="text-sm text-gray-600">{{ $lesson->student_progress_count }} interactions</span>
                    </div>
                @empty
                    <p class="text-gray-600">No lesson interaction data yet.</p>
                @endforelse
            </div>
        </div>

        <div class="panel p-6">
            <h2 class="text-xl font-bold mb-4">Top Quizzes by Attempts</h2>
            <div class="space-y-2">
                @forelse($topQuizzes as $quiz)
                    <div class="flex items-center justify-between border rounded p-3">
                        <span class="font-medium">{{ $quiz->title }}</span>
                        <span class="text-sm text-gray-600">{{ $quiz->attempts_count }} attempts</span>
                    </div>
                @empty
                    <p class="text-gray-600">No quiz attempt data yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
