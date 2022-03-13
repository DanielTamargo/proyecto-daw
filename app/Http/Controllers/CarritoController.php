<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    /**
     * Muestra los productos del carrito
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // Obtenemos los productos del carrito del usuario
        $productos = Auth::user()->productosCarrito;

        // Vamos a la vista del carrito y enviamos los productos
        return view('carrito.show', compact('productos'));
    }
}
