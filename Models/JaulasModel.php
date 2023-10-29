<?php 

	Class JaulasModel extends Mysql {
		public $intIdJaula;
		public $strJaula;
		public $intNumeroJaula;
		public $strDescripcion;
		public function __construct() {
			parent::__construct();
			
		}

		public function selectJaulas() {
			$sql = "SELECT * FROM tbl_jaula";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectJaula(int $idJaula) {
			$this->intIdJaula = $idJaula;
			$sql = "SELECT * FROM tbl_jaula where id_jaula  = $this->intIdJaula";
			//Llamamos a la funcion creada en el crud de MySQL
			$request = $this->select($sql);
			//Retornamos el resultado
			
			return $request;
		}
		public function insertJaula(string $jaula,int $numeroJaula,string $descripcion) {

			$return = "";
			$this->strJaula = $jaula;
			$this->intNumeroJaula = $numeroJaula;
			$this->strDescripcion = $descripcion;

			$sql = "SELECT * FROM tbl_jaula WHERE nombre_jaula = '{$this->strJaula}' AND numero_jaula = '{$this->intNumeroJaula}'";
			$request = $this->select_all($sql);

			if(empty($request)) {
				$query_insert  = "INSERT INTO tbl_jaula(nombre_jaula,numero_jaula,Descripcion) VALUES(?,?,?)";
	        	$arrData = array( $this->strJaula,$this->intNumeroJaula, $this->strDescripcion);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			} else {
				$return = "exist";
			}
			return $return;
		}
		public function updateJaula(int $idJaula,string $jaula, int $numeroJaula, string $descripcion) {
			$this->intIdJaula = $idJaula;
			$this->intNumeroJaula = $numeroJaula;
			$this->strJaula = $jaula;
			$this->strDescripcion = $descripcion;

			$sql = "SELECT * FROM tbl_jaula WHERE (nombre_jaula = '$this->strJaula' OR numero_jaula = $this->intNumeroJaula) AND id_jaula  != $this->intIdJaula";
			$request = $this->select_all($sql);

			if(empty($request)) {
				$sql = "UPDATE tbl_jaula SET nombre_jaula = ?, numero_jaula = ?, Descripcion = ? WHERE id_jaula  = $this->intIdJaula ";
				$arrData = array($this->strJaula, $this->intNumeroJaula, $this->strDescripcion);
				$request = $this->update($sql,$arrData);
			} else {
				$request = "exist";
			}
		    return $request;			
		}

		public function deleteJaula(int $idJaula) {
			$this->intIdJaula = $idJaula;
			$sql = "SELECT * FROM tbl_guarderia WHERE id_jaula = $this->intIdJaula ";
			$request = $this->select_all($sql);
			if(empty($request)) {
				$sql = "DELETE FROM tbl_jaula WHERE id_jaula  = $this->intIdJaula ";
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