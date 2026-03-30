@extends('layouts.app')

@section('title', isset($lesson) ? 'Edit Lesson' : 'Create Lesson')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">
        {{ isset($lesson) ? '✏️ Edit Lesson' : 'Create Lesson' }}
    </h1>

    <div class="bg-white rounded-lg shadow p-8">
        <form method="POST" action="{{ isset($lesson) ? route('admin.lessons.update', $lesson) : route('admin.lessons.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($lesson))
                @method('PUT')
            @endif

            <!-- Subject Selection -->
            <div class="mb-6">
                <label for="subject_id" class="block text-sm font-bold text-gray-900 mb-2">
                    Subject <span class="text-red-500">*</span>
                </label>
                <select 
                    id="subject_id" 
                    name="subject_id"
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('subject_id') border-red-500 @enderror"
                    required
                >
                    <option value="">Select a subject</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}" {{ old('subject_id', $lesson->subject_id ?? '') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
                @error('subject_id')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-bold text-gray-900 mb-2">
                    Title <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title"
                    value="{{ old('title', $lesson->title ?? '') }}"
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('title') border-red-500 @enderror"
                    placeholder="e.g., Introduction to Algebra"
                    required
                >
                @error('title')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div class="mb-6">
                <label for="content_text" class="block text-sm font-bold text-gray-900 mb-2">
                    Content <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="content_text" 
                    name="content_text"
                    rows="8"
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('content_text') border-red-500 @enderror"
                    placeholder="Enter lesson content here..."
                    required
                >{{ old('content_text', $lesson->content_text ?? '') }}</textarea>
                @error('content_text')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Video URL (optional) -->
            <div class="mb-6">
                <label for="video_url" class="block text-sm font-bold text-gray-900 mb-2">
                    Video URL (optional)
                </label>
                <input 
                    type="url" 
                    id="video_url" 
                    name="video_url"
                    value="{{ old('video_url', $lesson->video_url ?? '') }}"
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('video_url') border-red-500 @enderror"
                    placeholder="https://youtu.be/... or https://..."
                >
                @error('video_url')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-600 mt-1">Supports YouTube, Vimeo, or direct video links</p>
            </div>

            <!-- Curriculum Material Upload -->
            <div class="mb-6">
                <label for="material_file" class="block text-sm font-bold text-gray-900 mb-2">
                    Upload Curriculum Material
                </label>
                <input
                    type="file"
                    id="material_file"
                    name="material_file"
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('material_file') border-red-500 @enderror"
                    accept=".pdf,.doc,.docx,.ppt,.pptx,.zip"
                >
                @error('material_file')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
                <p class="text-xs text-gray-600 mt-1">Accepted: PDF, DOC, DOCX, PPT, PPTX, ZIP (max 15 MB)</p>

                @if(isset($lesson) && $lesson->material_path)
                    <div class="mt-3 p-3 bg-primary-50 border border-primary-100 rounded-lg">
                        <p class="text-sm text-gray-700">Current file: <span class="font-semibold">{{ $lesson->material_name ?? basename($lesson->material_path) }}</span></p>
                        <label class="mt-2 inline-flex items-center gap-2 text-sm text-red-700 cursor-pointer">
                            <input type="checkbox" name="remove_material" value="1" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                            Remove current material
                        </label>
                    </div>
                @endif
            </div>

            <!-- Difficulty Level -->
            <div class="mb-6">
                <label for="difficulty_level" class="block text-sm font-bold text-gray-900 mb-2">
                    Difficulty Level <span class="text-red-500">*</span>
                </label>
                <select 
                    id="difficulty_level" 
                    name="difficulty_level"
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('difficulty_level') border-red-500 @enderror"
                    required
                >
                    <option value="">Select difficulty</option>
                    <option value="Beginner" {{ old('difficulty_level', $lesson->difficulty_level ?? '') == 'Beginner' ? 'selected' : '' }}>
                        🟢 Beginner
                    </option>
                    <option value="Intermediate" {{ old('difficulty_level', $lesson->difficulty_level ?? '') == 'Intermediate' ? 'selected' : '' }}>
                        🟡 Intermediate
                    </option>
                    <option value="Advanced" {{ old('difficulty_level', $lesson->difficulty_level ?? '') == 'Advanced' ? 'selected' : '' }}>
                        🔴 Advanced
                    </option>
                </select>
                @error('difficulty_level')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Curriculum Tag (optional) -->
            <div class="mb-6">
                <label for="curriculum_tag" class="block text-sm font-bold text-gray-900 mb-2">
                    Curriculum Tag (optional)
                </label>
                <input 
                    type="text" 
                    id="curriculum_tag" 
                    name="curriculum_tag"
                    value="{{ old('curriculum_tag', $lesson->curriculum_tag ?? '') }}"
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none"
                    placeholder="e.g., Grade 8, Chapter 5"
                >
            </div>

            <!-- Active Status -->
            <div class="mb-6">
                <label for="is_active" class="flex items-center gap-3 cursor-pointer">
                    <input 
                        type="checkbox" 
                        id="is_active" 
                        name="is_active"
                        value="1"
                        {{ old('is_active', $lesson->is_active ?? true) ? 'checked' : '' }}
                        class="w-4 h-4 text-primary-500 rounded focus:ring-2 focus:ring-primary-500"
                    >
                    <span class="text-sm font-semibold text-gray-900">Make this lesson active and visible to students</span>
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-primary-500 to-primary-700 text-white font-bold py-3 rounded-lg hover:shadow-lg transition">
                    {{ isset($lesson) ? 'Update Lesson' : 'Create Lesson' }}
                </button>
                <a href="{{ route('admin.lessons.index') }}" class="flex-1 bg-gray-200 text-gray-900 font-bold py-3 rounded-lg hover:bg-gray-300 transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
