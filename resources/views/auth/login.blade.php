@extends('layouts.app')

@section('styleScripts')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="contenedor">

    {{-- Hidden para cargar directamente el formulario de registro si es necesario --}}
    @if (isset($registrar_usuario))
        <input type="hidden" name="cargar-registro" id="cargar-registro" value="true">
    @else
        <input type="hidden" name="cargar-registro" id="cargar-registro" value="false">
    @endif

    {{-- Hidden para controlar si es un administrador registrando a otro administrador --}}
    @if (Auth::user() && Auth::user()->rol == \App\Models\Constants::ROL_ADMINISTRADOR)
        <input type="hidden" name="nuevo-administrador" id="nuevo-administrador" value="true">
    @endif

    @if ($errors->any()) {{-- Cambiar por un alert/toast --}}
        @if ($errors->has('username')) {{-- Login error --}}
            
        @endif
        <div class="alert alert-danger">
            <p>{{ $errors }}</p>
        </div>
    @endif
    <div class="loginCard">
        <div id="form1" class="form1">
            <h1 class="noSaltar">Iniciar Sesi&oacute;n</h1>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input class="form-control" id="username" type="text" placeholder="Nombre de usuario" name="username" value="{{ old('username') }}" required>
                <input class="form-control" id="password" type="password" placeholder="Contrase&ntilde;a" name="password" required>
                <div class="form-check noSaltar">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Recordarme') }}
                    </label>
                </div>
                
                @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('¿Olvidaste tu contraseña?') }}
                    </a>
                @endif

                <button type="submit" class="btn btn-primary col-12">
                    {{ __('Iniciar sesión') }}
                </button>

                            
            </form>
        </div>
        <div id="form2" class="form2 inactiveForm">
            @php
                // Un usuario se registrará como cliente, un admin registrará otros admins
                if (Auth::user() && Auth::user()->rol == \App\Models\Constants::ROL_ADMINISTRADOR) $rol = \App\Models\Constants::ROL_ADMINISTRADOR;
                else $rol = \App\Models\Constants::ROL_CLIENTE;
            @endphp

            <h1>{{ ($rol == \App\Models\Constants::ROL_CLIENTE) ? 'Registrarse' : 'Registrar un administrador'}}</h1>
            <form method="POST" action="{{ route('register.store', ['rol' => $rol]) }}">
                @csrf
                <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre completo" required>
                <div class="input-group">
                    <input class="form-control" id="username" type="text" placeholder="Nombre de usuario" name="username" value="{{ old('username') }}" required>
                    <span class="input-group-text" id="basic-addon1"></span>
                    <input class="form-control" id="dni" type="text" placeholder="DNI" name="dni" value="{{ old('dni') }}" required>
                </div>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
                <input type="text" id="direccion" class="form-control" name="direccion" value="{{ old('direccion') }}" placeholder="Direcci&oacute;n">
                <input class="form-control" type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" placeholder="N&uacute;mero de tel&eacute;fono">
                <div class="input-group">
                    <input class="form-control" id="password" type="password" placeholder="Contrase&ntilde;a" name="password" required>
                    <span class="input-group-text" id="basic-addon1"></span>
                    <input id="password-confirm" type="password" class="form-control" placeholder="Repetir contrase&ntilde;a" name="password_confirmation" required autocomplete="new-password">
                </div>
                
                <button id="registro-submit" type="submit" class="btn btn-primary col-12">
                    {{ __('Registrarse') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    {{-- Librerías jQuery + notify --}}
    <script src="{{ asset('js/lib/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/lib/notify.min.js') }}"></script>

    {{-- Scripts login + registro --}}
    <script src="{{ asset('js/login.js') }}"></script>
    <script src="{{ asset('js/registro.js') }}"></script>
@endsection