let input = document.getElementById('input-cliente-factura')
let tabla = document.getElementById('tabla-factura').children[1]
let pagination = document.getElementById('pagination')
let btn_nueva_factura = document.getElementById('btn-nueva-factura')

btn_nueva_factura.addEventListener('click', e => {
    e.preventDefault()
    window.open('/nueva_factura', '_self')
})

cargar_tabla(facturas.data, clientes, vendedores)

input.addEventListener('keyup', () => {
    // si borro el input y queda en blanco se hace un fetch ?input=all para volver a traer todos los resultados.
    input.value == '' ? fetch_facturas('all') : fetch_facturas(input.value)
})

function fetch_facturas(param) {
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

function obtener_factura(text) {
    page_text = text
    start = page_text.indexOf('let facturas')
    end = page_text.indexOf('//end')
    data = page_text.slice(start, end)
    data = data.slice(16)
    data = JSON.parse(data)
    return data
}

function obtener_paginador(data) {
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

        document.getElementsByClassName('ver')[i].addEventListener('click', e => ver(e, 'factura'))
        document.getElementsByClassName('editar')[i].addEventListener('click', e => editar(e, 'factura'))
        document.getElementsByClassName('eliminar')[i].addEventListener('click', e => eliminar(e, 'factura'))
    }
    input_param !== '' ? input.value = input_param : null
    input_param === 'all' ? input.value = '' : null
    input.focus()
}
