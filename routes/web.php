<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DriverController;
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
Route::middleware(['auth:sanctum'])->group(function () {

});
Route::get('drivers', [DriverController::class, 'index'])->name('drivers.index');
Route::get('driver-create', [DriverController::class, 'create'])->name('drivers.create');
Route::post('driver-verify/{driver}', [DriverController::class, 'verify'])->name('drivers.verify');
Route::post('driver-store', [DriverController::class, 'store'])->name('drivers.store');
Route::get('driver-show/{driver}', [DriverController::class, 'show'])->name('drivers.show');
Route::get('driver-edit/{driver}', [DriverController::class, 'edit'])->name('drivers.edit');
Route::post('driver-update/{driver}', [DriverController::class, 'update'])->name('drivers.updated');
Route::post('driver-delete/{driver}', [DriverController::class, 'destroy'])->name('drivers.destroy');
Route::get('/', function () {
    return view('welcome');
});
Route::get('auth/google', 'Auth\LoginController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');
Route::get('auth/facebook', 'Auth\LoginController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Auth\LoginController@handleFacebookCallback');
Route::get('/error', [LoginController::class, 'error'])->name('error');