<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Models\Categoria;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Route::get('/register', function () { return redirect()->route('login'); })->name('usuarios.create');


/*-- REDIRECCIONES INICIO / HOME --*/
Route::get('/inicio', function () { return redirect()->route('productos.index'); });
Route::get('/home', function () { return redirect()->route('productos.index'); });
Route::get('/', function () { return redirect()->route('productos.index'); });


/*-- PRODUCTOS --*/
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
Route::get('/productos/{id}', [ProductoController::class, 'show'])->name('productos.show');
Route::put('/productos/{id}', [ProductoController::class, 'edit'])->name('productos.edit');
Route::get('/productos/nuevo', [ProductoController::class, 'create'])->name('productos.create');
Route::post('/productos/nuevo', [ProductoController::class, 'store'])->name('productos.store');
Route::delete('/productos', [ProductoController::class, 'delete'])->name('productos.delete');


/*-- USUARIOS --*/
Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
// Route::get('/usuarios/{id}', [UsuarioController::class, 'show'])->name('usuarios.show');
// Route::put('/usuarios/{id}', [UsuarioController::class, 'edit'])->name('usuarios.edit');
// Route::delete('/usuarios', [UsuarioController::class, 'delete'])->name('usuarios.delete');


/*-- PRUEBAS -- */
Route::get('/pruebas/relaciones', function () {
    return view('pruebas.relaciones')
        ->with('usuarios', User::all())
        ->with('productos', Producto::all())
        ->with('pedidos', Pedido::all())
        ->with('categorias', Categoria::all())
        ;
});