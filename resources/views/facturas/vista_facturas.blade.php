@extends('plantillas.plantilla')

@section('title','Facturas')

@section('main')

    <div class="container" id="main">
        <form class="form-inline" method="get" action="lista_facturas" id="form-lista-facturas">
            <div class="form-group mx-sm-3 mb-2" id="div-barra-busqueda">
                <span><i class="fas fa-search"></i>Buscar Facturas</span>
                <label for="factura" class="sr-only">Cliente o # de factura</label>
                <input type="text" class="form-control" id="input-cliente-factura" name="input"
                       placeholder="Cliente o # de factura">
                <button class="btn btn-primary mb-2 " id="btn-nueva-factura">+ Nueva Factura</button>
            </div>
        </form>

        @include('plantillas.mensaje_confirmacion')
        <div class="div-facturas">
        <table class="table tabla-facturas" id="tabla-factura">
            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Fecha</th>
                <th scope="col">Cliente</th>
                <th scope="col">Vendedor</th>
                <th scope="col">Total</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>

        <div id="pagination"> {{$facturas->appends( ['input' => $_SESSION['param'] ])->links()}} </div>

    </div>
    <form action="ver_factura" method="post" id="form-ver-factura" target="_blank">
        <input type="hidden" name="datos">
        @csrf
    </form>


    <script type="text/javascript" src="/js/pdf_factura.js"></script>
    <script>
        @php echo 'let facturas = ' @endphp {!! json_encode($facturas) !!}//end
        @php echo 'let clientes = ' @endphp {!! $_SESSION['clientes'] !!} ;
        @php echo 'let vendedores = ' @endphp {!! $_SESSION['vendedores'] !!};
        let input_param = '{{ $_SESSION['param'] }}'
    </script>
    <script type="text/javascript" src="/js/vista_facturas.js"></script>
    <script type="text/javascript" src="/js/acciones.js"></script>

@endsection
