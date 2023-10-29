<?php

	// Incluye la biblioteca DOMPDF
	include "../../conex.php";
	require_once '../../Libraries/pdf/vendor/autoload.php';
	use Dompdf\Dompdf;
	// Crea una instancia de DOMPDF
	$dompdf = new Dompdf();
	$whereCategoria = "";
	$whereProveedor = "";
	$wherePrecioMayor = "";
	$wherePrecioMenor = "";
	$ordernarBy = " ";


 	if (!empty($_GET['idCategoria'])) {
		$idCategoria = $_GET['idCategoria'];
		if ($idCategoria > 0) {
			$whereCategoria = "AND  p.id_categoria  = " .$idCategoria;
		}
	}

	if (!empty($_GET['idProveedor'])) {
		$idProveedor = $_GET['idProveedor'];
        if ($idProveedor > 0) {
			$whereProveedor = "AND p.id_proveedores  = " .$idProveedor;
		}
	}

	if (!empty($_GET['precioMayor'])) {
		$precioMayor = $_GET['precioMayor'];
		$wherePrecioMayor = "AND p.Precio >= " .$precioMayor;
	}

    if (!empty($_GET['PrecioMenor'])) {
		$PrecioMenor = $_GET['PrecioMenor'];
		$wherePrecioMenor = "AND p.Precio <= " .$PrecioMenor;
	}

	if (!empty($_GET['ordernarPor'])) {
		$ordernarPor = $_GET['ordernarPor'];
		if ($ordernarPor == 1) {
			$ordernarBy = "ORDER BY p.Nombre_producto, Codigo, categoria, Precio, stock, Nombre_proveedor";
		} else if ($ordernarPor == 2) {
			$ordernarBy = "ORDER BY Codigo, p.Nombre_producto, categoria, Precio, stock, Nombre_proveedor";
		} else if ($ordernarPor == 3) {
			$ordernarBy = "ORDER BY categoria, p.Nombre_producto, Codigo, Precio, stock, Nombre_proveedor";
		} else if ($ordernarPor == 4) {
			$ordernarBy = "ORDER BY Nombre_proveedor, p.Nombre_producto, Codigo, categoria, Precio, stock";
		} else if ($ordernarPor == 5) {
			$ordernarBy = "ORDER BY Precio DESC, p.Nombre_producto, Codigo, categoria, stock, Nombre_proveedor";
		} else if ($ordernarPor == 6) {
			$ordernarBy = "ORDER BY Precio ASC, p.Nombre_producto, Codigo, categoria, stock, Nombre_proveedor";
		} else if ($ordernarPor == 7) {
			$ordernarBy = "ORDER BY stock, p.Nombre_producto, Codigo, categoria, Precio, Nombre_proveedor";
		}
	}

	$query = mysqli_query($conecction,"SELECT p.id_producto,
                                                p.Codigo,
                                                p.Nombre_producto ,
                                                p.Descripcion ,
                                                p.id_categoria,
                                                c.nombre_categoria as categoria,
                                                p.Precio ,
                                                p.stock,
                                                p.status,
                                                p.id_proveedores,
                                                concat(pr.Nombre_proveedor,' ', pr.Apellido_Proveedor) as Nombre_proveedor
                                            FROM tbl_producto p 
                                            INNER JOIN tbl_categoria c
                                            ON p.id_categoria = c.id_categoria
                                            INNER JOIN tbl_proveedores pr 
					                        ON pr.id_proveedores = p.id_proveedores
                                            WHERE p.status != 0
                                            $whereCategoria
                                            $whereProveedor
                                            $wherePrecioMayor
                                            $wherePrecioMenor
                                            $ordernarBy
    ");

	$result = mysqli_num_rows($query);
	if ($result >= 0) {
		ob_start();
		include(dirname('__FILE__').'/reporte_informe_producto.php');
		$html = ob_get_clean();

		// instantiate and use the dompdf class
		$dompdf = new Dompdf();

		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter', 'portrait');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream('Informe de productos.pdf',array('Attachment'=>0));
		exit;
	}

?>