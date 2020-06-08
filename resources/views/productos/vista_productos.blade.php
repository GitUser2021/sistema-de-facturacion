@extends('plantillas.plantilla')

@section('title','Productos')

@section('main')

<div class="container" id="main">
    <form class="form-inline" action="" method="get" id="form-buscar-producto">
        <div class="form-group mx-sm-3 mb-2" id="div-barra-busqueda">
            <span><i class="fas fa-search"> </i>Buscar Productos</span>
            <label for="producto" class="sr-only">Cliente o # de factura</label>
            <input type="text" class="form-control" id="input-producto" name="p"
                placeholder="Código o nombre del producto">
            <button class="btn btn-primary mb-2" id="btn-nuevo-producto">+ Nuevo Producto</button>
        </div>
    </form>
    @include('plantillas.mensaje_confirmacion')
    <div class="div-productos">
        <table class="table" id="tabla-productos">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Código</th>
                <th scope="col">Producto</th>
                <th scope="col">Estado</th>
                <th scope="col">Agregado</th>
                <th scope="col">Precio</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <div id="pagination" class = "container"> {{$productos->appends( ['input' => $_SESSION['param'] ])->links()}}
    </div>
</div>

<script>
    @php echo 'let productos = ' @endphp {!! json_encode($productos ) !!}//end
    let input_param = '{{ $_SESSION['param'] }}'
</script>
<script type="text/javascript" src="/js/vista_productos.js"></script>
<script type="text/javascript" src="/js/acciones.js"></script>

@endsection
