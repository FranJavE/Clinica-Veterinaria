<?php 

	Class LoginModel extends Mysql
	{
		private $intIdUsuario;
		private $strUsuario;
		private $strPassword;
		private $strToken;

		public function __construct()
		{
			parent::__construct();
		}

		public function loginUser(string $usuario, string $password){
			$this->strUsuario = $usuario;
			$this->strPassword = $password;
			$sql = "SELECT id_persona,status FROM tbl_persona WHERE email_user = '$this->strUsuario' and password = '$this->strPassword' and status != 0";
			$request = $this->select($sql);
			return $request;
		}
		public function sessionLogin(int $idUsuario)
		{
			$this->intIdUsuario = $idUsuario;
			$sql = "SELECT p.id_persona, p.identificacion, p.Nombre, p.Apellido,concat(p.Nombre,' ', p.Apellido) as 'Nombre_Completo', p.Telefono, p.email_user, p.Direccion, r.id_rol, r.NombreRol, p.status
					FROM tbl_persona p 
					INNER JOIN tbl_rol r 			
					ON p.id_rol = r.id_rol
					WHERE p.id_persona = $this->intIdUsuario ";
			$request = $this->select($sql);
			$_SESSION['userData'] = $request;
			return $request;
		}
		public function getUserEmail(string $Email){
			$this->strUsuario = $Email;
			$sql = "SELECT id_persona, Nombre, Apellido, status FROM tbl_persona where email_user = '$this->strUsuario' and status = 1";
			$request = $this->select($sql);
			return $request;
		}
		public function setTokenUser(int $IdPersona, string $token)
		{
			$this->intIdUsuario = $IdPersona;
			$this->strToken = $token;
			$sql = "UPDATE tbl_persona SET token = ? WHERE id_persona = $this->intIdUsuario";
			$arrData = array($this->strToken);
			$request = $this->update($sql,$arrData);
			return $request;
		}
		public function getUsuario(string $email, string $token)
		{
			$this->strUsuario = $email;
			$this->strToken = $token;
			$sql = "SELECT id_persona FROM tbl_persona where email_user = '$this->strUsuario' and token = '$this->strToken' and status = 1";
			$request = $this->select($sql);
			return $request;
		}
		public function insertPassword(int $IdPersona,string $Password){
			$this->intIdUsuario = $IdPersona;
			$this->strPassword = $Password;
			$sql = "UPDATE tbl_persona SET password = ?, token = ? WHERE id_persona = $this->intIdUsuario ";
			$arrData = array($this->strPassword,"");
			$request = $this->update($sql,$arrData);
			return $request;
		}
	}

?>