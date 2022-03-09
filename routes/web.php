<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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


/*-- AUTH --*/
Auth::routes();
Route::get('/register', [RegisterController::class, 'load'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

/*-- CERRAR SESIÓN DURANTE LAS PRUEBAS --*/
Route::get('/logout', function () { 
    Session::flush();
    Auth::logout();
    return redirect()->route('login');    
})->name('logout.get');


/*-- RUTAS API --*/
Route::get('/api/usuario/comprobar-campo-unico', [ApiController::class, 'comprobarUsuarioCampoUnico']);
Route::get('/api/carrito/producto-carrito', [ApiController::class, 'actualizarProductoCarrito'])->middleware('auth');
Route::get('/api/producto/modificar-estado', [ApiController::class, 'modificarEstadoPedido'])->middleware('auth.admin');

/*-- REDIRECCIONES INICIO / HOME --*/
Route::get('/inicio', function () { return redirect()->route('inicio'); });
Route::get('/home', function () { return redirect()->route('inicio'); });
Route::get('/', function () { return redirect()->route('inicio'); });


/*-- PRODUCTOS --*/
Route::get('/productos', [ProductoController::class, 'index'])->name('inicio'); // productos.index
Route::get('/productos/{id}', [ProductoController::class, 'show'])->name('productos.show');
Route::put('/productos/editar', [ProductoController::class, 'edit'])->name('productos.edit')->middleware('auth.admin');
Route::get('/productos/nuevo', [ProductoController::class, 'create'])->name('productos.create')->middleware('auth.admin');
Route::post('/productos/nuevo', [ProductoController::class, 'store'])->name('productos.store')->middleware('auth.admin');
Route::delete('/productos/eliminar', [ProductoController::class, 'destroy'])->name('productos.destroy')->middleware('auth.admin');


/*-- USUARIOS --*/
Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index')->middleware('auth.admin');
Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show')->middleware('auth.admin');
Route::get('/perfil', [UsuarioController::class, 'profile'])->name('usuarios.profile')->middleware('auth');
Route::delete('/usuarios/eliminar', [UsuarioController::class, 'destroy'])->name('usuarios.destroy')->middleware('auth.admin');


/*-- COMENTARIOS --*/
Route::post('/productos/{producto_id}', [ComentarioController::class, 'store'])->name('comentarios.store')->middleware('auth');


/*-- MOSTRAR CARRITO / AÑADIR O QUITAR PRODUCTOS / LIMPIAR CARRITO / REALIZAR PEDIDO --*/
Route::get('/carrito', [CarritoController::class, 'show'])->name('carrito.show')->middleware('auth');
Route::post('/carrito/{id}', [CarritoController::class, 'add'])->name('carrito.add')->middleware('auth');
Route::delete('/carrito/{id}', [CarritoController::class, 'remove'])->name('carrito.remove')->middleware('auth');
Route::post('/comprar', [CarritoController::class, 'buy'])->name('carrito.buy')->middleware('auth');
Route::post('/carrito/vaciar', [CarritoController::class, 'clear'])->name('carrito.clear')->middleware('auth');


/*-- PRUEBAS -- */
Route::get('/pruebas/relaciones', function () {
    return view('pruebas.relaciones')
        ->with('usuarios', App\Models\User::all())
        ->with('productos', App\Models\Producto::all())
        ->with('pedidos', App\Models\Pedido::all())
        ->with('categorias', App\Models\Categoria::all())
        ;
});