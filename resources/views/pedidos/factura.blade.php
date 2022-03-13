@extends('layouts.app')

@section('styleScripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .pedido {
            border: 1px solid gray;
        }
        .datos-pedido {
            display: flex;
            flex-direction: row;
        }
        .datos-cliente {
            padding: 1em;
            flex-grow: 1;
        }
        .datos-factura {
            padding: 1em;
            flex-grow: 1;
            border-left: 1px solid gray;
        }
        .desglose-pedido {
            border-top: 1px solid gray;
            padding: 1em;
        }
        
    </style>
@endsection


@section('navActiva')
    @php
        $nav_activa_pedidos = true;
    @endphp
@endsection


@section('content')
    <div class="container my-3">
        <div class="pedido">
            <div class="datos-pedido">
                <div class="datos-cliente">
                    <div class="datos-cliente-contenido">
                        <h4>Cliente</h4>
                        <p class="mb-0"><i class="bi bi-person-fill me-2"></i><strong>{{ ucwords(strtolower($pedido->cliente->nombre)) }}</strong></p>
                        <p class="mb-0"><i class="bi bi-credit-card-2-front-fill me-2"></i>{{ strtoupper($pedido->cliente->dni) }}</p>
                        <p><i class="bi bi-telephone-fill me-2"></i>{{ $pedido->cliente->telefono }}</p>
                    </div>
                </div>    
                <div class="datos-factura">
                    <div class="datos-factura-contenido">
                        <h4>Info pedido</h4>
                        <p class="mb-0">Estado: 
                            @switch($pedido->estado)
                                @case(\App\Models\Constants::ESTADO_RECIBIDO)
                                    Recibido
                                    @break
                                @case(\App\Models\Constants::ESTADO_ENPROCESO)
                                    En proceso
                                    @break
                                @case(\App\Models\Constants::ESTADO_LISTO)
                                    Listo
                                    @break
                                @case(\App\Models\Constants::ESTADO_CANCELADO)
                                    Cancelado
                                    @break
                                @default
                                    Finalizado
                            @endswitch
                        </p>
                        <p class="mb-0">Fecha pedido: {{ date('d-m-Y H:i:s', strtotime($pedido->fecha_pedido)) }}</p>
                        <p>Precio total: {{ $pedido->precioTotal() }}&euro;</p>
                    </div>
                </div>        
            </div>
            <div class="desglose-pedido pt-4">
                <h4>Lista de productos del pedido</h4>
                <table class="table table-responsive table-hover align-middle cursor-default">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Nombre</th>
                            <th class="text-center" scope="col">Cantidad</th>
                            <th class="text-center" scope="col">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedido->productos as $producto)
                            <tr producto_id="{{ $producto->id }}" onclick="verProducto(this)">
                                <td><img src="{{ asset('img/'.$producto->foto) }}" alt="{{ $producto->id }}"></td>
                                <td class="text-overflow-ellipsis">{{ $producto->nombre }}</td>
                                <td class="text-center">{{ $producto->cantidadEnPedido($pedido) }}</td>
                                <td class="text-center">{{ number_format($producto->cantidadEnPedido($pedido) * $producto->precio, 2) }}&euro;</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <h4 class="text-end me-2">Total pedido: {{ $pedido->precioTotal() }}&euro;</h4>
            </div>
        </div>
        <input type="hidden" id="url_carta" value="{{ route('inicio') }}">
    </div>
@endsection


@section('scripts')
<script>
    function verProducto(linea) {
    window.location.href = document.querySelector('#url_carta').getAttribute('value') + '/' + linea.getAttribute('producto_id');
}
</script>
@endsection