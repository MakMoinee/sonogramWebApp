<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\SignOutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/about", [AboutController::class, 'index']);
Route::get("/contact", [ContactController::class, 'index']);
Route::get("/pricing", [PricingController::class, 'index']);
Route::resource('/login', LoginController::class);
Route::post("/signup", [LoginController::class, 'signup']);
Route::get("/signout", [SignOutController::class, 'index']);
