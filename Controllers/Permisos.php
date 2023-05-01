<?php 

	Class Permisos extends Controllers{
		public function __construct()
		{
			//$this->views = new Views();
			//Como estamos heredando ejecutamos el metodo constructor de la clase padre
			parent::__construct();
			session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
		}
		public function getPermisosRol(int $idrol)
		{
			$rolid = intval($idrol);
			if($rolid > 0)
			{
				$arrModulos = $this->modelo->selectModulos();
				$arrPermisosRol = $this->modelo->selectPermisosRol($rolid);
				$arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
				$arrPermisoRol = array('id_rol' => $rolid );

				if(empty($arrPermisosRol))
				{
					for ($i=0; $i < count($arrModulos) ; $i++) { 

						$arrModulos[$i]['permisos'] = $arrPermisos;
					}
				}else{
					for ($i=0; $i < count($arrModulos); $i++) {
						$arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
						if(isset($arrPermisosRol[$i]))
						{
						$arrPermisos = array('r' => $arrPermisosRol[$i]['r'], 
											 'w' => $arrPermisosRol[$i]['w'], 
											 'u' => $arrPermisosRol[$i]['u'], 
											 'd' => $arrPermisosRol[$i]['d'] 
											);
					}
							$arrModulos[$i]['permisos'] = $arrPermisos;
					}
				}
				$arrPermisoRol['modulos'] = $arrModulos;
				$html = getModal("modalPermisos",$arrPermisoRol);
				//dep($arrPermisoRol);

			}
			die();
		}
	public function setPermisos()
	{
			//dep($_POST);
			if($_POST)
			{
				$intIdrol = intval($_POST['id_rol']);
				$modulos = $_POST['modulos'];

				$this->modelo->deletePermisos($intIdrol);
				foreach ($modulos as $modulo) {
					$idModulo = $modulo['id_modulo'];
					$r = empty($modulo['r']) ? 0 : 1;
					$w = empty($modulo['w']) ? 0 : 1;
					$u = empty($modulo['u']) ? 0 : 1;
					$d = empty($modulo['d']) ? 0 : 1;
					$requestPermiso = $this->modelo->insertPermisos($intIdrol, $idModulo, $r, $w, $u, $d);
				}
				if($requestPermiso > 0)
				{
					$arrResponse = array('status' => true, 'msg' => 'Permisos asignados correctamente.');
				}else{
					$arrResponse = array("status" => false, "msg" => 'No es posible asignar los permisos.');
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

	}
?>