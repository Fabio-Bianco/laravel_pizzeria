@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-12 col-lg-10 col-xl-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h1 class="h5 mb-0">Modifica pizza</h1>
                <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-secondary btn-sm">Indietro</a>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pizzas.update', $pizza) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label">Nome</label>
                            <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $pizza->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="price" class="form-label">Prezzo</label>
                            <input id="price" name="price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $pizza->price) }}" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label">Descrizione</label>
                            <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $pizza->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="category_id" class="form-label">Categoria</label>
                            <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                                <option value="">-</option>
                                @foreach ($categories as $c)
                                    <option value="{{ $c->id }}" @selected(old('category_id', $pizza->category_id) == $c->id)>{{ $c->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="ingredients" class="form-label mb-0">Ingredienti</label>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#newIngredientModal">+ Nuovo ingrediente</button>
                            </div>
                                            <select id="ingredients" name="ingredients[]" multiple class="form-select" data-choices placeholder="Seleziona ingredienti..." data-store-url="{{ route('admin.ingredients.store') }}">
                                @foreach ($ingredients as $i)
                                    <option value="{{ $i->id }}" @selected($pizza->ingredients->pluck('id')->contains($i->id))>{{ $i->name }}</option>
                                @endforeach
                            </select>
                            @error('ingredients')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-secondary">Annulla</a>
                        <button type="submit" class="btn btn-primary">Salva</button>
                    </div>
                </form>
            </div>
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

    
    </div>
</div>
@endsection
