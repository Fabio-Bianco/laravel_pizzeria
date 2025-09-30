<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categoria: {{ $category->name }}</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8 space-y-4">
        <div class="bg-white p-6 rounded shadow">
            <p class="mt-2">{{ $category->description }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.categories.edit', $category) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Modifica</a>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Sicuro?')">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 bg-red-600 text-white rounded">Elimina</button>
            </form>
            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-200 rounded">Torna all'elenco</a>
        </div>
    </div>
</x-app-layout>
