let tableUsuarios;
document.addEventListener('DOMContentLoaded', function(){

    tableUsuarios = $('#tableUsuarios').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Clientes/getClientes",
            "dataSrc":""
        },

        "columns":[
            {"data":"identificacion"},
            {"data":"Nombre"},
            {"data":"Apellido"},
            {"data":"email_user"},
            {"data":"Telefono"},
            {"data":"Direccion"},
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
    let formCliente = document.querySelector('#formCliente');
    //Activamos el evento que será igual a esa funcion
    formCliente.onsubmit =function(e){
        e.preventDefault();
        let strIdentificacion = document.querySelector('#txtIdentificacion').value;
        let strNombre = document.querySelector('#txtNombre').value;
        let strApellido = document.querySelector('#txtApellido').value;
        let strEmail = document.querySelector('#txtEmail').value;
        let strTelefono = document.querySelector('#txtTelefono').value;
        let strDireccion = document.querySelector('#txtDireccion').value;

                
        if(strIdentificacion == '' || strNombre == '' || strApellido == '' || strEmail == '' || strTelefono == '' || strDireccion == '' )
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
        let ajaxUrl = base_url+'/Clientes/setClientes';
        let formData = new FormData(formCliente);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        //Obtenemos el resultado de la inserccion
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200)
            {
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    $('#modalFormCliente').modal('hide');
                    formCliente.reset();
                    swal("Clientes", objData.msg ,"success");
                   tableUsuarios.api().ajax.reload();
                }else{
                    swal("Error", objData.msg , "error");

                }

            }
        }
    }
}, false);
 


function fntViewCliente(idPersona)
  {
   // let idpersona = idPersona;
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Clientes/getCliente/'+idPersona;
        request.open("GET",ajaxUrl,true);
        request.send();

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                 let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    let estadoUsuario = objData.data.status == 1 ?
                    '<span class="badge badge-success">Activo</span>' :
                    '<span class="badge badge-danger">Inactivo</span>';
                    document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
                    document.querySelector("#celNombre").innerHTML = objData.data.Nombre;
                    document.querySelector("#celApellido").innerHTML = objData.data.Apellido;
                    document.querySelector("#celTelefono").innerHTML = objData.data.Telefono;
                    document.querySelector("#celEmail").innerHTML = objData.data.email_user;
                    document.querySelector("#celDireccion").innerHTML = objData.data.Direccion;
                    document.querySelector("#celRol").innerHTML = objData.data.NombreRol;
                    document.querySelector("#celEstado").innerHTML = estadoUsuario;
                    document.querySelector("#celFechaRegistro").innerHTML = objData.data.fechaRegistro;
                    $('#modalViewCliente').modal('show');
                }else{
                    swal("Error". objData.msg , "error");
                }
            }
          }
  }

function fntEditCliente(idPersona)
{
    document.querySelector('#titleModal').innerHTML ="Actualizar Clientes";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar Cliente";

    //let idpersona = idPersona;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Clientes/getCliente/'+idPersona;
    request.open("GET",ajaxUrl,true);
    request.send();
    

            request.onreadystatechange = function(){

            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status)
                {
                    document.querySelector("#idUsuario").value = objData.data.id_persona;
                    document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
                    document.querySelector("#txtNombre").value = objData.data.Nombre;
                    document.querySelector("#txtApellido").value = objData.data.Apellido;
                    document.querySelector("#txtTelefono").value = objData.data.Telefono;
                    document.querySelector("#txtEmail").value = objData.data.email_user;
                    document.querySelector("#txtDireccion").value =objData.data.Direccion;

                    if(objData.data.status == 1){
                        document.querySelector("#listStatus").value = 1;
                    }else{
                        document.querySelector("#listStatus").value = 2;
                    }
                    $('#listStatus').selectpicker('render');
                }
            }
        
            $('#modalFormCliente').modal('show');
        }
}
function fntDelCliente(idPersona)
{
    //let idUsuario = idPersona;//obtenemos el ide del elemneto al que le damos click
        swal({
            title: "Eliminar Cliente",
            text: "¿Realmente quiere eliminar el Cliente?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "No, Cancelar",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) { 
            if (isConfirm){

                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl  = base_url+'/Clientes/delCliente/';
                let strData = 'idUsuario='+idPersona;
                request.open("POST",ajaxUrl ,true);
                request.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);//convertimos un obj a formato JSON

                        if(objData.status)
                        {   
                            swal("Eliminar!", objData.msg , "success");
                            tableUsuarios.api().ajax.reload();
                            
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
    document.querySelector('#idUsuario').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Cliente";
    document.querySelector("#formCliente").reset();
    $('#modalFormCliente').modal('show');
}