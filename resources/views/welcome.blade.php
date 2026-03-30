@extends('layouts.auth')

@section('title', 'Welcome')

@section('content')
@php
    $brandName = config('app.name', 'EduAid');
    $logoPath = config('app.brand_logo');
    $hasLogo = is_string($logoPath) && $logoPath !== '' && file_exists(public_path($logoPath));
@endphp
<div class="min-h-screen bg-gradient-to-br from-primary-500 via-accent-600 to-primary-700 text-white">
    <div class="max-w-7xl mx-auto px-4 py-10 sm:py-16">
        <header class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                @if($hasLogo)
                    <div class="flex flex-col">
                        <div class="brand-logo-frame brand-logo-frame-hero">
                            <img src="{{ asset($logoPath) }}" alt="{{ $brandName }} logo" class="brand-logo-image">
                        </div>
                        <p class="text-xs text-primary-100 mt-1">Personalized Learning Platform</p>
                    </div>
                @else
                    <x-brand-mark
                        wrapperClass="w-11 h-11 rounded-xl bg-white/20 backdrop-blur flex items-center justify-center overflow-hidden"
                        logoClass="w-full h-full object-contain"
                        fallbackClass="font-extrabold"
                    />
                    <div>
                        <p class="text-xl font-bold">{{ $brandName }}</p>
                        <p class="text-xs text-primary-100">Personalized Learning Platform</p>
                    </div>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg bg-white/10 hover:bg-white/20 border border-white/20">Login</a>
                <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-secondary-500 hover:bg-secondary-600 font-semibold">Get Started</a>
            </div>
        </header>

        <main class="mt-16 grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
            <section>
                <p class="inline-block px-3 py-1 rounded-full bg-white/15 text-sm mb-5">For Grades 7-12</p>
                <h1 class="text-4xl sm:text-5xl font-extrabold leading-tight">Personalized tutoring, diagnostics, and progress tracking in one platform.</h1>
                <p class="mt-5 text-primary-100 max-w-xl">Take subject pretests, get targeted lessons and quizzes, and ask the AI tutor for help based on your current topic.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('register') }}" class="btn-secondary">Create Student Account</a>
                    <a href="{{ route('login') }}" class="btn-muted">Sign In</a>
                </div>
            </section>

            <section class="panel p-6 bg-white/95 text-gray-900">
                <h2 class="text-xl font-bold mb-4">What You Can Do</h2>
                <ul class="space-y-3 text-sm">
                    <li>Diagnostic pretests in Math, Science, and English</li>
                    <li>Text + video lessons with curriculum alignment</li>
                    <li>Interactive quizzes with score feedback</li>
                    <li>AI Tutor powered by Ollama for lesson-focused guidance</li>
                    <li>Progress dashboard and downloadable reports</li>
                </ul>
            </section>
        </main>
    </div>
</div>
@endsection
