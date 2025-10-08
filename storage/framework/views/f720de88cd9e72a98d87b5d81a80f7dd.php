<?php $__env->startSection('title', 'Allergeni'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
    <div class="mb-2" style="font-size:3rem;">⚠️</div>
    <h1 class="display-6 fw-bold text-dark mb-2">Allergeni</h1>
    <p class="lead text-muted mb-4">Gestisci gli allergeni presenti nei tuoi ingredienti e piatti</p>

    
    <div class="d-flex justify-content-center mb-4">
        <a href="<?php echo e(route('admin.allergens.create')); ?>"
             class="btn btn-create btn-lg px-4 py-3"
             role="button"
             aria-label="Aggiungi un nuovo allergene"
             data-bs-toggle="tooltip" 
             title="Crea un nuovo allergene">
            <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuovo Allergene
        </a>
    </div>

    <?php if(session('status')): ?>
        <div class="text-success"><?php echo e(session('status')); ?></div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginale721a0f56e20dd0a547a936533f60514 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale721a0f56e20dd0a547a936533f60514 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.filter-toolbar','data' => ['search' => true,'searchPlaceholder' => 'Cerca per nome o descrizione…','sortOptions' => ['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A'],'resetUrl' => route('admin.allergens.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filter-toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['search' => true,'searchPlaceholder' => 'Cerca per nome o descrizione…','sort-options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A']),'reset-url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.allergens.index'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale721a0f56e20dd0a547a936533f60514)): ?>
<?php $attributes = $__attributesOriginale721a0f56e20dd0a547a936533f60514; ?>
<?php unset($__attributesOriginale721a0f56e20dd0a547a936533f60514); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale721a0f56e20dd0a547a936533f60514)): ?>
<?php $component = $__componentOriginale721a0f56e20dd0a547a936533f60514; ?>
<?php unset($__componentOriginale721a0f56e20dd0a547a936533f60514); ?>
<?php endif; ?>

    <?php if($allergens->count() === 0): ?>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center py-5">
                    <div class="mb-4" style="font-size:5rem;opacity:.5;">⚠️</div>
                    <h3 class="fw-bold text-dark mb-3">Nessun allergene presente</h3>
                    <p class="text-muted mb-4">Crea il tuo primo allergene per iniziare.</p>
                    <a class="btn btn-create btn-lg px-4 py-3" href="<?php echo e(route('admin.allergens.create')); ?>">
                        <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea il Primo Allergene
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="list-container">
            <?php $__currentLoopData = $allergens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex align-items-center list-item-pizza">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h6 class="mb-0 text-truncate"><?php echo e($allergen->name); ?></h6>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 ms-3 flex-shrink-0">
                        <a href="<?php echo e(route('admin.allergens.edit', $allergen)); ?>"
                             class="btn btn-success btn-sm d-flex align-items-center gap-1"
                             title="Modifica allergene">
                            <i class="fas fa-edit me-1" aria-hidden="true"></i> <span>Modifica</span>
                        </a>
                        <form action="<?php echo e(route('admin.allergens.destroy', $allergen)); ?>" method="POST" data-confirm="Sicuro?" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                            class="btn btn-danger btn-sm d-flex align-items-center gap-1"
                                            title="Elimina allergene">
                                <i class="fas fa-trash me-1" aria-hidden="true"></i> <span>Elimina</span>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if(method_exists($allergens,'hasPages') && $allergens->hasPages()): ?>
            <div class="d-flex justify-content-center mt-5">
                <?php echo e($allergens->links()); ?>

            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/admin/allergens/index.blade.php ENDPATH**/ ?>