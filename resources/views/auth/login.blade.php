<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-semibold tracking-tight text-gray-900">Sign in to your account</h2>
        <p class="mt-2 text-sm text-gray-500">Welcome back to the editorial dashboard.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-ui.label for="email" :value="__('Email address')" />
            <div class="mt-2">
                <x-ui.input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-ui.label for="password" :value="__('Password')" />
            <div class="mt-2">
                <x-ui.input id="password" type="password" name="password" required autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-ui.button type="submit" class="w-full justify-center">
                {{ __('Sign in') }}
            </x-ui.button>
        </div>
    </form>
</x-guest-layout>

