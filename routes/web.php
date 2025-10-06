<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\AllergenController;
use App\Http\Controllers\AppetizerController;
use App\Http\Controllers\BeverageController;
use App\Http\Controllers\DessertController;
use Illuminate\Support\Facades\Route;
use App\Models\Appetizer;
use App\Models\Pizza;
use App\Models\Beverage;
use App\Models\Dessert;
use App\Models\Allergen;
use App\Models\Ingredient;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'countAppetizers' => Appetizer::count(),
        'countPizzas' => Pizza::count(),
        'countBeverages' => Beverage::count(),
        'countDesserts' => Dessert::count(),
        'countAllergens' => Allergen::count(),
        'countIngredients' => Ingredient::count(),
        'countCategories' => \App\Models\Category::count(),
        // Statistiche più utili
        'latestPizza' => Pizza::latest()->first(),
        'latestAppetizer' => Appetizer::latest()->first(),
        'latestBeverage' => Beverage::latest()->first(),
        'latestDessert' => Dessert::latest()->first(),
        // Tutti gli elementi sono considerati "attivi" senza colonna is_active
        'activePizzas' => Pizza::count(),
        'activeAppetizers' => Appetizer::count(),
        'activeBeverages' => Beverage::count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotte pubbliche (guest) per futura vetrina: nomi guest.* e URL user-friendly
Route::prefix('menu')->name('guest.')->group(function () {
    Route::get('/', function () {
        return view('guest.placeholder', ['title' => 'Menu']);
    })->name('home');

    // Pizze (slug)
    Route::get('/pizze', function () {
        return view('guest.placeholder', ['title' => 'Pizze']);
    })->name('pizzas.index');
    Route::get('/pizze/{pizza:slug}', function (\App\Models\Pizza $pizza) {
        return view('guest.placeholder', ['title' => $pizza->name]);
    })->name('pizzas.show');

    // Antipasti (slug)
    Route::get('/antipasti', function () {
        return view('guest.placeholder', ['title' => 'Antipasti']);
    })->name('appetizers.index');
    Route::get('/antipasti/{appetizer:slug}', function (\App\Models\Appetizer $appetizer) {
        return view('guest.placeholder', ['title' => $appetizer->name]);
    })->name('appetizers.show');

    // Bevande (slug)
    Route::get('/bevande', function () {
        return view('guest.placeholder', ['title' => 'Bevande']);
    })->name('beverages.index');
    Route::get('/bevande/{beverage:slug}', function (\App\Models\Beverage $beverage) {
        return view('guest.placeholder', ['title' => $beverage->name]);
    })->name('beverages.show');

    // Categorie (slug)
    Route::get('/categorie', function () {
        return view('guest.placeholder', ['title' => 'Categorie']);
    })->name('categories.index');
    Route::get('/categorie/{category:slug}', function (\App\Models\Category $category) {
        return view('guest.placeholder', ['title' => $category->name]);
    })->name('categories.show');
});
// Rotte profilo (non prefissate), protette
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Backoffice URLs senza prefisso /admin; i nomi sono in namespace admin.* per coerenza
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('categories', CategoryController::class)->names('admin.categories');
    Route::resource('pizzas', PizzaController::class)->names('admin.pizzas');
    Route::resource('ingredients', IngredientController::class)->names('admin.ingredients');
    Route::resource('allergens', AllergenController::class)->names('admin.allergens');
    Route::resource('appetizers', AppetizerController::class)->names('admin.appetizers');
    Route::resource('beverages', BeverageController::class)->names('admin.beverages');
    Route::resource('desserts', DessertController::class)->names('admin.desserts');
    
    // AJAX endpoints per form intelligenti
    Route::get('ajax/ingredients-allergens', [IngredientController::class, 'getAllergensForIngredients'])->name('admin.ajax.ingredients-allergens');
    
    // ROTTA DI TEST LAYOUT
    Route::get('/test-layout', function () {
        return view('layouts.test-layout');
    })->name('test.layout');
    
    // DEBUG ASSOLUTO
    Route::get('/debug', function () {
        return view('debug-layout');
    })->name('debug.layout');
    
    // DASHBOARD PULITO SENZA BOOTSTRAP
    Route::get('/dashboard-clean', function () {
        return view('dashboard-clean', [
            'countPizzas' => 12,
            'countAppetizers' => 8,
            'countBeverages' => 15,
            'countDesserts' => 6,
            'latestPizza' => (object)['name' => 'Margherita', 'price' => 8.50],
            'latestAppetizer' => (object)['name' => 'Bruschetta', 'price' => 5.00],
            'latestDessert' => (object)['name' => 'Tiramisù', 'price' => 4.50],
        ]);
    })->name('dashboard.clean');
});

require __DIR__ . '/auth.php';
