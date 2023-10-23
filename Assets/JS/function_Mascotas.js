let tableMascotas;
document.addEventListener('DOMContentLoaded', function(){

    tableMascotas = $('#tableMascotas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Mascotas/getMascotas",
            "dataSrc":""
        },

        "columns":[
            {"data":"Nombre"},
            {"data":"NombreRaza"},
            {"data":"NombreEspecie"},
            {"data":"Peso"},
            {"data":"Altura"},
            {"data":"Dueño"},
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
    let formMascotas = document.querySelector('#formMascotas');
    //Activamos el evento que será igual a esa funcion
    formMascotas.onsubmit =function(e){
        e.preventDefault();
        let strNombre = document.querySelector('#txtNombre').value;
        let intlistEspecieId = document.querySelector('#listEspecieId').value;
        let intlistRazaid = document.querySelector('#listRazaid').value;
        let intPeso= document.querySelector('#txtPeso').value;
        let intAltura = document.querySelector('#txtAltura').value;
        let intlistDuenoId = document.querySelector('#listDuenoId').value;
        
        if(strNombre == '' || intlistEspecieId == '' || intlistRazaid == '' || intPeso == '' || intAltura == '' || intlistDuenoId == '' )
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
        let ajaxUrl = base_url+'/Mascotas/setMascotas';
        let formData = new FormData(formMascotas);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        //Obtenemos el resultado de la inserccion
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200)
            {
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    $('#modalFormMascotas').modal('hide');
                    formMascotas.reset();
                    swal("Mascotas", objData.msg ,"success");
                   tableMascotas.api().ajax.reload();
                }else{
                    swal("Error", objData.msg , "error");

                }

            }
        }
    }
}, false);

window.addEventListener('load', function(){
   fntEspecie();
   fntClientes();
}, false);

function fntEspecie(){
    let ajaxUrl = base_url+'/Mascotas/getSelectEspecie';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listEspecieId').innerHTML = request.responseText;
            document.querySelector('#listEspecieId').value = 1;
            fntRaza();
            $('#listEspecieId').selectpicker('render');

            }

    }

}
function fntRaza() {   
    let intlistEspecieId = document.querySelector('#listEspecieId').value;
    let ajaxUrl = base_url+'/Mascotas/getSelectRaza/'+intlistEspecieId;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
           document.querySelector('#listRazaid').innerHTML = request.responseText;
           //document.querySelector('#listRazaid').value = request[id_raza']['5'];
           // $('#listRazaid').addEventListener('change');
           $("#listRazaid").selectpicker('val',request.status);
           $('#listRazaid').selectpicker('refresh');
            //console.log();
        }
    }

}
function fntClientes(){
    let ajaxUrl = base_url+'/Clientes/getSelectClientes';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listDuenoId').innerHTML = request.responseText;
            document.querySelector('#listDuenoId').value = id_persona;
            $('#listDuenoId').selectpicker('render');
        }
    }
    
}
function fntViewMascota(idMascota)
  {
   // let idMascota = idMascota;
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Mascotas/getMascota/'+idMascota;
        request.open("GET",ajaxUrl,true);
        request.send();

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                 let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    let estadoMascota = objData.data.status == 1 ?
                    '<span class="badge badge-success">Activo</span>' :
                    '<span class="badge badge-danger">Inactivo</span>';
                    document.querySelector("#celNombre").innerHTML = objData.data.Nombre;
                    document.querySelector("#celEspecie").innerHTML = objData.data.NombreEspecie;
                    document.querySelector("#celRaza").innerHTML = objData.data.NombreRaza;
                    document.querySelector("#celPeso").innerHTML = objData.data.Peso;
                    document.querySelector("#celAltura").innerHTML = objData.data.Altura;
                    document.querySelector("#celDueno").innerHTML = objData.data.Dueño;
                   document.querySelector("#celEstado").innerHTML = estadoMascota;
                    document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechacreacion;
                    $('#modalViewMascotas').modal('show');
                }else{
                    swal("Error". objData.msg , "error");
                }
            }
          }
  }
  function fntPrediccion()
  {
    
      $('#modalFormPrediccion').modal('show');
  }

function fntEditMascota(idMascota)
{
    document.querySelector('#titleModal').innerHTML ="Actualizar Mascota";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar Mascota";

    //let idMascota = idMascota;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Mascotas/getMascota/'+idMascota;
    request.open("GET",ajaxUrl,true);
    request.send();
    

            request.onreadystatechange = function(){

            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status)
                {
                    document.querySelector("#idMascota").value = objData.data.id_mascota;
                    document.querySelector("#txtNombre").value = objData.data.Nombre;
                    document.querySelector("#listEspecieId").value = objData.data.id_especie;
                    $('#listEspecieId').selectpicker('render');
                    document.querySelector("#listRazaid").value = objData.data.id_raza;
                   // $("#listRazaid").selectpicker('val',request.status);
                    $('#listRazaid').selectpicker('render');
                    document.querySelector("#txtPeso").value = objData.data.Peso;
                    document.querySelector("#txtAltura").value = objData.data.Altura;
                    document.querySelector("#listDuenoId").value =objData.data.id_persona;
                    $('#listDuenoId').selectpicker('render');

                    if(objData.data.status == 1){
                        document.querySelector("#listStatus").value = 1;
                    }else{
                        document.querySelector("#listStatus").value = 2;
                    }
                    $('#listStatus').selectpicker('render');
                }
            }
            $('#modalFormMascotas').modal('show');
        }
}
function fntDelMascota(idMascota)
{
    //let idMascota = idMascota;//obtenemos el ide del elemneto al que le damos click
        swal({
            title: "Eliminar Mascota",
            text: "¿Realmente quiere eliminar la Mascota?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "No, Cancelar",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) { 
            if (isConfirm){

                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl  = base_url+'/Mascotas/delMascota/';
                let strData = 'idMascota='+idMascota;
                request.open("POST",ajaxUrl ,true);
                request.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);//convertimos un obj a formato JSON

                        if(objData.status)
                        {   
                            swal("Eliminar!", objData.msg , "success");
                            tableMascotas.api().ajax.reload();
                            
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
    fntClientes();
    document.querySelector('#idMascota').value="";    
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nueva Mascota";
    document.querySelector("#formMascotas").reset();
    $('#modalFormMascotas').modal('show');

}