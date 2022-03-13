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
    
    <p>¡Oído cocina!</p>
    <p>Hola {{ ucwords(strtolower($detalles['nombre'])) }}, hemos recibido tu pedido y en breves comenzaremos a prepararlo.</p>

    <br>
    <p><a href="{{ route('pedidos.show', ['id' => $detalles['pedido_id']]) }}">Puedes consultar aquí el estado de tu pedido.</a></p>
    <p>También te notificaremos vía email de las actualizaciones de tu pedido, por si no quieres estar pendiente de la página web.</p>

    <br>
    <p>Un saludo, <br>
    Hostelería DAW</p>
</body>
</html>