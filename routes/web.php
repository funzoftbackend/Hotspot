<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\UserController;
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
Route::get('dashboard-drivers', [DriverController::class, 'dashboard_driver_index'])->name('dashboard_drivers.index');
Route::get('driver-create', [DriverController::class, 'create'])->name('drivers.create');
Route::get('dashboard-driver-create', [DriverController::class, 'dashboard_driver_create'])->name('dashboard_drivers.create');
Route::post('driver-verify/{driver}', [DriverController::class, 'verify'])->name('drivers.verify');
Route::post('dashboard-driver-verify/{driver}', [DriverController::class, 'dashboard_driver_verify'])->name('dashboard_drivers.verify');
Route::post('driver-store', [DriverController::class, 'store'])->name('drivers.store');
Route::post('dashboard-driver-store', [DriverController::class, 'dashboard_driver_store'])->name('dashboard_drivers.store');
Route::get('driver-show/{driver}', [DriverController::class, 'show'])->name('drivers.show');
Route::get('dashboard-driver-show', [DriverController::class, 'dashboard_driver_show'])->name('dashboard_drivers.show');
Route::get('driver-edit/{driver}', [DriverController::class, 'edit'])->name('drivers.edit');
Route::post('driver-update/{driver}', [DriverController::class, 'update'])->name('drivers.update');
Route::post('driver-delete/{driver}', [DriverController::class, 'destroy'])->name('drivers.destroy');
Route::post('dashboard-driver-delete/{driver}', [DriverController::class, 'dashboard_drivers_destroy'])->name('dashboard_drivers.destroy');
Route::get('/', function () {
    return view('welcome');
});
Route::get('auth/google', 'Auth\LoginController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\LoginController@handleGoogleCallback');
Route::get('auth/facebook', 'Auth\LoginController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Auth\LoginController@handleFacebookCallback');
Route::get('/error', [LoginController::class, 'error'])->name('error');
Route::get('/clear-cache', function () {
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    return 'Route and view caches cleared successfully.';
});
Route::post('/forgotPassword', [ForgotPasswordController::class, 'forgotPassword'])->name('web.forgot.password');
Route::get('/forgotPassword', [ForgotPasswordController::class, 'showforgotpassword'])->name('showforgotpassword');
Route::get('/showverifyCode', [ForgotPasswordController::class, 'showverifyCode'])->name('web.showverify.code');
Route::post('/verifyCode', [ForgotPasswordController::class, 'verifyCode'])->name('web.verify.code');
Route::get('/resetPassword', [ResetPasswordController::class, 'showresetPassword'])->name('web.showreset.password');
Route::post('/resetPassword', [ResetPasswordController::class, 'resetPassword'])->name('web.reset.password');
Route::post('/resendVerificationCode', [ForgotPasswordController::class, 'resendVerificationCode'])->name('web.resend.code');
Route::get('/', [LoginController::class, 'login']);
Route::get('/signup', [LoginController::class, 'signup'])->name('signup');
Route::post('/post_signup', [LoginController::class, 'post_signup'])->name('post_signup');
Route::get('/error', [LoginController::class, 'error'])->name('error');
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/post_login', [LoginController::class, 'post_login'])->name('post_login');
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');
// Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/user-create', [UserController::class, 'create'])->name('user.create');
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::post('/user-store', [UserController::class, 'store'])->name('user.store');
    Route::get('/users', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{user}', [UserController::class, 'show'])->name('user.show');
    Route::get('/edit-user', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/update/{user}', [UserController::class, 'update'])->name('user.update');
    Route::delete('/delete-user/{user}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::get('/businesses', [BusinessController::class, 'index'])->name('business.index');
    Route::get('/create', [BusinessController::class, 'create'])->name('business.create');
    Route::post('/store', [BusinessController::class, 'store'])->name('business.store');
    Route::get('/business/{business}', [BusinessController::class, 'show'])->name('business.show');
    Route::get('/edit-business', [BusinessController::class, 'edit'])->name('business.edit');
    Route::put('/update/{business}', [BusinessController::class, 'update'])->name('business.update');
    Route::delete('/delete-business/{business}', [BusinessController::class, 'destroy'])->name('business.destroy');
    
// });