<?php 
   header_admin($data); 
   getModal('ModalMedicos',$data);
?>
   <div id= "contentAjax"></div>
   
    <main class="app-content">
      <div class="app-title">

      <form id="formConsulta" name="formConsulta" class= "form-horizontal">
        <h1><i class="fas fa-user-md"></i> <?= $data['Titulo_pagina']; ?>
        <div class="form-row">
             <div class="form-group col-md-6">
                <label for="listPaciente">Paciente <span class="required">*</span></label>
                <select class="form-control" data-live-search="true" id="listPaciente" name="listPaciente">
                </select>
            </div>
        </div>
        <div class="form-row">
           <div class="form-group col-md-6">
              <label for="txtFecha">Fecha Consulta <span class="required">*</span></label>
                  <input class="form-control" id="txtFecha" name="txtFecha" type="date" placeholder="Seleccionar fecha">
                 </div>
                 <div class="form-group col-md-6"><!-- ocupara 6 columnas -->
            <label for="txtHora">Hora <span class="required">*</span></label>
            <input type="text" class="form-control valid validHora" id="txtHora" name="txtHora" placeholder="hh : mm " onkeypress="return controlhora(event);">
          </div>
        </div>
                <br></br>
        <div class="tile-footer">
          <button id="btnActionForm" class="btn btn-primary" type="submit" onClick="fntImprimirConsulta('1');"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Imprimir</span></button>&nbsp;&nbsp;&nbsp;

          <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>

        </div>
        </form>
      </div>
    </main>
    
 <?php footer_admin($data); ?>