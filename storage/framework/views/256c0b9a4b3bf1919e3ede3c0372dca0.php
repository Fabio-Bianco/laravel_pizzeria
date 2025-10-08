<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['title' => 'Categorie','items' => [['label' => 'Categorie']]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Categorie','items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([['label' => 'Categorie']])]); ?>
             <?php $__env->slot('actions', null, []); ?> 
                <a class="btn btn-primary" href="<?php echo e(route('admin.categories.create')); ?>">+ Nuova categoria</a>
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
     <?php $__env->endSlot(); ?>

    <?php echo $__env->make('partials.flash', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

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

    <div class="container py-4">

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0">
                                    <a href="<?php echo e(route('admin.categories.show', $category)); ?>" class="stretched-link text-decoration-none"><?php echo e($category->name); ?></a>
                                </h5>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge text-bg-info-subtle text-info-emphasis" title="Numero pizze in categoria"><?php echo e($category->pizzas_count); ?> pizze</span>
                                </div>
                            </div>
                            <?php if($category->description): ?>
                                <p class="card-text text-muted small mb-3"><?php echo e(\Illuminate\Support\Str::limit($category->description, 120)); ?></p>
                            <?php endif; ?>
                            <div class="mt-auto d-flex gap-2 justify-content-end">
                                <a href="<?php echo e(route('admin.categories.edit', $category)); ?>" class="btn btn-outline-success btn-sm" style="border:1.5px solid #388e3c;color:#388e3c;background:transparent;">Modifica</a>
                                <form action="<?php echo e(route('admin.categories.destroy', $category)); ?>" method="POST" data-confirm="Sicuro?">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button class="btn btn-outline-danger btn-sm" type="submit" style="border:1.5px solid #d32f2f;color:#d32f2f;background:transparent;">Elimina</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col">
                    <div class="alert alert-info mb-0">Nessuna categoria.</div>
                </div>
            <?php endif; ?>
        </div>

        <nav class="mt-4 d-flex justify-content-center" aria-label="Paginazione categorie">
            <?php echo e($categories->links('pagination.custom')); ?>

        </nav>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/admin/categories/index.blade.php ENDPATH**/ ?>