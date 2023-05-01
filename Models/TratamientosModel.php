<?php 

	Class TratamientosModel extends Mysql
	{
		public $intIdtratamiento;
		public $strTratamiento;
		public $strDescripcion;
		public $intStatus;
		public function __construct()
		{
			parent::__construct();
			
		}

		public function selectTratamientos()
		{
			$sql = "SELECT * FROM tbl_tratamiento where status != 0";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectTratamiento(int $idtratamiento)
		{
			$this->intIdTratamiento = $idtratamiento;
			$sql = "SELECT * FROM tbl_tratamiento where id_tratamiento = $this->intIdTratamiento";
			//Llamamos a la funcion creada en el crud de MySQL
			$request = $this->select($sql);
			//Retornamos el resultado
			
			return $request;
		}
		public function insertTratamiento(string $tratamiento, string $descripcion, int $status){

			$return = "";
			$this->strTratamiento = $tratamiento;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM tbl_tratamiento WHERE NombreTratamiento = '{$this->strTratamiento}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO tbl_tratamiento(NombreTratamiento,Descripcion,status) VALUES(?,?,?)";
	        	$arrData = array($this->strTratamiento, $this->strDescripcion, $this->intStatus);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}
		public function updateTratamiento(int $idtratamiento, string $tratamiento, string $descripcion, int $status){
			$this->intIdtratamiento = $idtratamiento;
			$this->strTratamiento = $tratamiento;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM tbl_tratamiento WHERE NombreTratamiento = '$this->strTratamiento' AND id_tratamiento != $this->intIdtratamiento";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE tbl_tratamiento SET NombreTratamiento = ?, Descripcion = ?, status = ? WHERE id_tratamiento = $this->intIdtratamiento ";
				$arrData = array($this->strTratamiento, $this->strDescripcion, $this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}

		public function deleteTratamiento(int $idtratamiento)
		{
			$this->intIdtratamiento = $idtratamiento;
			$sql = "SELECT * FROM tbl_consultas WHERE id_tratamiento= $this->intIdtratamiento ";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "UPDATE tbl_tratamiento SET status = ? WHERE id_tratamiento = $this->intIdtratamiento ";
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