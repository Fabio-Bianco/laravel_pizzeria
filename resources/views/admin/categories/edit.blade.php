<x-app-layout>
    <x-page-header :title="'Modifica: ' . $category->name" :items="[['label' => 'Categorie', 'url' => route('admin.categories.index')], ['label' => $category->name], ['label' => 'Modifica']]" :backUrl="route('admin.categories.index')" />
        <div class="row justify-content-center py-4">
            <div class="col-12 col-lg-8 col-xl-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <span class="h6 mb-0">Dettagli categoria</span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.categories.update', $category) }}" method="POST" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">Nome</label>
                                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Descrizione</label>
                                <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="1" id="is_white" name="is_white" @checked(old('is_white', $category->is_white))>
                                <label class="form-check-label" for="is_white">
                                    Bianca (senza pomodoro)
                                </label>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Annulla</a>
                                <button type="submit" class="btn btn-primary">Salva</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
