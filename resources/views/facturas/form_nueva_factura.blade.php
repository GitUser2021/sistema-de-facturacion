@extends('plantillas.plantilla')

@section('title','Nueva Factura')

@section('main')
    @php
        if( !isset($cliente) ){
              $cliente = new stdClass();
              $cliente->Nombre = '';
              $cliente->id_cliente = '';
        }

    $id = $id ?? '' ;
    @endphp

    <div class="container-fluid" id="nueva-factura-main">
        <div class="nueva-factura-left">
            <div class="container div-left">
                <h1>{{ $titulo }} FACTURA @if (isset($id)) {{ 'N°'.$id }} @endif </h1>
                <form class="form-inline ml-auto mr-auto" action="" method="post">
                    <div class="form-group">
                        <input type="text" id="cliente" name="cliente" placeholder="Buscar cliente"
                               class="form-control">
                        <input type="hidden" name="titulo" value="{{$titulo}}">
                        <input type="hidden" name="id" value="{{$id}}">
                    </div>
                    <button type="submit" class="btn btn-primary mt-1" id="btn-buscar-cliente">BUSCAR</button>
                    @csrf
                </form>

                <form action="{{ $titulo == 'EDITAR'? '/actualizar_factura/'.$id:'/agregar_factura' }}"
                      id="form-factura" method="post" class="form-inline">
                    <input type="text" id="cliente-encontrado" class="form-control"
                           value="Cliente: {{$cliente->Nombre}}"
                           disabled>
                    <button class="btn btn-primary mt-auto" form="form-factura" id="btn-guardar-factura" disabled>
                        GUARDAR
                        FACTURA
                    </button>
                    <input type="hidden" name="id_cliente" id="id-cliente" value="{{$cliente->id_cliente}}">
                    <input type="hidden" name="total_factura" id="total-factura">
                    <input type="hidden" name="carrito" id="carrito">
                    <div class="div-form-vendedor">
                        <div class="form-group ml-auto mr-auto vendedor">
                            <label for="vendedor" class="mr-2"> Vendedor:</label>
                            <select id="vendedor" class="form-control w-auto vendedor-select" name="vende" required>
                                <option value="">Seleccione un vendedor</option>
                                @foreach($vendedores as $vendedor)
                                    <option value="{{$vendedor->id_vendedor}}">{{$vendedor->Nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ml-auto mr-auto medio-de-pago">
                            <label for="medio_de_pago" class="mr-1">Medio de pago:</label>
                            <select id="medio_de_pago" class="form-control w-auto medio-de-pago-select">
                                <option value="1">Efectivo</option>
                                <option value="2">Tarjeta</option>
                                <option value="3">Transferencia</option>
                            </select>
                        </div>
                        <button class="btn btn-primary" form="ver-factura" id="btn-ver-factura" disabled>VER FACTURA
                        </button>
                    </div>
                    @csrf
                </form>
            </div>
            <div class="div-tabla table-responsive">
                <table id="tabla-factura" class="table mt-4 tabla-factura ">
                    <thead>
                    <tr>
                        <th>CODIGO</th>
                        <th>CANTIDAD</th>
                        <th>DESCRIPCION</th>
                        <th>PRECIO UNIT.</th>
                        <th>TOTAL</th>
                        <th>ACCIONES</th>
                    </tr>
                    </thead>
                    <tbody id="tbody-factura">
                    </tbody>
                </table>
            </div>
        </div>

        <div class="div-right">
            <div class="div-form-right">
                <div class="nueva-factura-right">
                    <H1>PRODUCTOS</H1>
                    <div class="nueva-factura-buscar-right">
                        <form class="form-inline">
                            <div class="form-group ml-auto mr-auto">
                                <input type="text" placeholder="Nombre o Codigo del producto" class="form-control"
                                       id="input-productos">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="nueva-factura-tabla-productos table-responsive">
                <table class="table mt-3" id="tabla-productos">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Código</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <form action="/ver_factura" method="post" id="form-ver-factura" target="_blank">
        <input type="hidden" name="datos">
        @csrf
    </form>

    <script type="text/javascript">
        @php echo 'let productos = '@endphp {!! $productos !!};
        @php echo 'let vendedores = '@endphp {!! $vendedores !!};
        @php echo 'let cliente_nombre = '@endphp '{{ $cliente->Nombre }}';
        @php echo 'cliente = '@endphp '{{ $cliente->id_cliente }}';
        @php echo 'let vendedor = '@endphp '{!! $vendedor_->id_vendedor ?? '' !!}';
        @php echo 'let carrito = '@endphp {!! $carrito ?? '[]' !!}
    </script>
    <script type="text/javascript" src="/js/pdf_factura.js"></script>
    <script type="text/javascript" src="/js/nueva_factura.js"></script>
@endsection
