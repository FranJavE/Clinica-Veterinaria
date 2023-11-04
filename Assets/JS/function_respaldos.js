function fntGenerarRespaldo()
  {
        //let idConsulta = idConsulta;
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Respaldos/Respaldo/'+1;
        request.open("GET",ajaxUrl,true);
        request.send();

        request.onreadystatechange = function() {
            if(request.readyState == 4 && request.status == 200){
                swal("Se genero el respaldo". objData.msg , "error");
            }
        }
  }