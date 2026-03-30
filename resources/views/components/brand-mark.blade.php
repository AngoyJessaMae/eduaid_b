@props([
    'wrapperClass' => 'w-10 h-10 rounded-lg bg-white flex items-center justify-center overflow-hidden',
    'logoClass' => 'w-full h-full object-contain',
    'fallbackClass' => 'text-2xl font-bold text-primary-700',
])

@php
    $brandName = config('app.name', 'EduAid');
    $logoPath = config('app.brand_logo');
    $hasLogo = is_string($logoPath) && $logoPath !== '' && file_exists(public_path($logoPath));
    $words = preg_split('/\s+/', trim($brandName)) ?: [];
    $initials = collect($words)
        ->filter()
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->take(2)
        ->implode('');
    $initials = $initials !== '' ? $initials : 'EA';
@endphp

<div class="{{ $wrapperClass }}">
    @if ($hasLogo)
        <img src="{{ asset($logoPath) }}" alt="{{ $brandName }} logo" class="{{ $logoClass }}">
    @else
        <span class="{{ $fallbackClass }}">{{ $initials }}</span>
    @endif
</div>