<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'variant' => 'primary', // primary, secondary, outline, ghost, danger
    'size' => 'md', // sm, md, lg
    'type' => 'submit'
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'variant' => 'primary', // primary, secondary, outline, ghost, danger
    'size' => 'md', // sm, md, lg
    'type' => 'submit'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $baseClasses = 'inline-flex items-center justify-center font-medium transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none rounded-md';

    $sizeClasses = match($size) {
        'sm' => 'px-3 py-1.5 text-xs',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-base',
        default => 'px-4 py-2 text-sm',
    };

    $variantClasses = match($variant) {
        'primary' => 'bg-gray-900 text-white hover:bg-black focus:ring-gray-900',
        'secondary' => 'bg-gray-100 text-gray-900 hover:bg-gray-200 focus:ring-gray-500',
        'outline' => 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50 focus:ring-gray-500',
        'ghost' => 'bg-transparent text-gray-700 hover:bg-gray-100 focus:ring-gray-500',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-600',
        'link' => 'bg-transparent text-blue-600 hover:text-blue-800 hover:underline p-0 focus:ring-0',
        default => 'bg-gray-900 text-white hover:bg-black focus:ring-gray-900',
    };

    $classes = $baseClasses . ' ' . $sizeClasses . ' ' . $variantClasses;
?>

<?php if($attributes->has('href')): ?>
    <a <?php echo e($attributes->merge(['class' => $classes])); ?>>
        <?php echo e($slot); ?>

    </a>
<?php else: ?>
    <button type="<?php echo e($type); ?>" <?php echo e($attributes->merge(['class' => $classes])); ?>>
        <?php echo e($slot); ?>

    </button>
<?php endif; ?>
<?php /**PATH C:\Users\Lenovo\Documents\ENT News\news\resources\views\components\ui\button.blade.php ENDPATH**/ ?>