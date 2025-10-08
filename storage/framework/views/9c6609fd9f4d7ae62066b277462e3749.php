<div class="modal fade" id="commandPalette" tabindex="-1" aria-labelledby="commandPaletteLabel" aria-hidden="true"
  data-pizzas-index="<?php echo e(route('admin.pizzas.index')); ?>" data-pizzas-create="<?php echo e(route('admin.pizzas.create')); ?>"
  data-ingredients-index="<?php echo e(route('admin.ingredients.index')); ?>" data-ingredients-create="<?php echo e(route('admin.ingredients.create')); ?>"
  data-categories-index="<?php echo e(route('admin.categories.index')); ?>" data-categories-create="<?php echo e(route('admin.categories.create')); ?>"
  data-beverages-index="<?php echo e(route('admin.beverages.index')); ?>" data-beverages-create="<?php echo e(route('admin.beverages.create')); ?>">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="commandPaletteLabel">Command Palette</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" id="cmdInput" placeholder="Scrivi un comando… (es. Crea Pizza)">
        <ul class="list-group mt-2" id="cmdResults" role="listbox" aria-label="Comandi disponibili"></ul>
      </div>
    </div>
  </div>
</div>

<?php /**PATH C:\Users\Utente\Desktop\project-work\pizzeria-backend\resources\views/components/command-palette.blade.php ENDPATH**/ ?>