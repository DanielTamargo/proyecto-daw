@extends('layouts.app')

@section('styleScripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
@endsection


@section('content')
    <div class="contenedor justify-content-start">
        <div class="contenedor-categorias col-12"></div>
        <div class="contenedor-productos col-12">
        @php
            $i=0;
        @endphp
        @foreach($productos as $producto)
        @php
            $i++;
        @endphp
            <div numero="{{ $i }}" id="producto-{{ $i }}">
                <div class="contenedor-imagen">
                    <img src="{{ asset('img/'.$producto->foto) }}" alt="foto">
                </div>
                <div class="contenedor-info">
                    <p class="nombre col-8 text-center fw-bold pb-2 fs-4 m-0">{{ $producto->nombre }}</p>
                    <p class="precio">{{ $producto->precio }}€</p>
                    <div class="annadir-carrito">
                        <div class="btn-menos">
                            <button><b>-</b></button>
                        </div>
                        <div class="btn-principal">
                            <button class="add-to-cart">
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
                </div>
            </div>
        @endforeach
        </div>
    </div>
@endsection


@section('scripts')
<script>
    // let cards = document.querySelector('.contenedor-productos').children;
    // for (const el of cards) {
    //     el.addEventListener('mouseenter',evt => {
    //         if(window.innerWidth > 1000) { //Tres columnas
    //             let result = String(el.getAttribute('numero')/3);
    //             let id = Number(el.getAttribute('numero'));
    //             let decimales = result.split('.')[1];
    //             if(decimales) {
    //                 if(decimales.split('')[0]==3) {
    //                     document.getElementById('producto-'+(id+1)).style.alignSelf = 'start';
    //                     document.getElementById('producto-'+(id+2)).style.alignSelf = 'start';
    //                 } else {
    //                     console.log('segundo');
    //                 }
    //             } else {
    //                 console.log('tercero');
    //             }
    //         } else if(window.innerWidth > 660) {
    //             let result = String(el.getAttribute('numero')/2);
    //             let decimales = result.split('.')[1];
    //             if(decimales) {
    //                 console.log('primero');
    //             } else {
    //                 console.log('segundo');
    //             }
    //         }
    //     });

    //     el.addEventListener('mouseleave',el => {

    //     });
    // }
    // ;

    document.querySelectorAll('.add-to-cart').forEach(button => {
        let btnMenos = button.parentElement.parentElement.children[0];
        let btnMas = button.parentElement.parentElement.children[2];
        button.addEventListener('click', e => {
            button.classList.toggle('added');
            btnMenos.classList.toggle('visible');
            btnMas.classList.toggle('visible');
        });
    });
</script>
@endsection