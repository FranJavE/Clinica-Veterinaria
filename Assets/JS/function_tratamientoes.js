
let tableTratamientos;
let rowTable = "";
document.addEventListener('DOMContentLoaded', function(){

  tableTratamientos = $('#tableTratamientos').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "ajax":{
            "url": " "+base_url+"/Tratamientos/getTratamientos",
            "dataSrc":""
        },
        "columns":[
            {"data":"id_tratamiento"},
            {"data":"NombreTratamiento"},
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
    let formTratamiento = document.querySelector("#formTratamiento");
    formTratamiento.onsubmit = function(e) {
       e.preventDefault();

        let intIdTratamiento = document.querySelector('#idTratamiento').value;
        let strNombre = document.querySelector('#txtNombre').value;
        let strDescripcion = document.querySelector('#txtDescripcion').value;
        let intStatus = document.querySelector('#listStatus').value;        
        if(strNombre == '' || strDescripcion == '' || intStatus == '')
        {
            swal("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Tratamientos/setTratamientos'; 
        let formData = new FormData(formTratamiento);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
           if(request.readyState == 4 && request.status == 200){
                
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    if(rowTable == ""){
                        tableTratamientos.api().ajax.reload();
                    }else{
                        htmlStatus = intStatus == 1 ? 
                            '<span class="badge badge-success">Activo</span>' : 
                            '<span class="badge badge-danger">Inactivo</span>';
                        rowTable.cells[1].textContent = strNombre;
                        rowTable.cells[2].textContent = strDescripcion;
                        rowTable.cells[3].innerHTML = htmlStatus;
                        rowTable = "";
                    }

                    $('#modalFormTratamiento').modal("hide");
                    formTratamiento.reset();
                    swal("Tratamiento", objData.msg ,"success");

                }              
            } 
        }
        return true;
        
    }

});

function openModal(){

    document.querySelector('#idTratamiento').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Tratamiento";
    document.querySelector("#formTratamiento").reset();
    $('#modalFormTratamiento').modal('show');
}

window.addEventListener('load', function(){
   /* fntEditTratamiento();
    fntDelTratamiento();
    fntPermisos();*/
}, false);

function fntEditTratamiento(element,idTratamiento){
    rowTable = element.parentNode.parentNode.parentNode;
    document.querySelector('#titleModal').innerHTML ="Actualizar Tratamiento";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";
   
    //Scrip para ejecutar el ajax
    let idtratamiento = idTratamiento;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl  = base_url+'/Tratamientos/getTratamiento/'+idTratamiento;
    request.open("GET",ajaxUrl ,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);//convertimos un obj a formato JSON

            if(objData.status)
            {   //Colocamos lo que venga desde la consulta en cada campo(estamos seteando)
                document.querySelector("#idTratamiento").value = objData.data.id_tratamiento;
                document.querySelector("#txtNombre").value = objData.data.NombreTratamiento;
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
    $('#modalFormTratamiento').modal('show');
    
}
function fntViewTratamiento(idTratamiento){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl = base_url+'/Tratamientos/getTratamiento/'+idTratamiento;
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let estado = objData.data.status == 1 ? 
                '<span class="badge badge-success">Activo</span>' : 
                '<span class="badge badge-danger">Inactivo</span>';
                document.querySelector("#celId").innerHTML = objData.data.id_tratamiento;
                document.querySelector("#celNombre").innerHTML = objData.data.NombreTratamiento;
                document.querySelector("#celDescripcion").innerHTML = objData.data.Descripcion;
                document.querySelector("#celEstado").innerHTML = estado;
                $('#modalViewTratamiento').modal('show');
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntDelTratamiento(idTratamiento){
           
   // let idtratamiento = idTratamiento;//obtenemos el ide del elemneto al que le damos click
    swal({
        title: "Eliminar Tratamiento",
        text: "¿Realmente quiere eliminar el Tratamiento?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, Cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) { 
        if (isConfirm){

                let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
                let ajaxUrl  = base_url+'/Tratamientos/delTratamiento/';
                let strData = 'idTratamiento='+idTratamiento;
                request.open("POST",ajaxUrl ,true);
                request.setRequestHeader("content-type", "application/x-www-form-urlencoded");
                request.send(strData);
                request.onreadystatechange = function(){
                    if(request.readyState == 4 && request.status == 200){
                        let objData = JSON.parse(request.responseText);//convertimos un obj a formato JSON

                        if(objData.status)
                        {   
                            swal("Eliminar!", objData.msg , "success");
                            tableTratamientos.api().ajax.reload();
                            
                        }else{
                            swal("Atención!", objData.msg , "error");
                        }
              }
            }

        }

    });


}




