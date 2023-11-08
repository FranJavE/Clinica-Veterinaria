
<?php 
   header_admin($data); 
?>
<div id="contentAjax"></div>

<main class="app-content">
    <div class="app-title">
        <form id="fomVentas" name="fomVentas" class="form-horizontal" style="width: 50%; margin: 0 auto;">
        <h1><i class="fas fa-user-md"></i> <?= $data['Titulo_pagina']; ?></h1>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="listDuenoId">Cliente</label>
                <select class="form-control" data-live-search="true" id="listDuenoId" name="listDuenoId">
                </select>
                <label for="listProductoId">Poducto</label>
                <select class="form-control" data-live-search="true" id="listProductoId" name="listProductoId">
                </select>
            </div>
            <div class="form-group col-md-6">
            <label for="ordernarPor">Odernar Por: <span class="required">*</span></label>
            <select class="form-control" data-live-search="true" id="ordernarPor" name="ordernarPor">
                <option value="1">Cliente</option>
                <option value="2">Poducto</option>
                <option value="3">Mayor cantidad</option>
                <option value="4">Menor cantidad</option>
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