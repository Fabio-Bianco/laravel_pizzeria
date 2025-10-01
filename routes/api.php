<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController as ApiCategoryController;
use App\Http\Controllers\Api\PizzaController as ApiPizzaController;
use App\Http\Controllers\Api\IngredientController as ApiIngredientController;
use App\Http\Controllers\Api\AllergenController as ApiAllergenController;

Route::prefix('v1')->name('guest.')->group(function () {
    Route::apiResource('categories', ApiCategoryController::class)->only(['index','show']);
    Route::apiResource('pizzas', ApiPizzaController::class)->only(['index','show']);
    Route::apiResource('ingredients', ApiIngredientController::class)->only(['index','show']);
    Route::apiResource('allergens', ApiAllergenController::class)->only(['index','show']);
});
