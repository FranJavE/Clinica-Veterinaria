<?php 
	class Historial extends Controllers{
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

        public function Historial()
		{
			if(empty($_SESSION['PermisosMod']['r'])){
				header("Location:".base_url().'/Dashboard');
			}
			$data['Etiqueta_Pagina'] = "Historial";
			$data['Titulo_pagina'] = "Historial <small>Tienda Virtual</small>";
			$data['Nombre_pagina'] = "Historial";
			$data['page_functions_js'] = "function_ventas.js";
			$this->views->getViews($this,"Historial",$data);
		}

		public function listar_historial()
		{
			$data = $this->modelo->getHistorialventas();
			echo json_encode($data, JSON_UNESCAPED_UNICODE);
			die();
		}		

		public function delHistorial()
		{
			if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				$intidHistorial = intval($_POST['idHistorial']);
				$requestDelete = $this->modelo->deleteHistorial($intidHistorial);
				if ($requestDelete) {
					$arrResponse = array("status" => true, "msg" => "Se ha eliminado el registro");
				} else {
					$arrResponse = array("status" => false, "msg" => "Error al eliminar el registro");
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}

    }

 ?>