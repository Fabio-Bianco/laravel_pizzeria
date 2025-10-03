<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

try {
    $pizza = \App\Models\Pizza::find(19);
    $categories = \App\Models\Category::all();
    $ingredients = \App\Models\Ingredient::all();
    $allergens = \App\Models\Allergen::all();
    
    if (!$pizza) {
        echo "Pizza with ID 19 not found\n";
        exit(1);
    }
    
    $view = view('admin.pizzas.edit', compact('pizza', 'categories', 'ingredients', 'allergens'));
    $rendered = $view->render();
    
    echo "Template compiles successfully!\n";
    echo "Rendered content length: " . strlen($rendered) . " characters\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    exit(1);
}