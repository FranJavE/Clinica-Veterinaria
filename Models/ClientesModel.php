<?php 

	Class ClientesModel extends Mysql
	{
		private $IdUsuario; 
		Private $strIdentificacion;
		Private $strNombre;
		Private $strApellido;
		Private $intTelefono;
		Private $strEmail;
		Private $strPassword;
		Private $strDireccion;
		private $strToken;
		Private $intTipoid;
		Private $intStatus;

		public function __construct()
		{
			parent::__construct();
			
		}
		public function insertCliente(string $Identificacion, string $Nombre, string $Apellido,int $Telefono,string $Email,string $direccion,string $Password,int $Status)
		{
		    $this->strIdentificacion = $Identificacion;
			$this->strNombre = $Nombre;
			$this->strApellido = $Apellido;
			$this->intTelefono = $Telefono;
			$this->strEmail = $Email;
			$this->strDireccion = $direccion;
			$this->strPassword = $Password;
			$this->intTipoid = 3;
			$this->intStatus = $Status;
			$return = 0;

			$sql = "SELECT * FROM tbl_persona where email_user = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}'";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert = "INSERT INTO tbl_persona(identificacion,Nombre,Apellido,Telefono,email_user,Direccion,password,id_rol,status) VALUES(?,?,?,?,?,?,?,?,?)";
				$arrData = array($this->strIdentificacion,
								$this->strNombre,
								$this->strApellido,
								$this->intTelefono,
								$this->strEmail,
								$this->strDireccion,
								$this->strPassword,
								$this->intTipoid,
								$this->intStatus);
				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else
			{
				$return="exist";
			}
			return $return;


	}
		public function selectgetClientes(){
			$sql = "SELECT p.id_persona, concat(p.Nombre,' ', p.Apellido) as 'Dueño'
			FROM tbl_persona p 
			INNER JOIN tbl_rol r 
			on p.id_rol  = r.id_rol 
			where p.status != 0 and (r.NombreRol = 'Cliente' or p.id_rol = 3) ";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectClientes()
		{
			$sql = "SELECT p.id_persona,p.identificacion,p.Nombre,p.Apellido,p.Telefono,p.email_user,p.status,p.Direccion
			From tbl_persona p 
			INNER JOIN tbl_rol r 
			on p.id_rol  = r.id_rol 
			where p.status != 0 and (r.NombreRol = 'Cliente' or p.id_rol = 3) ";
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectCliente(int $idpersona)
		{
			$this->intIdUsuario = $idpersona;
			$sql = "SELECT p.id_persona,p.identificacion,p.Nombre,p.Apellido,p.Telefono,p.email_user,p.Direccion,r.id_rol,r.NombreRol, p.status, DATE_FORMAT(p.datecreated, '%d-%m-%Y') as fechaRegistro
			From tbl_persona p 
			INNER JOIN tbl_rol r 
			on p.id_rol  = r.id_rol 
			where p.id_persona = $this->intIdUsuario";
			$request = $this->select($sql);
			return $request;
		}

	public function updateCliente(int $idUsuario,string $Identificacion, string $Nombre, string $Apellido,int $Telefono,string $Email,string $Direccion ,string $Password,int $Status)
	{
			$this->IdUsuario = $idUsuario;
		    $this->strIdentificacion = $Identificacion;
			$this->strNombre = $Nombre;
			$this->strApellido = $Apellido;
			$this->intTelefono = $Telefono;
			$this->strEmail = $Email;
			$this->strDireccion = $Direccion;
			$this->intStatus = $Status;
			$sql = "SELECT * FROM tbl_persona where (email_user = '{$this->strEmail}' AND id_persona != $this->IdUsuario) OR (identificacion = '{$this->strIdentificacion}' AND id_persona != $this->IdUsuario)";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				
				$sql = "UPDATE tbl_persona SET identificacion=?,Nombre=?,Apellido=?,Telefono=?,email_user=?,Direccion=?,status=?
				where id_persona = $this->IdUsuario";
				$arrData = array($this->strIdentificacion,
								$this->strNombre,
								$this->strApellido,
								$this->intTelefono,
								$this->strEmail,
								$this->strDireccion,
								$this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
	}
	public function deleteCliente(int $idpersona)
	{
		$this->IdUsuario = $idpersona;
		$sql = "UPDATE tbl_persona SET status = ? WHERE id_persona = $this->IdUsuario";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}
	}
?>