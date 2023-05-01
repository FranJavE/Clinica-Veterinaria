<?php 
	//Pagina principal

	Class Tratamientos extends controllers{

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

		public function Tratamientos()
		{
		
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['page_id']=3;
			$data['Etiqueta_Pagina']="Tratamientos ";
			$data['Titulo_pagina'] = "Tratamientos ";
			$data['Nombre_pagina'] = "Tratamientos ";
			$data['page_functions_js'] = "function_tratamientoes.js";
			$this->views->getViews($this,"Tratamientos",$data);
		}

		public function getTratamientos()
		{
			if($_SESSION['PermisosMod']['r']){
				$arrData = $this->modelo->selectTratamientos();
				//dep($arrData); exit();
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
					$btnView = '<button class="btn btn-info btn-sm btnViewTratamiento" onClick="fntViewTratamiento('.$arrData[$i]['id_tratamiento'].')" title="Ver guarderia"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['PermisosMod']['u']){
					$btnEdit = '<button class="btn btn-primary btn-sm btnEditTratamiento" onClick="fntEditTratamiento(this, '.$arrData[$i]['id_tratamiento'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['PermisosMod']['d']){
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelTratamiento" onClick="fntDelTratamiento('.$arrData[$i]['id_tratamiento'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';

				}

				//Implementamos el arrays con formado JSON para que pueda ser interpretado por cualquier lenguaje de programacion
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getSelectTratamientos()
		{
			$htmlOptions = "";
			$arrData = $this->modelo->selectTratamientos();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData); $i++){
					if($arrData[$i]['status'] == 1 ){
					$htmlOptions .= '<option value="'.$arrData[$i]['id_tratamiento'].'">'.$arrData[$i]['NombreTratamiento'].'</options>';
				}
				}

			}
			echo $htmlOptions;
			die();
						
		}

		//metodo para extraer un tratamiento
		public function getTratamiento($idtratamiento){
			if($_SESSION['PermisosMod']['r']){
			$intIdTratamiento = intval(strClean($idtratamiento));
			   if ($intIdTratamiento > 0) { 
				$arrData = $this->modelo->selectTratamiento($intIdTratamiento);
				if(empty($arrData)){
						$arrResponse =array('status' => false, 'msg' => 'Datos no encontrados.');
				}else{
						$arrResponse =array('status' => true, 'data' => $arrData);
				}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE); 
			
				}
			}
			//Finalizamos el proceso
			die();
		}

		public function setTratamientos(){
			
			if($_POST)
			{
			
			$intIdtratamiento = intval($_POST['idTratamiento']);
			$strTratamiento =  strClean($_POST['txtNombre']);
			$strDescipcion = strClean($_POST['txtDescripcion']);
			$intStatus = intval($_POST['listStatus']);
			$request_tratamiento = "";
			if($intIdtratamiento == 0)
			{
				//Crear
				if($_SESSION['PermisosMod']['w']){
					$request_tratamiento = $this->modelo->insertTratamiento($strTratamiento, $strDescipcion,$intStatus);
					$option = 1;
				}
			}else{
				//Actualizar
				if($_SESSION['PermisosMod']['u']){
					$request_tratamiento = $this->modelo->updateTratamiento($intIdtratamiento, $strTratamiento, $strDescipcion, $intStatus);
					$option = 2;
				}
			}

			if($request_tratamiento > 0 )
			{

				if($option == 1)
				{
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
				}else{
					$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
				}
				
			}else if($request_tratamiento == 'exist'){
				
				$arrResponse = array('status' => false, 'msg' => '¡Atención! El Tratamiento ya existe.');
			}else{
				$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
		
		}

	//Eliminar Tratamiento
		public function delTratamiento()
		{
			if($_SESSION['PermisosMod']['d']){
				if($_POST)
				{
					$intIdTratamiento =  intval($_POST['idTratamiento']);
					$requestDelete = $this->modelo->deleteTratamiento($intIdTratamiento);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el tratamiento');
					}elseif ( $requestDelete == 'exist') {
						$arrResponse = array('status' => false, 'msg' => 'No se ha podido elminar un tratamiento asociado a una consulta');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Tratamiento');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
		    }

			die();
		
		}
}


?>