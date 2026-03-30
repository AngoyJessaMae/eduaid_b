@extends('layouts.app')

@section('title', 'Manage Subjects')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">📚 Manage Subjects</h1>
        <a href="{{ route('admin.subjects.create') }}" class="bg-gradient-to-r from-primary-500 to-primary-700 text-white px-6 py-2 rounded-lg font-bold hover:shadow-lg transition">
            + Create Subject
        </a>
    </div>

    <!-- Subjects Table -->
    @if($subjects->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Subject</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Lessons</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Pretest Questions</th>
                        <th class="px-6 py-3 text-right text-sm font-bold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($subjects as $subject)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900">{{ $subject->name }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-sm font-semibold">
                                    {{ $subject->lessons_count }} lessons
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full bg-purple-100 text-purple-800 text-sm font-semibold">
                                    {{ $subject->pretest_questions_count }} questions
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.subjects.edit', $subject) }}" class="text-primary-500 hover:underline text-sm font-semibold">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.subjects.destroy', $subject) }}" class="inline" onsubmit="return confirm('Are you sure?')">
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
        @if($subjects->hasPages())
            <div class="mt-6">
                {{ $subjects->links() }}
            </div>
        @endif
    @else
        <div class="bg-gray-50 rounded-lg p-12 text-center">
            <p class="text-gray-600 mb-4">No subjects created yet.</p>
            <a href="{{ route('admin.subjects.create') }}" class="text-primary-500 hover:underline font-semibold">
                Create the first subject
            </a>
        </div>
    @endif
</div>
@endsection
