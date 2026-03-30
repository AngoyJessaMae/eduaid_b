@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">⚙️ Admin Dashboard</h1>

    <!-- Key Metrics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Students</p>
                    <p class="text-3xl font-bold text-primary-500">{{ $stats['total_students'] ?? 0 }}</p>
                </div>
                <div class="text-3xl">👥</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Subjects</p>
                    <p class="text-3xl font-bold text-primary-500">{{ $stats['total_subjects'] ?? 0 }}</p>
                </div>
                <div class="text-3xl">📚</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Lessons</p>
                    <p class="text-3xl font-bold text-primary-500">{{ $stats['total_lessons'] ?? 0 }}</p>
                </div>
                <div class="text-3xl">✏️</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Quizzes</p>
                    <p class="text-3xl font-bold text-primary-500">{{ $stats['total_quizzes'] ?? 0 }}</p>
                </div>
                <div class="text-3xl">✅</div>
            </div>
        </div>
    </div>

    <!-- Management Panels -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Subjects -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">📚 Manage Subjects</h2>
                <a href="{{ route('admin.subjects.create') }}" class="bg-primary-500 text-white px-3 py-1 rounded text-sm hover:bg-primary-700 transition">
                    + Add
                </a>
            </div>
            <p class="text-gray-600 text-sm mb-4">Manage subject categories for curriculum organization</p>
            <a href="{{ route('admin.subjects.index') }}" class="block bg-gray-100 text-gray-900 text-center py-2 rounded hover:bg-gray-200 transition font-semibold">
                View Subjects →
            </a>
        </div>

        <!-- Lessons -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">✏️ Manage Lessons</h2>
                <a href="{{ route('admin.lessons.create') }}" class="bg-primary-500 text-white px-3 py-1 rounded text-sm hover:bg-primary-700 transition">
                    + Add
                </a>
            </div>
            <p class="text-gray-600 text-sm mb-4">Create and edit lesson content</p>
            <a href="{{ route('admin.lessons.index') }}" class="block bg-gray-100 text-gray-900 text-center py-2 rounded hover:bg-gray-200 transition font-semibold">
                View Lessons →
            </a>
        </div>

        <!-- Quizzes -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">✅ Manage Quizzes</h2>
                <a href="{{ route('admin.quizzes.create') }}" class="bg-primary-500 text-white px-3 py-1 rounded text-sm hover:bg-primary-700 transition">
                    + Add
                </a>
            </div>
            <p class="text-gray-600 text-sm mb-4">Create assessments for lessons</p>
            <a href="{{ route('admin.quizzes.index') }}" class="block bg-gray-100 text-gray-900 text-center py-2 rounded hover:bg-gray-200 transition font-semibold">
                View Quizzes →
            </a>
        </div>

        <!-- Questions -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold">❓ Manage Questions</h2>
                <a href="{{ route('admin.questions.pretest.create') }}" class="bg-primary-500 text-white px-3 py-1 rounded text-sm hover:bg-primary-700 transition">
                    + Add
                </a>
            </div>
            <p class="text-gray-600 text-sm mb-4">Create pretest and quiz questions</p>
            <a href="{{ route('admin.questions.pretest.index') }}" class="block bg-gray-100 text-gray-900 text-center py-2 rounded hover:bg-gray-200 transition font-semibold">
                Manage Questions →
            </a>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 bg-gradient-to-r from-primary-50 to-secondary-50 rounded-lg p-6">
        <h3 class="text-xl font-bold mb-4">🚀 Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="{{ route('admin.subjects.index') }}" class="bg-white rounded p-4 border-2 border-primary-200 hover:shadow-lg transition">
                <p class="font-bold text-primary-700">View All Subjects</p>
                <p class="text-sm text-gray-600">{{ $stats['total_subjects'] ?? 0 }} subjects created</p>
            </a>
            <a href="{{ route('admin.lessons.index') }}" class="bg-white rounded p-4 border-2 border-primary-200 hover:shadow-lg transition">
                <p class="font-bold text-primary-700">View All Lessons</p>
                <p class="text-sm text-gray-600">{{ $stats['total_lessons'] ?? 0 }} lessons created</p>
            </a>
            <a href="{{ route('admin.quizzes.index') }}" class="bg-white rounded p-4 border-2 border-primary-200 hover:shadow-lg transition">
                <p class="font-bold text-primary-700">View All Quizzes</p>
                <p class="text-sm text-gray-600">{{ $stats['total_quizzes'] ?? 0 }} quizzes created</p>
            </a>
        </div>
    </div>

    <div class="mt-8 bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">📊 Content Snapshot</h3>
            <a href="{{ route('admin.analytics') }}" class="text-primary-600 font-semibold hover:underline">Open Full Analytics</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="rounded-lg border border-primary-100 bg-primary-50 p-4">
                <p class="text-sm text-gray-600 mb-2">Quiz Score Bands</p>
                <div class="space-y-2 text-sm text-gray-800">
                    @foreach(($chartData['scoreBands'] ?? []) as $band => $count)
                        <div class="flex items-center justify-between">
                            <span>{{ $band }}</span>
                            <span class="font-semibold">{{ $count }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="rounded-lg border border-secondary-100 bg-secondary-50 p-4">
                <p class="text-sm text-gray-600 mb-2">Lessons by Subject</p>
                <div class="space-y-2 text-sm text-gray-800">
                    @foreach(($chartData['subjectLessonCounts'] ?? []) as $item)
                        <div class="flex items-center justify-between">
                            <span>{{ $item['label'] }}</span>
                            <span class="font-semibold">{{ $item['value'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
