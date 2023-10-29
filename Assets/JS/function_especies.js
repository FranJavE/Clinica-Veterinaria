let tableEspecies;
document.addEventListener('DOMContentLoaded', function(){

    tableEspecies = $('#tableEspecies').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Especies/getEspecies",
            "dataSrc":""
        },

        "columns":[
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

    //Nuevo Especie
    let formEspecie = document.querySelector('#formEspecie');
    //Activamos el evento que será igual a esa funcion
    formEspecie.onsubmit =function(e){
        e.preventDefault();
        let strNombre = document.querySelector('#txtNombre').value;
        let strDescrpcion = document.querySelector('#txtDescripcion').value;

                
        if(strNombre == '' || strDescrpcion == '') {
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
        let ajaxUrl = base_url+'/Especies/setEspecie';
        let formData = new FormData(formEspecie);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        //Obtenemos el resultado de la inserccion
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    $('#modalFormEspecie').modal('hide');
                    formEspecie.reset();
                    swal("Especie", objData.msg ,"success");
                    tableEspecies.api().ajax.reload();
                } else {
                    swal("Error", objData.msg , "error");

                }
            }
        }
    }
}, false);
 


function fntEditEspecie(idEspecie) {
    document.querySelector('#titleModal').innerHTML ="Actualizar Especie";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar Especie";

    //let idpersona = idEspecie;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Especies/getEspecie/'+idEspecie;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status) {
                document.querySelector("#idEspecie").value = objData.data.id_especie;
                document.querySelector("#txtNombre").value = objData.data.NombreEspecie;
                document.querySelector("#txtDescripcion").value = objData.data.Descripcion;
            }
        }
    
        $('#modalFormEspecie').modal('show');
    }
}
function fntDelEspecie(idEspecie) {
    //let idEspecie = idEspecie;//obtenemos el ide del elemneto al que le damos click
        swal({
            title: "Eliminar Especie",
            text: "¿Realmente quiere eliminar el Especie?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "No, Cancelar",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) { 
            if (isConfirm){

                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl  = base_url+'/Especies/delEspecie/';
                let strData = 'idEspecie='+idEspecie;
                request.open("POST",ajaxUrl ,true);
                request.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);//convertimos un obj a formato JSON
                        if(objData.status) {   
                            swal("Eliminar!", objData.msg , "success");
                            tableEspecies.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg , "error");
                        }
                  }
                }

            }

        });
}

function openModal() {
    document.querySelector('#idEspecie').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Especie";
    document.querySelector("#formEspecie").reset();
    $('#modalFormEspecie').modal('show');
}