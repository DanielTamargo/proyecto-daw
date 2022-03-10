@extends('layouts.app')

@section('content')
    <div class="mt-5 px-5">
        {{ Auth::user()->compraVerificada(46) > 0 ? 'Si' : 'No' }}
    </div>
@endsection