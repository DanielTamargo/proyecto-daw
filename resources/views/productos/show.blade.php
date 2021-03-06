@extends('layouts.app')

@section('styleScripts')
  <style>
        .comentarios {
            width: 100%;
            padding: 0 2em; 
        }
        hr.separadorComentarios {
            border: 0;
            height: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
  </style>
@endsection


@section('content')
    <div class="contenedor-show contenedor-1">
        <div class="contenedor">
            <div class="imagen mb-3">
                <img src="{{ asset('img/'.$producto->foto) }}" alt="foto">
            </div>
            <div class="detalles">
                <p style="line-height: 1em !important;" id="nombre">{{ $producto->nombre }}</p>
                <p class="d-flex justify-content-between" id="precio">
                    <span>
                        {{ $producto->precio }}€
                    </span>
                    <span id="twitter" class="me-4">
                        <a target="blank" href="https://twitter.com/intent/tweet?text=Mira%20este%20plato%20que%20he%20encontrado%20en%20la%20mejor%20pagina%20de%20comida%20del%20mundo&url={{ url()->current() }}&hashtags=comida,hosteleria,oferta,delicioso">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-share-fill" viewBox="0 0 16 16">
                            <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                            </svg>
                        </a>
                    </span>
                </p>
                <p id="descripcion">{{ $producto->descripcion }}</p>
                <div class="botonera d-flex flex-row justify-content-center align-items-center p-3">
                    @if(Auth::user() && Auth::user()->rol == \App\Models\Constants::ROL_ADMINISTRADOR)
                        <form id="eliminar-producto-{{ $producto->id }}" action="{{ route('productos.destroy') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                        </form>
                        <a class="btn btn-primary mb-5"  href="{{ route('productos.edit', ['id' => $producto->id]) }}">Editar</a>
                        <button class="btn btn-danger ms-3 mb-5" producto_id="{{ $producto->id }}" onclick="eliminarProducto(this)">Eliminar</button>
                    @else
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
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="contenedor-show contenedor-2">
        <div class="contenedor">
            <div class="wave-decoration">
                <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                    <defs><path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" /></defs>
                    <g class="parallax">
                        <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255, 255, 255, 0.7)" />
                        <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255, 255, 255, 0.5)" />
                        <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255, 255, 255, 0.3)" />
                        <use xlink:href="#gentle-wave" x="48" y="7" fill="rgb(255, 255, 255)" />
                    </g>
                </svg>
            </div>

            {{-- Lista de comentarios del producto --}}
            <div class="comentarios py-5">
                {{--  
                    Badges
                    <span class="badge bg-secondary">Admin</span> 
                    <span class="badge bg-secondary">Compra confirmada</span> 
                --}}
                @php
                    $i = 0;
                    $usuario = Auth::user();
                @endphp
                @if (count($producto->comentarios) <= 0)
                    <div class="sin-comentarios">
                        <h2 class="text-muted text-center">El producto no tiene comentarios</h2>
                        @if ($usuario && $usuario->rol == \App\Models\Constants::ROL_CLIENTE)
                            <h3 class="text-muted text-center">¡Sé el primero en comentar!</h3>
                        @endif
                    </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <div class="nuevo-comentario mb-5">
                    <h5 class="text-start">Añadir un nuevo comentario</h5>
                    <form action="{{ route('comentarios.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                        <textarea minlength="8" maxlength="255" class="form-control mb-3" id="texto" name="texto" rows="3" required>{{ old('texto') }}</textarea>
                        <button type="submit" class="btn btn-primary align-self-start">Añadir comentario</button>
                    </form>
                </div>

                @foreach ($producto->comentarios as $comentario)
                    @php
                        $i++;
                    @endphp
                    <div class="comentario mb-5">
                        <h5>{{ ucwords(strtolower($comentario->cliente->nombre)) }}  
                            @if ($comentario->cliente->rol ==  \App\Models\Constants::ROL_ADMINISTRADOR)
                                <span class="badge bg-secondary">Administrador</span> 
                            @elseif ($comentario->cliente->compraVerificada($producto->id))
                                <span class="badge bg-secondary">Compra verificada</span>  
                            @endif
                        </h5>

                        <p>{{ $comentario->texto }}</p>
                        @if ($i < count($producto->comentarios))
                            <hr class="separadorComentarios">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <input type="hidden" id="nyb_cl" value="{{ Auth::user() ? 'true' : '' }}">
        <input type="hidden" id="url_api" value="{{ route('api.carrito.actualizarproducto') }}">
        <input type="hidden" id="url_login" value="{{ route('login') }}">
    </div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/gh/coswise/hicon-js@latest/hicon.min.js"></script>
<script src="{{asset('js/lib/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/lib/Draggable3.min.js')}}"></script>
<script src="{{asset('js/lib/gsap.min.js')}}"></script>
<script src="{{asset('js/lib/TweenMax.min.js')}}"></script>
<script src="{{asset('js/boton.js')}}"></script>

<script src="{{asset('js/producto.js')}}"></script>

@endsection