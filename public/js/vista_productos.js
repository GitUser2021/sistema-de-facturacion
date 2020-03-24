let btn_nuevo_producto = document.getElementById('btn-nuevo-producto')
let input_producto = document.getElementById('input-producto')
let tabla = document.getElementById('tabla-productos').children[1]
input_producto.addEventListener('keypress', cargar_tabla)



btn_nuevo_producto.addEventListener('click',e=>{
    e.preventDefault()
    window.open('/nuevo_producto','_self')
})



fetch('lista_productos?p=all')
    .then(res => res.json())
    .then(data => cargar_tabla(data))

input_producto.addEventListener('keyup', () => {
    // si borro el input y queda en blanco se hace un fetch ?p=all para volver a traer todos los resultados.
    input_producto.value == ''? fetch_productos('all'):fetch_productos(input_producto.value)
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
        col = document.createElement('td')
        row.appendChild(col)
        tabla.children[i].children[6].innerHTML = `
<!--        <button class="btn btn-primary btn-sm ml-1 ver ${data[i]['Codigo']} ">Ver</button>-->
        <button class="btn btn-warning btn-sm ml-1 editar ${data[i]['Codigo']}">Editar</button>
        <button class="btn btn-danger btn-sm ml-1 eliminar ${data[i]['Codigo']}">Eliminar</button>`

        // document.getElementsByClassName('ver')[i].addEventListener('click', e => ver(e,'producto'))
        document.getElementsByClassName('editar')[i].addEventListener('click', e => editar(e,'producto'))
        document.getElementsByClassName('eliminar')[i].addEventListener('click', e => eliminar(e,'producto'))
    }
}
