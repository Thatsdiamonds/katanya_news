<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center gap-4">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Users</h2>
            <x-ui.button href="{{ route('admin.users.create') }}">Add User</x-ui.button>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="p-4 rounded-md bg-green-50 text-green-700 ring-1 ring-green-600/20">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="p-4 rounded-md bg-red-50 text-red-700 ring-1 ring-red-600/20">{{ session('error') }}</div>
        @endif

        <x-ui.card class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wide">Name</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 uppercase tracking-wide">Role</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 uppercase tracking-wide">Joined</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0">
                                            @if($user->avatar)
                                                <img class="h-10 w-10 rounded-full object-cover shadow-sm ring-1 ring-gray-900/5" src="{{ Storage::disk('public')->url($user->avatar) }}" alt="">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold border border-gray-200">{{ substr($user->name, 0, 1) }}</div>
                                            @endif
                                        </div>
                                        <div class="ml-4">
                                            <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $user->role === 'superadmin' ? 'bg-purple-50 text-purple-700 ring-purple-600/20' : 'bg-gray-50 text-gray-600 ring-gray-500/20' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <div class="flex items-center justify-end gap-2">
                                        <x-ui.button variant="ghost" size="sm" href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-800">Edit</x-ui.button>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline-block">
                                            @csrf @method('DELETE')
                                            <x-ui.button type="submit" variant="ghost" size="sm" class="text-red-600 hover:text-red-800">Delete</x-ui.button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
                <div class="border-t border-gray-200 px-4 py-3 sm:px-6">{{ $users->links() }}</div>
            @endif
        </x-ui.card>
    </div>
</x-app-layout>
