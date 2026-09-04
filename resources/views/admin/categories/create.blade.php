<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.categories.index') }}" class="text-gray-400 hover:text-gray-500">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                Add New Category
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

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <x-ui.card>
                <div class="space-y-6">
                    <div>
                        <x-ui.label for="name" value="Name *" />
                        <x-ui.input id="name" name="name" type="text" value="{{ old('name') }}" required class="mt-1 w-full" />
                    </div>

                    <div>
                        <x-ui.label for="slug" value="Slug (Auto-generated if empty)" />
                        <x-ui.input id="slug" name="slug" type="text" value="{{ old('slug') }}" class="mt-1 w-full font-mono text-sm" />
                    </div>

                    <div>
                        <x-ui.label for="description" value="Description" />
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-900 sm:text-sm sm:leading-6">{{ old('description') }}</textarea>
                    </div>
                </div>

                <x-slot name="footer">
                    <div class="flex items-center justify-end">
                        <x-ui.button variant="ghost" href="{{ route('admin.categories.index') }}" class="mr-3">Cancel</x-ui.button>
                        <x-ui.button type="submit">Create Category</x-ui.button>
                    </div>
                </x-slot>
            </x-ui.card>
        </form>
    </div>

    @push('scripts')
    <script>
        document.getElementById('name').addEventListener('blur', function(e) {
            let slugInput = document.getElementById('slug');
            if (slugInput.value.trim() === '') {
                let slug = e.target.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)+/g, '');
                slugInput.value = slug;
            }
        });
    </script>
    @endpush
</x-app-layout>
