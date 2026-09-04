<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center gap-4">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">Categories</h2>
            <x-ui.button href="{{ route('admin.categories.create') }}">Add Category</x-ui.button>
        </div>
    </x-slot>

    <div class="space-y-6 max-w-4xl">
        @if(session('success'))
            <div class="p-4 rounded-md bg-green-50 text-green-700 ring-1 ring-green-600/20">{{ session('success') }}</div>
        @endif

        <x-ui.card class="overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold text-gray-900 uppercase tracking-wide">Category Name</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 uppercase tracking-wide">Slug</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach($categories as $category)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900">{{ $category->name }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 font-mono">{{ $category->slug }}</td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <div class="flex items-center justify-end gap-2">
                                        <x-ui.button variant="ghost" size="sm" href="{{ route('admin.categories.edit', $category) }}" class="text-blue-600 hover:text-blue-800">Edit</x-ui.button>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure?');" class="inline-block">
                                            @csrf @method('DELETE')
                                            <x-ui.button type="submit" variant="ghost" size="sm" class="text-red-600 hover:text-red-800">Delete</x-ui.button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($categories->hasPages())
                <div class="border-t border-gray-200 px-4 py-3 sm:px-6">{{ $categories->links() }}</div>
            @endif
        </x-ui.card>
    </div>
</x-app-layout>
