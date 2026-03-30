@extends('layouts.app')

@section('title', isset($question) ? 'Edit Pretest Question' : 'Create Pretest Question')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">
        {{ isset($question) ? '✏️ Edit Question' : 'Create Pretest Question' }}
    </h1>

    <div class="bg-white rounded-lg shadow p-8">
        <form method="POST" action="{{ isset($question) ? route('admin.questions.pretest.update', $question) : route('admin.questions.pretest.store') }}">
            @csrf
            @if(isset($question))
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
                        <option value="{{ $subject->id }}" {{ old('subject_id', $question->subject_id ?? '') == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
                @error('subject_id')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Question -->
            <div class="mb-6">
                <label for="question" class="block text-sm font-bold text-gray-900 mb-2">
                    Question <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="question" 
                    name="question"
                    rows="3"
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('question') border-red-500 @enderror"
                    placeholder="Enter the question text"
                    required
                >{{ old('question', $question->question ?? '') }}</textarea>
                @error('question')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Answer Choices -->
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-900 mb-3">
                    Answer Choices <span class="text-red-500">*</span>
                </label>
                @php
                    $choices = isset($question) ? (is_array($question->choices) ? $question->choices : json_decode($question->choices, true)) : ['', '', '', ''];
                @endphp
                
                <div id="choices-container" class="space-y-3">
                    @foreach($choices as $index => $choice)
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                name="choices[]"
                                value="{{ $choice }}"
                                class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none"
                                placeholder="Choice {{ $index + 1 }}"
                            >
                            <button type="button" onclick="removeChoice(this)" class="px-3 py-2 bg-red-100 text-red-800 rounded hover:bg-red-200" style="display: {{ count($choices) <= 2 ? 'none' : 'block' }}">
                                ✕
                            </button>
                        </div>
                    @endforeach
                </div>
                <button type="button" onclick="addChoice()" class="mt-3 px-4 py-2 bg-gray-200 text-gray-900 rounded hover:bg-gray-300 text-sm font-semibold">
                    + Add Choice
                </button>
                @error('choices')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Correct Answer -->
            <div class="mb-6">
                <label for="correct_answer" class="block text-sm font-bold text-gray-900 mb-2">
                    Correct Answer <span class="text-red-500">*</span>
                </label>
                <select 
                    id="correct_answer" 
                    name="correct_answer"
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('correct_answer') border-red-500 @enderror"
                    required
                >
                    <option value="">Select correct answer</option>
                    @foreach($choices as $index => $choice)
                        @if($choice)
                            <option value="{{ $choice }}" {{ old('correct_answer', $question->correct_answer ?? '') == $choice ? 'selected' : '' }}>
                                {{ $choice }}
                            </option>
                        @endif
                    @endforeach
                </select>
                @error('correct_answer')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Difficulty Weight -->
            <div class="mb-6">
                <label for="difficulty_weight" class="block text-sm font-bold text-gray-900 mb-2">
                    Difficulty Weight <span class="text-red-500">*</span>
                </label>
                <select 
                    id="difficulty_weight" 
                    name="difficulty_weight"
                    class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none"
                    required
                >
                    <option value="1" {{ old('difficulty_weight', $question->difficulty_weight ?? '') == 1 ? 'selected' : '' }}>
                        🟢 Easy (1)
                    </option>
                    <option value="3" {{ old('difficulty_weight', $question->difficulty_weight ?? '') == 3 ? 'selected' : '' }}>
                        🟡 Medium (3)
                    </option>
                    <option value="5" {{ old('difficulty_weight', $question->difficulty_weight ?? '') == 5 ? 'selected' : '' }}>
                        🔴 Hard (5)
                    </option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-primary-500 to-primary-700 text-white font-bold py-3 rounded-lg hover:shadow-lg transition">
                    {{ isset($question) ? 'Update Question' : 'Create Question' }}
                </button>
                <a href="{{ route('admin.questions.pretest.index') }}" class="flex-1 bg-gray-200 text-gray-900 font-bold py-3 rounded-lg hover:bg-gray-300 transition text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <script>
        function addChoice() {
            const container = document.getElementById('choices-container');
            const choice = document.createElement('div');
            choice.className = 'flex gap-2';
            choice.innerHTML = `
                <input 
                    type="text" 
                    name="choices[]"
                    class="flex-1 px-4 py-2 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none"
                    placeholder="New choice"
                >
                <button type="button" onclick="removeChoice(this)" class="px-3 py-2 bg-red-100 text-red-800 rounded hover:bg-red-200">
                    ✕
                </button>
            `;
            container.appendChild(choice);
            updateCorrectAnswerOptions();
        }

        function removeChoice(button) {
            button.parentElement.remove();
            updateCorrectAnswerOptions();
        }

        function updateCorrectAnswerOptions() {
            const choices = document.querySelectorAll('input[name="choices[]"]');
            const select = document.getElementById('correct_answer');
            const currentValue = select.value;
            select.innerHTML = '<option value="">Select correct answer</option>';
            
            choices.forEach(choice => {
                if(choice.value) {
                    const option = document.createElement('option');
                    option.value = choice.value;
                    option.textContent = choice.value;
                    if(choice.value === currentValue) option.selected = true;
                    select.appendChild(option);
                }
            });
        }

        // Update correct answer options when choices change
        document.addEventListener('change', function(e) {
            if(e.target.name === 'choices[]') {
                updateCorrectAnswerOptions();
            }
        });
    </script>
@endsection
