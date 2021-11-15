<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//UserController
Route::post("/create" , [\App\Http\Controllers\UserController::class , "createAccount"]);
Route::post("/login" , [\App\Http\Controllers\UserController::class , "loginAccount"]);

//ProductsController
Route::post("/create-product" , [\App\Http\Controllers\ProductController::class , "createProduct"]);
Route::get("/all-products" , [\App\Http\Controllers\ProductController::class , 'getAllProducts']);
Route::get("/product/{id}",[\App\Http\Controllers\ProductController::class , 'getProductById']);
Route::get("/search/{key}",[\App\Http\Controllers\ProductController::class , 'searchForProduct']);
Route::get("/trending",[\App\Http\Controllers\ProductController::class , 'getAllTrendingProducts']);
Route::delete("/delete-product/{id}",[\App\Http\Controllers\ProductController::class , 'deleteCategoryById']);
Route::put("/update-product/{id}" , [\App\Http\Controllers\ProductController::class , 'updateProduct']);

//CartController
Route::post("/add-to-cart/{id}" , [\App\Http\Controllers\CartController::class , 'addToCart']);
Route::get("/get-all-products-from-cart" , [\App\Http\Controllers\CartController::class , 'getAllProductsFromCart']);
Route::get('/get-product/{id}' , [\App\Http\Controllers\CartController::class , 'getProductByIdFromCart']);
Route::delete('/delete-from-cart/{id}',[\App\Http\Controllers\CartController::class , 'deleteProductFromCart']);
Route::put("/update-from-cart/{id}",[\App\Http\Controllers\CartController::class , 'updateProductInCartById']);
Route::get("/checkout" , [\App\Http\Controllers\CartController::class , 'checkoutCart']);

//FavoritesController
Route::post("/add-to-favs" , [\App\Http\Controllers\FavoritesController::class , 'addToFavorites']);
Route::get("/favorites" , [\App\Http\Controllers\FavoritesController::class , 'fetchAllProductsFromFavorites']);
Route::delete("/favorites/{id}" , [\App\Http\Controllers\FavoritesController::class , 'deleteProductFromFavorites']);

//CategoryController
Route::post("/add-category" , [\App\Http\Controllers\CategoryController::class , 'addCategory']);
Route::get('/get-popular' , [\App\Http\Controllers\CategoryController::class , 'getAllPopularCategories']);
Route::delete("/delete-category/{id}" , [\App\Http\Controllers\CategoryController::class , 'deleteCategoryById']);
Route::get("/all-categories" , [\App\Http\Controllers\CategoryController::class , 'getAllCategories']);
Route::get("/get-prod-by-category" , [\App\Http\Controllers\CategoryController::class , 'getProductsByCategories']);

//OrderController
Route::post("/place-order/{id}" , [\App\Http\Controllers\OrderController::class , 'placeOrder']);
Route::get('/all-orders' , [\App\Http\Controllers\OrderController::class , 'viewOrder']);
