<?php 
	class Ventas extends Controllers{
		public function __construct()
		{
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(4);
		}

		public function Ventas()
		{
			if(empty($_SESSION['PermisosMod']['r'])){
				header("Location:".base_url().'/Dashboard');
			}
			$data['Etiqueta_Pagina'] = "Ventas";
			$data['Titulo_pagina'] = "VENTAS <small>Tienda Virtual</small>";
			$data['Nombre_pagina'] = "ventas";
			$data['page_functions_js'] = "function_ventas.js";
			$data['clientes'] = $this->modelo->getNomClientes();
			$this->views->getViews($this, "Ventas", $data);
		}
		
		public function VentasClientes()
		{
			$data = $this->modelo->getNomClientes();
			$this->views->getViews($this,"Ventas",$data);
		}

        public function buscarCodigo($cod)
        {
            $data = $this->modelo->getProCod($cod);
            echo json_encode($data, JSON_UNESCAPED_UNICODE);
            die();
        }
        
		public function ingresar()
		{
			$id_producto = $_POST['id_producto'];
			$datos = $this->modelo->getProductos($id_producto);
			$id_producto = $datos['id_producto'];
			$idUsuario = $_SESSION['idUser'];
			$precio = $datos['Precio'];
			$cantidad = $_POST['cantidad'];
				$sub_total = $precio * $cantidad;
				try {
					$data = $this->modelo->registrarDetalles($id_producto, $idUsuario, $precio, $cantidad, $sub_total);
					$response = array("status" => "ok");
				} catch (Exception $e) {
					$response = array("status" => "error", "message" => $e->getMessage());
				}
			echo json_encode($response, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function listar()
		{   
			$idUsuario = $_SESSION['idUser'];
			$data['tbl_detalle_venta'] = $this->modelo->getDetalle($idUsuario);
			$data['sub_total'] = $this->modelo->calcularVenta($idUsuario);
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
			die();
		}

		public function delete($id)
		{
			$data = $this->modelo->deleteDetalle($id);
			if ($data  == 'ok') {
				$msg = 'ok';
			}else{
				$msg = 'error';
			}
			echo json_encode($msg);
			die();
		}

		public function registrarVenta($id_cliente)
		{
			$idUsuario = $_SESSION['idUser'];
			try {
				$total = $this->modelo->calcularVenta($idUsuario);
				$this->modelo->registrarVenta($id_cliente, $total['total']);
				$detalle = $this->modelo->getDetalle($idUsuario);
				$id_venta = $this->modelo->id_venta();
				foreach ($detalle as $row) {
					$cantidad = $row['cantidad'];
					$precio = $row['precio'];
					$id_pro = $row['id_producto'];
					$sub_total = $cantidad * $precio;
					$this->modelo->registrarDetalleVenta($id_venta['id'], $id_pro, $cantidad, $precio, $sub_total);
					$stock_actual = $this->modelo->getProductos($id_pro);
					$stock =  $stock_actual['stock'] - $cantidad;
					$this->modelo->actualizarStock($stock, $id_pro);
					$this->modelo->vaciarDetalle($idUsuario);
				}
				$response = [
					'status' => 'ok',
					'id_venta' => $id_venta['id']
				];
			} catch (Exception $e) {
				$response = [
					'status' => 'error',
					'message' => $e->getMessage()
				];
			}
		
			echo json_encode($response);
			die();
		}
		

		public function generarPdf($id_venta)
		{
			$id_venta = (int) $id_venta;
			$productos = $this->modelo->getProVenta($id_venta);
			$clientes = $this->modelo->getClientes($id_venta);
			
		
			require('Libraries/fpdf/fpdf.php');
		
			$pdf = new FPDF('P','mm', array(85, 200));
			$pdf->AddPage();
			$pdf->SetMargins(2, 0, 0);
			// $pdf->Image('Assets/Images/logoVeterina.png', 10, 10, 40);
		
			// Encabezado
			$pdf->SetFont('Arial', 'B', 12);
			$pdf->Cell(60, 10, utf8_decode('Clinica Veterinaria El Gato'), 0, 1, 'C');
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(60, 10, utf8_decode('Telefono: +505 5824 5488'), 0, 1, 'C');
			$pdf->Cell(60, 0, utf8_decode('Dirección: Barrio Central, contiguo'), 0, 1, 'C');
			$pdf->Cell(60, 10, utf8_decode('a la entrada municipal, El Rama'), 0, 1, 'C');
			
			$pdf->Cell(15, 10, 'Cliente:', 0, 0, 'L');
            $pdf->Cell(15, 10, $clientes['Nombre'], 0, 0, 'L');
            $pdf->Cell(10, 10, $clientes['Apellido'], 0, 1, 'L');



			$pdf->Ln();
			$pdf->SetFont('Arial', 'B', 8);
			// Establecer un grosor de línea más delgado
			$pdf->SetLineWidth(0.2);

			// Encabezado con contorno
			$pdf->Cell(15, 5, 'Cant', 'LTRB', 0, 'L');
			$pdf->Cell(30, 5, 'Descripcion', 'LTRB', 0, 'L');
			$pdf->Cell(15, 5, 'Precio', 'LTRB', 0, 'L');
			$pdf->Cell(20, 5, 'Sub total', 'LTRB', 1, 'L');

			$pdf->SetFont('Arial', '', 8);
			$total = 0;  // Inicializar la variable total

			foreach ($productos as $row) {
				// Celdas con contorno
				$pdf->Cell(15, 5, $row['cantidad'], 'LTRB', 0, 'L');
				
				$descripcionX = $pdf->GetX();
				$descripcionY = $pdf->GetY();
				$pdf->MultiCell(30, 5, $row['Descripcion'], 'LTRB', 'J');
				
				// Ajustar posición X para la celda de Precio
				$pdf->setXY($descripcionX + 30, $descripcionY); // Ajuste aquí

				$pdf->Cell(15, 5, $row['precio'], 'LTRB', 0, 'L');

				// Ajustar posición X e Y para la celda de Subtotal
				$pdf->setXY($descripcionX + 45, $descripcionY); // Ajuste aquí
				
				$subtotal = $row['cantidad'] * $row['precio'];
				$total += $subtotal;  // Sumar al total
				$pdf->Cell(10, 5, $subtotal, 'LTRB', 1, 'L');

				$pdf->ln(20);
			}

			// Agregar celda para mostrar el total con contorno
			$pdf->Cell(70, 5, 'Total:', 'LTRB', 0, 'R');
			$pdf->Cell(10, 5, $total, 'LTRB', 1, 'L');

			$pdf->Output();

		}			
		
		
    }

 ?>