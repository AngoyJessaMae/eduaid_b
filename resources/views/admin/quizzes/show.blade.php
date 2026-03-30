@extends('layouts.app')

@section('title', 'Quiz Details')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('admin.quizzes.index') }}" class="text-primary-600 hover:underline text-sm">&larr; Back to Quizzes</a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $quiz->title }}</h1>
            <p class="text-gray-600">{{ $quiz->lesson->subject->name }} • {{ $quiz->lesson->title }}</p>
        </div>
        <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-4 py-2 rounded-lg">Edit Quiz</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Questions</p>
            <p class="text-3xl font-bold text-primary-700">{{ $quiz->questions->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Attempts</p>
            <p class="text-3xl font-bold text-secondary-600">{{ $quiz->attempts->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Status</p>
            <p class="text-lg font-semibold {{ $quiz->is_active ? 'text-green-700' : 'text-gray-600' }}">{{ $quiz->is_active ? 'Active' : 'Inactive' }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Question Bank</h2>
            <a href="{{ route('admin.questions.quiz.create', $quiz) }}" class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg font-semibold">Add Question</a>
        </div>
        @if($quiz->questions->count())
            <div class="space-y-2">
                @foreach($quiz->questions as $question)
                    <div class="border rounded-lg p-4">
                        <p class="font-semibold text-gray-900">{{ $question->question }}</p>
                        <p class="text-xs text-gray-500 mt-1">Difficulty Weight: {{ $question->difficulty_weight }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">No questions added yet.</p>
        @endif
    </div>
</div>
@endsection
