@extends('plantillas.plantilla')

@section('title','Nuevo Producto')

@section('main')

    @include('plantillas.mensaje_confirmacion')
    <div class="container main-agregar-producto">
        <h1 class="titulo-agregar-producto">Agregar Nuevo Producto</h1>
        <div class="div-form-agregar-producto container">
            <form id="form-agregar-producto" class="container"
                  action="{{ $editar ?? '' ? '/actualizar_producto/'.$id:'/agregar_producto' }}" method="post">
                <div class="form-1 container">
                    Codigo: <input type="number" name="codigo" value="{{ old('codigo'), $producto->Codigo ?? '' }}" class="input-codigo">
                    Nombre Producto: <input type="text" name="producto" value="{{ old('producto'), $producto->Producto  ?? '' }}" class="input-nombre-producto">
                </div>
                <div class="form-2 container">
                    Estado: <select name="estado">
                        <option value="activo" {{ ($producto->Estado ?? '') == 'activo'? 'selected':null }}>activo
                        </option>
                        <option value='inactivo' {{ ($producto->Estado ?? '') == 'inactivo'? 'selected':null }}>inactivo
                        </option>
                    </select>
                    Precio: <input type="number" name="precio" value="{{ old('precio'), $producto->Precio  ?? '' }}" class="input-precio">
                    <input type="submit" value="Enviar" class="input-enviar">
                </div>
                @csrf
            </form>
        </div>
    </div>
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection
