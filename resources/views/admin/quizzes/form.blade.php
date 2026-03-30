@extends('layouts.app')

@section('title', isset($quiz) ? 'Edit Quiz' : 'Create Quiz')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">
        {{ isset($quiz) ? '✏️ Edit Quiz' : 'Create Quiz' }}
    </h1>

    <div class="bg-white rounded-lg shadow p-8">
        <form method="POST" action="{{ isset($quiz) ? route('admin.quizzes.update', $quiz) : route('admin.quizzes.store') }}">
            @csrf
            @if(isset($quiz))
                @method('PUT')
            @endif

            <!-- Lesson Selection -->
            <div class="mb-6">
                <label for="lesson_id" class="block text-sm font-bold text-gray-900 mb-2">
                    Lesson <span class="text-red-500">*</span>
                </label>
                <select 
                    id="lesson_id" 
                    name="lesson_id"
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('lesson_id') border-red-500 @enderror"
                    required
                >
                    <option value="">Select a lesson</option>
                    @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}" {{ old('lesson_id', $quiz->lesson_id ?? '') == $lesson->id ? 'selected' : '' }}>
                            {{ $lesson->subject->name }} - {{ $lesson->title }}
                        </option>
                    @endforeach
                </select>
                @error('lesson_id')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-bold text-gray-900 mb-2">
                    Quiz Title <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title"
                    value="{{ old('title', $quiz->title ?? '') }}"
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('title') border-red-500 @enderror"
                    placeholder="e.g., Chapter 5 Quiz"
                    required
                >
                @error('title')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <label for="is_active" class="flex items-center gap-3 cursor-pointer">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active"
                        value="1"
                        {{ old('is_active', $quiz->is_active ?? true) ? 'checked' : '' }}
                        class="w-4 h-4 text-primary-500 rounded focus:ring-2 focus:ring-primary-500"
                    >
                    <span class="text-sm font-semibold text-gray-900">Make this quiz active and available to students</span>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-primary-500 to-primary-700 text-white font-bold py-3 rounded-lg hover:shadow-lg transition">
                    {{ isset($quiz) ? 'Update Quiz' : 'Create Quiz' }}
                </button>
                <a href="{{ route('admin.quizzes.index') }}" class="flex-1 bg-gray-200 text-gray-900 font-bold py-3 rounded-lg hover:bg-gray-300 transition text-center">
                    Cancel
                </a>
            </div>

            @if(isset($quiz))
                <div class="mt-6 pt-6 border-t">
                    <p class="text-sm text-gray-600 mb-3">Next step: Add questions to this quiz</p>
                    <a href="{{ route('admin.questions.quiz.index', $quiz) }}" class="inline-block bg-purple-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-purple-700 transition">
                        Manage Questions
                    </a>
                </div>
            @endif
        </form>
    </div>
</div>
@endsection
