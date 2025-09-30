<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\AllergenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Backoffice URLs without /admin path, but route names are namespaced as admin.* to avoid collisions with API
    Route::resource('categories', CategoryController::class)->names('admin.categories');
    Route::resource('pizzas', PizzaController::class)->names('admin.pizzas');
    Route::resource('ingredients', IngredientController::class)->names('admin.ingredients');
    Route::resource('allergens', AllergenController::class)->names('admin.allergens');
});

require __DIR__.'/auth.php';
