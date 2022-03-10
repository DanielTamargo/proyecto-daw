@extends('layouts.app')

@section('styleScripts')
  <style>
        .comentario {
            width: 100%;    
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
            <div class="imagen">
                <img src="{{ asset('img/'.$producto->foto) }}" alt="foto">
            </div>
            <div class="detalles">
                <p id="nombre">{{ $producto->nombre }}</p>
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
                <div class="botonera d-flex justify-content-between">
                <div class="boton-confirmar">
                    <div class='container-btn'>
                        <div class='el-wrap'>
                            <div class='slider'>
                                <div class='slider-text'>
                                    <div class='text'>
                                    Confirmar
                                    </div>
                                </div>
                                <div class='slider-trigger'>
                                    <div class='controller' id='controller'>
                                        <i load-hicon='chevron-right' class='icon icon-opa'></i>
                                    </div>
                                    <div class='endpoint-container'>
                                        <div class='endpoint' id='controllerDrop'></div>
                                    </div>
                                </div>
                            </div>
                            <div class='button btn-clickable'>
                                <p class='text text-c'>Comprar</p>
                                <i load-hicon='check' class='icon icon-check'></i>
                            </div>
                        </div>
                    </div>
                </div>
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
            <div class="comentarios py-3">
                {{--  
                    Badges
                    <span class="badge bg-secondary">Admin</span> 
                    <span class="badge bg-secondary">Compra confirmada</span> 
                --}}
                @php
                    $i = 0;
                @endphp
                @forelse ($producto->comentarios as $comentario)
                    @php
                        $i++;
                    @endphp
                    <div class="comentario">
                        <h5>asdfsadf <span class="badge bg-secondary">Admin</span></h5>
                        <p>asdfasdf</p>
                        @if ($i < count($producto->comentarios))
                            <hr class="separadorComentarios">
                        @endif
                    </div>
                @empty
                    <div class="sin-comentarios">
                        <h3 class="text-muted">El producto no tiene comentarios</h3>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script src="https://cdn.jsdelivr.net/gh/coswise/hicon-js@latest/hicon.min.js"></script>
<script src="{{asset('js/lib/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('js/lib/Draggable3.min.js')}}"></script>
<script src="{{asset('js/lib/gsap.min.js')}}"></script>
<script src="{{asset('js/lib/TweenMax.min.js')}}"></script>

<script>
    hicon.replace();
$(document).ready(function() {
  initDrag();
});
// Button
$(".btn-clickable").click(function() {
  setTimeout(function() {
    $(".slider").addClass("sldr-opa");
  }, 199); 
  setTimeout(function() {
    $(".slider").addClass("sldr-pos");
  }, 299); 
  setTimeout(function() {
    $(".button").removeClass("btn-clickable");
    $(".text-c").text("Hecho");
    $(".icon").removeClass("icon-check");
    loadController();
  }, 359);  
  setTimeout(function() {
    $(".icon").removeClass("icon-opa");
  }, 499); 
});


// Slider
// Initial status
var controller = $(".controller");
TweenMax.set(controller, {scale: 0, opacity: 0});

var sliderContainer = $(".endpoint-container"),
    tl = new TimelineLite(),
    dropTargets = $(".endpoint"),
    totlaTarges = 1,
    totalHit = 0;


// After load status
function loadController() {
  TweenMax.staggerTo(controller, .2, {scale: 1,opacity: 1, ease: Back.easeOut, force3D: true}), initDrag;
};

function initDrag() {
  Draggable.create(controller, {
    bounds: sliderContainer,
    edgeResistance: 1,
    type:'x',
    onPress: function() {

      this.sartX = this.x;
      this.sartY = this.y;

      this.offsetTop = this.startY - $(this.target).position().top;
      this.offsetLeft = this.startX - $(this.target).position().left;

    },
    onDragStart: function(){ 
      $(".slider").toggleClass("sldr-drag");
      $(".slider-text").toggleClass("text-d");
    }, 
    onDragEnd: function() {
      var dragThing = this;
      var dragID = this.target.id + "Drop";

      $.each(dropTargets, function (idx, spot) {
        var spotID = spot.id;
        var pos = $(spot).position();
        var diffTop = dragThing.offsetTop + pos.top;
        var diffLeft = dragThing.offsetLeft + pos.left;


        if (spotID === dragID) {
          if(dragThing.hitTest(spot, "70%")) {
            TweenMax.to(dragThing.target, .1, {x: diffLeft, y: diffTop, marginTop: "4px", marginLeft: "3px"});
            TweenMax.staggerTo(controller, .5, {scale: 0,opacity: 0, delay: .5, ease: Back.easeOut, force3D: true}, SliderOff);
            // Post action 
            function SliderOff() {
              setTimeout(function() {
                $(".slider").removeClass("sldr-opa");
              }, 499); 
              setTimeout(function() {
                $(".slider").removeClass("sldr-pos");
              }, 799); 
              setTimeout(function() {
                $(".el-wrap").addClass("el-wrap-shield");
              }, 499);
            }
          } else {
            TweenMax.to(dragThing.target, .5, {x: dragThing.startX, y: dragThing.startY});
          }
        }
      });
      $(".slider").toggleClass("sldr-drag");
      $(".slider-text").toggleClass("text-d");
    }
  })
};


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