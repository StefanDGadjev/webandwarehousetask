<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DeliveryController;

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

Route::redirect('/', '/products');

Route::resource('products', ProductController::class);

Route::resource('deliveries', DeliveryController::class);
Route::post('/deliveries/delete/{id}', 'DeliveryController@deleteproduct')->name('deliveries.delete.product');
Route::post('/delivery/create/imeis/{id}', [DeliveryController::class, 'createImeis'])->name('delivery.create.imeis');

Route::get('/pdf/products', [ProductController::class, 'allProductsPDF'])->name('pdf.all.products');
