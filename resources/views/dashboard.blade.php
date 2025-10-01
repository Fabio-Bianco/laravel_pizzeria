<x-app-layout>

    <!-- Prima riga: Antipasti, Pizze, Bevande -->
    <div class="row g-3 mb-1">
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('admin.appetizers.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="x-emoji">🥗</div>
                        <div class="mt-2 fw-semibold">Antipasti</div>
                        <div class="text-muted small">{{ $countAppetizers ?? '' }} elementi</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('admin.pizzas.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="x-emoji">🍕</div>
                        <div class="mt-2 fw-semibold">Pizze</div>
                        <div class="text-muted small">{{ $countPizzas ?? '' }} elementi</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('admin.beverages.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                            <div class="x-emoji">🥤</div>
                        <div class="mt-2 fw-semibold">Bevande</div>
                        <div class="text-muted small">{{ $countBeverages ?? '' }} elementi</div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Seconda riga: Allergeni, Ingredienti -->
    <div class="row g-3">
        <div class="col-12 col-sm-6 col-lg-6">
            <a href="{{ route('admin.allergens.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="x-emoji">⚠️</div>
                        <div class="mt-2 fw-semibold">Allergeni</div>
                        <div class="text-muted small">{{ $countAllergens ?? '' }} elementi</div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-12 col-sm-6 col-lg-6">
            <a href="{{ route('admin.ingredients.index') }}" class="text-decoration-none">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center">
                        <div class="x-emoji">🥬</div>
                        <div class="mt-2 fw-semibold">Ingredienti</div>
                        <div class="text-muted small">{{ $countIngredients ?? '' }} elementi</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>
