<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                {{ __('Dashboard') }}
            </h2>
            <div class="text-sm text-gray-500">
                {{ now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Stats Grid - Miller's Law: Chunked into 6 digestible items -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <!-- Total Articles -->
            <x-ui.card class="border-l-4 border-l-gray-900 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-2">Total</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</div>
                        <div class="text-xs text-gray-400 mt-1">Artikel</div>
                    </div>
                    <div class="p-2 bg-gray-100 rounded-lg">
                        <i class="ri-file-list-3-line text-xl text-gray-600"></i>
                    </div>
                </div>
            </x-ui.card>

            <!-- Drafts -->
            <x-ui.card class="border-l-4 border-l-gray-400 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-2">Draft</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $stats['draft'] }}</div>
                        <div class="text-xs text-gray-400 mt-1">Tersimpan</div>
                    </div>
                    <div class="p-2 bg-gray-100 rounded-lg">
                        <i class="ri-draft-line text-xl text-gray-600"></i>
                    </div>
                </div>
            </x-ui.card>

            <!-- Pending Review -->
            <x-ui.card class="border-l-4 border-l-amber-400 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-2">Pending</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $stats['pending'] }}</div>
                        <div class="text-xs text-gray-400 mt-1">Menunggu</div>
                    </div>
                    <div class="p-2 bg-amber-50 rounded-lg">
                        <i class="ri-time-line text-xl text-amber-600"></i>
                    </div>
                </div>
            </x-ui.card>

            <!-- Revision Needed -->
            <x-ui.card class="border-l-4 border-l-rose-400 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-2">Revisi</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $stats['revision'] }}</div>
                        <div class="text-xs text-gray-400 mt-1">Perlu Perbaikan</div>
                    </div>
                    <div class="p-2 bg-rose-50 rounded-lg">
                        <i class="ri-error-warning-line text-xl text-rose-600"></i>
                    </div>
                </div>
            </x-ui.card>

            <!-- Published -->
            <x-ui.card class="border-l-4 border-l-emerald-400 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-2">Terbit</div>
                        <div class="text-3xl font-bold text-gray-900">{{ $stats['published'] }}</div>
                        <div class="text-xs text-gray-400 mt-1">Dipublikasi</div>
                    </div>
                    <div class="p-2 bg-emerald-50 rounded-lg">
                        <i class="ri-check-double-line text-xl text-emerald-600"></i>
                    </div>
                </div>
            </x-ui.card>

            <!-- Total Views -->
            <x-ui.card class="border-l-4 border-l-blue-400 hover:shadow-md transition-shadow duration-200">
                <div class="flex items-start justify-between">
                    <div>
                        <div class="text-gray-500 text-xs font-semibold uppercase tracking-wider mb-2">Views</div>
                        <div class="text-3xl font-bold text-gray-900">
                            @php
                                $views = $stats['total_views'];
                                if ($views >= 1000000) {
                                    echo number_format($views / 1000000, 1) . 'M';
                                } elseif ($views >= 1000) {
                                    echo number_format($views / 1000, 1) . 'K';
                                } else {
                                    echo number_format($views);
                                }
                            @endphp
                        </div>
                        <div class="text-xs text-gray-400 mt-1">Total Pembaca</div>
                    </div>
                    <div class="p-2 bg-blue-50 rounded-lg">
                        <i class="ri-eye-line text-xl text-blue-600"></i>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Quick Actions - Fitts's Law: Large, easy-to-click targets -->
        <x-ui.card>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.news.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors font-medium text-sm shadow-sm">
                    <i class="ri-add-line text-lg"></i>
                    <span>Buat Artikel Baru</span>
                </a>

                @if(auth()->user()->role === 'superadmin' && $stats['pending'] > 0)
                    <a href="{{ route('admin.news.index') }}?status=pending"
                       class="inline-flex items-center gap-2 px-5 py-3 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors font-medium text-sm shadow-sm">
                        <i class="ri-file-search-line text-lg"></i>
                        <span>Review {{ $stats['pending'] }} Artikel</span>
                    </a>
                @endif

                @if($stats['revision'] > 0)
                    <a href="{{ route('admin.news.index') }}?status=revision"
                       class="inline-flex items-center gap-2 px-5 py-3 bg-rose-500 text-white rounded-lg hover:bg-rose-600 transition-colors font-medium text-sm shadow-sm">
                        <i class="ri-edit-box-line text-lg"></i>
                        <span>{{ $stats['revision'] }} Perlu Revisi</span>
                    </a>
                @endif

                <a href="{{ route('admin.news.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-3 bg-white border-2 border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium text-sm">
                    <i class="ri-list-check text-lg"></i>
                    <span>Semua Artikel</span>
                </a>
            </div>
        </x-ui.card>

        <!-- Two Column Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Most Viewed Articles -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-semibold leading-6 text-gray-900 flex items-center gap-2">
                            <i class="ri-fire-line text-orange-500"></i>
                            Artikel Terpopuler
                        </h3>
                        <span class="text-xs text-gray-500">Berdasarkan Views</span>
                    </div>
                </x-slot>

                @if($mostViewed->isEmpty())
                    <div class="text-center py-8">
                        <i class="ri-eye-off-line text-4xl text-gray-300 mb-2"></i>
                        <p class="text-sm text-gray-500">Belum ada artikel yang dilihat</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($mostViewed as $index => $article)
                            <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-gradient-to-br from-orange-400 to-pink-500 flex items-center justify-center text-white font-bold text-sm">
                                    {{ $index + 1 }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('admin.news.edit', $article) }}"
                                       class="font-medium text-sm text-gray-900 hover:text-blue-600 line-clamp-2 mb-1">
                                        {{ $article->title }}
                                    </a>
                                    <div class="flex items-center gap-3 text-xs text-gray-500">
                                        @if($article->category)
                                            <span class="px-2 py-0.5 bg-gray-100 rounded-full">{{ $article->category->name }}</span>
                                        @endif
                                        <span class="flex items-center gap-1">
                                            <i class="ri-eye-line"></i>
                                            {{ number_format($article->views) }} views
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-ui.card>

            <!-- Recent Articles -->
            <x-ui.card>
                <x-slot name="header">
                    <div class="flex items-center justify-between">
                        <h3 class="text-base font-semibold leading-6 text-gray-900 flex items-center gap-2">
                            <i class="ri-time-line text-blue-500"></i>
                            Aktivitas Terbaru
                        </h3>
                        <x-ui.button variant="link" href="{{ route('admin.news.index') }}" class="text-sm">
                            Lihat Semua &rarr;
                        </x-ui.button>
                    </div>
                </x-slot>

                @if($recentNews->isEmpty())
                    <div class="text-center py-8">
                        <i class="ri-file-list-3-line text-4xl text-gray-300 mb-2"></i>
                        <p class="text-sm text-gray-500 mb-3">Belum ada artikel</p>
                        <a href="{{ route('admin.news.create') }}"
                           class="inline-flex items-center gap-1 text-sm text-blue-600 hover:text-blue-700 font-medium">
                            <i class="ri-add-line"></i>
                            Buat Artikel Pertama
                        </a>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($recentNews as $item)
                            <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors border-l-2 {{
                                $item->status === 'published' ? 'border-emerald-400' :
                                ($item->status === 'pending' ? 'border-amber-400' :
                                ($item->status === 'revision' ? 'border-rose-400' : 'border-gray-300'))
                            }}">
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('admin.news.edit', $item) }}"
                                       class="font-medium text-sm text-gray-900 hover:text-blue-600 line-clamp-2 mb-1">
                                        {{ $item->title }}
                                    </a>
                                    <div class="flex items-center gap-2 text-xs text-gray-500 flex-wrap">
                                        <x-ui.badge :status="$item->status" />
                                        <span>&middot;</span>
                                        <span>{{ $item->author->name }}</span>
                                        <span>&middot;</span>
                                        <span>{{ $item->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>
</x-app-layout>
