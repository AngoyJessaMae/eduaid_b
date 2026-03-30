@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6 text-center">Reset Password</h1>

        @if ($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-red-50 border border-red-200">
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-red-800">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label for="email" class="block text-sm font-bold text-gray-900 mb-2">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $request->email) }}" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:outline-none">
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-gray-900 mb-2">New Password</label>
                <input id="password" name="password" type="password" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:outline-none">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-gray-900 mb-2">Confirm Password</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-primary-500 focus:outline-none">
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-primary-600 to-accent-600 text-white font-bold py-3 rounded-lg hover:shadow-lg transition">Reset Password</button>
        </form>
    </div>
</div>
@endsection
