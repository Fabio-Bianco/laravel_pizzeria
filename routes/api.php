<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController as ApiCategoryController;
use App\Http\Controllers\Api\PizzaController as ApiPizzaController;
use App\Http\Controllers\Api\IngredientController as ApiIngredientController;
use App\Http\Controllers\Api\AllergenController as ApiAllergenController;
use App\Http\Controllers\Api\AppetizerController as ApiAppetizerController;
use App\Http\Controllers\Api\BeverageController as ApiBeverageController;
use App\Http\Controllers\Api\DessertController as ApiDessertController;

Route::prefix('v1')->name('guest.')->group(function () {
    Route::apiResource('categories', ApiCategoryController::class)->only(['index','show']);
    Route::apiResource('pizzas', ApiPizzaController::class)->only(['index','show']);
    Route::apiResource('ingredients', ApiIngredientController::class)->only(['index','show']);
    Route::apiResource('allergens', ApiAllergenController::class)->only(['index','show']);
    Route::apiResource('appetizers', ApiAppetizerController::class)->only(['index','show']);
    Route::apiResource('beverages', ApiBeverageController::class)->only(['index','show']);
    Route::apiResource('desserts', ApiDessertController::class)->only(['index','show']);
});
