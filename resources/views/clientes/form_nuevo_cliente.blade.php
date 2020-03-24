@extends('plantillas.plantilla')

@section('title','Nuevo Cliente')

@section('main')

    @include('plantillas.mensaje_confirmacion')

    <form action="{{ ($editar ?? '') ? '/actualizar_cliente/'.$id:'/agregar_cliente' }}" method="post">
        Nombre: <input type="text" name="nombre" value="{{ $cliente->Nombre ?? '' }}">
        Telefono: <input type="number" name="telefono" value="{{ $cliente->Telefono  ?? '' }}">
        Email: <input type="email" name="email" value="{{ $cliente->Email ?? '' }}">
        <br>
        Direccion: <input type="text" name="direccion" value="{{ $cliente->Direccion ?? '' }}">
        Estado: <select name="estado">
            <option value="activo" {{ ( $cliente->Estado ?? '' ) == 'activo'? 'selected':null }}>activo</option>
            <option value='inactivo' {{ ( $cliente->Estado ?? '' ) == 'inactivo'? 'selected':null }}>inactivo</option>
        </select>
        <input type="submit">
        @csrf
</form>

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
