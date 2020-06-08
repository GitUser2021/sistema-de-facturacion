// referencias
let input_total_factura = document.getElementById('total-factura')
let input_carrito = document.getElementById('carrito')
let tabla_factura = document.getElementById('tabla-factura').children[1]
let tabla_productos = document.getElementById('tabla-productos').children[1]
// let ocultar_tabla_productos = document.getElementsByClassName('nueva-factura-right')
    let ocultar_tabla_productos = document.getElementsByClassName('div-right')
let btn_guardar_factura = document.getElementById('btn-guardar-factura')
let tbody_factura = document.getElementById('tbody-factura')
let btn_agregar = document.getElementsByClassName('btn-agregar')
let btn_ver_factura = document.getElementById('btn-ver-factura')
let input_productos = document.getElementById('input-productos')
let btn_buscar_cliente = document.getElementById('btn-buscar-cliente')
let cliente = document.getElementById('cliente')
let input_cliente_encontrado = document.getElementById('cliente-encontrado')
let input_id_cliente = document.getElementById('id-cliente')
let pagination = document.getElementById('pagination')

btn_buscar_cliente.addEventListener('click', (e) => {
    e.preventDefault()
    fetch(`/buscar_cliente/${cliente.value}`)
        .then(res => res.json())
        .then(data => {
            if (data.id_cliente !== 'xx') {
                enable_buttons(true)
                ocultar_tabla_productos[0].style.opacity = 1
                ocultar_tabla_productos[0].style.zIndex = 1
            } else {
                enable_buttons(false);
            }
            input_cliente_encontrado.value = `Cliente: ${data.Nombre}`;
            input_id_cliente.value = data.id_cliente
        })
})

// let carrito = []
let index = 0;
let total_compra = 0
let factura
let factura_data = ''

// deshabilito la seleccion de productos si aun no se ha elegido un cliente para la nueva factura.
if (cliente_nombre == "" || cliente_nombre == "no encontrado!") {
    ocultar_tabla_productos[0].style.opacity = 0.3
    ocultar_tabla_productos[0].style.zIndex = -1
}

// habilito/deshabilito los botones VER FACTURA y GUARDAR FACTURA si aun no se han elegido productos para la nueva factura.
function enable_buttons(status) {
    if (status) {
        btn_guardar_factura.disabled = false
        btn_ver_factura.disabled = false
    } else {
        btn_guardar_factura.disabled = true
        btn_ver_factura.disabled = true
    }
}

// selecciono el vendedor que figura en la factura.
for (let i = 0; i < document.getElementById('vendedor').childElementCount; i++) {
    if (document.getElementById('vendedor')[i].value == vendedor) {
        document.getElementById('vendedor')[i].selected = true
        break
    }
}
vendedor = document.getElementById('vendedor').value

// cargo el carrito de la factura en la tabla para su edicion.
if (carrito.length > 0) {
    for (let i = 0; i < carrito.length; i++) {
        cargar_factura(carrito)
        input_carrito.value = JSON.stringify(carrito)
    }
    enable_buttons(true)
}

// obtengo la lista de productos.
cargar_tabla(productos)

function cargar_tabla(data) {
    let row, col, textNode
    for (let i = 0; i < data.length; i++) {
        row = document.createElement('tr')
        col = document.createElement('td')
        textNode = document.createTextNode(i)
        col.appendChild(textNode)
        row.appendChild(col)
        tabla_productos.appendChild(row)

        for (key in data[i]) {
            col = document.createElement('td')
            col.id = key + '-' + (i + 1)
            if (key !== 'Estado' && key !== 'Agregado') {
                textNode = document.createTextNode(data[i][key])
                col.appendChild(textNode)
                row.appendChild(col)
            }
        }
        col = document.createElement('td')
        row.appendChild(col)
        tabla_productos.children[i].children[4].innerHTML = `<input type="number" class="form-control ml-auto" id="input-${i + 1}">`

        col = document.createElement('td')
        row.appendChild(col)
        btn = crear_boton('agregar', i + 1)
        tabla_productos.children[i].children[5].appendChild(btn)
    }
    listener_productos()
    listener_carrito()
}

