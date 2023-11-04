<?php header_admin($data); ?>

       <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Bienvenido a la clinica veterinaria El Gato</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
      </div>
      <div class="row">
        <?php if(!empty($_SESSION['permisos'][2]['r'])){?>
        <div class="col-md-6 col-lg-3">
          <a href="<?= base_url() ?>/Usuarios">
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-user"></i>
              <div class="info">
                <h4>Usuarios</h4>
                <p><b><?= $data['cantidadUsuarios']; ?></b></p>
              </div>
            </div>
          </a>
        </div>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][9]['r'])){?>
        <div class="col-md-6 col-lg-3">
          <a href="<?= base_url() ?>/Clientes">
            <div class="widget-small info coloured-icon"><i class="icon fas fa-male"></i>
              <div class="info">
                <h4>Clientes</h4>
                <p><b><?= $data['cantidadClientes']; ?></b></p>
              </div>
            </div>
          </a>
        </div>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][3]['r'])){?>
       <div class="col-md-6 col-lg-3">
          <a href="<?= base_url() ?>/Mascotas">
            <div class="widget-small danger coloured-icon"><i class="icon fas fa-dog"></i> 
              <div class="info">
                <h4>Mascotas</h4>
                <p><b><?= $data['cantidadMascotas']; ?></b></p>
              </div>
            </div>
          </a>
        </div>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][4]['r'])){?>
        <div class="col-md-6 col-lg-3">
          <a href="<?= base_url() ?>/Citas">
            <div class="widget-small warning coloured-icon"><i class="icon fas fa-book"></i>
              <div class="info">
                <h4>Citas</h4>
                <p><b><?= $data['cantidadCitas']; ?></b></p>
              </div>
            </div>
          </a>
        </div>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][8]['r'])){?>
        <div class="col-md-6 col-lg-3">
          <a href="<?= base_url() ?>/Guarderia">
            <div class="widget-small danger coloured-icon"><i class="icon fas fa-house-damage"></i>
              <div class="info">
                <h4>Guarderia</h4>
                <p><b><?= $data['cantidadGuarderia']; ?></b></p>
              </div>
            </div>
          </a>
        </div>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][11]['r'])){?>
        <div class="col-md-6 col-lg-3">
          <a href="<?= base_url() ?>/Productos">
            <div class="widget-small warning coloured-icon"><i class="icon fas fa-shopping-bag"></i>
              <div class="info">
                <h4>Productos</h4>
                <p><b><?= $data['cantidadProductos']; ?></b></p>
              </div>
            </div>
          </a>
        </div>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][5]['r'])){?>
          <div class="col-md-6 col-lg-3">
          <a href="<?= base_url() ?>/Consultas">
            <div class="widget-small primary coloured-icon"><i class="icon fas fa-stethoscope"></i>
              <div class="info">
                <h4>Consultas</h4>
                <p><b><?= $data['cantidadConsultas']; ?></b></p>
              </div>
            </div>
          </a>
        </div>
        <?php } ?>
        <?php if(!empty($_SESSION['permisos'][11]['r'])){?>
        <div class="col-md-6 col-lg-3">
          <a href="<?= base_url() ?>/Ventas">
            <div class="widget-small info coloured-icon"><i class="icon fas fa-shopping-cart"></i>
              <div class="info">
                <h4>Ventas</h4>
                <p><b><?= $data['cantidadVentas']; ?></b></p>
              </div>
            </div>
          </a>
        </div>
      </div>
      <?php } ?>

    </main>
 <?php footer_admin($data); ?>
