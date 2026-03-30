@extends('layouts.app')

@section('title', 'Quizzes')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">📝 Quizzes</h1>
    <p class="text-gray-600 mb-8">Practice what you learned and track your progress</p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($quizzes as $quiz)
            @php($attempt = $latestAttempts[$quiz->id] ?? null)
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                <div class="bg-gradient-to-r from-primary-500 to-accent-600 text-white p-4">
                    <p class="text-xs opacity-90">{{ $quiz->lesson->subject->name }}</p>
                    <h2 class="text-lg font-bold">{{ $quiz->title }}</h2>
                    <p class="text-xs mt-1">{{ $quiz->lesson->title }}</p>
                </div>
                <div class="p-4">
                    <p class="text-sm text-gray-600 mb-3">{{ $quiz->questions->count() }} questions</p>
                    @if($attempt)
                        <div class="bg-primary-50 border border-primary-100 rounded p-3 mb-4">
                            <p class="text-xs text-gray-600">Latest Score</p>
                            <p class="text-2xl font-bold text-primary-700">{{ $attempt->overall_score }}%</p>
                        </div>
                    @endif
                    <a href="{{ route('student.quizzes.show', $quiz) }}" class="block text-center bg-primary-600 hover:bg-primary-700 text-white py-2 rounded-lg font-semibold">
                        {{ $attempt ? 'Retake Quiz' : 'Start Quiz' }}
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-lg shadow p-8 text-center text-gray-600">No quizzes are available yet.</div>
        @endforelse
    </div>
</div>
@endsection
