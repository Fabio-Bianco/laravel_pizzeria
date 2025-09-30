<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Modifica Allergene</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6 sm:px-6 lg:px-8">
    <form action="{{ route('admin.allergens.update', $allergen) }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
            @csrf
            @method('PUT')
            <div>
                <x-input-label for="name" value="Nome" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $allergen->name) }}" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.allergens.index') }}" class="px-4 py-2 bg-gray-200 rounded">Annulla</a>
                <x-primary-button>Salva</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
