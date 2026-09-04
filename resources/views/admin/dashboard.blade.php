<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="space-y-8">
        <!-- Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <x-ui.card class="border-t-4 border-t-gray-900 rounded-none sm:rounded-lg">
                <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Total Articles</div>
                <div class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</div>
            </x-ui.card>
            <x-ui.card class="border-t-4 border-t-gray-400 rounded-none sm:rounded-lg">
                <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Drafts</div>
                <div class="text-3xl font-bold text-gray-900">{{ $stats['draft'] }}</div>
            </x-ui.card>
            <x-ui.card class="border-t-4 border-t-amber-400 rounded-none sm:rounded-lg">
                <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Pending Review</div>
                <div class="text-3xl font-bold text-gray-900">{{ $stats['pending'] }}</div>
            </x-ui.card>
            <x-ui.card class="border-t-4 border-t-rose-400 rounded-none sm:rounded-lg">
                <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Revision Needed</div>
                <div class="text-3xl font-bold text-gray-900">{{ $stats['revision'] }}</div>
            </x-ui.card>
            <x-ui.card class="border-t-4 border-t-blue-400 rounded-none sm:rounded-lg">
                <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-1">Published</div>
                <div class="text-3xl font-bold text-gray-900">{{ $stats['published'] }}</div>
            </x-ui.card>
        </div>

        <!-- Recent Articles -->
        <x-ui.card>
            <x-slot name="header">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Recent Articles</h3>
                    <x-ui.button variant="link" href="{{ route('admin.news.index') }}" class="text-sm">View All &rarr;</x-ui.button>
                </div>
            </x-slot>

            @if($recentNews->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
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
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Author</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-3 py-3.5 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider sm:pr-6">Last Updated</th>
                        </x-slot>

                        @foreach($recentNews as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm sm:pl-6">
                                    <a href="{{ route('admin.news.edit', $item) }}" class="font-medium text-gray-900 hover:text-blue-600 truncate block max-w-[200px] sm:max-w-xs">{{ $item->title }}</a>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                    {{ $item->author->name }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                    <x-ui.badge :status="$item->status" />
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-right sm:pr-6">
                                    {{ $item->updated_at->diffForHumans() }}
                                </td>
                            </tr>
                        @endforeach
                    </x-ui.table>
                </div>
            @endif
        </x-ui.card>
    </div>
</x-app-layout>
