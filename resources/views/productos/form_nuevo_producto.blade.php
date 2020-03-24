@extends('plantillas.plantilla')

@section('title','Nuevo Producto')

@section('main')

@include('plantillas.mensaje_confirmacion')

<form action="{{ $editar ?? '' ? '/actualizar_producto/'.$id:'/agregar_producto' }}" method="post">
        Codigo: <input type="number" name="codigo" value="{{ $producto->Codigo  ?? '' }}">
        Nombre Producto: <input type="text" name="producto" value="{{ $producto->Producto  ?? '' }}">
        Estado: <select name="estado">
                    <option value="activo" {{ ($producto->Estado ?? '') == 'activo'? 'selected':null }}>activo</option>
                    <option value='inactivo' {{ ($producto->Estado ?? '') == 'inactivo'? 'selected':null }}>inactivo</option>
                </select>
        Precio: <input type="number" name="precio" value="{{ $producto->Precio  ?? '' }}">
        <input type="submit">
        @csrf
</form>
@endsection
