let tableRazas;
document.addEventListener('DOMContentLoaded', function(){

    tableRazas = $('#tableRazas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Razas/getRazas",
            "dataSrc":""
        },

        "columns":[
            {"data":"NombreRaza"},
            {"data":"NombreEspecie"},
            {"data":"Descripcion"},
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

    //Nuevo Raza
    let formRaza = document.querySelector('#formRaza');
    //Activamos el evento que será igual a esa funcion
    formRaza.onsubmit =function(e){
        e.preventDefault();
        let intlistEspecieId = document.querySelector('#listEspecieId').value;
        let strNombre = document.querySelector('#txtNombre').value;
        let strDescrpcion = document.querySelector('#txtDescripcion').value;

                
        if(intlistEspecieId = '' || strNombre == '' || strDescrpcion == '') {
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
        let ajaxUrl = base_url+'/Razas/setRaza';
        let formData = new FormData(formRaza);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        //Obtenemos el resultado de la inserccion
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    $('#modalFormRaza').modal('hide');
                    formRaza.reset();
                    swal("Raza", objData.msg ,"success");
                    tableRazas.api().ajax.reload();
                } else {
                    swal("Error", objData.msg , "error");

                }
            }
        }
    }
}, false);
 
window.addEventListener('load', function(){
    fntEspecie();
 }, false);
 

function fntEditRaza(idRaza) {
    document.querySelector('#titleModal').innerHTML ="Actualizar Raza";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar Raza";

    //let idpersona = idRaza;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Razas/getRaza/'+idRaza;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status) {
                document.querySelector("#idRaza").value = objData.data.id_raza;
                document.querySelector("#listEspecieId").value = objData.data.id_especie;
                document.querySelector("#txtNombre").value = objData.data.NombreRaza;
                document.querySelector("#txtDescripcion").value = objData.data.Descripcion;
            }
        }
    
        $('#modalFormRaza').modal('show');
    }
}
function fntDelRaza(idRaza) {
    //let idRaza = idRaza;//obtenemos el ide del elemneto al que le damos click
        swal({
            title: "Eliminar Raza",
            text: "¿Realmente quiere eliminar el Raza?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "No, Cancelar",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) { 
            if (isConfirm){

                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl  = base_url+'/Razas/delRaza/';
                let strData = 'idRaza='+idRaza;
                request.open("POST",ajaxUrl ,true);
                request.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function(){
                    if (request.readyState == 4 && request.status == 200) {
                        let objData = JSON.parse(request.responseText);//convertimos un obj a formato JSON
                        if(objData.status) {   
                            swal("Eliminar!", objData.msg , "success");
                            tableRazas.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg , "error");
                        }
                  }
                }

            }

        });
}

function fntEspecie(){
    let ajaxUrl = base_url+'/Mascotas/getSelectEspecie';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listEspecieId').innerHTML = request.responseText;
            document.querySelector('#listEspecieId').value = 1;
            $('#listEspecieId').selectpicker('render');
        }
    }
}

function openModal() {
    document.querySelector('#idRaza').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Raza";
    document.querySelector("#formRaza").reset();
    $('#modalFormRaza').modal('show');
}