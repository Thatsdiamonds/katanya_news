<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['date']));

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

foreach (array_filter((['date']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    if (!$date) {
        $diff = '-';
        $exactFull = '';
        $exactShort = '';
        $isBeyondDays = false;
    } else {
        $cDate = \Carbon\Carbon::parse($date)->locale('id');
        $now = \Carbon\Carbon::now();
        
        $exactFull = $cDate->translatedFormat('d F Y H:i');
        $exactShort = $cDate->translatedFormat('d M Y');
        
        $diff = $cDate->diffForHumans();
        
        $diffInDays = abs((int) $cDate->diffInDays($now));
        $isBeyondDays = $diffInDays >= 7;
    }
?>

<?php if($date): ?>
    <span title="<?php echo e($exactFull); ?>" <?php echo e($attributes->merge(['class' => 'inline-flex items-center gap-1 cursor-pointer transition-opacity hover:opacity-100'])); ?>>
        <span><?php echo e($diff); ?></span>
        <?php if($isBeyondDays): ?>
            <span class="opacity-50 font-normal">(<?php echo e($exactShort); ?>)</span>
        <?php endif; ?>
    </span>
<?php else: ?>
    <span <?php echo e($attributes); ?>>-</span>
<?php endif; ?>
<?php /**PATH C:\Users\Lenovo\Documents\ENT News\news\resources\views\components\news-date.blade.php ENDPATH**/ ?>