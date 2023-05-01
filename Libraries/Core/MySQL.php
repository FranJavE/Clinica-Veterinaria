<?php 

	Class Mysql extends conexion{
		
		//Propiedades 
		private $conexion;
		private $strquery;
		private $arrValues;

		public function __construct()
		 {
		 	//Hace la instancia del objeto conexion
		 	$this->conexion = new conexion();

		 	$this->conexion = $this->conexion->conect();//Llamamos a la funcion connect

		 }

		 //Insertar Registros
		 public function insert(string $query, array $arrValues)
		 {
		 	//La variable query almacena la instruccion sql 
		 	$this->strquery= $query;
		 	//La variable arrValues almacena los parametros que se insertaran mediante el query
		 	$this->arrValues= $arrValues;

		 	//Preparamos el query
		 	$INSERT = $this->conexion->prepare($this->strquery);
		 	//Aca se ejecuta la instruccion 
		 	$resInsert = $INSERT->execute($this->arrValues);

		 	//Un if para validar si nos devuelve true, lo que significa que si inserto los datos, lo que significa que si inserto los datos
		 	if($resInsert)
		 	{
		 		//Aqui almacenamos el ultimo id insertado
		 		$lastInsert = $this->conexion->lastInsertId();
		 	}else{
		 		$lastInsert = 0;
		 	}
		 	return $lastInsert;


		  }
		  //Buscar un registro
		  public function select(string $query)
		  {
		  	//Alamacenamos el query
		  	$this->strquery = $query;
		  	//Preparamos el instruccion
		  	$result = $this->conexion->prepare($this->strquery);
		  	//Ejecutamos la instruccion 
		  	$result->execute();
		  	//Obtenemos el resultado que ha sido obtenido
		  	$data = $result->fetch(PDO::FETCH_ASSOC);
		  	//Devolvemos
		  	return $data;
		  }

		  //Todos los registros
		  public function select_all(string $query)
		  {
		  	//Alamacenamos el query
		  	$this->strquery = $query;
		  	//Preparamos el instruccion
		  	$result = $this->conexion->prepare($this->strquery);
		  	//Ejecutamos la instruccion 
		  	$result->execute();
		  	//Obtenemos los resultado que ha sido obtenido
		  	$data = $result->fetchall(PDO::FETCH_ASSOC);
		  	//Devolvemos
		  	return $data;
		  }
		  //Actualiza registros
		public function update(string $query, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrVAlues = $arrValues;
			$update = $this->conexion->prepare($this->strquery);
			$resExecute = $update->execute($this->arrVAlues);
	        return $resExecute;
		}
		  //Eliminar
	    public function Delete(string $query)
		{
		  		//Alamacenamos el query
		  		$this->strquery = $query;

		  		$delete = $this->conexion->prepare($this->strquery);
		  	    $del = $delete->execute();
		  		return $del;
		}

	}



 ?>