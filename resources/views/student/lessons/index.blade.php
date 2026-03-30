@extends('layouts.app')

@section('title', 'Lessons')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">📚 Lessons</h1>

    <!-- Filter by Subject -->
    <div class="mb-8">
        <form method="GET" class="flex gap-2 flex-wrap">
            <a href="{{ route('student.lessons.index') }}" class="px-4 py-2 rounded-lg {{ !request('subject') ? 'bg-primary-500 text-white' : 'bg-gray-200 text-gray-900' }} hover:shadow transition">
                All Subjects
            </a>
            @foreach($subjects as $subject)
                <a href="{{ route('student.lessons.index', ['subject' => $subject->id]) }}" class="px-4 py-2 rounded-lg {{ request('subject') == $subject->id ? 'bg-primary-500 text-white' : 'bg-gray-200 text-gray-900' }} hover:shadow transition">
                    {{ $subject->name }}
                </a>
            @endforeach
        </form>
    </div>

    <!-- Lessons Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($lessons as $lesson)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                <!-- Lesson Header -->
                <div class="bg-gradient-to-r from-primary-500 to-primary-700 text-white p-4">
                    <p class="text-xs font-semibold mb-1">{{ $lesson->subject->name }}</p>
                    <h3 class="text-lg font-bold">{{ $lesson->title }}</h3>
                </div>

                <!-- Lesson Content -->
                <div class="p-4">
                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($lesson->content_text, 100) }}</p>

                    <!-- Difficulty Badge -->
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs font-semibold px-2 py-1 rounded
                            @if($lesson->difficulty_level === 'Beginner')
                                bg-green-100 text-green-800
                            @elseif($lesson->difficulty_level === 'Intermediate')
                                bg-yellow-100 text-yellow-800
                            @else
                                bg-red-100 text-red-800
                            @endif
                        ">
                            {{ $lesson->difficulty_level }}
                        </span>
                    </div>

                    <!-- Progress Stats -->
                    <div class="bg-gray-50 rounded p-3 mb-4 text-sm">
                        @php
                            $progress = $lesson->studentProgress->first();
                            $isCompleted = $progress?->completed ?? false;
                            $quizScore = $progress?->quiz_score ?? null;
                        @endphp
                        
                        @if($isCompleted)
                            <p class="text-green-600 font-semibold">✓ Completed</p>
                            @if($quizScore)
                                <p class="text-gray-600">Quiz Score: {{ $quizScore }}%</p>
                            @endif
                        @else
                            <p class="text-gray-600">Not started</p>
                        @endif
                    </div>

                    <!-- Action Button -->
                    <a href="{{ route('student.lessons.show', $lesson) }}" class="block w-full bg-primary-500 text-white text-center py-2 rounded-lg font-semibold hover:bg-primary-700 transition">
                        {{ $isCompleted ? 'Review Lesson' : 'Start Lesson' }}
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-gray-50 rounded-lg p-12 text-center">
                <p class="text-gray-600 mb-4">No lessons available yet.</p>
                <a href="{{ route('student.dashboard') }}" class="text-primary-500 hover:underline">Return to Dashboard</a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($lessons->hasPages())
        <div class="mt-8">
            {{ $lessons->links() }}
        </div>
    @endif
</div>
@endsection
