<?php

use App\Http\Controllers\Api\Manager\AuthenticationController;
use App\Http\Controllers\Api\Manager\CustomerController;
use App\Http\Controllers\Api\Manager\DashboardAppController;
use App\Http\Controllers\Api\Manager\OrdersController;
use App\Http\Controllers\Api\Manager\ProductsController;
use App\Http\Controllers\Api\Manager\SendNotificationController;
use App\Http\Controllers\Api\Manager\TerritoryInformationsController;
use App\Http\Controllers\Api\Manager\UsersController;
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
   Route::post('/manager/login',  [AuthenticationController::class, 'login']);
   Route::post('signup', 'AuthController@userSignUp');
   Route::middleware(['auth:sanctum'])->group(function () {
      Route::get('/manager/customers', [CustomerController::class, 'getCustomers']);
      Route::get('/manager/users', [UsersController::class, 'getUsers']);
      Route::post('/manager/send/notification', [SendNotificationController::class, 'receiveNotification']);
      Route::get('/manager/all/regions', [TerritoryInformationsController::class, 'getAllTerritories']);
      Route::get('/manager/all/orders', [OrdersController::class, 'allOrders']);
      Route::get('/manager/dashboard/data', [DashboardAppController::class, 'dashboard']);

      //adding products
      Route::get('managers/all/products', [ProductsController::class,'index']);
      Route::get('managers/products/categories', [ProductsController::class,'categories']);
      Route::post('managers/products/store', [ProductsController::class, 'store']);
      Route::get('managers/products/{sku}/edit', [ProductsController::class, 'edit']);
      Route::post('managers/products/{sku}/restock', [ProductsController::class, 'restock']);
      Route::get('managers/products/{sku}/details', [ProductsController::class, 'details']);
   });
});
