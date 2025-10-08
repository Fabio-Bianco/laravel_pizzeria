<?php $__env->startSection('title', 'I Tuoi Dessert'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
  <div class="mb-2" style="font-size:3rem;">🍰</div>
  <h1 class="display-6 fw-bold text-dark mb-2">I Tuoi Dolci</h1>
  <p class="lead text-muted mb-4">Tiramisù, gelati e delizie dolci</p>

  
  <div class="d-flex justify-content-center mb-4">
    <a href="<?php echo e(route('admin.desserts.create')); ?>"
       class="btn btn-create btn-lg px-4 py-3"
       role="button"
       aria-label="Aggiungi un nuovo dolce"
       data-bs-toggle="tooltip" title="Crea un nuovo dolce">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuovo Dolce
    </a>
  </div>

  
  <div class="visually-hidden" aria-live="polite" aria-atomic="true" id="view-change-announce"></div>
  <div class="mt-3">
    <?php $total = method_exists($desserts,'total') ? $desserts->total() : ($desserts->count() ?? 0); ?>
    <span class="badge bg-success fs-6 px-3 py-2">Hai <?php echo e($total); ?> <?php echo e($total == 1 ? 'dolce' : 'dolci'); ?> nel menu</span>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php $count = ($desserts->count() ?? 0); ?>

  <?php if($count === 0): ?>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🍰</div>
          <h3 class="fw-bold text-dark mb-3">Nessun dessert presente</h3>
          <p class="text-muted mb-4">Aggiungi il primo dolce al tuo menu.</p>
          <a class="btn btn-success btn-lg px-4 py-3 fw-bold" href="<?php echo e(route('admin.desserts.create')); ?>">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea il Primo Dessert
          </a>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div id="desserts-container" class="transition-container list-wrapper">

      <div class="list-container">
        <?php $__currentLoopData = $desserts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="pizza-card card shadow-sm border-0 mb-3">
            <div class="card-body py-3 px-3">
              <div class="d-flex align-items-center gap-3 flex-wrap flex-md-nowrap">
                <div class="pizza-icon flex-shrink-0 d-flex align-items-center justify-content-center bg-light rounded-circle" style="height:56px;width:56px;">
                  <?php if(!empty($d->image_path)): ?>
                    <img src="<?php echo e(asset('storage/'.$d->image_path)); ?>" alt="Dolce <?php echo e($d->name); ?>" class="img-fluid rounded-circle" style="height:56px;width:56px;object-fit:cover;">
                  <?php else: ?>
                    <i class="fas fa-cookie-bite text-warning fs-3" aria-hidden="true"></i>
                  <?php endif; ?>
                </div>
                <div class="flex-grow-1 min-w-0">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="d-flex align-items-center flex-wrap" style="min-width:0;">
                      <span class="fw-bold fs-5 text-dark text-truncate d-inline-block" style="max-width:220px;"><?php echo e($d->name); ?></span>
                    </div>
                    <?php if(!empty($d->is_gluten_free)): ?>
                      <span class="badge rounded-pill bg-glutenfree text-glutenfree ms-2 align-middle" style="font-size:0.85em;font-weight:600;padding:0.18em 0.7em;vertical-align:middle;letter-spacing:0.02em;" title="Senza glutine">Senza Glutine</span>
                    <?php endif; ?>
                  </div>
                  <?php if(!empty($d->description)): ?>
                    <div class="mb-1"><small class="text-muted text-truncate d-block" style="max-width:320px;"><?php echo e(\Illuminate\Support\Str::limit($d->description, 120)); ?></small></div>
                  <?php endif; ?>
                  <?php $collapseId = 'ingredients-collapse-dessert-'.$d->id; $collapseAllergenId = 'allergens-collapse-dessert-'.$d->id; ?>
                  <div class="d-flex flex-row gap-2 mt-2">
                    <button class="btn btn-sm d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo e($collapseId); ?>" aria-expanded="false" aria-controls="<?php echo e($collapseId); ?>" style="border:1.5px solid #8fd19e;color:#388e3c;background:transparent;">
                      <span style="font-size:1.2em;line-height:1;color:#388e3c;">&#9776;</span> <span>Vedi ingredienti</span>
                    </button>
                    <button class="btn btn-sm d-inline-flex align-items-center gap-1" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo e($collapseAllergenId); ?>" aria-expanded="false" aria-controls="<?php echo e($collapseAllergenId); ?>" style="border:1.5px solid #ffe066;color:#bfa100;background:transparent;">
                      <span style="font-size:1.2em;line-height:1;color:#bfa100;">&#9776;</span> <span>Vedi allergeni</span>
                    </button>
                  </div>
                  <div class="collapse mt-2 w-100" id="<?php echo e($collapseId); ?>">
                    <?php if($d->ingredients && $d->ingredients->count() > 0): ?>
                      <ul class="list-unstyled mb-0 ps-2 small">
                        <?php $__currentLoopData = $d->ingredients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingredient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li class="py-1 d-flex align-items-center gap-2">
                            <span><?php echo e($ingredient->name); ?></span>
                          </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </ul>
                    <?php else: ?>
                      <div class="text-muted small ps-2">Nessun ingrediente</div>
                    <?php endif; ?>
                  </div>
                  <div class="collapse mt-2 w-100" id="<?php echo e($collapseAllergenId); ?>">
                    <?php if($d->allergens && $d->allergens->count() > 0): ?>
                      <ul class="list-unstyled mb-0 ps-2 small">
                        <?php $__currentLoopData = $d->allergens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allergen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <li class="py-1 d-flex align-items-center gap-2">
                            <span><?php echo e($allergen->name); ?></span>
                          </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </ul>
                    <?php else: ?>
                      <div class="text-muted small ps-2">Nessun allergene</div>
                    <?php endif; ?>
                  </div>
                </div>
                <div class="pizza-actions d-flex flex-column flex-md-row gap-2 ms-md-3 mt-3 mt-md-0">
                  <a href="<?php echo e(route('admin.desserts.show', $d)); ?>" class="btn btn-outline-primary btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Dettagli" style="border:1.5px solid #1976d2;color:#1976d2;background:transparent;">
                    <i class="fas fa-eye me-1" style="color:#1976d2;"></i><span class="d-none d-md-inline" style="color:#1976d2;">Dettagli</span>
                  </a>
                  <a href="<?php echo e(route('admin.desserts.edit', $d)); ?>" class="btn btn-outline-success btn-sm d-flex align-items-center justify-content-center" data-bs-toggle="tooltip" title="Modifica" style="border:1.5px solid #388e3c;color:#388e3c;background:transparent;">
                    <i class="fas fa-edit me-1" style="color:#388e3c;"></i><span class="d-none d-md-inline" style="color:#388e3c;">Modifica</span>
                  </a>
                  <form method="POST" action="<?php echo e(route('admin.desserts.destroy', $d)); ?>" onsubmit="return confirm('Eliminare definitivamente <?php echo e($d->name); ?>?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center justify-content-center w-100" data-bs-toggle="tooltip" title="Elimina" style="border:1.5px solid #d32f2f;color:#d32f2f;background:transparent;">
                      <i class="fas fa-trash me-1" style="color:#d32f2f;"></i><span class="d-none d-md-inline" style="color:#d32f2f;">Elimina</span>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>

      <?php if(method_exists($desserts,'hasPages') && $desserts->hasPages()): ?>
        <div class="d-flex justify-content-center mt-5"><?php echo e($desserts->links()); ?></div>
      <?php endif; ?>
    </div>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
  .list-wrapper, .list-container { overflow: visible; }
  .actions-flex .btn { min-width: 110px; white-space: nowrap; }
  @media (max-width: 576px) {
    .actions-flex .btn { min-width: 100%; }
  }
  /* Badge vegano e senza glutine: palette rilassante */
  .bg-green-veg {
    background: #e6f4ea;
    border: 1.5px solid #6bbf59;
  }
  .text-green-veg {
    color: #388e3c !important;
  }
  .bg-glutenfree {
    background: #f3f6fa;
    border: 1.5px solid #7e9ebd;
  }
  .text-glutenfree {
    color: #3b5c7e !important;
  }
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

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/admin/desserts/index.blade.php ENDPATH**/ ?>