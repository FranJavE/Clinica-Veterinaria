<?php 
	//Pagina principal

	Class Vacunas extends Controllers{

		Public function __construct()
		{
			$this->views = new Views();
			parent::__construct();
			session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(6);
		}

		public function Vacunas($params)
		{
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['Etiqueta_Pagina']="Vacunas";
			$data['Titulo_pagina'] = "Vacunas";
			$data['Nombre_pagina'] = "Vacunas";
			$data['page_functions_js'] = "function_Vacunas.js";
			$this->views->getViews($this,"Vacunas",$data);
		}

		public function setVacunas(){
			if($_POST){
			//	dep($_POST);
				if(empty($_POST['listPaciente']) || empty($_POST['listVacunas']) || empty($_POST['txtDescripcion']) || empty($_POST['txtPrecio'])){

						$arrResponse = array("status" => false, "msg" => "Datos incorrectos.");

				}else{
					$idVacuna = intval($_POST['idVacuna']);
					$intIsPaciente = intval($_POST['listPaciente']);
					$intIsVacunas = intval($_POST['listVacunas']);
					$strDescripcion = ucwords(strClean($_POST['txtDescripcion']));
					$intPrecio = intval($_POST['txtPrecio']);
					$DateFecha = strClean($_POST['txtFecha']);
					$strHora = strClean($_POST['txtHora']);
					$request_user = "";
					if($idVacuna == 0)
					{
						$option = 1;
						if($_SESSION['PermisosMod']['w']){
							$request_user = $this->modelo->insertVacuna($intIsPaciente,$intIsVacunas,$strDescripcion,$intPrecio,$DateFecha,$strHora);
						}
					}else{
						$option = 2;
						if($_SESSION['PermisosMod']['u']){
							 $request_user = $this->modelo->updateVacuna($idVacuna,$intIsPaciente,$intIsVacunas,$strDescripcion,$intPrecio,$DateFecha,$strHora);
						}
					}


					if($request_user > 0)
					{
						if($option == 1){
							$arrResponse = array("status" => true , "msg" => "Datos Guardados Correctamente.");	
						}else{
							$arrResponse = array("status" => true , "msg" => "Datos Actualizados Correctamente.");
						}
						
					}else if($request_user == 'exist'){
						$arrResponse = array("status" => false , "msg" => "Ya se registro esta Vacuna, verifique los datos.");
					}else{
						$arrResponse = array("status" => false , "msg" => "No es posible almacenar los datos.");
					}

				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);	
			}
			die(); 	
		}
		public function getVacunas()
		{
			if($_SESSION['PermisosMod']['r']){
				$arrData = $this->modelo->selectVacunas();
				//dep($arrData);
				for ($i=0; $i < count($arrData); $i++) { 
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';
					$arrData[$i]['Precio'] = SMONEY.' '.formatMoney($arrData[$i]['Precio']);
					if($_SESSION['PermisosMod']['r']){
					$btnView = '<button class="btn btn-info btn-sm btnViewVacuna" onClick="fntViewVacuna('.$arrData[$i]['id_VacunacionXMascota'].')" title="Ver Consulta"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['PermisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary btn-sm btnVacuna" onClick="fntEditVacuna(this, '.$arrData[$i]['id_VacunacionXMascota'].')" title="Editar consulta"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['PermisosMod']['d']){
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelVacuna" onClick="fntDelVacuna('.$arrData[$i]['id_VacunacionXMascota'].')" title="Eliminar consulta"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
						//El atributo rl sirve para setear el id del rol
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getSelectVacunas()
		{
			$htmlOptions = "";
			$arrData = $this->modelo->selectgetVacunas();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData); $i++){
					$htmlOptions .= '<option value="'.$arrData[$i]['id_Vacunacion'].'">'.$arrData[$i]['NombreVacuna'].'</options>';
				}
			}
			echo $htmlOptions;
			die();
		}

		public function getVacuna($idVacuna){
			if($_SESSION['PermisosMod']['r']){
				$idVacuna = intval($idVacuna);
				if($idVacuna > 0)
				{
					$arrData = $this->modelo->selectVacuna($idVacuna);
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
		public function delVacuna()
		{
			if($_SESSION['PermisosMod']['d']){
				if($_POST){
					$idVacuna = intval($_POST['idVacuna']);
					$requestDelete = $this->modelo->deleteVacuna($idVacuna);
						if($requestDelete)
						{
							$arrResponse = array("status" => true , "msg" => "Se ha eliminado el registro de vacunacion");


						}else{
							$arrResponse = array("status" => false , "msg" => "Error al eliminar el registro de vacunacion");

						}
						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				 }
			}
			die();

		}

	}
	


?>