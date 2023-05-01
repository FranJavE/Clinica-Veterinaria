window.addEventListener('load', function(){
    fntClientes();
    fntProductos();
 }, false);

function fntClientes() {
    let ajaxUrl = base_url+'/Clientes/getSelectClientes';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listDuenoId').innerHTML = request.responseText;
           // document.querySelector('#listDuenoId').value = id_persona;
            $('#listDuenoId').selectpicker('render');
        }
    } 
}

function fntProductos() {
    let ajaxUrl = base_url+'/Productos/getSelectProductos';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#listProductoId').innerHTML = request.responseText;
            //document.querySelector('#listProductoId').value = id_producto;
            $('#listProductoId ').selectpicker('render');
        }
    } 
}