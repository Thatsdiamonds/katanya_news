<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center gap-4">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                {{ __('Articles') }}
            </h2>
            <x-ui.button href="{{ route('admin.news.create') }}" class="ml-4">
                Create Article
            </x-ui.button>
        </div>
    </x-slot>

    <div class="space-y-6">
        @if(session('success'))
            <div class="rounded-md bg-green-50 p-4 ring-1 ring-inset ring-green-600/20">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <x-ui.card>
            @if($news->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3L22 4" />
                    </svg>
                    <h3 class="mt-2 text-sm font-semibold text-gray-900">No articles</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new article.</p>
                </div>
            @else
                <div class="-mx-4 -my-5 sm:-mx-6">
                    <x-ui.table class="border-t border-gray-100">
                        <x-slot name="head">
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider sm:pl-6">Title</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                            @if(auth()->user()->role === 'superadmin')
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Author</th>
                            @endif
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Actions</span>
                            </th>
                        </x-slot>

                        @foreach($news as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 sm:pl-6">
                                    <div class="text-sm font-semibold text-gray-900 max-w-xs truncate">{{ $item->title }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">{{ $item->created_at->format('M d, Y') }}</div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $item->category ? $item->category->name : '-' }}
                                </td>
                                @if(auth()->user()->role === 'superadmin')
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $item->author->name }}
                                </td>
                                @endif
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                    <x-ui.badge :status="$item->status" />
                                    @if($item->status === 'revision')
                                        <div class="text-[10px] text-red-500 mt-1 cursor-help truncate max-w-[100px]" title="{{ $item->rejection_reason }}">{{ Str::limit($item->rejection_reason, 15) }}</div>
                                    @endif
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <div class="flex justify-end space-x-2">
                                        @if(auth()->user()->role === 'superadmin' || $item->author_id === auth()->id())
                                        <x-ui.button variant="ghost" size="sm" href="{{ route('admin.news.preview', $item) }}" target="_blank" title="Preview">
                                            Preview
                                        </x-ui.button>
                                        @endif

                                        @if(auth()->user()->role === 'superadmin' && $item->status === 'approved')
                                        <form method="POST" action="{{ route('admin.news.review', $item) }}" class="inline" onsubmit="return window.confirm('Apakah Anda yakin ingin mempublikasikan artikel ini?');">
                                            @csrf
                                            <input type="hidden" name="action" value="publish">
                                            <x-ui.button type="submit" variant="ghost" size="sm" class="text-emerald-600 hover:text-emerald-800">
                                                Publish
                                            </x-ui.button>
                                        </form>
                                        @endif

                                        @can('update', $item)
                                        <x-ui.button variant="ghost" size="sm" href="{{ route('admin.news.edit', $item) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ (auth()->user()->role === 'superadmin' && $item->status === 'pending') ? 'Review' : 'Edit' }}
                                        </x-ui.button>
                                        @endcan

                                        @can('submit', $item)
                                        <form method="POST" action="{{ route('admin.news.submit', $item) }}" class="inline" onsubmit="return window.confirm('Apakah Anda yakin ingin mengirim artikel ini untuk ditinjau?');">
                                            @csrf
                                            <x-ui.button type="submit" variant="ghost" size="sm" class="text-indigo-600 hover:text-indigo-800">
                                                Submit
                                            </x-ui.button>
                                        </form>
                                        @endcan
                                        
                                        @can('delete', $item)
                                        <form method="POST" action="{{ route('admin.news.destroy', $item) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this draft?');">
                                            @csrf
                                            @method('DELETE')
                                            <x-ui.button type="submit" variant="ghost" size="sm" class="text-red-600 hover:text-red-800">
                                                Delete
                                            </x-ui.button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </x-ui.table>
                </div>
                <div class="mt-4 border-t border-gray-100 pt-4">
                    {{ $news->links() }}
                </div>
            @endif
        </x-ui.card>
    </div>
</x-app-layout>
