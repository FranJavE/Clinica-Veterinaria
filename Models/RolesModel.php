<?php 

	Class RolesModel extends Mysql
	{
		public $intIdrol;
		public $strRol;
		public $strDescripcion;
		public $intStatus;
		public function __construct()
		{
			parent::__construct();
			
		}

		public function selectRoles()
		{
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1){
				$whereAdmin = " and id_rol != 1 and id_rol != 3";
			}
			$sql = "SELECT * FROM tbl_rol where status != 0".$whereAdmin;
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectRol(int $idrol)
		{
			$this->intIdRol = $idrol;
			$sql = "SELECT * FROM tbl_rol where id_rol = $this->intIdRol";
			//Llamamos a la funcion creada en el crud de MySQL
			$request = $this->select($sql);
			//Retornamos el resultado
			
			return $request;
		}
		public function insertRol(string $rol, string $descripcion, int $status){

			$return = "";
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM tbl_rol WHERE NombreRol = '{$this->strRol}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO tbl_rol(NombreRol,Descripcion,status) VALUES(?,?,?)";
	        	$arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}
		public function updateRol(int $idrol, string $rol, string $descripcion, int $status){
			$this->intIdrol = $idrol;
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM tbl_rol WHERE NombreRol = '$this->strRol' AND id_rol != $this->intIdrol";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE tbl_rol SET NombreRol = ?, Descripcion = ?, status = ? WHERE id_rol = $this->intIdrol ";
				$arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}

		public function deleteRol(int $idrol)
		{
			$this->intIdrol = $idrol;
			$sql = "SELECT * FROM tbl_persona WHERE id_rol= $this->intIdrol ";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "UPDATE tbl_rol SET status = ? WHERE id_rol = $this->intIdrol ";
				$arrData = array(0);
				$request = $this->update($sql,$arrData);
				if($request)
				{
					$request = 'ok';
				}else
				{
					$request = 'error';
				}
			}else{
				$request = "exist";
			}
		    return $request;
		}
	

	}
?>