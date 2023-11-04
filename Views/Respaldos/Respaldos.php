<?php 
   header_admin($data); 
?>
       <div id="contentAjax"></div>

<main class="app-content">
    <div class="app-title">
        <form id="formRespaldo" name="formRespaldo" class="form-horizontal" style="width: 50%; margin: 0 auto;">
            <h1><i class="fas fa-user-md"></i> <?= $data['Titulo_pagina']; ?></h1>
        <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtFecha">Desde:</label>
              <input class="form-control" id="txtHasta" name="txtFecha" type="date" placeholder="Seleccionar fecha">
            </div>
            <div class="form-group col-md-6">
              <label for="txtFecha">Hasta:</label>
              <input class="form-control" id="txtHasta" name="txtFecha" type="date" placeholder="Seleccionar fecha">
            </div>
        </div>
        <br></br>
        <div class="tile-footer">
          <button id="btnActionForm" class="btn btn-primary" type="submit" onClick="fntGenerarRespaldo();"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Generar Respaldo</span></button>&nbsp;&nbsp;&nbsp;
        </div>
        </form>
      </div>
    </main>
    
 <?php footer_admin($data); ?>