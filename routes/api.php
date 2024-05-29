<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\APIController;
use App\Http\Controllers\API\ResetPasswordController;
use App\Http\Controllers\API\ForgotPasswordController;
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

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('create-review', [APIController::class, 'create_review'])->name('create_review');
    Route::post('create-post', [APIController::class, 'create_post'])->name('create_post');
    Route::post('create-comment', [APIController::class, 'create_comment'])->name('create_comment');
    Route::post('make-favourite', [APIController::class, 'make_favourite'])->name('make_favourite');
    Route::get('get-community-feed', [APIController::class, 'get_community_feed'])->name('get_community_feed');
    Route::post('update-fcm-token', [APIController::class, 'storeToken'])->name('update_fcm_token');
    Route::get('/get_profile', [APIController::class, 'get_profile'])->name('get_profile');
    Route::get('/get_current_order', [APIController::class, 'get_current_order'])->name('get_current_order');
    Route::get('/get_last_offer', [APIController::class, 'get_last_offer'])->name('get_last_offer');
    Route::post('/update_availablity', [APIController::class, 'update_availablity'])->name('update_availablity');
    Route::post('/accept_reject_order', [APIController::class, 'accept_reject_order'])->name('accept_reject_order');
    Route::post('/dropoff_order', [APIController::class, 'dropoff_order'])->name('dropoff_order');
    Route::get('/get_driver_wallet', [APIController::class, 'get_driver_wallet'])->name('get_driver_wallet');
    Route::get('/get_driver_wallet_history', [APIController::class, 'get_driver_wallet_history'])->name('get_driver_wallet_history');
    Route::post('/pickup_order', [APIController::class, 'pickup_order'])->name('pickup_order');
    Route::post('/update_driver_location', [APIController::class, 'update_driver_location'])->name('update_driver_location');
    Route::get('/get_user_addresses', [APIController::class, 'get_user_addresses'])->name('get_user_addresses');
    Route::get('/get_product_orders', [APIController::class, 'get_product_orders'])->name('get_product_orders');
     Route::get('/get_last_order_status', [APIController::class, 'get_last_order_status'])->name('get_last_order_status');
    Route::get('/get_driver_orders', [APIController::class, 'get_driver_orders'])->name('get_driver_orders');
    Route::post('/update_profile', [APIController::class, 'update_profile'])->name('update_profile');
    Route::post('/create_hotspot', [APIController::class, 'create_hotspot'])->name('create_hotspot');
     Route::post('/place_orders', [APIController::class, 'place_order'])->name('place_order');
    Route::post('/add_to_cart', [APIController::class, 'add_to_cart'])->name('add_to_cart');
    Route::post('/add_tip_to_cart', [APIController::class, 'add_tip_to_cart'])->name('add_tip_to_cart');
    Route::post('/submit_cart', [APIController::class, 'submit_cart'])->name('submit_cart');
     Route::post('/update_shipment_type', [APIController::class, 'update_shipment_type'])->name('update_shipment_type');
    Route::post('/verify_promo_code', [APIController::class, 'verify_promo_code'])->name('verify_promo_code');
    Route::post('/delete_from_cart', [APIController::class, 'delete_from_cart'])->name('delete_from_cart');
    Route::post('/create_user_address', [APIController::class, 'create_user_address'])->name('create_user_address');
    Route::post('/update_hotspot', [APIController::class, 'update_hotspot'])->name('update_hotspot');
    Route::get('/get_hotspot', [APIController::class, 'get_hotspot'])->name('get_hotspot');
      Route::get('/get_cart', [APIController::class, 'get_cart'])->name('get_cart');
    Route::get('/get_business_products_by_id', [APIController::class, 'get_business_products_by_id'])->name('get_business_products_by_id');
    Route::get('/get_business_products', [APIController::class, 'get_business_products'])->name('get_business_products');
    Route::get('/get_vendors', [APIController::class, 'get_vendors'])->name('get_vendors');
    Route::get('/get_vendors_latest', [APIController::class, 'get_vendors_latest'])->name('get_vendors_latest');
    Route::get('/get_vendor_for_you', [APIController::class, 'get_vendor_for_you'])->name('get_vendor_for_you');
    Route::get('/get_categories', [APIController::class, 'get_categories'])->name('get_categories');
    Route::get('/get_trending_vendors', [APIController::class, 'get_trending_vendors'])->name('get_trending_vendors');
    Route::get('/get_banners', [APIController::class, 'get_banners'])->name('get_banners');
    Route::post('/create_product', [APIController::class, 'create_product'])->name('create_product');
    Route::post('/update_product/{id}', [APIController::class, 'update_product'])->name('update_product');
    Route::post('/logout', [APIController::class, 'logout']);
    Route::post('/upload-image', [APIController::class, 'upload_image']);
});
 Route::post('/driver_signin', [APIController::class, 'driver_signin'])->name('driver_signin');

Route::post('/signup_with_email', [APIController::class, 'signup_with_email'])->name('signup_with_email');
Route::post('/signup_with_phone_number', [APIController::class, 'signup_with_phone_number'])->name('signup_with_phone_number');
Route::post('/signin_with_email', [APIController::class, 'signin_with_email'])->name('signin_with_email');
Route::post('/signin_with_phone_number', [APIController::class, 'signin_with_phone_number'])->name('signin_with_phone_number');
Route::post('/verify_phone_code', [APIController::class, 'verify_phone_code'])->name('verify_phone_code');
Route::post('/continue_social', [APIController::class, 'continue_social'])->name('continue_social');

Route::post('/forgotPassword', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/resetPassword', [ResetPasswordController::class, 'resetPassword']);
