<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController as ApiCategoryController;
use App\Http\Controllers\Api\PizzaController as ApiPizzaController;
use App\Http\Controllers\Api\IngredientController as ApiIngredientController;
use App\Http\Controllers\Api\AllergenController as ApiAllergenController;

Route::prefix('v1')->name('guest.')->group(function () {
    Route::apiResource('categories', ApiCategoryController::class);
    Route::apiResource('pizzas', ApiPizzaController::class);
    Route::apiResource('ingredients', ApiIngredientController::class);
    Route::apiResource('allergens', ApiAllergenController::class);
});
