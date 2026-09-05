<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center gap-4">
            <a href="{{ route('admin.news.index') }}" class="text-gray-400 hover:text-gray-500">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                    {{ __('Edit Article') }}
                </h2>
                <x-ui.badge :status="$news->status" />
            </div>
        </div>
    </x-slot>

    <div class="space-y-6 max-w-4xl">
        
        @if($news->status === 'revision' && $news->rejection_reason)
            <div class="rounded-md bg-rose-50 p-4 ring-1 ring-inset ring-rose-600/20">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-rose-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-rose-800">Revision Needed</h3>
                        <div class="mt-2 text-sm text-rose-700">
                            <p>{{ $news->rejection_reason }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

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

        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <x-ui.card>
                <div class="space-y-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        
                        <div class="sm:col-span-4">
                            <x-ui.label for="title" value="Title *" />
                            <div class="mt-2">
                                <x-ui.input id="title" name="title" type="text" value="{{ old('title', $news->title) }}" required />
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <x-ui.label for="category_id" value="Category *" />
                            <div class="mt-2">
                                <select id="category_id" name="category_id" required aria-describedby="category-error" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset {{ $errors->has('category_id') ? 'ring-red-500 focus:ring-red-500' : 'ring-gray-300 focus:ring-gray-900' }} sm:text-sm sm:leading-6">
                                    <option value="" disabled {{ old('category_id', $news->category_id) ? '' : 'selected' }}>Select a category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $news->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                                <p id="category-error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @include('admin.news._slug-assistant', [
                            'slugNewsId' => $news->id,
                            'slugInitialTitle' => old('title', $news->title),
                            'slugInitialValue' => old('slug', $news->slug),
                        ])

                        <div class="sm:col-span-6">
                            <x-ui.label for="excerpt" value="Excerpt" />
                            <div class="mt-2">
                                <textarea id="excerpt" name="excerpt" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-900 sm:text-sm sm:leading-6">{{ old('excerpt', $news->excerpt) }}</textarea>
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <x-ui.label for="image" value="Cover Image" />
                            @if($news->image)
                                <div class="mt-2 mb-3">
                                    <img src="{{ Storage::url($news->image) }}" alt="Current cover" class="w-48 h-auto rounded-md shadow-sm ring-1 ring-gray-900/10">
                                </div>
                            @endif
                            <div class="mt-2">
                                <input type="file" name="image" id="image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-50 file:text-gray-700 hover:file:bg-gray-100 focus:outline-none">
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Leave empty to keep current image.</p>
                        </div>

                        <div class="sm:col-span-6">
                            <x-ui.label for="content" value="Content *" />
                            <div class="mt-2 border border-gray-300 rounded-md shadow-sm overflow-hidden focus-within:ring-2 focus-within:ring-gray-900 focus-within:border-transparent">
                                <!-- Hidden input for Tiptap content -->
                                <input type="hidden" name="content" id="content" value="{{ old('content', $news->content) }}">
                                
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
                    @if(auth()->user()->role === 'superadmin' && $news->status === 'pending')
                        <div class="flex-1 text-sm text-gray-500 mr-4">
                            Save changes first before approving/rejecting.
                        </div>
                    @endif
                    <div class="flex items-center">
                        <x-ui.button variant="ghost" href="{{ route('admin.news.index') }}" class="mr-3">Cancel</x-ui.button>
                        <x-ui.button type="submit">Update Article</x-ui.button>
                    </div>
                </x-slot>
            </x-ui.card>
        </form>

        @if(auth()->user()->role === 'superadmin' && $news->status === 'pending')
            <x-ui.card class="border-t-4 border-t-amber-400">
                <x-slot name="header">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Super Admin Review</h3>
                </x-slot>
                
                <form action="{{ route('admin.news.review', $news) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <x-ui.label for="rejection_reason" value="Revision Note (Required if sending back)" />
                            <div class="mt-2">
                                <textarea name="rejection_reason" id="rejection_reason" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-900 sm:text-sm sm:leading-6" placeholder="Explain what needs to be changed..."></textarea>
                            </div>
                        </div>

                        <div class="flex gap-3 pt-2">
                            <button type="submit" name="action" value="approve" onclick="return window.confirm('Apakah Anda yakin ingin menyetujui artikel ini?');" class="inline-flex items-center justify-center font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-md px-4 py-2 text-sm bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-600">
                                Approve Article
                            </button>
                            <button type="submit" name="action" value="revise" onclick="return window.confirm('Apakah Anda yakin ingin meminta revisi artikel ini?');" class="inline-flex items-center justify-center font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-md px-4 py-2 text-sm bg-rose-600 text-white hover:bg-rose-700 focus:ring-rose-600">
                                Request Revision
                            </button>
                        </div>
                    </div>
                </form>
            </x-ui.card>
        @endif

        @if(auth()->user()->role === 'superadmin' && $news->status === 'approved')
            <x-ui.card class="border-t-4 border-t-emerald-400">
                <x-slot name="header">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Publish Article</h3>
                </x-slot>
                
                <form action="{{ route('admin.news.review', $news) }}" method="POST">
                    @csrf
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <p class="text-sm text-gray-600">This article has been approved and is ready to be published to the public website.</p>
                        <button type="submit" name="action" value="publish" onclick="return window.confirm('Apakah Anda yakin ingin mempublikasikan artikel ini?');" class="inline-flex items-center justify-center font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-md px-4 py-2 text-sm bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-600">
                            Publish Now
                        </button>
                    </div>
                </form>
            </x-ui.card>
        @endif
    </div>
    
    @push('scripts')
    @vite(['resources/js/editor.js'])
    @endpush
</x-app-layout>
