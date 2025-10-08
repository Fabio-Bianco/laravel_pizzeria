

<?php $__env->startSection('title', 'Ingredienti'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
  <div class="mb-2" style="font-size:3rem;">🥄</div>
  <h1 class="display-6 fw-bold text-dark mb-2">Ingredienti</h1>
  <p class="lead text-muted mb-4">Gestisci gli ingredienti per le tue ricette</p>

  
  <div class="d-flex justify-content-center mb-4">
    <a href="<?php echo e(route('admin.ingredients.create')); ?>"
       class="btn btn-create btn-lg px-4 py-3"
       role="button"
       aria-label="Aggiungi un nuovo ingrediente"
       data-bs-toggle="tooltip" 
       title="Crea un nuovo ingrediente">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuovo Ingrediente
    </a>
  </div>

  <div class="mt-3">
    <?php $total = method_exists($ingredients,'total') ? $ingredients->total() : ($ingredients->count() ?? 0); ?>
    <span class="badge badge-success fs-6 px-3 py-2">
      Hai <?php echo e($total); ?> <?php echo e($total == 1 ? 'ingrediente' : 'ingredienti'); ?> disponibili
    </span>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php if(($ingredients->count() ?? 0) === 0): ?>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🥄</div>
          <h3 class="fw-bold text-dark mb-3">Nessun ingrediente presente</h3>
          <p class="text-muted mb-4">Crea il tuo primo ingrediente per iniziare.</p>
          <a class="btn btn-create btn-lg px-4 py-3" href="<?php echo e(route('admin.ingredients.create')); ?>">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea il Primo Ingrediente
          </a>
        </div>
      </div>
    </div>
  <?php else: ?>

    
    <div class="list-container">
      <?php $__currentLoopData = $ingredients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingredient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="d-flex align-items-center list-item-pizza">
          <div class="flex-grow-1">
            <div class="d-flex align-items-center gap-2 mb-1">
              <h6 class="mb-0 text-truncate"><?php echo e($ingredient->name); ?></h6>
              <?php if($ingredient->allergens && $ingredient->allergens->count() > 0): ?>
                <span class="badge badge-warning" title="Contiene allergeni"><?php echo e($ingredient->allergens->count()); ?> allergeni</span>
              <?php endif; ?>
            </div>
            <?php if(!empty($ingredient->description)): ?>
              <div class="text-muted small mb-1"><?php echo e(\Illuminate\Support\Str::limit($ingredient->description, 100)); ?></div>
            <?php endif; ?>
            <?php if($ingredient->allergens && $ingredient->allergens->count() > 0): ?>
              <div class="mb-1">
                <small class="text-muted">Allergeni:</small>
                <?php $__currentLoopData = $ingredient->allergens->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <span class="badge badge-danger me-1 mb-1"><?php echo e($allergen->name); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if($ingredient->allergens->count() > 3): ?>
                  <span class="badge badge-neutral">+<?php echo e($ingredient->allergens->count() - 3); ?></span>
                <?php endif; ?>
              </div>
            <?php endif; ?>
          </div>
          <div class="d-flex align-items-center gap-2 ms-3 flex-shrink-0">
            <a href="<?php echo e(route('admin.ingredients.edit', $ingredient)); ?>"
               class="btn btn-success btn-sm d-flex align-items-center gap-1"
               title="Modifica ingrediente">
              <i class="fas fa-edit me-1" aria-hidden="true"></i> <span>Modifica</span>
            </a>
            <form method="POST" action="<?php echo e(route('admin.ingredients.destroy', $ingredient)); ?>" class="d-inline" data-item-name="<?php echo e($ingredient->name); ?>">
              <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
              <button type="submit"
                      class="btn btn-danger btn-sm d-flex align-items-center gap-1"
                      title="Elimina ingrediente">
                <i class="fas fa-trash me-1" aria-hidden="true"></i> <span>Elimina</span>
              </button>
            </form>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if(method_exists($ingredients,'hasPages') && $ingredients->hasPages()): ?>
      <div class="d-flex justify-content-center mt-5">
        <?php echo e($ingredients->links()); ?>

      </div>
    <?php endif; ?>
  <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/admin/ingredients/index.blade.php ENDPATH**/ ?>