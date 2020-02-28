console.log('nueva_factura.js')

let cliente = document.getElementById('cliente').value
let vendedor = document.getElementById('vendedor').value
let items = []
let precio_total

// ref a la tabla de factura
let tabla_factura = document.getElementById('tabla-factura').children[1]

// ref a la tabla de productos
let tabla_productos = document.getElementById('tabla-productos').children[1]

// ref al lado productos
let lado_productos = document.getElementsByClassName('nueva-factura-right')
let btn_guardar_factura = document.getElementById('btn-guardar-factura')

let tbody_factura = document.getElementById('tbody-factura')
let index = 0;
let agregar = document.getElementsByClassName('btn-agregar')
let btn_imprimir = document.getElementById('btn-imprimir')
let input_productos = document.getElementById('input-productos')


if( cliente_nombre != "" && cliente_nombre != "Cliente no encontrado!" )  {
    console.log(`php_var: ${cliente_nombre}`)
}else{
    console.log("sin cliente")
    lado_productos[0].style.opacity = 0.3
    lado_productos[0].style.zIndex = -1
}
// if( @php echo "'".$cliente->Nombre."'" @endphp != "" && @php echo "'".$cliente->Nombre."'" @endphp != "Cliente no encontrado!" )  {
//     {{--                        console.log("php_var: @php echo $cliente->Nombre @endphp ")--}}
// }else{
//     console.log("sin cliente")
//     lado_productos[0].style.opacity = 0.3
//     lado_productos[0].style.zIndex = -1
// }

function enable_buttons(status){
    if(status){
        btn_guardar_factura.disabled = false
        btn_imprimir.disabled = false
    }else{
        btn_guardar_factura.disabled = true
        btn_imprimir.disabled = true
    }
}

fetch('lista_productos?p=all')
    .then(res => res.json())
    .then(data => {
            cargar_tabla(data)
            input_productos.addEventListener('keyup', () => {
                // si borro el input y queda en blanco se hace un fetch ?p=all para volver a traer todos los resultados.
                input_productos.value == '' ? fetch_productos('all') : fetch_productos(input_productos.value)
            })
            cargar_carrito()
        }
    )

function fetch_productos(param) {
    if (isNaN(param) || param == 'all') {
        fetch(`lista_productos?p=${param}`)
            .then(res => res.json())
            .then(data => {
                tabla_productos.innerHTML = null // limpio la tabla antes de cargar los nuevos datos
                cargar_tabla(data)
                cargar_carrito()
            })
    } else {
        fetch(`lista_productos?codigo=${param}`)
            .then(res => res.json())
            .then(data => {
                tabla_productos.innerHTML = null // limpio la tabla antes de cargar los nuevos datos
                cargar_tabla(data)
                cargar_carrito()
            })
    }
}

function cargar_carrito() {
    for (let i = 0; i < agregar.length; i++) {
        agregar[i].addEventListener('click', (e) => {
            items.push({
                codigo: document.getElementById('Codigo-' + e.target.id).innerText,
                cantidad: document.getElementById('input-' + e.target.id).value,
                producto: document.getElementById('Producto-' + e.target.id).innerText,
                precio: document.getElementById('Precio-' + e.target.id).innerText,
                total: parseFloat(document.getElementById('Precio-' + e.target.id).innerText) * document.getElementById('input-' + e.target.id).value,
                acciones: ''
            })
            items.length == 0? enable_buttons(false):enable_buttons(true)
            cargar_factura(items)
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
        tabla_productos.appendChild(row)

        for (key in data[i]) {
            col = document.createElement('td')
            col.id = key + '-' + (i+1)
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
        tabla_productos.children[i].children[5].innerHTML = `<button class="btn btn-primary btn-agregar" id="${i + 1}">Agregar</button>`


    }
}


function cargar_factura(items) {
    let row = document.createElement('tr')

    for (key in items[index]) {
        td = document.createElement('td')
        btn = document.createElement('button')
        btn.id = items[index]['codigo']
        btn.className = 'btn-eliminar'
        btn.innerText = 'Eliminar'
        btn.addEventListener('click', eliminar)
        row.appendChild(td)
        textNode = document.createTextNode(items[index][key])
        td.appendChild(textNode)
        if (key == 'acciones') {
            td.appendChild(btn)
        }
        tabla_factura.appendChild(row)
    }
    calcular_total()
    // eliminio las columnas acciones (5) de cada tr
    tabla_print(index) // cargo la tabla que se usara para el pdf.
    // factura_data = document.getElementById('print-factura').outerHTML
    index++
}


let total_compra = 0

function calcular_total() {
    total_compra = 0
    for (key in items) {
        total_compra += items[key]['total']
    }
}


function eliminar() {
    for (item in items) {
        if (items[item].codigo == this.id) {
            items.splice(item, 1)
            break
        }
    }
    this.parentElement.parentElement.remove()
    index--
    factura_data = ''
    tabla_print()
    calcular_total()
    items.length == 0? enable_buttons(false):enable_buttons(true)
}

function tabla_print(index_) {
    index = index_ || 0
    for(let i = index ; i < tbody_factura.children.length;i++){
        factura_data += '<tr>'
        for(let e = 0 ; e < 5;e++){
            factura_data += tbody_factura.children[i].children[e].outerHTML
        }
        factura_data += '</tr>'
    }
}

function Factura() {
    this.id_cliente
    this.id_vendedor
    this.cantidad_productos
    this.codigo
    this.producto
    this.precio_unitario
    this.precio_total
    this.total_venta
}

let factura

function crear_factura() {
    factura = new Factura()

    factura.codigo = codigo
    factura.producto = producto
    factura.precio_unitario = precio_unitario
    factura.precio_total = precio_total
    factura.cantidad_productos = cantidad
    factura.id_cliente = cliente
    factura.id_vendedor = vendedor
}

let factura_data = ''
btn_imprimir.addEventListener('click', () => {

    cliente_ = document.getElementById('cliente-encontrado').value
    vendedor_ = document.getElementById('vendedor').value
    for(let i = 0 ; i < vendedores.length;i++){
        vendedores[i].id_vendedor == vendedor_? vendedor_ = vendedores[i].Nombre:null
    }

    var date = new Date();
    date = date.toLocaleDateString(undefined, { // you can skip the first argument
        day: "2-digit",
        month: "2-digit",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit"
    });
    factura_ = {fecha:date,total_venta:total_compra}

    form[0].value = table(factura_data)
    form.submit()
})

