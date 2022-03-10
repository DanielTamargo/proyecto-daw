@extends('layouts.app')

@section('styleScripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
@endsection


@section('content')
    <div class="contenedor justify-content-start">
        <div class="contenedor-categorias col-12"></div>
        <div class="contenedor-productos col-12">
        @php
            $i=0;
        @endphp
        @foreach($productos as $producto)
        @php
            $i++;
        @endphp
            <div numero="{{ $i }}" id="producto-{{ $i }}" tipo="tarjeta-producto">
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