<?php $__env->startSection('title', 'Le Tue Bevande'); ?>

<?php $__env->startSection('header'); ?>
<div class="text-center py-4">
  <div class="mb-2" style="font-size:3rem;">🥤</div>
  <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Bevande</h1>
  <p class="lead text-muted mb-4">Acqua, bibite, birre, vini e altro</p>

  <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
    <a href="<?php echo e(route('admin.beverages.create')); ?>"
       class="btn btn-create btn-lg px-4 py-3"
       title="Aggiungi bevanda" data-bs-toggle="tooltip">
      <i class="fas fa-plus me-2" aria-hidden="true"></i> Aggiungi Nuova Bevanda
    </a>
    
    
    <div class="view-toggle-controls" role="group" aria-label="Seleziona vista visualizzazione">
      <div class="btn-group" role="radiogroup" aria-label="Modalità visualizzazione bevande">
        <input type="radio" class="btn-check" name="beveragesViewMode" id="beveragesListView" value="list" checked>
        <label class="btn btn-outline-secondary" for="beveragesListView" 
               title="Visualizzazione a elenco" 
               aria-label="Cambia a visualizzazione a elenco">
          <i class="fas fa-list me-1" aria-hidden="true"></i>
          <span class="d-none d-sm-inline">Elenco</span>
        </label>

        <input type="radio" class="btn-check" name="beveragesViewMode" id="beveragesCardView" value="card">
        <label class="btn btn-outline-secondary" for="beveragesCardView" 
               title="Visualizzazione a griglia" 
               aria-label="Cambia a visualizzazione a griglia">
          <i class="fas fa-th-large me-1" aria-hidden="true"></i>
          <span class="d-none d-sm-inline">Griglia</span>
        </label>
      </div>
    </div>
  </div>

  <div class="mt-3">
    <?php $total = method_exists($beverages,'total') ? $beverages->total() : ($beverages->count() ?? 0); ?>
    <span class="badge badge-success fs-6 px-3 py-2">
      Hai <?php echo e($total); ?> <?php echo e($total == 1 ? 'bevanda' : 'bevande'); ?> nel menu
    </span>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php if(($beverages->count() ?? 0) === 0): ?>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🥤</div>
          <h3 class="fw-bold text-dark mb-3">Nessuna bevanda presente</h3>
          <p class="text-muted mb-4">Aggiungi la prima bevanda alla carta.</p>
          <a class="btn btn-create btn-lg px-4 py-3" href="<?php echo e(route('admin.beverages.create')); ?>">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea la Prima Bevanda
          </a>
        </div>
      </div>
    </div>
  <?php else: ?>
    
    <div id="beverages-container" class="transition-container">
      
      
      <div id="beverages-list-view" class="view-mode active" role="region" aria-label="Vista a elenco delle bevande">
        <div class="list-container">
          <?php $__currentLoopData = $beverages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="list-item-pizza border-bottom py-3">
              <div class="row align-items-center">
                <div class="col-md-2 col-3">
                  <?php if(!empty($b->image_path)): ?>
                    <img src="<?php echo e(asset('storage/'.$b->image_path)); ?>" 
                         alt="Bevanda <?php echo e($b->name); ?>" 
                         class="img-fluid rounded" style="height:60px;width:60px;object-fit:cover;">
                  <?php else: ?>
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:60px;width:60px;">
                      <i class="fas fa-glass-water text-muted"></i>
                    </div>
                  <?php endif; ?>
                </div>
                <div class="col-md-5 col-6">
                  <h6 class="mb-1 fw-bold">
                    <a href="<?php echo e(route('admin.beverages.show', $b)); ?>" class="text-decoration-none text-dark">
                      <?php echo e($b->name); ?>

                    </a>
                  </h6>
                  <small class="text-muted d-block"><?php echo e($b->description ?? 'Nessuna descrizione'); ?></small>
                  
                  
                  <div class="mt-1">
                    <?php if (isset($component)) { $__componentOriginal5b439834db70954e0d348c0a339254ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b439834db70954e0d348c0a339254ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.allergen-display','data' => ['allergens' => $b,'mode' => 'minimal','maxVisible' => 3]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('allergen-display'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['allergens' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($b),'mode' => 'minimal','maxVisible' => 3]); ?>
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
                </div>
                <div class="col-md-2 col-3 text-center">
                  <span class="h6 text-success fw-bold">€<?php echo e(number_format($b->price ?? 0, 2, ',', '.')); ?></span>
                  <?php if(!empty($b->is_alcoholic)): ?>
                    <br><small class="badge bg-warning text-dark">🍺 Alcolica</small>
                  <?php endif; ?>
                </div>
                <div class="col-md-3 col-12 mt-2 mt-md-0">
                  <div class="btn-group btn-group-sm w-100">
                    <a href="<?php echo e(route('admin.beverages.show', $b)); ?>" class="btn btn-view btn-sm flex-fill">
                      <i class="fas fa-eye me-1" aria-hidden="true"></i>
                      <span class="d-none d-sm-inline">Dettagli</span>
                    </a>
                    <a href="<?php echo e(route('admin.beverages.edit', $b)); ?>" class="btn btn-edit btn-sm flex-fill">
                      <i class="fas fa-edit me-1" aria-hidden="true"></i>
                      <span class="d-none d-sm-inline">Modifica</span>
                    </a>
                    <form method="POST" action="<?php echo e(route('admin.beverages.destroy', $b)); ?>" class="flex-fill d-inline"
                          onsubmit="return confirm('Eliminare definitivamente <?php echo e($b->name); ?>?')">
                      <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                      <button type="submit" class="btn btn-delete btn-sm w-100" data-bs-toggle="tooltip" title="Elimina">
                        <i class="fas fa-trash me-1" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline">Elimina</span>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
      
      
      <div id="beverages-card-view" class="view-mode" role="region" aria-label="Vista a griglia delle bevande" style="display: none;">
        <div class="row g-4">
          <?php $__currentLoopData = $beverages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12 col-md-6 col-xl-4">
              <div class="card h-100 border-0 shadow-sm">
                <?php if(!empty($b->image_path)): ?>
                  <div class="position-relative">
                    <img src="<?php echo e(asset('storage/'.$b->image_path)); ?>"
                         alt="Immagine bevanda <?php echo e($b->name); ?>"
                         class="card-img-top" style="height:200px;object-fit:cover;">
                    <?php if(!empty($b->is_alcoholic)): ?>
                      <span class="position-absolute top-0 start-0 badge bg-warning text-dark m-2">
                        🍺 Alcolica
                      </span>
                    <?php endif; ?>
                  </div>
                <?php else: ?>
                  <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                    <div class="text-center text-muted">
                      <i class="fas fa-glass-water fs-1 mb-2"></i>
                      <div class="small">Nessuna immagine</div>
                    </div>
                  </div>
                <?php endif; ?>

                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                    <a href="<?php echo e(route('admin.beverages.show', $b)); ?>"
                       class="h5 mb-0 text-decoration-none fw-bold text-dark">
                      <?php echo e($b->name); ?>

                    </a>
                    <div class="h5 mb-0 text-success fw-bold">
                      €<?php echo e(number_format($b->price ?? 0, 2, ',', '.')); ?>

                    </div>
                  </div>

                  <?php if(!empty($b->description)): ?>
                    <p class="card-text text-muted mb-3" style="line-height:1.5;">
                      <?php echo e(\Illuminate\Support\Str::limit($b->description, 120)); ?>

                    </p>
                  <?php endif; ?>

                  
                  <div class="mb-3">
                    <?php if (isset($component)) { $__componentOriginal5b439834db70954e0d348c0a339254ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b439834db70954e0d348c0a339254ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.allergen-display','data' => ['allergens' => $b,'mode' => 'compact','maxVisible' => 3]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('allergen-display'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['allergens' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($b),'mode' => 'compact','maxVisible' => 3]); ?>
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

                  <div class="d-flex gap-2 mt-auto">
                    <a class="btn btn-view btn-sm flex-fill"
                       href="<?php echo e(route('admin.beverages.show', $b)); ?>"
                       data-bs-toggle="tooltip" title="Dettagli">
                      <i class="fas fa-eye me-1" aria-hidden="true"></i> Dettagli
                    </a>
                    <a class="btn btn-edit btn-sm flex-fill"
                       href="<?php echo e(route('admin.beverages.edit', $b)); ?>"
                       data-bs-toggle="tooltip" title="Modifica">
                      <i class="fas fa-edit me-1" aria-hidden="true"></i> Modifica
                    </a>
                    <form method="POST" action="<?php echo e(route('admin.beverages.destroy', $b)); ?>" class="flex-fill"
                          onsubmit="return confirm('Eliminare definitivamente <?php echo e($b->name); ?>?')">
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
      </div>
      
    </div>

    <?php if(method_exists($beverages,'hasPages') && $beverages->hasPages()): ?>
      <div class="d-flex justify-content-center mt-5">
        <?php echo e($beverages->links()); ?>

      </div>
    <?php endif; ?>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php if(($beverages->count() ?? 0) === 0): ?>
    <div class="row justify-content-center">
      <div class="col-lg-6">
        <div class="text-center py-5">
          <div class="mb-4" style="font-size:5rem;opacity:.5;">🥤</div>
          <h3 class="fw-bold text-dark mb-3">Nessuna bevanda presente</h3>
          <p class="text-muted mb-4">Aggiungi la prima bevanda alla carta.</p>
          <a class="btn btn-create btn-lg px-4 py-3" href="<?php echo e(route('admin.beverages.create')); ?>">
            <i class="fas fa-rocket me-2" aria-hidden="true"></i> Crea la Prima Bevanda
          </a>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="row g-4">
      <?php $__currentLoopData = $beverages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-12 col-md-6 col-xl-4">
          <div class="card h-100 border-0 shadow-sm">
            <?php if(!empty($b->image_path)): ?>
              <div class="position-relative">
                <img src="<?php echo e(asset('storage/'.$b->image_path)); ?>"
                     alt="Immagine bevanda <?php echo e($b->name); ?>"
                     class="card-img-top" style="height:200px;object-fit:cover;">
                <?php if(!empty($b->is_alcoholic)): ?>
                  <span class="position-absolute top-0 start-0 badge bg-danger text-white m-2">
                    18+
                  </span>
                <?php endif; ?>
              </div>
            <?php else: ?>
              <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                <div class="text-center text-muted">
                  <i class="fas fa-wine-glass-alt fs-1 mb-2"></i>
                  <div class="small">Nessuna immagine</div>
                </div>
              </div>
            <?php endif; ?>

            <div class="card-body d-flex flex-column">
              <div class="d-flex justify-content-between align-items-start mb-3">
                <a href="<?php echo e(route('admin.beverages.show', $b)); ?>"
                   class="h5 mb-0 text-decoration-none fw-bold text-dark">
                  <?php echo e($b->name); ?>

                </a>
                <div class="h5 mb-0 text-success fw-bold">
                  €<?php echo e(number_format($b->price ?? 0, 2, ',', '.')); ?>

                </div>
              </div>

              <?php if(!empty($b->description)): ?>
                <p class="card-text text-muted mb-3">
                  <?php echo e(\Illuminate\Support\Str::limit($b->description, 120)); ?>

                </p>
              <?php endif; ?>

              
              <div class="mb-3">
                <?php if (isset($component)) { $__componentOriginal5b439834db70954e0d348c0a339254ee = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5b439834db70954e0d348c0a339254ee = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.allergen-display','data' => ['allergens' => $b,'mode' => 'compact','maxVisible' => 2]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('allergen-display'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['allergens' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($b),'mode' => 'compact','maxVisible' => 2]); ?>
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

              <div class="d-flex gap-2 mt-auto">
                <a class="btn btn-view btn-sm flex-fill"
                   href="<?php echo e(route('admin.beverages.show', $b)); ?>"
                   data-bs-toggle="tooltip" title="Dettagli">
                  <i class="fas fa-eye me-1" aria-hidden="true"></i> Dettagli
                </a>
                <a class="btn btn-edit btn-sm flex-fill"
                   href="<?php echo e(route('admin.beverages.edit', $b)); ?>"
                   data-bs-toggle="tooltip" title="Modifica">
                  <i class="fas fa-edit me-1" aria-hidden="true"></i> Modifica
                </a>
                <form method="POST" action="<?php echo e(route('admin.beverages.destroy', $b)); ?>" class="flex-fill"
                      onsubmit="return confirm('Eliminare definitivamente <?php echo e($b->name); ?>?')">
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

    <?php if(method_exists($beverages,'hasPages') && $beverages->hasPages()): ?>
      <div class="d-flex justify-content-center mt-5">
        <?php echo e($beverages->links()); ?>

      </div>
    <?php endif; ?>
  <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app-modern', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/admin/beverages/index.blade.php ENDPATH**/ ?>