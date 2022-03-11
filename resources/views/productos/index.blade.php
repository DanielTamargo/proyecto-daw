@extends('layouts.app')

@section('styleScripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
@endsection


@section('navActiva')
    @php
        $nav_activa_carta = true;
    @endphp
@endsection


@section('content')
    <div class="contenedor justify-content-start">
        @if(Auth::user() && Auth::user()->rol == \App\Models\Constants::ROL_ADMINISTRADOR)
        <a href="{{ route('productos.create') }}" id="btn-nuevo-producto" class="text-light btn btn-circle btn-xl btn-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="auto" height="auto" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
            </svg>
        </a>
        @endif
        <div class="contenedor-categorias col-12"></div>
        <div class="contenedor-productos col-12">
        @php
            $i=0;
        @endphp
        @foreach($productos as $producto)
        @php
            $i++;
        @endphp
            <div numero="{{ $i }}" id="producto-{{ $producto->id }}" tipo="tarjeta-producto">
                <div class="contenedor-imagen">
                    <img src="{{ asset('img/'.$producto->foto) }}" alt="foto">
                </div>
                <div class="contenedor-info">
                    <p class="nombre col-8 text-center fw-bold pb-2 fs-4 m-0">{{ $producto->nombre }}</p>
                    <p class="precio">{{ $producto->precio }}€</p>
                    <div class="annadir-carrito">
                        <div class="btn-menos">
                            <button><b>-</b></button>
                        </div>
                        <div class="btn-principal">
                            <button producto_id="{{ $producto->id }}" class="add-to-cart 
                            @if ($producto->cantidadEnCarrito(Auth::user()) > 0)
                                added
                            @endif">
                                <div class="default">Añadir al carrito</div>
                                <div class="success">{{ $producto->cantidadEnCarrito(Auth::user()) }}</div>
                                <div class="cart">
                                    <div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                                <div class="dots"></div>
                            </button>
                        </div>
                        <div class="btn-mas">
                            <button><b>+</b></button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
    <input type="hidden" id="nyb_cl" value="{{ Auth::user() ? 'true' : '' }}">
    <input type="hidden" id="url_api" value="{{ route('api.carrito.actualizarproducto') }}">
    <input type="hidden" id="url_login" value="{{ route('login') }}">
    {{-- <input type="hidden" id="url_producto_show" value="{{ route('productos.show') }}"> --}}
    
@endsection


@section('scripts')
<script src="{{ asset('js/carta.js') }}"></script>
@endsection