let tableGuarderia;
let rowTable = " ";
document.addEventListener('DOMContentLoaded', function(){

    tableGuarderia = $('#tableGuarderia').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Guarderia/getGuarderias",
            "dataSrc":""
        },

        "columns":[
            {"data":"Dueño"},
            {"data":"NombreMascota"},
            {"data":"NombreEspecie"},
            {"data":"Numero_Jaula"},
            {"data":"fechainicio"},
            {"data":"fechafin"},
            {"data":"Precio"},
            {"data":"status"},
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
 if (document.querySelector('#formGuarderia')) 
    {
    //Nueva Guarderia
        let formGuarderia = document.querySelector('#formGuarderia');
        //Activamos el evento que será igual a esa funcion
        formGuarderia.onsubmit =function(e){
            e.preventDefault();
            let intIsPaciente = document.querySelector('#listPaciente').value;
            let intIsJaula = document.querySelector('#listJaula').value;
            let strDescripcion= document.querySelector('#txtDescripcion').value;
            let intPrecio= document.querySelector('#txtPrecio').value;
            let DateFechallegada = document.querySelector('#txtFechallegada').value;
            let strHorallegada = document.querySelector('#txtHorallegada').value;
            let DateFechaSalida = document.querySelector('#txtFechaSalida').value;
            let strHoraSalida = document.querySelector('#txtHoraSalida').value;
            let intStatus  = document.querySelector('#listStatus').value;
            
            if(intIsPaciente == '' || intIsJaula == '' || strDescripcion == '' || intPrecio == '' || DateFechallegada == '' || strHorallegada == ''  ||
               DateFechaSalida == '' || strHoraSalida == '')
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
            //divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Guarderia/setGuarderia';
            let formData = new FormData(formGuarderia);
            request.open("POST",ajaxUrl,true);
            request.send(formData);
            //Obtenemos el resultado de la inserccion
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200)
                {
                    //console.log(request);
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        if(rowTable == " "){
                          tableGuarderia.api().ajax.reload();
                        }else{ 
                            htmlStatus = intStatus == 1 ?
                            '<span class="badge badge-success">Activo</span>' :
                            '<span class="badge badge-danger">Fuera</span>'; 
                            rowTable.cells[1].textContent = document.querySelector('#listPaciente').selectedOptions[0].text;
                            rowTable.cells[3].textContent = document.querySelector('#listJaula').selectedOptions[0].text;
                            rowTable.cells[4].textContent = strDescripcion;
                            rowTable.cells[5].textContent = DateFechallegada;
                            rowTable.cells[4].textContent = DateFechaSalida;
                            rowTable.cells[6].textContent = intPrecio;
                            rowTable.cells[7].innerHTML = htmlStatus;
                        }
                        $('#modalFormGuarderia').modal('hide');
                        formGuarderia.reset();
                        swal("Guarderia", objData.msg ,"success");

                    }else{
                        swal("Error", objData.msg , "error");

                    }

                }
           /* divLoading.style.display = "none";
            return false;*/
            }   
        }
    }
}, false);
 
window.addEventListener('load', function(){
    fntDueno();
   // fntGuarderia();
}, false);

function fntDueno()
{
  let ajaxUrl = base_url+'/Clientes/getSelectClientes';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listDuenoId').innerHTML = request.responseText;
           //document.querySelector('#listDuenoId').value = 1;
            fntMascotas();
            $('#listDuenoId').selectpicker('render');
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
         //  document.querySelector('#listPaciente').value = 1;
           // $('#listRazaid').addEventListener('change');
           $("#listPaciente").selectpicker('val',request.status);
           $('#listPaciente').selectpicker('refresh');
            //console.log();
        }
    }
}

