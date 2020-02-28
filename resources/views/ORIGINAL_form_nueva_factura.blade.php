@include('head')
@section('title','Nueva facturaaa')
<div class="container div-nueva-factura">
    <div class="container form-container">
            <form action="agregar_factura" method="post" class="form form-control">
                    Cliente:
                    <select name="cliente" id="cliente" >
                        @foreach($clientes as $cliente)
                            <option value="{{$cliente->id_cliente}}">{{$cliente->Nombre}}</option>
                        @endforeach
                    </select>

                Vendedor:
                <select id="vendedor">
                    @foreach($vendedores as $vendedor)
                        <option value="{{$vendedor->id_vendedor}}">{{$vendedor->nombre}}</option>
                    @endforeach
                </select>

                Medio de pago:
                <select id="medio_de_pago">
                    <option value="1">Efectivo</option>
                    <option value="2">Tarjeta</option>
                    <option value="3">Transferencia</option>
                </select>
                @csrf
            </form>

        <div class="tabla-factura">
                <table class="table" id="tabla-factura">
                    <tr>
                        <td>CODIGO</td>
                        <td>CANTIDAD</td>
                        <td>DESCRIPCION</td>
                        <td>PRECIO UNIT.</td>
                        <td s>TOTAL</td>
                    </tr>
                </table>
        </div>
    </div>


    <div class="nueva-factura-productos">

        <div class="btn btn-buscar container-fluid">
            <div class="dis-block my-modal ">
                <div class="div-factura">
                    <form class="form-inline">
                        <label for="producto" class="sr-only">Cliente o # de factura</label>
                        <input type="text" class="form-control nueva-factura-input" id="producto" placeholder="Código o nombre del producto">
                        <button type="submit" class="btn btn-primary">BUSCAR</button>
                    </form>
                </div>
            </div>
        </div>

        <table class="table table-nueva-factura">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Código</th>
                <th scope="col">Producto</th>
                <th scope="col">Precio</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Acciones</th>
            </tr>
            </thead>
            <tbody>

            @foreach($productos as  $key => $producto)
                <tr>
                    <th scope="row">{{$key + 1}}</th>
                    <td id="codigo-{{$key + 1}}">{{$producto->Codigo}}</td>
                    <td id="producto-{{$key + 1}}">{{$producto->Producto}}</td>
                    <td id="precio-{{$key + 1}}">{{$producto->Precio}}</td>
                    <td><input type="number" class="input-nueva-factura" id="input-{{$key + 1}}"></td>
                    <td>
                        <button class="btn-nueva-factura" id="{{$key + 1}}">Agregar</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    let btn = document.getElementById('link_agregar_producto_factura')

    let cliente = document.getElementById('cliente').value
    let vendedor = document.getElementById('vendedor').value
    let agregar = document.querySelectorAll('button')
    let items = []
    let precio_total

    // ref a la tabla de factura
    let tabla_factura = document.getElementById('tabla-factura').children[0]
    let row_codigo = document.getElementById('td-codigo')
    let row_cantidad = document.getElementById('td-cantidad')
    let row_descripcion = document.getElementById('td-descripcion')
    let row_precio_unitario = document.getElementById('td-precio_unitario')
    let row_total = document.getElementById('td-total')

    let index = 0

    function cargar_factura(items){
        let row = document.createElement('tr')

            for(key in items[index]){
                td = document.createElement('td')
                row.appendChild(td)
                textNode = document.createTextNode(items[index][key])
                td.appendChild(textNode)
                tabla_factura.appendChild(row)
            }
        index++
    }



    for (let i = 0; i < agregar.length; i++) {
        agregar[i].addEventListener('click', (e) => {
            items.push({
                    codigo: document.getElementById('codigo-' + e.target.id).innerText,
                    cantidad: document.getElementById('input-' + e.target.id).value,
                    producto: document.getElementById('producto-' + e.target.id).innerText,
                    precio: document.getElementById('precio-' + e.target.id).innerText,
                    total:  parseFloat(document.getElementById('precio-' + e.target.id).innerText) * document.getElementById('input-' + e.target.id).value
                })
            cargar_factura(items)
        })
    }


    function Factura (){
        // this.id_factura
        // this.fecha
        this.id_cliente
        this.id_vendedor
        this.cantidad_productos
        this.codigo
        this.producto
        this.precio_unitario
        this.precio_total
        // this.estado
        this.total_venta
    }
    let factura
    function crear_factura(){
        factura = new Factura()

        factura.codigo = codigo
        factura.producto = producto
        factura.precio_unitario = precio_unitario
        factura.precio_total = precio_total
        factura.cantidad_productos = cantidad
        factura.id_cliente = cliente
        factura.id_vendedor = vendedor
    }


</script>

@include('footer')
