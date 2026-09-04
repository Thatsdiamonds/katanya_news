<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Self-hosted fonts from public/fonts -->
        @include('partials.fonts')

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#F9FAFB] min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div class="text-center">
                <a href="/" class="inline-block font-serif text-3xl font-bold tracking-tight text-gray-900">
                    Kata<sup class="text-blue-600 text-xl">2</sup>-nya.
                </a>
            </div>

            <div class="bg-white px-8 py-10 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
