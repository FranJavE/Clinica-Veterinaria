<?php 
	//Pagina principal

	Class Jaulas extends Controllers{
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

		public function Jaulas() {
		
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['page_id']=3;
			$data['Etiqueta_Pagina']="Catalogo Jaulas";
			$data['Titulo_pagina'] = "Catalogo Jaulas";
			$data['Nombre_pagina'] = "Catalogo Jaulas";
			$data['page_functions_js'] = "function_jaulas.js";
			$this->views->getViews($this,"Jaulas",$data);
		}

		public function getJaulas() {
			if($_SESSION['PermisosMod']['r']){
				$arrData = $this->modelo->selectJaulas();
				for ($i=0; $i < count($arrData); $i++) { 
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';
					if($_SESSION['PermisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnViewJaula" onClick="fntViewJaulas('.$arrData[$i]['id_jaula'].')" title="Ver Jaula"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['PermisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm btnJaula" onClick="fntEditJaula('.$arrData[$i]['id_jaula'].')" title="Editar Jaula"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['PermisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelJaula" onClick="fntDelJaula('.$arrData[$i]['id_jaula'].')" title="Eliminar Jaula"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnEdit.' '.$btnDelete.'</div>';
				}
				//Implementamos el arrays con formado JSON para que pueda ser interpretado por cualquier lenguaje de programacion
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		//metodo para extraer un rol
		public function getJaula($idJaula) {
			if($_SESSION['PermisosMod']['r']) {
			    $intidJaula = intval(strClean($idJaula));
			    if ($intidJaula > 0) { 
					$arrData = $this->modelo->selectJaula($intidJaula);
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

		public function setJaula() {
			if($_POST) {
				$intidJaula = intval($_POST['idJaula']);
				$intNumeroJaula = intval($_POST['txtNumero']);
				$strJaula =  strClean($_POST['txtNombre']);
				$strDescipcion = strClean($_POST['txtDescripcion']);
				$request_Jaula = "";
				if ($intidJaula == 0) {
				//Crear
					if($_SESSION['PermisosMod']['w']){
						$request_Jaula = $this->modelo->insertJaula($strJaula, $intNumeroJaula, $strDescipcion);
						$option = 1;
					}
				} else {
				//Actualizar
				if($_SESSION['PermisosMod']['u']){
					$request_Jaula = $this->modelo->updateJaula($intidJaula, $strJaula, $intNumeroJaula, $strDescipcion);
					$option = 2;
				}
			}

			if ($request_Jaula > 0 ) {
				if($option == 1) {
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
				} else {
					$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
				}
			} else if ($request_Jaula == 'exist') {
				$arrResponse = array('status' => false, 'msg' => '¡Atención! La Jaula ya existe.');
			} else {
				$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
		
	}

	//Eliminar Rol
	public function delJaula() {
		if ($_SESSION['PermisosMod']['d']) {
			if ($_POST) {
				$intidJaula =  intval($_POST['idJaula']);
				$requestDelete = $this->modelo->deleteJaula($intidJaula);
				if($requestDelete == 'ok') {
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la jaula');
				} elseif ( $requestDelete == 'exist') {
					$arrResponse = array('status' => false, 'msg' => 'No se ha podido elminar una jaula tiene un registro de guarderi asociado');
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la jaula');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

	public function getSelectJaulas() {
		//dep($_POST);
		$htmlOptions = "";
		$arrData = $this->modelo->selectJaulas();
		if(count($arrData) > 0){
			for ($i=0; $i < count($arrData); $i++){
				$htmlOptions .= '<option value="'.$arrData[$i]['id_jaula'].'">'.$arrData[$i]['nombre_jaula'].'</options>';
				//$htmlOptions .= '<option value="'.$arrData[$i]['id_raza'].'">'.$arrData[$i]['NombreEspecie'].' | '.$arrData[$i]['NombreRaza'].'</options>';
			}
		}
		echo $htmlOptions;
		die();
	}
}


?>