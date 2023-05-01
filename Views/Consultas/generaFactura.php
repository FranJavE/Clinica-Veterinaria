<?php

	//print_r($_REQUEST);
	//exit;
	//echo base64_encode('2');
	//exit;
	session_start();
	if(empty($_SESSION['login']))
	{
		header('Location: '.base_url().'/login');
	}

	include "../../conex.php";
	require_once 'pdf/vendor/autoload.php';
	use Dompdf\Dompdf;

	if(empty($_REQUEST['ma']) || empty($_REQUEST['co']))
	{
		echo "No es posible generar la consulta.";
	}else{
		$idMascota = $_REQUEST['ma'];
		$idConsulta = $_REQUEST['co'];
		$anulada = '';

		/*$query_config   = mysqli_query($conection,0"SELECT * FROM configuracion");
		$result_config  = mysqli_num_rows($query_config);
		if($result_config > 0){
			$configuracion = mysqli_fetch_assoc($query_config);
		}*/


		$query = mysqli_query($conecction,"SELECT c.id_Consulta,concat(p.Nombre,' ', p.Apellido) as 'Dueño', m.Nombre as 'NombreMascota', me.NombreMedico, e.NombreEspecie,r.NombreRaza, c.Descripcion, c.fechaconsulta, c.hora, t.NombreTratamiento,c.Precio, c.status, t.id_tratamiento,me.id_medico, m.id_mascota, p.id_persona, m.Peso, m.Altura,p.identificacion,p.Direccion,p.Telefono,p.email_user
				FROM tbl_consultas c
				INNER JOIN tbl_mascota m
				ON c.id_mascota = m.id_mascota
				INNER JOIN tbl_persona p 
				ON p.id_persona = m.id_persona
				INNER JOIN tbl_raza r 
				ON r.id_raza = m.id_raza
				INNER JOIN tbl_especie e 
				ON e.id_especie = r.id_especie
				INNER JOIN tbl_tratamiento t 
				ON t.id_tratamiento = c.id_tratamiento
                INNER JOIN tbl_medico me 
                ON me.id_medico = c.id_medico
				where c.status != 0 and c.id_Consulta = $idConsulta and m.id_mascota = $idMascota");

		$result = mysqli_num_rows($query);
		if($result > 0){

			$configuracion  = mysqli_fetch_assoc($query);
			$no_consulta = $configuracion['id_Consulta'];
			//echo $no_consulta;

			/*$query_productos = mysqli_query($conection,"SELECT p.descripcion,dt.cantidad,dt.precio_venta,(dt.cantidad * dt.precio_venta) as precio_total
														FROM consulta f
														INNER JOIN detalleconsulta dt
														ON f.noconsulta = dt.noconsulta
														INNER JOIN producto p
														ON dt.codproducto = p.codproducto
														WHERE f.noconsulta = $no_consulta ");
			$result_detalle = mysqli_num_rows($query_productos);*/

			ob_start();
		    include(dirname('__FILE__').'/factura.php');
		    $html = ob_get_clean();

			// instantiate and use the dompdf class
			$dompdf = new Dompdf();

			$dompdf->loadHtml($html);
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('letter', 'portrait');
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream('consulta_'.$no_consulta.'.pdf',array('Attachment'=>0));
			exit;
		}
	}

?>