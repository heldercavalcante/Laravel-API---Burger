<?php

use App\Http\Controllers\BreadController;
use App\Http\Controllers\BurgerController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\MeatController;
use App\Http\Controllers\OptionalController;
use App\Http\Controllers\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//
Route::get('/ingredients', [BurgerController::class, 'ingredients']);
Route::get('/dashboard', [BurgerController::class, 'dashboard']);

//Order
Route::post('/order', [BurgerController::class, 'store']);
Route::delete('/order/{id}', [BurgerController::class, 'destroy']);
Route::put('/order/update/{id}', [BurgerController::class, 'update']);

//Optionals
Route::post('/optional', [OptionalController::class, 'store']);
Route::get('/optional/dashboard', [OptionalController::class, 'index']);
Route::delete('/optional/{id}', [OptionalController::class, 'destroy']);
Route::put('/optional/update/{id}', [OptionalController::class, 'update']);
Route::get('/optional/edit/{id}', [OptionalController::class, 'edit']);

//Meats
Route::post('/meat', [MeatController::class, 'store']);
Route::get('/meat/dashboard', [MeatController::class, 'index']);
Route::delete('/meat/{id}', [MeatController::class, 'destroy']);
Route::put('/meat/update/{id}', [MeatController::class, 'update']);
Route::get('/meat/edit/{id}', [MeatController::class, 'edit']);

//Breads
Route::post('/bread', [BreadController::class, 'store']);
Route::get('/bread/dashboard', [BreadController::class, 'index']);
Route::delete('/bread/{id}', [BreadController::class, 'destroy']);
Route::put('/bread/update/{id}', [BreadController::class, 'update']);
Route::get('/bread/edit/{id}', [BreadController::class, 'edit']);
