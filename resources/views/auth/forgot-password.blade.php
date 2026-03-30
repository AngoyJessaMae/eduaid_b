@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
@php
    $brandName = config('app.name', 'EduAid');
    $logoPath = config('app.brand_logo');
    $hasLogo = is_string($logoPath) && $logoPath !== '' && file_exists(public_path($logoPath));
@endphp
<div class="min-h-screen bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center gap-3 mb-6">
                @if($hasLogo)
                    <div class="brand-logo-frame brand-logo-frame-auth">
                        <img src="{{ asset($logoPath) }}" alt="{{ $brandName }} logo" class="brand-logo-image">
                    </div>
                @else
                    <x-brand-mark wrapperClass="w-12 h-12 bg-white rounded-lg flex items-center justify-center overflow-hidden" />
                    <h1 class="text-3xl font-bold text-white">{{ $brandName }}</h1>
                @endif
            </div>
            <p class="text-primary-100">Reset Your Password</p>
        </div>

        <!-- Forgot Password Form -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2 text-center">Forgot Password?</h2>
            <p class="text-gray-600 text-center mb-6">
                No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.
            </p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-4 rounded-lg bg-green-50 border border-green-200">
                    <p class="text-sm text-green-800">{{ session('status') }}</p>
                </div>
            @endif

            <!-- Errors -->
            @if ($errors->any())
                <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm text-red-800">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-900 mb-2">Email Address</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('email') border-red-500 @enderror"
                        placeholder="you@example.com"
                        required
                    >
                </div>

                <!-- Send Link Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-primary-700 text-white font-bold py-3 rounded-lg hover:shadow-lg transition mt-6">
                    Email Password Reset Link
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center text-sm">
                <a href="{{ route('login') }}" class="text-primary-500 hover:underline font-semibold">
                    Back to Login
                </a>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-primary-100 text-sm mt-6">
            © 2026 {{ config('app.name', 'EduAid') }}. All rights reserved.
        </p>
    </div>
</div>
@endsection
