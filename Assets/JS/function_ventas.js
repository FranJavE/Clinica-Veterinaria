

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
        cargarDetalle(); // Esta función debería cargarse en ambos casos para actualizar la interfaz.
    })
    .catch(error => {
        console.error("Error en la solicitud:", error);
        // Manejar errores de red u otros errores aquí.
    });
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
            const url = base_url + "/Ventas/registrarVenta/";
            const http = new XMLHttpRequest();
            http.open("GET", url, true);
            http.send();
            http.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    //console.log(this.responseText);
                    const res = JSON.parse(this.responseText);
                    if (res === 'ok') { // Comparar con 'ok'
                        swal("Ingresado", "", "success"); // Mostrar un mensaje de éxito
                        const ruta = base_url + `/Ventas/generarPdf/`;
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
