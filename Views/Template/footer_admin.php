 <?php 
 //Lo tomaremos desde donde inician los scrip?>

<!--  obtebnemos la ruta raiz para implementarla en los scripts de javascript -->
<script >
     
    const base_url= "<?= base_url(); ?>";
</script>
  <!-- Essential javascripts for application to work-->

    <script src="<?= media();?>/JS/jquery-3.3.1.min.js"></script> 
    <script src="<?= media();?>/JS/popper.min.js"></script> 
    <script src="<?= media();?>/JS/bootstrap.min.js"></script>
    <script src="<?= media();?>/JS/main.js"></script>
    <script src="<?= media();?>/JS/fontawesome.js"></script>
    <script src="<?= media();?>/JS/function_admin.js"></script>
   
   <script type="text/javascript" src="<?= media();?>/JS/plugins/sweetalert.min.js"></script>
   <script type="text/javascript" src="<?= media();?>/JS/tinymce/tinymce.min.js"></script>
    <!-- The javascript plugin to display page loading on top-->
      <script src="<?= media();?>/JS/plugins/pace.min.js"></script>
     <script type="text/javascript" src="<?= media();?>/JS/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?= media();?>/JS/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript" src="<?= media();?>/JS/plugins/bootstrap-select.min.js"></script>
      <!-- Importados para en exportar usuarios a Excel, pdf and csv -->
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script>

     <script type="text/javascript" src="<?= media();?>/js/function_admin.js"></script>
       <script src="<?= media(); ?>/JS/<?= $data['page_functions_js']; ?>"></script>
       
      </body>
    </script>