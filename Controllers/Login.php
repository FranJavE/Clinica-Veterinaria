<?php 

	Class Login extends Controllers{

		public function __construct()
		{
			session_start();
			if(isset($_SESSION['login']))
			{
				header('Location: '.base_url().'/dashboard');
			}
			$this->views = new Views();
			//Como estamos heredando ejecutamos el metodo constructor de la clase padre
			parent::__construct();
		}
		public function login()
		{ 
			
			$data['page_tag'] = "Clinica Veterinaria"; 
			//Titulo de la pagina
			$data['page_title'] = "Clinica Veterinaria 'El Gato'";
			$data['page_name'] = "login";
			//Contenido de la pagina
			$data['page_function_js'] = "function_login.js";
			$this->views->getViews($this,"login", $data);
		}
		
		public function loginUser(){
			//dep($_POST);
			if($_POST)
			{
				if (empty($_POST['txtEmail']) || empty($_POST['txtPassword'])) {
					$arrResponse = array('status' => false, 'msg' => 'Error de datos');
				}else{
					$strUsuario = strtolower(strClean($_POST['txtEmail']));
					$strPassword = hash("SHA256", $_POST['txtPassword']);
					$requestUser = $this->modelo->loginUser($strUsuario, $strPassword);
					if(empty($requestUser)){
						$arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto. ');
					}else{
						$arrData = $requestUser;
						if($arrData['status'] == 1){
							$_SESSION['idUser'] = $arrData['id_persona'];
							$_SESSION['login'] = true;
							$arrData = $this->modelo->sessionLogin($_SESSION['idUser']);
							sessionUser($_SESSION['idUser']);
							//$_SESSION['userData'] = $arrData;
							$arrResponse = array('status' => true, 'msg' => 'OKIS ');
						}else{
							$arrResponse = array('status' => false, 'msg' => 'El usuario esta inactivo ');
						}
					}
				}
				sleep(1);
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function resetPass()
		{
			//dep($_POST);
			if($_POST){
				error_reporting(0);

				if(empty($_POST['txtEmailReset'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos' );
				}else{
					$token = token();
					$strEmail  = strtolower(strClean($_POST['txtEmailReset']));
					$arrData = $this->modelo->getUserEmail($strEmail);

					if(empty($arrData)){
						$arrResponse = array('status' => false, 'msg' => 'Usuario no existente.' ); 
					}else{
						$idpersona = $arrData['id_persona'];
						$nombreUsuario = $arrData['Nombre'].' '.$arrData['Apellido'];

						$url_recovery = base_url().'/login/confirmUser/'.$strEmail.'/'.$token;
						$requestUpdate = $this->modelo->setTokenUser($idpersona,$token);
						//echo $requestUpdate;
						$dataUsuario = array('nombreUsuario' => $nombreUsuario,
											 'email' => $strEmail,
											 'asunto' => 'Recuperar cuenta - '.NOMBRE_REMITENTE,
											 'url_recovery' => $url_recovery);
						if($requestUpdate){
							$sendEmail = sendEmail($dataUsuario,'email_cambioPassword');
							/**var_dump($sendEmail);
							exit;*/

							if($sendEmail){
								$arrResponse = array('status' => true, 
												 'msg' => 'Se ha enviado un email a tu cuenta de correo para cambiar tu contraseña.');
							}else{
								$arrResponse = array('status' => false, 
												 'msg' => 'No es posible realizar el proceso, intenta más tarde 1.' );
							}
						}else{
							    $arrResponse = array('status' => false, 
												 'msg' => 'No es posible realizar el proceso, intenta más tarde 2.' );
						}
					}
				}
				sleep(1.5);
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);	
		}
		die();
	}

	public function confirmUser(string $params){ 
			 if(empty($params))
			 {
			 	header('Location: '.base_url());
			 }else{
			 	//echo $params;
			 	$arrParams = explode(',',$params);
			 	$strEmail = strClean($arrParams[0]);
			 	$strToken = strClean($arrParams[1]);
			 	//dep($arrParams);
			 	$arrResponse = $this->modelo->getUsuario($strEmail, $strToken);
			 	if(empty($arrResponse)){
			 		header("Location: ".base_url());
			 	}else{
			 		 $data['page_tag'] = "Cambiar Contraseña"; 
					//Titulo de la pagina
					$data['page_title'] = "cambiar_contraseña";
					$data['page_name'] = "Cambiar Contraseña <small>Clinica Veterinaria</small>";
					$data['IdPersona'] = $arrResponse['id_persona'];
					$data['email'] = $strEmail;
					$data['token'] = $strToken;

					$data['page_function_js'] = "function_login.js";
				    $this->views->getViews($this,"cambiar_password", $data);
			 	}
			 }
			 die();
	   	}
	   	public function setPassword()
	   	{
	   		//dep($_POST);
	   		if (empty($_POST['idUsuario']) || empty($_POST['txtEmail']) || empty($_POST['txtToken']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm']) )  {

	   			$arrResponse = array('status' => false, 'msg' => 'Error de datos');
	   		}else{
	   			$intIdPersona = intval($_POST['idUsuario']);
	   			$strEmail = strClean($_POST['txtEmail']);
	   			$strToken = strClean($_POST['txtToken']);
	   			$strPassword = $_POST['txtPassword'];
	   			$strPasswordConfirm = $_POST['txtPasswordConfirm'];
	   			if ($strPassword != $strPasswordConfirm) {
	   				$arrResponse = array('status' => false, 'msg' => 'Las contraseñas no son iguales');
	   			}else{
	   				$arrResponseUser = $this->modelo->getUsuario($strEmail, $strToken);
			 	if(empty($arrResponseUser)){
			 		$arrResponse = array('status' => false, 'msg' => 'Error de datos');
			 	}else{
			 		$strPassword = hash("SHA256", $strPassword);
			 		$requestPass = $this->modelo->insertPassword($intIdPersona,$strPassword);
			 		if($requestPass){
			 			$arrResponse = array('status' => true, 'msg' => 'Contraseña actualizada con exito');
			 		}else{
			 			$arrResponse = array('status' => false, 'msg' => 'No se puedo actualizar la contraseña vuelva a intentarlo mas tarde');
			 		}			 	
			 	}

	   			}
	   		}
	   		sleep(2);
	   		echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
	   		die();
	   	}
	}
?>