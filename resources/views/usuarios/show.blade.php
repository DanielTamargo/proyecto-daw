@extends('layouts.app')

@section('styleScripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
@endsection

@section('content')
<div class="container my-5">

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
                Número de pedidos: {{ count($user->pedidos) }} <br>
                Número de comentarios: {{ count($user->comentarios) }}
            </p>
            <a href="{{ route('logout.get') }}" class="btn btn-outline-danger">Cerrar sesión</a>
        </div>
    </div>
    
    {{-- Historial de pedidos --}}
    @if ($user->rol == \App\Models\Constants::ROL_CLIENTE)
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
                            @foreach ($user->pedidos as $pedido)
                                <tr>
                                    <th scope="row">{{ $pedido->id }}</th>
                                    <td>{{ $pedido->fecha_pedido }}</td>
                                    <td>{{ $pedido->estado }}</td>
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
    @endif

</div>
@endsection

@section('scripts')

@endsection