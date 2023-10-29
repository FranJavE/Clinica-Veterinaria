<?php 
	//Pagina principal

	Class Razas extends Controllers{
		public $views;
		public $modelo;
		Public function __construct() {
			$this->views = new Views();
			parent::__construct();
			session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(12);
		}

		public function Razas() {
		
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['page_id']=3;
			$data['Etiqueta_Pagina']="Catalogo Razas";
			$data['Titulo_pagina'] = "Catalogo Razas";
			$data['Nombre_pagina'] = "Catalogo Razas";
			$data['page_functions_js'] = "function_razas.js";
			$this->views->getViews($this,"Razas",$data);
		}

		public function getRazas() {
			if($_SESSION['PermisosMod']['r']){
				$arrData = $this->modelo->selectRazas();
				for ($i=0; $i < count($arrData); $i++) { 
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';
					if($_SESSION['PermisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnViewRaza" onClick="fntViewRazas('.$arrData[$i]['id_raza'].')" title="Ver Raza"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['PermisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnRaza" onClick="fntEditRaza('.$arrData[$i]['id_raza'].')" title="Editar Raza"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['PermisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelRaza" onClick="fntDelRaza('.$arrData[$i]['id_raza'].')" title="Eliminar Raza"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelete.'</div>';
				}
				//Implementamos el arrays con formado JSON para que pueda ser interpretado por cualquier lenguaje de programacion
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		//metodo para extraer un rol
		public function getRaza($idRaza) {
			if($_SESSION['PermisosMod']['r']) {
			    $intidRaza = intval(strClean($idRaza));
			    if ($intidRaza > 0) { 
					$arrData = $this->modelo->selectRaza($intidRaza);
					if(empty($arrData)){
						$arrResponse =array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse =array('status' => true, 'data' => $arrData);
					}	
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); 
				}
			}
			//Finalizamos el proceso
			die();
		}

		public function setRaza() {
			if($_POST) {
				$intidRaza = intval($_POST['idRaza']);
				$intidEspecie = intval($_POST['listEspecieId']);
				$strRaza =  strClean($_POST['txtNombre']);
				$strDescipcion = strClean($_POST['txtDescripcion']);
				$request_raza = "";
				if ($intidRaza == 0) {
				//Crear
					if($_SESSION['PermisosMod']['w']){
						$request_raza = $this->modelo->insertRaza($intidEspecie, $strRaza, $strDescipcion);
						$option = 1;
					}
				} else {
				//Actualizar
				if($_SESSION['PermisosMod']['u']){
					$request_raza = $this->modelo->updateRaza($intidRaza, $intidEspecie, $strRaza, $strDescipcion);
					$option = 2;
				}
			}

			if ($request_raza > 0 ) {
				if($option == 1) {
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
				} else {
					$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
				}
			} else if ($request_raza == 'exist') {
				$arrResponse = array('status' => false, 'msg' => '¡Atención! La raza ya existe.');
			} else {
				$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
		
	}

	public function delRaza() {
		if ($_SESSION['PermisosMod']['d']) {
			if ($_POST) {
				$intidRaza =  intval($_POST['idRaza']);
				$requestDelete = $this->modelo->deleteRaza($intidRaza);
				if($requestDelete == 'ok') {
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la raza');
				} elseif ( $requestDelete == 'exist') {
					$arrResponse = array('status' => false, 'msg' => 'No se ha podido elminar una raza asociada a mascotas');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la raza');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}
}


?>