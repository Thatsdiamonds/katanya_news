@props([
    'variant' => 'primary', // primary, secondary, outline, ghost, danger
    'size' => 'md', // sm, md, lg
    'type' => 'submit'
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none rounded-md';

    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-base',
        default => 'px-4 py-2 text-sm',
    };

    $variantClasses = match($variant) {
        'primary' => 'bg-gray-900 text-white hover:bg-black focus:ring-gray-900',
        'secondary' => 'bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-500',
        'outline' => 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:ring-gray-500',
        'ghost' => 'bg-transparent text-gray-700 hover:bg-gray-100 focus:ring-gray-500',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-600',
        'link' => 'bg-transparent text-blue-600 hover:text-blue-800 hover:underline p-0 focus:ring-0',
        default => 'bg-gray-900 text-white hover:bg-black focus:ring-gray-900',
    };

    $classes = $baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses;
@endphp

@if($attributes->has('href'))
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
