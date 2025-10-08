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
          <div class="list-item-dessert py-3 border-bottom">
            <div class="row align-items-center g-3">
              
              <div class="col-md-2 col-3">
                <?php if(!empty($d->image_path)): ?>
                  <img src="<?php echo e(asset('storage/'.$d->image_path)); ?>" alt="Dolce <?php echo e($d->name); ?>" class="img-fluid rounded" style="height:60px;width:60px;object-fit:cover;">
                <?php else: ?>
                  <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:60px;width:60px;">
                    <i class="fas fa-cookie-bite text-muted" aria-hidden="true"></i>
                  </div>
                <?php endif; ?>
              </div>

              
              <div class="col-md-5 col-6">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="flex-grow-1 min-w-0">
                    <h6 class="mb-1 fw-bold text-truncate">
                      <a href="<?php echo e(route('admin.desserts.show', $d)); ?>" class="text-decoration-none text-dark"><?php echo e($d->name); ?></a>
                    </h6>
                    <small class="text-muted d-block text-truncate"><?php echo e($d->description ?? 'Nessuna descrizione'); ?></small>

                    <?php if(\Illuminate\Support\Facades\View::exists('components.allergen-display')): ?>
                      <div class="mt-1">
                        <?php if (isset($component)) { $__componentOriginal5b439834db70954e0d348c0a339254ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b439834db70954e0d348c0a339254ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.allergen-display','data' => ['allergens' => $d,'mode' => 'minimal','maxVisible' => 3]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('allergen-display'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['allergens' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($d),'mode' => 'minimal','maxVisible' => 3]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5b439834db70954e0d348c0a339254ee)): ?>
<?php $attributes = $__attributesOriginal5b439834db70954e0d348c0a339254ee; ?>
<?php unset($__attributesOriginal5b439834db70954e0d348c0a339254ee); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5b439834db70954e0d348c0a339254ee)): ?>
<?php $component = $__componentOriginal5b439834db70954e0d348c0a339254ee; ?>
<?php unset($__componentOriginal5b439834db70954e0d348c0a339254ee); ?>
<?php endif; ?>
                      </div>
                    <?php endif; ?>
                  </div>

                  <?php if(!empty($d->is_gluten_free)): ?>
                    <span class="badge bg-info text-dark ms-2" title="Senza glutine">🌾 Senza Glutine</span>
                  <?php endif; ?>
                </div>
              </div>

              
              <div class="col-md-2 col-3 text-center">
                <span class="h6 text-success fw-bold">€<?php echo e(number_format($d->price ?? 0, 2, ',', '.')); ?></span>
              </div>

              
              <div class="col-md-3 col-12">
                <div class="d-flex flex-wrap gap-2 w-100 actions-flex">
                  <a href="<?php echo e(route('admin.desserts.show', $d)); ?>"
                     class="btn btn-view btn-sm flex-grow-1"
                     data-bs-toggle="tooltip" title="Dettagli">
                    <i class="fas fa-eye me-1"></i><span class="d-none d-lg-inline">Dettagli</span>
                  </a>

                  <a href="<?php echo e(route('admin.desserts.edit', $d)); ?>"
                     class="btn btn-edit btn-sm flex-grow-1"
                     data-bs-toggle="tooltip" title="Modifica">
                    <i class="fas fa-edit me-1"></i><span class="d-none d-lg-inline">Modifica</span>
                  </a>

                  <form method="POST"
                        action="<?php echo e(route('admin.desserts.destroy', $d)); ?>"
                        class="flex-grow-1"
                        onsubmit="return confirm('Eliminare definitivamente <?php echo e($d->name); ?>?')">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit"
                            class="btn btn-delete btn-sm w-100 d-flex align-items-center justify-content-center"
                            data-bs-toggle="tooltip" title="Elimina">
                      <i class="fas fa-trash me-1"></i><span>Elimina</span>
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
  /* Evita qualsiasi clipping dell'elenco */
  .list-wrapper, .list-container { overflow: visible; }
  /* Migliora la resa su layout stretti */
  .actions-flex .btn { min-width: 110px; white-space: nowrap; }
  @media (max-width: 576px) {
    .actions-flex .btn { min-width: 100%; }
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