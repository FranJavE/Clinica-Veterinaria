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


<table class="table table-ligth" id="t_historial_v">
    <thead class="thead-dark">
          <tr>
            <th></th>
            <th>Total</th>
            <th>Fecha venta</th>
            <th>Acciones</th>
          </tr>
    </thead>
    <tbody>
    </tbody>
</table>
        
    
 <?php footer_admin($data); ?>
    