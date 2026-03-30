@extends('layouts.app')

@section('title', 'Pretest')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">🎯 Diagnostic Pretest</h1>
    <p class="text-gray-600 mb-8">Assess your current knowledge level in each subject</p>

    <!-- Current Status Banner -->
    @php
        $latestAttempt = auth()->user()->pretestAttempts()->latest()->first();
    @endphp

    @if(!$latestAttempt)
        <div class="bg-accent-50 border-l-4 border-accent-500 p-6 mb-8 rounded">
            <h3 class="font-bold text-accent-900 mb-2">📌 New Here?</h3>
            <p class="text-accent-700">Take the pretest in each subject to establish your baseline knowledge. This helps us personalize your learning path!</p>
        </div>
    @else
        <div class="bg-primary-50 border-l-4 border-primary-500 p-6 mb-8 rounded">
            <h3 class="font-bold text-primary-900 mb-2">✓ You've taken the pretest!</h3>
            <p class="text-primary-700">Your latest overall score: <span class="font-bold text-2xl">{{ $latestAttempt->overall_score }}%</span></p>
            <p class="text-sm text-primary-600 mt-2">Taken on {{ $latestAttempt->created_at->format('M d, Y \a\t g:ia') }}</p>
        </div>
    @endif

    <!-- Subjects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($subjects as $subject)
            @php
                $subjectAttempt = auth()->user()->pretestAttempts()
                    ->latest()
                    ->first();
                $subjectScore = null;
                $subjectLevel = null;
                
                if($subjectAttempt) {
                    if($subject->name === 'Math') {
                        $subjectScore = $subjectAttempt->math_score;
                        $subjectLevel = $subjectAttempt->math_level;
                    } elseif($subject->name === 'Science') {
                        $subjectScore = $subjectAttempt->science_score;
                        $subjectLevel = $subjectAttempt->science_level;
                    } elseif($subject->name === 'English') {
                        $subjectScore = $subjectAttempt->english_score;
                        $subjectLevel = $subjectAttempt->english_level;
                    }
                }
            @endphp
            
            <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                <!-- Subject Header -->
                <div class="bg-gradient-to-r from-primary-500 to-primary-700 text-white p-6">
                    <h3 class="text-2xl font-bold">{{ $subject->name }}</h3>
                    <p class="text-sm opacity-90">{{ $subject->pretestQuestions->count() }} questions</p>
                </div>

                <!-- Subject Stats -->
                <div class="p-6">
                    @if($subjectScore !== null)
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-semibold text-gray-700">Latest Score</span>
                                <span class="text-3xl font-bold text-primary-500">{{ $subjectScore }}%</span>
                            </div>
                            <div class="bg-gray-200 rounded-full h-2">
                                <div class="bg-primary-500 h-2 rounded-full" style="width: {{ $subjectScore }}%"></div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded p-3 mb-4">
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold text-gray-900">Level:</span>
                                <span class="px-2 py-1 rounded text-xs font-bold
                                    @if($subjectLevel === 'Advanced')
                                        bg-green-100 text-green-800
                                    @elseif($subjectLevel === 'Intermediate')
                                        bg-yellow-100 text-yellow-800
                                    @else
                                        bg-blue-100 text-blue-800
                                    @endif
                                ">
                                    {{ $subjectLevel }}
                                </span>
                            </p>
                        </div>

                        <a href="{{ route('student.pretest.start', $subject) }}" class="block w-full bg-secondary-500 text-white text-center py-2 rounded-lg font-semibold hover:bg-secondary-600 transition">
                            Retake Test
                        </a>
                    @else
                        <p class="text-gray-600 text-sm mb-4">
                            Take the {{ $subject->name }} pretest to establish your baseline knowledge level.
                        </p>
                        <a href="{{ route('student.pretest.start', $subject) }}" class="block w-full bg-primary-500 text-white text-center py-3 rounded-lg font-bold hover:bg-primary-700 transition">
                            Start {{ $subject->name }} Test
                        </a>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Attempt History -->
    @if($latestAttempt)
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold mb-4">📊 History</h2>
            <div class="space-y-3">
                @php
                    // Group attempts by date
                    $attempts = auth()->user()->pretestAttempts()
                        ->latest()
                        ->take(10)
                        ->get();
                @endphp

                @foreach($attempts as $attempt)
                    <div class="border border-gray-200 rounded p-4 hover:bg-gray-50">
                        <div class="grid grid-cols-4 gap-4">
                            <div>
                                <p class="text-xs text-gray-600">Overall</p>
                                <p class="text-2xl font-bold text-primary-500">{{ $attempt->overall_score }}%</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Math</p>
                                <p class="font-bold text-gray-800">
                                    {{ $attempt->math_score }}% 
                                    <span class="text-xs font-normal ml-1">{{ $attempt->math_level }}</span>
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-600">Science</p>
                                <p class="font-bold text-gray-800">
                                    {{ $attempt->science_score }}% 
                                    <span class="text-xs font-normal ml-1">{{ $attempt->science_level }}</span>
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-600">Date</p>
                                <p class="font-semibold text-gray-800">{{ $attempt->created_at->format('M d') }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
