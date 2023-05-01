<?php 

	class CategoriasModel extends Mysql
	{
		public $intIdCategoria;
		public $strCategoria;
		public $strDescripcion;
		public $intStatus;
		public $strPortada;
		public $ruta;

		public function __construct()
		{
			parent::__construct();
		}

		public function inserCategoria(string $nombre_categoria, string $Descripcion, string $portada, string $ruta, int $status){

			$return = 0;
			$this->strCategoria = $nombre_categoria;
			$this->strDescripcion = $Descripcion;
			$this->strPortada = $portada;
			$this->ruta = $ruta;
			$this->intStatus = $status;

			$sql = "SELECT * FROM tbl_categoria WHERE nombre_categoria = '{$this->strCategoria}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO tbl_categoria(nombre_categoria,Descripcion,portada,ruta,status) VALUES(?,?,?,?,?)";
	        	$arrData = array($this->strCategoria, 
								 $this->strDescripcion, 
								 $this->strPortada,
								 $this->ruta, 
								 $this->intStatus);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}

		public function selectCategorias() {
			$sql = "SELECT * FROM tbl_categoria 
					WHERE status != 0 ";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectCategoria(int $id_categoria){
			$this->intIdCategoria = $id_categoria;
			$sql = "SELECT * FROM tbl_categoria
					WHERE id_categoria = $this->intIdCategoria";
			$request = $this->select($sql);
			return $request;
		}

		public function updateCategoria(int $idtbl_categoria, string $strCategoria, string $Descripcion, string $portada, string $ruta, int $status){
			$this->intIdCategoria = $idtbl_categoria;
			$this->strCategoria = $strCategoria;
			$this->strDescripcion = $Descripcion;
			$this->strPortada = $portada;
			$this->ruta = $ruta;
			$this->intStatus = $status;

			$sql = "SELECT * FROM tbl_categoria WHERE nombre_categoria = '{$this->strCategoria}' AND id_categoria != $this->intIdCategoria";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE tbl_categoria SET nombre_categoria = ?, Descripcion = ?, portada = ?, ruta = ?, status = ? WHERE id_categoria = $this->intIdCategoria ";
				$arrData = array($this->strCategoria, 
								 $this->strDescripcion, 
								 $this->strPortada, 
								 $this->ruta,
								 $this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}

		public function deleteCategoria(int $idtbl_categoria)
		{
			$this->intIdCategoria = $idtbl_categoria;
			$sql = "SELECT * FROM tbl_producto WHERE id_categoria = $this->intIdCategoria";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "UPDATE tbl_categoria SET status = ? WHERE id_categoria = $this->intIdCategoria ";
				$arrData = array(0);
				$request = $this->update($sql,$arrData);
				if($request)
				{
					$request = 'ok';	
				}else{
					$request = 'error';
				}
			}else{
				$request = 'exist';
			}
			return $request;
		}	


	}
 ?>