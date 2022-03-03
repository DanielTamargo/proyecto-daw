<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pruebas</title>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/prueba.css') }}">
</head>
<body>
    <div class="contenedor">
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
                <h1>Registrarse</h1>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input id="name" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" placeholder="Nombre" required>
                    <input class="form-control" id="username" type="text" placeholder="Nombre de usuario" name="username" value="{{ old('username') }}" required>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
                    <input type="text" id="direccion" class="form-control" name="direccion" value="{{ old('direccion') }}" placeholder="Direcci&oacute;n">
                    <input class="form-control" id="password" type="password" placeholder="Contrase&ntilde;a" name="password" required>
                    <input id="password-confirm" type="password" class="form-control" placeholder="Repetir contrase&ntilde;a" name="password_confirmation" required autocomplete="new-password">
                    <button type="submit" class="btn btn-primary col-12">
                        {{ __('Registrarse') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/prueba.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>