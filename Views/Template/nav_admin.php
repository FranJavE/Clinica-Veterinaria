 <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="<?= media();?>/Images/avatar.png" alt="User Image">
        <div>
          <p class="app-sidebar__user-name"><?= $_SESSION['userData']['Nombre_Completo']; ?></p>
          <p class="app-sidebar__user-designation"><?= $_SESSION['userData']['NombreRol']; ?></p>
        </div> 
      </div>
      <ul class="app-menu">
        <?php if(!empty($_SESSION['permisos'][1]['r'])){?>
        <li><a class="app-menu__item" href="Dashboard"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Inicio</span></a></li>
      <?php } ?>

<!------------------------------------------------------------------------ Menu Usuario ---------------------------------------------------->
       <?php if(!empty($_SESSION['permisos'][2]['r'])){?>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-user" aria-hidden="true"></i><span class="app-menu__label">Usuario</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
           
            <li><a class="treeview-item" href="<?= base_url();?>/Usuarios"><i class="icon fa fa-circle-o"></i>Usuario</a></li>
            <li><a class="treeview-item" href="<?= base_url();?>/Roles"><i class="icon fa fa-circle-o"></i> Roles</a></li>
            
          </ul>
        </li>
        <?php } ?>
<!------------------------------------------------------------------------ Menu Usuario ---------------------------------------------------->
<!------------------------------------------------------------------------ Menu Catalogos ---------------------------------------------------->
<?php if(!empty($_SESSION['permisos'][12]['r'])){?>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-file-alt" aria-hidden="true"></i><span class="app-menu__label">Catalogos</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
           
            <li><a class="treeview-item" href="<?= base_url();?>/Especies"><i class="icon fa fa-circle-o"></i>Especies</a></li>
            <li><a class="treeview-item" href="<?= base_url();?>/Razas"><i class="icon fa fa-circle-o"></i>Razas</a></li>
            <li><a class="treeview-item" href="<?= base_url();?>/Jaulas"><i class="icon fa fa-circle-o"></i>Jaulas</a></li>
            <li><a class="treeview-item" href="<?= base_url();?>/Categorias"><i class="icon fa fa-circle-o"></i>Categorias</a></li>
            <li><a class="treeview-item" href="<?= base_url();?>/Proveedor"><i class="icon fa fa-circle-o"></i>Proveedor</a></li>
          </ul>
        </li>
        <?php } ?>
<!------------------------------------------------------------------------ Menu Catalogos ---------------------------------------------------->
<!------------------------------------------------------------------------ Menu Cliente ---------------------------------------------------->
      <?php if(!empty($_SESSION['permisos'][9]['r'])){?>
<!--         <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users" aria-hidden="true"></i><span class="app-menu__label">Clientes</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?= base_url();?>/Clientes"><i class="icon fa fa-circle-o"></i>Clientes</a></li>
          </ul>
        </li> -->
        <li><a class="app-menu__item" href="<?= base_url();?>/Clientes"><i class="app-menu__icon fas fa-male" aria-hidden="true"></i><span class="app-menu__label">Clientes</span></a>

        <?php } ?>
<!------------------------------------------------------------------------ Menu Clientes ---------------------------------------------------->
<!------------------------------------------------------------------------ Menu Mascotas ---------------------------------------------------->
        
        <?php if(!empty($_SESSION['permisos'][3]['r'])){?>
<!--         <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-paw" aria-hidden="true"></i><span class="app-menu__label">Mascotas</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?= base_url();?>/Mascotas"><i class="icon fa fa-circle-o"></i>Mascotas</a></li>
          </ul>
        </li> -->
        <li><a class="app-menu__item" href="<?= base_url();?>/Mascotas"><i class="app-menu__icon fa fa-paw" aria-hidden="true"></i><span class="app-menu__label">Mascotas</span></a>

        <?php } ?>
<!------------------------------------------------------------------------ Menu Mascotas ---------------------------------------------------->
<!------------------------------------------------------------------------ Menu cita ---------------------------------------------------->
        
        <?php if(!empty($_SESSION['permisos'][4]['r'])){?>
<!--         <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-book" ></i><span class="app-menu__label">Citas</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?= base_url();?>/Citas"><i class="icon fa fa-circle-o"></i>Citas</a></li>
          </ul>
        </li> -->
        <li><a class="app-menu__item" href="<?= base_url();?>/Citas"><i class="app-menu__icon fas fa-book" aria-hidden="true"></i><span class="app-menu__label">Citas</span></a>

        <?php } ?>
<!------------------------------------------------------------------------ Menu citas ---------------------------------------------------->
<!------------------------------------------------------------------------ Menu consultas ---------------------------------------------------->
        
        <?php if(!empty($_SESSION['permisos'][5]['r'])){?>
<!--          <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-book" ></i><span class="app-menu__label">Consultas</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
             <li><a class="treeview-item" href="<?= base_url();?>/Tratamientos"><i class="icon fa fa-circle-o"></i>Tratamientos</a></li>
            <li><a class="treeview-item" href="<?= base_url();?>/Consultas"><i class="icon fa fa-circle-o"></i>Consultas</a></li>
          </ul>
        </li> -->
        <li><a class="app-menu__item" href="<?= base_url();?>/Consultas"><i class="app-menu__icon icon fas fa-stethoscope" aria-hidden="true"></i><span class="app-menu__label">Consultas</span></a>

        <?php } ?>
