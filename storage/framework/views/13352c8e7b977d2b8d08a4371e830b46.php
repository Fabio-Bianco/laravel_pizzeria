

<?php $__env->startSection('title', 'Pizze'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
  <div class="mb-2" style="font-size:3rem;">🍕</div>
  <h1 class="display-6 fw-bold text-dark mb-2">Pizze</h1>
  <p class="lead text-muted mb-4">Gestisci le pizze del tuo menu</p>

  <div class="d-flex justify-content-center mb-4">
    <a href="<?php echo e(route('admin.pizzas.create')); ?>"
       class="btn btn-create btn-lg px-4 py-3"
       role="button"
       aria-label="Aggiungi una nuova pizza"
       data-bs-toggle="tooltip" title="Crea una nuova pizza">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuova Pizza
    </a>
  </div>

  <div class="mt-3">
    <?php $total = method_exists($pizzas,'total') ? $pizzas->total() : ($pizzas->count() ?? 0); ?>
    <span class="badge bg-success fs-6 px-3 py-2">Hai <?php echo e($total); ?> <?php echo e($total == 1 ? 'pizza' : 'pizze'); ?> disponibili</span>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php $count = ($pizzas->count() ?? 0); ?>

  <?php if($count === 0): ?>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🍕</div>
          <h3 class="fw-bold text-dark mb-3">Nessuna pizza presente</h3>
          <p class="text-muted mb-4">Crea la tua prima pizza per iniziare.</p>
          <a class="btn btn-success btn-lg px-4 py-3 fw-bold" href="<?php echo e(route('admin.pizzas.create')); ?>">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea la Prima Pizza
          </a>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="transition-container list-wrapper">
      <div class="list-container">
        <?php $__currentLoopData = $pizzas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pizza): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="border-bottom py-3">
            <div class="row align-items-center g-3">
              <div class="col-md-2 col-3">
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:60px;width:60px;">
                  <i class="fas fa-pizza-slice text-muted" aria-hidden="true"></i>
                </div>
              </div>

              <div class="col-md-7 col-9">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="flex-grow-1 min-w-0">
                    <h6 class="mb-1 fw-bold text-truncate"><?php echo e($pizza->name); ?></h6>
                    <?php if(!empty($pizza->notes)): ?>
                      <small class="text-muted d-block text-truncate"><?php echo e(\Illuminate\Support\Str::limit($pizza->notes, 120)); ?></small>
                    <?php endif; ?>

                    <?php if($pizza->ingredients && $pizza->ingredients->count() > 0): ?>
                      <div class="mt-2">
                        <small class="text-muted">Ingredienti:</small>
                        <div class="mt-1">
                          <?php $__currentLoopData = $pizza->ingredients->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingredient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge bg-primary text-white me-1 mb-1"><?php echo e($ingredient->name); ?></span>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php if($pizza->ingredients->count() > 3): ?>
                            <span class="badge bg-secondary">+<?php echo e($pizza->ingredients->count() - 3); ?></span>
                          <?php endif; ?>
                        </div>
                      </div>
                    <?php endif; ?>
                  </div>
                  <?php if($pizza->category): ?>
                    <span class="badge bg-info text-dark ms-2"><?php echo e($pizza->category->name); ?></span>
                  <?php endif; ?>
                </div>
              </div>

              <div class="col-md-3 col-12">
                <div class="d-flex flex-wrap gap-2 w-100 actions-flex">
                  <a href="<?php echo e(route('admin.pizzas.show', $pizza)); ?>" class="btn btn-view btn-sm flex-grow-1" data-bs-toggle="tooltip" title="Dettagli">
                    <i class="fas fa-eye me-1"></i><span class="d-none d-lg-inline">Dettagli</span>
                  </a>
                  <a href="<?php echo e(route('admin.pizzas.edit', $pizza)); ?>" class="btn btn-edit btn-sm flex-grow-1" data-bs-toggle="tooltip" title="Modifica">
                    <i class="fas fa-edit me-1"></i><span class="d-none d-lg-inline">Modifica</span>
                  </a>
                  <form method="POST" action="<?php echo e(route('admin.pizzas.destroy', $pizza)); ?>" class="flex-grow-1" onsubmit="return confirm('Eliminare definitivamente <?php echo e($pizza->name); ?>?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-delete btn-sm w-100 d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Elimina">
                      <i class="fas fa-trash me-1"></i><span>Elimina</span>
                    </button>
                  </form>
                </div>
              </div>

            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      <?php if(method_exists($pizzas,'hasPages') && $pizzas->hasPages()): ?>
        <div class="d-flex justify-content-center mt-5"><?php echo e($pizzas->links()); ?></div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
  .list-wrapper, .list-container { overflow: visible; }
  .actions-flex .btn { min-width: 110px; white-space: nowrap; }
  @media (max-width: 576px) { .actions-flex .btn { min-width: 100%; } }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
(function () {
  if (window.bootstrap) {
    const triggers = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    triggers.forEach(el => new bootstrap.Tooltip(el));
  }
})();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/admin/pizzas/index.blade.php ENDPATH**/ ?>