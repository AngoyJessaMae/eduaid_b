@extends('layouts.app')

@section('title', 'Unauthorized')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="max-w-md text-center">
        <div class="text-9xl font-bold text-secondary-500 mb-4">
            403
        </div>
        
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Access Denied
        </h1>
        
        <p class="text-gray-600 mb-8">
            You don't have permission to access this resource. If you think this is a mistake, please contact an administrator.
        </p>

        <div class="flex gap-4 flex-col sm:flex-row justify-center">
            <a href="{{ auth()->check() ? route('student.dashboard') : url('/') }}" class="bg-primary-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-primary-700 transition">
                {{ auth()->check() ? 'Go to Dashboard' : 'Go Home' }}
            </a>
            <a href="javascript:history.back()" class="bg-gray-300 text-gray-900 font-bold py-3 px-6 rounded-lg hover:bg-gray-400 transition">
                Go Back
            </a>
        </div>
    </div>
</div>
@endsection
