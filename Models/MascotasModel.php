<?php 

	Class MascotasModel extends Mysql
	{
		private $IdMascotas; 
		private $id_persona;
		Private $strNombre;
		Private $intRaza;
		Private $intEspecie;
		Private $intPeso;
		Private $intAltura;
		Private $intIdCliente;
		Private $intStatus;
		public function __construct()
		{
			parent::__construct();
			
		}
		public function insertMascotas($strNombre,$intlistRazaid,$intPeso,$intAltura,$intlistDuenoId,$intStatus) {
		    $this->strNombre =$strNombre;
		    $this->intRaza =$intlistRazaid;
		    $this->intPeso =$intPeso;
		    $this->intAltura =$intAltura;
		    $this->intIdCliente = $intlistDuenoId;
			$this->intStatus = $intStatus;
			$return = 0;

			$sql = "SELECT * FROM tbl_mascota where id_persona = $this->intIdCliente and Nombre = '{$this->strNombre}'";
			$request = $this->select_all($sql);

			if (empty($request)) {
				$query_insert = "INSERT INTO tbl_mascota(Nombre,id_raza,peso,Altura,id_persona,status) VALUES(?,?,?,?,?,?)";
				$arrData = array($this->strNombre,
								$this->intRaza,
								$this->intPeso,
								$this->intAltura,
								$this->intIdCliente,
								$this->intStatus);
				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			} else {
				$return="exist";
			}
			return $return;
	}
		public function selectMascotas() {
			$sql = "SELECT m.id_mascota,m.Nombre,r.NombreRaza,e.NombreEspecie,m.Peso,m.Altura,concat(p.Nombre,' ', p.Apellido) as 'Dueño',m.status
			From tbl_mascota m 
			INNER JOIN tbl_persona p
			on m.id_persona  = p.id_persona
			INNER JOIN tbl_raza r 
			on m.id_raza = r.id_raza
			INNER JOIN tbl_especie e
			on r.id_especie = e.id_especie
			where m.status != 0";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectMascota(int $id_mascota)
		{
			$this->IdMascotas = $id_mascota;
			$sql = "SELECT m.id_mascota,p.id_persona,m.Nombre,r.NombreRaza,m.id_raza,e.NombreEspecie,e.id_especie,m.Peso,m.Altura,concat(p.Nombre,' ', p.Apellido) as 'Dueño',m.status, DATE_FORMAT(m.fechacreacion, '%d-%m-%Y') as fechacreacion
			From tbl_mascota m 
			INNER JOIN tbl_persona p
			on m.id_persona  = p.id_persona
			INNER JOIN tbl_raza r 
			on m.id_raza = r.id_raza
			INNER JOIN tbl_especie e
			on r.id_especie = e.id_especie
			where m.id_mascota = $this->IdMascotas";
			$request = $this->select($sql);
			return $request;
		}
		public function selectEspecie()
		{
			$sql = "SELECT * FROM tbl_especie";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectRaza(int $id_especie)
		{
			$this->intEspecie = $id_especie;
			$sql = "SELECT * 
			FROM tbl_raza r
			INNER JOIN tbl_especie e
			on r.id_especie = e.id_especie
			where r.id_especie = $this->intEspecie";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectMascotaDueno($id_Dueno)
		{
			$this->id_persona = $id_Dueno;
			$sql = "SELECT m.id_mascota, m.Nombre
			FROM tbl_mascota m
			INNER JOIN tbl_persona p
			on m.id_persona = p.id_persona
			where m.id_persona = $this->id_persona";
			$request = $this->select_all($sql);
			return $request;
		}

		public function updateMascota($idMascota,$strNombre,$intlistRazaid,$intPeso,$intAltura,$intlistDuenoId,$intStatus)
		{
		    $this->IdMascotas =$idMascota;
		    $this->strNombre =$strNombre;
		    $this->intRaza =$intlistRazaid;
		    $this->intPeso =$intPeso;
		    $this->intAltura =$intAltura;
		    $this->intIdCliente = $intlistDuenoId;
			$this->intStatus = $intStatus;
			$sql = "SELECT * FROM tbl_mascota where ((id_persona = $this->intIdCliente and Nombre = '{$this->strNombre}') and id_mascota != $this->IdMascotas)";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				
				$sql = "UPDATE tbl_mascota SET Nombre=?,id_raza=?,peso=?,Altura=?,id_persona=?,status=?
				where id_mascota = $this->IdMascotas";
				$arrData = array( $this->strNombre =$strNombre,
								    $this->intRaza =$intlistRazaid,
								    $this->intPeso =$intPeso,
								    $this->intAltura =$intAltura,
								    $this->intIdCliente = $intlistDuenoId,
									$this->intStatus = $intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
	    }
	    public function deleteMascota($intidMascota)
		{
		$this->IdMascotas = $intidMascota;
		$sql = "UPDATE tbl_mascota SET status = ? WHERE id_mascota = $this->IdMascotas";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
		}
		

	}
?>