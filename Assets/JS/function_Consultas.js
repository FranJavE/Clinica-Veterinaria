
let tableConsultas;
let rowTable = "";
document.addEventListener('DOMContentLoaded', function(){

    tableConsultas = $('#tableConsultas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Consultas/getConsultas",
            "dataSrc":""
        },

        "columns":[
            {"data":"Dueño"},
            {"data":"NombreMascota"},
            {"data":"NombreEspecie"},
            {"data":"NombreMedico"},
            {"data":"fechaconsulta"},
            {"data":"hora"},
            {"data":"Precio"},
            {"data":"options"}
        ],
        'dom': 'lBfrtip',
        'buttons': [
        {
           "extend": "copyHtml5",
                "text": "<i class='far fa-copy'></i> Copiar",
                "titleAttr":"Copiar",
                "className": "btn btn-secondary"
            },{
                "extend": "excelHtml5",
                "text": "<i class='fas fa-file-excel'></i> Excel",
                "titleAttr":"Esportar a Excel",
                "className": "btn btn-success"
            },{
                "extend": "pdfHtml5",
                "text": "<i class='fas fa-file-pdf'></i> PDF",
                "titleAttr":"Esportar a PDF",
                "className": "btn btn-danger"
            },{
                "extend": "csvHtml5",
                "text": "<i class='fas fa-file-csv'></i> CSV",
                "titleAttr":"Esportar a CSV",
                "className": "btn btn-info"
            }
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 10,
        "order":[[0,"desc"]]
    });
  if (document.querySelector('#formConsulta'))
    {
    //Nueva Consulta
        let formConsulta = document.querySelector('#formConsulta');
        //Activamos el evento que será igual a esa funcion
        formConsulta.onsubmit =function(e){
            e.preventDefault();
            let intIsPaciente = document.querySelector('#listPaciente').value;
            let intIsMedico = document.querySelector('#listMedicoId').value;
            let strDescripcion= document.querySelector('#txtDescripcion').value;
            let DateFecha = document.querySelector('#txtFecha').value;
            let strHora = document.querySelector('#txtHora').value;
            let intPrecio= document.querySelector('#txtPrecio').value;

            if(intIsPaciente == '' || intIsMedico == '' || strDescripcion == '' || intPrecio == '' ||
                DateFecha == '' || strHora == '')
            {
                swal("Atencion", "Todos los campos son obligatorios. ", "error");
                return false;
            }
            let elementsValid = document.getElementsByClassName("valid");
            for (let i = 0; i < elementsValid.length; i++) {
                if(elementsValid[i].classList.contains('is-invalid')) {
                    swal("Atencion", "Por favor verifique los datos." , "error");
                    return false;
                }
            }
           // divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Consultas/setConsultas';
            let formData = new FormData(formConsulta);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            //Obtenemos el resultado de la inserccion
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200)
                {
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == ""){
                          tableConsultas.api().ajax.reload();
                        }else{
                            rowTable.cells[1].textContent = document.querySelector('#listPaciente').selectedOptions[0].text;
                            rowTable.cells[3].textContent = document.querySelector('#listMedicoId').selectedOptions[0].text;
                            rowTable.cells[5].textContent = strHora;
                            rowTable.cells[4].textContent = DateFecha;
                            rowTable.cells[6].innerHTML = intPrecio;
                        }
                        $('#modalFormConsulta').modal('hide');
                        formConsulta.reset();
                        swal("Consulta", objData.msg ,"success");

                    }else{
                        swal("Error", objData.msg , "error");

                    }

                }
            //divLoading.style.display = "none";
            return false;
            }
        }
    }

}, false);

window.addEventListener('load', function(){
    fntDueno();
    fntMedico();
}, false);

function fntDueno(){
  let ajaxUrl = base_url+'/Clientes/getSelectClientes';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listDuenoId').innerHTML = request.responseText;
           //document.querySelector('#listDuenoId').value = id_persona;
            fntMascotas();
            $('#listDuenoId').selectpicker('render');
            //fntMascotas();
        }
    }
 }

