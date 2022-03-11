@extends('layouts.app')

@section('styleScripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
@endsection


@section('content')
    <div class="contenedor @if(count($productos)!=0) justify-content-start row g-3">
        
        <table class="table table-responsive table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Nombre</th>
                    <th class="text-center" scope="col">Precio</th>
                    <th class="text-center" scope="col">Cantidad</th>
                </tr>
            </thead>
            <tbody id="cuerpo-carrito">
                @foreach($productos as $producto)
                    <tr>
                        <td><img src="{{ asset('img/'.$producto->foto) }}" alt="{{ $producto->id }}"></td>
                        <td class="text-overflow-ellipsis">{{ $producto->nombre }}</td>
                        <td class="text-center">{{ $producto->precio }}&euro;</td>
                        <td class="text-center">
                            <div class="d-flex flex-row flex-nowrap justify-content-center">
                                <button producto_id="{{ $producto->id }}" class="btn btn-primary sumar-cantidad"><i class="bi bi-caret-left-fill"></i></button>
                                <span producto_id="{{ $producto->id }}" class="p-2">{{ $producto->cantidadEnCarrito(Auth::user()) }}</span>
                                <button producto_id="{{ $producto->id }}" class="btn btn-primary restar-cantidad"><i class="bi bi-caret-right-fill"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex flex-row justify-content-evenly">
            <div class="boton-confirmar">
                <div class='container-btn'>
                    <div class='el-wrap'>
                        <div class='slider'>
                            <div class='slider-text'>
                                <div class='text'>
                                Confirmar
                                </div>
                            </div>
                            <div class='slider-trigger'>
                                <div class='controller' id='controller'>
                                    <i load-hicon='chevron-right' class='icon icon-opa'></i>
                                </div>
                                <div class='endpoint-container'>
                                    <div class='endpoint' id='controllerDrop'></div>
                                </div>
                            </div>
                        </div>
                        <div class='button btn-clickable'>
                            <p class='m-0 text text-c'>Comprar</p>
                            <i load-hicon='check' class='icon icon-check'></i>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-danger">Vaciar carrito</button>
        </div>
        @else 
        justify-content-center">
        <p class="display-4">No hay nada aqu&iacute; todav&iacute;a</p>
        <p class="display-1"><i class="bi bi-emoji-frown text-primary"></i></p>
        <a href="{{ url()->previous() }}" class="btn btn-primary fs-2"><i class="bi bi-caret-left-fill"></i> Volver</a>
        @endif
    </div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/gh/coswise/hicon-js@latest/hicon.min.js"></script>
<script src="{{asset('js/lib/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/lib/Draggable3.min.js')}}"></script>
<script src="{{asset('js/lib/gsap.min.js')}}"></script>
<script src="{{asset('js/lib/TweenMax.min.js')}}"></script>
<script src="{{asset('js/boton.js')}}"></script>

    <script>
        /***
            TODO:
            Evitar que al clicar en el botón se vaya
            Sumar cantidad (API)
            Restar cantidad (API)
            Actualizar cantidad del producto
            Actualizar cantidad en el carrito
            Nota: si baja a 0 no borrarlo, se deja a 0 por si quiere volver a añadirlo
        ***/
        function despues() {
            // code here
        }

        document.querySelectorAll('#cuerpo-carrito tr').forEach(el => {
            let id = el.children[0].children[0].getAttribute('alt');
            el.addEventListener('click', function() {
                window.location.href = '/carta/' + id;
            })
        });
    </script>
@endsection