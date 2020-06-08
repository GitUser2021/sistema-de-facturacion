@extends('plantillas.plantilla')

@section('title','Clientes')

@section('main')

<div class="container" id="main">
        <form class="form-inline" action="" method="get">
            <div class="form-group mx-sm-3 mb-2" id="div-barra-busqueda">
                <span><i class="fas fa-search"></i>Buscar Clientes</span>
                <label for="cliente" class="sr-only">cliente</label>
                <input type="text" class="form-control" id="input-cliente" placeholder="Nombre del cliente">
                <button class="btn btn-primary mb-2" id="btn-nuevo-cliente">+ Nuevo Cliente</button>
            </div>
        </form>

    @include('plantillas.mensaje_confirmacion')

    <div class="div-clientes">
    <table class="table" id="tabla-clientes">
            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Email</th>
                <th scope="col">Dirección</th>
                <th scope="col">Estado</th>
                <th scope="col">Agregado</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

</div>
<script type="text/javascript" src="/js/vista_clientes.js"></script>
<script type="text/javascript" src="/js/acciones.js"></script>

@endsection