function fntMedico(){
  let ajaxUrl = base_url+'/Medicos/getSelectMedicos';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listMedicoId').innerHTML = request.responseText;
           //document.querySelector('#listDuenoId').value = id_persona;
            $('#listMedicoId').selectpicker('render');
            //fntMascotas();
        }
    }
 }

 function fntMascotas()
{
    let intlistPacienteeId = document.querySelector('#listDuenoId').value;
    let ajaxUrl = base_url+'/Mascotas/getSelectMascota/'+intlistPacienteeId;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
           document.querySelector('#listPaciente').innerHTML = request.responseText;
           document.querySelector('#listPaciente').value = 1;
           // $('#listRazaid').addEventListener('change');
           //$("#listPaciente").selectpicker('val',request.status);
           $('#listPaciente').selectpicker('refresh');
            //console.log();
        }
    }
}

function fntEditConsulta(element, idConsulta)
{
    rowTable = element.parentNode.parentNode.parentNode;
   // rowTable.cells[1].textContent = "Julio";

   //console.log(rowTable);
    document.querySelector('#titleModal').innerHTML ="Actualizar Consulta";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar Consulta";
    //let idpersona = idPersona;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Consultas/getConsulta/'+idConsulta;
    request.open("GET",ajaxUrl,true);
    request.send();


            request.onreadystatechange = function(){

            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status)
                {
                    document.querySelector("#idConsulta").value = objData.data.id_Consulta;
                    document.querySelector('#listDuenoId').value = objData.data.id_persona;
                    $('#listDuenoId').selectpicker('render');
                    document.querySelector('#listPaciente').value = objData.data.id_mascota;
                    $('#listPaciente').selectpicker('render');
                    document.querySelector('#listMedicoId').value = objData.data.id_medico;
                    $('#listMedicoId').selectpicker('render');
                    document.querySelector('#txtDescripcion').value = objData.data.Descripcion;
                    document.querySelector('#txtFecha').value = objData.data.fechaconsulta;
                    document.querySelector('#txtHora').value = objData.data.hora;
                    document.querySelector('#txtPrecio').value = objData.data.Precio;
                    }

            $('#modalFormConsulta').modal('show');
        }
    }
}

function fntViewConsulta(idConsulta)
  {
        //let idConsulta = idConsulta;
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Consultas/getConsulta/'+idConsulta;
        request.open("GET",ajaxUrl,true);
        request.send();

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    /*'<span class="badge badge-warning">Pospuesta</span>';
                    '<span class="badge badge-danger">Cancelado</span>';*/
                    document.querySelector("#celNombreDueno").innerHTML = objData.data.Dueño;
                    document.querySelector("#celPaciente").innerHTML = objData.data.NombreMascota;
                    document.querySelector("#celEspecie").innerHTML = objData.data.NombreEspecie;
                    document.querySelector("#celRaza").innerHTML = objData.data.NombreRaza;
                    document.querySelector("#celDescripcion").innerHTML = objData.data.Descripcion;
                    document.querySelector("#celPrecio").innerHTML = objData.data.Precio;
                    document.querySelector("#celFecha").innerHTML = objData.data.fechaconsulta;
                    document.querySelector("#celHora").innerHTML =  objData.data.hora;

                    if (objData.data.id_detalle_consulta) {
                      document.querySelector("#celDescProducto").innerHTML = objData.data.desc_producto;
                      document.querySelector("#celStock").innerHTML = objData.data.stock;
                      document.querySelector("#celPrecioProducto").innerHTML = objData.data.precio_producto;
                      document.querySelector("#celCantidad").innerHTML = objData.data.cantidad;
                  }
                  
                    $('#modalViewConsulta').modal('show');
                }else{
                    swal("Error". objData.msg , "error");
                }
            }
          }
  }
function fntDelConsulta(idConsulta)
{
    //let idConsulta = idConsulta;//obtenemos el ide del elemneto al que le damos click
        swal({
            title: "Eliminar Consulta",
            text: "¿Realmente quiere eliminar la Consulta?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "No, Cancelar",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) {
            if (isConfirm){

                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl  = base_url+'/Consultas/delConsulta/';
                let strData = 'idConsulta='+idConsulta;
                request.open("POST",ajaxUrl ,true);
                request.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);//convertimos un obj a formato JSON

                        if(objData.status)
                        {
                            swal("Eliminar!", objData.msg , "success");
                            tableConsultas.api().ajax.reload();

                        }else{
                            swal("Atención!", objData.msg , "error");
                        }
                  }
                }

            }

        });
}
function fntImprimirConsulta(idConsulta)
  {
        //let idConsulta = idConsulta;
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Consultas/getConsulta/'+idConsulta;
        request.open("GET",ajaxUrl,true);
        request.send();

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                 let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    generarPDF(objData.data.id_mascota,objData.data.id_Consulta);
                }else{
                    swal("Error". objData.msg , "error");
                }
            }
          }
  }
