<div class="modal fade" id="commandPalette" tabindex="-1" aria-labelledby="commandPaletteLabel" aria-hidden="true"
  data-pizzas-index="{{ route('admin.pizzas.index') }}" data-pizzas-create="{{ route('admin.pizzas.create') }}"
  data-ingredients-index="{{ route('admin.ingredients.index') }}" data-ingredients-create="{{ route('admin.ingredients.create') }}"
  data-categories-index="{{ route('admin.categories.index') }}" data-categories-create="{{ route('admin.categories.create') }}"
  data-beverages-index="{{ route('admin.beverages.index') }}" data-beverages-create="{{ route('admin.beverages.create') }}">
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

{{-- JS inizializzato da resources/js/features/commandPalette.js --}}