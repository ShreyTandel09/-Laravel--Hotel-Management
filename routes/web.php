<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HotelRoomsController;
use App\Http\Controllers\RoomRentsController;
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

// routes/web.php


// Route for the homepage/dashboard
Route::get('/', function () {
    return view('dashboard'); // Assuming you have a dashboard view
})->name('dashboard');

// Routes for Room Management
// Route::get('/rooms', [HotelRoomsController::class, 'index'])->name('rooms.index');
// Route::get('/rooms/create', [HotelRoomsController::class, 'create'])->name('rooms.create');
// Route::post('/rooms', [HotelRoomsController::class, 'store'])->name('rooms.store');
// Route::get('/rooms/{id}', [HotelRoomsController::class, 'show'])->name('rooms.show');

Route::resource('rooms', HotelRoomsController::class);

Route::post('/rooms/available', [HotelRoomsController::class, 'getAvailableRooms'])->name('rooms.available');
Route::post('/calculate-cost', [BookingController::class, 'calculateCost'])->name('calculate.cost');

//Dashboard Controller
Route::get('/dashboard-heatmap', [DashboardController::class, 'heatmap'])->name('dashboard.heatmap');
Route::get('/dashboard-roomSummary', [DashboardController::class, 'roomSummary'])->name('dashboard.roomSummary');
Route::get('/dashboard-vacancies', [DashboardController::class, 'vacancies'])->name('dashboard.vacancies');



// Routes for Booking Management
Route::resource('bookings', BookingController::class);


Route::resource('room-rents', RoomRentsController::class);
