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


            {{-- Div a mostrar cuando el pedido es cancelado --}}
            <div id="pedido-cancelado" class="col-12 mb-5" style="display: none;">
                <h3 class="text-muted text-center">El pedido ha sido <b>cancelado</b></h3>
                <p class="text-muted text-center">Si consideras que se trata de un error, llama al <b>945 71 54 32</b> o contacta a <b>hosteleriadaw@gmail.com</b></p>
            </div>

            {{-- Div a mostrar cuando hay petición al recuperar la información del pedido --}}
            <div id="error-comprobar-pedido" class="col-12 mb-5" style="display: none;">
                <h3 class="text-muted text-center">No hemos podido actualizar el estado del pedido. Intentándolo de nuevo...</h3>
                <p class="text-muted text-center">Si este mensaje no se oculta significa que el problema persiste, llama al <b>945 71 54 32</b> o contacta a <b>hosteleriadaw@gmail.com</b></p>
            </div>

            {{-- Div que muestra la barra de progreso del pedido --}}
            <div id="barra-estado-pedido" class="progress col-12">
                <div id="progress" class="progress-bar {{ $pedido->estado }}" role="progressbar">
                </div>
            </div>
            <div id="barra-estado-pedido-textos" class="col-12 d-flex justify-content-between mb-5" style="display: flex;">
                <span></span>
                <span>Oído cocina</span>
                <span>En preparación</span>
                <span>Listo</span>
                <span id="ultimo-estado">Recogido</span>
            </div>
            <h4>Lista de productos del pedido</h4>
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell" scope="col"></th>
                        <th scope="col">Nombre</th>
                        <th class="text-center" scope="col">Precio</th>
                        <th class="text-center" scope="col">Cantidad</th>
                    </tr>
                </thead>
                <tbody id="cuerpo-carrito">
                    @foreach($pedido->productos as $producto)
                        <tr>
                            <td class="d-none d-sm-table-cell" ><img src="{{ asset('img/'.$producto->foto) }}" alt="{{ $producto->id }}"></td>
                            <td class="text-overflow-ellipsis">{{ $producto->nombre }}</td>
                            <td class="text-center">{{ number_format($producto->precio * $producto->cantidadEnPedido($pedido), 2) }}&euro;</td>
                            <td class="text-center">
                                <div class="d-flex flex-row flex-nowrap justify-content-center">
                                    <span class="p-2">{{ $producto->cantidadEnPedido($pedido) }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="d-none d-sm-table-cell" ></td>
                        <td></td>
                        <td></td>
                        <td class="d-flex justify-content-evenly"><b>Precio total:</b><span>&nbsp;{{ $pedido->precioTotal() }}€</span></td>
                    </tr>
                </tfoot>
            </table>
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
    //actualizarBarra(datos);
}, 1000);

var error = false;
var cancelado = false;

function actualizarBarra(estado) {
    if (estado.toLowerCase() !== 'cancelado' && estado.toLowerCase() !== 'error') {
        if (error || cancelado) {
            if (error) { 
                error = false;
                document.querySelector('#error-comprobar-pedido').style.display = 'none';
            }
            else if (cancelado) {
                cancelado = false;
                document.querySelector('#pedido-cancelado').style.display = 'none';
                document.querySelector('#ultimo-estado').innerText = 'Recibido';
            }
        }

        document.querySelector('#progress').className='progress-bar '+ estado;
    } else if (estado.toLowerCase() === 'cancelado') {
        if (!cancelado) {
            cancelado = true;
            document.querySelector('#ultimo-estado').innerText = 'Cancelado';
            document.querySelector('#progress').className='progress-bar cancelado';

            document.querySelector('#pedido-cancelado').style.display = 'block';
        }

    } else if (estado.toLowerCase() === 'error') {
        if (!error) {
            error = true;
            document.querySelector('#error-comprobar-pedido').style.display = 'block';
        }
    }
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
    .then(response => {
        if (response.ok) {
            datos=response['estado'];
        } else {
            datos='error';
        }
        actualizarBarra(datos);
    })
    .catch(error => console.error('Error:', error));

}
</script>
@endsection