<?php
	require_once("Libraries/Core/MySQL.php");

	trait TProducto{
		private $con;
		private $strCategorias;
		private $intIdCategoria;
		private $intIdProducto;
		private $strProducto;
		private $cant;
		private $option;
		private $strRuta;
		public function getProductosT() {
			$this->con = new MySQL();
			$sql = "SELECT p.id_producto,
								p.Codigo,
								p.Nombre_producto ,
								p.Descripcion ,
								p.id_categoria,
								c.nombre_categoria as categoria,
								p.Precio ,
								p.ruta,
								p.stock
						FROM tbl_producto p 
						INNER JOIN tbl_categoria c
						ON p.id_categoria = c.id_categoria
						WHERE p.status != 0
						ORDER BY p.id_producto DESC";
						$request = $this->con->select_all($sql);
				if (count($request) > 0) {
					for ($c=0; $c < count($request); $c++) {
						$intIdProducto = $request[$c]['id_producto'];
						$sqlImg = "SELECT img
						FROM imagen
						WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg);
						if (count($arrImg) > 0) {
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$request[$c]['images'] = $arrImg;
					}
				}
				return $request;
		}

		public function getProductosCategoriasT(int $idCategoria, string $ruta) {
			$this->intIdCategoria = $idCategoria;
			$this->strRuta = $ruta;
			$this->con = new MySQL();
			$sqlCategoria = "SELECT id_categoria, nombre_categoria FROM tbl_categoria WHERE id_categoria = $this->intIdCategoria";
			$request = $this->con->select($sqlCategoria);
			if (!empty($request)) {
				$this->strCategorias = $request['nombre_categoria'];
				$sql = "SELECT p.id_producto,
						p.Codigo,
						p.Nombre_producto ,
						p.Descripcion ,
						p.id_categoria,
						c.nombre_categoria as categoria,
						p.Precio ,
						p.ruta,
						p.stock
				FROM tbl_producto p 
				INNER JOIN tbl_categoria c
				ON p.id_categoria = c.id_categoria
				WHERE p.status != 0 
				  AND p.id_categoria = $this->intIdCategoria
				 And c.ruta = '{$this->strRuta}' ";
				$request = $this->con->select_all($sql);
				if (count($request) > 0) {
					for ($c=0; $c < count($request); $c++) {
						$intIdProducto = $request[$c]['id_producto'];
						$sqlImg = "SELECT img
						FROM imagen
						WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg);
						if (count($arrImg) > 0) {
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						}
						$request[$c]['images'] = $arrImg;
					}
				}
				$request = array('idCategoria' => $this->intIdCategoria,
					'categoria' => $this->strCategorias,
					'productos' => $request
				);
			}
			return $request;
		}

		public function getProductoT(int $IdProducto, string $ruta) {
			$this->intIdProducto = $IdProducto;
			$this->con = new MySQL();
			$this->strRuta = $ruta;
			$sql = "SELECT p.id_producto,
								p.Codigo,
								p.Nombre_producto ,
								p.Descripcion ,
								p.id_categoria,
								c.nombre_categoria as categoria,
								p.Precio ,
								p.ruta,
								p.stock
						FROM tbl_producto p 
						INNER JOIN tbl_categoria c
						ON p.id_categoria = c.id_categoria
						WHERE p.status != 0
						And p.ruta = '{$this->strRuta}' 
						AND p.id_producto = '{$this->intIdProducto}'";
				$request = $this->con->select($sql);
				if (!empty($request)) {
						$intIdProducto = $request['id_producto'];
						$sqlImg = "SELECT img
						FROM imagen
						WHERE productoid = $intIdProducto";
						$arrImg = $this->con->select_all($sqlImg);
						if (count($arrImg) > 0) {
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
							}
						} else {
							$arrImg[0]['url_image'] = media().'/images/uploads/product.png';
						}
						$request['images'] = $arrImg;
				}
				return $request;
		}

		public function getProductosRandom(int $idCategoria, int $cant, string $option) {
			$this->intIdCategoria = $idCategoria;
			$this->cant = $cant;
            $this->option = $option;
            dep($option);
            if ($option == "r") {
            	$this->option = " RAND() ";
            } else if ($option == "a") {
            	$this->option = "id_producto ASC ";
            } else {
            	$this->option = "id_producto DESC ";
            }
            $this->con = new MySQL();
			$sql = "SELECT p.id_producto,
					p.Codigo,
					p.Nombre_producto ,
					p.Descripcion ,
					p.id_categoria,
					c.nombre_categoria as categoria,
					p.Precio ,
					p.ruta,
					p.stock
			FROM tbl_producto p 
			INNER JOIN tbl_categoria c
			ON p.id_categoria = c.id_categoria
			WHERE p.status != 0 
			  AND p.id_categoria = $this->intIdCategoria
			 ORDER BY  $this->option
			 LIMIT  $this->cant";
			$request = $this->con->select_all($sql);
			if (count($request) > 0) {
				for ($c=0; $c < count($request); $c++) {
					$intIdProducto = $request[$c]['id_producto'];
					$sqlImg = "SELECT img
					FROM imagen
					WHERE productoid = $intIdProducto";
					$arrImg = $this->con->select_all($sqlImg);
					if (count($arrImg) > 0) {
						for ($i=0; $i < count($arrImg); $i++) { 
							$arrImg[$i]['url_image'] = media().'/images/uploads/'.$arrImg[$i]['img'];
						}
					}
					$request[$c]['images'] = $arrImg;
				}
			}
			return $request;
		}

	}
?>