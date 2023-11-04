<?php 
	//Pagina principal

	Class Roles extends Controllers{
		public $views;
		public $modelo;
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

		public function Roles()
		{
		
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['page_id']=3;
			$data['Etiqueta_Pagina']="Roles Usuarios";
			$data['Titulo_pagina'] = "Roles Usuarios";
			$data['Nombre_pagina'] = "Roles_Usuarios";
			$data['page_functions_js'] = "function_roles.js";
			$this->views->getViews($this,"Roles",$data);
		}

		public function getRoles()
		{
			if($_SESSION['PermisosMod']['r']){
				$arrData = $this->modelo->selectRoles();
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
					$btnView = '';
					}
					if($_SESSION['PermisosMod']['u']){
					$btnEdit = '<button class="btn btn-secondary btn-sm btnPermisosRol" onClick="fntPermisos('.$arrData[$i]['id_rol'].')" title="Permisos"><i class="fas fa-key"></i></button>
					<button class="btn btn-primary btn-sm btnEditRol" onClick="fntEditRol('.$arrData[$i]['id_rol'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['PermisosMod']['d']){
					$btnDelete = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol('.$arrData[$i]['id_rol'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';

				}

				//Implementamos el arrays con formado JSON para que pueda ser interpretado por cualquier lenguaje de programacion
				echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getSelectRoles()
		{
			$htmlOptions = "";
			$arrData = $this->modelo->selectRoles();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData); $i++){
					if($arrData[$i]['status'] == 1 ){
					$htmlOptions .= '<option value="'.$arrData[$i]['id_rol'].'">'.$arrData[$i]['NombreRol'].'</options>';
				}
				}

			}
			echo $htmlOptions;
			die();
						
		}

		//metodo para extraer un rol
		public function getRol($idrol){
			if($_SESSION['PermisosMod']['r']){
			$intIdRol = intval(strClean($idrol));
			   if ($intIdRol > 0) { 
				$arrData = $this->modelo->selectRol($intIdRol);
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

		public function setRol(){
			
			if($_POST)
			{
			
			$intIdrol = intval($_POST['idRol']);
			$strRol =  strClean($_POST['txtNombre']);
			$strDescipcion = strClean($_POST['txtDescripcion']);
			$intStatus = intval($_POST['listStatus']);
			$request_rol = "";
			if($intIdrol == 0)
			{
				//Crear
				if($_SESSION['PermisosMod']['w']){
					$request_rol = $this->modelo->insertRol($strRol, $strDescipcion,$intStatus);
					$option = 1;
				}
			}else{
				//Actualizar
				if($_SESSION['PermisosMod']['u']){
					$request_rol = $this->modelo->updateRol($intIdrol, $strRol, $strDescipcion, $intStatus);
					$option = 2;
				}
			}

			if($request_rol > 0 )
			{

				if($option == 1)
				{
					$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
				}else{
					$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
				}
				
			}else if($request_rol == 'exist'){
				
				$arrResponse = array('status' => false, 'msg' => '¡Atención! El Rol ya existe.');
			}else{
				$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
		
	}

	//Eliminar Rol
		public function delRol()
		{
			if($_SESSION['PermisosMod']['d']){
				if($_POST)
				{
					$intIdRol =  intval($_POST['id_rol']);
					$requestDelete = $this->modelo->deleteRol($intIdRol);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el rol');
					}elseif ( $requestDelete == 'exist') {
						$arrResponse = array('status' => false, 'msg' => 'No se ha podido elminar un ROl asociado a usuarios');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el Rol');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
		    }

			die();
		
		}
}


?>