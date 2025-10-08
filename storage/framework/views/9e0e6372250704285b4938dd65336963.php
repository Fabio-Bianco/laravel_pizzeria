<?php $__env->startSection('title', 'Modifica: ' . $ingredient->name); ?>

<?php $__env->startSection('header'); ?>
<div class="d-flex justify-content-between align-items-center">
    <div>
        <div class="d-flex align-items-center mb-2">
            <a href="<?php echo e(route('admin.ingredients.index')); ?>" class="btn btn-outline-secondary btn-sm me-3">
                <i class="fas fa-arrow-left me-1"></i>
                Indietro
            </a>
            <h1 class="page-title mb-0">
                <i class="fas fa-edit text-success me-2"></i>
                Modifica: <?php echo e($ingredient->name); ?>

            </h1>
        </div>
        <p class="page-subtitle">Aggiorna le informazioni dell'ingrediente</p>
    </div>
    <div>
        <span class="badge bg-light text-dark fs-6 px-3 py-2">
            <i class="fas fa-seedling me-1"></i>
            Gestione Ingredienti
        </span>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-12">
            <form action="<?php echo e(route('admin.ingredients.update', $ingredient)); ?>" method="POST" novalidate class="needs-validation">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="row g-4">
                    
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle text-success me-2"></i>
                                    Informazioni Base
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="name" class="form-label fw-semibold">
                                            <i class="fas fa-seedling me-1"></i>
                                            Nome Ingrediente <span class="text-danger">*</span>
                                        </label>
                                        <input id="name" name="name" type="text" 
                                               class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                               value="<?php echo e(old('name', $ingredient->name)); ?>" 
                                               placeholder="Es. Mozzarella, Pomodoro, Basilico..."
                                               required>
                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" value="1" 
                                                   id="is_tomato" name="is_tomato" 
                                                   <?php if(old('is_tomato', $ingredient->is_tomato)): echo 'checked'; endif; ?>>
                                            <label class="form-check-label fw-semibold" for="is_tomato">
                                                <i class="fas fa-tomato text-danger me-1"></i>
                                                È un tipo di pomodoro
                                            </label>
                                        </div>
                                        <small class="text-muted">Contrassegna se questo ingrediente è un derivato del pomodoro</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    Allergeni Associati
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="allergens" class="form-label fw-semibold mb-3">
                                        <i class="fas fa-list me-1"></i>
                                        Seleziona allergeni
                                    </label>
                                    <select id="allergens" name="allergens[]" multiple 
                                            class="form-select <?php $__errorArgs = ['allergens'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            data-choices 
                                            placeholder="Cerca e seleziona allergeni...">
                                        <?php $__currentLoopData = $allergens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($allergen->id); ?>" 
                                                    <?php if($ingredient->allergens->pluck('id')->contains($allergen->id)): echo 'selected'; endif; ?>>
                                                <?php echo e($allergen->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['allergens'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Seleziona tutti gli allergeni presenti in questo ingrediente
                                    </div>
                                </div>

                                
                                <?php if($ingredient->allergens->isNotEmpty()): ?>
                                <div class="mt-4 p-3 bg-light rounded">
                                    <h6 class="mb-2">
                                        <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                        Allergeni Attuali
                                    </h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <?php $__currentLoopData = $ingredient->allergens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <span class="badge bg-warning text-dark"><?php echo e($allergen->name); ?></span>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="mt-4 p-3 bg-light rounded">
                                    <h6 class="mb-2">
                                        <i class="fas fa-check-circle text-success me-1"></i>
                                        Nessun Allergene
                                    </h6>
                                    <small class="text-muted">
                                        Questo ingrediente non contiene allergeni noti
                                    </small>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        I campi contrassegnati con <span class="text-danger">*</span> sono obbligatori
                                    </small>
                                    <div class="d-flex gap-3">
                                        <a href="<?php echo e(route('admin.ingredients.index')); ?>" class="btn btn-outline-secondary px-4">
                                            <i class="fas fa-times me-2"></i>
                                            Annulla
                                        </a>
                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="fas fa-save me-2"></i>
                                            Aggiorna Ingrediente
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/admin/ingredients/edit.blade.php ENDPATH**/ ?>