@extends('layouts.app')

@section('title', 'Subject Details')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('admin.subjects.index') }}" class="text-primary-600 hover:underline text-sm">&larr; Back to Subjects</a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $subject->name }}</h1>
        </div>
        <a href="{{ route('admin.subjects.edit', $subject) }}" class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-4 py-2 rounded-lg">Edit Subject</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Lessons</p>
            <p class="text-3xl font-bold text-primary-700">{{ $subject->lessons->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Pretest Questions</p>
            <p class="text-3xl font-bold text-secondary-600">{{ $subject->pretestQuestions->count() }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-4">
            <p class="text-sm text-gray-500">Status</p>
            <p class="text-lg font-semibold text-green-700">Active</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Content Management</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('admin.lessons.index', ['subject' => $subject->id]) }}" class="border border-primary-200 rounded-lg p-4 hover:bg-primary-50 transition">
                <p class="font-semibold text-primary-700">Manage Lessons</p>
                <p class="text-sm text-gray-600">Upload, edit, and organize lesson materials</p>
            </a>
            <a href="{{ route('admin.questions.pretest.index', ['subject' => $subject->id]) }}" class="border border-secondary-200 rounded-lg p-4 hover:bg-secondary-50 transition">
                <p class="font-semibold text-secondary-700">Manage Pretest Items</p>
                <p class="text-sm text-gray-600">Create diagnostic questions and answer keys</p>
            </a>
        </div>
    </div>
</div>
@endsection
