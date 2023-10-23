window.addEventListener('load', function(){
    fntEspecie();
    fntRaza();
    fntClientes();
}, false);

function fntImprimirConsulta(idTipoMascotas) {
    let idEspecie = document.getElementById("listEspecieId").value;
    let idRaza = document.getElementById("listRazaid").value;
    let idDuenio = document.getElementById("listDuenoId").value;
    let ordernarPor = document.getElementById("ordernarPor").value;
    generarPDF(idEspecie,idRaza,idDuenio,ordernarPor);
}

function generarPDF(especie, raza, duenio, ordernarPor) {
    let ancho = 1000;
    let alto = 800;
    let x = parseInt((window.screen.width/2) - (ancho / 2));
    let y = parseInt((window.screen.height/2) - (alto / 2));

    $url = base_url+'/Views/informe_mascotas/generarInformeDeMascotas.php?especie='+especie+'&raza='+raza+'&duenio='+duenio+'&ordernarPor='+ordernarPor;
    window.open($url,"Mascotas","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si, location=no,resizable=si,menubar=no");

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
            fntRaza();
            const selectEspecie = document.querySelector('#listEspecieId');
            selectEspecie.innerHTML = '<option value="0">Selecciona una especie</option>' + request.responseText;
            $('#listEspecieId').selectpicker('render');

         }

    }

}
function fntRaza() {   
    let intlistEspecieId = document.querySelector('#listEspecieId').value;
    let ajaxUrl = base_url+'/Mascotas/getSelectRaza/'+intlistEspecieId;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    request.open("GET",ajaxUrl,true);
    request.send();

    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
           document.querySelector('#listRazaid').innerHTML = request.responseText;
           //document.querySelector('#listRazaid').value = request[id_raza']['5'];
           // $('#listRazaid').addEventListener('change');
           $("#listRazaid").selectpicker('val',request.status);
           $('#listRazaid').selectpicker('refresh');
            //console.log();
        }
    }

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