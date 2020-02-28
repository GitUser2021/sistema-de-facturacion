@extends('plantilla')
@section('title','Productos')
@section('main')
    <div class="div-1">
        <div class="header">
            <span><i class="fas fa-search"></i>Buscar Productos</span>
            <form action="nuevo_producto" class="form-add" method="post">
                <button class="btn btn-primary mb-2 btn-add">+ Nuevo Producto</button>
                @csrf
            </form>
        </div>

        <form class="form-inline" action="" method="get" id="form-find-producto">
            <div class="form-group mx-sm-3 mb-2">
                <label for="producto" class="sr-only">Cliente o # de factura</label>
                <input type="text" class="form-control" id="producto" name="p"
                       placeholder="Código o nombre del producto">
            </div>
        </form>

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

    <script>
        let input = document.getElementById('producto')
        let tabla = document.getElementById('tabla-productos').children[1]
        input.addEventListener('keypress', cargar_tabla)

        fetch('lista_productos?p=all')
            .then(res => res.json())
            .then(data => cargar_tabla(data))

        input.addEventListener('keyup', () => {
        // si borro el input y queda en blanco se hace un fetch ?p=all para volver a traer todos los resultados.
            input.value == ''? fetch_productos('all'):fetch_productos(input.value)
        })

    function fetch_productos(param){
        if ( isNaN(param) || param == 'all' ) {
            fetch(`lista_productos?p=${param}`)
                .then(res => res.json())
                .then(data => {
                    tabla.innerHTML = null // limpio la tabla antes de cargar los nuevos datos
                    cargar_tabla(data)
                })
        }
        else{
            fetch(`lista_productos?codigo=${param}`)
                .then(res => res.json())
                .then(data => {
                    tabla.innerHTML = null // limpio la tabla antes de cargar los nuevos datos
                    cargar_tabla(data)
                })
        }
    }

        function cargar_tabla(data) {
            let row, col, textNode
            for (let i = 0; i < data.length; i++) {
                row = document.createElement('tr')
                col = document.createElement('td')
                textNode = document.createTextNode(i)
                col.appendChild(textNode)
                row.appendChild(col)
                tabla.appendChild(row)
                for (key in data[i]) {
                    col = document.createElement('td')
                    textNode = document.createTextNode(data[i][key])
                    col.appendChild(textNode)
                    row.appendChild(col)
                }
            }
        }
    </script>
@endsection
