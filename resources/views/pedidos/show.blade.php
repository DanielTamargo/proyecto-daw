@extends('layouts.app')

@section('styleScripts')

@endsection


@section('navActiva')
    @php
        $nav_activa_pedidos = true;
    @endphp
@endsection


@section('content')
    <div class="contenedor">
    
        <div class="col-11">
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
                @php $total = 0; @endphp
                    @foreach($pedido->productos as $producto)
                    @php $total += $producto->precio; @endphp
                        <tr>
                            <td><img src="{{ asset('img/'.$producto->foto) }}" alt="{{ $producto->id }}"></td>
                            <td class="text-overflow-ellipsis">{{ $producto->nombre }}</td>
                            <td class="text-center">{{ $producto->precio }}&euro;</td>
                            <td class="text-center">
                                <div class="d-flex flex-row flex-nowrap justify-content-center">
                                    <span class="p-2">Placeholder</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td class="d-flex justify-content-evenly"><b>Precio total:</b><span>{{ $total }}€</span></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
            <div class="progress col-12">
                <div id="progress" class="progress-bar {{ $pedido->estado }}" role="progressbar">
                </div>
            </div>
            <div class="col-12 d-flex justify-content-between">
                <span></span>
                <span>Oído cocina</span>
                <span>En preparacion</span>
                <span>Listo</span>
                <span>Recogido</span>
            </div>
        </div>
        <input type="hidden" id="estado" value="{{ $pedido->estado }}">
        <input type="hidden" id="id_pedido" value="{{ $pedido->id }}">
        <input type="hidden" id="url_api" value="{{ route('api.pedido.obtenerestadopedido') }}">
    </div>
@endsection


@section('scripts')
<script src="{{ asset('js/lib/jquery-3.6.0.min.js') }}"></script>
<script>
const token_cliente = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const pedido_id = document.querySelector('#id_pedido').getAttribute('value');
var datos = document.querySelector('#estado').getAttribute('value');
const urlAPI = document.querySelector('#url_api').getAttribute('value');

setInterval(() => {
    peticionAPIActualizarDatos();
    actualizarBarra(datos);
}, 1000);


function actualizarBarra(estado) {
    document.querySelector('#progress').className='progress-bar '+estado;
}


function peticionAPIActualizarDatos() {

    fetch(urlAPI, {
        method: 'POST',
        body: JSON.stringify({
            'pedido_id' : Number(pedido_id),
        }),
        headers:{
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token_cliente
        }
    }).then(res => res.json())
    .then(response => datos=response['estado'])
    .catch(error => console.error('Error:', error));

}
</script>
@endsection