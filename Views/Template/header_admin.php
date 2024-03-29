 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Veterinaria 'El Gato'">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media();  ?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= media();  ?>/css/style.css">
      <!-----------------Metas agregados------------->
    <meta name="author" content="Frank Aguilar">
     <meta name="theme-color" content="#673AB7">

    <!---------------------FIN---------------------->
    <title><?= $data['Etiqueta_Pagina'];?></title>
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/CSS/main.css">
    
        <link rel="stylesheet" type="text/css" href="<?= media(); ?>/CSS/bootstrap-select.min.css">
    <!-- --------------------------->
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/CSS/style.css">
    <!--------------------------- -->
    
  </head>
  <body class="app sidebar-mini" bgcolor="#673AB7">
         <div id="divLoading">
          <div>
            <img src="<?= media(); ?>/Images/loading.svg" alt="Loading">
          </div>
        </div>
    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="<?= base_url();?>/Dashboard">Clinica Veterinaria</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"><i class="fas fa-bars"></i></a>
      <!-- Navbar Right Menu-->
      <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li><a class="dropdown-item" href="<?= base_url();?>/Respaldos/Respaldos"><i class="fa fa-cog fa-lg"></i> Respaldo</a></li>
            <li><a class="dropdown-item" href="<?= base_url();?>/Usuarios/Perfil"><i class="fa fa-user fa-lg"></i> Profile</a></li>
            <li><a class="dropdown-item" href="#" id="btnDescargarWord"><i class="fa fa-file-word fa-lg"></i> Descargar Manual</a></li>
            <li><a class="dropdown-item" href="<?= base_url();?>/Logout"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
          </ul>
        </li>
      </ul>
    </header>
    <?php require_once("nav_admin.php"); ?>
   

    <script>
  document.getElementById('btnDescargarWord').addEventListener('click', function() {
    // Lógica para descargar el archivo Word
    descargarWord();
  });

  function descargarWord() {
    // Ruta relativa del archivo Word en tu proyecto
    var rutaArchivoWord = 'Assets/Images/manual_usuario.docx';

    // Obtén la ruta completa del archivo
    var urlArchivoWord = window.location.origin + '/' + rutaArchivoWord;

    // Crea un enlace 'a' para descargar el archivo
    var a = document.createElement('a');
    a.href = urlArchivoWord;
    a.download = 'manual_usuario.docx';

    // Agrega el enlace al DOM y simula un clic para iniciar la descarga
    document.body.appendChild(a);
    a.click();

    // Remueve el enlace del DOM después de la descarga
    document.body.removeChild(a);
  }
</script>
