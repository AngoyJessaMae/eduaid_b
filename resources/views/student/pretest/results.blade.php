@extends('layouts.app')

@section('title', 'Pretest Results')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Success Banner -->
    <div class="bg-gradient-to-r from-primary-500 to-primary-700 text-white rounded-lg p-8 mb-8 text-center">
        <h1 class="text-4xl font-bold mb-2">🎉 Test Complete!</h1>
        <p class="text-lg opacity-90">Your assessment has been saved</p>
    </div>

    <!-- Overall Score -->
    <div class="bg-white rounded-lg shadow p-8 mb-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Your Results</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
            <!-- Overall Score -->
            <div class="bg-gradient-to-b from-primary-50 to-primary-100 rounded-lg p-6">
                <p class="text-gray-700 font-semibold mb-2">Overall Score</p>
                <p class="text-5xl font-bold text-primary-500 mb-2">{{ $attempt->overall_score }}%</p>
                <div class="flex gap-2 justify-center flex-wrap">
                    @if($attempt->overall_score >= 80)
                        <span class="px-3 py-1 rounded-full text-sm font-bold bg-green-100 text-green-800">Excellent</span>
                    @elseif($attempt->overall_score >= 60)
                        <span class="px-3 py-1 rounded-full text-sm font-bold bg-yellow-100 text-yellow-800">Good</span>
                    @else
                        <span class="px-3 py-1 rounded-full text-sm font-bold bg-blue-100 text-blue-800">Getting Started</span>
                    @endif
                </div>
            </div>

            <!-- Math Score -->
            <div class="bg-gradient-to-b from-secondary-50 to-secondary-100 rounded-lg p-6">
                <p class="text-gray-700 font-semibold mb-2">Math</p>
                <p class="text-5xl font-bold text-secondary-500 mb-2">{{ $attempt->math_score }}%</p>
                <span class="text-sm font-bold px-3 py-1 rounded-full
                    @if($attempt->math_level === 'Advanced')
                        bg-green-100 text-green-800
                    @elseif($attempt->math_level === 'Intermediate')
                        bg-yellow-100 text-yellow-800
                    @else
                        bg-blue-100 text-blue-800
                    @endif
                ">
                    {{ $attempt->math_level }}
                </span>
            </div>

            <!-- Science Score -->
            <div class="bg-gradient-to-b from-accent-50 to-accent-100 rounded-lg p-6">
                <p class="text-gray-700 font-semibold mb-2">Science</p>
                <p class="text-5xl font-bold text-accent-500 mb-2">{{ $attempt->science_score }}%</p>
                <span class="text-sm font-bold px-3 py-1 rounded-full
                    @if($attempt->science_level === 'Advanced')
                        bg-green-100 text-green-800
                    @elseif($attempt->science_level === 'Intermediate')
                        bg-yellow-100 text-yellow-800
                    @else
                        bg-blue-100 text-blue-800
                    @endif
                ">
                    {{ $attempt->science_level }}
                </span>
            </div>
        </div>

        <!-- English Score (if applicable) -->
        @if($attempt->english_score !== null)
            <div class="mt-6 bg-gradient-to-b from-highlight-50 to-highlight-100 rounded-lg p-6 md:col-span-1 max-w-xs mx-auto">
                <p class="text-gray-700 font-semibold mb-2 text-center">English</p>
                <p class="text-5xl font-bold text-highlight-500 mb-2 text-center">{{ $attempt->english_score }}%</p>
                <div class="text-center">
                    <span class="text-sm font-bold px-3 py-1 rounded-full
                        @if($attempt->english_level === 'Advanced')
                            bg-green-100 text-green-800
                        @elseif($attempt->english_level === 'Intermediate')
                            bg-yellow-100 text-yellow-800
                        @else
                            bg-blue-100 text-blue-800
                        @endif
                    ">
                        {{ $attempt->english_level }}
                    </span>
                </div>
            </div>
        @endif
    </div>

    <!-- Insights -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h3 class="text-2xl font-bold mb-6">📊 What This Means</h3>
        
        <div class="space-y-4">
            <!-- Learning Level Explanation -->
            <div class="border-l-4 border-primary-500 pl-4 py-2">
                <h4 class="font-bold text-gray-900 mb-1">Your Learning Path</h4>
                <p class="text-gray-700">
                    Based on your performance, we've personalized the curriculum to match your level. 
                    You'll start with content that builds on your strengths and addresses areas for growth.
                </p>
            </div>

            <!-- Math Insights -->
            <div class="border-l-4 border-secondary-500 pl-4 py-2">
                <h4 class="font-bold text-gray-900 mb-1">Math: {{ $attempt->math_level }}</h4>
                <p class="text-gray-700">
                    @if($attempt->math_level === 'Advanced')
                        Excellent work! You have strong foundational math skills. We'll challenge you with advanced concepts.
                    @elseif($attempt->math_level === 'Intermediate')
                        You're doing well! There are some areas we'll focus on to strengthen your skills.
                    @else
                        You're getting started with math. We'll build your confidence step by step with fundamental concepts.
                    @endif
                </p>
            </div>

            <!-- Science Insights -->
            <div class="border-l-4 border-accent-500 pl-4 py-2">
                <h4 class="font-bold text-gray-900 mb-1">Science: {{ $attempt->science_level }}</h4>
                <p class="text-gray-700">
                    @if($attempt->science_level === 'Advanced')
                        Impressive! You have a strong grasp of scientific concepts. We'll explore advanced topics.
                    @elseif($attempt->science_level === 'Intermediate')
                        Good foundation! We'll expand your understanding through targeted lessons.
                    @else
                        You're beginning your science journey. We'll introduce concepts gradually with engaging examples.
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Next Steps -->
    <div class="bg-gradient-to-r from-primary-50 to-secondary-50 rounded-lg p-6">
        <h3 class="text-2xl font-bold mb-4">🚀 Next Steps</h3>
        <div class="space-y-3">
            <a href="{{ route('student.dashboard') }}" class="block bg-white border-2 border-primary-500 text-primary-500 font-bold py-3 rounded-lg hover:bg-primary-50 transition text-center">
                View Your Dashboard
            </a>
            <a href="{{ route('student.lessons.index') }}" class="block bg-gradient-to-r from-primary-500 to-primary-700 text-white font-bold py-3 rounded-lg hover:shadow-lg transition text-center">
                Start Your Lessons
            </a>
            <a href="{{ route('student.tutor.index') }}" class="block bg-white border-2 border-secondary-500 text-secondary-500 font-bold py-3 rounded-lg hover:bg-secondary-50 transition text-center">
                Chat with AI Tutor
            </a>
        </div>
    </div>

    <!-- Metrics -->
    <div class="mt-8 text-center text-sm text-gray-600">
        <p>Test taken on {{ $attempt->created_at->format('F j, Y \a\t g:i A') }}</p>
    </div>
</div>
@endsection
