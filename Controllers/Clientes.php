<?php 
	//Pagina principal

	Class Clientes extends Controllers{
		public $views;
		public $modelo;
		Public function __construct() {
			$this->views = new Views();
			parent::__construct();
			session_start();
			//session_regenerate_id(true);
			if (empty($_SESSION['login'])) {
				header('Location: '.base_url().'/login');
			}
			getPermisos(9);
		}

		public function Clientes($params)
		{
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}	
			$data['Etiqueta_Pagina']="Clientes";
			$data['Titulo_pagina'] = "Clientes";
			$data['Nombre_pagina'] = "Clientes";
			$data['page_functions_js'] = "function_Clientes.js";
			$this->views->getViews($this,"Clientes",$data);
		}
		public function setClientes(){
			if($_POST){
				//dep($_POST);
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['txtDireccion']) || empty($_POST['listStatus'])){

						$arrResponse = array("status" => false, "msg" => "Datos incorrectos.");

				}else{
					$idUsuario = intval($_POST['idUsuario']);
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strDireccion = strClean($_POST['txtDireccion']);
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$intStatus = intval(strClean($_POST['listStatus']));
					if($idUsuario == 0)
					{
						$option = 1;
					$strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash ("SHA256", $_POST['txtPassword']);//generamos e encryptamos la contraseña
					if($_SESSION['PermisosMod']['w']){
						$request_user = $this->modelo->insertCliente($strIdentificacion,$strNombre,$strApellido,$intTelefono,$strEmail,$strDireccion,$strPassword,$intStatus);
					}
					}else{
						$option = 2;
						$strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash ("SHA256", $_POST['txtPassword']);//generamos e encryptamos la contraseña
						if($_SESSION['PermisosMod']['u']){
							 $request_user = $this->modelo->updateCliente($idUsuario,$strIdentificacion,$strNombre,$strApellido,$intTelefono,$strEmail,$strDireccion,$strPassword,$intStatus);
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
						$arrResponse = array("status" => false , "msg" => "Este Cliente ya existe, verifique los datos.");
					}else{
						$arrResponse = array("status" => false , "msg" => "No es posible almacenar los datos.");
					}

				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);	
			}
			die(); 	
		}

		public function getClientes()
		{
			if($_SESSION['PermisosMod']['r']){
				$arrData = $this->modelo->selectClientes();
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
					$btnView = '<button class="btn btn-info btn-sm btnViewCliente" onClick="fntViewCliente('.$arrData[$i]['id_persona'].')" title="Ver Usuarios"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['PermisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary btn-sm btnCliente" onClick="fntEditCliente('.$arrData[$i]['id_persona'].')" title="Editar Usuario"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['PermisosMod']['d']){
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelCliente" onClick="fntDelCliente('.$arrData[$i]['id_persona'].')" title="Eliminar Usuario"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
						//El atributo rl sirve para setear el id del rol
				}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getSelectClientes()
		{
			$htmlOptions = "";
			$arrData = $this->modelo->selectgetClientes();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData); $i++){
					$htmlOptions .= '<option value="'.$arrData[$i]['id_persona'].'">'.$arrData[$i]['Dueño'].'</options>';
				}
			}
			echo $htmlOptions;
			die();
		}
		public function getCliente($idpersona){
			if($_SESSION['PermisosMod']['r']){
				$idCliente = intval($idpersona);
				if($idCliente > 0)
				{
					$arrData = $this->modelo->selectCliente($idCliente);
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

		public function delCliente() {
			if ($_SESSION['PermisosMod']['u']) {
				if ($_POST) {
					$intIdpersona = intval($_POST['idUsuario']);
					$requestExiste = $this->modelo->verificaCliente($intIdpersona);
					if($requestExiste['Tabla'] == 'libre') {
						$requestDelete = $this->modelo->deleteCliente($intIdpersona);
						if($requestDelete) {
							$arrResponse = array("status" => true , "msg" => "Se ha eliminado el cliente");
						} else {
							$arrResponse = array("status" => false , "msg" => "Error al eliminar al usuario");
						}
					} else {
						$arrResponse = array("status" => false , "msg" => "Error al eliminar al cliente, este tiene una mascota activa");
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
	}
?>