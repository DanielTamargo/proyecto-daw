<!DOCTYPE html>
<html>
<head>
    <title>Hosteleria DAW</title>

    <style>
        h1.titulo { color: #a370f7; }
        p { color: #2f2f2f; }
        a { color: #a370f7; }
    </style>
</head>
<body>
    <h1 class="titulo">Hostelería DAW</h1>
    <br>
    
    @if ($detalles['rol'] == App\Models\Constants::ROL_CLIENTE)
        <p>¡Hola {{ ucwords(strtolower($detalles['nombre'])) }}!</p>
        <p>Te comunicamos que el proceso de registro se ha realizado con éxito.</p>
        <p>Esperamos que disfrutes de tus futuros pedidos.</p> <br>
        <p>Cualquier problema o inconveniente no dudes en comunicárnoslo a nuestra dirección de correo: {{ env('MAIL_FROM_ADDRESS') }}</p>
    @else
        <p>Bienvenido/a {{ ucwords(strtolower($detalles['nombre'])) }}, <br>
            Te comunicamos que tu usuario ya ha sido registrado en nuestra página web.</p>
        <p>Estas serán tus credenciales: <br>
            Usuario: <b>{{ $detalles['usuario'] }}</b><br>
            Contraseña: <b>{{ $detalles['password'] }}</b></p>
        <p>Se te ha registrado como <b>administrador</b> por lo que podrás gestionar productos, pedidos y usuarios.</p>
    @endif

    <p><a href="{{ route('login') }}">Haz clic aquí para iniciar sesión en la página.</a></p>


    <br>
    <p>Un saludo, <br>
    Hostelería DAW</p>
</body>
</html>