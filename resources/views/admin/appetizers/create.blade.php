<x-app-layout>
    <x-page-header title="Nuovo antipasto" :items="[['label' => 'Antipasti', 'url' => route('admin.appetizers.index')], ['label' => 'Nuovo']]" :backUrl="route('admin.appetizers.index')" />
    <div class="col-12 col-lg-6 mx-auto py-4">
        <form action="{{ route('admin.appetizers.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm" novalidate>
            @csrf
            <div class="mb-3">
                <x-input-label for="name" value="Nome" />
                <x-text-input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
            </div>
            <div class="mb-3">
                <x-input-label for="price" value="Prezzo" />
                <x-text-input id="price" name="price" type="number" step="0.01" class="form-control" value="{{ old('price') }}" required />
                <x-input-error :messages="$errors->get('price')" class="mt-2 text-danger" />
            </div>
            <div class="mb-3">
                <x-input-label for="description" value="Descrizione" />
                <textarea id="description" name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2 text-danger" />
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-secondary">Annulla</a>
                <x-primary-button class="btn btn-primary">Crea</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
