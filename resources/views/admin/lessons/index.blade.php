@extends('layouts.app')

@section('title', 'Manage Lessons')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">✏️ Manage Lessons</h1>
        <a href="{{ route('admin.lessons.create') }}" class="bg-gradient-to-r from-primary-500 to-primary-700 text-white px-6 py-2 rounded-lg font-bold hover:shadow-lg transition">
            + Create Lesson
        </a>
    </div>

    <!-- Filter by Subject -->
    <div class="mb-6 flex gap-2 flex-wrap">
        <a href="{{ route('admin.lessons.index') }}" class="px-4 py-2 rounded-lg {{ !request('subject') ? 'bg-primary-500 text-white' : 'bg-gray-200 text-gray-900' }} hover:shadow transition text-sm font-semibold">
            All Lessons
        </a>
        @foreach($subjects as $subject)
            <a href="{{ route('admin.lessons.index', ['subject' => $subject->id]) }}" class="px-4 py-2 rounded-lg {{ request('subject') == $subject->id ? 'bg-primary-500 text-white' : 'bg-gray-200 text-gray-900' }} hover:shadow transition text-sm font-semibold">
                {{ $subject->name }}
            </a>
        @endforeach
    </div>

    <!-- Lessons Table -->
    @if($lessons->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Title</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Subject</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Difficulty</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Quizzes</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Status</th>
                        <th class="px-6 py-3 text-right text-sm font-bold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($lessons as $lesson)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900">{{ $lesson->title }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $lesson->subject->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold px-2 py-1 rounded
                                    @if($lesson->difficulty_level === 'Beginner')
                                        bg-green-100 text-green-800
                                    @elseif($lesson->difficulty_level === 'Intermediate')
                                        bg-yellow-100 text-yellow-800
                                    @else
                                        bg-red-100 text-red-800
                                    @endif
                                ">
                                    {{ $lesson->difficulty_level }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $lesson->quizzes_count ?? $lesson->quizzes->count() }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" action="{{ route('admin.lessons.toggle-active', $lesson) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold px-3 py-1 rounded
                                        {{ $lesson->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}
                                    ">
                                        {{ $lesson->is_active ? '✓ Active' : '✕ Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.lessons.edit', $lesson) }}" class="text-primary-500 hover:underline text-sm font-semibold">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.lessons.destroy', $lesson) }}" class="inline" onsubmit="return confirm('Are you sure?')">
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
        @if($lessons->hasPages())
            <div class="mt-6">
                {{ $lessons->links() }}
            </div>
        @endif
    @else
        <div class="bg-gray-50 rounded-lg p-12 text-center">
            <p class="text-gray-600 mb-4">No lessons created yet.</p>
            <a href="{{ route('admin.lessons.create') }}" class="text-primary-500 hover:underline font-semibold">
                Create the first lesson
            </a>
        </div>
    @endif
</div>
@endsection
