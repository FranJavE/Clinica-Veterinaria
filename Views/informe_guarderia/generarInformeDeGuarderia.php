<?php

	// Incluye la biblioteca DOMPDF
	include "../../conex.php";
	require_once '../../Libraries/pdf/vendor/autoload.php';
	use Dompdf\Dompdf;
	// Crea una instancia de DOMPDF
	$dompdf = new Dompdf();
	$whereMascota = "";
	$whereFechaLlegada = "";
	$whereHoraLlegada = "";
	$whereFechaSalida = "";
	$whereHoraSalida = "";
	$whereJaula = "";
	$ordernarBy = " ";


	if (!empty($_GET['idMascota'])) {
		$mascota = $_GET['idMascota'];
		if ($mascota > 0) {
			$whereMascota = "AND  m.id_mascota = " .$mascota;
		}
	}

	if (!empty($_GET['fechaLlegada'])) {
		$fechaLlegada = $_GET['fechaLlegada'];
		$whereFechaLlegada = "AND g.fechainicio = " .$fechaLlegada;
	}

	if (!empty($_GET['horaLlegada'])) {
		$horaLlegada = $_GET['horaLlegada'];
		$whereHoraLlegada = "AND g.Hora_lnicio = " .$horaLlegada;
	}

	if (!empty($_GET['fechaSalida'])) {
		$fechaSalida = $_GET['fechaSalida'];
		$whereFechaSalida = "AND g.fechafin = " .$fechaSalida;
	}

	if (!empty($_GET['horaSalida'])) {
		$horaSalida = $_GET['horaSalida'];
		$whereHoraSalida = "AND g.Hora_salida = " .$horaSalida;
	}

	if (!empty($_GET['jaula'])) {
		$jaula = $_GET['jaula'];
		if ($jaula > 0) {
			$whereJaula = "AND  g.Numero_Jaula = " .$jaula;
		}
	}

	if (!empty($_GET['ordernarPor'])) {
		$ordernarPor = $_GET['ordernarPor'];
		if ($ordernarPor == 1) {
			$ordernarBy = "ORDER BY Dueño, NombreMascota, fechainicio DESC, Hora_lnicio";
		} else if ($ordernarPor == 2) {
			$ordernarBy = "ORDER BY NombreMascota ASC, Dueño , fechainicio DESC, Hora_lnicio";
		} else if ($ordernarPor == 3) {
			$ordernarBy = "ORDER BY Numero_Jaula, NombreMascota, Dueño,  fechainicio DESC, Hora_lnicio";
		}
	}



	$query = mysqli_query($conecction,"SELECT g.id_guarderia,concat(p.Nombre,' ', p.Apellido) as 'Dueño', m.Nombre as 'NombreMascota', 
				e.NombreEspecie, g.Descripcion, g.fechainicio,g.Hora_lnicio,(jaula.numero_jaula) AS Numero_Jaula,g.Precio, fechafin,Hora_salida ,g.status
				FROM tbl_guarderia g
				INNER JOIN tbl_mascota m
				ON g.id_mascota = m.id_mascota
				INNER JOIN tbl_persona p 
				ON p.id_persona = m.id_persona
				INNER JOIN tbl_raza r 
				ON r.id_raza = m.id_raza
				INNER JOIN tbl_especie e 
				ON e.id_especie = r.id_especie
				INNER JOIN tbl_jaula jaula
				ON g.id_jaula = jaula.id_jaula
				where g.status != 0
				$whereMascota
				$whereFechaLlegada
				$whereHoraLlegada
				$whereFechaSalida
				$whereHoraSalida
				$whereJaula
				$ordernarBy
");

	$result = mysqli_num_rows($query);
	if ($result >= 0) {
		ob_start();
		include(dirname('__FILE__').'/reporte_informe_guarderia.php');
		$html = ob_get_clean();

		// instantiate and use the dompdf class
		$dompdf = new Dompdf();

		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter', 'portrait');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream('Informe de guarderia.pdf',array('Attachment'=>0));
		exit;
	}

?>