<?php 
	//Pagina principal

	Class Proveedor extends Controllers{

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
			getPermisos(9);
		}

		public function Proveedor($params)
		{
			
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['page_id']=2;
			$data['Etiqueta_Pagina']="Proveedores";
			$data['Titulo_pagina'] = "Proveedores Veterinaria";
			$data['Nombre_pagina'] = "Proveedores";
			$data['page_functions_js'] = "function_Proveedores.js";
			$this->views->getViews($this,"Proveedor",$data);
		}
		public function setProveedores(){
			if($_POST){
				//dep($_POST);
				if(empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['txtDireccion']) || empty($_POST['txtEmpresa']) || empty($_POST['listStatus'])){

						$arrResponse = array("status" => false, "msg" => "Datos incorrectos.");

				}else{
					$idProveedor = intval($_POST['idProveedor']);
					$strIdentificacion = strClean($_POST['txtIdentificacion']);
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strDireccion = strClean($_POST['txtDireccion']);
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$strEmpresa = strtolower(strClean($_POST['txtEmpresa']));
					$intStatus = intval(strClean($_POST['listStatus']));
					if($idProveedor == 0)
					{
						$option = 1;
					//$strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash ("SHA256", $_POST['txtPassword']);//generamos e encryptamos la contraseña
					if($_SESSION['PermisosMod']['w']){
						$request_user = $this->modelo->insertProveedor($strIdentificacion,$strNombre,$strApellido,$intTelefono,$strEmail,$strDireccion, $strEmpresa, $intStatus);
					}
					}else{
						$option = 2;
						if($_SESSION['PermisosMod']['u']){
						//$strPassword = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash ("SHA256", $_POST['txtPassword']);//generamos e encryptamos la contraseña
					 		$request_user = $this->modelo->updateProveedor($idProveedor,$strIdentificacion,$strNombre,$strApellido,$intTelefono,$strEmail,$strDireccion,$strEmpresa,$intStatus);
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
						$arrResponse = array("status" => false , "msg" => "Este Proveedor ya existe, verifique los datos.");
					}else{
						$arrResponse = array("status" => false , "msg" => "No es posible almacenar los datos.");
					}

				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);	
			}
			die(); 	
		}

		public function getProveedores()
		{
			if($_SESSION['PermisosMod']['r']){
				$arrData = $this->modelo->selectProveedores();
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
					$btnView = '<button class="btn btn-info btn-sm btnViewProveedor" onClick="fntViewProveedor('.$arrData[$i]['id_proveedores'].')" title="Ver Usuarios"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['PermisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary btn-sm btnProveedor" onClick="fntEditProveedor('.$arrData[$i]['id_proveedores'].')" title="Editar Usuario"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['PermisosMod']['d']){
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelProveedor" onClick="fntDelProveedor('.$arrData[$i]['id_proveedores'].')" title="Eliminar Usuario"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
						//El atributo rl sirve para setear el id del rol
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getProveedor($idpersona){
			if($_SESSION['PermisosMod']['r']){
				$idProveedor = intval($idpersona);
				if($idProveedor > 0)
				{
					$arrData = $this->modelo->selectProveedorr($idProveedor);
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

		public function delProveedor()
		{
			if($_SESSION['PermisosMod']['d']){
				if($_POST){
					$intIdpersona = intval($_POST['idProveedor']);
					$requestDelete = $this->modelo->deleteProveedor($intIdpersona);
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