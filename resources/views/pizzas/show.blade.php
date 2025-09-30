<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pizza: {{ $pizza->name }}</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8 space-y-4">
        <div class="bg-white p-6 rounded shadow space-y-2">
            <p><strong>Categoria:</strong> {{ optional($pizza->category)->name ?? '-' }}</p>
            <p><strong>Prezzo:</strong> € {{ number_format($pizza->price, 2, ',', '.') }}</p>
            <p>{{ $pizza->description }}</p>
            <div class="mt-4">
                <strong>Ingredienti:</strong>
                <ul class="list-disc ml-6">
                    @forelse ($pizza->ingredients as $i)
                        <li>{{ $i->name }}</li>
                    @empty
                        <li>Nessuno</li>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.pizzas.edit', $pizza) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">Modifica</a>
            <form action="{{ route('admin.pizzas.destroy', $pizza) }}" method="POST" onsubmit="return confirm('Sicuro?')">
                @csrf
                @method('DELETE')
                <button class="px-4 py-2 bg-red-600 text-white rounded">Elimina</button>
            </form>
            <a href="{{ route('admin.pizzas.index') }}" class="px-4 py-2 bg-gray-200 rounded">Torna all'elenco</a>
        </div>
    </div>
</x-app-layout>
