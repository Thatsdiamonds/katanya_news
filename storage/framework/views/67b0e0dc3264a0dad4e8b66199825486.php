<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?> - Admin</title>

        <!-- Self-hosted fonts from public/fonts -->
        <?php echo $__env->make('partials.fonts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-[#F9FAFB] flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col hidden md:flex z-10 shrink-0">
            <div class="h-16 flex items-center px-6 border-b border-gray-100">
                <a href="<?php echo e(route('home')); ?>" class="font-serif text-xl font-bold tracking-tight text-gray-900 flex items-center gap-1.5">
                    Kata<sup class="text-blue-600 text-sm">2</sup>-nya.
                </a>
            </div>
            
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <ul role="list" class="flex flex-1 flex-col gap-y-1">
                    <li>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-gray-50 text-blue-600' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'); ?>">
                            <svg class="h-6 w-6 shrink-0 <?php echo e(request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600'); ?>" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.news.index')); ?>" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold <?php echo e(request()->routeIs('admin.news.*') ? 'bg-gray-50 text-blue-600' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'); ?>">
                            <svg class="h-6 w-6 shrink-0 <?php echo e(request()->routeIs('admin.news.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600'); ?>" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z" />
                            </svg>
                            Articles
                        </a>
                    </li>
                    
                    <?php if(auth()->user()->role === 'superadmin'): ?>
                    <li>
                        <a href="<?php echo e(route('admin.categories.index')); ?>" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold <?php echo e(request()->routeIs('admin.categories.*') ? 'bg-gray-50 text-blue-600' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'); ?>">
                            <svg class="h-6 w-6 shrink-0 <?php echo e(request()->routeIs('admin.categories.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            Categories
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold <?php echo e(request()->routeIs('admin.users.*') ? 'bg-gray-50 text-blue-600' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-50'); ?>">
                            <svg class="h-6 w-6 shrink-0 <?php echo e(request()->routeIs('admin.users.*') ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-600'); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Users
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>

            <div class="p-4 border-t border-gray-100 mt-auto">
                <div class="flex items-center px-2 mb-4">
                    <div class="h-8 w-8 rounded-full bg-gray-100 ring-1 ring-gray-200 flex items-center justify-center font-bold text-gray-600 text-xs uppercase overflow-hidden">
                        <?php if(auth()->user()->avatar): ?>
                            <img src="<?php echo e(Storage::disk('public')->url(auth()->user()->avatar)); ?>" alt="<?php echo e(auth()->user()->name); ?>" class="h-full w-full object-cover">
                        <?php else: ?>
                            <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                        <?php endif; ?>
                    </div>
                    <div class="ml-3 truncate">
                        <p class="text-sm font-semibold text-gray-900 truncate"><?php echo e(auth()->user()->name); ?></p>
                        <p class="text-xs font-medium text-gray-500 capitalize truncate"><?php echo e(auth()->user()->role); ?></p>
                    </div>
                </div>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 rounded-md hover:bg-gray-50 transition-colors">
                        <svg class="mr-3 flex-shrink-0 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Log out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Header -->
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 lg:px-8 z-10 shrink-0">
                <div class="flex items-center">
                    <button type="button" class="md:hidden mr-4 text-gray-500 hover:text-gray-900 focus:outline-none">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <?php if(isset($header)): ?>
                        <div class="font-semibold text-gray-900 truncate">
                            <?php echo e($header); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </header>

            <!-- Main scrollable area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                <?php echo e($slot); ?>

            </main>
        </div>
    </body>
</html>
<?php /**PATH C:\Users\Lenovo\Documents\ENT News\news\resources\views/layouts/app.blade.php ENDPATH**/ ?>