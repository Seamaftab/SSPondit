<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NoobController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Order;
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

Route::get('/', [NoobController::class, 'welcome'])->name('welcome');


require __DIR__.'/auth.php';

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('admin')->group(function()
{
    //auth
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Users
    Route::get('/users/trash', [UserController::class, 'trash'])->name('users.trash');
    
    Route::resource('/users', UserController::class);

    Route::patch('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');

    Route::delete('/users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');

    //Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    Route::get('/products/trash', [ProductController::class, 'trash'])->name('products.trash');

    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

    Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');

    Route::patch('/products/{product}/restore', [ProductController::class, 'restore'])->name('products.restore');

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::delete('/products/{product}/delete', [ProductController::class, 'delete'])->name('products.delete');

    //Category
    Route::resource('categories', CategoryController::class);

    //Colors
    Route::resource('colors', ColorsController::class);

    //Cart
    Route::resource('carts', CartController::class);

    //Comments
    Route::post('/products/{productSlug}/comments', [CommentController::class, 'store'])->name('comments.store');
});

//orders
Route::middleware('auth')->group(function()
{
    Route::get('/orders/cancelled_orders', [OrderController::class, 'cancelled_orders'])->name('cancelled_orders');

    Route::resource('orders', OrderController::class);

    Route::patch('/orders/{order}/restore', [OrderController::class, 'restore'])->name('orders.restored');

    Route::delete('/orders/{order}', [OrderController::class, 'cancel_order'])->name('orders.cancel');

    Route::delete('/orders/{order}/delete', [OrderController::class, 'delete'])->name('orders.remove');

    Route::get('orders-confirmed', [OrderController::class, 'confirmed'])->name('confirmed');

    Route::get('/orders/{order}/invoice-pdf', [OrderController::class, 'generateInvoicePdf'])->name('invoice.pdf');
});

Route::get('/{slug}', [NoobController::class, 'categoryWiseProducts'])->name('category.products');

Route::get('/product/{slug}', [NoobController::class, 'productDetails'])->name('product_details');




// Outside The Main parts of the code
Route::get('/home', [NoobController::class, 'home'])->name('home');

Route::get('/about', [NoobController::class, 'about'])->name('about');

Route::get('/contact', [NoobController::class, 'contact'])->name('contact');

Route::get('/users', [NoobController::class, 'users'])->name('users');
