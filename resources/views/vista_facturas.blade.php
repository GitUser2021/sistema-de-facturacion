@extends('plantilla')

@section('title','Facturas')


@section('main')
    <div class="div-1">
        <div class="header">
            <span><i class="fas fa-search"></i>Buscar Facturas</span>
            <form action="nueva_factura" method="post" class="form-add">
                <button class="btn btn-primary mb-2 btn-add">+ Nueva Factura</button>
                @csrf
            </form>
        </div>


        <form class="form-inline" method="get" action="lista_facturas" id="form-fac-cli">
            <div class="form-group mx-sm-3 mb-2">
                <label for="factura" class="sr-only">Cliente o # de factura</label>
                <input type="text" class="form-control" id="input-factura" name="input"
                       placeholder="Cliente o # de factura">
            </div>
        </form>

        <table class="table" id="tabla-factura">
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

        <div id="pagination"> {{$facturas->appends( ['input' => $_SESSION['param'] ])->links()}} </div>

    </div>
    <form action="ver_factura" method="post" id="form-ver-factura" target="_blank">
        <input type="hidden" name="datos">
         @csrf
    </form>

    <script type="text/javascript" src="js/pdf_factura.js"></script>
    <script>

        @php echo 'let facturas = ' @endphp {!! json_encode($facturas) !!}//end
        @php echo 'let clientes = ' @endphp {!! $_SESSION['clientes'] !!} ;
        @php echo 'let vendedores = ' @endphp {!! $_SESSION['vendedores'] !!};

        let input_param = '{{ $_SESSION['param'] }}'
        let input = document.getElementById('input-factura')
        let tabla = document.getElementById('tabla-factura').children[1]
        let pagination = document.getElementById('pagination')

        cargar_tabla( facturas.data , clientes, vendedores)

        input.addEventListener('keyup', () => {
            // si borro el input y queda en blanco se hace un fetch ?f=all para volver a traer todos los resultados.
            input.value == ''? fetch_facturas('all'):fetch_facturas(input.value)
        })

            function fetch_facturas(param){
                let page = `lista_facturas?input=${param}`
                history.pushState(page, 'title', page)
                input_param = param
                fetch(`lista_facturas?input=${param}`)
                    .then(res => res.text())
                    .then(text => {
                        data = obtener_factura(text)
                        obtener_paginador(data)
                        tabla.innerHTML = null // limpio la tabla antes de cargar los nuevos datos
                        cargar_tabla(data.data, clientes, vendedores)
                    })
            }
            function obtener_factura(text){
                page_text = text
                start = page_text.indexOf('let facturas')
                end = page_text.indexOf('//end')
                data = page_text.slice(start, end)
                data = data.slice(16)
                data = JSON.parse(data)
                return data
            }
            function obtener_paginador(data){
                start = page_text.indexOf('<nav>')
                end = page_text.indexOf('</nav>', start)
                nav = page_text.slice(start, end)
                data.last_page > 1 ? pagination.innerHTML = nav : pagination.innerHTML = null // solo inserto la paginacion si hay mas de 1 pagina.
            }
            function cargar_tabla(data, clientes, vendedores) {
            for (let i = 0; i < data.length; i++) {
                let row = document.createElement('tr')
                tabla.appendChild(row)
                for (key in data[i]) {
                    let col = document.createElement('td')
                    switch (key) {
                        case 'id_cliente':
                            id_cliente = data[i][key]
                            for (key in clientes) {
                                if (clientes[key].id_cliente == id_cliente) {
                                    nombre_cliente = clientes[key].Nombre
                                    break
                                }
                            }
                            textNode = document.createTextNode(data[i][key])
                            col.appendChild(textNode)
                            row.appendChild(col)
                            tabla.children[i].children[2].innerText = nombre_cliente
                            break;

                        case 'id_vendedor':
                            id_vendedor = data[i][key]
                            for (key in vendedores) {
                                if (vendedores[key].id_vendedor == id_vendedor) {
                                    nombre_vendedor = vendedores[key].Nombre
                                    break
                                }
                            }
                            textNode = document.createTextNode(data[i][key])
                            col.appendChild(textNode)
                            row.appendChild(col)
                            tabla.children[i].children[3].innerText = nombre_vendedor
                            break;

                        default:
                            textNode = document.createTextNode(data[i][key])
                            col.appendChild(textNode)
                            row.appendChild(col)
                            break;
                    }
                }
                col = document.createElement('td')
                row.appendChild(col)
                tabla.children[i].children[6].innerHTML = `<button class="btn btn-primary btn-sm ml-1 ver ${data[i]['id_factura']} ">Ver</button><button class="btn btn-warning btn-sm ml-1 editar ${data[i]['id_factura']}">Editar</button><button class="btn btn-danger btn-sm ml-1 eliminar ${data[i]['id_factura']}">Eliminar</button>`

                document.getElementsByClassName('ver')[i].addEventListener('click', e => ver(e))
                document.getElementsByClassName('editar')[i].addEventListener('click', e => editar(e))
                document.getElementsByClassName('eliminar')[i].addEventListener('click', e => eliminar(e))
            }
            input_param !== '' ? input.value = input_param : null
            input_param === 'all' ? input.value = '' : null
            input.focus()
        }
            function eliminar(e) {
                id = e.target.classList[5]
                console.log(id)
                e.target.parentElement.parentElement.remove() // elimino el <tr>
                fetch(`eliminar_factura/${id}`)
            }
            function editar(e) {
                id = e.target.classList[5]
                console.log(id)
                fetch(`editar_factura/${id}`)
            }
            function ver(e) {
                id = e.target.classList[5]
                console.log(id)
                crear_pdf_factura(id)
            }

    </script>

@endsection
