<div class="flow-root">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                <table <?php echo e($attributes->merge(['class' => 'min-w-full divide-y divide-gray-300'])); ?>>
                    <?php if(isset($head)): ?>
                        <thead class="bg-gray-50">
                            <tr>
                                <?php echo e($head); ?>

                            </tr>
                        </thead>
                    <?php endif; ?>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php echo e($slot); ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Lenovo\Documents\ENT News\news\resources\views\components\ui\table.blade.php ENDPATH**/ ?>