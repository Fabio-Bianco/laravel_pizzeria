<?php $__env->startSection('title', 'Le Tue Pizze'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
  <div class="mb-2" style="font-size:3rem;">🍕</div>
  <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Pizze</h1>
  <p class="lead text-muted mb-4">Gestisci le pizze del tuo menu</p>

  <div class="d-flex justify-content-center">
    <a href="<?php echo e(route('admin.pizzas.create')); ?>"
       class="btn btn-create btn-lg px-4 py-3"
       title="Aggiungi nuova pizza" data-bs-toggle="tooltip">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuova Pizza
    </a>
  </div>

  <div class="mt-3">
    <?php $total = method_exists($pizzas,'total') ? $pizzas->total() : ($pizzas->count() ?? 0); ?>
    <span class="badge badge-success fs-6 px-3 py-2">
      Hai <?php echo e($total); ?> <?php echo e($total == 1 ? 'pizza' : 'pizze'); ?> nel menu
    </span>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php if(($pizzas->count() ?? 0) === 0): ?>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🍕</div>
          <h3 class="fw-bold text-dark mb-3">Nessuna pizza presente</h3>
          <p class="text-muted mb-4">Crea la tua prima pizza per iniziare.</p>
          <a class="btn btn-create btn-lg px-4 py-3" href="<?php echo e(route('admin.pizzas.create')); ?>">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea la Prima Pizza
          </a>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="row g-4">
      <?php $__currentLoopData = $pizzas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-12 col-md-6 col-xl-4">
          <div class="card h-100 border-0 shadow-sm">
            <?php if(!empty($p->image_path)): ?>
              <div class="position-relative">
                <img src="<?php echo e(asset('storage/'.$p->image_path)); ?>"
                     alt="Immagine pizza <?php echo e($p->name); ?>"
                     class="card-img-top" style="height:200px;object-fit:cover;">
                <?php if(!empty($p->is_vegan)): ?>
                  <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">
                    <i class="fas fa-leaf me-1"></i> Vegana
                  </span>
                <?php endif; ?>
                <?php if(!empty($p->is_special)): ?>
                  <span class="position-absolute top-0 end-0 badge bg-warning text-dark m-2">
                    ⭐ Special
                  </span>
                <?php endif; ?>
              </div>
            <?php else: ?>
              <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                <div class="text-center text-muted">
                  <i class="fas fa-pizza-slice fs-1 mb-2"></i>
                  <div class="small">Nessuna immagine</div>
                </div>
              </div>
            <?php endif; ?>

            <div class="card-body d-flex flex-column">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <a href="<?php echo e(route('admin.pizzas.show', $p)); ?>"
                   class="h5 mb-0 text-decoration-none fw-bold text-dark">
                  <?php echo e($p->name); ?>

                </a>
                <div class="h5 mb-0 text-success fw-bold">
                  €<?php echo e(number_format($p->price ?? 0, 2, ',', '.')); ?>

                </div>
              </div>

              <?php if(!empty($p->description)): ?>
                <p class="card-text text-muted mb-3">
                  <?php echo e(\Illuminate\Support\Str::limit($p->description, 120)); ?>

                </p>
              <?php endif; ?>

              <?php if(!empty($p->ingredients) && $p->ingredients->isNotEmpty()): ?>
                <div class="mb-3">
                  <div class="small text-muted mb-1">
                    <i class="fas fa-seedling me-1" aria-hidden="true"></i> Ingredienti:
                  </div>
                  <div class="d-flex flex-wrap gap-1">
                    <?php $__currentLoopData = $p->ingredients->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ingredient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <span class="badge bg-light text-dark"><?php echo e($ingredient->name); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if($p->ingredients->count() > 4): ?>
                      <span class="badge bg-secondary">+<?php echo e($p->ingredients->count() - 4); ?></span>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endif; ?>

              <div class="d-flex gap-2 mt-auto">
                <a class="btn btn-view btn-sm flex-fill"
                   href="<?php echo e(route('admin.pizzas.show', $p)); ?>"
                   data-bs-toggle="tooltip" title="Dettagli">
                  <i class="fas fa-eye me-1" aria-hidden="true"></i> Dettagli
                </a>
                <a class="btn btn-edit btn-sm flex-fill"
                   href="<?php echo e(route('admin.pizzas.edit', $p)); ?>"
                   data-bs-toggle="tooltip" title="Modifica">
                  <i class="fas fa-edit me-1" aria-hidden="true"></i> Modifica
                </a>
                <form method="POST" action="<?php echo e(route('admin.pizzas.destroy', $p)); ?>" class="flex-fill"
                      onsubmit="return confirm('Eliminare definitivamente <?php echo e($p->name); ?>?')">
                  <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                  <button type="submit" class="btn btn-delete btn-sm w-100" data-bs-toggle="tooltip" title="Elimina">
                    <i class="fas fa-trash me-1" aria-hidden="true"></i> Elimina
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <?php if(method_exists($pizzas,'hasPages') && $pizzas->hasPages()): ?>
      <div class="d-flex justify-content-center mt-5">
        <?php echo e($pizzas->links()); ?>

      </div>
    <?php endif; ?>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/admin/pizzas/index.blade.php ENDPATH**/ ?>