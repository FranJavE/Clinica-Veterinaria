<?php

	// Incluye la biblioteca DOMPDF
	include "../../conex.php";
	require_once '../../Libraries/pdf/vendor/autoload.php';
	use Dompdf\Dompdf;
	// Crea una instancia de DOMPDF
	$dompdf = new Dompdf();
	$whereEspecie = "";
	$whereRaza = "";
	$whereDuenio = "";
	$ordernarBy = " ";


 	if (!empty($_GET['especie'])) {
		$especie = $_GET['especie'];
		if ($especie > 0) {
			$whereEspecie = "AND  r.id_especie = " .$especie;
		}
	}

	if (!empty($_GET['raza'])) {
		$raza = $_GET['raza'];
		$whereRaza = "AND m.id_raza = " .$raza;
	}

	if (!empty($_GET['duenio'])) {
		$duenio = $_GET['duenio'];
		$whereDuenio = "AND p.id_persona = " .$duenio;
	}

	if (!empty($_GET['ordernarPor'])) {
		$ordernarPor = $_GET['ordernarPor'];
		if ($ordernarPor == 1) {
			$ordernarBy = "ORDER BY m.Nombre, Dueño, NombreEspecie, NombreRaza, Peso, Altura";
		} else if ($ordernarPor == 2) {
			$ordernarBy = "ORDER BY NombreRaza, m.Nombre, Dueño, NombreEspecie, Peso, Altura";
		} else if ($ordernarPor == 3) {
			$ordernarBy = "ORDER BY NombreEspecie, NombreRaza, m.Nombre, Dueño, Peso, Altura";
		} else if ($ordernarPor == 4) {
			$ordernarBy = "ORDER BY Peso, m.Nombre, Dueño, NombreEspecie, NombreRaza, Altura";
		} else if ($ordernarPor == 5) {
			$ordernarBy = "ORDER BY Altura, m.Nombre, Dueño, NombreEspecie, NombreRaza, Peso";
		}
	}

	$query = mysqli_query($conecction,"SELECT m.id_mascota,m.Nombre,r.NombreRaza,e.NombreEspecie,m.Peso,m.Altura,
                concat(p.Nombre,' ', p.Apellido) as 'Dueño',m.status
                From tbl_mascota m 
                INNER JOIN tbl_persona p
                on m.id_persona  = p.id_persona
                INNER JOIN tbl_raza r 
                on m.id_raza = r.id_raza
                INNER JOIN tbl_especie e
                on r.id_especie = e.id_especie
                where m.status != 0
				$whereEspecie
				$whereRaza
				$whereDuenio
				$ordernarBy
");

	$result = mysqli_num_rows($query);
	if ($result >= 0) {
		ob_start();
		include(dirname('__FILE__').'/reporte_informe_mascotas.php');
		$html = ob_get_clean();

		// instantiate and use the dompdf class
		$dompdf = new Dompdf();

		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter', 'portrait');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream('Informe de mascotas.pdf',array('Attachment'=>0));
		exit;
	}

?>