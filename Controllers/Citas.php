<?php 
	//Pagina principal

	Class Citas extends Controllers{

		public $views;
		public $modelo;
		Public function __construct() {
			$this->views = new Views();
			parent::__construct();
			session_start();
		//	session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(4);
		}

		public function Citas($params) {
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['Etiqueta_Pagina']="Citas";
			$data['Titulo_pagina'] = "Citas";
			$data['Nombre_pagina'] = "Citas";
			$data['page_functions_js'] = "function_citas.js";
			$this->views->getViews($this,"Citas",$data);
		}
		public function setCita(){
			if($_POST){
				//dep($_POST);
				if(empty($_POST['listPaciente'])  || empty($_POST['txtDescripcion']) || empty($_POST['txtFecha']) || empty($_POST['txtHora'])) {
					$arrResponse = array("status" => false, "msg" => "Datos incorrectos.");
				} else {
					$idCita = intval($_POST['idCita']);
					$intIdPaciente = intval(strClean($_POST['listPaciente']));
					$strDescripcion = ucwords(strClean($_POST['txtDescripcion']));
					$DateFecha = strClean($_POST['txtFecha']);
					$strHora = strClean($_POST['txtHora']);
					$intStatus = intval(strClean($_POST['listStatus']));
					if($idCita == 0) {
						$option = 1;
						if($_SESSION['PermisosMod']['w']){
							$request_mas= $this->modelo->insertcitas($intIdPaciente,$strDescripcion,$DateFecha,$strHora);
						}
					}else{
						$option = 2;
						if($_SESSION['PermisosMod']['u']){
							$request_mas = $this->modelo->updatecitas($idCita,$intIdPaciente,$strDescripcion,$DateFecha,$strHora,$intStatus);
						}	
					}

					if($request_mas > 0) {
						$arrResponse = $option == 1 ? array("status" => true , "msg" => "Datos Guardados Correctamente.")
												    : array("status" => true , "msg" => "Datos Actualizados Correctamente.");	
					} else if($request_mas == 'exist') {
						$arrResponse = array("status" => false , "msg" => "Ya existe una cita para ese dia y hora.");
					}else{
						$arrResponse = array("status" => false , "msg" => "No es posible almacenar los datos.");
					}
				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);	
			}
			die(); 	
		}

		public function getCitas() {
		 	if($_SESSION['PermisosMod']['r']){
				$arrData = $this->modelo->selectCitas();
				//dep($arrData);
				for ($i=0; $i < count($arrData); $i++) { 
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';
					if($arrData[$i]['CantDias'] < 0 and $arrData[$i]['status'] == 1){
						$arrData[$i]['CantDias'] = 'No vino';
						$arrData[$i]['status'] = 4;
					}else if ($arrData[$i]['CantDias'] < 0 and $arrData[$i]['status'] == 2){
						$arrData[$i]['CantDias'] = 'Ya vino';
					} else if($arrData[$i]['status'] > 3) {
						$arrData[$i]['CantDias'] = 'Se cancelo';
					}
					if ($arrData[$i]['status'] == 1) {

						$arrData[$i]['status'] = ' <span class="badge badge-primary">Activa</span>';
					}else if($arrData[$i]['status'] == 2){
						$arrData[$i]['status'] = '<span class="badge badge-success">Realizada</span>';
					}else if($arrData[$i]['status'] == 3){
						$arrData[$i]['status'] = '<span class="badge badge-warning">Pospuesta</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Cancelado</span>';
					}
					if($_SESSION['PermisosMod']['r']){
					$btnView = '<button class="btn btn-info btn-sm btnViewCita" onClick="fntViewCita('.$arrData[$i]['id_citas'].')" title="Ver Cita"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['PermisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary btn-sm btnEditCita" onClick="fntEditCita('.$arrData[$i]['id_citas'].')"  title="Editar Usuario"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['PermisosMod']['d']){
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelCita" onClick="fntDelCita('.$arrData[$i]['id_citas'].')" title="Eliminar Cita"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
						//El atributo rl sirve para setear el id del rol
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getCita( $id_Cita)
		{
			if($_SESSION['PermisosMod']['r']){
				$id_Cita = intval($id_Cita);
				if($id_Cita > 0)
				{
					$arrData = $this->modelo->selectCita($id_Cita);
					if (empty($arrData))
					 {
						$arrResponse = array("status" => false , "msg" => "No se encontraron datos");
					}else{
						$arrResponse = array("status" => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
		public function delCita() {
			if($_SESSION['PermisosMod']['d']){
				if($_POST){
					$idCita = intval($_POST['idCita']);
					$requestDelete = $this->modelo->deleteCita($idCita);
					if($requestDelete) {
						$arrResponse = array("status" => true , "msg" => "Se ha eliminado la cita");
					}else{
						$arrResponse = array("status" => false , "msg" => "Error al eliminar la cita");
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				 }
			}
			die();
		}
		
	}


?>