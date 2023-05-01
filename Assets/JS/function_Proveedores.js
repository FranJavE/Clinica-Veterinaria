let tableProveedor;
document.addEventListener('DOMContentLoaded', function(){

    tableProveedor = $('#tableProveedor').dataTable( {
        "aProcessing":true,
        "aServerSide":true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Proveedor/getProveedores",
            "dataSrc":""
        },

        "columns":[
            {"data":"identificacion"},
            {"data":"Nombre_proveedor"},
            {"data":"Apellido_Proveedor"},
            {"data":"email_proveedor"},
            {"data":"Telefono"},
            {"data":"Direccion"},
            {"data":"Empresa"},
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

    //Nuevo Proveedor
    let formProveedor = document.querySelector('#formProveedor');
    //Activamos el evento que será igual a esa funcion
    formProveedor.onsubmit =function(e){
        e.preventDefault();
        let strIdentificacion = document.querySelector('#txtIdentificacion').value;
        let strNombre = document.querySelector('#txtNombre').value;
        let strApellido = document.querySelector('#txtApellido').value;
        let strEmail = document.querySelector('#txtEmail').value;
        let strTelefono = document.querySelector('#txtTelefono').value;
        let strDireccion = document.querySelector('#txtDireccion').value;
        let strEmpresa = document.querySelector('#txtEmpresa').value;

                
        if(strIdentificacion == '' || strNombre == '' || strApellido == '' || strEmail == '' || strTelefono == '' || strDireccion == '' || strEmpresa == '' )
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
        let ajaxUrl = base_url+'/Proveedor/setProveedores';
        let formData = new FormData(formProveedor);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        //Obtenemos el resultado de la inserccion
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200)
            {
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    $('#modalFormProveedor').modal('hide');
                    formProveedor.reset();
                    swal("Proveedor", objData.msg ,"success");
                   tableProveedor.api().ajax.reload();
                }else{
                    swal("Error", objData.msg , "error");

                }

            }
        }
    }
}, false);
 


function fntViewProveedor(idProveedor)
  {
   // let idpersona = idProveedor;
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Proveedor/getProveedor/'+idProveedor;
        request.open("GET",ajaxUrl,true);
        request.send();

        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                 let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    let estadoProveedor = objData.data.status == 1 ?
                    '<span class="badge badge-success">Activo</span>' :
                    '<span class="badge badge-danger">Inactivo</span>';
                    document.querySelector("#celIdentificacion").innerHTML = objData.data.identificacion;
                    document.querySelector("#celNombre").innerHTML = objData.data.Nombre_proveedor;
                    document.querySelector("#celApellido").innerHTML = objData.data.Apellido_Proveedor;
                    document.querySelector("#celTelefono").innerHTML = objData.data.Telefono;
                    document.querySelector("#celEmail").innerHTML = objData.data.email_proveedor;
                    document.querySelector("#celDireccion").innerHTML = objData.data.Direccion;
                    document.querySelector("#celEstado").innerHTML = estadoProveedor;
                    document.querySelector("#celEmpresa").innerHTML = objData.data.Empresa;
                    $('#modalViewProveedor').modal('show');
                }else{
                    swal("Error". objData.msg , "error");
                }
            }
          }
  }

function fntEditProveedor(idProveedor)
{
    document.querySelector('#titleModal').innerHTML ="Actualizar Proveedor";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar Proveedor";

    //let idpersona = idProveedor;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Proveedor/getProveedor/'+idProveedor;
    request.open("GET",ajaxUrl,true);
    request.send();
    

            request.onreadystatechange = function(){

            if(request.readyState == 4 && request.status == 200){
                let objData = JSON.parse(request.responseText);

                if(objData.status)
                {
                    document.querySelector("#idProveedor").value = objData.data.id_proveedores;
                    document.querySelector("#txtIdentificacion").value = objData.data.identificacion;
                    document.querySelector("#txtNombre").value = objData.data.Nombre_proveedor;
                    document.querySelector("#txtApellido").value = objData.data.Apellido_Proveedor;
                    document.querySelector("#txtTelefono").value = objData.data.Telefono;
                    document.querySelector("#txtEmail").value = objData.data.email_proveedor;
                    document.querySelector("#txtDireccion").value =objData.data.Direccion;
                    document.querySelector("#txtEmpresa").value =objData.data.Empresa;
                    if(objData.data.status == 1){
                        document.querySelector("#listStatus").value = 1;
                    }else{
                        document.querySelector("#listStatus").value = 2;
                    }
                    $('#listStatus').selectpicker('render');
                }
            }
        
            $('#modalFormProveedor').modal('show');
        }
}
function fntDelProveedor(idProveedor)
{
    //let idProveedor = idProveedor;//obtenemos el ide del elemneto al que le damos click
        swal({
            title: "Eliminar Proveedor",
            text: "¿Realmente quiere eliminar el Proveedor?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar",
            cancelButtonText: "No, Cancelar",
            closeOnConfirm: false,
            closeOnCancel: true
        }, function(isConfirm) { 
            if (isConfirm){

                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl  = base_url+'/Proveedor/delProveedor/';
                let strData = 'idProveedor='+idProveedor;
                request.open("POST",ajaxUrl ,true);
                request.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);//convertimos un obj a formato JSON

                        if(objData.status)
                        {   
                            swal("Eliminar!", objData.msg , "success");
                            tableProveedor.api().ajax.reload();
                            
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
    document.querySelector('#idProveedor').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Proveedor";
    document.querySelector("#formProveedor").reset();
    $('#modalFormProveedor').modal('show');
}