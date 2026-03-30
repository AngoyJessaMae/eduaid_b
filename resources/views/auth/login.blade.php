@extends('layouts.auth')

@section('title', 'Login')

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
            <p class="text-primary-100">Personalized Learning for Every Student</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Welcome Back</h2>

            <!-- Session Status -->
            @if ($errors->any())
                <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200">
                    @foreach ($errors->all() as $error)
                        <p class="text-sm text-red-800">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
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
                        autofocus
                    >
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
                </div>

                <!-- Remember Me -->
                <label for="remember_me" class="flex items-center gap-2 cursor-pointer">
                    <input 
                        type="checkbox" 
                        id="remember_me" 
                        name="remember"
                        class="w-4 h-4 text-primary-500 rounded focus:ring-2 focus:ring-primary-500"
                    >
                    <span class="text-sm text-gray-700">Remember me</span>
                </label>

                <!-- Login Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-primary-700 text-white font-bold py-3 rounded-lg hover:shadow-lg transition mt-6">
                    Sign In
                </button>
            </form>

            <!-- Links -->
            <div class="mt-6 space-y-2 text-center text-sm">
                @if (Route::has('password.request'))
                    <p>
                        <a href="{{ route('password.request') }}" class="text-primary-500 hover:underline font-semibold">
                            Forgot Your Password?
                        </a>
                    </p>
                @endif

                <p>
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-primary-500 hover:underline font-semibold">
                        Sign Up
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
