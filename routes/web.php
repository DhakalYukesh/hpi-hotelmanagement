<?php

use App\Http\Controllers\ArchivedController;
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

/* ------------- Home Routing ------------ */
Route::get('/', function () {
    return view('home');
});

Route::post('contact_us', [CustomAuthController::class, 'contact_us']);

/* ------------- Admin Routing ------------ */
// Routing for admin login
Route::get('admin', [AdminAuthController::class, 'login']);
Route::post('admin', [AdminAuthController::class, 'loginCheck']);
Route::get('admin/logout', [AdminAuthController::class, 'logout']);
Route::get('admin/dashboard', [AdminAuthController::class, 'dashboard']);

/* ------------- Roomtype Routing ------------ */
Route::resource('admin/roomtype', RoomtypeController::class);
Route::get('admin/roomtype/{id}/delete', [RoomtypeController::class, 'destroy']);

/* ------------- Room Routing ------------ */
Route::resource('admin/room', RoomController::class);
Route::get('admin/room/{id}/delete', [RoomController::class, 'destroy']);

/* ------------- Customer Routing ------------ */
Route::resource('admin/customer', CustomerController::class); 
Route::post('registration/verify', [CustomerController::class, 'store']);
Route::post('registration/verify/{verification_code}', [CustomerController::class, 'verify']);
Route::get('admin/customer/{id}/delete', [CustomerController::class, 'destroy']);

/* ------------- Archived Booking Routing ------------ */
Route::get('admin/booking/archive', [ArchivedController::class, 'archiveIndex'])->name('booking.archiveindex');
Route::get('admin/booking/archive/{id}/delete', [ArchivedController::class, 'destroy']);

/* ------------- Booking Routing ------------ */
Route::resource('admin/booking', BookingController::class);
Route::get('admin/booking/{id}/delete', [BookingController::class, 'destroy']);
Route::get('admin/booking/{id}/checkedIn', [BookingController::class, 'checkedin']);
Route::get('admin/booking/{id}/checkedOut', [BookingController::class, 'checkedout']);
Route::get('admin/booking/{id}/invoice', [BookingController::class, 'invoice']);
Route::get('admin/booking/{id}/gen_invoice', [BookingController::class, 'generateInvoice']);
Route::get('admin/booking/{id}/arc_booking', [BookingController::class, 'archive']);
Route::get('admin/booking/{id}/food', [BookingController::class, 'food']);
Route::get('booking/availableRooms/{check_in}/{num_days}', [BookingController::class, 'available_Rooms'])->name('booking.availableRooms');

/* ------------- Service Routing ------------ */
Route::resource('admin/service', ServiceController::class);
Route::get('admin/service/{id}/delete', [ServiceController::class, 'destroy']);

/* ------------- Food Routing ------------ */
Route::resource('admin/food', FoodController::class);
Route::post('admin/booking/{id}/food', [FoodController::class, 'handleOrder']);
Route::get('admin/food/{id}/delete', [FoodController::class, 'destroy']);
Route::get('admin/booking/{id}/invoice', [BookingController::class, 'invoice']);

/* ------------- Staff Routing ------------ */
Route::get('admin/staff/account', [StaffController::class, 'staff_account']);
Route::resource('admin/staff', StaffController::class);
Route::get('admin/staff/{id}/delete', [StaffController::class, 'destroy']);

/* ------------- Department Routing ------------ */
Route::resource('admin/department', StaffDepartController::class);
Route::get('admin/department/{id}/delete', [StaffDepartController::class, 'destroy']);

/* ------------- Finance Routing ------------ */
Route::get('admin/finance', [BookingController::class, 'finance']);

/* ------------- User Booking Routing - Frontend ------------ */
Route::get('booking', [BookingController::class, 'booking']);

/* ------------- Payment Routing ------------ */
Route::get('/booking/payment', [PaymentController::class, 'index'])->name('payment.index');
Route::get('/payment', [PaymentController::class, 'adminPayment'])->name('payment.admin_payment');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

/* ------------- Miscellaneous Routing ------------ */
Route::get('home', function () {
    return view('home');
});

Route::get('home', [CustomerController::class, 'customerHome']);
Route::get('booking/success', [BookingController::class, 'success'])->name('booking.success');
Route::get('booking/error', [BookingController::class, 'error'])->name('booking.error');


Route::get('/', [CustomerController::class, 'login']);
Route::post('/customer/login', [CustomerController::class, 'loginCustomer']);
Route::get('/registration', [CustomerController::class, 'registration']);
Route::get('/logout', [CustomerController::class, 'logout']);