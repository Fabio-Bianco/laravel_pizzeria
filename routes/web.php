<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\AllergenController;
use App\Http\Controllers\AppetizerController;
use App\Http\Controllers\BeverageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
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
});

require __DIR__ . '/auth.php';
