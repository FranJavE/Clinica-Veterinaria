window.addEventListener('load', function(){
    fntCategorias();
    fntProveedores();
}, false); 

function fntImprimirConsulta(idTipoInforme) {
    let idCategoria = document.getElementById("listCategoria").value;
    let idProveedor = document.getElementById("listProveedor").value;
    let precioMayor = document.getElementById("txtPrecioMayor").value;
    let PrecioMenor = document.getElementById("txtPrecioMenor").value;
    let ordernarPor = document.getElementById("ordernarPor").value;
    generarPDF(idCategoria,idProveedor,precioMayor,PrecioMenor,ordernarPor);
}

function generarPDF(idCategoria, idProveedor, precioMayor, PrecioMenor, ordernarPor) {
    let ancho = 1000;
    let alto = 800;
    let x = parseInt((window.screen.width/2) - (ancho / 2));
    let y = parseInt((window.screen.height/2) - (alto / 2));

    $url = base_url+'/Views/informe_producto/generarInformeDeProductos.php?idCategoria='+idCategoria+'&idProveedor='+idProveedor+'&precioMayor='+precioMayor+'&PrecioMenor='+PrecioMenor+'&ordernarPor='+ordernarPor;
    window.open($url,"Vacunas","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si, location=no,resizable=si,menubar=no");

 }
    
function fntCategorias(){
    if(document.querySelector('#listCategoria')){
        let ajaxUrl = base_url+'/Categorias/getSelectCategorias';
        let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                const selectCategoria = document.querySelector('#listCategoria');
                selectCategoria.innerHTML = '<option value="0">Selecciona una categoria</option>' + request.responseText;
                $('#listCategoria').selectpicker('render');
            }
        }
    }
}
function fntProveedores() {
    if(document.querySelector('#listProveedor')){
        let ajaxUrl = base_url+'/Productos/getSelectProveedor';
        let request = (window.XMLHttpRequest) ? 
                    new XMLHttpRequest() : 
                    new ActiveXObject('Microsoft.XMLHTTP');
        request.open("GET",ajaxUrl,true);
        request.send();
        request.onreadystatechange = function(){
            if(request.readyState == 4 && request.status == 200){
                const selectProveedor = document.querySelector('#listProveedor');
                selectProveedor.innerHTML = '<option value="0">Selecciona un proveedor</option>' + request.responseText;
                $('#listProveedor').selectpicker('render');
            }
        }
    }
}