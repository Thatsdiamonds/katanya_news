@props(['date'])

@php
    if (!$date) {
        $diff = '-';
        $exactFull = '';
        $exactShort = '';
        $isBeyondDays = false;
    } else {
        $cDate = \Carbon\Carbon::parse($date)->locale('id');
        $now = \Carbon\Carbon::now();
        
        $exactFull = $cDate->translatedFormat('d F Y H:i');
        $exactShort = $cDate->translatedFormat('d M Y');
        
        $diff = $cDate->diffForHumans();
        
        $diffInDays = abs((int) $cDate->diffInDays($now));
        $isBeyondDays = $diffInDays >= 7;
    }
@endphp

@if($date)
    <span title="{{ $exactFull }}" {{ $attributes->merge(['class' => 'inline-flex items-center gap-1 cursor-pointer transition-opacity hover:opacity-100']) }}>
        <span>{{ $diff }}</span>
        @if($isBeyondDays)
            <span class="opacity-50 font-normal">({{ $exactShort }})</span>
        @endif
    </span>
@else
    <span {{ $attributes }}>-</span>
@endif
