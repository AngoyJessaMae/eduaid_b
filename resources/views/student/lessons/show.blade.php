@extends('layouts.app')

@section('title', $lesson->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('student.lessons.index') }}" class="text-primary-500 hover:underline mb-4 inline-block">&larr; Back to Lessons</a>
        <div class="bg-gradient-to-r from-primary-500 to-primary-700 text-white rounded-lg p-8">
            <p class="text-sm font-semibold mb-2">{{ $lesson->subject->name }}</p>
            <h1 class="text-4xl font-bold mb-4">{{ $lesson->title }}</h1>
            <div class="flex gap-4">
                <span class="px-3 py-1 rounded-full text-xs font-semibold
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
        </div>
    </div>

    <!-- Progress Bar -->
    @php
        $isCompleted = $progress?->completed ?? false;
    @endphp
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-900">Your Progress</h3>
            <span class="text-sm font-semibold px-3 py-1 rounded-full
                {{ $isCompleted ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}
            ">
                {{ $isCompleted ? '✓ Completed' : 'In Progress' }}
            </span>
        </div>
        <div class="bg-gray-200 rounded-full h-3">
            <div class="bg-primary-500 h-3 rounded-full" style="width: {{ $isCompleted ? '100' : '50' }}%"></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-3 gap-8">
        <div class="col-span-2">
            <!-- Lesson Text Content -->
            <div class="bg-white rounded-lg shadow p-6 mb-8">
                <h2 class="text-2xl font-bold mb-4">📖 Content</h2>
                <div class="prose prose-sm max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($lesson->content_text)) !!}
                </div>
            </div>

            <!-- Video Section (if available) -->
            @if($lesson->video_url)
                <div class="bg-white rounded-lg shadow p-6 mb-8">
                    <h2 class="text-2xl font-bold mb-4">🎥 Video Tutorial</h2>
                    <div class="relative w-full" style="padding-bottom: 56.25%;">
                        @if(strpos($lesson->video_url, 'youtube.com') !== false || strpos($lesson->video_url, 'youtu.be') !== false)
                            @php
                                $videoId = '';
                                if(preg_match('/youtu\.be\/([^\?]+)/', $lesson->video_url, $match)) {
                                    $videoId = $match[1];
                                } elseif(preg_match('/youtube\.com\/watch\?v=([^\&]+)/', $lesson->video_url, $match)) {
                                    $videoId = $match[1];
                                }
                            @endphp
                            <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allowfullscreen></iframe>
                        @else
                            <video class="absolute top-0 left-0 w-full h-full" controls>
                                <source src="{{ $lesson->video_url }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Quizzes Section -->
            @if($quizzes->count() > 0)
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-2xl font-bold mb-4">✅ Quizzes</h2>
                    <div class="space-y-4">
                        @foreach($quizzes as $quiz)
                            @php
                                $quizAttempt = auth()->user()->quizAttempts()
                                    ->where('quiz_id', $quiz->id)
                                    ->latest()
                                    ->first();
                            @endphp
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-semibold text-gray-900">{{ $quiz->title }}</h3>
                                    @if($quizAttempt)
                                        <span class="text-sm font-bold text-primary-500">
                                            Score: {{ $quizAttempt->overall_score }}%
                                        </span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 mb-3">{{ $quiz->questions_count ?? $quiz->questions->count() }} questions</p>
                                <a href="{{ route('student.quizzes.show', $quiz) }}" class="text-primary-500 font-semibold hover:underline">
                                    {{ $quizAttempt ? 'Retake Quiz' : 'Start Quiz' }} →
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar: Lesson Actions -->
        <div class="col-span-1">
            <div class="bg-white rounded-lg shadow sticky top-24">
                <div class="p-6">
                    <h3 class="font-bold text-lg mb-4">Actions</h3>
                    
                    @if(!$isCompleted)
                        <form method="POST" action="{{ route('student.lessons.complete', $lesson) }}" class="mb-4">
                            @csrf
                            <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-primary-700 text-white py-3 rounded-lg font-bold hover:shadow-lg transition">
                                ✓ Mark as Complete
                            </button>
                        </form>
                    @else
                        <div class="w-full bg-green-100 text-green-800 py-3 rounded-lg font-bold text-center mb-4">
                            ✓ Completed on {{ $progress->completed_at->format('M d, Y') }}
                        </div>
                    @endif

                    <button class="w-full text-center bg-gray-200 text-gray-900 py-3 rounded-lg font-semibold hover:bg-gray-300 transition mb-4">
                        📝 Take Notes
                    </button>

                    <!-- Quick Links -->
                    <div class="border-t pt-4">
                        <p class="text-sm font-semibold text-gray-600 mb-3">Related</p>
                        <div class="space-y-2">
                            <a href="{{ route('student.tutor.index') }}" class="block text-primary-500 hover:underline text-sm">
                                🤖 Ask AI Tutor
                            </a>
                            <a href="{{ route('student.reports.index') }}" class="block text-primary-500 hover:underline text-sm">
                                📈 View My Reports
                            </a>
                            <a href="{{ route('student.lessons.index', ['subject' => $lesson->subject->id]) }}" class="block text-primary-500 hover:underline text-sm">
                                📚 More in {{ $lesson->subject->name }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
