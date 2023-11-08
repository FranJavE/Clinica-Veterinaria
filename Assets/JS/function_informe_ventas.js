window.addEventListener('load', function(){
    fntClientes();
    fntPoductos();
}, false);

function fntImprimirConsulta(idTipoMascotas) {
    let idDuenio = document.getElementById("listDuenoId").value;
    let idProducto = document.getElementById("listProductoId").value;
    let ordernarPor = document.getElementById("ordernarPor").value;
    generarPDF(idDuenio, idProducto,ordernarPor);
}

function generarPDF(cliente, producto, ordernarPor) {
    let ancho = 1000;
    let alto = 800;
    let x = parseInt((window.screen.width/2) - (ancho / 2));
    let y = parseInt((window.screen.height/2) - (alto / 2));

    $url = base_url+'/Views/informe_ventas/generarInformeDeVentas.php?cliente='+cliente+'&producto='+producto+'&ordernarPor='+ordernarPor;
    window.open($url,"Mascotas","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si, location=no,resizable=si,menubar=no");

}



function fntClientes() {
    let ajaxUrl = base_url+'/Clientes/getSelectClientes';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){

            const selectPaciente = document.querySelector('#listDuenoId');
            selectPaciente.innerHTML = '<option value="0">Selecciona un dueño</option>' + request.responseText;
            $('#listDuenoId').selectpicker('render');
        }
    }
}



function fntPoductos() {
    let ajaxUrl = base_url+'/Productos/getSelectProductos';
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){

            const selectProductos = document.querySelector('#listProductoId');
            selectProductos.innerHTML = '<option value="0">Selecciona un producto</option>' + request.responseText;
            $('#listProductoId').selectpicker('render');
        }
    }
}  