// si borro el input y queda en blanco se hace un fetch ?p=all para volver a traer todos los resultados.
// de lo contrario traigo el listado del producto buscado.
function listener_productos() {
    input_productos.addEventListener('keyup', () => {
        input_productos.value == '' ? fetch_productos('all') : fetch_productos(input_productos.value)
    })
}

function fetch_productos(param) {
    if (isNaN(param) || param == 'all') {
        fetch(`/lista_productos?input=${param}`)
            .then(res => res.json())
            .then(data => {
                tabla_productos.innerHTML = null // limpio la tabla antes de cargar los nuevos datos
                cargar_tabla(data)
            })
    } else {
        fetch(`/lista_productos?input=${param}`)
            .then(res => res.json())
            .then(data => {
                tabla_productos.innerHTML = null // limpio la tabla antes de cargar los nuevos datos
                cargar_tabla(data)
            })
    }
}

function listener_carrito() {
    for (let i = 0; i < btn_agregar.length; i++) {
        btn_agregar[i].addEventListener('click', event => {
            cargar_carrito(event)
        })
    }
}

function cargar_carrito(event) {
    carrito.push({
        codigo: document.getElementById('Codigo-' + event.target.id).innerText,
        cantidad: document.getElementById('input-' + event.target.id).value,
        producto: document.getElementById('Producto-' + event.target.id).innerText,
        precio: document.getElementById('Precio-' + event.target.id).innerText,
        total: parseFloat(document.getElementById('Precio-' + event.target.id).innerText) * document.getElementById('input-' + event.target.id).value,
        acciones: ''
    })
    carrito.length == 0 ? enable_buttons(false) : enable_buttons(true)
    input_carrito.value = JSON.stringify(carrito)
    cargar_factura(carrito)
}

function cargar_factura(carrito) {
    let row = document.createElement('tr')

    for (key in carrito[index]) {
        td = document.createElement('td')
        crear_boton('eliminar', carrito[index]['codigo'])
        btn.addEventListener('click', eliminar_item_carrito)
        row.appendChild(td)
        textNode = document.createTextNode(carrito[index][key])
        td.appendChild(textNode)
        if (key == 'acciones') {
            td.appendChild(btn)
        }
        tabla_factura.appendChild(row)
    }
    calcular_total()
    // eliminio las columnas acciones (5) de cada tr
    tabla_pdf(index) // cargo la tabla que se usara para el pdf.
    index++
}

function crear_boton(name, id) {
    btn = document.createElement('button')
    btn.id = id
    btn.className = `btn btn-primary btn-${name}`
    btn.innerText = name
    return btn
}

function calcular_total() {
    total_compra = 0
    for (key in carrito) {
        total_compra += carrito[key]['total']
    }
    input_total_factura.value = total_compra
}

function tabla_pdf(index_) {
    index = index_ || 0
    for (let i = index; i < tbody_factura.children.length; i++) {
        factura_data += '<tr>'
        for (let e = 0; e < 5; e++) {
            factura_data += tbody_factura.children[i].children[e].outerHTML
        }
        factura_data += '</tr>'
    }
}

function eliminar_item_carrito() {
    for (item in carrito) {
        if (carrito[item].codigo == this.id) {
            carrito.splice(item, 1)
            break
        }
    }
    this.parentElement.parentElement.remove()
    index--
    factura_data = ''
    input_carrito.value = '' // limpio el valor del input y luego lo actualizo con el carrito sin el item eliminado.
    input_carrito.value = JSON.stringify(carrito)
    tabla_pdf()
    calcular_total()
    carrito.length == 0 ? enable_buttons(false) : enable_buttons(true)
}

btn_ver_factura.addEventListener('click', generar_pdf)

function generar_pdf() {
    cliente_ = document.getElementById('cliente-encontrado').value
    vendedor_ = document.getElementById('vendedor').value
    for (let i = 0; i < vendedores.length; i++) {
        vendedores[i].id_vendedor == vendedor_ ? vendedor_ = vendedores[i].Nombre : null
    }

    var date = new Date();
    date = date.toLocaleDateString(undefined, {
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit"
    });
    factura_ = {fecha: date, total_venta: total_compra}

    form[0].value = tabla_pdf_factura(factura_data)
    form.submit()
}
