<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'allergens' => null,
    'mode' => 'compact', // compact, full, simple, minimal
    'maxVisible' => 3
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
    'allergens' => null,
    'mode' => 'compact', // compact, full, simple, minimal
    'maxVisible' => 3
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    // 🚀 OTTIMIZZAZIONE: Collezione allergeni unificata con cache-aware loading
    $allergenCollection = collect();
    
    if($allergens && method_exists($allergens, 'getAllAllergens')) {
        // Per modelli con getAllAllergens() (Pizza, Appetizer, etc.) - ORA OTTIMIZZATO
        $allergenCollection = $allergens->getAllAllergens();
    } elseif($allergens && is_object($allergens) && !empty($allergens->manual_allergens)) {
        // Per bevande con allergeni manuali JSON
        $manual = json_decode($allergens->manual_allergens, true);
        if(is_array($manual) && count($manual) > 0) {
            $allergenCollection = \App\Models\Allergen::whereIn('id', $manual)->get();
        }
    } elseif($allergens && is_iterable($allergens)) {
        // Collection diretta di allergeni
        $allergenCollection = collect($allergens);
    }
    
    $hasAllergens = $allergenCollection->isNotEmpty();
    $totalCount = $allergenCollection->count();
    
    // Performance: se non ci sono allergeni, esci subito
    if($allergenCollection->isEmpty()) {
        // Non fare return qui, mostra badge "sicuro"
    }
    
    // Limita il numero di allergeni visibili per performance
    $visibleAllergens = $allergenCollection->take($maxVisible);
    $hiddenCount = max(0, $allergenCollection->count() - $maxVisible);
    
    // Icone semantiche per allergeni comuni
    $allergenIcons = [
        'glutine' => '🌾',
        'latte' => '🥛', 
        'lattosio' => '🥛',
        'uova' => '🥚',
        'pesce' => '🐟',
        'crostacei' => '🦐',
        'frutta a guscio' => '🥜',
        'arachidi' => '🥜',
        'soia' => '🌱',
        'sedano' => '🥬',
        'senape' => '🌿',
        'sesamo' => '🌰',
        'solfiti' => '⚠️',
        'nichel' => '⚙️',
        'molluschi' => '🐚',
        'lupini' => '🌿'
    ];
?>

<div class="allergen-display" role="region" aria-label="Informazioni allergeni">
    <?php if(!$hasAllergens): ?>
        
        <?php if($mode === 'full'): ?>
            <div class="allergen-safe">
                <span class="badge badge-success d-flex align-items-center">
                    <i class="fas fa-shield-check me-2" aria-hidden="true"></i>
                    <span>Sicuro per Allergeni</span>
                </span>
            </div>
        <?php else: ?>
            <span class="badge badge-success">
                <i class="fas fa-check me-1" aria-hidden="true"></i>Sicuro
            </span>
        <?php endif; ?>
    <?php else: ?>
        
        <?php if($mode === 'full'): ?>
            
            <div class="allergen-full">
                <div class="small text-warning fw-bold mb-2">
                    <i class="fas fa-exclamation-triangle me-1" aria-hidden="true"></i>
                    Contiene <?php echo e($totalCount); ?> <?php echo e($totalCount === 1 ? 'allergene' : 'allergeni'); ?>:
                </div>
                <div class="d-flex flex-wrap gap-1">
                    <?php $__currentLoopData = $allergenCollection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $name = strtolower($allergen->name);
                            $icon = '⚠️'; // default
                            foreach($allergenIcons as $key => $value) {
                                if(str_contains($name, $key)) {
                                    $icon = $value;
                                    break;
                                }
                            }
                        ?>
                        <span class="badge badge-warning d-flex align-items-center" 
                              title="Allergene: <?php echo e($allergen->name); ?>">
                            <span class="me-1"><?php echo e($icon); ?></span>
                            <span><?php echo e($allergen->name); ?></span>
                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php elseif($mode === 'compact'): ?>
            
            <div class="allergen-compact">
                <div class="small text-warning mb-1">
                    <i class="fas fa-shield-alt me-1" aria-hidden="true"></i>Allergeni:
                </div>
                <div class="d-flex flex-wrap gap-1 align-items-center">
                    <?php $__currentLoopData = $allergenCollection->take($maxVisible); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $name = strtolower($allergen->name);
                            $icon = '⚠️';
                            foreach($allergenIcons as $key => $value) {
                                if(str_contains($name, $key)) {
                                    $icon = $value;
                                    break;
                                }
                            }
                        ?>
                        <span class="badge badge-warning-subtle" 
                              title="Allergene: <?php echo e($allergen->name); ?>">
                            <?php echo e($icon); ?> <?php echo e(\Illuminate\Support\Str::limit($allergen->name, 8)); ?>

                        </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if($totalCount > $maxVisible): ?>
                        <span class="badge badge-secondary" 
                              title="Altri <?php echo e($totalCount - $maxVisible); ?> allergeni">
                            +<?php echo e($totalCount - $maxVisible); ?>

                        </span>
                    <?php endif; ?>
                </div>
            </div>
        <?php elseif($mode === 'minimal'): ?>
            
            <div class="allergen-minimal d-flex align-items-center gap-1">
                <?php $__currentLoopData = $allergenCollection->take($maxVisible); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $name = strtolower($allergen->name);
                        $icon = '⚠️';
                        foreach($allergenIcons as $key => $value) {
                            if(str_contains($name, $key)) {
                                $icon = $value;
                                break;
                            }
                        }
                    ?>
                    <span class="allergen-icon" 
                          title="Contiene: <?php echo e($allergen->name); ?>"
                          aria-label="Allergene <?php echo e($allergen->name); ?>">
                        <?php echo e($icon); ?>

                    </span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <?php if($totalCount > $maxVisible): ?>
                    <small class="text-warning ms-1" 
                           title="Contiene altri <?php echo e($totalCount - $maxVisible); ?> allergeni"
                           aria-label="Altri <?php echo e($totalCount - $maxVisible); ?> allergeni">
                        +<?php echo e($totalCount - $maxVisible); ?>

                    </small>
                <?php endif; ?>
            </div>
        <?php else: ?>
            
            <span class="badge badge-warning" 
                  title="Contiene <?php echo e($totalCount); ?> <?php echo e($totalCount === 1 ? 'allergene' : 'allergeni'); ?>">
                <i class="fas fa-exclamation-triangle me-1" aria-hidden="true"></i>
                <?php echo e($totalCount); ?> allergeni
            </span>
        <?php endif; ?>
    <?php endif; ?>
</div><?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/components/allergen-display.blade.php ENDPATH**/ ?>