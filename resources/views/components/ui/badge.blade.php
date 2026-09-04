@props(['status'])

@php
    $status = strtolower($status);
    
    $classes = match($status) {
        'published' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'draft' => 'bg-gray-50 text-gray-600 ring-gray-500/20',
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        'revision' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
        'approved' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
        default => 'bg-gray-50 text-gray-600 ring-gray-500/20',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset $classes"]) }}>
    {{ $slot->isEmpty() ? ucfirst($status) : $slot }}
</span>
