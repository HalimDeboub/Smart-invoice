<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
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

Route::get('/invoices',[InvoiceController::class, 'index'])->name('invoices.index');
Route::post('/invoices',[InvoiceController::class, 'store'])->name('invoices.store');
Route::get('/invoices/{id}',[InvoiceController::class, 'show'])->name('invoices.show');
Route::delete('/invoice/items/delete/{id}',[InvoiceController::class, 'delete_item']);
Route::get('invoices/search/',[InvoiceController::class, 'search'])->name('invoices.search');
Route::get('invoices/create_invoice',[InvoiceController::class, 'create'])->name('invoices.create');

Route::get('/customers',[CustomerController::class, 'index'])->name('customers.index');
Route::get('/products',[ProductController::class, 'index'])->name('products.index');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
