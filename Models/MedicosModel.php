<?php 

	Class MedicosModel extends Mysql
	{
		private $IdUsuario; 
		Private $strIdentificacion;
		Private $strNombreMedico;
		Private $strApellidoMedico;
		Private $intTelefono;
		Private $strEmail;
		Private $strDireccion;
		private $strToken;
		Private $intTipoid;
		Private $intStatus;

		public function __construct()
		{
			parent::__construct();
			
		}
		public function insertMedico(string $Identificacion, string $NombreMedico, string $ApellidoMedico,int $Telefono,string $Email,int $Status)
		{
		    $this->strIdentificacion = $Identificacion;
			$this->strNombreMedico = $NombreMedico;
			$this->strApellidoMedico = $ApellidoMedico;
			$this->intTelefono = $Telefono;
			$this->strEmail = $Email;
			$this->intStatus = $Status;
			$return = 0;

			$sql = "SELECT * FROM tbl_medico where email = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}'";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert = "INSERT INTO tbl_medico(identificacion,NombreMedico,ApellidoMedico,Telefono,email,status) VALUES(?,?,?,?,?,?)";
				$arrData = array($this->strIdentificacion,
								$this->strNombreMedico,
								$this->strApellidoMedico,
								$this->intTelefono,
								$this->strEmail,
								$this->intStatus);
				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else
			{
				$return="exist";
			}
			return $return;


	}
		public function selectgetMedico(){
			$sql = "SELECT m.id_medico, concat(m.NombreMedico,' ', m.ApellidoMedico) as 'Medico'
			FROM tbl_medico m
			where m.status != 0
			ORDER BY Medico ";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectMedicos()
		{
			$sql = "SELECT m.id_medico,m.identificacion,m.NombreMedico,m.ApellidoMedico,m.Telefono,m.email,m.status
			From tbl_medico m 
			where m.status != 0
			ORDER BY m.NombreMedico";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectMedico(int $idpersona)
	{
		$this->intIdUsuario = $idpersona;
		$sql = "SELECT m.id_medico,m.identificacion,m.NombreMedico,m.ApellidoMedico,m.Telefono,m.email, m.status
		From tbl_medico m 
		where m.id_medico = $this->intIdUsuario";
		$request = $this->select($sql);
		return $request;
	}

	public function updateMedico(int $idUsuario,string $Identificacion, string $NombreMedico, string $ApellidoMedico,int $Telefono,string $Email,int $Status)
	{
			$this->IdUsuario = $idUsuario;
		    $this->strIdentificacion = $Identificacion;
			$this->strNombreMedico = $NombreMedico;
			$this->strApellidoMedico = $ApellidoMedico;
			$this->intTelefono = $Telefono;
			$this->strEmail = $Email;
			$this->intStatus = $Status;
			$sql = "SELECT * FROM tbl_medico where (email = '{$this->strEmail}' AND id_medico != $this->IdUsuario) OR (identificacion = '{$this->strIdentificacion}' AND id_medico != $this->IdUsuario)";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				
				$sql = "UPDATE tbl_medico SET identificacion=?,NombreMedico=?,ApellidoMedico=?,Telefono=?,email=?,status=?
				where id_medico = $this->IdUsuario";
				$arrData = array($this->strIdentificacion,
								$this->strNombreMedico,
								$this->strApellidoMedico,
								$this->intTelefono,
								$this->strEmail,
								$this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
	}
	public function deleteMedico(int $idpersona)
	{
		$this->IdUsuario = $idpersona;
		$sql = "UPDATE tbl_medico SET status = ? WHERE id_medico = $this->IdUsuario";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}

	public function selectgetMedicos()
	{
			$sql = "SELECT m.id_medico, concat(m.NombreMedico,' ', m.ApellidoMedico) as 'Medico'
			FROM tbl_medico m 
			where m.status != 0";
			$request = $this->select_all($sql);
			return $request;
	}
	}
?>