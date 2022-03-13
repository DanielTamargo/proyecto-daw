const urlAPI = document.getElementById('url_api').value;
const token_cliente = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const accionSumar = 'sumar';
const accionRestar = 'restar';

function despues() {
    // code here
}

// Redirección a producto si clica en la celda
document.querySelectorAll('#cuerpo-carrito tr').forEach(el => {
    let id = el.children[0].children[0].getAttribute('alt');
    el.addEventListener('click', function(evt) {
        if (evt.target.tagName != 'BUTTON' && evt.target.parentElement.tagName != 'BUTTON') {
            window.location.href = '/carta/' + id;
        }
    })
});


// Función que actualiza el precio
function actualizarPrecioProducto(producto_id, producto_precio, cantidad) {
    document.getElementById('precio-producto-' + producto_id).innerText = (producto_precio * cantidad).toFixed(2) + "€";
    actualizarTotal();
}

// Función que actualiza el total
function actualizarTotal() {
    var total = 0;
    document.querySelectorAll('.precio-producto').forEach(elm => {
        total += Number(elm.innerText.replace('€', ''));
    });

    document.getElementById('precio-total-carrito').innerText = "Total: " + total.toFixed(2) + "€";

}

// Función que suma uno a la cifra del producto y se lo manda a la API
function sumarCantidad(button) {
    let producto_id =  button.getAttribute('producto_id');
    let elemCantidad = document.getElementById('cantidad-producto-' + producto_id);
    let num = Number(elemCantidad.innerText);
    num++;
    elemCantidad.innerText = num;

    actualizarCantidadCarrito(accionSumar);
    peticionAPIActualizarCarrito(producto_id, num);
    actualizarPrecioProducto(producto_id, Number(button.getAttribute('producto_precio')), num);
}

// Función que suma uno a la cifra del producto y se lo manda a la API
function restarCantidad(button) {
    let producto_id =  button.getAttribute('producto_id');
    let elemCantidad = document.getElementById('cantidad-producto-' + producto_id);
    let num = Number(elemCantidad.innerText);
    num--;
    if (num < 0) return;

    elemCantidad.innerText = num;

    actualizarCantidadCarrito(accionRestar);
    peticionAPIActualizarCarrito(producto_id, num);
    actualizarPrecioProducto(producto_id, Number(button.getAttribute('producto_precio')), num);
}

// Función que actualiza la cantidad total del carrito
function actualizarCantidadCarrito(accion) {
    let elm_carrito = document.getElementById('indicador-carrito');
    let numCarrito = Number(elm_carrito.innerText);
    if (Number.isNaN(numCarrito)) numCarrito = 0;

    if (accion === accionSumar) {
        numCarrito++;
    } else if (accion === accionRestar) {
        numCarrito--;
    }

    if (numCarrito > 0) elm_carrito.innerText = numCarrito;
    else elm_carrito.innerText = '';
}

// Petición API que actualiza en la BBDD el carrito del usuario
function peticionAPIActualizarCarrito(producto_id, producto_cantidad) {
    fetch(urlAPI, {
        method: 'POST',
        body: JSON.stringify({
            'producto_id' : Number(producto_id),
            'producto_cantidad' : producto_cantidad,
        }),
        headers:{
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': token_cliente
        }
      }).then(res => res.json())
      .then(response => console.log('Success:', response))
      .catch(error => console.error('Error:', error));
}