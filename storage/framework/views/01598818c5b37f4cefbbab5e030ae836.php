<?php $__env->startSection('title', 'Le Tue Bevande'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
  <div class="mb-2" style="font-size:3rem;">🥤</div>
  <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Bevande</h1>
  <p class="lead text-muted mb-4">Bibite, vini e birre del tuo menu</p>

  <div class="d-flex justify-content-center mb-4">
    <a href="<?php echo e(route('admin.beverages.create')); ?>"
       class="btn btn-create btn-lg px-4 py-3"
       role="button"
       aria-label="Aggiungi una nuova bevanda"
       data-bs-toggle="tooltip" title="Crea una nuova bevanda">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuova Bevanda
    </a>
  </div>

  <div class="visually-hidden" aria-live="polite" aria-atomic="true" id="view-change-announce"></div>
  <div class="mt-3">
    <?php $total = method_exists($beverages,'total') ? $beverages->total() : ($beverages->count() ?? 0); ?>
    <span class="badge bg-success fs-6 px-3 py-2">Hai <?php echo e($total); ?> <?php echo e($total == 1 ? 'bevanda' : 'bevande'); ?> nel menu</span>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php $count = ($beverages->count() ?? 0); ?>

  <?php if($count === 0): ?>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🥤</div>
          <h3 class="fw-bold text-dark mb-3">Nessuna bevanda presente</h3>
          <p class="text-muted mb-4">Aggiungi la prima bevanda al tuo menu.</p>
          <a class="btn btn-success btn-lg px-4 py-3 fw-bold" href="<?php echo e(route('admin.beverages.create')); ?>">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea la Prima Bevanda
          </a>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div id="beverages-container" class="transition-container list-wrapper">
      <div class="list-container">
        <?php $__currentLoopData = $beverages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="list-item-beverage border-bottom py-3">
            <div class="row align-items-center g-3">
              <div class="col-md-2 col-3">
                <?php if(!empty($b->image_path)): ?>
                  <img src="<?php echo e(asset('storage/'.$b->image_path)); ?>" alt="Bevanda <?php echo e($b->name); ?>" class="img-fluid rounded" style="height:60px;width:60px;object-fit:cover;">
                <?php else: ?>
                  <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:60px;width:60px;">
                    <i class="fas fa-wine-bottle text-muted" aria-hidden="true"></i>
                  </div>
                <?php endif; ?>
              </div>

              <div class="col-md-5 col-6">
                <div class="flex-grow-1 min-w-0">
                  <h6 class="mb-1 fw-bold text-truncate">
                    <a href="<?php echo e(route('admin.beverages.show', $b)); ?>" class="text-decoration-none text-dark"><?php echo e($b->name); ?></a>
                  </h6>
                  <small class="text-muted d-block text-truncate"><?php echo e($b->description ?? 'Nessuna descrizione'); ?></small>
                </div>
              </div>

              <div class="col-md-2 col-3 text-center">
                <span class="h6 text-success fw-bold">€<?php echo e(number_format($b->price ?? 0, 2, ',', '.')); ?></span>
              </div>

              <div class="col-md-3 col-12">
                <div class="d-flex flex-wrap gap-2 w-100 actions-flex">
                  <a href="<?php echo e(route('admin.beverages.show', $b)); ?>" class="btn btn-view btn-sm flex-grow-1" data-bs-toggle="tooltip" title="Dettagli">
                    <i class="fas fa-eye me-1"></i><span class="d-none d-lg-inline">Dettagli</span>
                  </a>
                  <a href="<?php echo e(route('admin.beverages.edit', $b)); ?>" class="btn btn-edit btn-sm flex-grow-1" data-bs-toggle="tooltip" title="Modifica">
                    <i class="fas fa-edit me-1"></i><span class="d-none d-lg-inline">Modifica</span>
                  </a>
                  <form method="POST" action="<?php echo e(route('admin.beverages.destroy', $b)); ?>" class="flex-grow-1" onsubmit="return confirm('Eliminare definitivamente <?php echo e($b->name); ?>?')">
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

      <?php if(method_exists($beverages,'hasPages') && $beverages->hasPages()): ?>
        <div class="d-flex justify-content-center mt-5"><?php echo e($beverages->links()); ?></div>
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

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/admin/beverages/index.blade.php ENDPATH**/ ?>