function generarPDF(mascota, consulta)
{
    let ancho = 1000;
    let alto = 800;
    let x = parseInt((window.screen.width/2) - (ancho / 2));
    let y = parseInt((window.screen.height/2) - (alto / 2));

    $url = base_url+'/Views/Consultas/generaFactura.php?ma='+mascota+'&co='+consulta;
    window.open($url,"Consulta","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si, location=no,resizable=si,menubar=no");

}

function openModal()
{
    document.querySelector('#idConsulta').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Consulta";
    document.querySelector("#formConsulta").reset();
    $('#modalFormConsulta').modal('show');
}

$(document).ready(function() {
    var detalleCounter = 0;
  
    // Manejar el clic en el botón "Agregar Detalle"
    $("#btnAgregarDetalle").click(function() {
      detalleCounter++;
  
      // Crea el HTML para el detalle
      var detalleHTML = `
        <div class="detalle">
          <div class="form-row">
          <div class="form-group col-md-2">
          <input type="text" class="form-control" name="detallesdescripcion${detalleCounter}" placeholder="Producto">
        </div>
            <div class="form-group col-md-2">
              <input type="text" class="form-control" name="detallesdescripcion${detalleCounter}" placeholder="descripcion">
            </div>
            <div class="form-group col-md-2">
              <input type="text" class="form-control" name="detallestock${detalleCounter}" placeholder="stock">
            </div>
            <div class="form-group col-md-2">
              <input type="text" class="form-control" name="detalleprecio${detalleCounter}" placeholder="precio">
            </div>
            <div class="form-group col-md-2">
              <input type="text" class="form-control" name="detallecantidad${detalleCounter}" placeholder="cantidad">
            </div>
            <div class="form-group col-md-2">
              <input type="text" class="form-control" name="detalletotal${detalleCounter}" placeholder="total" disabled>
            </div>
            <div class="form-group col-md-2">
              <button class="btnQuitarDetalle">Quitar Detalle</button>
            </div>
          </div>
        </div>
      `;
  
      // Agrega el detalle al contenedor
      $("#detallesContainer").append(detalleHTML);
    });

    $("#detallesContainer").on("click", ".btnQuitarDetalle", function() {
      $(this).closest(".detalle").remove();
    });
    $("#detallesContainer").on("input", "input[name^='detalleprecio'], input[name^='detallecantidad']", function() {
      var detalle = $(this).closest(".detalle");
  
      var precio = parseFloat(detalle.find("input[name^='detalleprecio']").val()) || 0;
      var cantidad = parseFloat(detalle.find("input[name^='detallecantidad']").val()) || 0;
      var precioGlobal = parseFloat($("#txtPrecio").val()) || 0;
  
      var total = precio * cantidad;
      detalle.find("input[name^='detalletotal']").val(total);

      $("#txtPrecio").val(precioGlobal + total);
    });
  
    $("#btnActionForm").click(function() {
      // Recopila los detalles en un arreglo
      var detalles = [];
      for (var i = 1; i <= detalleCounter; i++) {
        var producto = document.querySelector(`input[name="detalleproducto${i}"]`).value;
        var descripcion = document.querySelector(`input[name="detallesdescripcion${i}"]`).value;
        var stock = document.querySelector(`input[name="detallestock${i}"]`).value;
        var precio = document.querySelector(`input[name="detalleprecio${i}"]`).value;
        var cantidad = document.querySelector(`input[name="detallecantidad${i}"]`).value;
        var total = document.querySelector(`input[name="detalletotal${i}"]`).value;
  
        var detalle = {
          producto: producto,
          descripcion: descripcion,
          stock: stock,
          precio: precio,
          cantidad: cantidad,
          total: total,
        };
  
        detalles.push(detalle);
      }
  
      // Agrega los detalles al formulario principal como un campo oculto
      var detallesInput = document.createElement("input");
      detallesInput.type = "hidden";
      detallesInput.name = "detalleConsulta";
      detallesInput.value = JSON.stringify(detalles);
      formConsulta.appendChild(detallesInput);
  
      // Continúa con el envío del formulario principal
      formConsulta.submit();
    });
  });
  