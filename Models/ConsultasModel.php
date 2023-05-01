
<?php 

	Class ConsultasModel extends Mysql
	{
		private $IdConsulta; 
		Private $IdMascota;
		Private $IdMedico;
		Private $IdTratamiento;
		Private $strDescripcion;
		Private $strfecha;
		Private $strhora;
		Private $intStatus;
		public function __construct()
		{
			parent::__construct();
			
		}

		public function insertConsulta($intIsPaciente ,$intIsMedico ,$intlistTratamiendo ,$strDescripcion ,$DateFecha ,$strHora ,$intPrecio)
		{
			$this->IdMascota = $intIsPaciente;
			$this->IdMedico = $intIsMedico;
			$this->IdTratamiento = $intlistTratamiendo;
			$this->strDescripcion = $strDescripcion;
			$this->intPrecio = $intPrecio;
			$this->strfecha = $DateFecha;
			$this->strhora = $strHora;
			$return = 0;

			$sql = "SELECT * FROM tbl_consultas where fechaConsulta = '{$this->strfecha}' and Hora ='{$this->strhora}' and status = 1 and id_mascota ='{$this->IdMascota}'";
			$request = $this->select_all($sql);
			if(empty($request)){
				$query_insert = "INSERT INTO tbl_consultas(id_mascota,id_medico,id_tratamiento,Descripcion,fechaConsulta,Precio,hora) VALUES(?,?,?,?,?,?,?)";
				$arrData = array($this->IdMascota,
								$this->IdMedico,
								$this->IdTratamiento,
								$this->strDescripcion,
								$this->strfecha,
								$this->intPrecio,
								$this->strhora);

				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return="exist";
			}
			return $return;
		}
		public function updateConsulta($idConsulta,$intIsPaciente ,$intIsMedico ,$intlistTratamiendo ,$strDescripcion ,$DateFecha ,$strHora ,$intPrecio)
		{
			$this->IdConsulta = $idConsulta;
			$this->IdMascota = $intIsPaciente;
			$this->IdMedico = $intIsMedico;
			$this->IdTratamiento = $intlistTratamiendo;
			$this->strDescripcion = $strDescripcion;
			$this->intPrecio = $intPrecio;
			$this->strfecha = $DateFecha;
			$this->strhora = $strHora;
			$return = 0;
			$sql = "SELECT * FROM tbl_consultas where fechaConsulta = '{$this->strfecha}' and Hora ='{$this->strhora}' and status = 1 and id_mascota ='{$this->IdMascota}' and id_Consulta != $this->IdConsulta";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				
				$sql = "UPDATE tbl_consultas SET id_mascota=?, id_medico=?, id_tratamiento = ?,Descripcion=?,Precio=?,fechaConsulta=?,hora=?
				where id_Consulta = $this->IdConsulta";
				$arrData = array($this->IdMascota,
								$this->IdMedico,
								$this->IdTratamiento,
								$this->strDescripcion,
								$this->intPrecio,
								$this->strfecha,
								$this->strhora);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}
		public function selecConsultas()
		{
			$sql = "SELECT c.id_Consulta,concat(p.Nombre,' ', p.Apellido) as 'Dueño', m.Nombre as 'NombreMascota', me.NombreMedico, e.NombreEspecie, c.Descripcion, c.fechaconsulta, c.hora, t.NombreTratamiento,c.Precio, c.status
				FROM tbl_consultas c
				INNER JOIN tbl_mascota m
				ON c.id_mascota = m.id_mascota
				INNER JOIN tbl_persona p 
				ON p.id_persona = m.id_persona
				INNER JOIN tbl_raza r 
				ON r.id_raza = m.id_raza
				INNER JOIN tbl_especie e 
				ON e.id_especie = r.id_especie
				INNER JOIN tbl_tratamiento t 
				ON t.id_tratamiento = c.id_tratamiento
                INNER JOIN tbl_medico me 
                ON me.id_medico = c.id_medico
				where c.status != 0";
			$request = $this->select_all($sql);
			return $request;
		}
		public function getSelectTratamiento()
		{
			$sql = "SELECT t.id_tratamiento, t.NombreTratamiento
			FROM tbl_tratamiento t  
			ORDER BY t.NombreTratamiento ASC";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectConsulta(int $idConsulta)
		{
			$this->IdConsulta = $idConsulta;
			$sql = "SELECT c.id_Consulta,concat(p.Nombre,' ', p.Apellido) as 'Dueño', m.Nombre as 'NombreMascota', me.NombreMedico, e.NombreEspecie,r.NombreRaza, c.Descripcion, c.fechaconsulta, c.hora, t.NombreTratamiento,c.Precio, c.status, t.id_tratamiento,me.id_medico, m.id_mascota, p.id_persona
				FROM tbl_consultas c
				INNER JOIN tbl_mascota m
				ON c.id_mascota = m.id_mascota
				INNER JOIN tbl_persona p 
				ON p.id_persona = m.id_persona
				INNER JOIN tbl_raza r 
				ON r.id_raza = m.id_raza
				INNER JOIN tbl_especie e 
				ON e.id_especie = r.id_especie
				INNER JOIN tbl_tratamiento t 
				ON t.id_tratamiento = c.id_tratamiento
                INNER JOIN tbl_medico me 
                ON me.id_medico = c.id_medico
				where c.status != 0 and id_Consulta = $this->IdConsulta ";
			$request = $this->select($sql);
			return $request;
		}

		public function deleteConsulta(int $idConsulta)
		{
			$this->IdConsulta = $idConsulta;
			$sql = "UPDATE tbl_consultas SET status = ? WHERE id_Consulta = $this->IdConsulta";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}


	}
?>