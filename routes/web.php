<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Profile\PasswordController;
use App\Http\Controllers\Profile\ProfileAvatarController;
use App\Http\Controllers\Profile\ProfileInformationController;
use App\Http\Controllers\Profile\UsernameController;
use App\Http\Controllers\CustomerController;
use App\Models\Category;

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

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/products', [PostController::class, 'index'])->name('products.index');
Route::get('products/{product}', [PostController::class, 'show'])->name('products.show');
Route::get('/category', [CategoryController::class, 'indexFree'])->name('welcome');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth','verified'])->name('dashboard');

Route::get('category/{category}', [PostController::class, 'category'])->name('products.category');

Route::get('profile/{user}', [ProfileInformationController::class, 'show'])->name('profile.info');

Route::get('tag/{tag}', [PostController::class, 'tag'])->name('products.tag');



Route::middleware(['auth', 'verified'])->group(function ()
{
    Route::resource('admin/categories', CategoryController::class)->names('admin.categories');

    Route::resource('admin/tags', TagController::class)->names('admin.tags');

    Route::get('/profile', [ProfileInformationController::class, 'edit'])->name('profile');

    Route::get('/notification', [ProfileInformationController::class, 'notice'])->name('profile.notice');
    
    Route::put('/profile', [ProfileInformationController::class, 'update'])->name('profile.update');
    
    Route::get('/username', [ProfileInformationController::class, 'edit'])->name('username');
    Route::put('/username', [UsernameController::class, 'update'])->name('user-username.update');

    Route::put('/password', [PasswordController::class, 'update'])->name('user-password.update');
    Route::put('/user-avatar', [ProfileAvatarController::class, 'update'])->name('user-avatar.update');

    Route::resource('posts', CustomerController::class)->names('custom');
    //Route::get('change/{post}', [CustomerController::class, 'change'])->name('custom.destroy');

    Route::get('/add', [PostController::class, 'addProduct'])->name('products.add');
    Route::get('/miCar', [PostController::class, 'mi_car'])->name('products.shopping');
    Route::get('/discard', [PostController::class, 'discard'])->name('products.destroy');
    Route::get('/reserve', [PostController::class, 'addReserve'])->name('products.addBuy');

    Route::get('/buy', [PostController::class, 'buyProduct'])->name('products.buy');
    Route::get('/my_history', [PostController::class, 'historyProduct'])->name('products.history');
    Route::get('/bought',[PostController::class, 'addBought'])->name('products.bought');

});

require __DIR__.'/auth.php';
