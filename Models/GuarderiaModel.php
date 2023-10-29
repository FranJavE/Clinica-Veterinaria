<?php 

	Class GuarderiaModel extends Mysql
	{
		Private $IdMascota;
		Private $IdGuarderia;
		Private $strDescripcion;
		Private $intPrecio;
		private $intJaula;
		Private $strfechallegada;
		Private $strHorallegada;
		Private $strHoraSalida;
		Private $strFechaSalida;
		Private $intStatus;
		public function __construct()
		{
			parent::__construct();
			
		}

		public function insertGuarderia($intIsPaciente, $intIsJaula, $strDescripcion, $intPrecio, $DateFechallegada, $strHorallegada, $DateFechaSalida, $strHoraSalida)
		{
			$this->IdMascota = $intIsPaciente;
			$this->intJaula = $intIsJaula;
			$this->strDescripcion = $strDescripcion;
			$this->intPrecio = $intPrecio;
			$this->strfechallegada = $DateFechallegada;
			$this->strHorallegada = $strHorallegada;
			$this->strFechaSalida = $DateFechaSalida;
			$this->strHoraSalida = $strHoraSalida;
			$return = 0;

			$sql = "SELECT * FROM tbl_guarderia where (status = 1 and Numero_Jaula = $this->intJaula) or (status = 1 and id_mascota ='{$this->IdMascota}')";
			$request = $this->select_all($sql);
			if(empty($request)){
				$query_insert = "INSERT INTO tbl_guarderia(id_mascota,id_jaula,Numero_Jaula,Descripcion,Precio,fechainicio,Hora_lnicio,fechafin,Hora_salida) VALUES(?,?,?,?,?,?,?,?,?)";
				$arrData = array($this->IdMascota, 
								$this->intJaula, 
								$this->intJaula, 
								$this->strDescripcion, 
								$this->intPrecio, 
								$this->strfechallegada, 
								$this->strHorallegada, 
								$this->strFechaSalida, 
								$this->strHoraSalida); 

				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return="exist";
			}
			return $return;
		}
		public function updateGuarderia($idGuarderia,$intIsPaciente, $intIsJaula, $strDescripcion, $intPrecio, $DateFechallegada, $strHorallegada, $DateFechaSalida, $strHoraSalida,$intStatus) {
			$this->IdGuarderia = $idGuarderia;
			$this->IdMascota = $intIsPaciente;
			$this->intJaula = $intIsJaula;
			$this->strDescripcion = $strDescripcion;
			$this->intPrecio = $intPrecio;
			$this->strfechallegada = $DateFechallegada;
			$this->strHorallegada = $strHorallegada;
			$this->strFechaSalida = $DateFechaSalida;
			$this->strHoraSalida = $strHoraSalida;
			$this->intStatus = $intStatus;
			$return = 0;
			$sql = "SELECT * FROM tbl_guarderia where (status = 1 and Numero_Jaula = $this->intJaula and id_guarderia != $this->IdGuarderia) or (status = 1 and id_mascota = $this->IdMascota and id_guarderia != $this->IdGuarderia)";
			$request = $this->select_all($sql);
			if (empty($request)) {
				$sql = "UPDATE tbl_guarderia SET id_mascota=?, id_jaula = ?, Numero_Jaula=?, Descripcion=?, Precio=?, fechainicio=?, Hora_lnicio=?, fechafin=?, Hora_salida=?, status =? where id_guarderia = $this->IdGuarderia";
				 $arrData = array($this->IdMascota,
								$this->intJaula,
								$this->intJaula,
								$this->strDescripcion,
								$this->intPrecio,
								$this->strfechallegada,
								$this->strHorallegada,
								$this->strFechaSalida,
								$this->strHoraSalida,
								$this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}
		public function selectGuarderias()
		{
			$sql = "SELECT g.id_guarderia,concat(p.Nombre,' ', p.Apellido) as 'Dueño', m.Nombre as 'NombreMascota', e.NombreEspecie,
			 g.Descripcion, g.fechainicio,g.fechafin,(jaula.numero_jaula) AS Numero_Jaula,g.Precio,g.status, jaula.nombre_jaula
				FROM tbl_guarderia g
				INNER JOIN tbl_mascota m
				ON g.id_mascota = m.id_mascota
				INNER JOIN tbl_persona p 
				ON p.id_persona = m.id_persona
				INNER JOIN tbl_raza r 
				ON r.id_raza = m.id_raza
				INNER JOIN tbl_especie e 
				ON e.id_especie = r.id_especie
				INNER JOIN tbl_jaula jaula
				ON g.id_jaula = jaula.id_jaula
				where g.status != 0";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectGuarderia(int $idGuarderia)
		{
			$this->IdGuarderia = $idGuarderia;
			$sql = "SELECT g.id_guarderia,concat(p.Nombre,' ', p.Apellido) as 'Dueño', m.Nombre as 'NombreMascota', r.NombreRaza ,
			e.NombreEspecie, g.Descripcion, g.fechainicio,g.fechafin,g.Hora_lnicio,g.Hora_salida,(jaula.numero_jaula) AS Numero_Jaula,g.Precio,g.status, jaula.nombre_jaula
				FROM tbl_guarderia g
				INNER JOIN tbl_mascota m
				ON g.id_mascota = m.id_mascota
				INNER JOIN tbl_persona p 
				ON p.id_persona = m.id_persona
				INNER JOIN tbl_raza r 
				ON r.id_raza = m.id_raza
				INNER JOIN tbl_especie e 
				ON e.id_especie = r.id_especie
				INNER JOIN tbl_jaula jaula
				ON g.id_jaula = jaula.id_jaula
				where g.status != 0 and g.id_guarderia= $this->IdGuarderia ";
			$request = $this->select($sql);
			return $request;
		}

		public function deleteGuarderia(int $idGuarderia)
		{
			$this->IdGuarderia = $idGuarderia;
			$sql = "UPDATE tbl_guarderia SET status = ? WHERE id_guarderia = $this->IdGuarderia";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}
		public function updateSalida(int $idGuarderia) {
			$this->IdGuarderia = $idGuarderia;
			$sql = "UPDATE tbl_guarderia SET status = ? WHERE id_guarderia = $this->IdGuarderia";
			$arrData = array(2);
			$request = $this->update($sql,$arrData);
			return $request;
		}

	}
?>