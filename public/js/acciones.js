function eliminar(e,target) {
    id = e.target.classList[5]
    confirm_delete(e,target)
}
function editar(e,target) {
    id = e.target.classList[5]
    window.open(`editar_${target}/${id}`,'_self')

}
function ver(e,target) {
    id = e.target.classList[5]
    crear_pdf_factura(id)
}

function confirm_delete(e,target) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "¡Esta acción no se puede revertir!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar!'
    }).then((result) => {
        if (result.value) {
            e.target.parentElement.parentElement.remove() // elimino el <tr>
            window.open(`eliminar_${target}/${id}`,'_self')
        }
    })
}
