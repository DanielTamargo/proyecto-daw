// Constantes
const addedClass = 'added';
const visible = 'visible';
const accionSumar = 'sumar';
const accionRestar = 'restar';
const urlLogin = document.getElementById('url_login').value;
const urlAPI = document.getElementById('url_api').value;
const token_cliente = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const cliente_loggeado = document.getElementById('nyb_cl').value;

//https://attacomsian.com/blog/javascript-detect-mobile-device#:~:text=To%20detect%20if%20the%20user,and%20platform%20of%20the%20browser.
const tipoDispositivo = () => {
    const ua = navigator.userAgent;
    if (/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i.test(ua)) {
        return "tablet";
    }
    else if (/Mobile|Android|iP(hone|od)|IEMobile|BlackBerry|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/.test(ua)) {
        return "mobile";
    }
    return "desktop";
};

var productoSeleccionado = undefined;

// Listeners de la tarjetas de cada producto, que nos llevará a ver el producto
//   a través de la delegación de eventos actuará en toda la tarjeta excepto en los botones añadir al carrito, sumar o restar
document.querySelectorAll('div[tipo="tarjeta-producto"]').forEach(tarjeta => {
    tarjeta.addEventListener('click', evt => {
        let idProducto = tarjeta.id.split('-')[1];
        if (idProducto == productoSeleccionado || tipoDispositivo() == 'desktop') {
            if (!elementoTieneOCualquierPadreTieneClase(evt.target, 'annadir-carrito')) {
                window.location.href += '/' + idProducto;
            }
        } else {
            productoSeleccionado = idProducto;
        }
    }, true)
});

// Función recursiva: devuelve true si el elemento o uno de sus padres tiene la clase indicada
function elementoTieneOCualquierPadreTieneClase(elemento, clase) {
    if (elemento.className && elemento.className.split(' ').indexOf(clase)>=0) return true;
    return elemento.parentNode && elementoTieneOCualquierPadreTieneClase(elemento.parentNode, clase);
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
    // TODO opcional: api con timeout
    //    estaría interesante que por producto se ejecutase con timeout 
    //    por si añade 5 seguidos que no se ejecute la api 5 veces innecesariamente
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

// Función que suma uno a la cifra del producto y se lo manda a la API
function sumarCantidad(button) {
    let num = Number(button.children[1].innerText);
    num++;
    button.children[1].innerText = num;

    actualizarCantidadCarrito(accionSumar);
    peticionAPIActualizarCarrito(button.getAttribute('producto_id'), num);
}

document.querySelectorAll('.add-to-cart').forEach(button => {
    // Referenciamos a los botones más y menos
    let btnMenos = button.parentElement.parentElement.children[0];
    let btnMas = button.parentElement.parentElement.children[2];

    // Si al cargar la página ya estaba añadida al carrito, mostramos los botones e indicamos cantidad
    if (button.classList.contains(addedClass)) {
        btnMenos.classList.toggle(visible);
        btnMas.classList.toggle(visible);

        // Adicionalmente evitamos que se haga la animación del carrito para que si
        // el usuario hace rápidamente hover en el producto no vea la animación a medias
        let carrito = button.children[2];
        let puntos = button.children[3];
        
        carrito.remove();
        puntos.remove();
    }

    button.addEventListener('click', e => {
        // Si NO está loggeado, redirigimos al login
        if (!cliente_loggeado) {
            window.location.href = urlLogin;
            return;
        }

        if (!button.classList.contains(addedClass)) {
            // Si no se había añadido, se ejecuta la animación y se añaden
            button.classList.toggle(addedClass);
            btnMenos.classList.toggle(visible);
            btnMas.classList.toggle(visible);
            sumarCantidad(button);
        }

    });

    // Eventos sumar y restar
    btnMas.addEventListener('click', e => {
        // Sumamos uno a la cantidad
        sumarCantidad(button);
    });

    btnMenos.addEventListener('click', e => {
        // Restamos uno a la cantidad
        let num = Number(button.children[1].innerText);
        num--;
        if (num >= 0) {
            button.children[1].innerText = num;
            actualizarCantidadCarrito(accionRestar);
            peticionAPIActualizarCarrito(button.getAttribute('producto_id'), num);

            if (num == 0) {
                    // Si la cantidad era 0, ocultamos
                button.classList.toggle(addedClass);
                btnMenos.classList.toggle(visible);
                btnMas.classList.toggle(visible);

                if (!button.innerHTML.includes('cart')) {
                    button.innerHTML += `
                    <div class="cart">
                        <div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                    <div class="dots"></div>
                    `;
                }
            }
        }
    });
});


// Función que pide confirmación para eliminar el producto
function eliminarProducto(btn) {
    Swal.fire({
        title: '¿Estás seguro? Esta acción será irreversible',
        showCancelButton: true,
        cancelButtonText: 'Mejor no',
        confirmButtonText: 'Eliminar',
    }).then((result) => {
        if (result.isConfirmed) {
            document.forms["eliminar-producto-" + btn.getAttribute('producto_id')].submit();
        }
    });
}