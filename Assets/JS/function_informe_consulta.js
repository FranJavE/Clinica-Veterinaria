window.addEventListener('load', function(){
    fntMascotas();
   // fntGuarderia();
}, false); 

function fntImprimirConsulta(idTipoInforme) {
    generarPDF(1,1);
}

function generarPDF(mascota, consulta) {
    let ancho = 1000;
    let alto = 800;
    let x = parseInt((window.screen.width/2) - (ancho / 2));
    let y = parseInt((window.screen.height/2) - (alto / 2));

    $url = base_url+'/Views/informe_consulta/generarInformeDeConsulta.php?ma='+mascota+'&co='+consulta;
    window.open($url,"Consulta","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si, location=no,resizable=si,menubar=no");

}

  function fntMascotas() {   

      let ajaxUrl = base_url+'/Mascotas/getSelectMascotas';
      let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      request.open("GET",ajaxUrl,true);
      request.send();
  
      request.onreadystatechange = function(){
          if(request.readyState == 4 && request.status == 200){
             document.querySelector('#listPaciente').innerHTML = request.responseText;
             $('#listPaciente').selectpicker('render');
          }
      }
  }
  