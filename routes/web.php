<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\PedidoController;
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
Route::post('/api/carrito/producto-carrito', [ApiController::class, 'actualizarProductoCarrito'])->name('api.carrito.actualizarproducto')->middleware('auth');
Route::get('/api/carrito/obtener-productos', [ApiController::class, 'obtenerProductosCarrito'])->name('api.carrito.obtenerproductos')->middleware('auth');
Route::post('/api/carrito/vaciar-carrito', [ApiController::class, 'vaciarCarrito'])->name('api.carrito.vaciarcarrito')->middleware('auth');
Route::post('/api/pedido/modificar-estado', [ApiController::class, 'modificarEstadoPedido'])->name('api.pedido.modificarestado')->middleware('auth');
Route::post('/api/pedido/obtener-estado', [ApiController::class, 'obtenerEstadoPedido'])->name('api.pedido.obtenerestadopedido')->middleware('auth');


/*-- REDIRECCIONES INICIO / HOME --*/
Route::get('/inicio', function () { return redirect()->route('inicio'); });
Route::get('/home', function () { return redirect()->route('inicio'); });
Route::get('/', function () { return redirect()->route('inicio'); });


/*-- PRODUCTOS --*/
Route::get('/carta', [ProductoController::class, 'index'])->name('inicio'); // productos.index
Route::get('/carta/{id}', [ProductoController::class, 'show'])->name('productos.show');
Route::get('/productos/nuevo', [ProductoController::class, 'create'])->name('productos.create')->middleware('auth');
Route::post('/productos/nuevo', [ProductoController::class, 'store'])->name('productos.store')->middleware('auth');
Route::get('/productos/editar/{id}', [ProductoController::class, 'edit'])->name('productos.edit')->middleware('auth');
Route::put('/productos/editar', [ProductoController::class, 'update'])->name('productos.update')->middleware('auth');
Route::delete('/productos/eliminar', [ProductoController::class, 'destroy'])->name('productos.destroy')->middleware('auth');


/*-- USUARIOS --*/
Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show')->middleware('auth');
Route::get('/perfil', [UsuarioController::class, 'profile'])->name('usuarios.profile')->middleware('auth');
Route::delete('/usuarios/eliminar', [UsuarioController::class, 'destroy'])->name('usuarios.destroy')->middleware('auth');


/*-- COMENTARIOS --*/
Route::post('/comentarios/guardar', [ComentarioController::class, 'store'])->name('comentarios.store')->middleware('auth');


/*-- MOSTRAR CARRITO / AÑADIR O QUITAR PRODUCTOS / LIMPIAR CARRITO / REALIZAR PEDIDO --*/
Route::get('/carrito', [CarritoController::class, 'show'])->name('carrito.show')->middleware('auth');
Route::post('/carrito/{id}', [CarritoController::class, 'add'])->name('carrito.add')->middleware('auth');
Route::delete('/carrito/{id}', [CarritoController::class, 'remove'])->name('carrito.remove')->middleware('auth');
Route::post('/comprar', [CarritoController::class, 'buy'])->name('carrito.buy')->middleware('auth');
Route::post('/carrito/vaciar', [CarritoController::class, 'clear'])->name('carrito.clear')->middleware('auth');


/*--  PEDIDOS --*/
Route::get('/pedidos', [PedidoController::class, 'index'])->name('pedidos.index')->middleware('auth');
Route::post('/pedidos', [PedidoController::class, 'store'])->name('pedidos.store')->middleware('auth');
Route::get('/pedidos/{id}', [PedidoController::class, 'show'])->name('pedidos.show')->middleware('auth');


/*-- ACCESO PROHIBIDO --*/
Route::get('/acceso-prohibido', function() { return view('errors.403'); })->name('error.403');


/*-- PRUEBAS -- */
Route::get('/pruebas/relaciones', function () {
    return view('pruebas.relaciones')
        ->with('usuarios', App\Models\User::all())
        ->with('productos', App\Models\Producto::all())
        ->with('pedidos', App\Models\Pedido::all())
        ->with('categorias', App\Models\Categoria::all())
        ;
});
Route::get('/pruebas/metodos/compra-verificada', function () {
    return view('pruebas.compraverificada');
});