<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomtypeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CustomerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

// Routing for admin login
Route::get('admin', [AdminAuthController::class,'login']);
Route::post('admin', [AdminAuthController::class,'loginCheck']);
Route::get('admin/logout', [AdminAuthController::class,'logout']);


Route::get('admin/dashboard', function () {
    return view('dashboard');
});

// Roomtype Route
Route::resource('admin/roomtype',RoomtypeController::class);
Route::get('admin/roomtype/{id}/delete',[RoomtypeController::class,'destroy']);

// Room Route
Route::resource('admin/room',RoomController::class);
Route::get('admin/room/{id}/delete',[RoomController::class,'destroy']);

// Customer Route
Route::resource('admin/customer',CustomerController::class);
Route::get('admin/customer/{id}/delete',[CustomerController::class,'destroy']);


Route::get('home', function() {
    return view('home');
});

Route::get('/', [CustomAuthController::class, 'login']);
Route::get('/registration', [CustomAuthController::class, 'registration']);
Route::post('/register-user', [CustomAuthController::class, 'registerUser'])->name('register-user');
Route::post('login-user', [CustomAuthController::class, 'loginUser'])->name('login-user'); 

// Route::get('/home',[CustomAuthController::class, 'home']);
// Route::get('/logout',[CustomAuthController::class, 'logout']);