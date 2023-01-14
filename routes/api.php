<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProviderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\TransferController;
use App\Http\Controllers\Api\UserController;

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

Route::group(['prefix' => 'providers'], function () {
    Route::get('/', [ProviderController::class, 'index'])->name('list-providers');
    Route::get('/all', [ProviderController::class, 'getAll'])->name('all-providers');
    Route::get('/products-orders', [ProviderController::class, 'getProductsbyYearMonth'])->name('providers-products');
    Route::get('/costs', [ProviderController::class, 'getCostbyYearMonth'])->name('providers-costs');
});
Route::group(['prefix' => 'users'], function () {
    Route::get('/', [UserController::class, 'index'])->name('list-users');
    Route::get('/all', [UserController::class, 'getAll'])->name('all-users');
});
Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductController::class, 'index'])->name('list-products');
    Route::get('/all', [ProductController::class, 'getAll'])->name('all-products');
    Route::get('/stock/{store}', [ProductController::class, 'getStock'])->name('products-stock');
    Route::get('/costs', [ProductController::class, 'getCostbyYearMonth'])->name('products-costs');
});
Route::group(['prefix' => 'types'], function () {
    Route::get('/all', [TypeController::class, 'getAll'])->name('all-types');
});
Route::group(['prefix' => 'tags'], function () {
    Route::get('/all', [TagController::class, 'getAll'])->name('all-tags');
});
Route::group(['prefix' => 'stores'], function () {
    Route::get('/', [StoreController::class, 'index'])->name('list-stores');
    Route::get('/all', [StoreController::class, 'getAll'])->name('all-stores');
    Route::get('/products', [StoreController::class, 'getProductsbyStore'])->name('products-stores');
});
Route::group(['prefix' => 'orders'], function () {
    Route::get('/', [OrderController::class, 'index'])->name('list-orders');
    Route::get('/all', [OrderController::class, 'getAll'])->name('all-orders');
    Route::get('/products', [OrderController::class, 'getProductsbyYearMonth'])->name('products-orders-date');
});
Route::group(['prefix' => 'transfers'], function () {
    Route::get('/', [TransferController::class, 'index'])->name('list-transfers');
    Route::get('/all', [TransferController::class, 'getAll'])->name('all-transfers');
});
Route::group(['prefix' => 'reports'], function () {
    Route::get('/', [ReportController::class, 'getAllReports'])->name('all-reports');
});
