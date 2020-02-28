@extends('plantilla')

@section('title','Clientes')
@section('main')
    <div class="div-clientes">
        <div class = "header">
            <span><i class="fas fa-search"></i>Buscar Clientes</span>
            <form action="nuevo_cliente" method="post" class="form-add">
                <button class="btn btn-primary mb-2">+ Nuevo Cliente</button>
                @csrf
            </form>
        </div>

        <form class="form-inline" action="" method="post">
            <div class="form-group mx-sm-3 mb-2">
                <label for="cliente" class="sr-only">cliente</label>
                <input type="text" class="form-control" id="cliente" placeholder="Nombre del cliente">
            </div>
        </form>

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



<script>
    let input = document.getElementById('cliente')
    let tabla = document.getElementById('tabla-clientes').children[1]
    input.addEventListener('keypress',cargar_tabla)

    fetch('lista_clientes?name=all')
        .then(res=>res.json())
        .then(data=>cargar_tabla(data))

    input.addEventListener('keyup', () => {
        // si borro el input y queda en blanco se hace un fetch ?name=all para volver a traer todos los resultados.
        input.value == ''? my_fetch('all'):my_fetch(input.value)
    })

    function my_fetch(param) {
        fetch(`lista_clientes?name=${param}`)
            .then(res => res.json())
            .then(data => {
                tabla.innerHTML = null // limpio la tabla antes de cargar los nuevos datos
                cargar_tabla(data)
            })
    }

    function cargar_tabla(data) {
        for(let i = 0 ; i < data.length;i++){
            let row = document.createElement('tr')
            for ( key in data[i]) {
                let col = document.createElement('td')
                let textNode = document.createTextNode(data[i][key])
                col.appendChild(textNode)
                row.appendChild(col)
            }
            tabla.appendChild(row)
        }
    }
</script>
@endsection
