<?php 
    header_admin($data); 
    getModal('modalProductos',$data);
?>
    <main class="app-content">
      <div class="app-title">
        <div>
            <h1><i class="fas fa-box"></i> <?= $data['Titulo_pagina']; ?>
              <?php if($_SESSION['PermisosMod']['w']){ ?>
                <button class="btn btn-primary" type="button" onclick="openModal();" ><i class="fas fa-plus-circle"></i> Nuevo</button>
              <?php } ?> 
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/Productos"><?= $data['Titulo_pagina']; ?></a></li>
        </ul>
      </div>
        <div class="row">
            <div class="col-md-12">
              <div class="tile">
                <div class="tile-body">
                  <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="tableProductos">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Código</th>
                          <th>Nombre</th>
                          <th>Stock</th>
                          <th>Precio</th>
                          <th>Estado</th>
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
        </div>
    </main>
    
 <?php footer_admin($data); ?>
    