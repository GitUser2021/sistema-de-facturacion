@include('plantillas.head')
@section('title','Factura Detallada')

<form action="agregar_factura" method="post">
    Cliente:
    <select name="cliente" id="">
        <option value="1">fede</option>
        <option value="1">flor</option>
        <option value="2">mony</option>
        <option value="3">hugo</option>
    </select>
    Vendedor:
    <select name="vendedor" id="">
        <option value="1">gasty</option>
        <option value="2">gaston</option>
        <option value="3">vazquez</option>
    </select>
    Medio de pago:
    <select name="pago" id="">
        <option value="1">Efectivo</option>
        <option value="2">Tarjeta</option>
        <option value="3">Transferencia</option>
    </select>
    @csrf
</form>

        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Producto</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Precio</th>
                <th scope="col">Agregar</th>
            </tr>
            </thead>
            <tbody>
{{--            @foreach($facturas as $factura)--}}
                <tr>
                    <th scope="row"></th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
{{--            @endforeach--}}
            </tbody>
        </table>

@include('plantillas.footer')
