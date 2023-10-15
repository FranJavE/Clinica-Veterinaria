<?php 
   header_admin($data); 
   getModal('ModalCita',$data);
?>
   <div id= "contentAjax"></div>
    <main class="app-content">
      <div class="app-title">
        <div>
            <h1><i class="fas fa-calendar-check"></i> <?= $data['Titulo_pagina']; ?>
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
                <table class="table table-hover table-bordered" id="tableCitas" style="width: 100%;">
                  <thead>
                    <tr>
                      <th>Dueño</th>
                      <th>Paciente</th>
                      <th>Descripcion</th>
                      <th>Fecha</th>
                      <th>Hora</th>
                      <th>Dias que faltan</th>
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