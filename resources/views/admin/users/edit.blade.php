<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users.index') }}" class="text-gray-400 hover:text-gray-500">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                Edit User
            </h2>
        </div>
    </x-slot>

    <div class="max-w-2xl">
        @if ($errors->any())
            <div class="mb-6 rounded-md bg-red-50 p-4 ring-1 ring-inset ring-red-600/20">
                <div class="text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <x-ui.card>
                <div class="space-y-6">
                    <div>
                        <x-ui.label for="avatar" value="Profile Picture" />
                        @if($user->avatar)
                            <div class="mt-2 mb-3">
                                <img src="{{ Storage::disk('public')->url($user->avatar) }}" alt="Avatar" class="w-16 h-16 rounded-full object-cover shadow-sm ring-1 ring-gray-900/10">
                            </div>
                        @endif
                        <input type="file" name="avatar" id="avatar" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100">
                    </div>

                    <div>
                        <x-ui.label for="name" value="Name *" />
                        <x-ui.input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required class="mt-1 w-full" />
                    </div>

                    <div>
                        <x-ui.label for="email" value="Email Address *" />
                        <x-ui.input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="mt-1 w-full" />
                    </div>

                    <div>
                        <x-ui.label for="role" value="Role *" />
                        <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-900 focus:ring-gray-900 sm:text-sm">
                            <option value="writer" {{ old('role', $user->role) === 'writer' ? 'selected' : '' }}>Writer</option>
                            <option value="superadmin" {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                        </select>
                    </div>

                    <div>
                        <x-ui.label for="password" value="New Password (leave blank to keep current)" />
                        <x-ui.input id="password" name="password" type="password" class="mt-1 w-full" />
                    </div>

                    <div>
                        <x-ui.label for="password_confirmation" value="Confirm Password" />
                        <x-ui.input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 w-full" />
                    </div>
                </div>

                <x-slot name="footer">
                    <div class="flex items-center justify-end">
                        <x-ui.button variant="ghost" href="{{ route('admin.users.index') }}" class="mr-3">Cancel</x-ui.button>
                        <x-ui.button type="submit">Update User</x-ui.button>
                    </div>
                </x-slot>
            </x-ui.card>
        </form>
    </div>
</x-app-layout>
