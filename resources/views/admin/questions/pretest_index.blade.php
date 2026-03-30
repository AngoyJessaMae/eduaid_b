@extends('layouts.app')

@section('title', 'Manage Pretest Questions')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">❓ Pretest Questions</h1>
        <a href="{{ route('admin.questions.pretest.create') }}" class="bg-gradient-to-r from-primary-500 to-primary-700 text-white px-6 py-2 rounded-lg font-bold hover:shadow-lg transition">
            + Add Question
        </a>
    </div>

    <!-- Filter by Subject -->
    <div class="mb-6 flex gap-2 flex-wrap">
        <a href="{{ route('admin.questions.pretest.index') }}" class="px-4 py-2 rounded-lg {{ !request('subject') ? 'bg-primary-500 text-white' : 'bg-gray-200 text-gray-900' }} hover:shadow transition text-sm font-semibold">
            All Subjects
        </a>
        @foreach($subjects as $subject)
            <a href="{{ route('admin.questions.pretest.index', ['subject' => $subject->id]) }}" class="px-4 py-2 rounded-lg {{ request('subject') == $subject->id ? 'bg-primary-500 text-white' : 'bg-gray-200 text-gray-900' }} hover:shadow transition text-sm font-semibold">
                {{ $subject->name }}
            </a>
        @endforeach
    </div>

    <!-- Questions Table -->
    @if($questions->count() > 0)
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Question</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Subject</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Difficulty</th>
                        <th class="px-6 py-3 text-left text-sm font-bold text-gray-900">Answers</th>
                        <th class="px-6 py-3 text-right text-sm font-bold text-gray-900">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($questions as $question)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900">{{ Str::limit($question->question, 50) }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">{{ $question->subject->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-semibold px-2 py-1 rounded
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
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm text-gray-600">
                                    {{ count(is_array($question->choices) ? $question->choices : json_decode($question->choices, true)) }} options
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.questions.pretest.edit', $question) }}" class="text-primary-500 hover:underline text-sm font-semibold">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.questions.pretest.destroy', $question) }}" class="inline" onsubmit="return confirm('Are you sure?')">
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
        @if($questions->hasPages())
            <div class="mt-6">
                {{ $questions->links() }}
            </div>
        @endif
    @else
        <div class="bg-gray-50 rounded-lg p-12 text-center">
            <p class="text-gray-600 mb-4">No pretest questions created yet.</p>
            <a href="{{ route('admin.questions.pretest.create') }}" class="text-primary-500 hover:underline font-semibold">
                Create a question
            </a>
        </div>
    @endif
</div>
@endsection
