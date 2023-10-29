

function buscarCodigo(e) {
    e.preventDefault();
    if (e.which == 13) {
    const cod = document.getElementById("codigo").value;
    const url = base_url + "/Ventas/buscarCodigo/" + cod;
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            if (res) {
                document.getElementById("nombre").value = res.Descripcion;
                document.getElementById("precio").value = res.Precio;
                document.getElementById("id_producto").value = res.id_producto;
                document.getElementById("cantidad").focus();
            } else {
                swal("Atencion", "El producto no existe. ", "error");
                document.getElementById("codigo").value = '';
                document.getElementById("codigo").focus();
            }
        }
    }
   }
}


function calcularPrecio(e) {
    e.preventDefault();
    const cant = document.getElementById("cantidad").value;
    const precio = document.getElementById("precio").value;
    document.getElementById("sub_total").value = precio * cant;
    if (e.which == 13) {
        if (cant > 0) {
            const url = base_url + "/Ventas/ingresar/";
            const frm = document.getElementById("frmVenta");
            const http = new XMLHttpRequest();
            http.open("POST", url, true);
            http.send(new FormData(frm));
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200){
                    const res = JSON.parse(this.responseText);
                    if (res.status === 'ok') {
                        frm.reset();
                        cargarDetalle();
                    }
                }
            }
        }
    }
}
cargarDetalle();
function cargarDetalle() {
    const url = base_url + "/Ventas/listar/";
    const http = new XMLHttpRequest();
    http.open("GET", url, true);
    http.send();
    http.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            const res = JSON.parse(this.responseText);
            let html = '';
            res.tbl_detalle_venta.forEach(row => {
                html += `<tr>
                <td>${row['id']}</td>
                <td>${row['Descripcion']}</td>
                <td>${row['cantidad']}</td>
                <td>${row['precio']}</td>
                <td>${row['sub_total']}</td>
                <td>
                <button class="btn btn-danger" type="button" onclick="deleteDetalle(${row['id']})">
                <i class="fas fa-trash-alt"></i>
                </button>
                </td>
                </tr>`;
            });
            document.getElementById("tblDetalle").innerHTML = html;
            document.getElementById("total").value = res.sub_total.total;
        }
    }
}

function deleteDetalle(id) {
    const url = base_url + "/Ventas/delete/" + id;

    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data === 'ok') {
            alert("Producto eliminado");
        } else {
            alert("Error al eliminar el producto");
        }
        // cargarDetalle(); // Esta función debería cargarse en ambos casos para actualizar la interfaz.
    })
    .catch(error => {
        console.error("Error en la solicitud:", error);
        // Manejar errores de red u otros errores aquí.
    });
}

function habilitarBoton() {
    var selectCliente = document.getElementById('cliente');
    var botonGenerarVenta = document.getElementById('botonGenerarVenta');
    
    if (selectCliente.value !== "") {
        botonGenerarVenta.removeAttribute('disabled');
    } else {
        botonGenerarVenta.setAttribute('disabled', 'disabled');
    }
}

function generarVenta() {
    swal({
        title: "Generar venta",
        text: "¿Realmente quiere generar la venta?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            const id_cliente = document.getElementById('cliente').value;
            const url = base_url + "/Ventas/registrarVenta/" + id_cliente;
            console.log("Valor de id_cliente:", id_cliente); // Agregar esta línea
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    const res = JSON.parse(this.responseText);
                    console.log(this.responseText);
                    if (res.status === 'ok') {
                        swal("Ingresado", "", "success"); // Mostrar un mensaje de éxito
                        const id_venta = res.id_venta; // Obtener el id_venta de la respuesta JSON
                        const ruta = base_url + '/Ventas/generarPdf/' + id_venta; // Utilizar el id_venta para generar el PDF
                        window.open(ruta);
                        setTimeout(() => {
                            window.location.reload();
                        }, 300);
                    } else {
                        swal("ERROR", "", "error"); // Mostrar un mensaje de error
                    }
                    
                    
                }
            };
        }
    });
}

$(document).ready(function () {
    $('#t_historial_v').DataTable({
        ajax: {
            url: "Historial/listar_historial",
            dataSrc: '',
        },
        columns: [{
                'data': 'id'
            },
            {
                'data': 'NombreCompleto'
            },
            {
                'data': 'total'
            },
            {
                'data': 'fecha'
            },
            {
                'data': null,
                render: function (data, type, row) {
                    return '<div><a class="btn btn-danger" href="' + "Ventas/generarPdf/" + row.id + '" target="_blank"><i class="fas fa-file-pdf"></i> PDF</a> ' +
                           '<a class="btn btn-danger delete-sale" data-id="' + row.id + '"><i class="fas fa-trash"></i> Eliminar</a></div>';
                }
            }
        ]
    });

    $('#t_historial_v').on('click', '.delete-sale', function (e) {
        e.preventDefault();
        var id = $(this).data('id');

            eliminarRegistro(id);
    });
});

function eliminarRegistro(id) {
    swal({
        title: "¿Estás seguro?",
        text: "Esta acción no se puede deshacer.",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function (isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: "Historial/delHistorial",
                type: "POST",
                data: { idHistorial: id },
                dataType: "json",
                success: function (response) {
                    if (response.status) {
                        swal("Eliminado", "El registro se ha eliminado con éxito.", "success");
                        setTimeout(function () {
                            location.reload();
                        }, 300);
                    } else {
                        swal("Error", "Error al eliminar el registro: " + response.msg, "error");
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText);
                    swal("Error", "Error al eliminar el registro: " + xhr.responseJSON.msg, "error");
                }
                
            });
        }
    });
}
