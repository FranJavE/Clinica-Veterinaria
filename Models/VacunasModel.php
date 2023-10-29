<?php 

	Class VacunasModel extends Mysql
	{
		private $id_VacunacionXMascota; 
		Private $IdMascota;
		Private $IdVacuna;
		Private $strDescripcion;
		Private $strfechaVacunacion;
		Private $intStatus;
		private $intPrecio;
		private $strHora;
		public function __construct()
		{
			parent::__construct();
			
		}
		public function insertVacuna($intIsPaciente,$intIsVacunas,$strDescripcion,$intPrecio,$DateFecha,$strHora)
		{
			$this->IdMascota = $intIsPaciente;
			$this->IdVacuna = $intIsVacunas;
			$this->strDescripcion = $strDescripcion;
			$this->intPrecio = $intPrecio;
			$this->strfechaVacunacion = $DateFecha;
			$this->strHora = $strHora;
			$return = 0;

			$sql = "SELECT * FROM tbl_vacunaxmascota where fechaVacunacion = '{$this->strfechaVacunacion}' and Hora ='{$this->strHora}' and status =1 and id_mascota ='{$this->IdMascota}'";
			$request = $this->select_all($sql);
			if(empty($request)){
				$query_insert = "INSERT INTO tbl_vacunaxmascota(id_mascota,id_Vacunacion,Descripcion,fechaVacunacion,Precio,Hora) VALUES(?,?,?,?,?,?)";
				$arrData = array($this->IdMascota,
								$this->IdVacuna,
								$this->strDescripcion,
								$this->strfechaVacunacion,
								$this->intPrecio,
								$this->strHora);

				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return="exist";
			}
			return $return;
		}
		public function updateVacuna($idVacuna,$intIsPaciente,$intIsVacunas,$strDescripcion,$intPrecio,$DateFecha,$strHora)
		{
			$this->id_VacunacionXMascota = $idVacuna;
			$this->IdMascota = $intIsPaciente;
			$this->IdVacuna = $intIsVacunas;
			$this->strDescripcion = $strDescripcion;
			$this->intPrecio = $intPrecio;
			$this->strfechaVacunacion = $DateFecha;
			$this->strHora = $strHora;
			$return = 0;
			$sql = "SELECT * FROM tbl_vacunaxmascota where (fechaVacunacion = '{$this->strfechaVacunacion}' and Hora ='{$this->strHora}' and id_VacunacionXMascota != $this->id_VacunacionXMascota and id_mascota = $this->IdMascota )";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				
				$sql = "UPDATE tbl_vacunaxmascota SET id_mascota=?, id_Vacunacion=?,Descripcion=?,Precio=?,fechaVacunacion=?,Hora=?
				where id_VacunacionXMascota = $this->id_VacunacionXMascota";
				$arrData = array($this->IdMascota,
								$this->IdVacuna,
								$this->strDescripcion,
								$this->intPrecio,
								$this->strfechaVacunacion,
								$this->strHora);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}

		public function selectVacunas()
		{
			$sql = "SELECT vm.id_VacunacionXMascota,concat(p.Nombre,' ', p.Apellido) as 'Dueño', m.Nombre as 'NombreMascota',
			e.NombreEspecie,v.NombreVacuna, vm.Descripcion, vm.fechaVacunacion,vm.Hora,vm.Precio ,vm.status
				FROM tbl_vacunaxmascota vm
				INNER JOIN tbl_mascota m
				ON vm.id_mascota = m.id_mascota
				INNER JOIN tbl_persona p 
				ON p.id_persona = m.id_persona
				INNER JOIN tbl_raza r 
				ON r.id_raza = m.id_raza
				INNER JOIN tbl_especie e 
				ON e.id_especie = r.id_especie
                INNER JOIN tbl_vacunacion v 
                ON v.id_Vacunacion = vm.id_Vacunacion
				where vm.status != 0";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectVacuna(int $idVacuna)
		{
			$this->id_VacunacionXMascota = $idVacuna;
			$sql = "SELECT vm.id_VacunacionXMascota,v.id_Vacunacion,m.id_mascota,concat(p.Nombre,' ', p.Apellido) as 'Dueño', m.Nombre as 'NombreMascota', e.NombreEspecie,v.NombreVacuna, r.NombreRaza, vm.Descripcion, vm.fechaVacunacion,vm.Hora,vm.Precio ,vm.status
				FROM tbl_vacunaxmascota vm
				INNER JOIN tbl_mascota m
				ON vm.id_mascota = m.id_mascota
				INNER JOIN tbl_persona p 
				ON p.id_persona = m.id_persona
				INNER JOIN tbl_raza r 
				ON r.id_raza = m.id_raza
				INNER JOIN tbl_especie e 
				ON e.id_especie = r.id_especie
                INNER JOIN tbl_vacunacion v 
                ON v.id_Vacunacion = vm.id_Vacunacion
				where vm.status != 0 and vm.id_VacunacionXMascota = $this->id_VacunacionXMascota";
			$request = $this->select($sql);
			return $request;
		}
		public function selectgetVacunas()
		{
			$sql = "SELECT id_Vacunacion, NombreVacuna FROM tbl_vacunacion";
			$request = $this->select_all($sql);
			return $request;
		}
		public function deleteVacuna(int $idVacuna)
		{
			$this->id_VacunacionXMascota = $idVacuna;
			$sql = "UPDATE tbl_vacunaxmascota SET status = ? WHERE id_VacunacionXMascota = $this->id_VacunacionXMascota";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}

	}
?>