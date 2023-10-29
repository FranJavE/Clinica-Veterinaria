<?php 
   header_admin($data); 
   getModal('ModalMedicos',$data);
?>
       <div id="contentAjax"></div>

<main class="app-content">
    <div class="app-title">
        <form id="formVacuna" name="formVacuna" class="form-horizontal" style="width: 50%; margin: 0 auto;">
            <h1><i class="fas fa-user-md"></i> <?= $data['Titulo_pagina']; ?></h1>
        <div class="form-row">
             <div class="form-group col-md-6">
                <label for="listPaciente">Paciente <span class="required">*</span></label>
                <select class="form-control" data-live-search="true" id="listPaciente" name="listPaciente">
                </select>
            </div>
            <div class="form-group col-md-6">
              <label for="txtFecha">Fecha de vacunación <span class="required">*</span></label>
              <input class="form-control" id="txtFecha" name="txtFecha" type="date" placeholder="Seleccionar fecha">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6"><!-- ocupara 6 columnas -->
                <label for="txtHora">Hora <span class="required">*</span></label>
                <input type="text" class="form-control valid validHora" id="txtHora" name="txtHora" placeholder="hh : mm " onkeypress="return controlhora(event);">
            </div>
            <div class="form-group col-md-6"><!-- ocupara 6 columnas -->
                <label for="listVacunas">Vacuna<span class="required">*</span></label>
                <select class="form-control" data-live-search="true" id="listVacunas" name="listVacunas" required >
                </select>	
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="ordernarPor">Odernar Por: <span class="required">*</span></label>
                <select class="form-control" data-live-search="true" id="ordernarPor" name="ordernarPor">
                    <option value="1">Nombre Dueño</option>
                    <option value="5">Tipo Vacuna</option>
                    <option value="2">Nombre mascota</option>
                    <option value="3">Mas reciente</option>
                    <option value="4">Más antigua</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
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