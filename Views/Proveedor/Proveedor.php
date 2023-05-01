<?php 
   header_admin($data); 
   getModal('ModalProveedor',$data);
?>
   <div id= "contentAjax"></div>
    <main class="app-content">
      <div class="app-title">
        <div>
            <h1><i class="fas fa-user-tag"></i> <?= $data['Titulo_pagina']; ?>
              <?php 
              if($_SESSION['PermisosMod']['w']){
             ?>
                <button class="btn btn-primary" type="button" onclick="openModal();" ><i class="fas fa-plus-circle"></i> Nuevo</button>
              <?php } ?>
            </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="<?= base_url(); ?>/Citas"><?= $data['Titulo_pagina']; ?></a></li>
        </ul>


      </div>
       <div class="row">
          <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tableProveedor">
                  <thead>
                    <tr>
                      <th>Identificacion</th>
                      <th>Nombres</th>
                      <th>Apellidos</th>
                      <th>Email</th>
                      <th>Telefono</th>
                      <th>Direccion</th>
                      <th>Empresa</th>
                      <th>Estado</th>
                      <th>Acciones</th>
                    </tr>
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