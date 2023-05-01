<?php 
	//Pagina principal

	Class Medicos extends Controllers{

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
			getPermisos(7);
		}

		public function Medicos($params)
		{
			
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['page_id']=2;
			$data['Etiqueta_Pagina']="Medicos";
			$data['Titulo_pagina'] = "Medicos Veterinaria";
			$data['Nombre_pagina'] = "Medicos";
			$data['page_functions_js'] = "function_Medicos.js";
			$this->views->getViews($this,"Medicos",$data);
		}
		public function setMedicos(){
			if($_POST){
				//dep($_POST);
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listStatus'])){

						$arrResponse = array("status" => false, "msg" => "Datos incorrectos.");

				}else{
					$idUsuario = intval($_POST['idMedico']);
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$intStatus = intval(strClean($_POST['listStatus']));
					if($idUsuario == 0)
					{
						$option = 1;
					//$strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash ("SHA256", $_POST['txtPassword']);//generamos e encryptamos la contraseña
					if($_SESSION['PermisosMod']['w']){
						$request_user = $this->modelo->insertMedico($strIdentificacion,$strNombre,$strApellido,$intTelefono,$strEmail,$intStatus);
					}
					}else{
						$option = 2;
						if($_SESSION['PermisosMod']['u']){
						//$strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash ("SHA256", $_POST['txtPassword']);//generamos e encryptamos la contraseña
					 		$request_user = $this->modelo->updateMedico($idUsuario,$strIdentificacion,$strNombre,$strApellido,$intTelefono,$strEmail,$intStatus);
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
						$arrResponse = array("status" => false , "msg" => "Este Medico ya existe, verifique los datos.");
					}else{
						$arrResponse = array("status" => false , "msg" => "No es posible almacenar los datos.");
					}

				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);	
			}
			die(); 	
		}

		public function getMedicos()
		{
			if($_SESSION['PermisosMod']['r']){
				$arrData = $this->modelo->selectMedicos();
				//dep($arrData);
				for ($i=0; $i < count($arrData); $i++) { 
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';
					if ($arrData[$i]['status'] == 1) {

						$arrData[$i]['status'] = ' <span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}
					if($_SESSION['PermisosMod']['r']){
					$btnView = '<button class="btn btn-info btn-sm btnViewMedico" onClick="fntViewMedico('.$arrData[$i]['id_medico'].')" title="Ver Usuarios"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['PermisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary btn-sm btnCliente" onClick="fntEditMedico('.$arrData[$i]['id_medico'].')" title="Editar Usuario"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['PermisosMod']['d']){
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelCliente" onClick="fntDelMedico('.$arrData[$i]['id_medico'].')" title="Eliminar Usuario"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
						//El atributo rl sirve para setear el id del rol
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getSelectMedicos()
		{
			$htmlOptions = "";
			$arrData = $this->modelo->selectgetMedicos();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData); $i++){
					$htmlOptions .= '<option value="'.$arrData[$i]['id_medico'].'">'.$arrData[$i]['Medico'].'</options>';
				}
			}
			echo $htmlOptions;
			die();
		}
		public function getMedico($idpersona){
			if($_SESSION['PermisosMod']['r']){
				$idCliente = intval($idpersona);
				if($idCliente > 0)
				{
					$arrData = $this->modelo->selectMedico($idCliente);
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

		public function delMedico()
		{
			if($_SESSION['PermisosMod']['d']){
				if($_POST){
					$intIdpersona = intval($_POST['idUsuario']);
					$requestDelete = $this->modelo->deleteMedico($intIdpersona);
						if($requestDelete)
						{
							$arrResponse = array("status" => true , "msg" => "Se ha eliminado el usuario");


						}else{
							$arrResponse = array("status" => false , "msg" => "Error al eliminar al usuario");

						}
						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
		die();
		}


	}
?>