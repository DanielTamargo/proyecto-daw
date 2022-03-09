@extends('layouts.app')

@section('styleScripts')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
@endsection


@section('content')
    <div class="contenedor justify-content-start">
        <div class="contenedor-categorias col-12"></div>
        <div class="contenedor-productos col-12">
        @for ($i = 0; $i <= 500; $i+=5)
            <div>
                
                <div class="contenedor-imagen">
                    <img src="http://placekitten.com/{{ $i+100 }}/{{ $i+100 }}" alt="">
                </div>
                <div class="contenedor-info">
                    <p class="nombre col-8 text-center fw-bold pb-2 fs-4 m-0">Gatito</p>
                    <p class="precio">17.99€</p>
                    <div class="annadir-carrito">
                        <div class="btn-menos">
                            <button><b>-</b></button>
                        </div>
                        <div class="btn-principal">
                            <button class="add-to-cart">
                                <div class="default">Añadir al carrito</div>
                                <div class="success">Añadido</div>
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
        @endfor
            
        </div>
    </div>
@endsection


@section('scripts')
<script>
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