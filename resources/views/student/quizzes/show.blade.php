@extends('layouts.app')

@section('title', $quiz->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('student.quizzes.index') }}" class="text-primary-600 hover:underline text-sm">&larr; Back to Quizzes</a>
        <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $quiz->title }}</h1>
        <p class="text-gray-600">{{ $quiz->lesson->subject->name }} • {{ $quiz->lesson->title }}</p>
    </div>

    <form method="POST" action="{{ route('student.quizzes.submit', $quiz) }}" class="space-y-5">
        @csrf

        @foreach($quiz->questions as $index => $question)
            <div class="bg-white rounded-lg shadow p-5">
                <h2 class="font-semibold text-gray-900 mb-3">{{ $index + 1 }}. {{ $question->question }}</h2>
                @foreach($question->choices as $choice)
                    <label class="flex items-center gap-3 p-3 border rounded-lg mb-2 hover:bg-primary-50 cursor-pointer">
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $choice }}" required>
                        <span>{{ $choice }}</span>
                    </label>
                @endforeach
            </div>
        @endforeach

        <button type="submit" class="w-full bg-gradient-to-r from-primary-600 to-accent-600 text-white font-bold py-3 rounded-lg hover:shadow-lg transition">
            Submit Quiz
        </button>
    </form>
</div>
@endsection
