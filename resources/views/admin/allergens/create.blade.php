<x-app-layout>
    <x-page-header title="Nuovo allergene" :items="[['label' => 'Allergeni', 'url' => route('admin.allergens.index')], ['label' => 'Nuovo']]" :backUrl="route('admin.allergens.index')" />
    <div class="col-12 col-lg-6 mx-auto py-4">
    <form action="{{ route('admin.allergens.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
            @csrf
            <div class="mb-3">
                <x-input-label for="name" value="Nome" />
                <x-text-input id="name" name="name" type="text" class="form-control" value="{{ old('name') }}" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger" />
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.allergens.index') }}" class="btn btn-outline-secondary">Annulla</a>
                <x-primary-button class="btn btn-primary">Crea</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
