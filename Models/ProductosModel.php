<?php 

	class ProductosModel extends Mysql
	{
		private $intIdProducto;
		private $strNombre;
		private $strDescripcion;
		private $intCodigo;
		private $intCategoriaId;
		private $intProveedorId;
		private $intPrecio;
		private $intStock;
		private $intStatus;
		private $strImagen;
		private $ruta;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectProductos(){
			$sql = "SELECT p.id_producto,
							p.Codigo,
							p.Nombre_producto ,
							p.Descripcion ,
							p.id_categoria,
							c.nombre_categoria as categoria,
							p.Precio ,
							p.stock,
							p.status 
					FROM tbl_producto p 
					INNER JOIN tbl_categoria c
					ON p.id_categoria = c.id_categoria
					WHERE p.status != 0 ";
					$request = $this->select_all($sql);
			return $request;
		}	

		public function insertProducto(string $Nombre_producto , string $Descripcion , int $Codigo, int $id_categoria, int $id_proveedor, string $Precio , int $stock,string $ruta, int $status){
			$this->strNombre = $Nombre_producto ;
			$this->strDescripcion = $Descripcion ;
			$this->intCodigo = $Codigo;
			$this->intCategoriaId = $id_categoria;
			$this->intProveedorId = $id_proveedor;
			$this->strPrecio = $Precio;
			$this->intStock = $stock;
			$this->intStatus = $status;
			$this->ruta = $ruta;
			$return = 0;
			$sql = "SELECT * FROM tbl_producto WHERE Codigo = '{$this->intCodigo}'";
			$request = $this->select_all($sql);
			if(empty($request)) {
				$query_insert  = "INSERT INTO tbl_producto(id_categoria,
														id_proveedores,
														Codigo,
														Nombre_producto ,
														Descripcion ,
														Precio ,
														stock,
														ruta,
														status) 
								  VALUES(?,?,?,?,?,?,?,?,?)";
	        	$arrData = array($this->intCategoriaId,
	        				    $this->intProveedorId, 
        						$this->intCodigo,
        						$this->strNombre,
        						$this->strDescripcion,
        						$this->strPrecio,
        						$this->intStock,
        						$this->ruta,
        						$this->intStatus);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
		}

		public function updateProducto(int $id_producto, string $Nombre_producto , string $Descripcion , int $Codigo, int $id_categoria, int $id_proveedor, string $Precio , int $stock, string $ruta, int $status){
			$this->intIdProducto = $id_producto;
			$this->strNombre = $Nombre_producto ;
			$this->strDescripcion = $Descripcion ;
			$this->intCodigo = $Codigo;
			$this->intCategoriaId = $id_categoria;
			$this->intProveedorId = $id_proveedor;
			$this->strPrecio = $Precio ;
			$this->intStock = $stock;
			$this->intStatus = $status;
			$this->ruta = $ruta;
			$return = 0;
			$sql = "SELECT * FROM tbl_producto WHERE Codigo = '{$this->intCodigo}' AND id_producto != $this->intIdProducto ";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "UPDATE tbl_producto 
						SET id_categoria=?,
							id_proveedores=?,
							Codigo=?,
							Nombre_producto =?,
							Descripcion =?,
							Precio =?,
							stock=?,
							ruta=?,
							status=? 
						WHERE id_producto = $this->intIdProducto ";
				$arrData = array($this->intCategoriaId,
								$this->intProveedorId,
        						$this->intCodigo,
        						$this->strNombre,
        						$this->strDescripcion,
        						$this->strPrecio,
        						$this->intStock,
        						$this->ruta,
        						$this->intStatus);

	        	$request = $this->update($sql,$arrData);
	        	$return = $request;
			}else{
				$return = "exist";
			}
	        return $return;
		}

		public function selectProducto(int $id_producto){
			$this->intIdProducto = $id_producto;
			$sql = "SELECT p.id_producto,
							p.Codigo,
							p.Nombre_producto ,
							p.Descripcion ,
							concat(pr.Nombre_proveedor,' ', pr.Apellido_Proveedor) as Nombre_proveedor,
							p.Precio ,
							p.stock,
							pr.id_proveedores,
							p.id_categoria,
							c.nombre_categoria as categoria,
							p.status
					FROM tbl_producto p
					INNER JOIN tbl_categoria c
					ON p.id_categoria = c.id_categoria
					INNER JOIN tbl_proveedores pr 
					ON pr.id_proveedores = p.id_proveedores
					WHERE id_producto = $this->intIdProducto";
			$request = $this->select($sql);
			return $request;

		}

		public function insertImage(int $id_producto, string $imagen){
			$this->intIdProducto = $id_producto;
			$this->strImagen = $imagen;
			$query_insert  = "INSERT INTO imagen(productoid,img) VALUES(?,?)";
	        $arrData = array($this->intIdProducto,
        					$this->strImagen);
	        $request_insert = $this->insert($query_insert,$arrData);
	        return $request_insert;
		}

		public function selectImages(int $id_producto){
			$this->intIdProducto = $id_producto;
			$sql = "SELECT productoid,img
					FROM imagen
					WHERE productoid = $this->intIdProducto";
			$request = $this->select_all($sql);
			return $request;
		}

		public function deleteImage(int $id_producto, string $imagen){
			$this->intIdProducto = $id_producto;
			$this->strImagen = $imagen;
			$query  = "DELETE FROM imagen 
						WHERE productoid = $this->intIdProducto 
						AND img = '{$this->strImagen}'";
	        $request_delete = $this->delete($query);
	        return $request_delete;
		}

		public function deleteProducto(int $id_producto){
			$this->intIdProducto = $id_producto;
			$sql = "UPDATE tbl_producto SET status = ? WHERE id_producto = $this->intIdProducto ";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}

		public function selectProveedor()
		{
			$sql = "SELECT p.id_proveedores, concat(p.Nombre_proveedor,' ', p.Apellido_Proveedor) as Nombre_proveedor, p.status
				 FROM tbl_proveedores p
					WHERE p.status != 0 ";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectGetProductos() {
			$sql = "SELECT id_producto, Nombre_producto
					FROM tbl_producto
					WHERE tbl_producto.status != 0"; 
			$request = $this->select_all($sql);
			return $request;
		}
	}
 ?>