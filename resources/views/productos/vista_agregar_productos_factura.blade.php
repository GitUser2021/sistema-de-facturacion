@include('plantillas.head')

@section('title','Productos')
    <div class="div-2">
        <form class="form-inline" id="form-1">
            <div class="form-group mx-sm-3 mb-2">
                <label for="producto" class="sr-only">Cliente o # de factura</label>
                <input type="text" class="form-control" id="producto" placeholder="Código o nombre del producto">
            </div>
            <button type="submit" class="btn btn-primary mb-2">BUSCAR</button>
        </form>

        <table class="table">
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
                    <td>{{$producto->Codigo}}</td>
                    <td>{{$producto->Producto}}</td>
                    <td>{{$producto->Precio}}</td>
                    <td>
                        <form action="" method="post" id="form-{{$key + 1}}">
                            <input type="number" class="form-input" name="cant">
                            <input type="hidden" name="cod" value="{{$producto->Codigo}}">
                            @csrf
                        </form>
                    </td>
                    <td>
                        <input type="submit" value = "Agregar" class="form-btn" form="form-{{$key + 1}}">
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>


</script>

@include('plantillas.footer')
