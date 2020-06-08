let btn_nuevo_producto = document.getElementById('btn-nuevo-producto')
let input_producto = document.getElementById('input-producto')
let tabla = document.getElementById('tabla-productos').children[1]
input_producto.addEventListener('keypress', cargar_tabla)
let pagination = document.getElementById('pagination')

btn_nuevo_producto.addEventListener('click', e => {
    e.preventDefault()
    window.open('/nuevo_producto', '_self')
})


cargar_tabla(productos.data)

input_producto.addEventListener('keyup', () => {
    // si borro el input y queda en blanco se hace un fetch ?input=all para volver a traer todos los resultados.
    input_producto.value == '' ? fetch_productos('all') : fetch_productos(input_producto.value)
})

function fetch_productos(param) {
    let page = `lista_productos?input=${param}`
    history.pushState(page, 'title', page)
    input_param = param
    fetch(`lista_productos?input=${param}`)
        .then(res => res.text())
        .then(text => {
            data = obtener_producto(text)
            obtener_paginador(data)
            tabla.innerHTML = null // limpio la tabla antes de cargar los nuevos datos
            cargar_tabla(data.data)
        })
}

function obtener_producto(text) {
    page_text = text
    start = page_text.indexOf('let productos')
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
        col = document.createElement('td')
        row.appendChild(col)
        tabla.children[i].children[6].innerHTML = `
<!--        <button class="btn btn-primary btn-sm ml-1 ver ${data[i]['Codigo']} ">Ver</button>-->
        <button class="btn btn-warning btn-sm ml-1 editar ${data[i]['Codigo']}">Editar</button>
        <button class="btn btn-danger btn-sm ml-1 eliminar ${data[i]['Codigo']}">Eliminar</button>`

        // document.getElementsByClassName('ver')[i].addEventListener('click', e => ver(e,'producto'))
        document.getElementsByClassName('editar')[i].addEventListener('click', e => editar(e, 'producto'))
        document.getElementsByClassName('eliminar')[i].addEventListener('click', e => eliminar(e, 'producto'))
    }
    input_param !== '' ? input_producto.value = input_param : null
    input_param === 'all' ? input_producto.value = '' : null
    input_producto.focus()
}

