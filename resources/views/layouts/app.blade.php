<!doctype html>
<html lang="es-ES">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hosteleria') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styleScripts')
</head>
<body>
    <div id="app">
        <nav>
            <div class="nav-content-container">
                <div class="nav-content navbar navbar-expand-lg navbar-dark">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="{{ route('inicio') }}">{{ config('app.name', 'Hosteleria') }}</a>
                        <div id="derecha">
                            <div id="boton-carrito" class="d-inline-block me-5">
                                @auth
                                    <a href="">
                                        @php
                                            $cantidadProductosCarrito = 0;
                                            if (Auth::user()) $cantidadProductosCarrito = App\Models\User::find(Auth::user()->id)->cantidadProductosEnCarrito();
                                        @endphp
                                        <span id="indicador-carrito" class="badge rounded-pill bg-danger">{{ ($cantidadProductosCarrito > 0) ? $cantidadProductosCarrito : '' }}</span>
                                        <div class="carrito-svg-container">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512">
                                                <circle cx="176" cy="416" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                                <circle cx="400" cy="416" r="16" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M48 80h64l48 272h256"/>
                                                <path d="M160 288h249.44a8 8 0 007.85-6.43l28.8-144a8 8 0 00-7.85-9.57H128" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/>
                                            </svg>
                                        </div>
                                    </a>
                                @endauth
                            </div>
                            <button class="menu navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <svg viewBox="0 0 64 48">
                                    <path d="M19,15 L45,15 C70,15 58,-2 49.0177126,7 L19,37"></path>
                                    <path d="M19,24 L45,24 C61.2371586,24 57,49 41,33 L32,24"></path>
                                    <path d="M45,33 L19,33 C-8,33 6,-2 22,14 L45,37"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav">
                                @yield('navActiva')
                                <li class="nav-item">
                                    <a class="nav-link @isset($nav_activa_carta) active @endisset" aria-current="page" href="{{ route('inicio') }}">Carta</a>
                                </li>
                                <li class="nav-item">
                                    @guest
                                        <a class="nav-link @if(isset($nav_activa_login) || isset($nav_activa_register)) active @endif" href="{{ route('login') }}">Iniciar sesión</a>                                        
                                    @endguest
                                    @auth
                                        <a class="nav-link @isset($nav_activa_perfil) active @endisset" href="{{ route('usuarios.profile') }}">Mi perfil</a>
                                        @if(Auth::user()->rol == App\Models\Constants::ROL_ADMINISTRADOR)
                                            <a class="nav-link" href="#">Pedidos</a>
                                        @endif
                                    @endauth
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="nav-decoration">
                <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                    <defs><path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" /></defs>
                    <g class="parallax">
                        <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(102, 16, 242, 0.7)" />
                        <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(102, 16, 242, 0.5)" />
                        <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(102, 16, 242, 0.3)" />
                        <use xlink:href="#gentle-wave" x="48" y="7" fill="#6610f2" />
                    </g>
                </svg>
            </div>
        </nav>

        <section id="separador">&nbsp;</section>

        <main>
            @yield('content')
        </main>
    </div>

    @yield('scripts')
</body>
</html>
