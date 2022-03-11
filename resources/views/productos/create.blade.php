@extends('layouts.app')

@section('styleScripts')
<style>
    .formulario-producto form {
        width: 100%;
        display: block;
    }
</style>
@endsection


@section('content')
<div class="container my-4">
    <div class="formulario-producto">
        <form method="POST" enctype="multipart/form-data"
            @if(isset($producto))
                action="{{ route('productos.update') }}"
            @else
                action="{{ route('productos.store') }}"
            @endif
            >

            @csrf
            <h3>{{ isset($producto) ? 'Editar producto' : 'Nuevo producto'}}</h3>
            @if(isset($producto))
                @method('PUT')
                <input type="hidden" name="producto_id" value="{{ $producto->id }}">
            @endif
            <div class="form-group my-3">
                <label for="foto">Imagen</label><br>
                <input type="file" class="form-control-file" id="foto" name="foto" aria-describedby="fotoHelp" accept="image/.jpg,.jpg,.jpeg,.png,.gif,.jfif" 
                        {{ isset($producto) ? '' : 'required' }}>
                @if(isset($producto))
                    <br><small id="fotoHelp" class="form-text text-muted">Añade una imagen para sobreescribir la existente</small>
                @endif
            </div>
            <div class="form-group my-3">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombe" name="nombre" placeholder="Un nombre llamativo" required
                        value={{ isset($producto) ? $producto->nombre : '' }}>
            </div>
            <div class="form-group my-3">
                <label for="descripcion">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Ingredientes, sabores, cómo se prepara" required
                        value={{ isset($producto) ? $producto->descripcion : '' }}>
            </div>
            <div class="form-group my-3">
                <label for="precio">Precio</label>
                <input type="number" class="form-control" id="precio" name="precio" placeholder="Precio asequible" step="0.01" pat="true" required
                        value={{ isset($producto) ? $producto->precio : '' }}>
            </div>
            <button type="submit" class="btn btn-primary my-3">{{ isset($producto) ? 'Editar' : 'Registrar producto'}}</button>
        </form>
    </div>
</div>
@endsection


@section('scripts')
<script src="{{ asset('js/lib/jquery-3.6.0.min.js') }}"></script>
<script>
    $(document).on('keydown', 'input[pat]', function(e){
        var input = $(this);
        var oldVal = input.val();
        var regex = new RegExp(/^\d*(\.\d{0,2})?$/, 'g');

        setTimeout(function(){
            var newVal = input.val();
            if(!regex.test(newVal)){
            input.val(oldVal); 
            }
        }, 1);
    });
</script>
@endsection