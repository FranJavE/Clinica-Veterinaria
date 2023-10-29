<?php 

	Class RazasModel extends Mysql {
		public $intIdRaza;
		public $intIdEspecie;
		public $strRaza;
		public $strDescripcion;
		public function __construct() {
			parent::__construct();
			
		}

		public function selectRazas() {
			$sql = "SELECT r.*, e.NombreEspecie FROM tbl_raza r INNER JOIN tbl_especie e on r.id_especie = e.id_especie";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectRaza(int $idRaza) {
			$this->intIdRaza = $idRaza;
			$sql = "SELECT r.*, e.NombreEspecie FROM tbl_raza r INNER JOIN tbl_especie e on r.id_especie = e.id_especie where id_raza = $this->intIdRaza";
			//Llamamos a la funcion creada en el crud de MySQL
			$request = $this->select($sql);
			//Retornamos el resultado
			
			return $request;
		}
		public function insertRaza(int $idEspecie,string $raza,string $descripcion) {

			$return = "";
			$this->strRaza = $raza;
			$this->intIdEspecie = $idEspecie;
			$this->strDescripcion = $descripcion;

			$sql = "SELECT * FROM tbl_raza WHERE NombreRaza = '{$this->strRaza}' ";
			$request = $this->select_all($sql);

			if(empty($request)) {
				$query_insert  = "INSERT INTO tbl_raza(id_especie ,NombreRaza,Descripcion) VALUES(?,?,?)";
	        	$arrData = array($this->intIdEspecie,$this->strRaza, $this->strDescripcion);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			} else {
				$return = "exist";
			}
			return $return;
		}
		public function updateRaza(int $idRaza,int $idEspecie,string $raza, string $descripcion){
			$this->intIdRaza = $idRaza;
			$this->intIdEspecie = $idEspecie;
			$this->strRaza = $raza;
			$this->strDescripcion = $descripcion;

			$sql = "SELECT * FROM tbl_raza WHERE NombreRaza = '$this->strRaza' AND id_raza != $this->intIdRaza";
			$request = $this->select_all($sql);

			if(empty($request)) {
				$sql = "UPDATE tbl_raza SET id_especie = ?, NombreRaza = ?, Descripcion = ? WHERE id_raza = $this->intIdRaza ";
				$arrData = array($this->intIdEspecie,$this->strRaza, $this->strDescripcion);
				$request = $this->update($sql,$arrData);
			} else {
				$request = "exist";
			}
		    return $request;			
		}

		public function deleteRaza(int $idRaza) {
			$this->intIdRaza = $idRaza;
			$sql = "SELECT * FROM tbl_mascota WHERE id_raza = $this->intIdRaza ";
			$request = $this->select_all($sql);
			if(empty($request)) {
			    $sql = "DELETE FROM tbl_raza WHERE id_raza = $this->intIdRaza";
				$request = $this->Delete($sql);
				if ($request) {
					$request = 'ok';
				} else {
					$request = 'error';
				}
			} else {
				$request = "exist";
			}
		    return $request;
		}
	}
?>