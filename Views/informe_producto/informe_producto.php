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
                <label for="listCategoria">Categoría</label>
                <select class="form-control" data-live-search="true" id="listCategoria" name="listCategoria"></select>
            </div>
            <div class="form-group col-md-6">
                <label for="listProveedor">Proveedor</label>
                <select class="form-control" data-live-search="true" id="listProveedor" name="listProveedor"></select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="control-label">Precio mayor a:</label>
                <input class="form-control validNumber" id="txtPrecioMayor" name="txtPrecioMayor" type="text" required=""  onkeypress="return controlTag(event);">
            </div>
            <div class="form-group col-md-6">
                <label class="control-label">Precio menor a:</label>
                <input class="form-control validNumber" id="txtPrecioMenor" name="txtPrecioMenor" type="text" required=""  onkeypress="return controlTag(event);">
            </div>

        </div>
        <div  class="form-row">
            <div class="form-group col-md-6">
                <label for="ordernarPor">Odernar Por:</label>
                <select class="form-control" data-live-search="true" id="ordernarPor" name="ordernarPor">
                    <option value="1">Nombre Producto</option>
                    <option value="2">Código Producto</option>
                    <option value="3">Categoria</option>
                    <option value="4">Proveedor</option>
                    <option value="7">Stock</option>
                    <option value="5">Precio mayor</option>
                    <option value="6">Precio Menor</option>
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