@extends('layouts.app')

@section('styleScripts')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
@endsection


@section('navActiva')
    @php
        $nav_activa_pedidos = true;
    @endphp
@endsection


@section('content')
    <div class="contenedor">
        <p class="display-4">Error 403, acceso denegado</p>
        <p class="display-1"><i class="bi bi-emoji-frown text-primary"></i></p>
        <a href="{{ url()->previous() }}" class="btn btn-primary fs-2"><i class="bi bi-caret-left-fill"></i> Volver</a>
    </div>
@endsection


@section('scripts')

@endsection