<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Constants;
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
     * 
     * Recibe: pedido_id, estado
     * 
     * Rol necesario: administrador
     */
    public function modificarEstadoPedido(Request $request) {
        // Comprobamos que el usuario es administrador
        if (!Auth::user() || Auth::user()->rol != Constants::ROL_ADMINISTRADOR) {
            return response()->json([
                'ok' => false,
                'mensaje' => 'Acceso denegado',
            ], 403);
        }

        // Obtenemos el pedido
        $pedido = Pedido::find($request->pedido_id);
        
        // Modificamos el estado
        $pedido->estado = $request->estado;

        // Guardamos
        $pedido->save();

        // Enviamos email notificando al cliente
        $detalles = [
            'asunto' => 'Actualización pedido nº' . $pedido->id,
            'plantilla_email' => 'emails.modificar-pedido',
            'nombre' => $pedido->cliente->nombre,
            'estado' => $pedido->estado,
            'pedido_id' => $pedido->id,
        ];
        
        try {
            \Illuminate\Support\Facades\Mail::to($pedido->cliente->email)->send(new \App\Mail\HosteleriaMail($detalles));
        } catch (\Exception $e) { }

        // Devolvemos la respuesta
        return response()->json([
            'ok' => true,
            'mensaje' => 'Petición válida',
        ], 200);
    }

    /**
     * API para obtener el estado de un pedido
     */
    public function obtenerEstadoPedido(Request $request) {
        $pedido = Pedido::find($request->pedido_id);

        // Devolvemos la respuesta
        return response()->json([
            'ok' => true,
            'mensaje' => 'Petición válida',
            'estado' => $pedido->estado,
        ], 200);
    }

    /**
     * API para vaciar el carrito
     */
    public function vaciarCarrito(Request $request) {
        try {
            ProductosCarrito::where('cliente_id', Auth::user()->id)->delete();
        } catch (\Exception $e) {
            return response()->json([
                'ok' => false,
                'mensaje' => 'Error al eliminar: ' . $e->getMessage()
            ], 200);
        }

        return response()->json([
            'ok' => true,
            'mensaje' => 'Petición válida'
        ], 200);
    }
}