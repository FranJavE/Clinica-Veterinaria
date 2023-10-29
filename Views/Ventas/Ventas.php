<?php 
    header_admin($data); 
    //getModal('modalProductos',$data);
?>
    <main class="app-content">
      <div class="app-title">
        <div>
            <h1><i class="fas fa-box"></i> <?= $data['Titulo_pagina']; ?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/Ventas"><?= $data['Titulo_pagina']; ?></a></li>
        </ul>
      </div>
      <div class="card">
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-md-4">
            <div class="form-group">
              <label for="cliente">Clientes Activos</label>
              <select id="cliente" class="form-control" name="cliente" onchange="habilitarBoton()">
    <option value="">Selecciona un cliente</option>
    <?php
    foreach ($data['clientes'] as $cliente) {
        echo "<option value='{$cliente['id_persona']}'>{$cliente['Nombre']} {$cliente['Apellido']}</option>";
    }
    ?>
</select>
            </div>
                </form>
            </div>
        </div>
        <div class="card">
          <div class="card-header bg-primary text-white">
            <h4>Nueva Venta</h4>
          </div>
            <div class="card-body">
                  <form id="frmVenta">
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="codigo">Código o Nombre</label>
                    <input type="hidden" id="id_producto" name="id_producto">
                    <input id="codigo" class="form-control" type="text" name="codigo" placeholder="Ingresa el código o nombre" onkeyup="buscarCodigo(event)">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="nombre">Descripción</label>
                    <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Descripción del Producto" disabled>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input id="cantidad" class="form-control" type="text" name="cantidad" placeholder="Cantidad" onkeyup="calcularPrecio(event)">
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input id="precio" class="form-control" type="text" name="precio" placeholder="Precio" disabled>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="form-group">
                    <label for="sub_total">Sub Total</label>
                    <input id="sub_total" class="form-control" type="text" name="sub_total" placeholder="Sub Total" disabled>
                </div>
            </div>
        </div>
    </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Sub Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tblDetalle">
                </tbody>
            </table>
            <div class="row">
              <div class="col-md-4 ml-auto">
                <div class="form-group">
                    <label for="total" class="font-weight-bold">Total a pagar</label>
                    <input id="total" class="form-control" type="text" name="total" placeholder="Total a pagar" disabled>
                    <button class="btn btn-primary mt-2 btn-block" type="button" onclick="generarVenta()" id="botonGenerarVenta" disabled>Generar Venta</button>
             </div>
        </div>
    </div>

</div>
    </main>
    
 <?php footer_admin($data); ?>
    