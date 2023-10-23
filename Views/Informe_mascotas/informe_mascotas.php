<?php 
   header_admin($data); 
?>
<div id="contentAjax"></div>

<main class="app-content">
    <div class="app-title">
        <form id="formMascota" name="formMascota" class="form-horizontal" style="width: 50%; margin: 0 auto;">
        <h1><i class="fas fa-user-md"></i> <?= $data['Titulo_pagina']; ?></h1>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="listEspecieId">Especie  <span class="required">*</span></label>
                <select class="form-control" data-live-search="true" id="listEspecieId" name="listEspecieId" onchange="fntRaza();">
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="listRazaid">Raza  <span class="required">*</span></label>
                <select class="form-control" data-live-search="true" id="listRazaid" name="listRazaid">
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="listDuenoId">Dueño  <span class="required">*</span></label>
                <select class="form-control" data-live-search="true" id="listDuenoId" name="listDuenoId">
                </select>
            </div>
            <div class="form-group col-md-6">
            <label for="ordernarPor">Odernar Por: <span class="required">*</span></label>
            <select class="form-control" data-live-search="true" id="ordernarPor" name="ordernarPor">
                <option value="1">Nombre Mascota</option>
                <option value="2">Raza</option>
                <option value="3">Especie</option>
                <option value="4">Peso</option>
                <option value="5">Altura</option>
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