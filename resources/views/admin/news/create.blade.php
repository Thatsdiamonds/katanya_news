<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center gap-4">
            <a href="{{ route('admin.news.index') }}" class="text-gray-400 hover:text-gray-500">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                {{ __('Create Article') }}
            </h2>
        </div>
    </x-slot>

    <div class="space-y-6 max-w-4xl">
        @if ($errors->any())
            <div class="rounded-md bg-red-50 p-4 ring-1 ring-inset ring-red-600/20">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul role="list" class="list-disc space-y-1 pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <x-ui.card>
                <div class="space-y-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        
                        <div class="sm:col-span-4">
                            <x-ui.label for="title" value="Title *" />
                            <div class="mt-2">
                                <x-ui.input id="title" name="title" type="text" value="{{ old('title') }}" required autofocus placeholder="Enter article title" />
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <x-ui.label for="category_id" value="Category *" />
                            <div class="mt-2">
                                <select id="category_id" name="category_id" required aria-describedby="category-error" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset {{ $errors->has('category_id') ? 'ring-red-500 focus:ring-red-500' : 'ring-gray-300 focus:ring-gray-900' }} sm:text-sm sm:leading-6">
                                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                                <p id="category-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @include('admin.news._slug-assistant', [
                            'slugNewsId' => null,
                            'slugInitialTitle' => old('title', ''),
                            'slugInitialValue' => old('slug', ''),
                        ])

                        <div class="sm:col-span-6">
                            <x-ui.label for="excerpt" value="Excerpt" />
                            <div class="mt-2">
                                <textarea id="excerpt" name="excerpt" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-900 sm:text-sm sm:leading-6">{{ old('excerpt') }}</textarea>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">A brief summary for the homepage and preview cards.</p>
                        </div>
                        
                        <div class="sm:col-span-6">
                            <x-ui.label for="image" value="Cover Image" />
                            <div class="mt-2 flex items-center gap-x-3">
                                <input type="file" name="image" id="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 focus:outline-none">
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <x-ui.label for="content" value="Content *" />
                            <div class="mt-2 border border-gray-300 rounded-md shadow-sm overflow-hidden focus-within:ring-2 focus-within:ring-gray-900 focus-within:border-transparent">
                                <!-- Hidden input for Tiptap content -->
                                <input type="hidden" name="content" id="content" value="{{ old('content') }}">
                                
                                <!-- Tiptap Toolbar (AlignUI Style) -->
                                <div id="tiptap-toolbar" class="bg-gray-50 border-b border-gray-200 p-1.5 flex flex-wrap gap-1 items-center">
                                    <button type="button" data-action="bold" class="p-1.5 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-900 font-bold w-8 h-8 flex items-center justify-center transition-colors">B</button>
                                    <button type="button" data-action="italic" class="p-1.5 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-900 italic w-8 h-8 flex items-center justify-center transition-colors">I</button>
                                    <div class="w-px h-5 bg-gray-300 mx-1"></div>
                                    <button type="button" data-action="h2" class="p-1.5 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-900 font-bold text-sm px-2 transition-colors">H2</button>
                                    <button type="button" data-action="h3" class="p-1.5 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-900 font-bold text-sm px-2 transition-colors">H3</button>
                                    <div class="w-px h-5 bg-gray-300 mx-1"></div>
                                    <button type="button" data-action="bulletList" class="p-1.5 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-900 text-sm px-2 flex items-center transition-colors">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                        List
                                    </button>
                                    <button type="button" data-action="orderedList" class="p-1.5 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-900 text-sm px-2 transition-colors">1. List</button>
                                    <button type="button" data-action="blockquote" class="p-1.5 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-900 text-sm px-2 transition-colors">Quote</button>
                                    <div class="w-px h-5 bg-gray-300 mx-1"></div>
                                    <button type="button" data-action="undo" class="p-1.5 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-900 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                    </button>
                                    <button type="button" data-action="redo" class="p-1.5 text-gray-600 rounded hover:bg-gray-200 hover:text-gray-900 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6"></path></svg>
                                    </button>
                                </div>
                                <div id="tiptap-editor" class="p-5 min-h-[400px] prose prose-sm sm:prose-base max-w-none focus:outline-none bg-white"></div>
                            </div>
                        </div>

                    </div>
                </div>
                
                <x-slot name="footer">
                    <x-ui.button variant="ghost" href="{{ route('admin.news.index') }}" class="mr-3">Cancel</x-ui.button>
                    <x-ui.button type="submit">Save as Draft</x-ui.button>
                </x-slot>
            </x-ui.card>
        </form>
    </div>
    
    @push('scripts')
    @vite(['resources/js/editor.js'])
    @endpush
</x-app-layout>
