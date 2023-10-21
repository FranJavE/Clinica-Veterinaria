window.addEventListener('load', function(){
    fntMascotas();
   // fntGuarderia();
}, false); 

function fntImprimirConsulta(idTipoInforme) {
    let idMascota = document.getElementById("listPaciente").value;
    var fechaConsulta = document.getElementById("txtFecha").value;
    var HoraConsulta = document.getElementById("txtHora").value;
    var ordernarPor = document.getElementById("ordernarPor").value;
    alert(ordernarPor);
    generarPDF(idMascota,fechaConsulta,HoraConsulta,ordernarPor);
}

function generarPDF(mascota, fecha, hora, ordernarPor) {
    let ancho = 1000;
    let alto = 800;
    let x = parseInt((window.screen.width/2) - (ancho / 2));
    let y = parseInt((window.screen.height/2) - (alto / 2));

    $url = base_url+'/Views/informe_consulta/generarInformeDeConsulta.php?idMascota='+mascota+'&fecha='+fecha+'&hora='+hora+'&ordernarPor='+ordernarPor;
    window.open($url,"Consulta","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si, location=no,resizable=si,menubar=no");

}

  function fntMascotas() {   

      let ajaxUrl = base_url+'/Mascotas/getSelectMascotas';
      let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      request.open("GET",ajaxUrl,true);
      request.send();
  
      request.onreadystatechange = function(){
          if(request.readyState == 4 && request.status == 200){
             const selectPaciente = document.querySelector('#listPaciente');
             selectPaciente.innerHTML = '<option value="0">Selecciona una mascota</option>' + request.responseText;
         
             $('#listPaciente').selectpicker('render');
          }
      }
  }
  