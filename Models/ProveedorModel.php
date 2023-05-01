<?php 

	Class ProveedorModel extends Mysql
	{
		private $idProveedor; 
		Private $strIdentificacion;
		Private $strNombre_proveedor;
		Private $strApellido_Proveedor ;
		Private $intTelefono;
		Private $strEmail;
		Private $strDireccion;
		private $strEmpresa;
		Private $intStatus;

		public function __construct()
		{
			parent::__construct();
			
		}
		public function insertProveedor($strIdentificacion,$strNombre,$strApellido,$intTelefono,$strEmail,$strDireccion, $strEmpresa, $intStatus)
		{
		    $this->strIdentificacion = $strIdentificacion;
			$this->strNombre_proveedor = $strNombre;
			$this->strApellido_Proveedor  = $strApellido ;
			$this->intTelefono = $intTelefono;
			$this->strEmail = $strEmail;
			$this->strDireccion = $strDireccion;
			$this->strEmpresa = $strEmpresa;
			$this->intStatus = $intStatus;
			$return = 0;

			$sql = "SELECT * FROM tbl_proveedores where email_proveedor = '{$this->strEmail}' or identificacion = '{$this->strIdentificacion}'";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert = "INSERT INTO tbl_proveedores(identificacion,Nombre_proveedor,Apellido_Proveedor ,Telefono,email_proveedor,Direccion, Empresa, status) VALUES(?,?,?,?,?,?,?,?)";
				$arrData = array($this->strIdentificacion,
								$this->strNombre_proveedor,
								$this->strApellido_Proveedor ,
								$this->intTelefono,
								$this->strEmail,
								$this->strDireccion,
								$this->strEmpresa,
								$this->intStatus);
				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else
			{
				$return="exist";
			}
			return $return;


	}
	public function selectProveedores(){
			$sql = "SELECT *
			FROM tbl_proveedores  
			where status != 0";
			$request = $this->select_all($sql);
			return $request;
	}
		public function selectProveedorr(int $idProveedor)
	{
		$this->intidProveedor = $idProveedor;
		$sql = "SELECT p.id_proveedores,p.identificacion,p.Nombre_proveedor,p.Apellido_Proveedor ,p.Telefono,p.email_proveedor,p.Direccion,p.Empresa, p.status
		From tbl_proveedores p 
		where p.id_proveedores = $this->intidProveedor";
		$request = $this->select($sql);
		return $request;
	}

	public function updateProveedor($idProveedor,$strIdentificacion,$strNombre,$strApellido,$intTelefono,$strEmail,$strDireccion,$strEmpresa,$intStatus)
	{
			$this->idProveedor = $idProveedor;
		    $this->strIdentificacion = $strIdentificacion;
			$this->strNombre_proveedor = $strNombre;
			$this->strApellido_Proveedor  = $strApellido ;
			$this->intTelefono = $intTelefono;
			$this->strEmail = $strEmail;
			$this->strEmpresa = $strEmpresa;
			$this->strDireccion = $strDireccion;
			$this->intStatus = $intStatus;
			$sql = "SELECT * FROM tbl_proveedores where (email_proveedor = '{$this->strEmail}' AND id_proveedores != $this->idProveedor) OR (identificacion = '{$this->strIdentificacion}' AND id_proveedores != $this->idProveedor)";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				
				$sql = "UPDATE tbl_proveedores SET identificacion=?,Nombre_proveedor=?,Apellido_Proveedor =?,Telefono=?,email_proveedor=?,Direccion=?,Empresa=?,status=?
				where id_proveedores = $this->idProveedor";
				$arrData = array($this->strIdentificacion,
								$this->strNombre_proveedor,
								$this->strApellido_Proveedor ,
								$this->intTelefono,
								$this->strEmail,
								$this->strDireccion,
								$this->strEmpresa,
								$this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
	}
	public function deleteProveedor(int $idProveedor)
	{
		$this->idProveedor = $idProveedor;
		$sql = "UPDATE tbl_proveedores SET status = ? WHERE id_proveedores = $this->idProveedor";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}

	}
?>