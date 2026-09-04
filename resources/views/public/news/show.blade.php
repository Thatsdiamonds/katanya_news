@extends('layouts.public')

@section('title', $news->title)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5">
    
    <!-- Main Article Card -->
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb Navigation -->
        <nav class="flex items-center gap-2 text-xs text-gray-400 mb-6 font-medium">
            <a href="{{ route('home') }}" class="hover:text-gray-800 transition-colors flex items-center gap-1">
                <i class="ri-home-4-line text-xs"></i>
                <span>Beranda</span>
            </a>
            <span>/</span>
            @if($news->category)
                <a href="{{ route('home', ['category' => $news->category->slug]) }}" class="hover:text-blue-600 transition-colors">
                    {{ $news->category->name }}
                </a>
                <span>/</span>
            @endif
            <span class="text-gray-700 truncate max-w-xs md:max-w-md">{{ $news->title }}</span>
        </nav>
        <article class="bg-white rounded-2xl p-6 sm:p-10 md:p-12 shadow-sm border border-gray-200/70 mb-10">
            
            <!-- Article Header -->
            <header class="mb-8">
                <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                    @if($news->category)
                        <a href="{{ route('home', ['category' => $news->category->slug]) }}" 
                           class="inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors">
                            #{{ $news->category->name }}
                        </a>
                    @endif

                    <div class="flex items-center gap-2">
                        @if(auth()->check() && (auth()->user()->role === 'superadmin' || auth()->id() === $news->author_id))
                            <span class="px-2.5 py-0.5 text-[11px] font-semibold rounded-md {{ $news->status === 'published' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-800 border border-amber-200' }}">
                                {{ $news->status === 'published' ? 'Terbit' : 'Preview: ' . ucfirst($news->status) }}
                            </span>
                            <a href="{{ route('admin.news.edit', $news) }}" 
                               class="inline-flex items-center gap-1 px-3 py-1 rounded-md text-xs font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                                <i class="ri-edit-line text-xs"></i>
                                <span>Edit Berita</span>
                            </a>
                        @endif
                    </div>
                </div>
            
                <h1 class="font-serif text-3xl sm:text-4xl md:text-5xl font-bold leading-snug sm:leading-tight text-gray-900 tracking-tight mb-5">
                    {{ $news->title }}
                </h1>
                
                @if($news->excerpt)
                    <p class="text-lg md:text-xl text-gray-500 font-serif leading-relaxed mb-6">
                        {{ $news->excerpt }}
                    </p>
                @endif

                <!-- Author & Meta Info Row -->
                <div class="flex items-center justify-between pt-5 border-t border-gray-100 text-xs text-gray-500">
                    <div class="flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-sm shadow-xs">
                            @if($news->author->avatar)
                                <img src="{{ Storage::disk('public')->url($news->author->avatar) }}" alt="{{ $news->author->name }}" class="w-full h-full object-cover rounded-full">
                            @else
                                {{ substr($news->author->name, 0, 1) }}
                            @endif
                        </div>
                        <div>
                            <div class="font-bold text-gray-900 text-sm leading-tight">{{ $news->author->name }}</div>
                            <div class="text-[11px] text-gray-400 mt-0.5 flex items-center gap-1.5">
                                <span>{{ $news->published_at ? $news->published_at->translatedFormat('d F Y') : 'Draft' }}</span>
                                <span>&middot;</span>
                                <i class="ri-time-line text-[11px]"></i>
                                <span>{{ ceil(str_word_count(strip_tags($news->content)) / 200) }} menit baca</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Share Actions -->
                    <div class="flex items-center gap-2" x-data="{ copied: false }">
                        <button @click="navigator.clipboard.writeText(window.location.href); copied = true; setTimeout(() => copied = false, 2000)"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors shadow-xs"
                                title="Salin Tautan">
                            <i :class="copied ? 'ri-check-line text-emerald-600' : 'ri-share-forward-line text-gray-600'" class="text-xs"></i>
                            <span x-text="copied ? 'Tersalin!' : 'Bagikan'">Bagikan</span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Cover Image -->
            @if($news->image)
                <figure class="mb-6 overflow-hidden rounded-lg shadow-xs border border-gray-200/60 bg-[#f6f8fc]">
                    <img src="{{ Storage::url($news->image) }}" alt="{{ $news->title }}" class="w-full aspect-[21/9] sm:aspect-[16/9] max-h-[380px] object-cover">
                </figure>
            @else
                <div class="w-full h-px bg-gray-100 mb-6"></div>
            @endif

            <!-- Article Content -->
            <div class="prose prose-base md:prose-lg font-serif max-w-none prose-p:leading-relaxed prose-p:text-gray-700 prose-a:text-blue-600 hover:underline prose-img:rounded-lg prose-headings:font-bold prose-headings:text-gray-900 prose-headings:tracking-tight prose-blockquote:border-l-4 prose-blockquote:border-blue-500 prose-blockquote:bg-blue-50/40 prose-blockquote:py-2 prose-blockquote:px-4 prose-blockquote:rounded-r-lg prose-blockquote:text-gray-700 prose-blockquote:not-italic">
                {!! $news->content !!}
            </div>

            <!-- Article Footer with Author Bio Card -->
            <footer class="mt-8 pt-6 border-t border-gray-100">
                <div class="bg-[#f8fafc] rounded-lg p-3.5 sm:p-4 border border-gray-200/60 flex flex-col sm:flex-row items-center sm:items-start gap-3 text-center sm:text-left">
                    <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-700 font-bold flex items-center justify-center text-sm flex-shrink-0 shadow-xs">
                        @if($news->author->avatar)
                            <img src="{{ Storage::disk('public')->url($news->author->avatar) }}" alt="{{ $news->author->name }}" class="w-full h-full object-cover rounded-full">
                        @else
                            {{ substr($news->author->name, 0, 1) }}
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-center sm:justify-between mb-0.5">
                            <h4 class="font-bold text-gray-900 text-sm">{{ $news->author->name }}</h4>
                            <span class="text-[10px] font-semibold text-blue-600 bg-blue-50 px-2 py-0.2 rounded-full capitalize">{{ $news->author->role ?? 'Jurnalis' }}</span>
                        </div>
                        <p class="text-[11px] text-gray-500 leading-snug">
                            Penulis dan kontributor editorial di portal berita Kata²-nya, menyajikan liputan mendalam dan berita terpercaya.
                        </p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row justify-between items-center gap-3 mt-6 pt-4 border-t border-gray-100 text-[11px] text-gray-400">
                    <a href="{{ route('home') }}" class="text-blue-600 font-semibold hover:underline inline-flex items-center gap-1">
                        <i class="ri-arrow-left-line text-xs"></i>
                        <span>Kembali ke Rangkuman Berita</span>
                    </a>
                </div>
            </footer>
        </article>
    </div>

    <!-- Related Articles Grid (Compact, No Animations) -->
    @if(isset($relatedNews) && $relatedNews->count() > 0)
    <div class="max-w-4xl mx-auto mt-2 mb-6">
        <div class="flex items-center justify-between mb-3 bg-[#f8fafc] px-3.5 py-2.5 rounded-lg border border-gray-200/80">
            <div class="flex items-center gap-1.5">
                <i class="ri-article-line text-blue-600 text-sm"></i>
                <h3 class="text-sm font-serif font-bold text-gray-900 tracking-tight">Artikel Pilihan Lainnya</h3>
            </div>
            <a href="{{ route('home') }}" class="text-blue-600 text-[11px] font-bold hover:underline inline-flex items-center gap-1">
                <span>Semua Berita</span>
                <i class="ri-arrow-right-line text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
            @foreach($relatedNews as $item)
            <article class="group flex flex-col h-full bg-white p-2.5 rounded-lg border border-gray-200/70 shadow-xs">
                <a href="{{ route('news.show', $item->slug) }}" class="block overflow-hidden rounded-md mb-2 aspect-[16/9] bg-[#f6f8fc] border border-gray-200/60">
                    @if($item->image)
                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover" loading="lazy">
                    @else
                        <div class="w-full h-full bg-[#f6f8fc] flex items-center justify-center text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </a>
                @if($item->category)
                    <a href="{{ route('home', ['category' => $item->category->slug]) }}" class="text-blue-600 text-[10px] font-bold mb-0.5 hover:underline">#{{ $item->category->name }}</a>
                @endif
                <a href="{{ route('news.show', $item->slug) }}" class="block mb-1 flex-1">
                    <h4 class="font-serif text-xs font-bold leading-snug text-gray-900 group-hover:underline transition-none line-clamp-2">{{ $item->title }}</h4>
                </a>
                <div class="text-[10px] text-gray-400 mt-auto flex items-center justify-between pt-1.5 border-t border-gray-100">
                    <span class="font-medium text-gray-700 truncate max-w-[100px]">{{ $item->author->name }}</span>
                    <x-news-date :date="$item->published_at" />
                </div>
            </article>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
