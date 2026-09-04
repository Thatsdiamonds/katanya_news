<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status']));

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

foreach (array_filter((['status']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $status = strtolower($status);
    
    $classes = match($status) {
        'published' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'draft' => 'bg-gray-50 text-gray-600 ring-gray-500/20',
        'pending' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        'revision' => 'bg-rose-50 text-rose-700 ring-rose-600/20',
        'approved' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
        default => 'bg-gray-50 text-gray-600 ring-gray-500/20',
    };
?>

<span <?php echo e($attributes->merge(['class' => "inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset $classes"])); ?>>
    <?php echo e($slot->isEmpty() ? ucfirst($status) : $slot); ?>

</span>
<?php /**PATH C:\Users\Lenovo\Documents\ENT News\news\resources\views\components\ui\badge.blade.php ENDPATH**/ ?>