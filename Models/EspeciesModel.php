<?php 

	Class EspeciesModel extends Mysql {
		public $intIdEspecie;
		public $strEspecie;
		public $strDescripcion;
		public function __construct() {
			parent::__construct();
			
		}

		public function selectEspecies() {
			$sql = "SELECT * FROM tbl_especie";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectEspecie(int $idEspecie) {
			$this->intIdEspecie = $idEspecie;
			$sql = "SELECT * FROM tbl_especie where id_especie  = $this->intIdEspecie";
			//Llamamos a la funcion creada en el crud de MySQL
			$request = $this->select($sql);
			//Retornamos el resultado
			
			return $request;
		}
		public function insertEspecie(string $especie,string $descripcion) {

			$return = "";
			$this->strEspecie = $especie;
			$this->strDescripcion = $descripcion;

			$sql = "SELECT * FROM tbl_especie WHERE NombreEspecie = '{$this->strEspecie}' ";
			$request = $this->select_all($sql);

			if(empty($request)) {
				$query_insert  = "INSERT INTO tbl_especie(NombreEspecie,Descripcion) VALUES(?,?)";
	        	$arrData = array($this->strEspecie, $this->strDescripcion);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			} else {
				$return = "exist";
			}
			return $return;
		}
		public function updateEspecie(int $idEspecie,string $especie, string $descripcion) {
			$this->intIdEspecie = $idEspecie;
			$this->strEspecie = $especie;
			$this->strDescripcion = $descripcion;

			$sql = "SELECT * FROM tbl_especie WHERE NombreEspecie = '$this->strEspecie' AND id_especie  != $this->intIdEspecie";
			$request = $this->select_all($sql);

			if(empty($request)) {
				$sql = "UPDATE tbl_especie SET NombreEspecie = ?, Descripcion = ? WHERE id_especie  = $this->intIdEspecie ";
				$arrData = array($this->strEspecie, $this->strDescripcion);
				$request = $this->update($sql,$arrData);
			} else {
				$request = "exist";
			}
		    return $request;			
		}

		public function deleteEspecie(int $idEspecie) {
			$this->intIdEspecie = $idEspecie;
			$sql = "SELECT * FROM tbl_raza WHERE id_especie = $this->intIdEspecie ";
			$request = $this->select_all($sql);
			if(empty($request)) {
				$sql = "DELETE FROM tbl_especie WHERE id_especie  = $this->intIdEspecie ";
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