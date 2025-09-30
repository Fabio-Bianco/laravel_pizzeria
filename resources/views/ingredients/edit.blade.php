@extends('layouts.app')

@section('content')
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
                        <select id="allergens" name="allergens[]" multiple class="form-select @error('allergens') is-invalid @enderror" size="6">
                            @foreach ($allergens as $allergen)
                                <option value="{{ $allergen->id }}" @selected($ingredient->allergens->pluck('id')->contains($allergen->id))>{{ $allergen->name }}</option>
                            @endforeach
                        </select>
                        @error('allergens')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
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
@endsection
