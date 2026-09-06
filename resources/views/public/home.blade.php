@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6 py-3">

    @if(request('search'))
        <div class="mb-4 pb-1.5 border-b border-gray-200">
            <h2 class="font-serif text-lg text-gray-900">Hasil pencarian untuk: <span class="font-bold italic text-blue-600">"{{ request('search') }}"</span></h2>
        </div>
    @endif

    @if($news->isEmpty())
        <div class="text-center py-12 rounded-xl border border-gray-200 bg-white shadow-xs">
            <svg class="mx-auto h-9 w-9 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11l3 3L22 4"></path></svg>
            <p class="text-sm font-semibold text-gray-700">Belum ada artikel yang ditemukan.</p>
            <p class="text-[11px] text-gray-400 mt-0.5">Coba sesuaikan kata kunci pencarian atau filter kategori Anda.</p>
        </div>
    @else
        
        @if($news->onFirstPage() && !request('search') && !request('category') && $news->count() > 0)
            @php 
                $hero = $news->first(); 
                $latest = $news->slice(1, 2);
                $recommended = $news->slice(3, 4);
                $trending = $news->slice(7, 6);
            @endphp
            
            <!-- Page Header: Indonesian date directly under Title without filler text -->
            <div class="mb-3.5 border-b border-gray-200/80 pb-2">
                <h1 class="text-xl md:text-2xl font-serif font-bold text-gray-900 tracking-tight leading-tight flex items-center gap-2">
                    <i class="ri-newspaper-line text-blue-600 text-xl font-normal"></i>
                    <span>Rangkuman untuk Anda</span>
                </h1>
                <p class="text-xs text-gray-500 font-medium mt-0.5 capitalize">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 mb-5 items-start">
                
                <!-- Left Column (8 cols) -->
                <div class="lg:col-span-8 flex flex-col gap-6">
                    
                    <!-- Section: Terbaru -->
                    <div>
                        <div class="mb-2.5">
                            <h2 class="text-xl md:text-2xl font-bold font-serif text-gray-900 tracking-tight flex items-center gap-2">
                                <i class="ri-flashlight-line text-amber-500 text-lg font-normal"></i>
                                <span>Terbaru</span>
                            </h2>
                        </div>
                        <div class="bg-white p-4 rounded-xl shadow-xs border border-gray-200/70">
                            
                            <!-- Hero Article -->
                            <article class="mb-4 group">
                                <a href="{{ route('news.show', $hero->slug) }}" class="block overflow-hidden rounded-lg mb-2.5 bg-[#f6f8fc] border border-gray-200/60">
                                    @if($hero->image)
                                        <img src="{{ Storage::url($hero->image) }}" alt="{{ $hero->title }}" class="w-full aspect-[21/9] sm:aspect-[16/8] max-h-[220px] object-cover" loading="lazy">
                                    @else
                                        <div class="w-full aspect-[21/9] sm:aspect-[16/8] max-h-[220px] bg-[#f6f8fc] flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-10 h-10 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span class="font-serif text-xs">Tidak ada gambar</span>
                                        </div>
                                    @endif
                                </a>
                                
                                <div class="flex items-center gap-1.5 mb-1 text-[11px]">
                                    @if($hero->category)
                                        <a href="{{ route('home', ['category' => $hero->category->slug]) }}" class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-blue-50 text-blue-700 hover:underline">#{{ $hero->category->name }}</a>
                                    @endif
                                    <span class="text-gray-300">&bull;</span>
                                    <x-news-date :date="$hero->published_at" class="text-gray-400" />
                                </div>

                                <a href="{{ route('news.show', $hero->slug) }}" class="block">
                                    <h3 class="font-serif text-lg md:text-xl font-bold leading-snug text-gray-900 group-hover:underline transition-none tracking-tight">{{ $hero->title }}</h3>
                                </a>
                                <p class="mt-1 text-gray-600 text-xs leading-relaxed line-clamp-2">{{ $hero->excerpt ?? strip_tags($hero->content) }}</p>
                                
                                <div class="mt-2.5 pt-2 flex items-center justify-between text-[11px] text-gray-500">
                                    <div class="flex items-center">
                                        <div class="h-5 w-5 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center mr-1.5 text-[10px]">
                                            {{ substr($hero->author->name, 0, 1) }}
                                        </div>
                                        <span class="font-semibold text-gray-800">{{ $hero->author->name }}</span>
                                    </div>
                                </div>
                            </article>

                            <!-- Latest Articles (Smaller List Style) -->
                            @if($latest->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-3 border-t border-gray-100">
                                @foreach($latest as $item)
                                <article class="group flex gap-2.5 items-start bg-[#f8fafc]/80 p-2.5 rounded-lg border border-gray-100/80">
                                    <div class="flex-1 min-w-0">
                                        @if($item->category)
                                            <a href="{{ route('home', ['category' => $item->category->slug]) }}" class="text-[10px] text-blue-600 font-bold mb-0.5 truncate block hover:underline">#{{ $item->category->name }}</a>
                                        @endif
                                        <a href="{{ route('news.show', $item->slug) }}" class="block">
                                            <h4 class="font-serif text-xs font-bold text-gray-900 group-hover:underline transition-none line-clamp-2 leading-tight">{{ $item->title }}</h4>
                                        </a>
                                        <div class="text-[10px] text-gray-400 mt-1.5 flex items-center justify-between">
                                            <span class="font-medium text-gray-700 truncate max-w-[80px]">{{ $item->author->name }}</span>
                                            <x-news-date :date="$item->published_at" />
                                        </div>
                                    </div>
                                    <a href="{{ route('news.show', $item->slug) }}" class="w-14 h-14 flex-shrink-0 overflow-hidden rounded-md block bg-[#f6f8fc] border border-gray-200/60">
                                        @if($item->image)
                                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover" loading="lazy">
                                        @else
                                            <div class="w-full h-full bg-[#f6f8fc] flex items-center justify-center text-gray-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                    </a>
                                </article>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Section: Mungkin Kamu Sukai (Berdasarkan Preferensi Kategori yang Diikuti) -->
                    <div x-data="{
                        pool: {{ Js::from($categoryNewsPool ?? []) }},
                        get recommendedNews() {
                            if (!followedCategories || followedCategories.length === 0) {
                                return [];
                            }
                            return this.pool.filter(item => followedCategories.includes(item.category_name)).slice(0, 4);
                        }
                    }">
                        <div class="mb-2.5 flex items-center justify-between">
                            <div>
                                <h2 class="text-xl md:text-2xl font-bold font-serif text-gray-900 tracking-tight flex items-center gap-2">
                                    <i class="ri-sparkling-line text-indigo-500 text-lg font-normal"></i>
                                    <span>Mungkin Kamu Sukai</span>
                                </h2>
                                <p class="text-xs text-gray-500 font-medium mt-0.5">Disarankan menurut minat Anda</p>
                            </div>
                            
                            <!-- Badges of followed categories if any -->
                            <div x-show="followedCategories && followedCategories.length > 0" class="hidden sm:flex items-center gap-1.5 flex-wrap justify-end">
                                <span class="text-[10px] text-gray-400 font-medium">Minat Anda:</span>
                                <template x-for="catName in followedCategories.slice(0, 3)" :key="catName">
                                    <span class="inline-flex items-center gap-1 text-[10px] font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-100">
                                        <i class="ri-star-fill text-[9px] text-amber-500"></i>
                                        <span x-text="catName"></span>
                                    </span>
                                </template>
                                <span x-show="followedCategories.length > 3" class="text-[10px] text-gray-400" x-text="'+' + (followedCategories.length - 3)"></span>
                            </div>
                        </div>

                        <!-- Empty State: Ketika belum ada kategori yang diikuti ATAU tidak ada artikel yang cocok -->
                        <div x-show="!followedCategories || followedCategories.length === 0 || recommendedNews.length === 0" 
                             class="bg-white p-6 sm:p-8 rounded-xl shadow-xs border border-gray-200/70 text-center">
                            <div class="mx-auto w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mb-3 border border-blue-100/60 shadow-2xs">
                                <i class="ri-compass-3-line text-2xl"></i>
                            </div>
                            <h3 class="font-serif text-base font-bold text-gray-900 mb-1">Tentukan Kategori Minat Anda</h3>
                            <p class="text-xs text-gray-500 max-w-md mx-auto mb-4 leading-relaxed">
                                Belum ada artikel rekomendasi. Pilih kategori yang Anda sukai di bagian Preferensi Kategori untuk melihat berita yang disesuaikan secara khusus.
                            </p>
                            <button type="button" 
                                    @click="scrollToPreferences()" 
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-full shadow-xs hover:shadow-sm transition-all cursor-pointer">
                                <span>Tentukan Kategori yang Anda Suka</span>
                                <i class="ri-arrow-down-line text-xs"></i>
                            </button>
                        </div>

                        <!-- Active State: Menampilkan Artikel Berdasarkan Kategori yang Diikuti -->
                        <div x-show="followedCategories && followedCategories.length > 0 && recommendedNews.length > 0" 
                             class="bg-white p-4 rounded-xl shadow-xs border border-gray-200/70">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <template x-for="item in recommendedNews" :key="item.id">
                                    <article class="group flex flex-col h-full bg-[#f8fafc]/60 p-2.5 rounded-lg border border-gray-100">
                                        <a :href="item.url" class="block overflow-hidden rounded-md mb-2 bg-[#f6f8fc] aspect-[16/9] border border-gray-200/60">
                                            <template x-if="item.image">
                                                <img :src="item.image" :alt="item.title" class="w-full h-full object-cover" loading="lazy">
                                            </template>
                                            <template x-if="!item.image">
                                                <div class="w-full h-full bg-[#f6f8fc] flex items-center justify-center text-gray-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            </template>
                                        </a>

                                        <template x-if="item.category_name">
                                            <a :href="item.category_url" class="text-[10px] text-blue-600 font-bold mb-0.5 hover:underline" x-text="'#' + item.category_name"></a>
                                        </template>

                                        <a :href="item.url" class="block mb-1.5 flex-1">
                                            <h4 class="font-serif text-[11px] font-bold leading-snug text-gray-900 group-hover:underline transition-none line-clamp-3" x-text="item.title"></h4>
                                        </a>

                                        <div class="text-[9px] text-gray-400 mt-auto pt-1.5 flex items-center justify-between" :title="item.exact_date">
                                            <span class="truncate max-w-[85px] font-medium text-gray-600" x-text="item.author"></span>
                                            <div class="flex items-center gap-1">
                                                <span x-text="item.time_ago"></span>
                                                <span x-show="item.is_outside_recent" class="opacity-40 text-[8px]" x-text="'(' + item.exact_date + ')'"></span>
                                            </div>
                                        </div>
                                    </article>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column (4 cols) -->
                <div class="lg:col-span-4 flex flex-col gap-6">
                    
                    <!-- Section: Tren Berdasar Kategori -->
                    <div>
                        <div class="mb-2.5">
                            <h2 class="text-xl md:text-2xl font-bold font-serif text-gray-900 tracking-tight flex items-center gap-2">
                                <i class="ri-fire-line text-rose-500 text-lg font-normal"></i>
                                <span>Tren Berdasar Kategori</span>
                            </h2>
                        </div>
                        <div class="bg-white p-3.5 rounded-xl shadow-xs border border-gray-200/70">
                            @if($trending->count() > 0)
                                <div class="flex flex-col gap-2.5">
                                    @foreach($trending as $item)
                                    <article class="group flex gap-2.5 items-start pb-2.5 border-b border-gray-100 last:border-b-0 last:pb-0">
                                        <div class="flex-1 min-w-0">
                                            @if($item->category)
                                                <a href="{{ route('home', ['category' => $item->category->slug]) }}" class="text-[10px] text-blue-600 font-bold mb-0.5 truncate block hover:underline">#{{ $item->category->name }}</a>
                                            @endif
                                            <a href="{{ route('news.show', $item->slug) }}" class="block">
                                                <h4 class="font-serif text-xs font-bold text-gray-900 group-hover:underline transition-none line-clamp-2 leading-tight">{{ $item->title }}</h4>
                                            </a>
                                            <p class="text-[10px] text-gray-400 mt-1"><x-news-date :date="$item->published_at" /></p>
                                        </div>
                                        <a href="{{ route('news.show', $item->slug) }}" class="w-14 h-14 flex-shrink-0 overflow-hidden rounded-md block bg-[#f6f8fc] border border-gray-200/60">
                                            @if($item->image)
                                                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover" loading="lazy">
                                            @else
                                                <div class="w-full h-full bg-[#f6f8fc] flex items-center justify-center text-gray-400">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                        </a>
                                    </article>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-[11px] text-gray-400">Belum ada artikel lain yang sedang tren.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Section: Sorotan Redaksi -->
                    @if(isset($editorPicks) && $editorPicks->count() > 0)
                    <div>
                        <div class="mb-2.5">
                            <h2 class="text-xl md:text-2xl font-bold font-serif text-gray-900 tracking-tight flex items-center gap-2">
                                <i class="ri-bookmark-star-line text-blue-600 text-lg font-normal"></i>
                                <span>Sorotan Redaksi</span>
                            </h2>
                        </div>
                        <div class="bg-white p-3.5 rounded-xl shadow-xs border border-gray-200/70">
                            <div class="flex flex-col gap-2.5">
                                @foreach($editorPicks as $index => $item)
                                <article class="group flex gap-2.5 items-start pb-2.5 border-b border-gray-100 last:border-b-0 last:pb-0">
                                    <span class="font-serif text-sm font-black text-blue-600/80 w-4 flex-shrink-0 pt-0.5">0{{ $index + 1 }}</span>
                                    <div class="flex-1 min-w-0">
                                        @if($item->category)
                                            <a href="{{ route('home', ['category' => $item->category->slug]) }}" class="text-[10px] text-blue-600 font-bold mb-0.5 truncate block hover:underline">#{{ $item->category->name }}</a>
                                        @endif
                                        <a href="{{ route('news.show', $item->slug) }}" class="block">
                                            <h4 class="font-serif text-xs font-bold text-gray-900 group-hover:underline transition-none line-clamp-2 leading-tight">{{ $item->title }}</h4>
                                        </a>
                                        <div class="text-[10px] text-gray-400 mt-1 flex items-center justify-between">
                                            <span class="font-medium text-gray-600 truncate max-w-[80px]">{{ $item->author->name }}</span>
                                            <x-news-date :date="$item->published_at" />
                                        </div>
                                    </div>
                                </article>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- News Berhubungan dengan Teknologi Waktu Terbaru -->
            @if(isset($technologyNews) && $technologyNews->count() > 0)
            <div class="mb-5">
                <div class="mb-2.5 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl md:text-2xl font-bold font-serif text-gray-900 tracking-tight flex items-center gap-2">
                            <i class="ri-cpu-line text-cyan-600 text-lg font-normal"></i>
                            <span>Teknologi Terkini</span>
                        </h2>
                    </div>
                    @php 
                        $techCat = $categories->first(fn($c) => stripos($c->name, 'tekno') !== false || stripos($c->slug, 'tech') !== false);
                    @endphp
                    @if($techCat)
                        <a href="{{ route('home', ['category' => $techCat->slug]) }}" class="text-blue-600 text-[11px] font-bold hover:underline flex items-center gap-0.5">
                            Semua Berita &rarr;
                        </a>
                    @endif
                </div>
                <div class="bg-white p-4 rounded-xl shadow-xs border border-gray-200/70">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        @foreach($technologyNews as $item)
                        <article class="group flex flex-col h-full bg-[#f8fafc] p-2.5 rounded-lg border border-gray-100">
                            <a href="{{ route('news.show', $item->slug) }}" class="block overflow-hidden rounded-md mb-2 bg-[#f1f5f9] aspect-[16/9] border border-gray-200/60">
                                @if($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover" loading="lazy">
                                @else
                                    <div class="w-full h-full bg-[#f1f5f9] flex items-center justify-center text-gray-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </a>
                            @if($item->category)
                                <a href="{{ route('home', ['category' => $item->category->slug]) }}" class="text-blue-600 text-[10px] font-bold mb-0.5 hover:underline">#{{ $item->category->name }}</a>
                            @endif
                            <a href="{{ route('news.show', $item->slug) }}" class="block mb-1.5 flex-1">
                                <h4 class="font-serif text-xs font-bold leading-snug text-gray-900 group-hover:underline transition-none line-clamp-2">{{ $item->title }}</h4>
                            </a>
                            <div class="text-[10px] text-gray-400 mt-auto flex items-center justify-between pt-1 border-t border-gray-200/60">
                                <span class="truncate max-w-[90px]">{{ $item->author->name }}</span>
                                <x-news-date :date="$item->published_at" />
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Trending per Kategori Section -->
            @if(isset($trendingByCategory) && $trendingByCategory->count() > 0)
            <div class="mb-5">
                <div class="mb-2.5">
                    <h2 class="text-xl md:text-2xl font-bold font-serif text-gray-900 tracking-tight flex items-center gap-2">
                        <i class="ri-fire-line text-orange-500 text-lg font-normal"></i>
                        <span>Trending per Kategori</span>
                    </h2>
                    <p class="text-xs text-gray-500 mt-0.5">Artikel paling banyak dilihat 7 hari terakhir</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($trendingByCategory as $item)
                    <div class="bg-white p-4 rounded-xl shadow-xs border border-gray-200/70">
                        <!-- Category Header -->
                        <div class="flex items-center justify-between mb-3 pb-2 border-b border-gray-100">
                            <a href="{{ route('home', ['category' => $item['category']->slug]) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg text-sm font-bold hover:from-blue-600 hover:to-blue-700 transition-all shadow-sm">
                                <i class="ri-hashtag text-xs"></i>
                                {{ $item['category']->name }}
                            </a>
                            <span class="text-xs text-gray-400">{{ $item['category']->news_count }} artikel</span>
                        </div>

                        <!-- Trending Articles List -->
                        <div class="space-y-3">
                            @foreach($item['articles'] as $index => $article)
                            <article class="group flex items-start gap-3">
                                <div class="flex-shrink-0 w-6 h-6 rounded-full bg-gradient-to-br from-orange-400 to-pink-500 flex items-center justify-center text-white font-bold text-xs">
                                    {{ $index + 1 }}
                                </div>

                                <!-- Article Image -->
                                @if($article->image)
                                <a href="{{ route('news.show', $article->slug) }}" class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden bg-gray-100 border border-gray-200">
                                    <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200" loading="lazy">
                                </a>
                                @endif

                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('news.show', $article->slug) }}" class="block">
                                        <h4 class="font-serif text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2 leading-tight mb-1">
                                            {{ $article->title }}
                                        </h4>
                                    </a>
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <i class="ri-eye-line text-xs"></i>
                                            {{ $article->formatted_views }}
                                        </span>
                                        <span>&middot;</span>
                                        <x-news-date :date="$article->published_at" />
                                    </div>
                                </div>
                            </article>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Preferensi Kategori Section (Restored Original Layout with Starred Priority) -->
            <div id="preferensi-kategori" class="bg-white p-4 rounded-xl shadow-xs border border-gray-200/70 mb-5">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-3.5 items-center">
                    <div class="md:col-span-3 border-b md:border-b-0 md:border-r border-gray-100 pb-3 md:pb-0 pr-0 md:pr-4 flex flex-col justify-between">
                        <div>
                            <div class="mb-1.5 inline-flex h-7 w-7 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                            </div>
                            <h3 class="text-base font-serif font-bold text-gray-900 leading-tight">Preferensi Kategori</h3>
                            <p class="text-gray-500 text-[11px] leading-tight mt-0.5">Top kategori pilihan untuk Anda.</p>
                        </div>
                        <!-- Scroll Navigation Arrows -->
                        <div class="hidden md:flex items-center gap-1.5 mt-3 pt-2 ">
                            <span class="text-[10px] text-gray-400 font-medium">Geser:</span>
                            <button type="button" @click="$refs.prefCatTrack.scrollBy({ left: -260, behavior: 'smooth' })" class="h-6 w-6 rounded-full bg-white border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 flex items-center justify-center shadow-xs transition-colors" title="Geser Kiri">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <button type="button" @click="$refs.prefCatTrack.scrollBy({ left: 260, behavior: 'smooth' })" class="h-6 w-6 rounded-full bg-white border border-gray-200 text-gray-600 hover:text-gray-900 hover:bg-gray-50 flex items-center justify-center shadow-xs transition-colors" title="Geser Kanan">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Horizontal Scrollable Category Cards (min-w-0 for flex/grid overflow-x-auto) -->
                    <div class="md:col-span-9 min-w-0">
                        <div x-ref="prefCatTrack" class="flex overflow-x-auto pb-2 pt-0.5 gap-3 flex-nowrap scroll-smooth" style="scrollbar-width: thin;">
                        @php 
                            $prefCategories = isset($topCategories) && $topCategories->count() > 0 ? $topCategories : $categories;
                        @endphp
                        @foreach($prefCategories as $cat)
                        @php 
                            $catNewsList = \App\Models\News::where('category_id', $cat->id)->where('status', 'published')->latest('published_at')->take(3)->get(); 
                        @endphp
                        <div :style="followedCategories.includes('{{ $cat->name }}') ? 'order: -1' : 'order: 0'"
                             class="flex-shrink-0 w-64 bg-white border border-gray-200/80 rounded-2xl p-3.5 flex flex-col justify-between group shadow-xs">
                            <div>
                                <!-- Header: Category & Ikuti Button (Pill with Star matching Google News) -->
                                <div class="flex justify-between items-center mb-2.5 gap-2">
                                    <h4 class="font-serif text-sm font-bold text-gray-900 truncate max-w-[125px]">{{ $cat->name }}</h4>
                                    <button @click="toggleCategory('{{ $cat->name }}')" 
                                            :class="followedCategories.includes('{{ $cat->name }}') 
                                                ? 'bg-blue-50 text-blue-700 border-blue-200' 
                                                : 'bg-white text-gray-700 hover:bg-gray-50 border-gray-200'"
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium border shadow-2xs transition-colors flex-shrink-0" 
                                            title="Ikuti {{ $cat->name }}">
                                        <i :class="followedCategories.includes('{{ $cat->name }}') ? 'ri-star-fill text-amber-500' : 'ri-star-line text-gray-400'" class="text-xs"></i>
                                        <span x-text="followedCategories.includes('{{ $cat->name }}') ? 'Mengikuti' : 'Ikuti'">Ikuti</span>
                                    </button>
                                </div>
                                
                                @if($catNewsList->count() > 0)
                                    <div class="flex flex-col gap-2.5 mb-2">
                                        @foreach($catNewsList as $catNews)
                                        <a href="{{ route('news.show', $catNews->slug) }}" class="flex gap-2.5 items-start group/item">
                                            <div class="flex-1 min-w-0">
                                                <h5 class="font-serif text-xs font-bold text-gray-900 line-clamp-2 leading-snug group-hover/item:underline transition-none">{{ $catNews->title }}</h5>
                                                <p class="text-[9px] text-gray-400 mt-1"><x-news-date :date="$catNews->published_at" /></p>
                                            </div>
                                            @if($catNews->image)
                                                <img src="{{ Storage::url($catNews->image) }}" class="w-14 h-12 object-cover rounded-lg shadow-2xs border border-gray-200/60 flex-shrink-0" alt="">
                                            @endif
                                        </a>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-[10px] text-gray-400 mb-2 leading-snug">Belum ada berita seputar {{ $cat->name }}.</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            @if($news->count() > 10)
                <div class="mb-2.5">
                    <h2 class="text-xl md:text-2xl font-bold font-serif text-gray-900 tracking-tight flex items-center gap-2">
                        <i class="ri-grid-fill text-gray-400 text-base font-normal"></i>
                        <span>Berita Lainnya</span>
                    </h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                    @foreach($news->slice(10) as $item)
                        <!-- Small cards -->
                        <article class="group flex flex-col h-full bg-white p-2.5 rounded-lg shadow-xs border border-gray-200/70">
                            <a href="{{ route('news.show', $item->slug) }}" class="block overflow-hidden rounded-md mb-1.5 bg-[#f6f8fc] aspect-[16/9] border border-gray-200/60">
                                @if($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover" loading="lazy">
                                @else
                                    <div class="w-full h-full bg-[#f6f8fc] flex items-center justify-center text-gray-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </a>
                            <a href="{{ route('news.show', $item->slug) }}" class="block mb-1 flex-1">
                                <h4 class="font-serif text-xs font-bold leading-snug text-gray-900 group-hover:underline transition-none line-clamp-2">{{ $item->title }}</h4>
                            </a>
                            <div class="text-[10px] text-gray-400 mt-auto">
                                <x-news-date :date="$item->published_at" />
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif

        @else
            <!-- Simple Grid Section for Category/Search/Page 2+ -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
                @foreach($news as $item)
                    <article class="group flex flex-col h-full bg-white p-3 rounded-lg border border-gray-200/70 shadow-xs">
                        <a href="{{ route('news.show', $item->slug) }}" class="block overflow-hidden rounded-md mb-2 aspect-[16/9] bg-gray-50 border border-gray-200/60">
                            @if($item->image)
                                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover" loading="lazy">
                            @else
                                <div class="w-full h-full bg-gray-100 flex flex-col items-center justify-center text-gray-400">
                                    <svg class="w-8 h-8 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </a>
                        
                        <div class="flex flex-col flex-1">
                            @if($item->category)
                                <a href="{{ route('home', ['category' => $item->category->slug]) }}" class="text-[10px] font-bold uppercase tracking-wider text-blue-600 mb-1 hover:underline">#{{ $item->category->name }}</a>
                            @endif
                            
                            <a href="{{ route('news.show', $item->slug) }}" class="block mb-1.5 flex-1">
                                <h3 class="font-serif text-sm font-bold leading-snug text-gray-900 group-hover:underline transition-none line-clamp-2">{{ $item->title }}</h3>
                            </a>
                            
                            <p class="text-gray-600 text-xs line-clamp-2 mb-2">{{ $item->excerpt ?? strip_tags($item->content) }}</p>
                            
                            <div class="mt-auto pt-2 border-t border-gray-100 flex items-center justify-between text-[10px] text-gray-400">
                                <span class="font-medium text-gray-800">{{ $item->author->name }}</span>
                                <x-news-date :date="$item->published_at" />
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

        <div class="mt-5 pt-3 border-t border-gray-200">
            {{ $news->links() }}
        </div>

    @endif
</div>
@endsection
