@extends('layouts.app')

@section('styleScripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        .datos-pedido:not(:last-of-type) {
            border-bottom: 1px solid gray;
        }
        .info-principal {
            width: 92%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .info-pedido {
            display: flex;
            flex-direction: row;
            justify-content: space-between
        }
        .info-pedido-estado {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: flex-end;
        }
    </style>
@endsection


@section('navActiva')
    @php
        $nav_activa_pedidos = true;
    @endphp
@endsection


@section('content')
    <div class="container mt-3">
        <div class="btn-group" role="group">
            <button onclick="filtrarPedidos(1)" id="pedidos-boton-todos" type="button" class="btn btn-primary">Todos</button>
            <button onclick="filtrarPedidos(2)" id="pedidos-boton-pendientes" type="button" class="btn btn-secondary">Pendientes</button>
            <button onclick="filtrarPedidos(3)" id="pedidos-boton-finalizados" type="button" class="btn btn-secondary">Finalizados</button>
        </div>

        {{-- Pendientes --}}
        <div class="card my-3" id="lista-pedidos-pendientes">
            <div class="card-header">
                Lista de pedidos <b>sin finalizar</b>
            </div>
            <div class="card-body p-0">
                @if (count($pedidos_pendientes) <= 0)
                    <p class="card-text">
                        Sin pedidos pendientes
                    </p>
                @else
                    <div class="accordion" id="accordion-pedidos-pendientes">
                        @foreach ($pedidos_pendientes as $pedido)
                        <div class="accordion-item datos-pedido">
                            <h2 class="accordion-header" id="heading-{{ $pedido->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $pedido->id }}" aria-expanded="false" aria-controls="collapse-{{ $pedido->id }}">
                                    <div class="info-principal">
                                        <h5 class="m-0 pedido-ref">Pedido nº{{ $pedido->id }} 
                                        @switch($pedido->estado)
                                            @case(\App\Models\Constants::ESTADO_RECIBIDO)
                                                <span id="badge-pedido-{{ $pedido->id }}" class="ms-2 badge bg-primary">Recibido</span>
                                                @break
                                            @case(\App\Models\Constants::ESTADO_ENPROCESO)
                                                <span id="badge-pedido-{{ $pedido->id }}" class="ms-2 badge bg-info">En proceso</span>
                                                @break
                                            @case(\App\Models\Constants::ESTADO_LISTO)
                                                <span id="badge-pedido-{{ $pedido->id }}" class="ms-2 badge bg-success">Listo</span>
                                                @break
                                            @case(\App\Models\Constants::ESTADO_CANCELADO)
                                                <span id="badge-pedido-{{ $pedido->id }}" class="ms-2 badge bg-danger">Cancelado</span>
                                                @break
                                            @default
                                                <span id="badge-pedido-{{ $pedido->id }}" class="ms-2 badge bg-secondary">Finalizado</span>
                                        @endswitch
                                        </h5>
                                        <p class="m-0 pedido-fecha">{{ date('d-m-Y H:i:s', strtotime($pedido->fecha_pedido)) }}</p>
                                    </div> 
                                </button>
                            </h2>
                            <div id="collapse-{{ $pedido->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $pedido->id }}" {{--data-bs-parent="#accordion-pedidos-finalizados"--}}>
                                <div class="accordion-body">
                                    <div class="info-pedido">
                                        <div class="info-pedido-datos">
                                            <p class="mb-0"><i class="bi bi-person-fill me-2"></i><strong>{{ ucwords(strtolower($pedido->cliente->nombre)) }}</strong></p>
                                            <p class="mb-0"><i class="bi bi-credit-card-2-front-fill me-2"></i>{{ strtoupper($pedido->cliente->dni) }}</p>
                                            <p><i class="bi bi-telephone-fill me-2"></i>{{ $pedido->cliente->telefono }}</p>
        
                                            <p class="mb-0">Pago realizado: Sí</p>
                                        </div>
                                        <div class="info-pedido-estado">
                                            <select class="form-select" pedido_id="{{ $pedido->id }}" onchange="peticionAPIActualizarEstadoPedido(this)">
                                                <option value="{{App\Models\Constants::ESTADO_RECIBIDO}}" 
                                                        @selected($pedido->estado == App\Models\Constants::ESTADO_RECIBIDO)
                                                        >Recibido</option>
                                                <option value="{{App\Models\Constants::ESTADO_ENPROCESO}}" 
                                                        @selected($pedido->estado == App\Models\Constants::ESTADO_ENPROCESO)
                                                        >En proceso</option>
                                                <option value="{{App\Models\Constants::ESTADO_LISTO}}" 
                                                        @selected($pedido->estado == App\Models\Constants::ESTADO_LISTO)
                                                        >Listo</option>
                                                <option value="{{App\Models\Constants::ESTADO_ENTREGADO}}" 
                                                        @selected($pedido->estado == App\Models\Constants::ESTADO_ENTREGADO)
                                                        >Entregado</option>
                                                <option value="{{App\Models\Constants::ESTADO_CANCELADO}}" 
                                                        @selected($pedido->estado == App\Models\Constants::ESTADO_CANCELADO)
                                                        >Cancelado</option>
                                            </select>
                                            <a href="{{ route('pedidos.show', ['id' => $pedido->id]) }}">Ver factura</a>
                                        </div>
                                    </div>
                                    <div class="productos-pedido mt-4">
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
                            </div>
                        </div>
                        @endforeach
                    </div>  
                @endif
            </div>


        </div>

        {{-- Finalizados --}}
        <div class="card my-3" id="lista-pedidos-finalizados">
            <div class="card-header">
                Lista de pedidos <b>finalizados</b>
            </div>
            <div class="card-body p-0">
                @if (count($pedidos_finalizados) <= 0)
                    <p class="card-text">
                        Sin pedidos finalizados
                    </p>
                @else
                    <div class="accordion" id="accordion-pedidos-finalizados">
                    @foreach ($pedidos_finalizados as $pedido)
                        <div class="accordion-item datos-pedido">
                            <h2 class="accordion-header" id="heading-{{ $pedido->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $pedido->id }}" aria-expanded="false" aria-controls="collapse-{{ $pedido->id }}">
                                    <div class="info-principal">
                                        <h5 class="m-0 pedido-ref">Pedido nº{{ $pedido->id }} 
                                        @switch($pedido->estado)
                                            @case(\App\Models\Constants::ESTADO_RECIBIDO)
                                                <span id="badge-pedido-{{ $pedido->id }}" class="ms-2 badge bg-primary">Recibido</span>
                                                @break
                                            @case(\App\Models\Constants::ESTADO_ENPROCESO)
                                                <span id="badge-pedido-{{ $pedido->id }}" class="ms-2 badge bg-info">En proceso</span>
                                                @break
                                            @case(\App\Models\Constants::ESTADO_LISTO)
                                                <span id="badge-pedido-{{ $pedido->id }}" class="ms-2 badge bg-success">Listo</span>
                                                @break
                                            @case(\App\Models\Constants::ESTADO_CANCELADO)
                                                <span id="badge-pedido-{{ $pedido->id }}" class="ms-2 badge bg-danger">Cancelado</span>
                                                @break
                                            @default
                                                <span id="badge-pedido-{{ $pedido->id }}" class="ms-2 badge bg-secondary">Finalizado</span>
                                        @endswitch
                                        </h5>
                                        <p class="m-0 pedido-fecha">{{ date('d-m-Y H:i:s', strtotime($pedido->fecha_pedido)) }}</p>
                                    </div> 
                                </button>
                            </h2>
                            <div id="collapse-{{ $pedido->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $pedido->id }}" {{--data-bs-parent="#accordion-pedidos-finalizados"--}}>
                                <div class="accordion-body">
                                    <div class="info-pedido">
                                        <div class="info-pedido-datos">
                                            <p class="mb-0"><i class="bi bi-person-fill me-2"></i><strong>{{ ucwords(strtolower($pedido->cliente->nombre)) }}</strong></p>
                                            <p class="mb-0"><i class="bi bi-credit-card-2-front-fill me-2"></i>{{ strtoupper($pedido->cliente->dni) }}</p>
                                            <p><i class="bi bi-telephone-fill me-2"></i>{{ $pedido->cliente->telefono }}</p>
        
                                            <p class="mb-0">Total pedido: {{ $pedido->precioTotal() }}&euro;</p>
                                            <p class="mb-0">Pago realizado: Sí</p>
                                        </div>
                                        <div class="info-pedido-estado">
                                            <select class="form-select" pedido_id="{{ $pedido->id }}" onchange="peticionAPIActualizarEstadoPedido(this)">
                                                <option value="{{App\Models\Constants::ESTADO_RECIBIDO}}" 
                                                        @selected($pedido->estado == App\Models\Constants::ESTADO_RECIBIDO)
                                                        >Recibido</option>
                                                <option value="{{App\Models\Constants::ESTADO_ENPROCESO}}" 
                                                        @selected($pedido->estado == App\Models\Constants::ESTADO_ENPROCESO)
                                                        >En proceso</option>
                                                <option value="{{App\Models\Constants::ESTADO_LISTO}}" 
                                                        @selected($pedido->estado == App\Models\Constants::ESTADO_LISTO)
                                                        >Listo</option>
                                                <option value="{{App\Models\Constants::ESTADO_ENTREGADO}}" 
                                                        @selected($pedido->estado == App\Models\Constants::ESTADO_ENTREGADO)
                                                        >Entregado</option>
                                                <option value="{{App\Models\Constants::ESTADO_CANCELADO}}" 
                                                        @selected($pedido->estado == App\Models\Constants::ESTADO_CANCELADO)
                                                        >Cancelado</option>
                                            </select>
                                            <a href="{{ route('pedidos.show', ['id' => $pedido->id]) }}">Ver factura</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>  
                @endif
            </div>
        </div>
        
        
        <input type="hidden" id="url_api" value="{{ route('api.pedido.modificarestado') }}">
        <input type="hidden" id="url_carta" value="{{ route('inicio') }}">
    </div>
@endsection


@section('scripts')
<script src="{{ asset('js/pedidos.js') }}"></script>
@endsection