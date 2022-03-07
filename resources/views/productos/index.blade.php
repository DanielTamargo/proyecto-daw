@extends('layouts.app')

@section('styleScripts')

@endsection


@section('content')
    <div class="contenedor justify-content-start">
        <div class="contenedor-categorias col-12"></div>
        <div class="contenedor-productos col-12">
            <style>
                .nombre {
                    border-bottom: 1.5px solid white;
                }

                .precio{
                    font-size: 2em;
                    transition: .4s;
                }

                .contenedor-productos > div:hover > .contenedor-info .precio {
                    font-size: 4em;
                }
            </style>
        @for ($i = 0; $i <= 1500; $i+=5)
            <div>
                
                <div class="contenedor-imagen">
                    <img src="http://placekitten.com/{{ $i+100 }}/{{ $i+100 }}" alt="">
                </div>
                <div class="contenedor-info">
                    <p class="nombre col-8 text-center fw-bold pb-2 fs-4 m-0">Gatito</p>
                    <p class="precio">17.99€</p>
                    <div class="botones-carrito"></div>
                </div>
                
            </div>
        @endfor
            
        </div>
    </div>
@endsection


@section('scripts')

@endsection