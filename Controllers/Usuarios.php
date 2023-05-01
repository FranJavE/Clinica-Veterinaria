<?php 
	//Pagina principal

	Class Usuarios extends Controllers{

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
			getPermisos(2);
		}

		public function Usuarios($params)
		{
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['Etiqueta_Pagina']="Usuarios";
			$data['Titulo_pagina'] = "Usuarios";
			$data['Nombre_pagina'] = "usuarios";
			$data['page_functions_js'] = "function_usuarios.js";
			$this->views->getViews($this,"Usuarios",$data);
		}
		
		public function setUsuario(){
			if($_POST){
			//	dep($_POST);
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) 
				   || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus'])) {
					$arrResponse = array("status" => false, "msg" => "Datos incorrectos.");
				} else {
					$idUsuario = intval($_POST['idUsuario']);
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$intTipoid = intval(strClean($_POST['listRolid']));
					$intStatus = intval(strClean($_POST['listStatus']));
					$request_user = "";
					if ($idUsuario == 0) {
						$option = 1;
						$strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash ("SHA256", $_POST['txtPassword']);//generamos e encryptamos la contraseña
					 	if($_SESSION['PermisosMod']['w']) {
							$request_user = $this->modelo->insertUsuario($strIdentificacion,$strNombre,$strApellido,$intTelefono,$strEmail,$strPassword,$intTipoid,$intStatus );
						}
					} else {
						$option = 2;
						$strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash ("SHA256", $_POST['txtPassword']);//generamos e encryptamos la contraseña
						if($_SESSION['PermisosMod']['u']){
							$request_user = $this->modelo->updateUsuario($idUsuario,$strIdentificacion,$strNombre,$strApellido,$intTelefono,$strEmail,$strPassword,$intTipoid,$intStatus );
						}
					}


					if ($request_user > 0) {
						if ($option == 1) {
							$arrResponse = array("status" => true , "msg" => "Datos Guardados Correctamente.");	
						} else {
							$arrResponse = array("status" => true , "msg" => "Datos Actualizados Correctamente.");
						}	
					} else if ($request_user == 'exist') {
						$arrResponse = array("status" => false , "msg" => "Este Usuario ya exste, verifique los datos.");
					} else {
						$arrResponse = array("status" => false , "msg" => "No es posible almacenar los datos.");
					}
				}
				sleep(2);
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);	
			}
			die(); 	
		}
		public function getUsuarios() {
			if($_SESSION['PermisosMod']['r']){
			$arrData = $this->modelo->selectUsuarios();
			//dep($arrData);
			for ($i=0; $i < count($arrData); $i++) { 
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';
				if ($arrData[$i]['status'] == 1) {
					$arrData[$i]['status'] = ' <span class="badge badge-success">Activo</span>';
				} else {
					$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
				}
				if($_SESSION['PermisosMod']['r']) {
					$btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario('.$arrData[$i]['id_persona'].')" title="Ver Usuarios"><i class="far fa-eye"></i></button>';
				}
				if($_SESSION['PermisosMod']['u']){
					if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['id_rol'] == 1) || ($_SESSION['userData']['id_rol'] == 1 and $arrData[$i]['id_rol'] != 1)){
					$btnEdit = '<button class="btn btn-primary btn-sm btnEditUsuario" onClick="fntEditUsuario(this,'.$arrData[$i]['id_persona'].')" title="Editar Usuario"><i class="fas fa-pencil-alt"></i></button>';
					}else{
						$btnEdit = '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-pencil-alt"></i></button>';
					}
				}
				if($_SESSION['PermisosMod']['d']){
					if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['id_rol'] == 1) || ($_SESSION['userData']['id_rol'] == 1 and $arrData[$i]['id_rol'] != 1) and ($_SESSION['userData']['id_persona'] != $arrData[$i]['id_persona'])){
						
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['id_persona'].')" title="Eliminar Usuario"><i class="far fa-trash-alt"></i></button>';
				}else{
					$btnDelete = '<button class="btn btn-danger btn-sm" disabled><i class="far fa-trash-alt"></i></button>';
				}
				}
				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				//El atributo rl sirve para setear el id del rol
			}
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getUsuario($idpersona){
			if($_SESSION['PermisosMod']['r']){
				$idusuario = intval($idpersona);
				if($idusuario > 0)
				{
					$arrData = $this->modelo->selectUsuario($idusuario);
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

		public function delUsuario()
		{
			if($_POST){
				if($_SESSION['PermisosMod']['d']){
				$intIdpersona = intval($_POST['idUsuario']);
				$requestDelete = $this->modelo->deleteUsuario($intIdpersona);
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

		public function perfil(){
			$data['Etiqueta_Pagina']="Perfil";
			$data['Titulo_pagina'] = "Peril de Usuarios";
			$data['Nombre_pagina'] = "Perfil";
			$data['page_functions_js'] = "function_usuarios.js";
			$this->views->getViews($this,"Perfil",$data);
		}
		public function putPerfil(){
			if($_POST){
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idUsuario = $_SESSION['idUser'];
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = strClean($_POST['txtNombre']);
					$strApellido = strClean($_POST['txtApellido']);
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strPassword = "";
					if(!empty($_POST['txtPassword'])){
						$strPassword = hash("SHA256",$_POST['txtPassword']);
					}
					$request_user = $this->modelo->updatePerfil($idUsuario,$strIdentificacion, $strNombre,$strApellido, $intTelefono, $strPassword);
					if($request_user)
					{
						sessionUser($_SESSION['idUser']);
						$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
					}
				}
				sleep(2);
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}


	}


?>