@extends('layouts.app')

@section('title', 'Take Pretest - ' . $subject->name)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('student.pretest.index') }}" class="text-primary-500 hover:underline mb-4 inline-block">&larr; Back to Pretest</a>
        <h1 class="text-3xl font-bold text-gray-900">{{ $subject->name }} Pretest</h1>
        <p class="text-gray-600">{{ $questions->count() }} questions • Answer as honestly as you can</p>
    </div>

    <!-- Progress Bar -->
    <div class="bg-white rounded-lg shadow p-4 mb-8">
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm font-semibold text-gray-700">Progress</span>
            <span class="text-sm font-semibold text-gray-700" id="progress-text">0/{{ $questions->count() }}</span>
        </div>
        <div class="bg-gray-200 rounded-full h-3">
            <div class="bg-primary-500 h-3 rounded-full transition-all duration-300" id="progress-bar" style="width: 0%"></div>
        </div>
    </div>

    <!-- Questions Form -->
    <form method="POST" action="{{ route('student.pretest.submit', $subject) }}" class="space-y-6">
        @csrf

        @foreach($questions as $index => $question)
            <div class="bg-white rounded-lg shadow p-6 question-card" data-question="{{ $index + 1 }}">
                <!-- Question Header -->
                <div class="flex items-start gap-4 mb-4">
                    <div class="bg-primary-500 text-white rounded-full w-8 h-8 flex items-center justify-center flex-shrink-0 font-bold">
                        {{ $index + 1 }}
                    </div>
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900">{{ $question->question }}</h3>
                        @if($question->difficulty_weight)
                            <p class="text-xs text-gray-600 mt-2">
                                Difficulty: 
                                <span class="px-2 py-1 rounded 
                                    @if($question->difficulty_weight >= 0.7)
                                        bg-red-100 text-red-800
                                    @elseif($question->difficulty_weight >= 0.4)
                                        bg-yellow-100 text-yellow-800
                                    @else
                                        bg-green-100 text-green-800
                                    @endif
                                ">
                                    {{ $question->difficulty_weight >= 0.7 ? 'Hard' : ($question->difficulty_weight >= 0.4 ? 'Medium' : 'Easy') }}
                                </span>
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Answer Options -->
                <div class="space-y-3 ml-12">
                    @php
                        $choices = is_array($question->choices) ? $question->choices : json_decode($question->choices, true);
                    @endphp

                    @foreach($choices as $choiceIndex => $choice)
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 question-option" data-choice="{{ $choiceIndex }}">
                            <input 
                                type="radio" 
                                name="answers[{{ $question->id }}]" 
                                value="{{ $choice }}"
                                class="w-4 h-4 text-primary-500 cursor-pointer answer-radio"
                                onchange="updateProgress()"
                            >
                            <span class="ml-4 flex-1 font-medium text-gray-900">{{ $choice }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Submit Button -->
        <div class="bg-white rounded-lg shadow p-6 flex gap-4">
            <a href="{{ route('student.pretest.index') }}" class="flex-1 bg-gray-200 text-gray-900 font-bold py-3 rounded-lg hover:bg-gray-300 transition text-center">
                Cancel
            </a>
            <button type="submit" class="flex-1 bg-gradient-to-r from-primary-500 to-primary-700 text-white font-bold py-3 rounded-lg hover:shadow-lg transition">
                ✓ Submit Pretest
            </button>
        </div>
    </form>
</div>

<script>
function updateProgress() {
    const totalQuestions = {{ $questions->count() }};
    const answered = document.querySelectorAll('.answer-radio:checked').length;
    
    document.getElementById('progress-text').textContent = `${answered}/${totalQuestions}`;
    document.getElementById('progress-bar').style.width = `${(answered / totalQuestions) * 100}%`;
    
    // Update question card styling when answered
    document.querySelectorAll('.question-card').forEach((card, index) => {
        const questions = document.querySelectorAll('.answer-radio');
        if(questions[index] && questions[index].checked) {
            card.classList.add('border-l-4', 'border-l-primary-500');
        } else {
            card.classList.remove('border-l-4', 'border-l-primary-500');
        }
    });
}

// Initialize progress on page load
document.addEventListener('DOMContentLoaded', updateProgress);
</script>
@endsection
