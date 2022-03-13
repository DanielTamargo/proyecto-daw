<?php

namespace App\Http\Controllers;

use App\Models\Constants;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Si no está loggeado no tendrá permisos
        if (!Auth::user()) return view('errors.403');

        // Si no es un usuario administrador se redirigirá a perfil donde puede ver sus pedidos
        if (Auth::user()->rol != Constants::ROL_ADMINISTRADOR) {
            return redirect()->route('usuarios.profile');
        }

        // Obtenemos los pedidos finalizados por un lado y los pendientes por otro
        $pedidos_finalizados = Pedido::wherein('estado', [Constants::ESTADO_ENTREGADO, Constants::ESTADO_CANCELADO])->orderByDesc('id')->get();
        $pedidos_pendientes = Pedido::whereNotIn('estado', [Constants::ESTADO_ENTREGADO, Constants::ESTADO_CANCELADO])->orderByDesc('id')->get();

        return view('pedidos.index')
            ->with('pedidos_finalizados', $pedidos_finalizados)
            ->with('pedidos_pendientes', $pedidos_pendientes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * Creamos un nuevo pedido asociado al usuario que está realizando dicho pedido y 
     * volcamos los productos del carrito en productos asociados al pedido
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {
        $pedido = Pedido::find(request('id'));
        
        // Si no se encuentra, error 404
        if (!$pedido) 
            return view('errors.404');

        // Si se encuentra pero no es el cliente o un admin, error 403
        if (!Auth::user() || ($pedido->cliente_id != Auth::user()->id && Auth::user()->rol != Constants::ROL_ADMINISTRADOR))
            return view('errors.403');

        // Si el pedido está finalizado (en estado cancelado o entregado) o es administrador, vemos factura
        if ($pedido->estado == Constants::ESTADO_CANCELADO || $pedido->estado == Constants::ESTADO_ENTREGADO || Auth::user()->rol == Constants::ROL_ADMINISTRADOR) {
            return view('pedidos.factura', compact('pedido'));
        }

        // Si no está finalizado, vemos actualización estado pedido
        return view('pedidos.show', compact('pedido'));
    }
}
