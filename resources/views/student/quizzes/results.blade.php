@extends('layouts.app')

@section('title', 'Quiz Results')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="bg-gradient-to-r from-primary-600 to-accent-600 text-white rounded-xl p-6 mb-8">
        <h1 class="text-3xl font-bold">Quiz Results: {{ $quiz->title }}</h1>
        <p class="mt-2 text-primary-100">You got {{ $correct }} out of {{ $total }} questions correct.</p>
        <p class="text-5xl font-extrabold mt-4">{{ $score }}%</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6 mb-8">
        <h2 class="text-xl font-bold mb-4">Detailed Feedback</h2>
        <div class="space-y-4">
            @foreach($feedback as $index => $item)
                <div class="border rounded-lg p-4 {{ $item['is_correct'] ? 'border-green-200 bg-green-50' : 'border-red-200 bg-red-50' }}">
                    <p class="font-semibold text-gray-900 mb-2">{{ $index + 1 }}. {{ $item['question'] }}</p>
                    <p class="text-sm">Your answer: <span class="font-semibold">{{ $item['selected_answer'] ?? 'No answer' }}</span></p>
                    @if(!$item['is_correct'])
                        <p class="text-sm mt-1">Correct answer: <span class="font-semibold">{{ $item['correct_answer'] }}</span></p>
                    @endif
                    <span class="inline-block mt-2 px-3 py-1 rounded-full text-xs font-bold {{ $item['is_correct'] ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                        {{ $item['is_correct'] ? 'Correct' : 'Needs review' }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="{{ route('student.quizzes.index') }}" class="btn-muted text-center">Back to Quizzes</a>
        <a href="{{ route('student.tutor.index', ['lesson_id' => $quiz->lesson_id]) }}" class="btn-primary text-center">Ask AI Tutor About This Lesson</a>
    </div>
</div>
@endsection
