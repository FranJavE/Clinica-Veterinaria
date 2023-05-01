<?php 
	
	Class conexion{
		private $conect;//para las instrucciones sql
		public function __construct()
		{
			$connectionString = "mysql:hos=".BD_HOST.";dbname=".BD_NAME.";.DB_CHARSET.";
			try 
			{
				//Aqui nos conectamos a la base de datos ya especificada
				$this->conect = new PDO($connectionString,BD_USER,BD_PASSWORD);
				$this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Esto nos sirve para poder detectar con mas facilidad los errores posibles
				//Echo "Conexion Excitosa";
			}
			 catch (Exception $e)
			{
				$this->conect = "Error de conxion";
				echo "ERROR: ". $e->getMessage();
			}
		}

		Public function conect()
		{
			return $this->conect;
		}
	}