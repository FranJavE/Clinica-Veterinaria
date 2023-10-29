let tableCitas;
document.addEventListener('DOMContentLoaded', function(){

    tableCitas = $('#tableCitas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Citas/getCitas",
            "dataSrc":""
        },

        "columns":[
            
            {"data":"NombrePersona"},
            {"data":"NombreMascota"},
            {"data":"Descripcion"},
            {"data":"fechacita"},
            {"data":"Hora"},
            {"data":"CantDias"},
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

    //Nuevo Usuario
    let formCita = document.querySelector('#formCita');
    //Activamos el evento que será igual a esa funcion
    formCita.onsubmit =function(e){
        e.preventDefault();
        let intIsPaciente = document.querySelector('#listPaciente').value;
        let strDescripcion= document.querySelector('#txtDescripcion').value;
        let DateFecha = document.querySelector('#txtFecha').value;
        let strHora = document.querySelector('#txtHora').value;
        
        
        if(intIsPaciente == '' || strDescripcion == '' || DateFecha == '' || strHora == '' )
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

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Citas/setCita/';
        let formData = new FormData(formCita);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        //Obtenemos el resultado de la inserccion
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200)
            {
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    $('#modalFormCita').modal('hide');
                    formCita.reset();
                    swal("Citas", objData.msg ,"success");
                   tableCitas.api().ajax.reload();
                }else{
                    swal("Error", objData.msg , "error");

                }

            }
        }
    }
}, false);

window.addEventListener('load', function(){
    fntDueno();
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
function fntViewCita(idCita)
  {
    	//let idCita = idCita;
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Citas/getCita/'+idCita;
        request.open("GET",ajaxUrl,true);
        request.send();

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                 let objData = JSON.parse(request.responseText);
                if(objData.status)
                {   
                    let Dias = "";
                    let estadoCita = "";
                    if(objData.data.CantDias < 0 && objData.data.status  == 1){
                        Dias = 'No vino';
                        objData.data.status = 4;
                    }else if (objData.data.CantDias < 0 && objData.data.status  == 2){
                        Dias = 'Ya vino';
                    }else if(objData.data.status  > 3)
                    {
                        objData.data.CantDias = 'Se cancelo';
                    }else{
                        Dias = objData.data.CantDias;
                    }

                    if(objData.data.status == 1){
                      //  document.querySelector("#listStatus").value = 1;
                      estadoCita = '<span class="badge badge-primary">Activa</span>'
                    }else if(objData.data.status == 2){
                         estadoCita = '<span class="badge badge-success">Realizada</span>';
                      //  document.querySelector("#listStatus").value = 2;
                    }else if(objData.data.status == 3){
                         estadoCita = '<span class="badge badge-warning">Pospuesta</span>';
                       // document.querySelector("#listStatus").value = 3;
                    }else{
                         estadoCita ='<span class="badge badge-danger">Cancelado</span>';
                       // document.querySelector("#listStatus").value = 4;
                    }
                    $('#listStatus').selectpicker('render');
                    document.querySelector("#celNombreDueno").innerHTML = objData.data.NombrePersona;
                    document.querySelector("#celPaciente").innerHTML = objData.data.NombreMascota;
                    document.querySelector("#celEspecie").innerHTML = objData.data.NombreEspecie;
                    document.querySelector("#celRaza").innerHTML = objData.data.NombreRaza;
                    document.querySelector("#celDescripcion").innerHTML = objData.data.Descripcion;
                    document.querySelector("#celFecha").innerHTML = objData.data.fechacita;
                    document.querySelector("#celCantDias").innerHTML = Dias;
                    document.querySelector("#celHora").innerHTML =  objData.data.Hora;
                    document.querySelector("#celEstado").innerHTML = estadoCita;
                    $('#modalViewCita').modal('show');
                }else{
                    swal("Error". objData.msg , "error");
                }
            }
          }
  }
  function fntEditCita(idCita) {
    document.querySelector('#titleModal').innerHTML ="Actualizar Cita";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar Cita";

    //let idCita = idCita;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Citas/getCita/'+idCita;
    request.open("GET",ajaxUrl,true);
    request.send();
    

            request.onreadystatechange = function(){

            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status)
                {
                    document.querySelector("#idCita").value = objData.data.id_citas;
                    document.querySelector("#listDuenoId").value =objData.data.id_persona;
                    $('#listDuenoId').selectpicker('render');
                    document.querySelector("#listPaciente").value = objData.data.id_mascota;
                    $('#listPaciente').selectpicker('render');
                    document.querySelector("#txtDescripcion").value = objData.data.Descripcion;
                    document.querySelector("#txtFecha").value = objData.data.fechacita;
                    document.querySelector("#txtHora").value = objData.data.Hora;
                   
                    if(objData.data.status == 1){
                        document.querySelector("#listStatus").value = 1;
                    }else if(objData.data.status == 2){
                        document.querySelector("#listStatus").value = 2;
                    }else if(objData.data.status == 3){
                        document.querySelector("#listStatus").value = 3;
                    }else{
                        document.querySelector("#listStatus").value = 4;
                    }
                    $('#listStatus').selectpicker('render');
                }
            }
        
            $('#modalFormCita').modal('show');
        }
}
function fntDelCita(idCita)
{
    //let idCita = idCita;//obtenemos el ide del elemneto al que le damos click
        swal({
            title: "Eliminar Cita",
            text: "¿Realmente quiere eliminar la cita?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "No, Cancelar",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) { 
            if (isConfirm){

                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl  = base_url+'/Citas/delCita/';
                let strData = 'idCita='+idCita;
                request.open("POST",ajaxUrl ,true);
                request.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);//convertimos un obj a formato JSON

                        if(objData.status)
                        {   
                            swal("Eliminar!", objData.msg , "success");
                            tableCitas.api().ajax.reload();
                            
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
   
    document.querySelector('#idCita').value="";    
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Cita";
    document.querySelector("#formCita").reset();
    $('#modalFormCita').modal('show');

}