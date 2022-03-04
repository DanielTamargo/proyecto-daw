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
        // $productos = Auth::user()->productosCarrito;

        // Vamos a la vista del carrito y enviamos los productos

        // Recorremos la colección y preparamos un array con producto y cantidad del producto
    }

    /**
     * Añade un producto al carrito
     *
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        // Añadimos el producto tantas veces como cantidad haya indicado
    }

    /**
     * Elimina un producto del carrito
     *
     * @return \Illuminate\Http\Response
     */
    public function removeOne(Request $request)
    {
        // Eliminar UNO de productos_carritos donde producto_id = request->producto_id y cliente_id = user->id
    }

    /**
     * Elimina un producto del carrito
     *
     * @return \Illuminate\Http\Response
     */
    public function removeAll(Request $request)
    {
        // Eliminar TODOS de productos_carritos donde producto_id = request->producto_id y cliente_id = user->id
    }

    /**
     * Vacía el carrito
     *
     * @return \Illuminate\Http\Response
     */
    public function clear()
    {
        // Eliminar de productos_carritos donde cliente_id = user->id
    }
}
