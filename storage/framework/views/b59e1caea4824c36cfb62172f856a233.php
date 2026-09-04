<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center space-x-4">
            <a href="<?php echo e(route('admin.categories.index')); ?>" class="text-gray-400 hover:text-gray-500">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            </a>
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                Add New Category
            </h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="max-w-2xl">
        <?php if($errors->any()): ?>
            <div class="mb-6 rounded-md bg-red-50 p-4 ring-1 ring-inset ring-red-600/20">
                <div class="text-sm text-red-700">
                    <ul class="list-disc pl-5 space-y-1">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.categories.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <?php if (isset($component)) { $__componentOriginaldae4cd48acb67888a4631e1ba48f2f93 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                <div class="space-y-6">
                    <div>
                        <?php if (isset($component)) { $__componentOriginalb2c43a998f3174877f99993c62e16bb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb2c43a998f3174877f99993c62e16bb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.label','data' => ['for' => 'name','value' => 'Name *']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'name','value' => 'Name *']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $attributes = $__attributesOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $component = $__componentOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__componentOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input','data' => ['id' => 'name','name' => 'name','type' => 'text','value' => ''.e(old('name')).'','required' => true,'class' => 'mt-1 w-full']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'name','name' => 'name','type' => 'text','value' => ''.e(old('name')).'','required' => true,'class' => 'mt-1 w-full']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $attributes = $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $component = $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
                    </div>

                    <div>
                        <?php if (isset($component)) { $__componentOriginalb2c43a998f3174877f99993c62e16bb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb2c43a998f3174877f99993c62e16bb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.label','data' => ['for' => 'slug','value' => 'Slug (Auto-generated if empty)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'slug','value' => 'Slug (Auto-generated if empty)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $attributes = $__attributesOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $component = $__componentOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__componentOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.input','data' => ['id' => 'slug','name' => 'slug','type' => 'text','value' => ''.e(old('slug')).'','class' => 'mt-1 w-full font-mono text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'slug','name' => 'slug','type' => 'text','value' => ''.e(old('slug')).'','class' => 'mt-1 w-full font-mono text-sm']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $attributes = $__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__attributesOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46)): ?>
<?php $component = $__componentOriginal65bd7e7dbd93cec773ad6501ce127e46; ?>
<?php unset($__componentOriginal65bd7e7dbd93cec773ad6501ce127e46); ?>
<?php endif; ?>
                    </div>

                    <div>
                        <?php if (isset($component)) { $__componentOriginalb2c43a998f3174877f99993c62e16bb4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb2c43a998f3174877f99993c62e16bb4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.label','data' => ['for' => 'description','value' => 'Description']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'description','value' => 'Description']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $attributes = $__attributesOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__attributesOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb2c43a998f3174877f99993c62e16bb4)): ?>
<?php $component = $__componentOriginalb2c43a998f3174877f99993c62e16bb4; ?>
<?php unset($__componentOriginalb2c43a998f3174877f99993c62e16bb4); ?>
<?php endif; ?>
                        <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-gray-900 sm:text-sm sm:leading-6"><?php echo e(old('description')); ?></textarea>
                    </div>
                </div>

                 <?php $__env->slot('footer', null, []); ?> 
                    <div class="flex items-center justify-end">
                        <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button','data' => ['variant' => 'ghost','href' => ''.e(route('admin.categories.index')).'','class' => 'mr-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'ghost','href' => ''.e(route('admin.categories.index')).'','class' => 'mr-3']); ?>Cancel <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $attributes = $__attributesOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__attributesOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $component = $__componentOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__componentOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginala8bb031a483a05f647cb99ed3a469847 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala8bb031a483a05f647cb99ed3a469847 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.ui.button','data' => ['type' => 'submit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit']); ?>Create Category <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $attributes = $__attributesOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__attributesOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala8bb031a483a05f647cb99ed3a469847)): ?>
<?php $component = $__componentOriginala8bb031a483a05f647cb99ed3a469847; ?>
<?php unset($__componentOriginala8bb031a483a05f647cb99ed3a469847); ?>
<?php endif; ?>
                    </div>
                 <?php $__env->endSlot(); ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93)): ?>
<?php $attributes = $__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93; ?>
<?php unset($__attributesOriginaldae4cd48acb67888a4631e1ba48f2f93); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldae4cd48acb67888a4631e1ba48f2f93)): ?>
<?php $component = $__componentOriginaldae4cd48acb67888a4631e1ba48f2f93; ?>
<?php unset($__componentOriginaldae4cd48acb67888a4631e1ba48f2f93); ?>
<?php endif; ?>
        </form>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.getElementById('name').addEventListener('blur', function(e) {
            let slugInput = document.getElementById('slug');
            if (slugInput.value.trim() === '') {
                let slug = e.target.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)+/g, '');
                slugInput.value = slug;
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Lenovo\Documents\ENT News\news\resources\views/admin/categories/create.blade.php ENDPATH**/ ?>