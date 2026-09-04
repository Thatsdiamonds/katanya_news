<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title>Kata&sup2;-nya. - <?php echo $__env->yieldContent('title', 'Latest News'); ?></title>

        <!-- Self-hosted fonts from public/fonts -->
        <?php echo $__env->make('partials.fonts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Remix Icon CDN -->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        
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
                        <a href="<?php echo e(route('home')); ?>" class="font-serif text-2xl md:text-3xl font-bold tracking-tighter text-gray-900 hover:text-gray-600 transition-colors">
                            Kata<sup class="text-blue-600 text-lg">2</sup>-nya.
                        </a>
                    </div>
                    
                    <!-- Search Bar -->
                    <div class="hidden md:flex flex-1 max-w-md mx-8">
                        <form action="<?php echo e(route('home')); ?>" method="GET" class="relative w-full group">
                            <input type="text" name="search" placeholder="Cari artikel atau topik..." value="<?php echo e(request('search')); ?>" 
                                class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-full text-sm placeholder-gray-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition-all">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 group-focus-within:text-gray-900 transition-colors">
                                <i class="ri-search-2-line text-sm"></i>
                            </div>
                        </form>
                    </div>

                    <div class="flex items-center space-x-6 text-sm font-medium">
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(url('/admin')); ?>" class="text-gray-600 hover:text-gray-900 transition-colors flex items-center gap-1.5">
                                <span class="h-7 w-7 rounded-full bg-gray-100 ring-1 ring-gray-200 flex items-center justify-center overflow-hidden text-xs font-bold text-gray-600 uppercase">
                                    <?php if(auth()->user()->avatar): ?>
                                        <img src="<?php echo e(Storage::disk('public')->url(auth()->user()->avatar)); ?>" alt="<?php echo e(auth()->user()->name); ?>" class="h-full w-full object-cover">
                                    <?php else: ?>
                                        <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                                    <?php endif; ?>
                                </span>
                                <span>Dashboard</span>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="text-gray-600 hover:text-gray-900 transition-colors flex items-center gap-1.5">
                                <i class="ri-user-3-line text-base text-gray-500"></i>
                                <span>Masuk</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Category Navbar -->
                <?php
                    $navCategories = \App\Models\Category::withCount(['news' => function ($q) {
                        $q->where('status', 'published');
                    }])->orderByDesc('news_count')->get();
                ?>
                <div class="py-2 overflow-x-auto hide-scrollbar">
                    <div class="flex items-center gap-1.5 min-w-max text-[11px]">
                        <a href="<?php echo e(route('home')); ?>" 
                           class="px-3 py-1 rounded-full font-semibold tracking-wide <?php echo e(!request('category') ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-600 hover:text-gray-900'); ?>">
                            Semua Berita
                        </a>
                        <?php $__currentLoopData = $navCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $isActive = (request('category') == $cat->slug || request('category') == $cat->name); ?>
                            <a href="<?php echo e(route('home', ['category' => $cat->slug])); ?>" 
                               class="px-2.5 py-1 rounded-full <?php echo e($isActive ? 'bg-blue-600 text-white font-semibold' : 'bg-gray-50 text-gray-600 hover:text-gray-900 border border-gray-200/60 font-medium'); ?>">
                                #<?php echo e($cat->name); ?>

                            </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </header>



        <main class="min-h-screen">
            <?php echo $__env->yieldContent('content'); ?>
        </main>

        <footer class="bg-white border-t border-gray-200/80 py-6 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <span class="font-serif text-xl font-bold tracking-tighter text-gray-900">Kata<sup class="text-blue-600 text-sm">2</sup>-nya.</span>
                    </div>

                    <?php if(isset($navCategories) && $navCategories->count() > 0): ?>
                        <div class="flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-xs text-gray-500 font-medium">
                            <?php $__currentLoopData = $navCategories->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fCat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('home', ['category' => $fCat->slug])); ?>" class="hover:text-blue-600 transition-colors">
                                    <?php echo e($fCat->name); ?>

                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
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

<?php /**PATH C:\Users\Lenovo\Documents\ENT News\news\resources\views\layouts\public.blade.php ENDPATH**/ ?>