@extends('layouts.app')

@section('title', 'Lesson Details')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('admin.lessons.index') }}" class="text-primary-600 hover:underline text-sm">&larr; Back to Lessons</a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $lesson->title }}</h1>
            <p class="text-gray-600">{{ $lesson->subject->name }} • {{ $lesson->difficulty_level }}</p>
        </div>
        <a href="{{ route('admin.lessons.edit', $lesson) }}" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-4 py-2 rounded-lg">Edit Lesson</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Quizzes</p>
            <p class="text-3xl font-bold text-primary-700">{{ $lesson->quizzes->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Status</p>
            <p class="text-lg font-semibold {{ $lesson->is_active ? 'text-green-700' : 'text-gray-600' }}">{{ $lesson->is_active ? 'Active' : 'Inactive' }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Curriculum Tag</p>
            <p class="text-lg font-semibold text-gray-800">{{ $lesson->curriculum_tag ?: 'N/A' }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h2 class="text-xl font-bold mb-3">Lesson Content</h2>
        <div class="prose max-w-none text-gray-700">{!! nl2br(e($lesson->content_text)) !!}</div>

        @if($lesson->material_path)
            <div class="mt-6 pt-4 border-t border-gray-100">
                <h3 class="text-sm font-bold text-gray-900 mb-2">Curriculum Material</h3>
                <a href="{{ asset('storage/' . $lesson->material_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 rounded-lg bg-primary-600 text-white font-semibold hover:bg-primary-700">
                    Download {{ $lesson->material_name ?? 'material' }}
                </a>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold">Quizzes in This Lesson</h2>
            <a href="{{ route('admin.quizzes.create') }}" class="text-primary-600 hover:underline font-semibold">Create Quiz</a>
        </div>
        @if($lesson->quizzes->count())
            <div class="space-y-2">
                @foreach($lesson->quizzes as $quiz)
                    <div class="border rounded-lg p-3 flex items-center justify-between">
                        <span class="font-semibold text-gray-900">{{ $quiz->title }}</span>
                        <a href="{{ route('admin.questions.quiz.index', $quiz) }}" class="text-primary-600 hover:underline">Manage Questions</a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">No quizzes yet for this lesson.</p>
        @endif
    </div>
</div>
@endsection
