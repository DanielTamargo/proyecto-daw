const token_cliente = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const urlAPI = document.querySelector('#url_api').getAttribute('value');
var botonActivo = document.getElementById('pedidos-boton-todos');


function peticionAPIActualizarEstadoPedido(opcion) {
    fetch(urlAPI, {
        method: 'POST',
        body: JSON.stringify({
            'pedido_id' : Number(opcion.getAttribute('pedido_id')),
            'estado' : opcion.value,
        }),
        headers:{
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token_cliente
        }
    }).then(res => res.json())
    .then(response => {
        if (response.ok) {
            let badge_bg = 'bg-secondary';
            let badge_text = 'Finalizado';
            switch(opcion.value) {
                case 'recibido':
                    badge_bg = 'bg-primary';
                    badge_text = 'Recibido';
                    break;
                case 'enproceso':
                    badge_bg = 'bg-info';
                    badge_text = 'En proceso';
                    break;
                case 'listo':
                    badge_bg = 'bg-success';
                    badge_text = 'Listo';
                    break;
                case 'cancelado':
                    badge_bg = 'bg-danger';
                    badge_text = 'Cancelado';
                    break;
                default:
                    badge_bg = 'bg-secondary';
                    badge_text = 'Finalizado';
            }

            document.getElementById('badge-pedido-' + opcion.getAttribute('pedido_id')).setAttribute('class', 'badge ' + badge_bg);
            document.getElementById('badge-pedido-' + opcion.getAttribute('pedido_id')).innerText = badge_text;
        }
    })
    .catch(error => console.error('Error:', error));
}

function filtrarPedidos(filtro) {
    let botonTodos = document.getElementById('pedidos-boton-todos');
    let botonPendientes = document.getElementById('pedidos-boton-pendientes');
    let botonFinalizados = document.getElementById('pedidos-boton-finalizados');

    let pedidosPendientes = document.getElementById('lista-pedidos-pendientes');
    let pedidosFinalizados = document.getElementById('lista-pedidos-finalizados');

    botonActivo.classList.remove('btn-primary');
    botonActivo.classList.add('btn-secondary');

    switch(filtro) {
        case 2: // Pendientes
        botonPendientes.classList.remove('btn-secondary');
            botonPendientes.classList.add('btn-primary');

            pedidosPendientes.style.display = 'block';
            pedidosFinalizados.style.display = 'none';

            botonActivo = botonPendientes;
            break;
        case 3: // Finalizados
            botonFinalizados.classList.remove('btn-secondary');
            botonFinalizados.classList.add('btn-primary');

            pedidosPendientes.style.display = 'none';
            pedidosFinalizados.style.display = 'block';

            botonActivo = botonFinalizados;
            break;
        default: // Todos
            botonTodos.classList.remove('btn-secondary');
            botonTodos.classList.add('btn-primary');

            pedidosPendientes.style.display = 'block';
            pedidosFinalizados.style.display = 'block';

            botonActivo = botonTodos;
    }
}