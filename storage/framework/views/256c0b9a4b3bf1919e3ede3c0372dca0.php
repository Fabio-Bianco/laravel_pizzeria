<?php $__env->startSection('title', 'Categorie'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
    <div class="mb-2" style="font-size:3rem;">🏷️</div>
    <h1 class="display-6 fw-bold text-dark mb-2">Categorie</h1>
    <p class="lead text-muted mb-4">Gestisci le categorie delle pizze e dei prodotti</p>

    
    <div class="d-flex justify-content-center mb-4">
        <a href="<?php echo e(route('admin.categories.create')); ?>"
             class="btn btn-create btn-lg px-4 py-3"
             role="button"
             aria-label="Aggiungi una nuova categoria"
             data-bs-toggle="tooltip" 
             title="Crea una nuova categoria">
            <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuova Categoria
        </a>
    </div>

    <?php echo $__env->make('partials.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginale721a0f56e20dd0a547a936533f60514 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale721a0f56e20dd0a547a936533f60514 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.filter-toolbar','data' => ['search' => true,'searchPlaceholder' => 'Cerca per nome o descrizione…','sortOptions' => ['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A'],'resetUrl' => route('admin.categories.index')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filter-toolbar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['search' => true,'searchPlaceholder' => 'Cerca per nome o descrizione…','sort-options' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A']),'reset-url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.categories.index'))]); ?>
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

    <?php if($categories->count() === 0): ?>
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center py-5">
                    <div class="mb-4" style="font-size:5rem;opacity:.5;">🏷️</div>
                    <h3 class="fw-bold text-dark mb-3">Nessuna categoria presente</h3>
                    <p class="text-muted mb-4">Crea la tua prima categoria per iniziare.</p>
                    <a class="btn btn-create btn-lg px-4 py-3" href="<?php echo e(route('admin.categories.create')); ?>">
                        <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea la Prima Categoria
                    </a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="list-container">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex align-items-center list-item-pizza">
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <h6 class="mb-0 text-truncate">
                                <a href="<?php echo e(route('admin.categories.show', $category)); ?>" class="text-decoration-none"><?php echo e($category->name); ?></a>
                            </h6>
                            <span class="badge badge-info" title="Numero pizze in categoria"><?php echo e($category->pizzas_count); ?> pizze</span>
                        </div>
                        <?php if($category->description): ?>
                            <div class="text-muted small mb-1"><?php echo e(\Illuminate\Support\Str::limit($category->description, 120)); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex align-items-center gap-2 ms-3 flex-shrink-0">
                        <a href="<?php echo e(route('admin.categories.edit', $category)); ?>"
                             class="btn btn-success btn-sm d-flex align-items-center gap-1"
                             title="Modifica categoria">
                            <i class="fas fa-edit me-1" aria-hidden="true"></i> <span>Modifica</span>
                        </a>
                        <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" data-confirm="Sicuro?" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                            class="btn btn-danger btn-sm d-flex align-items-center gap-1"
                                            title="Elimina categoria">
                                <i class="fas fa-trash me-1" aria-hidden="true"></i> <span>Elimina</span>
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if(method_exists($categories,'hasPages') && $categories->hasPages()): ?>
            <div class="d-flex justify-content-center mt-5">
                <?php echo e($categories->links()); ?>

            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>