@extends('layouts.app')

@section('content')

    {{-- 
        - Utilidades:
            + Obtener puntuación media de valoraciones de un producto:
                $punt_media = number_format(App\Models\Comentario::where('producto_id', $producto->id)->pluck('puntuacion')->avg(), 1);

        - Relaciones:
            + Producto:
                $producto->creador 
                $producto->comentarios 
                $producto->categorias
                $producto->cantidadEnCarrito($user)

            + Usuario cliente:
                $usuario->pedidos
                $usuario->comentarios
                $usuario->productosCarrito

            + Usuario administrador:
                $usuario->productosCreados

            + Pedido:
                $pedido->productos
                $pedido->cliente
            
            + Categorías:
                $categoria->productos
    --}}

    <div class="mt-5 px-5">
        {{-- PRUEBAS CARRITO --}}
        <div class="card mb-4">
            <div class="card-body">
                <h1 class="card-title">Pruebas carrito</h1>
                <br>
                
                @php
                    $producto = \App\Models\Producto::find(1);
                    $usuario = \App\Models\User::find(13);
                @endphp
                    <p class="card-text m-0">Producto: {{ $producto->nombre }}</p>
                    <p class="card-text m-0">Usuario: {{ $usuario->nombre }}</p>
                    <p class="card-text m-0">Veces en carrito: {{ $producto->cantidadEnCarrito($usuario) }}</p>
                
                <hr>

                @php
                    $producto = \App\Models\Producto::find(2);
                    $usuario = \App\Models\User::find(13);
                @endphp
                    <p class="card-text m-0">Producto: {{ $producto->nombre }}</p>
                    <p class="card-text m-0">Usuario: {{ $usuario->nombre }}</p>
                    <p class="card-text m-0">Veces en carrito: {{ $producto->cantidadEnCarrito($usuario) }}</p>

            </div>
        </div>

        <!--
        {{-- USUARIOS --}}
        <div class="card mb-4">
            <div class="card-body">
              <h1 class="card-title">Usuarios</h1>
              @if (isset($usuarios) && count($usuarios) > 0)
                @foreach ($usuarios as $usuario)
                    <p class="card-text m-0">{{ ucfirst($usuario->rol) }} | {{ $usuario->nombre }}</p>
                    @if ($usuario->rol == App\Models\Constants::ROL_CLIENTE)
                        <p class="card-text m-0">Número de pedidos: {{ count($usuario->pedidos) }}</p>
                        <p class="card-text m-0">Número de comentarios realizados: {{ count($usuario->comentarios) }}</p>
                        @if (count($usuario->productosCarrito) > 0)
                            <p class="card-text m-0">Productos en el carrito:</p>
                            <ul>
                                @foreach ($usuario->productosCarrito as $producto)
                                    <li>{{ ucfirst($producto->nombre) }} (id: {{ $producto->id }})</li> 
                                @endforeach
                            </ul>
                        @endif
                    @else
                        <p class="card-text m-0">Productos creados: {{ count($usuario->productosCreados) }}</p>
                    @endif
                    <br>
                @endforeach
              @else
                <div class="alert alert-success">
                    <p>Sin usuarios registrados</p>
                </div>
              @endif
            </div>
        </div>

        {{-- PRODUCTOS --}}
        <div class="card mb-4">
            <div class="card-body">
              <h1 class="card-title">Productos</h1>
              @if (isset($productos) && count($productos) > 0)
                @foreach ($productos as $producto)
                    <p class="card-text m-0"><b>{{ $producto->id }}</b> | {{ $producto->nombre }}</p>
                    <p class="card-text m-0">Creado por: {{ $producto->creador->nombre }}</p>
                    <p class="card-text m-0">Número de comentarios: {{ count($producto->comentarios) }}</p>
                    @php
                        $punt_media = number_format(App\Models\Comentario::where('producto_id', $producto->id)->pluck('puntuacion')->avg(), 2);
                    @endphp
                    <p class="card-text m-0">Puntuación media: {{ $punt_media < 1 ? 'Sin puntuaciones' : $punt_media }}</p>
                    <p class="card-text m-0">Categorías: 
                        @foreach ($producto->categorias as $categoria)
                            {{ ucfirst($categoria->nombre) }} 
                        @endforeach
                    </p>
                    <br>
                @endforeach
              @else
                <div class="alert alert-success">
                    <p>Sin productos registrados</p>
                </div>
              @endif
            </div>
        </div>

        {{-- PEDIDOS --}}
        <div class="card mb-4">
            <div class="card-body">
              <h1 class="card-title">Pedidos</h1>
              @if (isset($pedidos) && count($pedidos) > 0)
                @foreach ($pedidos as $pedido)
                    <p class="card-text m-0"><b>{{ $pedido->id }}</b> | {{ $pedido->fecha_pedido }}</p>
                    <p class="card-text m-0">Realizado por: {{ $pedido->cliente->nombre }}</p>
                    <p class="card-text m-0">Estado: {{ $pedido->estado }}</p>
                    <p class="card-text m-0">Productos (ids): 
                        @foreach ($pedido->productos as $producto)
                            {{ ucfirst($producto->id) }}  
                        @endforeach
                    </p>
                    <br>
                @endforeach
              @else
                <div class="alert alert-success">
                    <p>Sin pedidos registrados</p>
                </div>
              @endif
            </div>
        </div>

        {{-- CATEGORIAS --}}
        <div class="card mb-4">
            <div class="card-body">
              <h1 class="card-title">Categorías</h1>
              @if (isset($categorias) && count($categorias) > 0)
                @foreach ($categorias as $categoria)
                    <p class="card-text m-0"><b>{{ ucfirst($categoria->nombre) }}</b></p>
                    <p class="card-text m-0">Productos (ids): 
                        @foreach ($categoria->productos as $producto)
                            {{ ucfirst($producto->id) }}  
                        @endforeach
                    </p>
                    <br>
                @endforeach
              @else
                <div class="alert alert-success">
                    <p>Sin categorías registrados</p>
                </div>
              @endif
            </div>
        </div>
        -->
    </div>
@endsection