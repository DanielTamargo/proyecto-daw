@extends('layouts.app')

@section('styleScripts')
    <style>
        .datos-pedido:not(:last-of-type) {
            border-bottom: 1px solid gray;
        }
        .info-principal {
            width: 90%;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            <button type="button" class="btn btn-primary">Todos</button>
            <button type="button" class="btn btn-secondary">Pendientes</button>
            <button type="button" class="btn btn-secondary">Finalizados</button>
        </div>

        {{-- Pendientes --}}
        <div class="card my-3">
            <div class="card-header">
                Lista de pedidos sin finalizar
            </div>
            <div class="card-body">
                @if (count($pedidos_pendientes) <= 0)
                    <p class="card-text">
                        Sin pedidos pendientes
                    </p>
                @else
                    <div class="accordion" id="accordion-pedidos-pendientes">
                        @foreach ($pedidos_pendientes as $pedido)
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading-{{ $pedidos->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $pedido->id }}" aria-expanded="false" aria-controls="collapse-{{ $pedido->id }}">
                                    Pedido nº{{ $pedido->id }}
                                </button>
                            </h2>
                            <div id="collapse-{{ $pedido->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $pedidos->id }}" data-bs-parent="#accordion-pedidos-pendientes">
                                <div class="accordion-body">
                                    <strong>This is the second item's accordion body.</strong> It is hidden by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>  
                @endif
            </div>


        </div>

        {{-- Finalizados --}}
        <div class="card my-3">
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
                                                <span class="badge bg-primary">Recibido</span>
                                                @break
                                            @case(\App\Models\Constants::ESTADO_ENPROCESO)
                                                <span class="badge bg-info">En proceso</span>
                                                @break
                                            @case(\App\Models\Constants::ESTADO_LISTO)
                                                <span class="badge bg-success">Listo</span>
                                                @break
                                            @case(\App\Models\Constants::ESTADO_CANCELADO)
                                                <span class="badge bg-danger">Cancelado</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">Finalizado</span>
                                                
                                        @endswitch
                                        </h5>
                                        <p class="m-0 pedido-fecha">{{ date('d-m-Y H:i:s', strtotime($pedido->fecha_pedido)) }}</p>
                                    </div> 
                                </button>
                            </h2>
                            <div id="collapse-{{ $pedido->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $pedido->id }}" {{--data-bs-parent="#accordion-pedidos-finalizados"--}}>
                                <div class="accordion-body">
                                    <p class="mb-0"><strong>{{ ucwords(strtolower($pedido->cliente->nombre)) }}</strong></p>
                                    <p class="mb-0">{{ strtoupper($pedido->cliente->dni) }}</p>
                                    <p>{{ $pedido->cliente->telefono }}</p>


                                    <p class="mb-0">Total pedido: {{ $pedido->precioTotal() }}</p>
                                    <p class="mb-0">Pago realizado: Sí</p>
                                    
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>  
                @endif
            </div>
        </div>
        
        


    </div>
@endsection


@section('scripts')

@endsection