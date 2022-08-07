<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\PasswordController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProfileAvatarController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\TagController;

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

//Productos informacion

Route::get('products', [PostController::class, 'index']);
Route::get('imageProduct/{product}', [PostController::class, 'getImage']);

Route::get('products/{product}', [PostController::class, 'show']);

Route::get('category', [PostController::class, 'indexCat']);

Route::get('tag/{tag}', [PostController::class, 'tag']);
Route::get('category/{category}', [PostController::class, 'category']);


// Public routes

// si funciona
Route::post('/login', [AuthController::class, 'login']);

// si funciona
Route::post('/register', [AuthController::class, 'register']);

// si funciona
Route::get('/users', [AuthController::class, 'index']);

// Perfil de usuario || Publico
Route::get('/profile/{user}', [ProfileController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function ()
{
    // si funciona
    Route::post('/logout', [AuthController::class, 'logout']);

    //PERFIL DE USUARIO

    //Mis notificaciones
    Route::get('notice', [ProfileController::class, 'notice']);
    //Actualizar Datos del usuario autenticado
    Route::get('updateUsername', [ProfileController::class, 'updateUsername']);
    Route::get('update', [ProfileController::class, 'update']);

    //Actualizar Foto de perfil
    Route::get('/user-avatar', [ProfileAvatarController::class, 'update']);

    //Actualizar Contraseña
    Route::get('/password', [PasswordController::class, 'update']);
    
    // Rutas con logica del vendedor || si funciona
    Route::resource('myPosts', CustomerController::class);

    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    
    //Producto -> añadir al carrito de compras
    Route::get('add/{id}', [PostController::class, 'addProduct']);
    
    //Producto -> Reservar el producto -> publicacion
    Route::get('buy/{id}', [PostController::class, 'buyProduct']);

    // carrito de compras
    Route::get('myCar', [PostController::class, 'my_car']);
    Route::get('myCar/discard/{id}', [PostController::class, 'discard']);
    Route::get('myCar/reserve/{id}', [PostController::class, 'addReserve']);

    //Producto -> Comprar y calificar
    Route::get('purchase/{id}', [PostController::class, 'finPurchase']);

    //Productos Reservados y Comprados
    Route::get('history', [PostController::class, 'historyProduct']);

});