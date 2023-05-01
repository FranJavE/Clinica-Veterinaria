let tableVacunas;
let rowTable = "";
document.addEventListener('DOMContentLoaded', function(){

    tableVacunas = $('#tableVacunas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Vacunas/getVacunas",
            "dataSrc":""
        },

        "columns":[
            {"data":"Dueño"},
            {"data":"NombreMascota"},
            {"data":"NombreEspecie"},
            {"data":"NombreVacuna"},
            {"data":"fechaVacunacion"},
            {"data":"Hora"},
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
  if (document.querySelector('#formVacuna')) 
    {
    //Nueva Vacuna
        let formVacuna = document.querySelector('#formVacuna');
        //Activamos el evento que será igual a esa funcion
        formVacuna.onsubmit =function(e){
            e.preventDefault();
            let intIsPaciente = document.querySelector('#listPaciente').value;
            let intIsVacunas = document.querySelector('#listVacunas').value;
            let strDescripcion= document.querySelector('#txtDescripcion').value;
            let intPrecio= document.querySelector('#txtPrecio').value;
            let DateFecha = document.querySelector('#txtFecha').value;
            let strHora = document.querySelector('#txtHora').value;

            if(intIsPaciente == '' || intIsVacunas == '' || strDescripcion == '' || intPrecio == '')
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
            divLoading.style.display = "flex";
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Vacunas/setVacunas';
            let formData = new FormData(formVacuna);
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
                          tableVacunas.api().ajax.reload();
                        }else{ 
                            rowTable.cells[1].textContent = document.querySelector('#listPaciente').selectedOptions[0].text;
                            rowTable.cells[3].textContent = document.querySelector('#listVacunas').selectedOptions[0].text;
                            rowTable.cells[5].textContent = strHora;
                            rowTable.cells[4].textContent = DateFecha;
                            rowTable.cells[6].innerHTML = intPrecio;
                        }
                        $('#modalFormVacuna').modal('hide');
                        formVacuna.reset();
                        swal("Vacuna", objData.msg ,"success");

                    }else{
                        swal("Error", objData.msg , "error");

                    }

                }
            divLoading.style.display = "none";
            return false;
            }   
        }
    }

}, false);
 
window.addEventListener('load', function(){
    fntDueno();
    fntVacuna();
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
function fntVacuna(){
  let ajaxUrl = base_url+'/Vacunas/getSelectVacunas';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listVacunas').innerHTML = request.responseText;
          // document.querySelector('#listVacunas').value = id_Vacunacion;
            $('#listVacunas').selectpicker('render');
            //fntMascotas();
        }
    }
 }

function fntEditVacuna(element, idVacuna)
{
    rowTable = element.parentNode.parentNode.parentNode;
   // rowTable.cells[1].textContent = "Julio";
    
   //console.log(rowTable);
    document.querySelector('#titleModal').innerHTML ="Actualizar Vacuna";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar Vacuna";
    //let idpersona = idPersona;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Vacunas/getVacuna/'+idVacuna;
    request.open("GET",ajaxUrl,true);
    request.send();
    

            request.onreadystatechange = function(){

            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status)
                {
                    document.querySelector("#idVacuna").value = objData.data.id_VacunacionXMascota;
                    document.querySelector("#listPaciente").value = objData.data.id_mascota;
                     $('#listPaciente').selectpicker('render');
                    document.querySelector("#listVacunas").value = objData.data.id_Vacunacion;
                     $('#listVacunas').selectpicker('render');
                    document.querySelector("#txtDescripcion").value = objData.data.Descripcion;
                    document.querySelector("#txtFecha").value = objData.data.fechaVacunacion;
                    document.querySelector("#txtPrecio").value = objData.data.Precio;
                    document.querySelector("#txtHora").value = objData.data.Hora;
                }
            }            

            $('#modalFormVacuna').modal('show');
        }
}
function fntViewVacuna(idVacuna)
  {
        //let idVacuna = idVacuna;
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Vacunas/getVacuna/'+idVacuna;
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
                    document.querySelector("#celVacuna").innerHTML = objData.data.NombreVacuna;
                    document.querySelector("#celFecha").innerHTML = objData.data.fechaVacunacion;
                    document.querySelector("#celHora").innerHTML =  objData.data.Hora;
                    $('#modalViewVacuna').modal('show');
                }else{
                    swal("Error". objData.msg , "error");
                }
            }
          }
  }
function fntDelVacuna(idVacuna)
{
    //let idVacuna = idVacuna;//obtenemos el ide del elemneto al que le damos click
        swal({
            title: "Eliminar Vacuna",
            text: "¿Realmente quiere eliminar la Vacuna?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "No, Cancelar",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) { 
            if (isConfirm){

                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl  = base_url+'/Vacunas/delVacuna/';
                let strData = 'idVacuna='+idVacuna;
                request.open("POST",ajaxUrl ,true);
                request.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);//convertimos un obj a formato JSON

                        if(objData.status)
                        {   
                            swal("Eliminar!", objData.msg , "success");
                            tableVacunas.api().ajax.reload();
                            
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
    document.querySelector('#idVacuna').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Vacuna";
    document.querySelector("#formVacuna").reset();
    $('#modalFormVacuna').modal('show');
}