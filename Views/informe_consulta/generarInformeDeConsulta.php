<?php

	// Incluye la biblioteca DOMPDF
	include "../../conex.php";
	require_once '../../Libraries/pdf/vendor/autoload.php';
	use Dompdf\Dompdf;
	// Crea una instancia de DOMPDF
	$dompdf = new Dompdf();
	$whereMascota = "";
	$whereFecha = "";
	$whereHora = "";
	$ordernarBy = " ";


	if (!empty($_GET['idMascota'])) {
		$mascota = $_GET['idMascota'];
		if ($mascota > 0) {
			$whereMascota = "AND  m.id_mascota = " .$mascota;
		}
	}

	if (!empty($_GET['fecha'])) {
		$fecha = $_GET['fecha'];
		$whereFecha = "AND  c.fechaconsulta = '" .$fecha ."'";
	}

	if (!empty($_GET['hora'])) {
		$hora = $_GET['hora'];
		$whereHora = "AND  c.hora = " .$hora;
	}

	if (!empty($_GET['ordernarPor'])) {
		$ordernarPor = $_GET['ordernarPor'];
		if ($ordernarPor == 1) {
			$ordernarBy = "ORDER BY Dueño, NombreMascota, fechaconsulta DESC, hora";
		} else if ($ordernarPor == 2) {
			$ordernarBy = "ORDER BY NombreMascota ASC, Dueño , fechaconsulta DESC, hora";
		} else if ($ordernarPor == 3) {
			$ordernarBy = "ORDER BY fechaconsulta DESC, Dueño, NombreMascota, hora";
		} else if ($ordernarPor == 4) {
			$ordernarBy = "ORDER BY fechaconsulta ASC, Dueño, NombreMascota, hora";
		}
	}



	$query = mysqli_query($conecction,"SELECT c.id_Consulta,concat(p.Nombre,' ', p.Apellido) as 'Dueño', m.Nombre as 'NombreMascota',
	            me.NombreMedico, e.NombreEspecie,r.NombreRaza, c.Descripcion, c.fechaconsulta, c.hora,c.Precio,
	            c.status,me.id_medico, m.id_mascota, p.id_persona, m.Peso, m.Altura,p.identificacion,p.Direccion,p.Telefono,p.email_user
				FROM tbl_consultas c
				INNER JOIN tbl_mascota m
				ON c.id_mascota = m.id_mascota
				INNER JOIN tbl_persona p 
				ON p.id_persona = m.id_persona
				INNER JOIN tbl_raza r 
				ON r.id_raza = m.id_raza
				INNER JOIN tbl_especie e 
				ON e.id_especie = r.id_especie
                INNER JOIN tbl_medico me 
                ON me.id_medico = c.id_medico
				where c.status != 0
				$whereMascota
				$whereFecha
				$whereHora
				$ordernarBy
");

	$result = mysqli_num_rows($query);
	if ($result >= 0) {
		ob_start();
		include(dirname('__FILE__').'/reporte_informe_consulta.php');
		$html = ob_get_clean();

		// instantiate and use the dompdf class
		$dompdf = new Dompdf();

		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter', 'portrait');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream('Informe de consulta.pdf',array('Attachment'=>0));
		exit;
	}

?>