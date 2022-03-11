<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\ProductosCarrito;
use App\Models\User;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    /**
     * API cuya respuesta devuelve si un valor es único
     * 
     * Recibe:
     * - clave: string, clave a comparar
     * - valor: string, valor a cotejar
     * 
     * Devuelve una respuesta json, valor_unico será true si no existe otro usuario con el mismo valor y false si sí que existe
     */
    public function comprobarUsuarioCampoUnico() {
        // Recibimos clave y valor
        $clave = $_GET["clave"];
        $valor = $_GET["valor"];

        // Buscamos si existe
        $user = User::where($clave, $valor)->first();

        // Devolvemos la respuesta
        return response()->json([
            'ok' => true,
            'mensaje' => 'Petición válida',
            'valor_unico' => $user ? false : true, // <- Aclaración: si el usuario NO existe, el valor único SÍ es true
        ], 200);
    }

    /**
     * API que recibirá el id del producto y del cliente y actualizará la cantidad en el carrito
     * Si no existe lo añadirá
     * Si existía y la cantidad es superior a 0, lo actualizará
     * Si existía pero la cantidad es 0 o inferior, lo eliminará
     */
    public function actualizarProductoCarrito(Request $request) {

        // Buscamos
        $cliente = Auth::user();
        $productosCarrito = ProductosCarrito::where('producto_id', $request->producto_id)->where('cliente_id', $cliente->id)->first();

        // Trabajamos con los datos
        if (!$productosCarrito && $request->producto_cantidad > 0) {
            // Si no existe (y la cantidad es positiva), lo añadimos
            ProductosCarrito::create(['cliente_id' => $cliente->id, 'producto_id' => $request->producto_id, 'cantidad' => $request->producto_cantidad]);
        } else if ($request->producto_cantidad > 0) {
            // Si sí que existe y la cantidad es positiva, actualizamos
            $productosCarrito->cantidad = $request->producto_cantidad;
            $productosCarrito->save();
        } else {
            // Si ya existía pero la cantidad es 0 (o inferior), eliminamos
            $productosCarrito->delete();
        }

        // Devolvemos la respuesta
        return response()->json([
            'ok' => true,
            'mensaje' => 'Petición válida',
        ], 200);
    }


    /**
     * API para modificar el estado de un pedido
     */
    public function modificarEstadoPedido(Request $request) {
        // Obtenemos el producto
        $producto = Producto::find($request->producto_id);
        
        // Modificamos el estado
        $producto->estado = $request->producto_estado;

        // Guardamos
        $producto->save();

        // Devolvemos la respuesta
        return response()->json([
            'ok' => true,
            'mensaje' => 'Petición válida',
        ], 200);
    }


    public function obtenerProductosCarrito() {

    }


    public function obtenerEstadoPedido(Request $request) {
        $pedido = Pedido::find($request->pedido_id);

        // Devolvemos la respuesta
        return response()->json([
            'ok' => true,
            'mensaje' => 'Petición válida',
            'estado' => $pedido->estado,
        ], 200);
    }
}