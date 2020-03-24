let btn_nuevo_cliente = document.getElementById('btn-nuevo-cliente')
let input_cliente = document.getElementById('input-cliente')
let tabla = document.getElementById('tabla-clientes').children[1]
input_cliente.addEventListener('keypress',cargar_tabla)

btn_nuevo_cliente.addEventListener('click',e=>{
    e.preventDefault()
    window.open('/nuevo_cliente','_self')
})

fetch('lista_clientes?name=all')
    .then(res=>res.json())
    .then(data=>cargar_tabla(data))

input_cliente.addEventListener('keyup', () => {
    // si borro el input y queda en blanco se hace un fetch ?name=all para volver a traer todos los resultados.
    input_cliente.value == ''? my_fetch('all'):my_fetch(input_cliente.value)
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
    let row, col, textNode
    for (let i = 0; i < data.length; i++) {
        row = document.createElement('tr')
        col = document.createElement('td')
        tabla.appendChild(row)
        for (key in data[i]) {
            col = document.createElement('td')
            textNode = document.createTextNode(data[i][key])
            col.appendChild(textNode)
            row.appendChild(col)
        }
        col = document.createElement('td')
        row.appendChild(col)
        tabla.children[i].children[7].innerHTML = `
<!--        <button class="btn btn-primary btn-sm ml-1 ver ${data[i]['id_cliente']} ">Ver</button>-->
        <button class="btn btn-warning btn-sm ml-1 editar ${data[i]['id_cliente']}">Editar</button>
        <button class="btn btn-danger btn-sm ml-1 eliminar ${data[i]['id_cliente']}">Eliminar</button>`

        // document.getElementsByClassName('ver')[i].addEventListener('click', e => ver(e,'cliente'))
        document.getElementsByClassName('editar')[i].addEventListener('click', e => editar(e,'cliente'))
        document.getElementsByClassName('eliminar')[i].addEventListener('click', e => eliminar(e,'cliente'))
    }
}
