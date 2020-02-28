@include('head')
@php
    if( !isset($cliente) ){
          $cliente = new stdClass();
          $cliente->Nombre = '';
          $cliente->id_cliente = '';
    }
@endphp

{{-------------------------------------------------------------- LEFT SIDE ----------------------------------------------------------------}}

{{-------------------------------------------------------------- TOP SIDE ----------------------------------------------------------------}}
<div class="nueva-factura-left">

    <div class="nueva-factura-top">
        <h1>NUEVA FACTURA</h1>

        <div class="nueva-factura-opciones">
            <div class="nueva-factura-opciones-left">
                <form class="form-inline  ml-auto mr-auto" action="buscar_cliente" method="post">
                    <div class="form-group">
                        <input type="text" id="cliente" name="cliente" placeholder="Buscar cliente"
                               class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary mt-1">BUSCAR</button>
                    @csrf
                </form>
                <button class="btn btn-primary mt-auto" form="form-factura" id="btn-guardar-factura" disabled>GUARDAR FACTURA</button>
            </div>

            <div class="nueva-factura-opciones-right">
                <form action="agregar_factura" id="form-factura" method="post" class="form-inline">
                    <input type="text" id="cliente-encontrado" class="form-control" value="{{$cliente->Nombre}}"
                           disabled>
                    <input type="hidden" name="id_cliente" value="{{$cliente->id_cliente}}">
                   <input type="hidden" name="total_factura" id="total-factura">
                    <input type="hidden" name="carrito" id="carrito">
                    <div class="form-group ml-auto mr-auto">
                        <label for="vendedor" class="mr-2"> Vendedor:</label>
                        <select id="vendedor" class="form-control w-auto" name="vende">
                            @foreach($vendedores as $vendedor)
                                <option value="{{$vendedor->id_vendedor}}">{{$vendedor->Nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group ml-auto mr-auto">
                        <label for="medio_de_pago" class="mr-1">Medio de pago:</label>

                        <select id="medio_de_pago" class="form-control w-auto">
                            <option value="1">Efectivo</option>
                            <option value="2">Tarjeta</option>
                            <option value="3">Transferencia</option>
                        </select>
                    </div>
                    @csrf
                </form>
                <button class="btn btn-primary" form="imprimir" id="btn-imprimir" disabled>IMPRIMIR</button>
            </div>
        </div>
    </div>    <form action="imprimir" method="post" id="imprimir" target="_blank">
        @csrf
        <input type="hidden" id="imprimir-factura" name="imprimir_factura">
    </form>
    {{-------------------------------------------------------------- BOTTOM SIDE ----------------------------------------------------------------}}
    <div class="nueva-factura-bottom">
        <table id="tabla-factura" class="table mt-4">
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


{{--------------------------------------------------------------- RIGHT SIDE ----------------------------------------------------------------}}
<div class="nueva-factura-right">
    <H1>PRODUCTOS</H1>
    <div class="nueva-factura-buscar-right">
        <form class="form-inline">
            <div class="form-group ml-auto mr-auto">
                <input type="text" placeholder="Nombre o Codigo del producto" class="form-control" id="input-productos">
            </div>
        </form>
    </div>

    <div class="nueva-factura-tabla-productos table-responsive">
        <table class="table mt-3 " id="tabla-productos">
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

<form action="ver_factura" method="post" id="form-ver-factura" target="_blank">
    <input type="hidden" name="datos">
    @csrf
</form>

<script type="text/javascript">
    @php echo 'let vendedores = '@endphp {!! $vendedores !!}
    @php echo 'let cliente_nombre = '@endphp '{{ $cliente->Nombre }}'
</script>
<script type="text/javascript" src="js/pdf_factura.js"></script>
<script type="text/javascript" src="js/nueva_factura.js"></script>

@include('footer')