function fntEditGuarderia(element, idGuarderia)
{
    rowTable = element.parentNode.parentNode.parentNode;
   // rowTable.cells[1].textContent = "Julio";
   //console.log(rowTable);
    document.querySelector('#titleModal').innerHTML ="Actualizar Guarderia";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar Guarderia";
    //let idpersona = idPersona;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Guarderia/getGuarderia/'+idGuarderia;
    request.open("GET",ajaxUrl,true);
    request.send();
    

            request.onreadystatechange = function(){

            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status)
                {
                    //fntDueno();
                    document.querySelector("#idGuarderia").value = objData.data.id_guarderia;
                    /*document.querySelector("#listDuenoId").value =objData.data.id_persona;
                    $('#listDuenoId').selectpicker('render');*/
                    document.querySelector("#listPaciente").value = objData.data.id_mascota;
                     $('#listPaciente').selectpicker('refresh');
                    document.querySelector("#listJaula").value = objData.data.Numero_Jaula;
                     $('#listJaula').selectpicker('render');
                    document.querySelector("#txtDescripcion").value = objData.data.Descripcion;
                    document.querySelector("#txtFechallegada").value = objData.data.fechainicio;
                    document.querySelector("#txtPrecio").value = objData.data.Precio;
                    document.querySelector("#txtHorallegada").value = objData.data.Hora_lnicio;
                    document.querySelector("#txtFechaSalida").value = objData.data.fechafin;
                    document.querySelector("#txtHoraSalida").value = objData.data.Hora_salida;
                    if(objData.data.status == 1){
                        document.querySelector("#listStatus").value = 1;
                    }else{
                        document.querySelector("#listStatus").value = 2;
                    }
                    $('#listStatus').selectpicker('render');
                }
            }            

            $('#modalFormGuarderia').modal('show');
        }
}

function fntViewGuarderia(idGuarderia)
  {
        //let idGuarderia = idGuarderia;
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Guarderia/getGuarderia/'+idGuarderia;
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
                    document.querySelector("#celJaula").innerHTML = objData.data.Numero_Jaula;
                    document.querySelector("#celFechaLlegada").innerHTML = objData.data.fechainicio;
                    document.querySelector("#celHoraLlegada").innerHTML =  objData.data.Hora_lnicio;
                    document.querySelector("#celFechaSalida").innerHTML = objData.data.fechafin;
                    document.querySelector("#celHoraSalida").innerHTML =  objData.data.Hora_salida;
                    $('#modalViewGuarderia').modal('show');
                }else{
                    swal("Error". objData.msg , "error");
                }
            }
          }
  }
function fntDelGuarderia(idGuarderia)
{
    //let idGuarderia = idGuarderia;//obtenemos el ide del elemneto al que le damos click
        swal({
            title: "Eliminar Guarderia",
            text: "¿Realmente quiere eliminar la Guarderia?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "No, Cancelar",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) { 
            if (isConfirm){

                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl  = base_url+'/Guarderia/delGuarderia/';
                let strData = 'idGuarderia='+idGuarderia;
                request.open("POST",ajaxUrl ,true);
                request.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);//convertimos un obj a formato JSON

                        if(objData.status)
                        {   
                            swal("Eliminar!", objData.msg , "success");
                            tableGuarderia.api().ajax.reload();
                            
                        }else{
                            swal("Atención!", objData.msg , "error");
                        }
                  }
                }

            }

        });
}
function fntbajaGuarderia(idGuarderia)
{
    //let idGuarderia = idGuarderia;//obtenemos el ide del elemneto al que le damos click
        swal({
            title: "Abandonar Guarderia",
            text: "¿La mascota se ira de guarderia?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, se ira",
            cancelButtonText: "No, Cancelar",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) { 
            if (isConfirm){

                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl  = base_url+'/Guarderia/bajaGuarderia/';
                let strData = 'idGuarderia='+idGuarderia;
                request.open("POST",ajaxUrl ,true);
                request.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);//convertimos un obj a formato JSON

                        if(objData.status)
                        {   
                            swal("Baja!", objData.msg , "success");
                            tableGuarderia.api().ajax.reload();
                            
                        }else{
                            swal("Atención!", objData.msg , "error");
                        }
                  }
                }

            }

        });
} 

function openModal()
{

    document.querySelector('#idGuarderia').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Mascota en Guarderia";
    document.querySelector("#formGuarderia").reset();
    $('#modalFormGuarderia').modal('show');
}