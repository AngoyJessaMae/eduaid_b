@extends('layouts.app')

@section('title', 'AI Tutor')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8 flex flex-col h-screen">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">🤖 AI Tutor</h1>
        <p class="text-gray-600">Ask questions and get instant help with your lessons</p>
    </div>

    <!-- Chat Window -->
    <div class="flex-1 bg-white rounded-lg shadow flex flex-col mb-6 overflow-hidden">
        <!-- Messages Area -->
        <div class="flex-1 overflow-y-auto p-6 space-y-4" id="chat-messages">
            @forelse($messages as $message)
                <div class="flex {{ $message->role === 'user' ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-xs lg:max-w-md {{ $message->role === 'user' ? 'bg-primary-500 text-white' : 'bg-gray-100 text-gray-900' }} rounded-lg p-4">
                        <p class="text-sm">{{ $message->message }}</p>
                        <p class="text-xs {{ $message->role === 'user' ? 'text-primary-100' : 'text-gray-500' }} mt-2">
                            {{ $message->created_at->format('g:i A') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="flex items-center justify-center h-full text-center">
                    <div>
                        <p class="text-2xl mb-2">👋 Welcome!</p>
                        <p class="text-gray-600">Ask me anything about your lessons or subjects.</p>
                        <p class="text-sm text-gray-500 mt-4">Type your question below to get started</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Input Area -->
        <form method="POST" action="{{ route('student.tutor.send') }}" class="border-t p-4 flex gap-2">
            @csrf
            
            <!-- Lesson Selection -->
            <select name="lesson_id" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent text-sm">
                <option value="">General Question</option>
                @foreach($lessons as $lesson)
                    <option value="{{ $lesson->id }}" {{ request('lesson_id') == $lesson->id ? 'selected' : '' }}>
                        {{ $lesson->title }}
                    </option>
                @endforeach
            </select>

            <!-- Message Input -->
            <input 
                type="text" 
                name="message" 
                placeholder="Ask your question..." 
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                autocomplete="off"
                required
            >

            <!-- Send Button -->
            <button type="submit" class="bg-primary-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-primary-700 transition flex-shrink-0">
                Send
            </button>
        </form>
    </div>

    <!-- Quick Tips -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-blue-50 border border-primary-200 rounded-lg p-4">
            <p class="font-bold text-primary-700 mb-2">💡 Tips for Better Help</p>
            <ul class="text-sm text-gray-700 space-y-1">
                <li>✓ Be specific in your questions</li>
                <li>✓ Mention the topic you need help with</li>
                <li>✓ Share what you've already tried</li>
            </ul>
        </div>
        <div class="bg-secondary-50 border border-secondary-200 rounded-lg p-4">
            <p class="font-bold text-secondary-700 mb-2">🚫 What I Can't Help With</p>
            <ul class="text-sm text-gray-700 space-y-1">
                <li>✗ Direct answers to homework</li>
                <li>✗ Non-educational content</li>
                <li>✗ Harmful or inappropriate requests</li>
            </ul>
        </div>
    </div>
</div>

<script>
// Auto-scroll to latest message
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chat-messages');
    if(chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});

// Auto-scroll after new message
const form = document.querySelector('form');
if(form) {
    form.addEventListener('submit', function() {
        setTimeout(() => {
            const chatMessages = document.getElementById('chat-messages');
            if(chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }, 100);
    });
}
</script>
@endsection
