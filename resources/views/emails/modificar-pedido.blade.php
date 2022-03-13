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
    
    <p>Hola {{ ucwords(strtolower($detalles['nombre'])) }}</p>
    @switch($detalles['estado'])
        @case(App\Models\Constants::ESTADO_CANCELADO)
            <p>Lamentablemente hemos tenido qeu cancelar su pedido. Disculpe las molestias</p>
            @break
        @case(App\Models\Constants::ESTADO_ENPROCESO)
            <p>Ya hemos comenzado a prepara su pedido, ¡en seguida estará listo!</p>
            @break
        @case(App\Models\Constants::ESTADO_LISTO)
            <p>¡Pedido listo! Pásate a recogerlo cuando quieras.</p>
            @break
        @case(App\Models\Constants::ESTADO_ENTREGADO)
            <p>Pedido recogido, ¡que aproveche!</p>
            @break      
    @endswitch

    <br>
    <p><a href="{{ route('pedidos.show', ['id' => $detalles['pedido_id']]) }}">Puedes consultar aquí el estado de tu pedido.</a></p>

    <br>
    <p>Un saludo, <br>
    Hostelería DAW</p>
</body>
</html>