window.addEventListener('load', function(){
    fntMascotas();
}, false); 

function fntImprimirConsulta(idTipoInforme) {
    let idMascota = document.getElementById("listPaciente").value;
    let fechaLlegada = document.getElementById("txtFechallegada").value;
    let horaLlegada = document.getElementById("txtHorallegada").value;
    let fechaSalida = document.getElementById("txtFechaSalida").value;
    let horaSalida = document.getElementById("txtHoraSalida").value;
    let jaula = document.getElementById("listJaula").value;
    let ordernarPor = document.getElementById("ordernarPor").value;
    generarPDF(idMascota,fechaLlegada,horaLlegada, fechaSalida, horaSalida,jaula,ordernarPor);
}

function generarPDF(mascota, fechaLlegada, horaLlegada, fechaSalida, horaSalida, jaula, ordernarPor) {
    let ancho = 1000;
    let alto = 800;
    let x = parseInt((window.screen.width/2) - (ancho / 2));
    let y = parseInt((window.screen.height/2) - (alto / 2));

    $url = base_url+'/Views/informe_guarderia/generarInformeDeGuarderia.php?idMascota='+mascota+'&jaula='+jaula+'&fechaLlegada='+fechaLlegada+'&horaLlegada='+horaLlegada+'&fechaSalida='+fechaSalida+'&horaSalida='+horaSalida+'&ordernarPor='+ordernarPor;
    window.open($url,"Guarderia","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si, location=no,resizable=si,menubar=no");

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