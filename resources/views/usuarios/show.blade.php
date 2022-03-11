@extends('layouts.app')

@section('styleScripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
@endsection


@section('navActiva')
    @php
    // Si es el admin que está mirando a otro usuario no marcamos como activa la ruta en la navbar
    if(!(Auth::user() && isset($user->id) && Auth::user()->id != $user->id))
        $nav_activa_perfil = true;
    @endphp
@endsection


@section('content')
<div class="container my-1">

    {{-- Datos del usuario --}}
    <div class="card">
        <div class="card-header">
            {{ (Auth::user() && Auth::user()->id == $user->id) ? 'Tus datos' : 'Datos'  }}
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ ucwords(strtolower($user->nombre)) }}</h5>
            <p class="card-text">
                <i class="bi bi-envelope-fill me-1"></i> {{ strtolower($user->email) }} <br>
                <i class="bi bi-telephone-fill me-1"></i> {{ $user->telefono ? $user->telefono : 'Sin registrar' }}
            </p>
            <p class="card-text">
                Registrado el: {{ $user->created_at->format('d-m-Y H:i:s') }} <br>
                @if ($user->rol == \App\Models\Constants::ROL_CLIENTE)
                    Número de pedidos: {{ count($user->pedidos) }} <br>
                    Número de comentarios: {{ count($user->comentarios) }} <br>
                @elseif ($user->rol == \App\Models\Constants::ROL_ADMINISTRADOR)
                    Productos registrados: {{ count($user->productosCreados) }} <br>
                @endif
            </p>
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button class="align-self-start btn btn-outline-danger">Cerrar sesión</button>
            </form>
        </div>
    </div>
    
    @if ($user->rol == \App\Models\Constants::ROL_CLIENTE)
        {{-- Historial de pedidos --}}
        <div class="card my-3">
            <div class="card-header">
                Historial de pedidos
            </div>
            <div class="card-body">
                @if (count($user->pedidos) > 0)
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Ref</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (array_reverse($user->pedidos->sortBy('id')->all()) as $pedido)
                                <tr>
                                    <th scope="row">{{ $pedido->id }}</th>
                                    <td>{{ date('d-m-Y H:i:s', strtotime($pedido->fecha_pedido)) }}</td>
                                    <td>
                                        @switch($pedido->estado)
                                            @case(\App\Models\Constants::ESTADO_ENPROCESO)
                                                En proceso
                                                @break
                                            @default
                                                {{ ucfirst($pedido->estado) }}
                                        @endswitch
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="card-text">
                        Sin pedidos registrados ＞﹏＜
                    </p>
                @endif
            </div>
        </div>
    @elseif ($user->rol == \App\Models\Constants::ROL_ADMINISTRADOR)
        {{-- Lista de usuarios --}}
        <div class="card my-3">
            <div class="card-header">
                Usuarios registrados
            </div>
            <div class="card-body">
                <a href="{{ route('register', ['registrar_usuario' => 'true']) }}" class="btn btn-outline-primary mb-2">Registrar nuevo administrador</a>

                @php
                    $usuarios = \App\Models\User::all();
                @endphp
                @if (count($usuarios) > 0)
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Fecha Registro</th>
                                <th scope="col">Rol</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <th scope="row">{{ ucwords(strtolower($usuario->nombre)) }}</th>
                                    <td>{{ $usuario->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        @switch($usuario->rol)
                                            @case(\App\Models\Constants::ROL_ADMINISTRADOR)
                                                Admin
                                                @break
                                            @default
                                                Cliente
                                        @endswitch
                                    </td>
                                    <td>
                                        @if (Auth::user() && Auth::user()->id != $usuario->id)
                                            <a class="btn btn-primary btn-sm" href="{{ route('usuarios.show', ['id' => $usuario->id]) }}">Ver perfil</a>
                                            <form method="post" action="{{route('usuarios.destroy')}}" style="display:inline-block">
                                                @method('delete')
                                                @csrf
                                                <input type="hidden" name="user_id" value="{{ $usuario->id }}">
                                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="card-text">
                        Sin usuarios registrados ＞﹏＜ 
                        (no debería pasar nunca, es decir, para ver esto tienes que estar loggeado, 
                        por lo que mínimo 1 usuario existe...)
                    </p>
                @endif
            </div>
        </div>
    @endif

</div>
@endsection

@section('scripts')

@endsection