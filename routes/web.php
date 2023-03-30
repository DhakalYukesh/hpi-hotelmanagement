<?php

use App\Http\Controllers\FoodController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomtypeController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\StaffDepartController;
use App\Http\Controllers\StaffController;


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

// Booking Route
Route::resource('admin/booking',BookingController::class);
Route::get('admin/booking/{id}/delete',[BookingController::class,'destroy']);
Route::get('admin/booking/{id}/checkedIn',[BookingController::class,'checkedin']);
Route::get('admin/booking/{id}/checkedOut',[BookingController::class,'checkedout']);
Route::get('admin/booking/{id}/invoice',[BookingController::class, 'invoice']);
Route::get('admin/booking/{id}/gen_invoice',[BookingController::class, 'generateInvoice']);
Route::get('admin/booking/{id}/food',[BookingController::class, 'food']);
Route::get('booking/availableRooms/{check_in}/{num_days}', [BookingController::class, 'available_Rooms'])->name('booking.availableRooms');

// Service Route
Route::resource('admin/service',ServiceController::class);
Route::get('admin/service/{id}/delete',[ServiceController::class,'destroy']);

// Food Route
Route::resource('admin/food',FoodController::class);
Route::post('admin/booking/{id}/food', [FoodController::class, 'handleOrder']);
Route::get('admin/food/{id}/delete',[FoodController::class,'destroy']);

// Staff Route
Route::resource('admin/staff',StaffController::class);
Route::get('admin/staff/{id}/delete',[StaffController::class,'destroy']);

// Department Route
Route::resource('admin/department',StaffDepartController::class);
Route::get('admin/department/{id}/delete',[StaffDepartController::class,'destroy']);

// User Booking - Frontend
Route::get('booking',[BookingController::class, 'booking']);

// Payment gateaway
Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

// Route::get('/booking/checkout', [BookingController::class, 'store'])->name('booking.checkout');
// Route::post('/payment/checkout', 'BookingController@store')->name('booking.store');

Route::get('home', function() {
    return view('home');
});

Route::get('booking/success', [BookingController::class, 'success'])->name('booking.success');
Route::get('booking/error', [BookingController::class, 'error'])->name('booking.error');


Route::get('/', [CustomerController::class, 'login']);
Route::post('/customer/login', [CustomerController::class, 'loginCustomer']);
Route::get('/registration', [CustomerController::class, 'registration']);
Route::get('/logout', [CustomerController::class, 'logout']);
