<x-app-layout>
    <x-slot name="header">
        <x-page-header :title="'Modifica: ' . $ingredient->name" :items="[['label' => 'Ingredienti', 'url' => route('admin.ingredients.index')], ['label' => $ingredient->name], ['label' => 'Modifica']]" :backUrl="route('admin.ingredients.index')" />
    </x-slot>

    <div class="row justify-content-center py-4">
        <div class="col-12 col-lg-8 col-xl-6">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <span class="h6 mb-0">Dettagli ingrediente</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.ingredients.update', $ingredient) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nome</label>
                            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $ingredient->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label for="allergens" class="form-label">Allergeni</label>
                            <select id="allergens" name="allergens[]" multiple class="form-select @error('allergens') is-invalid @enderror" data-choices>
                                @foreach ($allergens as $a)
                                    <option value="{{ $a->id }}" @selected($ingredient->allergens->pluck('id')->contains($a->id))>{{ $a->name }}</option>
                                @endforeach
                            </select>
                            @error('allergens')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" value="1" id="is_tomato" name="is_tomato" @checked(old('is_tomato', $ingredient->is_tomato))>
                            <label class="form-check-label" for="is_tomato">
                                Pomodoro
                            </label>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.ingredients.index') }}" class="btn btn-outline-secondary">Annulla</a>
                            <button type="submit" class="btn btn-primary">Salva</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
