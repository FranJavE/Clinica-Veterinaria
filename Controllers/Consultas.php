<?php 
	//Pagina principal

	Class Consultas extends Controllers{

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
			getPermisos(5);
		}

		public function Consultas($params)
		{
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['Etiqueta_Pagina']="Consultas";
			$data['Titulo_pagina'] = "Consultas";
			$data['Nombre_pagina'] = "Consultas";
			$data['page_functions_js'] = "function_Consultas.js";
			$this->views->getViews($this,"Consultas",$data);
		}
		public function setConsultas(){
			if($_POST){
				//dep($_POST);
				if(empty($_POST['listPaciente']) || empty($_POST['listMedicoId']) || 
					empty($_POST['txtDescripcion']) || empty($_POST['txtFecha']) || empty($_POST['txtHora']) || empty($_POST['txtPrecio']) )
				{

						$arrResponse = array("status" => false, "msg" => "Datos incorrectos.");

				}else{
					$idConsulta = intval($_POST['idConsulta']);
					$intIsPaciente = intval($_POST['listPaciente']);
					$intIsMedico = intval($_POST['listMedicoId']);
					$strDescripcion = ucwords(strClean($_POST['txtDescripcion']));
					$DateFecha = strClean($_POST['txtFecha']);
					$strHora = strClean($_POST['txtHora']);
					$intPrecio = intval($_POST['txtPrecio']);
					$request_user = "";
					if($idConsulta == 0)
					{
						$option = 1;
						if($_SESSION['PermisosMod']['w']){
							$request_user = $this->modelo->insertConsulta($intIsPaciente ,$intIsMedico ,$strDescripcion ,$DateFecha ,$strHora ,$intPrecio);
						}
					}else{
						$option = 2;
						if($_SESSION['PermisosMod']['u']){
							 $request_user = $this->modelo->updateConsulta($idConsulta,$intIsPaciente ,$intIsMedico ,$strDescripcion ,$DateFecha ,$strHora ,$intPrecio);
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
						$arrResponse = array("status" => false , "msg" => "Ya se registro esta Consulta, verifique los datos.");
					}else{
						$arrResponse = array("status" => false , "msg" => "No es posible almacenar los datos.");
					}

				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);	
			}
			die(); 	
		}
		public function getConsultas()
		{
			if($_SESSION['PermisosMod']['r']){
				$arrData = $this->modelo->selecConsultas();
				//dep($arrData);
				for ($i=0; $i < count($arrData); $i++) { 
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';
					$btnImprimir = '';
					if ($arrData[$i]['status'] == 1) {

						$arrData[$i]['status'] = ' <span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}
					$arrData[$i]['Precio'] = SMONEY.' '.formatMoney($arrData[$i]['Precio']);
					if($_SESSION['PermisosMod']['r']){
					$btnView = '<button class="btn btn-info btn-sm btnViewConsulta" onClick="fntViewConsulta('.$arrData[$i]['id_Consulta'].')" title="Ver Consulta"><i class="far fa-eye"></i></button>';
					$btnImprimir = '<button class="btn btn-outline-secondary btn-sm btnImprimirConsulta" onClick="fntImprimirConsulta('.$arrData[$i]['id_Consulta'].')" title="Imprimir Consulta"><i class="fas fa-print"></i></button>';
					}
					if($_SESSION['PermisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary btn-sm btnConsulta" onClick="fntEditConsulta(this, '.$arrData[$i]['id_Consulta'].')" title="Editar consulta"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['PermisosMod']['d']){
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelConsulta" onClick="fntDelConsulta('.$arrData[$i]['id_Consulta'].')" title="Eliminar consulta"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.' '.$btnImprimir.'</div>';
						//El atributo rl sirve para setear el id del rol
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getConsulta($idConsulta) {
			if ($_SESSION['PermisosMod']['r']){
				$idConsulta = intval($idConsulta);
				if ($idConsulta > 0) {
					$arrData = $this->modelo->selectConsulta($idConsulta);
					if (empty($arrData)) {
						$arrResponse = array("status" => false , "msg" => "No se encontraron datos");
					}else{
						$arrResponse = array("status" => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();

		}
		public function delConsulta()
		{
			if($_SESSION['PermisosMod']['d']){
				if($_POST){
					$idConsulta = intval($_POST['idConsulta']);
					$requestDelete = $this->modelo->deleteConsulta($idConsulta);
						if($requestDelete)
						{
							$arrResponse = array("status" => true , "msg" => "Se ha eliminado el registro de consultacion");


						}else{
							$arrResponse = array("status" => false , "msg" => "Error al eliminar el registro de consultacion");

						}
						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				 }
			}
			die();

		}

	   public function getfactura($idConsulta)
		{
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$arrData = $this->modelo->selectConsulta($idConsulta);
			$data['NombreMascota'] =  $arrData['NombreMascota'];
			$data['page_functions_js'] = "function_Consultas.js";
			$this->views->getViews($this,"factura",$data);
		}
	}


?>