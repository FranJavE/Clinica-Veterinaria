window.addEventListener('load', function(){
    fntMascotas();
    fntVacuna();
}, false); 

function fntImprimirConsulta(idTipoInforme) {
    let idMascota = document.getElementById("listPaciente").value;
    let fechaConsulta = document.getElementById("txtFecha").value;
    let HoraConsulta = document.getElementById("txtHora").value;
    let tipoVacuna = document.getElementById("listVacunas").value;
    let ordernarPor = document.getElementById("ordernarPor").value;
    generarPDF(idMascota,fechaConsulta,HoraConsulta,tipoVacuna,ordernarPor);
}

function generarPDF(mascota, fecha, hora, tipoVacuna, ordernarPor) {
    let ancho = 1000;
    let alto = 800;
    let x = parseInt((window.screen.width/2) - (ancho / 2));
    let y = parseInt((window.screen.height/2) - (alto / 2));

    $url = base_url+'/Views/informe_vacunas/generarInformeDeVacunas.php?idMascota='+mascota+'&tipoVacuna='+tipoVacuna+'&fecha='+fecha+'&hora='+hora+'&ordernarPor='+ordernarPor;
    window.open($url,"Vacunas","left="+x+",top="+y+",height="+alto+",width="+ancho+",scrollbar=si, location=no,resizable=si,menubar=no");

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
  
  function fntVacuna() {
    let ajaxUrl = base_url+'/Vacunas/getSelectVacunas';
      let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
      request.open("GET",ajaxUrl,true);
      request.send();
  
      request.onreadystatechange = function(){
          if(request.readyState == 4 && request.status == 200){
            const selectVacunas = document.querySelector('#listVacunas');
            selectVacunas.innerHTML = '<option value="0">Selecciona una vacuna</option>' + request.responseText;
        
            $('#listVacunas').selectpicker('render');
              //fntMascotas();
          }
      }
   }