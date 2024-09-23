<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderReportsController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\PartyReportsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SummaryReportController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'dashboard'])
    ->middleware('auth')->name('dashboard');


   
    Route::middleware(['can:product','auth'])->group(function (){
      


    });
    Route::middleware(['can:customer','auth'])->group(function (){
       

    });
    Route::middleware(['can:suppliers','auth'])->group(function(){
        // suppliers
    Route::post('/add-supplier', [SupplierController::class, 'addSupplier'])->name('add_supplier');
    Route::get('/get-supplier-list', [SupplierController::class, 'getSupplierList']);
    Route::get('/get-supplier/{id}', [SupplierController::class, 'getSupplier']);
    Route::post('/update-supplier', [SupplierController::class, 'updateSupplier'])->name('update.supplier');
    Route::get('/delete-supplier/{id}', [SupplierController::class, 'delete_supplier'])->name('supplier.delete');


    });

    Route::middleware(['can:nozzale','auth'])->group(function(){
       
    });

    Route::middleware(['can:reports','auth'])->group(function (){
      
    });

   
   
Route::middleware(['auth'])->group(function () {



    Route::post('/get-dashboard-card', [DashboardController::class, 'getDashboardCard']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/product', [ProductController::class, 'add_product'])->name('product.from');
    Route::post('/save_products', [ProductController::class, 'save_product'])->name('products.save');
    Route::get('/customer', [CustomerController::class, 'add_customer'])->name('customer.from');
    Route::post('/save_customer', [CustomerController::class, 'save_customer'])->name('customer.save');
    Route::get('/get-product/{id}', [ProductController::class, 'get_product'])->name('get.product');
    Route::post('/update-product', [ProductController::class, 'update_product'])->name('update.product');
    Route::get('/delete-product/{id}', [ProductController::class, 'delete_product'])->name('product.delete');
    Route::get('/get-customer/{id}', [CustomerController::class, 'get_customer'])->name('get.customer');
    Route::post('/update-customer', [CustomerController::class, 'update_customer'])->name('update.customer');
    Route::get('/delete-customer/{id}', [CustomerController::class, 'delete_customer'])->name('customer.delete');
    Route::get('/purchase', [PurchaseController::class, 'show_purchase_page'])->name('purchase.form');
    Route::post('/fetch-product-details', [PurchaseController::class, 'fetchProductDetails'])->name('fetch.product.details');
    Route::post('/save-purchase', [PurchaseController::class, 'save_purchase'])->name('save.purchase');
    
    

    
});

Route::middleware(['can:user-management', 'auth'])->group(function () {
    Route::get('/users-list', [UserController::class, 'usersList']);
    Route::post('/add-user', [UserController::class, 'registerUser']);
    Route::post('/update-user',[UserController::class, 'updateUser']);
});

require __DIR__ . '/auth.php';