<!------------------------------------------------------------------------ Menu Consultas ---------------------------------------------------->
<!------------------------------------------------------------------------ Menu Vacunas ---------------------------------------------------->
      <?php if(!empty($_SESSION['permisos'][6]['r'])){?>
<!--         <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-syringe"></i><span class="app-menu__label">Vacunas</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
             <li><a class="treeview-item" href="<?= base_url();?>/Vacunas"><i class="icon fa fa-circle-o"></i>Vacunas</a></li>
          
          </ul>
        </li> -->
        <li><a class="app-menu__item" href="<?= base_url();?>/Vacunas"><i class="app-menu__icon fas fa-syringe" aria-hidden="true"></i><span class="app-menu__label">Vacunas</span></a>

        <?php } ?>
<!------------------------------------------------------------------------ Menu Vacunas ---------------------------------------------------->
<!------------------------------------------------------------------------ Menu Medico ---------------------------------------------------->
        
        <?php if(!empty($_SESSION['permisos'][7]['r'])){?>
<!--         <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-user-md"></i><span class="app-menu__label">Medicos</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
             <li><a class="treeview-item" href="<?= base_url();?>/Medicos"><i class="icon fa fa-circle-o"></i>Medicos</a></li>
          
          </ul>
        </li> -->
        <li><a class="app-menu__item" href="<?= base_url();?>/Medicos"><i class="app-menu__icon fas fa-user-md" aria-hidden="true"></i><span class="app-menu__label">Medicos</span></a>

        <?php } ?>
<!------------------------------------------------------------------------ Menu Medico ---------------------------------------------------->

<!------------------------------------------------------------------------ Menu Guarderia ---------------------------------------------------->
        
        <?php if(!empty($_SESSION['permisos'][8]['r'])){?>
<!--               <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-house-damage"></i><span class="app-menu__label">Guarderia</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?= base_url();?>/Guarderia"><i class="icon fa fa-circle-o"></i>Guarderia</a></li>
          </ul>
        </li> -->
        <li><a class="app-menu__item" href="<?= base_url();?>/Guarderia"><i class="app-menu__icon fas fa-house-damage" aria-hidden="true"></i><span class="app-menu__label">Guarderia</span></a>

        <?php } ?>
       <!------------------------------------------------------------------------ Menu Guarderia ---------------------------------------------------->
<!------------------------------------------------------------------------ Menu Productos ---------------------------------------------------->
        
        <?php if(!empty($_SESSION['permisos'][11]['r'])){?>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-shopping-cart" aria-hidden="true"></i><span class="app-menu__label">Tienda</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?= base_url();?>/Productos"><i class="icon fa fa-circle-o"></i>Productos</a></li>
            <li><a class="treeview-item" href="<?= base_url();?>/Ventas"><i class="icon fa fa-circle-o"></i>Ventas</a></li>
            <li><a class="treeview-item" href="<?= base_url();?>/historial"><i class="icon fa fa-circle-o"></i>historial</a></li>
          </li>
          </ul>
        </li>
        <?php } ?>
<!------------------------------------------------------------------------ Menu Productos ---------------------------------------------------->

<!------------------------------------------------------------------------ Menu Registro Clinico ---------------------------------------------------->
      
      <?php if(!empty($_SESSION['permisos'][10]['r'])){?>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-folder-o" aria-hidden="true"></i><span class="app-menu__label">Registro Clinico</span><i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item" href="<?= base_url();?>/informe_consulta"><i class="icon fa fa-circle-o"></i>Informe de consultas</a></li>
            <li><a class="treeview-item" href="<?= base_url();?>/informe_vacunas"><i class="icon fa fa-circle-o"></i>Informe de vacunas</a></li>
            <li><a class="treeview-item" href="<?= base_url();?>/informe_guarderia"><i class="icon fa fa-circle-o"></i>Informe de guarderia</a></li>
            <li><a class="treeview-item" href="<?= base_url();?>/informe_ventas"><i class="icon fa fa-circle-o"></i>Informe de ventas</a></li>
            <li><a class="treeview-item" href="<?= base_url();?>/informe_mascotas"><i class="icon fa fa-circle-o"></i>Informe Mascotas</a></li>
            <li><a class="treeview-item" href="<?= base_url();?>/informe_producto"><i class="icon fa fa-circle-o"></i>Informe de Producto</a></li>
          </ul>
        </li>
        <?php } ?>
<!------------------------------------------------------------------------ Menu Productos ---------------------------------------------------->

<!---------------------------------------------------------------------- Salir ---------------------------------------------------->
 <li><a class="app-menu__item" href="<?= base_url();?>/Logout?>
<?= $_SESSION['userData']['NombreRol']; ?>"><i class="app-menu__icon fas fa-sign-out-alt"></i><span class="app-menu__label">Salir</span></a></li>
      </ul>
       </aside>