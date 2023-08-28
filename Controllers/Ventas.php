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

		public function registrarVenta()
		{
			$idUsuario = $_SESSION['idUser'];
			try {
				$total = $this->modelo->calcularVenta($idUsuario);
				$this->modelo->registrarVenta($total['total']);
				$detalle = $this->modelo->getDetalle($idUsuario);
				$id_venta = $this->modelo->id_venta();
				foreach ($detalle as $row){
					$cantidad = $row['cantidad'];
					$precio = $row['precio'];
					$id_pro = $row['id_producto'];
					$sub_total = $cantidad * $precio;
                  $this->modelo->registrarDetalleVenta($id_venta['id'], $id_pro, $cantidad, $precio, $sub_total);
				  $this->modelo->vaciarDetalle($idUsuario);
				}
				$msg = 'ok';

			} catch (Exception $e) {
				$msg = 'error';
			}
		
			echo json_encode($msg);
			die();
		}

		public function generarPdf($id_venta)
		{
			$productos = $this->modelo->getProVenta($id_venta);

			require('Libraries/fpdf/fpdf.php');

			$pdf = new FPDF('P','mm', array(80, 200));
			$pdf->AddPage();
			$pdf->SetMargins(2, 0, 0);
			$pdf->SetTitle('Reporte de Venta');
			$pdf->SetFont('Arial','B',12);
			$pdf->Cell(60,10, utf8_decode('Clinica Veterinaria Vet Amigos'));
            
			$pdf->Ln(); // Agregar un salto de línea
			$pdf->SetFont('Arial', 'B', 8);
			$pdf->Cell(60, 10, 'Telefono : 22600525');

			$pdf->Ln(); // Agregar un salto de línea
			$pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(60, 10, 'Direcionn : barrio san judas');

			//Productos
			$pdf->Ln();
			$pdf->Cell(15, 5, 'Cant', 0, 0, 'L');
			$pdf->Cell(30, 5, 'Descripcion', 0, 0, 'L');
			$pdf->Cell(15, 5, 'Precio', 0, 0, 'L');
			$pdf->Cell(10, 5, 'Sub total', 0, 1, 'L');

            foreach ($productos as $row) {
				$pdf->Cell(15, 5, $row['cantidad'], 0, 0, 'L');
				$pdf->Cell(30, 5, $row['Descripcion'], 0, 0, 'L');
				$pdf->Cell(15, 5, $row['precio'], 0, 0, 'L');
				$pdf->Cell(10, 5, $row['cantidad'] * $row['precio'], 0, 1, 'L');

			}
			
			


			$pdf->Output();
		}

		public function historial()
		{
           $this->views->getViews($this, "Facturas");
		}
		
    }

 ?>