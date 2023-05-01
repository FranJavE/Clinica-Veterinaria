<?php 

	Class CitasModel extends Mysql
	{	
		private $idCita;
		private $idPaciente;
		private $Descripcion;
		private $fechacita;
		private $Hora;
		private $status;

		public function __construct()
		{
			parent::__construct();
			
		}
		public function insertcitas(int $intIdPaciente, string $strDescripcion, string $DateFecha,string $strHora)
		{
			$this->idPaciente = $intIdPaciente;
			$this->Descripcion = $strDescripcion;
			$this->fechacita = $DateFecha;
			$this->Hora = $strHora;
			$return = 0;

			$sql = "SELECT * FROM tbl_citas where fechacita = '{$this->fechacita}' and Hora ='{$this->Hora}' and status =1";
			$request = $this->select_all($sql);
			if(empty($request)){
				$query_insert = "INSERT INTO tbl_citas(id_mascota,Descripcion,fechacita,Hora) VALUES(?,?,?,?)";
				$arrData = array($this->idPaciente,
								$this->Descripcion,
								$this->fechacita,
								$this->Hora);

				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return="exist";
			}
			return $return;
		}
		public function updatecitas(int $idCita,int $intIdPaciente,string $strDescripcion,string $DateFecha,string $strHora,int $intStatus)
		{
			$this->idCita = $idCita;
		    $this->idPaciente = $intIdPaciente;
			$this->Descripcion = $strDescripcion;
			$this->fechacita = $DateFecha;
			$this->Hora = $strHora;
			$this->status = $intStatus;
			$sql = "SELECT * FROM tbl_citas where (fechacita = '{$this->fechacita}' and Hora ='{$this->Hora}' and id_citas != $this->idCita)";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				
				$sql = "UPDATE tbl_citas SET id_mascota=?,Descripcion=?,fechacita=?,Hora=?,status=?
				where id_citas = $this->idCita";
				$arrData = array($this->idPaciente,
								$this->Descripcion,
								$this->fechacita,
								$this->Hora,
								$this->status);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}

		public function selectCitas()
		{
			$sql = "SELECT c.id_citas,p.id_persona,concat(p.Nombre,' ', p.Apellido) as 'NombrePersona',m.Nombre as 'NombreMascota',e.NombreEspecie,c.Descripcion,c.fechacita,c.Hora, DATEDIFF(c.fechacita,NOW()) as 'CantDias',c.status
				FROM tbl_citas c 
				INNER JOIN tbl_mascota m
				ON c.id_mascota = m.id_mascota 
				INNER JOIN tbl_persona p 
				ON m.id_persona = p.id_persona
				INNER JOIN tbl_raza r 
				ON m.id_raza = r.id_raza
				INNER JOIN tbl_especie e 
				ON r.id_especie = e.id_especie
				WHERE c.status != 0";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectCita(int $id_Cita)
		{
			$this->idCita = $id_Cita;
			$sql = "SELECT c.id_citas,r.NombreRaza,m.id_mascota,p.id_persona,concat(p.Nombre,' ', p.Apellido) as 'NombrePersona',m.Nombre as 'NombreMascota',e.NombreEspecie,c.Descripcion,c.fechacita,c.Hora, DATEDIFF(c.fechacita,NOW()) as 'CantDias',c.status
				FROM tbl_citas c 
				INNER JOIN tbl_mascota m
				ON c.id_mascota = m.id_mascota 
				INNER JOIN tbl_persona p 
				ON m.id_persona = p.id_persona
				INNER JOIN tbl_raza r 
				ON m.id_raza = r.id_raza
				INNER JOIN tbl_especie e 
				ON r.id_especie = e.id_especie
				where c.id_citas = $this->idCita";
			$request = $this->select($sql);
			return $request;
		}
		public function deleteCita(int $idCita)
		{
			$this->idCita = $idCita;
			$sql = "UPDATE tbl_citas SET status = ? WHERE id_citas = $this->idCita";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}

	}
?>