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
        if (Auth::user()->rol != Constants::ROL_ADMINISTRADOR) return view('errors.403');

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
        return view('pedidos.show', compact('pedido'));
    }
}
