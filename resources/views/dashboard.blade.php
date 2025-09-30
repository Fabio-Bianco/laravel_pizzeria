<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0">Pannello di controllo</h2>
    </x-slot>

    <div class="row g-3">
        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div style="font-size:2rem;">📂</div>
                        <div class="mt-2 fw-semibold">Categorie</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('admin.pizzas.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div style="font-size:2rem;">🍕</div>
                        <div class="mt-2 fw-semibold">Pizze</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('admin.ingredients.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div style="font-size:2rem;">🥬</div>
                        <div class="mt-2 fw-semibold">Ingredienti</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
            <a href="{{ route('admin.allergens.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div style="font-size:2rem;">⚠️</div>
                        <div class="mt-2 fw-semibold">Allergeni</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>
