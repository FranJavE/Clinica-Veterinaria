<?php 
   header_admin($data); 
   getModal('ModalMedicos',$data);
?>
       <div id="contentAjax"></div>

<main class="app-content">
    <div class="app-title">
        <form id="formGuarderia" name="formGuarderia" class="form-horizontal" style="width: 50%; margin: 0 auto;">
            <h1><i class="fas fa-user-md"></i> <?= $data['Titulo_pagina']; ?></h1>
        <div class="form-row">
             <div class="form-group col-md-6">
                <label for="listPaciente">Paciente <span class="required">*</span></label>
                <select class="form-control" data-live-search="true" id="listPaciente" name="listPaciente">
                </select>
            </div>
            <div class="col-md-6"><!-- ocupara 6 columnas -->
                <label for="listJaula">Jaula <span class="required">*</span></label>
                <select class="form-control" data-live-search="true" id="listJaula" name="listJaula" required >
                    <option value="0">Seleccione una jaula</option>
                    <option value="1">Jaula 1</option>
                    <option value="2">Jaula 2</option>
                    <option value="3">Jaula 3</option>
                    <option value="4">Jaula 4</option>
                    <option value="5">Jaula 5</option>
                    <option value="6">Jaula 6</option>
                    <option value="7">Jaula 7</option>
                    <option value="8">Jaula 8</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="txtFechallegada">Fecha llegada <span class="required">*</span></label>
                <input class="form-control" id="txtFechallegada" name="txtFechallegada" type="date" placeholder="Seleccionar fecha" required="">
            </div>
            <div class="form-group col-md-6"><!-- ocupara 6 columnas -->
                <label for="txtHorallegada">Hora Llegada <span class="required">*</span></label>
                <input type="text" class="form-control valid validHora" id="txtHorallegada" name="txtHorallegada" placeholder="hh : mm " required="" onkeypress="return controlhora(event);">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="txtFechaSalida">Fecha Salida <span class="required">*</span></label>
                <input class="form-control" id="txtFechaSalida" name="txtFechaSalida" type="date" placeholder="Seleccionar fecha" required="">
            </div>
            <div class="form-group col-md-6"><!-- ocupara 6 columnas -->
                <label for="txtHoraSalida">Hora Salida <span class="required">*</span></label>
                <input type="text" class="form-control valid validHora" id="txtHoraSalida" name="txtHoraSalida" placeholder="hh : mm " required="" onkeypress="return controlhora(event);">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="ordernarPor">Odernar Por: <span class="required">*</span></label>
                <select class="form-control" data-live-search="true" id="ordernarPor" name="ordernarPor">
                    <option value="1">Nombre Dueño</option>
                    <option value="3">Número Jaula</option>
                    <option value="2">Nombre mascota</option>
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