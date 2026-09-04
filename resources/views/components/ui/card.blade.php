<div {{ $attributes->merge(['class' => 'bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl']) }}>
    @if(isset($header))
        <div class="px-4 py-5 border-b border-gray-100 sm:px-6">
            {{ $header }}
        </div>
    @endif
    <div class="px-4 py-5 sm:p-6">
        {{ $slot }}
    </div>
    @if(isset($footer))
        <div class="px-4 py-4 border-t border-gray-100 bg-gray-50 sm:px-6 sm:rounded-b-xl flex items-center justify-end">
            {{ $footer }}
        </div>
    @endif
</div>
