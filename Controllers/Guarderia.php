<?php 
	//Pagina principal                

	Class Guarderia extends Controllers{

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
			getPermisos(8);
		}

		public function Guarderia($params)
		{
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['Etiqueta_Pagina']="Guarderia";
			$data['Titulo_pagina'] = "Guarderia";
			$data['Nombre_pagina'] = "Guarderia";
			$data['page_functions_js'] = "function_Guarderia.js";
			$this->views->getViews($this,"Guarderia",$data);
		}

		public function setGuarderia(){
			if($_POST){
				//dep($_POST); exit();
				if(empty($_POST['listPaciente']) || empty($_POST['listJaula']) || empty($_POST['txtDescripcion']) || empty($_POST['txtPrecio'])|| empty($_POST['txtFechallegada'])|| empty($_POST['txtHorallegada'])|| empty($_POST['txtFechaSalida'])|| empty($_POST['txtHorallegada'])){

						$arrResponse = array("status" => false, "msg" => "Datos incorrectos.");

				}else{
					$idGuarderia = intval($_POST['idGuarderia']);
					$intIsPaciente = intval($_POST['listPaciente']);
					$intIsJaula = intval($_POST['listJaula']);
					$strDescripcion = ucwords(strClean($_POST['txtDescripcion']));
					$intPrecio = intval($_POST['txtPrecio']);
					$DateFechallegada = strClean($_POST['txtFechallegada']);
					$strHorallegada = strClean($_POST['txtHorallegada']);
					$DateFechaSalida = strClean($_POST['txtFechaSalida']);
					$strHoraSalida = strClean($_POST['txtHorallegada']);;
					$intStatus = intval($_POST['listStatus']);
					$request_user = "";
					if($idGuarderia == 0)
					{
						$option = 1;
						if($_SESSION['PermisosMod']['w']){
							$request_user = $this->modelo->insertGuarderia($intIsPaciente, $intIsJaula, $strDescripcion, $intPrecio, $DateFechallegada, $strHorallegada, $DateFechaSalida, $strHoraSalida);
						}
					}else{
						$option = 2;
						if($_SESSION['PermisosMod']['u']){
							 $request_user = $this->modelo->updateGuarderia($idGuarderia,$intIsPaciente, $intIsJaula, $strDescripcion, $intPrecio, $DateFechallegada, $strHorallegada, $DateFechaSalida, $strHoraSalida,$intStatus);
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
						$arrResponse = array("status" => false , "msg" => "Ya se registro esta Guarderia, verifique los datos.");
					}else{
						$arrResponse = array("status" => false , "msg" => "No es posible almacenar los datos.");
					}

				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);	
			}
			die(); 	
		}
		public function getGuarderias()
		{
			if($_SESSION['PermisosMod']['r']){
				$arrData = $this->modelo->selectGuarderias();
				//dep($arrData);
				for ($i=0; $i < count($arrData); $i++) { 
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';
					$btnBaja = '';
					$estado = $arrData[$i]['status'];
					if ($arrData[$i]['status'] == 1) {

						$arrData[$i]['status'] = ' <span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Fuera</span>';
					}
					$arrData[$i]['Precio'] = SMONEY.' '.formatMoney($arrData[$i]['Precio']);
					if($_SESSION['PermisosMod']['r']){
					$btnView = '<button class="btn btn-info btn-sm btnViewGuarderia" onClick="fntViewGuarderia('.$arrData[$i]['id_guarderia'].')" title="Ver guarderia"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['PermisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary btn-sm btnGuarderia" onClick="fntEditGuarderia(this, '.$arrData[$i]['id_guarderia'].')" title="Editar guarderia"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['PermisosMod']['d']){
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelGuarderia" onClick="fntDelGuarderia('.$arrData[$i]['id_guarderia'].')" title="Eliminar guarderia"><i class="far fa-trash-alt"></i></button>';
					}
					if($_SESSION['PermisosMod']['u']){
						if($estado == 1){
							$btnBaja = '<button class="btn btn-warning btn-sm btnbajaGuarderia" onClick="fntbajaGuarderia('.$arrData[$i]['id_guarderia'].')" title="Sacar de guarderia"><i class="fas fa-sign-out-alt"></i></button>';
						}else{
							$btnBaja = '<button class="btn btn-warning btn-sm" disabled><i class="fas fa-sign-out-alt"></i></button>';
						}
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.' '.$btnBaja.'</div>';
						//El atributo rl sirve para setear el id del rol
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getGuarderia($idGuarderia){
			if($_SESSION['PermisosMod']['r']){
				$idGuarderia = intval($idGuarderia);
				if($idGuarderia > 0)
				{
					$arrData = $this->modelo->selectGuarderia($idGuarderia);
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
		public function delGuarderia()
		{
			if($_SESSION['PermisosMod']['d']){
				//dep($_POST); exit();
				if($_POST){
					$idGuarderia = intval($_POST['idGuarderia']);
					$requestDelete = $this->modelo->deleteGuarderia($idGuarderia);
						if($requestDelete)
						{
							$arrResponse = array("status" => true , "msg" => "Se ha eliminado el registro de guarderia");


						}else{
							$arrResponse = array("status" => false , "msg" => "Error al eliminar el registro de guarderia");

						}
						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				 }
			}
			die();

		}
		public function bajaGuarderia()
		{
			if($_SESSION['PermisosMod']['u']){
				//dep($_POST); exit();
				if($_POST){
					$idGuarderia = intval($_POST['idGuarderia']);
					$requestDelete = $this->modelo->updateSalida($idGuarderia);
						if($requestDelete)
						{
							$arrResponse = array("status" => true , "msg" => "La mascota se ha ido con su dueño");


						}else{
							$arrResponse = array("status" => false , "msg" => "Error al dar de baja el registro de guarderia");

						}
						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				 }
			}
			die();

		}
	}


?>