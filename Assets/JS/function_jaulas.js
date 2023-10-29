let tableJaulas;
document.addEventListener('DOMContentLoaded', function(){

    tableJaulas = $('#tableJaulas').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Jaulas/getJaulas",
            "dataSrc":""
        },

        "columns":[
            {"data":"nombre_jaula"},
            {"data":"numero_jaula"},
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

    //Nuevo Jaula
    let formJaula = document.querySelector('#formJaula');
    //Activamos el evento que será igual a esa funcion
    formJaula.onsubmit =function(e){
        e.preventDefault();
        let strNombre = document.querySelector('#txtNombre').value;
        let intNumero = document.querySelector('#txtNumero').value;
        let strDescrpcion = document.querySelector('#txtDescripcion').value;

                
        if(intNumero == '' || strNombre == '' || strDescrpcion == '') {
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
        let ajaxUrl = base_url+'/Jaulas/setJaula';
        let formData = new FormData(formJaula);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        //Obtenemos el resultado de la inserccion
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200) {
                let objData = JSON.parse(request.responseText);
                if (objData.status) {
                    $('#modalFormJaula').modal('hide');
                    formJaula.reset();
                    swal("Jaula", objData.msg ,"success");
                    tableJaulas.api().ajax.reload();
                } else {
                    swal("Error", objData.msg , "error");

                }
            }
        }
    }
}, false);
 


function fntEditJaula(idJaula) {
    document.querySelector('#titleModal').innerHTML ="Actualizar Jaula";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar Jaula";

    //let idpersona = idJaula;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Jaulas/getJaula/'+idJaula;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status) {
                document.querySelector("#idJaula").value = objData.data.id_jaula;
                document.querySelector("#txtNombre").value = objData.data.nombre_jaula;
                document.querySelector("#txtNumero").value = objData.data.numero_jaula;
                document.querySelector("#txtDescripcion").value = objData.data.Descripcion;
            }
        }
    
        $('#modalFormJaula').modal('show');
    }
}
function fntDelJaula(idJaula) {
    //let idJaula = idJaula;//obtenemos el ide del elemneto al que le damos click
        swal({
            title: "Eliminar Jaula",
            text: "¿Realmente quiere eliminar el Jaula?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "No, Cancelar",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) { 
            if (isConfirm){

                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl  = base_url+'/Jaulas/delJaula/';
                let strData = 'idJaula='+idJaula;
                request.open("POST",ajaxUrl ,true);
                request.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);//convertimos un obj a formato JSON
                        if(objData.status) {   
                            swal("Eliminar!", objData.msg , "success");
                            tableJaulas.api().ajax.reload();
                        } else {
                            swal("Atención!", objData.msg , "error");
                        }
                  }
                }

            }

        });
}

function openModal() {
    document.querySelector('#idJaula').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Jaula";
    document.querySelector("#formJaula").reset();
    $('#modalFormJaula').modal('show');
}