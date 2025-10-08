<div class="position-sticky top-0 z-3 bg-white border-bottom d-print-none" style="--bs-bg-opacity: .98;">
  <div class="container py-2 d-flex align-items-center gap-2 flex-wrap">
    <?php
      $isPizzas = request()->routeIs('admin.pizzas.*');
      $isIngredients = request()->routeIs('admin.ingredients.*');
      $isCategories = request()->routeIs('admin.categories.*');
      $isBeverages = request()->routeIs('admin.beverages.*');
      $indexUrl = $isPizzas ? route('admin.pizzas.index') : ($isIngredients ? route('admin.ingredients.index') : ($isCategories ? route('admin.categories.index') : ($isBeverages ? route('admin.beverages.index') : url()->current())));
      $placeholder = $isPizzas ? 'Cerca pizze…' : ($isIngredients ? 'Cerca ingredienti…' : ($isCategories ? 'Cerca categorie…' : ($isBeverages ? 'Cerca bevande…' : 'Cerca…')));
    ?>
    <!-- Search contextual only -->
    <form class="d-flex flex-grow-1" role="search" action="<?php echo e($indexUrl); ?>" method="get" data-index-url="<?php echo e($indexUrl); ?>">
      <input type="search" class="form-control" placeholder="<?php echo e($placeholder); ?>" aria-label="Cerca" id="globalSearchInput" value="<?php echo e(request('search')); ?>">
    </form>
  </div>
</div>

<?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/layouts/sticky-header.blade.php ENDPATH**/ ?>