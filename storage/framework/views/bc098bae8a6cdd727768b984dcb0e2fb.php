<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['homeHref' => route('dashboard'), 'backHref' => null]));

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

foreach (array_filter((['homeHref' => route('dashboard'), 'backHref' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $back = $backHref ?: url()->previous();
?>

<div class="x-fab-group" aria-label="Navigazione rapida">
    <a href="<?php echo e($homeHref); ?>" class="btn btn-outline-secondary btn-sm" aria-label="Vai alla Home">
        <span aria-hidden="true">🏠</span>
        <span class="ms-1">Home</span>
    </a>
    <a href="<?php echo e($back); ?>" class="btn btn-outline-secondary btn-sm" aria-label="Torna indietro">
        <span aria-hidden="true">‹</span>
        <span class="ms-1">Indietro</span>
    </a>
</div>
<?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/components/fab-nav.blade.php ENDPATH**/ ?>