<?php

	// Incluye la biblioteca DOMPDF
	include "../../conex.php";
	require_once '../../Libraries/pdf/vendor/autoload.php';
	use Dompdf\Dompdf;
	// Crea una instancia de DOMPDF
	$dompdf = new Dompdf();
	$whereproducto = "";
	$wherecliente = "";
	$ordernarBy = " ";


	if (!empty($_GET['cliente'])) {
		$cliente = $_GET['cliente'];
		$wherecliente = "AND tbl_persona.id_persona = " .$cliente;
	}

    if (!empty($_GET['producto'])) {
		$producto = $_GET['producto'];
		$whereproducto = "AND tbl_venta_detalle.id_producto  = " .$producto;
	}


	if (!empty($_GET['ordernarPor'])) {
		$ordernarPor = $_GET['ordernarPor'];
		if ($ordernarPor == 1) {
			$ordernarBy = "ORDER BY cliente, Nombre_producto";
		} else if ($ordernarPor == 2) {
			$ordernarBy = "ORDER BY Nombre_producto, cliente";
		} else if ($ordernarPor == 3) {
			$ordernarBy = "ORDER BY precio_total ASC, Nombre_producto, cliente";
		} else if ($ordernarPor == 4) {
			$ordernarBy = "ORDER BY precio_total DESC, Nombre_producto, cliente";
		}
	}

	$query = mysqli_query($conecction," SELECT concat(tbl_persona.Nombre,' ', tbl_persona.Apellido) as 'cliente', SUM(tbl_venta_detalle.sub_total) AS precio_total,
        SUM(tbl_venta_detalle.cantidad) AS cantidad, CONCAT_WS (', ', tbl_producto.Nombre_producto) AS Nombre_producto
        FROM tbl_ventas 
        INNER JOIN tbl_venta_detalle ON tbl_ventas.id = tbl_venta_detalle.id_venta 
        INNER JOIN tbl_producto ON tbl_producto.id_producto = tbl_venta_detalle.id_producto 
        INNER JOIN tbl_persona ON tbl_persona.id_persona = tbl_ventas.id_cliente
        WHERE sub_total > 0
        $wherecliente
		$whereproducto
        GROUP BY tbl_ventas.id
        $ordernarBy");

	$result = mysqli_num_rows($query);
	if ($result >= 0) {
		ob_start();
		include(dirname('__FILE__').'/reporte_informe_ventas.php');
		$html = ob_get_clean();

		// instantiate and use the dompdf class
		$dompdf = new Dompdf();

		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter', 'portrait');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream('Informe de ventas.pdf',array('Attachment'=>0));
		exit;
	}

?>