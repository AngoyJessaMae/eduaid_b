@extends('layouts.auth')

@section('title', 'Register')

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
            <p class="text-primary-100">Start Your Learning Journey Today</p>
        </div>

        <!-- Registration Form -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Create Account</h2>

            <!-- Errors -->
            @if ($errors->any())
                <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm text-red-800">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-900 mb-2">Full Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('name') border-red-500 @enderror"
                        placeholder="John Doe"
                        required
                    >
                </div>

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

                <!-- Grade Level (for students) -->
                <div>
                    <label for="grade_level" class="block text-sm font-bold text-gray-900 mb-2">Grade Level</label>
                    <select 
                        id="grade_level" 
                        name="grade_level"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('grade_level') border-red-500 @enderror"
                    >
                        <option value="">Select your grade</option>
                        <option value="7" {{ old('grade_level') == '7' ? 'selected' : '' }}>Grade 7</option>
                        <option value="8" {{ old('grade_level') == '8' ? 'selected' : '' }}>Grade 8</option>
                        <option value="9" {{ old('grade_level') == '9' ? 'selected' : '' }}>Grade 9</option>
                        <option value="10" {{ old('grade_level') == '10' ? 'selected' : '' }}>Grade 10</option>
                        <option value="11" {{ old('grade_level') == '11' ? 'selected' : '' }}>Grade 11</option>
                        <option value="12" {{ old('grade_level') == '12' ? 'selected' : '' }}>Grade 12</option>
                    </select>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-900 mb-2">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('password') border-red-500 @enderror"
                        placeholder="••••••••"
                        required
                    >
                    <p class="text-xs text-gray-600 mt-1">At least 8 characters</p>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-900 mb-2">Confirm Password</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation"
                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:ring-primary-500 focus:outline-none @error('password_confirmation') border-red-500 @enderror"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <!-- Sign Up Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-primary-700 text-white font-bold py-3 rounded-lg hover:shadow-lg transition mt-6">
                    Create Account
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center text-sm">
                <p>
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-primary-500 hover:underline font-semibold">
                        Sign In
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <p class="text-center text-primary-100 text-sm mt-6">
            © 2026 {{ config('app.name', 'EduAid') }}. All rights reserved.
        </p>
    </div>
</div>
@endsection
