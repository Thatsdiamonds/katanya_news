<div <?php echo e($attributes->merge(['class' => 'bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl'])); ?>>
    <?php if(isset($header)): ?>
        <div class="px-4 py-5 border-b border-gray-100 sm:px-6">
            <?php echo e($header); ?>

        </div>
    <?php endif; ?>
    <div class="px-4 py-5 sm:p-6">
        <?php echo e($slot); ?>

    </div>
    <?php if(isset($footer)): ?>
        <div class="px-4 py-4 border-t border-gray-100 bg-gray-50 sm:px-6 sm:rounded-b-xl flex items-center justify-end">
            <?php echo e($footer); ?>

        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\Lenovo\Documents\ENT News\news\resources\views/components/ui/card.blade.php ENDPATH**/ ?>