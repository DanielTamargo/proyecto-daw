@extends('layouts.app')

@section('styleScripts')
    
@endsection


@section('content')
    <div class="contenedor justify-content-start row g-3">
    <table class="table table-striped table-hover align-middle">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Nombre</th>
                <th scope="col">Precio</th>
                <th scope="col">N&uacute;mero</th>
                <th scope="col">Eliminar</th>
            </tr>
        </thead>
        <tbody id="cuerpo-carrito">
            @foreach($productos as $producto)
                <tr>
                    <td><img src="{{ asset('img/'.$producto->foto) }}" alt="{{ $producto->id }}"></td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->precio }}&euro;</td>
                    <td>{{ $producto->cantidadEnCarrito(Auth::user()) }}</td>
                    <td>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                        </svg>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
        
    </div>
@endsection


@section('scripts')
    <script>
        document.querySelectorAll('#cuerpo-carrito tr').forEach(el => {
            let id = el.children[0].children[0].getAttribute('alt');
            el.addEventListener('click', function() {
                window.location.href = '/carta/' + id;
            })
        });
    </script>
@endsection