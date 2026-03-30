@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-md text-center">
        <div class="text-9xl font-bold text-primary-500 mb-4">
            404
        </div>
        
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Page Not Found
        </h1>
        
        <p class="text-gray-600 mb-8">
            Sorry, the page you're looking for doesn't exist. It might have been moved or deleted.
        </p>

        <div class="flex gap-4 flex-col sm:flex-row justify-center">
            <a href="{{ url('/') }}" class="bg-primary-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-primary-700 transition">
                Go Home
            </a>
            <a href="javascript:history.back()" class="bg-gray-300 text-gray-900 font-bold py-3 px-6 rounded-lg hover:bg-gray-400 transition">
                Go Back
            </a>
        </div>
    </div>
</div>
@endsection
