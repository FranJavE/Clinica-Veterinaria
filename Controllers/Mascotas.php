<?php 
	//Pagina principal

	Class Mascotas extends Controllers
	{

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
			getPermisos(3);
		}

		public function Mascotas($params)
		{
			
			
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['Etiqueta_Pagina']="Mascotas";
			$data['Titulo_pagina'] = "Mascotas";
			$data['Nombre_pagina'] = "Mascotas";
			$data['page_functions_js'] = "function_Mascotas.js";
			$this->views->getViews($this,"Mascotas",$data);
		}
		public function setMascotas(){
			if($_POST){
				//dep($_POST);
				if(empty($_POST['txtNombre'])  || empty($_POST['listRazaid']) || empty($_POST['txtPeso']) || empty($_POST['txtAltura']) || empty($_POST['listDuenoId']) || empty($_POST['listStatus'])){

						$arrResponse = array("status" => false, "msg" => "Datos incorrectos.");

				}else{
					$idMascota = intval($_POST['idMascota']);
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$intlistRazaid = intval(strClean($_POST['listRazaid']));
					$intPeso = floatval(strClean($_POST['txtPeso']));
					$intAltura = floatval(strClean($_POST['txtAltura']));
					$intlistDuenoId = intval(strClean($_POST['listDuenoId']));
					$intStatus = intval(strClean($_POST['listStatus']));
					if($idMascota == 0)
					{
						$option = 1;
						if($_SESSION['PermisosMod']['w']){
							$request_mas= $this->modelo->insertMascotas($strNombre,$intlistRazaid,$intPeso,$intAltura,$intlistDuenoId,$intStatus);
						}
					}else{
						$option = 2;
						if($_SESSION['PermisosMod']['u']){
							$request_mas = $this->modelo->updateMascota($idMascota,$strNombre,$intlistRazaid,$intPeso,$intAltura,$intlistDuenoId,$intStatus);
						}
					}


					if($request_mas > 0)
					{
						if($option == 1){
							$arrResponse = array("status" => true , "msg" => "Datos Guardados Correctamente.");	
						}else{
							$arrResponse = array("status" => true , "msg" => "Datos Actualizados Correctamente.");
						}
						
					}else if($request_mas == 'exist'){
						$arrResponse = array("status" => false , "msg" => "Este Usuario ya exste, verifique los datos.");
					}else{
						$arrResponse = array("status" => false , "msg" => "No es posible almacenar los datos.");
					}

				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);	
			}
			die(); 	
		}

		public function getMascotas()
		{
			if($_SESSION['PermisosMod']['r']){
				$arrData = $this->modelo->selectMascotas();
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
					$btnView = '<button class="btn btn-info btn-sm btnViewMascota" onClick="fntViewMascota('.$arrData[$i]['id_mascota'].')" title="Ver Mascota"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['PermisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary btn-sm btnMascota" onClick="fntEditMascota('.$arrData[$i]['id_mascota'].')" title="Editar Mascota"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['PermisosMod']['d']){
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelMascota" onClick="fntDelMascota('.$arrData[$i]['id_mascota'].')" title="Eliminar Mascota"><i class="far fa-trash-alt"></i></button>';
					}

					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
						//El atributo rl sirve para setear el id del rol
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getMascota($id_mascota)
		{
			if($_SESSION['PermisosMod']['r']){
				$id_mascota = intval($id_mascota);
				if($id_mascota > 0)
				{
					$arrData = $this->modelo->selectMascota($id_mascota);
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
		public function getSelectEspecie()
		{
			$htmlOptions = "";
			$arrData = $this->modelo->selectEspecie();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData); $i++){
					$htmlOptions .= '<option value="'.$arrData[$i]['id_especie'].'">'.$arrData[$i]['NombreEspecie'].'</options>';
				}
			}
			echo $htmlOptions;
			die();						
		}
		public function getSelectRaza(int $id_especie)
		{
			$id_especie = intval($id_especie);
			if($id_especie > 0)
			{
				//dep($_POST);
				$htmlOptions = "";
				$arrData = $this->modelo->selectRaza($id_especie);
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData); $i++){
						$htmlOptions .= '<option value="'.$arrData[$i]['id_raza'].'">'.$arrData[$i]['NombreRaza'].'</options>';
					}
				}
				echo $htmlOptions;
			}
			die();
		}
		
		public function getSelectMascota(int $id_Dueno)
		{
			$id_Dueno = intval($id_Dueno);
			if($id_Dueno > 0)
			{
				//dep($_POST);
				$htmlOptions = "";
				$arrData = $this->modelo->selectMascotaDueno($id_Dueno);
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData); $i++){
						$htmlOptions .= '<option value="'.$arrData[$i]['id_mascota'].'">'.$arrData[$i]['Nombre'].'</options>';
						//$htmlOptions .= '<option value="'.$arrData[$i]['id_raza'].'">'.$arrData[$i]['NombreEspecie'].' | '.$arrData[$i]['NombreRaza'].'</options>';
					}
				}
				echo $htmlOptions;
			}
			die();
		}
		public function delMascota()
		{
			if($_SESSION['PermisosMod']['d']){
				if($_POST){
					$intidMascota = intval($_POST['idMascota']);
					$requestDelete = $this->modelo->deleteMascota($intidMascota);
						if($requestDelete)
						{
							$arrResponse = array("status" => true , "msg" => "Se ha eliminado la mascota");


						}else{
							$arrResponse = array("status" => false , "msg" => "Error al eliminar la mascota");

						}
						echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
		die();
		}


	}
?>