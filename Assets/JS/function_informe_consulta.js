window.addEventListener('load', function(){
    fntDueno();
   // fntGuarderia();
}, false);

function fntImprimirConsulta(idTipoInforme) {
    //let idConsulta = idConsulta;
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    // ajaxUrl = base_url+'/Consultas/getConsulta/'+idConsulta;
    let id_mascota = document.querySelector('#listPaciente').value;
    ajaxUrl = base_url+'/Consultas/getConsulta/1';
    alert(id_mascota);
    alert(idTipoInforme);
    request.open("GET",ajaxUrl,true);
    request.send();
    request.onreadystatechange = function(){
        if (request.readyState == 4 && request.status == 200) {
             let objData = JSON.parse(request.responseText);
            if (objData.status)  {
                generarPDF(objData.data.id_mascota,objData.data.id_Consulta);
            } else {
                swal("Error". objData.msg , "error");
            }
        }
      }
}

function generarPDF(mascota, consulta) {
    let ancho = 1000;
    let alto = 800;
    let x = parseInt((window.screen.width/2) - (ancho / 2));
    let y = parseInt((window.screen.height/2) - (alto / 2));

    $url = base_url+'/Views/informe_consulta/generarInformeDeConsulta.php?ma='+mascota+'&co='+consulta;
    window.open($url,"Consulta","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si, location=no,resizable=si,menubar=no");

}

function fntDueno() {
    let ajaxUrl = base_url+'/Clientes/getSelectClientes';
      let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      request.open("GET",ajaxUrl,true);
      request.send();
  
      request.onreadystatechange = function(){
          if(request.readyState == 4 && request.status == 200){
              document.querySelector('#listDuenoId').innerHTML = request.responseText;
             //document.querySelector('#listDuenoId').value = 1;
              fntMascotas();
              $('#listDuenoId').selectpicker('render');
              //fntMascotas();
          }
      }
   }
  
  function fntMascotas() {   
      let intlistPacienteeId = document.querySelector('#listDuenoId').value;
      let ajaxUrl = base_url+'/Mascotas/getSelectMascota/'+intlistPacienteeId;
      let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      request.open("GET",ajaxUrl,true);
      request.send();
  
      request.onreadystatechange = function(){
          if(request.readyState == 4 && request.status == 200){
             document.querySelector('#listPaciente').innerHTML = request.responseText;
           //  document.querySelector('#listPaciente').value = 1;
             // $('#listRazaid').addEventListener('change');
             $("#listPaciente").selectpicker('val',request.status);
             $('#listPaciente').selectpicker('refresh');
              //console.log();
          }
      }
  }
  