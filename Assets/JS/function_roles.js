
let tableRoles;

document.addEventListener('DOMContentLoaded', function(){

  tableRoles = $('#tableRoles').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Roles/getRoles",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_rol"},
            {"data":"NombreRol"},
            {"data":"Descripcion"},
            {"data":"status"},
            {"data":"options"}
        ],
        "resonsieve":"true",
        "bDestroy": true,
        "iDisplayLength": 1000,
        "order":[[0,"desc"]]  
    });

    //NUEVO ROL
    let formRol = document.querySelector("#formRol");
    formRol.onsubmit = function(e) {
       e.preventDefault();

        let intIdRol = document.querySelector('#idRol').value;
        let strNombre = document.querySelector('#txtNombre').value;
        let strDescripcion = document.querySelector('#txtDescripcion').value;
        let intStatus = document.querySelector('#listStatus').value;        
        if(strNombre == '' || strDescripcion == '' || intStatus == '')
        {
            swal("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Roles/setRol'; 
        let formData = new FormData(formRol);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
           if(request.readyState == 4 && request.status == 200){
                
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    $('#modalFormRol').modal("hide");
                    formRol.reset();
                    swal("Roles de usuario", objData.msg ,"success");
                    tableRoles.api().ajax.reload();
                }else{
                    formRol.reset();
                    swal("Error", objData.msg , "error");

                }              
            } 
        }
        return true;
        
    }

});

$('#tableRoles').DataTable();

function openModal(){

    document.querySelector('#idRol').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Rol";
    document.querySelector("#formRol").reset();
    $('#modalFormRol').modal('show');
}

window.addEventListener('load', function(){
   /* fntEditRol();
    fntDelRol();
    fntPermisos();*/
}, false);

function fntEditRol(idRol){
    
    document.querySelector('#titleModal').innerHTML ="Actualizar Rol";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
   
    //Scrip para ejecutar el ajax
    let idrol = idRol;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl  = base_url+'/Roles/getRol/'+idrol;
    request.open("GET",ajaxUrl ,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);//convertimos un obj a formato JSON

            if(objData.status)
            {   //Colocamos lo que venga desde la consulta en cada campo(estamos seteando)
                document.querySelector("#idRol").value = objData.data.id_rol;
                document.querySelector("#txtNombre").value = objData.data.NombreRol;
                document.querySelector("#txtDescripcion").value = objData.data.Descripcion;
                //Convertimos de int a texto con html
                if(objData.data.status == 1)
                {
                    let optionSelect = '<option value="1" selected class="notBlock">Activo</option>';
                }else{
                    let optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';
                }
                //Variable para colocar la opcion activo e inactivo
                let htmlSelect = `${optionSelect}
                                  <option value="1">Activo</option>
                                  <option value="2">Inactivo</option>
                                `;
                //Colocamos la letiable en html en ek combobox                
                document.querySelector("#listStatus").innerHTML = htmlSelect;
                
            }else{
                swal("Error", objData.msg , "error");
            }
        }
     }
    $('#modalFormRol').modal('show');
    
}

function fntDelRol(idRol){
           
    let idrol = idRol;//obtenemos el ide del elemneto al que le damos click
    swal({
        title: "Eliminar Rol",
        text: "¿Realmente quiere eliminar el Rol?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) { 
        if (isConfirm){

                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl  = base_url+'/Roles/delRol/';
                let strData = 'id_rol='+idrol;
                request.open("POST",ajaxUrl ,true);
                request.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);//convertimos un obj a formato JSON

                        if(objData.status)
                        {   
                            swal("Eliminar!", objData.msg , "success");
                            tableRoles.api().ajax.reload(function(){ 
                                fntEditRol();
                                fntDelRol();
                                fntPermisos();
                            });
                            
                        }else{
                            swal("Atención!", objData.msg , "error");
                        }
              }
            }

        }

    });


}


function fntPermisos(idRol)
{
            
            //Scrip para ejecutar el ajax
            let idrol = idRol;
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl  = base_url+'/Permisos/getPermisosRol/'+idrol;
            request.open("GET",ajaxUrl ,true);
            request.send(); 
             //$('.ModalPermisos').modal('show');

           request.onreadystatechange = function(){
           if(request.readyState == 4 && request.status == 200){
            
              //  console.log(request.responseText);
                document.querySelector('#contentAjax').innerHTML = request.responseText;

                $('.ModalPermisos').modal('show');
                document.querySelector('#formPermisos').addEventListener('submit',fntSavePermisos,false);
            }
        }

}


function fntSavePermisos(evnet){
    evnet.preventDefault();
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Permisos/setPermisos'; 
    let formElement = document.querySelector("#formPermisos");
    let formData = new FormData(formElement);
    request.open("POST",ajaxUrl,true);
    request.send(formData);

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                swal("Permisos de usuario", objData.msg ,"success");
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
    
}
