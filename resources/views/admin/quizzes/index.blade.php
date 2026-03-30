@extends('layouts.app')

@section('title', 'Manage Quizzes')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">✅ Manage Quizzes</h1>
        <a href="{{ route('admin.quizzes.create') }}" class="bg-gradient-to-r from-primary-500 to-primary-700 text-white px-6 py-2 rounded-lg font-bold hover:shadow-lg transition">
            + Create Quiz
        </a>
    </div>

    <!-- Filter by Lesson/Subject -->
    <div class="mb-6 bg-white rounded-lg shadow p-4">
        <form method="GET" class="flex gap-3 flex-wrap">
            <select name="subject" class="px-4 py-2 border-2 border-gray-300 rounded-lg text-sm">
                <option value="">All Subjects</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ request('subject') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
            <select name="lesson" class="px-4 py-2 border-2 border-gray-300 rounded-lg text-sm">
                <option value="">All Lessons</option>
                @foreach($lessons as $lesson)
                    <option value="{{ $lesson->id }}" {{ request('lesson') == $lesson->id ? 'selected' : '' }}>
                        {{ $lesson->title }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-primary-500 text-white rounded-lg text-sm font-semibold hover:bg-primary-700">
                Filter
            </button>
        </form>
    </div>

    <!-- Quizzes Table -->
    @if($quizzes->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Lesson</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Questions</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Attempts</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Status</th>
                        <th class="px-6 py-3 text-right text-sm font-bold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($quizzes as $quiz)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900">{{ $quiz->title }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $quiz->lesson->title }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $quiz->questions_count ?? $quiz->questions->count() }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $quiz->attempts_count ?? $quiz->quizAttempts->count() }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.quizzes.toggle-active', $quiz) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold px-3 py-1 rounded
                                        {{ $quiz->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}
                                    ">
                                        {{ $quiz->is_active ? '✓ Active' : '✕ Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2 flex justify-end">
                                <a href="{{ route('admin.quizzes.show', $quiz) }}" class="text-blue-500 hover:underline text-sm font-semibold">
                                    View
                                </a>
                                <a href="{{ route('admin.quizzes.edit', $quiz) }}" class="text-primary-500 hover:underline text-sm font-semibold">
                                    Edit
                                </a>
                                <a href="{{ route('admin.questions.quiz.index', $quiz) }}" class="text-purple-500 hover:underline text-sm font-semibold">
                                    Questions
                                </a>
                                <form method="POST" action="{{ route('admin.quizzes.destroy', $quiz) }}" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline text-sm font-semibold">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($quizzes->hasPages())
            <div class="mt-6">
                {{ $quizzes->links() }}
            </div>
        @endif
    @else
        <div class="bg-gray-50 rounded-lg p-12 text-center">
            <p class="text-gray-600 mb-4">No quizzes created yet.</p>
            <a href="{{ route('admin.quizzes.create') }}" class="text-primary-500 hover:underline font-semibold">
                Create a quiz
            </a>
        </div>
    @endif
</div>
@endsection
