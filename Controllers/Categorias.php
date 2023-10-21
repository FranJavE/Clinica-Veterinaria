<?php 
	//Pagina principal

	Class Categorias extends Controllers{

		Public function __construct()
		{
			$this->views = new Views();
			parent::__construct();
			session_start();
			session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(11);
		}
		public function Categorias($params)
		{
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['Etiqueta_Pagina']="Categoria";
			$data['Titulo_pagina'] = "Categoria";
			$data['Nombre_pagina'] = "Categoria";
			$data['page_functions_js'] = "function_Categorias.js";
			$this->views->getViews($this,"Categorias",$data);
		}
		public function setCategoria(){
			if($_POST){
				/*dep($_POST);
				dep($_FILES);
				exit();*/
				if(empty($_POST['txtNombre']) || empty($_POST['txtDescripcion']) || empty($_POST['listStatus']) ) {
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				} else {
					
					$intIdcategoria = intval($_POST['idCategoria']);
					$strCategoria =  strClean($_POST['txtNombre']);
					$ = strClean($_POST['txtDescripcion']);
					$intStatus = intval($_POST['listStatus']);

					$ruta = strtolower(clear_cadena($strCategoria));
					$ruta = str_replace(" ", "-", $ruta);

					$foto   	 	= $_FILES['foto'];
					$nombre_foto 	= $foto['name'];
					$type 		 	= $foto['type'];
					$url_temp    	= $foto['tmp_name'];
					$imgPortada 	= 'portada_categoria.png';
					$request_cateria = "";
					if($nombre_foto != ''){
						$imgPortada = 'img_'.md5(date('d-m-Y H:m:s')).'.jpg';
					}

					if($intIdcategoria == 0)
					{
						//Crear
						if($_SESSION['PermisosMod']['w']){
							$request_cateria = $this->modelo->inserCategoria($strCategoria, $strDescipcion, $imgPortada, $ruta, $intStatus);
							$option = 1;
						}
					}else{
						//Actualizar
						if($_SESSION['PermisosMod']['u']){
							if($nombre_foto == ''){
								if($_POST['foto_actual'] != 'portada_categoria.png' && $_POST['foto_remove'] == 0 ){
									$imgPortada = $_POST['foto_actual'];
								}
							}
							$request_cateria = $this->modelo->updateCategoria($intIdcategoria, $strCategoria, $strDescipcion, $imgPortada, $ruta,$intStatus);
							$option = 2;
						}
					}
					if($request_cateria > 0 )
					{
						if($option == 1)
						{
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
							if($nombre_foto != ''){ uploadImage($foto,$imgPortada); }
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
							if($nombre_foto != ''){ uploadImage($foto,$imgPortada); }

							if(($nombre_foto == '' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'portada_categoria.png')
								|| ($nombre_foto != '' && $_POST['foto_actual'] != 'portada_categoria.png')){
								deleteFile($_POST['foto_actual']);
							}
						}
					}else if($request_cateria == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! La categoría ya existe.');
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getCategorias()
		{
			if($_SESSION['PermisosMod']['r']){
				$arrData = $this->modelo->selectCategorias();
				for ($i=0; $i < count($arrData); $i++) {
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

					if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}

					if($_SESSION['PermisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm" onClick="fntViewInfo('.$arrData[$i]['id_categoria'].')" title="Ver categoría"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['PermisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary  btn-sm" onClick="fntEditInfo(this,'.$arrData[$i]['id_categoria'].')" title="Editar categoría"><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['PermisosMod']['d']){	
						$btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDelInfo('.$arrData[$i]['id_categoria'].')" title="Eliminar categoría"><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getCategoria($idcategoria)
		{
			if($_SESSION['PermisosMod']['r']){
				$intIdcategoria = intval($idcategoria);
				if($intIdcategoria > 0)
				{
					$arrData = $this->modelo->selectCategoria($intIdcategoria);
					if(empty($arrData))
					{
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrData['url_portada'] = media().'/images/uploads/'.$arrData['portada'];
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function delCategoria()
		{
			if($_POST){
				if($_SESSION['PermisosMod']['d']){
					$intIdcategoria = intval($_POST['idCategoria']);
					$requestDelete = $this->modelo->deleteCategoria($intIdcategoria);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la categoría');
					}else if($requestDelete == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'No es posible eliminar una categoría con productos asociados.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la categoría.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function getSelectCategorias(){
			$htmlOptions = "";
			$arrData = $this->modelo->selectCategorias();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					if($arrData[$i]['status'] == 1 ){
					$htmlOptions .= '<option value="'.$arrData[$i]['id_categoria'].'">'.$arrData[$i]['nombre_categoria'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();	
		}

	
	}
?>