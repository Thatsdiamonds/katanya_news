<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Kata&sup2;-nya. - @yield('title', 'Latest News')</title>

        <!-- Self-hosted fonts from public/fonts -->
        @include('partials.fonts')

        <!-- Remix Icon CDN -->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            [x-cloak] { display: none !important; }
            /* Hide scrollbar for category list */
            .hide-scrollbar::-webkit-scrollbar {
                display: none;
            }
            .hide-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#f6f8fc] selection:bg-gray-900 selection:text-white" x-data="categoryPreferences()">
        
        <header class="bg-white border-b border-gray-200 sticky top-0 z-50 transition-shadow duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-14 md:h-16">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="font-serif text-2xl md:text-3xl font-bold tracking-tighter text-gray-900 hover:text-gray-600 transition-colors">
                            Kata<sup class="text-blue-600 text-lg">2</sup>-nya.
                        </a>
                    </div>
                    
                   <!-- Search Bar -->
                    <div class="hidden md:flex flex-1 max-w-md mx-8">
                        <form action="{{ route('home') }}" method="GET" class="w-full">
                            <div class="flex items-center w-full px-3.5 py-2 bg-gray-50 border border-gray-200 rounded-full text-gray-400 focus-within:text-gray-900 focus-within:bg-white focus-within:ring-2 focus-within:ring-gray-900 focus-within:border-transparent transition-all gap-2">
                                
                                <div class="flex items-center justify-center shrink-0 mr-2.5">
                                    <i class="ri-search-2-line text-base leading-none block"></i>
                                </div>

                                <input type="text" name="search" placeholder="Cari artikel atau topik..." value="{{ request('search') }}" 
                                    class="w-full p-0 bg-transparent border-none text-sm placeholder-gray-400 focus:outline-none focus:ring-0">
                                    
                            </div>
                        </form>
                    </div>

                    <div class="flex items-center space-x-6 text-sm font-medium">
                        @auth
                            <a href="{{ url('/admin') }}" class="text-gray-600 hover:text-gray-900 transition-colors flex items-center gap-1.5">
                                <i class="ri-dashboard-3-line text-base text-gray-500"></i>
                                <span>Dashboard</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 transition-colors flex items-center gap-1.5">
                                <i class="ri-user-3-line text-base text-gray-500"></i>
                                <span>Masuk</span>
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Category Navbar -->
                @php
                    $navCategories = \App\Models\Category::withCount(['news' => function ($q) {
                        $q->where('status', 'published');
                    }])->orderByDesc('news_count')->get();
                @endphp
                <div class="py-2 overflow-x-auto hide-scrollbar">
                    <div class="flex items-center gap-1.5 min-w-max text-[11px]">
                        <a href="{{ route('home') }}" 
                           class="px-3 py-1 rounded-full font-semibold tracking-wide {{ !request('category') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 hover:text-gray-900' }}">
                            Semua Berita
                        </a>
                        @foreach($navCategories as $cat)
                            @php $isActive = (request('category') == $cat->slug || request('category') == $cat->name); @endphp
                            <a href="{{ route('home', ['category' => $cat->slug]) }}" 
                               class="px-2.5 py-1 rounded-full {{ $isActive ? 'bg-blue-600 text-white font-semibold' : 'bg-gray-50 text-gray-600 hover:text-gray-900 border border-gray-200/60 font-medium' }}">
                                #{{ $cat->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </header>



        <main class="min-h-screen">
            @yield('content')
        </main>

        <footer class="bg-white border-t border-gray-200/80 py-6 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <span class="font-serif text-xl font-bold tracking-tighter text-gray-900">Kata<sup class="text-blue-600 text-sm">2</sup>-nya.</span>
                    </div>

                    @if(isset($navCategories) && $navCategories->count() > 0)
                        <div class="flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-xs text-gray-500 font-medium">
                            @foreach($navCategories->take(6) as $fCat)
                                <a href="{{ route('home', ['category' => $fCat->slug]) }}" class="hover:text-blue-600 transition-colors">
                                    {{ $fCat->name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </footer>

        <!-- Lenis Smooth Scroll -->
        <script src="https://unpkg.com/lenis@1.1.9/dist/lenis.min.js"></script>
        <script>
            // Initialize Lenis properly
            const lenis = new Lenis({
                duration: 1.2,
                easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t))
            });

            function raf(time) {
                lenis.raf(time);
                requestAnimationFrame(raf);
            }
            requestAnimationFrame(raf);

            // AlpineJS Data Store for Followed Categories
            document.addEventListener('alpine:init', () => {
                Alpine.data('categoryPreferences', () => ({
                    followedCategories: JSON.parse(localStorage.getItem('followedCategories')) || [],
                    toggleCategory(cat) {
                        if (this.followedCategories.includes(cat)) {
                            this.followedCategories = this.followedCategories.filter(c => c !== cat);
                        } else {
                            this.followedCategories.push(cat);
                        }
                        localStorage.setItem('followedCategories', JSON.stringify(this.followedCategories));
                    },
                    scrollToPreferences() {
                        const el = document.getElementById('preferensi-kategori');
                        if (el) {
                            if (typeof lenis !== 'undefined' && lenis) {
                                lenis.scrollTo(el, { offset: -70, duration: 1.2 });
                            } else {
                                el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                            }
                        }
                    }
                }));
            });
        </script>
    </body>
</html>

