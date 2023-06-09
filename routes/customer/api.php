<?php

use App\Http\Controllers\Api\customer\CartController;
use App\Http\Controllers\Api\CustomerAuthController;
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

Route::group(['namespace' => 'Api'], function () {

   /*
   |--------------------------------------------------------------------------
   | Authentication
   |--------------------------------------------------------------------------
   */
   /**
    * Customer registration
    */
   Route::post('customer/registration', [CustomerAuthController::class, 'registerCustomer']);

   /**
    * Customer Login
    */
   Route::post('/customer/login', [CustomerAuthController::class, 'customerLogin']);

   /**
    * Customer reset password
    */
   Route::post('customer/send/otp/{number}',  [CustomerAuthController::class, 'sendOTP']);
   Route::post('/customer/verify/otp/{number}/{otp}',  [CustomerAuthController::class, 'verifyOTP']);
   Route::post('/customer/reset-password',  [CustomerAuthController::class, 'updatePassword']);


   Route::middleware(['auth:sanctum'])->group(function () {
      /**
       * Customer Cart
       */
      Route::post('/customer/addToCart',  [CartController::class, 'addToCart']);
      Route::get('/customer/getCartItems',  [CartController::class, 'getCartItems']);
      Route::post('/customer/deleteFromCart',  [CartController::class, 'deleteFromCart']);
      Route::post('/customer/clearCart',  [CartController::class, 'clearCart']);
   });
});