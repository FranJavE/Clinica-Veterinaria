<?php 

	Class PermisosModel extends Mysql
	{
		//Definimos las propiedades de un rol
		public $intIdpermiso;
		public $intRolid;
		public $intModuloid;
		public $r;
		public $w;
		public $u;
		public $d;
		public function __construct()
		{
			parent::__construct();
		}
		public function selectModulos()
		{
			$sql = "SELECT * FROM tbl_modulo WHERE status != 0";
			$request = $this->select_all($sql);
			return $request;

		}

		public function selectPermisosRol(int $idrol)
		{
			$this->intRolid = $idrol;
			$sql = "SELECT * FROM tbl_permisos WHERE id_rol = $this->intRolid";
			$request = $this->select_all($sql);
			return $request;

		}
		public function deletePermisos(int $idrol)
		{
			$this->intRolid = $idrol;
			$sql = "DELETE FROM tbl_permisos WHERE id_rol = $this->intRolid";
			$request = $this->Delete($sql);
			return $request;
		}

		
			public function insertPermisos(int $idrol, int $idmodulo, int $r, int $w, int $u, int $d){
			$this->intRolid = $idrol;
			$this->intModuloid = $idmodulo;
			$this->r = $r;
			$this->w = $w;
			$this->u = $u;
			$this->d = $d;
			$query_insert  = "INSERT INTO tbl_permisos(id_modulo,id_rol,d,r,u,w)VALUES(?,?,?,?,?,?)";
        	$arrData = array($this->intModuloid,$this->intRolid, $this->d,$this->r, $this->u,$this->w);
        	$request_insert = $this->insert($query_insert,$arrData);		
	        return $request_insert;
		}
		public function permisosModulo(int $idrol)
		{
			$this->intRolid = $idrol;
			$sql = "SELECT p.id_rol,
						   p.id_modulo,
						   m.Nombre as 'Modulo', 
						   p.r, 
						   p.w,
						   p.u, 
						   p.d 
					FROM tbl_permisos p 
					INNER JOIN tbl_modulo m 
					ON p.id_modulo = m.id_modulo 
					WHERE p.id_rol =  $this->intRolid";
			$request = $this->select_all($sql);
			//dep($request);
			$arrPermisos = array();
			for ($i = 0; $i < count($request); $i++){
				$arrPermisos[$request[$i]['id_modulo']] = $request[$i];
			}
			return $arrPermisos;
		}
	}
?>