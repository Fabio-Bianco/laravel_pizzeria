<x-app-layout>
    <x-slot name="header">
    <h2 class="h4 mb-0">Aggiungi Pizza</h2>
    </x-slot>

    <div class="col-12 col-lg-8 mx-auto py-4">
    <form action="{{ route('admin.pizzas.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
            @csrf
            <div class="mb-3">
                <x-input-label for="name" value="Nome" />
                <x-text-input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
            </div>
            <div class="mb-3">
                <x-input-label for="description" value="Descrizione" />
                <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2 text-danger" />
            </div>
            <div class="mb-3">
                <x-input-label for="price" value="Prezzo" />
                <x-text-input id="price" name="price" type="number" step="0.01" class="form-control" value="{{ old('price') }}" required />
                <x-input-error :messages="$errors->get('price')" class="mt-2 text-danger" />
            </div>
            <div class="mb-3">
                <x-input-label for="category_id" value="Categoria" />
                <select id="category_id" name="category_id" class="form-select">
                    <option value="">-</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->id }}" @selected(old('category_id') == $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('category_id')" class="mt-2 text-danger" />
            </div>
                        <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                        <x-input-label for="ingredients" value="Ingredienti" />
                                        <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#newIngredientModal">+ Nuovo ingrediente</button>
                                </div>
                                <select id="ingredients" name="ingredients[]" multiple class="form-select" data-choices placeholder="Seleziona ingredienti...">
                                        @foreach ($ingredients as $i)
                                                <option value="{{ $i->id }}" @selected(collect(old('ingredients', []))->contains($i->id))>{{ $i->name }}</option>
                                        @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('ingredients')" class="mt-2 text-danger" />
                        </div>

                        <!-- Modal nuovo ingrediente -->
                        <div class="modal fade" id="newIngredientModal" tabindex="-1" aria-labelledby="newIngredientModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="newIngredientModalLabel">Nuovo ingrediente</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="ni_name" class="form-label">Nome</label>
                                            <input type="text" id="ni_name" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annulla</button>
                                        <button type="button" id="ni_save" class="btn btn-primary">Crea</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <script>
                        document.addEventListener('DOMContentLoaded', () => {
                            const saveBtn = document.getElementById('ni_save');
                            const nameInput = document.getElementById('ni_name');
                            const select = document.getElementById('ingredients');
                            const modalEl = document.getElementById('newIngredientModal');
                            saveBtn?.addEventListener('click', async () => {
                                const name = nameInput.value.trim();
                                if (!name) { nameInput.focus(); return; }
                                try {
                                    const res = await fetch('{{ route('admin.ingredients.store') }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                            'Accept': 'application/json'
                                        },
                                        body: JSON.stringify({ name })
                                    });
                                    if (!res.ok) throw new Error('Errore creazione ingrediente');
                                    const data = await res.json();
                                    // aggiungi alla select e seleziona
                                    if (select && select._choices) {
                                        select._choices.setChoices([{ value: data.id, label: data.name, selected: true }], 'value', 'label', true);
                                    } else {
                                        const opt = new Option(data.name, data.id, true, true);
                                        select.add(opt);
                                    }
                                    // chiudi modal e pulisci
                                    const bsModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                                    bsModal.hide();
                                    nameInput.value = '';
                                } catch (e) {
                                    alert('Impossibile creare ingrediente.');
                                }
                            });
                        });
                        </script>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-secondary">Annulla</a>
                <x-primary-button class="btn btn-primary">Crea</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
