<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use App\Models\ProductosCarrito;
use App\Models\User;
use Illuminate\Http\Client\Request;
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
     * API que recibirá el id del producto y la cantidad en el carrito
     * 
     * Borrará del carrito todas las veces que exista el producto en la lista del carrito y luego los añadirá tantas veces como
     * cantidad haya sido indicado
     * 
     * Esto se debe a que la BBDD está planteada con una tabla de relación muchos a muchos entre cliente y producto donde se sonsacan
     * los productos que existen en el carrito, sin un atributo que controle la cantidad
     * Supondrá un exceso de trabajo para la BBDD pero el tiempo disponible en el proyecto es mínimo y daremos prioridad 
     * a otras funcionalidades
     * Aunque de esta manera podremos emplear esta petición tanto para añadir, eliminar, aumentar cantidad y disminuir cantidad
     * 
     * Devuelve el número de productos totales en el carrito
     */
    public function actualizarProductoCarrito(Request $request) {
        // Borramos para actualizar
        $cliente = Auth::user();
        ProductosCarrito::where('producto_id', $request->producto_id)->where('cliente_id', $cliente->id)->delete();

        // Añadimos tantas veces como exista
        for ($i = 0; $i < $request->cantidad_producto; $i++) {
            ProductosCarrito::create(['producto_id' => $request->producto_id, 'cliente_id' => $cliente->id]);
        }

        // Obtenemos número de productos en total
        $count_carrito = count(ProductosCarrito::where('cliente_id', $cliente->id)->get());

        // Devolvemos la respuesta
        return response()->json([
            'ok' => true,
            'mensaje' => 'Petición válida',
            'num_productos_carrito' => $count_carrito, 
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
}