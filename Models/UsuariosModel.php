<?php 

	Class UsuariosModel extends Mysql
	{
		private $IdUsuario; 
		Private $strIdentificacion;
		Private $strNombre;
		Private $strApellido;
		Private $intTelefono;
		Private $strEmail;
		Private $strPassword;
		private $strToken;
		Private $intTipoid;
		Private $intStatus;

		public function __construct()
		{
			parent::__construct();
		}

		public function insertUsuario(string $Identificacion, string $Nombre, string $Apellido,int $Telefono,string $Email,string $Password,int $Tipoid, int $Status)
		{
		    $this->strIdentificacion = $Identificacion;
			$this->strNombre = $Nombre;
			$this->strApellido = $Apellido;
			$this->intTelefono = $Telefono;
			$this->strEmail = $Email;
			$this->strPassword = $Password;
			$this->intTipoid = $Tipoid;
			$this->intStatus = $Status;
			$return = 0;

			$sql = "SELECT * FROM tbl_persona where email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}'";
			$request = $this->select_all($sql);

			if (empty($request)) {
				$query_insert = "INSERT INTO tbl_persona(identificacion,Nombre,Apellido,Telefono,email_user,password,id_rol,status) VALUES(?,?,?,?,?,?,?,?)";
				$arrData = array($this->strIdentificacion,
								$this->strNombre,
								$this->strApellido,
								$this->intTelefono,
								$this->strEmail,
								$this->strPassword,
								$this->intTipoid,
								$this->intStatus);
				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			} else {
				$return = "exist";
			}
			return $return;
	}
	public function selectUsuarios()
	{
		$whereAdmin = "";
		if ($_SESSION['idUser'] != 1) {
			$whereAdmin = " and p.id_persona != 1 ";
		}
		$sql = "SELECT p.Nombre,p.id_persona,p.identificacion,p.Apellido,p.Telefono,p.email_user,p.status,r.id_rol,r.NombreRol
		From tbl_persona p 
		INNER JOIN tbl_rol r ON p.id_rol  = r.id_rol 
		WHERE p.status != 0 AND p.id_rol != 3 ".$whereAdmin;
		$request = $this->select_all($sql);
		return $request;
	}
	public function selectUsuario(int $idpersona)
	{
		$this->IdUsuario = $idpersona;
		$sql = "SELECT p.id_persona,p.identificacion,p.Nombre,p.Apellido,p.Telefono,p.email_user,p.Direccion,r.id_rol,r.NombreRol, p.status, DATE_FORMAT(p.datecreated, '%d-%m-%Y') as fechaRegistro
		From tbl_persona p 
		INNER JOIN tbl_rol r 
		on p.id_rol  = r.id_rol 
		where p.id_persona = $this->IdUsuario";
		$request = $this->select($sql);
		return $request;
	}

	public function updateUsuario(int $idUsuario,string $Identificacion, string $Nombre, string $Apellido,int $Telefono,string $Email,string $Password,int $Tipoid, int $Status)
	{
			$this->IdUsuario = $idUsuario;
		    $this->strIdentificacion = $Identificacion;
			$this->strNombre = $Nombre;
			$this->strApellido = $Apellido;
			$this->intTelefono = $Telefono;
			$this->strEmail = $Email;
			$this->strPassword = $Password;
			$this->intTipoid = $Tipoid;
			$this->intStatus = $Status;
			$sql = "SELECT * FROM tbl_persona where (email_user = '{$this->strEmail}' AND id_persona != $this->IdUsuario) OR (identificacion = '{$this->strIdentificacion}' AND id_persona != $this->IdUsuario)";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				if($this->strPassword != "")
				{
				$sql = "UPDATE tbl_persona SET identificacion=?,Nombre=?,Apellido=?,Telefono=?,email_user=?,password=?,id_rol=?,status=?
				where id_persona = $this->IdUsuario";
				$arrData = array($this->strIdentificacion,
								$this->strNombre,
								$this->strApellido,
								$this->intTelefono,
								$this->strEmail,
								$this->strPassword,
								$this->intTipoid,
								$this->intStatus);
				}else{
					$sql = "UPDATE tbl_persona SET identificacion=?,Nombre=?,Apellido=?,Telefono=?,email_user=?,id_rol=?,status=?
				where id_persona = $this->IdUsuario";
				$arrData = array($this->strIdentificacion,
								$this->strNombre,
								$this->strApellido,
								$this->intTelefono,
								$this->strEmail,
								$this->intTipoid,
								$this->intStatus);
				}
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
	}
	public function deleteUsuario(int $idpersona)
	{
		$this->IdUsuario = $idpersona;
		$sql = "UPDATE tbl_persona SET status = ? WHERE id_persona = $this->IdUsuario";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}

	public function updatePerfil(int $idUser, string $identificacion, string $nombre, string $Apellido, int $telefono, string $password)
	{
			$this->IdUsuario = $idUser;
		    $this->strIdentificacion = $identificacion;
			$this->strNombre = $nombre;
			$this->strApellido = $Apellido;
			$this->intTelefono = $telefono;
			if($this->strPassword != "")
			{
				$sql = "UPDATE tbl_persona SET identificacion=?,Nombre=?,Apellido=?,Telefono=?,password=?
				where id_persona = $this->IdUsuario";
				$arrData = array($this->strIdentificacion,
								$this->strNombre,
								$this->strApellido,
								$this->intTelefono,
								$this->strPassword);
			}else{
				$sql = "UPDATE tbl_persona SET identificacion=?,Nombre=?,Apellido=?,Telefono=?
				where id_persona = $this->IdUsuario";
				$arrData = array($this->strIdentificacion,
								$this->strNombre,
								$this->strApellido,
								$this->intTelefono);
			}
			$request = $this->update($sql,$arrData);
			return $request;
			
	}
}
?>