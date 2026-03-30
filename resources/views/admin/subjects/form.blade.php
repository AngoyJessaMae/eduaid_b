@extends('layouts.app')

@section('title', isset($subject) ? 'Edit Subject' : 'Create Subject')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">
        {{ isset($subject) ? '✏️ Edit Subject' : '📚 Create Subject' }}
    </h1>

    <div class="bg-white rounded-lg shadow p-8">
        <form method="POST" action="{{ isset($subject) ? route('admin.subjects.update', $subject) : route('admin.subjects.store') }}">
            @csrf
            @if(isset($subject))
                @method('PUT')
            @endif

            <!-- Subject Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-bold text-gray-900 mb-2">
                    Subject Name <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name"
                    value="{{ old('name', $subject->name ?? '') }}"
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('name') border-red-500 @enderror"
                    placeholder="e.g., Mathematics"
                    required
                >
                @error('name')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description (optional) -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-bold text-gray-900 mb-2">
                    Description
                </label>
                <textarea 
                    id="description" 
                    name="description"
                    rows="4"
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('description') border-red-500 @enderror"
                    placeholder="Brief description of the subject"
                >{{ old('description', $subject->description ?? '') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-primary-500 to-primary-700 text-white font-bold py-3 rounded-lg hover:shadow-lg transition">
                    {{ isset($subject) ? 'Update Subject' : 'Create Subject' }}
                </button>
                <a href="{{ route('admin.subjects.index') }}" class="flex-1 bg-gray-200 text-gray-900 font-bold py-3 rounded-lg hover:bg-gray-300 transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
