@extends('plantillas.plantilla')

@section('title','Nuevo Cliente')

@section('main')

    @include('plantillas.mensaje_confirmacion')
    <div class="container main-agregar-cliente">
        <h1 class="titulo-agregar-cliente">Agregar Nuevo Cliente</h1>
        <div class="div-form-agregar-cliente container">
            <form id="form-agregar-cliente" class="container"
                  action="{{ ($editar ?? '') ? '/actualizar_cliente/'.$id:'/agregar_cliente' }}" method="post">
                <div class="form-1 container">
                    Nombre: <input type="text" name="nombre" value="{!! old('nombre'), $cliente->Nombre ?? '' !!}">
                    Telefono: <input type="number" name="telefono" value="{!! old('telefono'), $cliente->Telefono  ?? '' !!}">
                    Email: <input type="email" name="email" value="{!! old('email'),$cliente->Email ?? '' !!}">
                </div>
                <div class="form-2 container">
                    Direccion: <input type="text" name="direccion" value="{!! old('direccion'),$cliente->Direccion ?? '' !!}">
                    Estado: <select name="estado">
                        <option value="activo" {{ ( $cliente->Estado ?? '' ) == 'activo'? 'selected':null }}>activo
                        </option>
                        <option value='inactivo' {{ ( $cliente->Estado ?? '' ) == 'inactivo'? 'selected':null }}>
                            inactivo
                        </option>
                    </select>
                    <input type="submit" value="Enviar">
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
