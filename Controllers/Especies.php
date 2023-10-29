<?php 
	//Pagina principal

	Class Especies extends Controllers{
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

		public function Especies() {
		
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['page_id']=3;
			$data['Etiqueta_Pagina']="Catalogo Especies";
			$data['Titulo_pagina'] = "Catalogo Especies";
			$data['Nombre_pagina'] = "Catalogo Especies";
			$data['page_functions_js'] = "function_especies.js";
			$this->views->getViews($this,"Especies",$data);
		}

		public function getEspecies() {
			if($_SESSION['PermisosMod']['r']){
				$arrData = $this->modelo->selectEspecies();
				for ($i=0; $i < count($arrData); $i++) { 
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';
					if($_SESSION['PermisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnViewEspecie" onClick="fntViewEspecies('.$arrData[$i]['id_especie'].')" title="Ver Especie"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['PermisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnEspecie" onClick="fntEditEspecie('.$arrData[$i]['id_especie'].')" title="Editar Especie"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['PermisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelEspecie" onClick="fntDelEspecie('.$arrData[$i]['id_especie'].')" title="Eliminar Especie"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelete.'</div>';
				}
				//Implementamos el arrays con formado JSON para que pueda ser interpretado por cualquier lenguaje de programacion
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		//metodo para extraer un rol
		public function getEspecie($idEspecie) {
			if($_SESSION['PermisosMod']['r']) {
			    $intidEspecie = intval(strClean($idEspecie));
			    if ($intidEspecie > 0) { 
					$arrData = $this->modelo->selectEspecie($intidEspecie);
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

		public function setEspecie() {
			if($_POST) {
				$intidEspecie = intval($_POST['idEspecie']);
				$strEspecie =  strClean($_POST['txtNombre']);
				$strDescipcion = strClean($_POST['txtDescripcion']);
				$request_Especie = "";
				if ($intidEspecie == 0) {
				//Crear
					if($_SESSION['PermisosMod']['w']){
						$request_Especie = $this->modelo->insertEspecie($strEspecie, $strDescipcion);
						$option = 1;
					}
				} else {
				//Actualizar
				if($_SESSION['PermisosMod']['u']){
					$request_Especie = $this->modelo->updateEspecie($intidEspecie, $strEspecie, $strDescipcion);
					$option = 2;
				}
			}

			if ($request_Especie > 0 ) {
				if($option == 1) {
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
				} else {
					$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
				}
			} else if ($request_Especie == 'exist') {
				$arrResponse = array('status' => false, 'msg' => '¡Atención! La Especie ya existe.');
			} else {
				$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
		
	}

	//Eliminar Rol
	public function delEspecie() {
		if ($_SESSION['PermisosMod']['d']) {
			if ($_POST) {
				$intidEspecie =  intval($_POST['idEspecie']);
				$requestDelete = $this->modelo->deleteEspecie($intidEspecie);
				if($requestDelete == 'ok') {
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la especie');
				} elseif ( $requestDelete == 'exist') {
					$arrResponse = array('status' => false, 'msg' => 'No se ha podido elminar una especie asociada a una raza');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la especie');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}
}


?>