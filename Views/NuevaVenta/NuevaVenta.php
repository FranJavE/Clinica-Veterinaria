<?php 
   header_admin($data);
?>
   <div id= "contentAjax"></div>
    <main class="app-content">
      <div class="app-title">
        <div>
            <h1><i class="fas fa-cart-arrow-down"></i> <?= $data['Titulo_pagina']; ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/Vacunas"><?= $data['Titulo_pagina']; ?></a></li>
        </ul>
      </div>
      <div class="row">
        <div class="form-group col-md-6">
            <label for="listDuenoId">Cliente<span class="required">*</span></label>
            <select class="form-control" data-live-search="true" id="listDuenoId" name="listDuenoId" required >
            </select>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="txtFecha">Fecha Venta  <span class="required">*</span></label>
                <input class="form-control" id="txtFecha" name="txtFecha" type="date" placeholder="Seleccionar fecha" required="">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
            <label for="listProductoId">Producto  <span class="required">*</span></label>
            <select class="form-control" data-live-search="true" id="listProductoId" name="listProductoId" onchange="fntProductos();" required >
            </select>
        </div>
        </div> 
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="tablePrdocutosVentas">
                            <thead>
                                <tr>
                                <th>Producto</th> 
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Descuento</th>
                                <th>Precio total</th>
                                <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
    
 <?php footer_admin($data); ?>