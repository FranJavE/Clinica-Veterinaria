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
	$whereVacuna = "";
	$ordernarBy = " ";


	if (!empty($_GET['idMascota'])) {
		$mascota = $_GET['idMascota'];
		if ($mascota > 0) {
			$whereMascota = "AND  m.id_mascota = " .$mascota;
		}
	}

    
	if (!empty($_GET['tipoVacuna'])) {
		$tipoVacuna = $_GET['tipoVacuna'];
		if ($tipoVacuna > 0) {
			$whereVacuna = "AND vm.id_Vacunacion = " .$tipoVacuna;
		}
	}

	if (!empty($_GET['fecha'])) {
		$fecha = $_GET['fecha'];
		$whereFecha = "AND vm.fechaVacunacion = '" .$fecha."'";
	}

	if (!empty($_GET['Hora'])) {
		$Hora = $_GET['Hora'];
		$whereHora = "AND vm.Hora = " .$Hora;
	}

	if (!empty($_GET['ordernarPor'])) {
		$ordernarPor = $_GET['ordernarPor'];
		if ($ordernarPor == 1) {
			$ordernarBy = "ORDER BY Dueño, NombreMascota, NombreVacuna, fechaVacunacion DESC, Hora";
		} else if ($ordernarPor == 2) {
			$ordernarBy = "ORDER BY NombreMascota ASC, Dueño, NombreVacuna , fechaVacunacion DESC, Hora";
		} else if ($ordernarPor == 3) {
			$ordernarBy = "ORDER BY fechaVacunacion DESC, Dueño, NombreMascota,NombreVacuna, Hora";
		} else if ($ordernarPor == 4) {
			$ordernarBy = "ORDER BY fechaVacunacion ASC, Dueño, NombreMascota, NombreVacuna, Hora";
		} else if ($ordernarPor == 5) {
			$ordernarBy = "ORDER BY NombreVacuna, Dueño, NombreMascota, fechaVacunacion DESC, Hora";
		}
	}



	$query = mysqli_query($conecction,"SELECT vm.id_VacunacionXMascota,concat(p.Nombre,' ', p.Apellido) as 'Dueño',
         m.Nombre as 'NombreMascota', e.NombreEspecie,v.NombreVacuna, vm.Descripcion, vm.fechaVacunacion,vm.Hora,vm.Precio ,vm.status
                FROM tbl_vacunaxmascota vm
                INNER JOIN tbl_mascota m
                ON vm.id_mascota = m.id_mascota
                INNER JOIN tbl_persona p 
                ON p.id_persona = m.id_persona
                INNER JOIN tbl_raza r 
                ON r.id_raza = m.id_raza
                INNER JOIN tbl_especie e 
                ON e.id_especie = r.id_especie
                INNER JOIN tbl_vacunacion v 
                ON v.id_Vacunacion = vm.id_Vacunacion
                where vm.status != 0
				$whereMascota
                $whereVacuna
				$whereFecha
				$whereHora
				$ordernarBy
");

	$result = mysqli_num_rows($query);
	if ($result >= 0) {
		ob_start();
		include(dirname('__FILE__').'/reporte_informe_vacunas.php');
		$html = ob_get_clean();

		// instantiate and use the dompdf class
		$dompdf = new Dompdf();

		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter', 'portrait');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream('Informe de vacunas.pdf',array('Attachment'=>0));
		exit;
	}

?>