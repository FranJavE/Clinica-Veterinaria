<?php 
	//Pagina principal
	require_once("Models/TCategoria.php");
	require_once("Models/TProducto.php");

	Class Tienda extends Controllers {
		use TCategoria, TProducto;

		Public function __construct() {
			$this->views = new Views();
			parent::__construct();	
		}

		public function Tienda() {
			
			$data['page_id'] = 1;
			$data['Etiqueta_Pagina']= NOMBRE_EMPESA;
			$data['Titulo_pagina'] = NOMBRE_EMPESA;
			$data['Nombre_pagina'] = "tienda";
			$data['producto'] = $this->getProductosT();
			$this->views->getViews($this,"tienda",$data);
		}

		public function categoria($params){
			if (empty($params)) {
				header("Location:".base_url());
			} else {
				$arrParams = explode(",", $params);
				$idCategoria = intval($arrParams[0]);
				$ruta = strClean($arrParams[1]);
				$infoCategoria = $this->getProductosCategoriasT($idCategoria, $ruta);
				$categoria = strClean($params);
				$data['Etiqueta_Pagina']= NOMBRE_EMPESA." - ".$infoCategoria['categoria'];
				$data['Titulo_pagina'] = $infoCategoria['categoria'];
				$data['Nombre_pagina'] = "categoria";
				$data['producto'] = $infoCategoria['productos'];
				$this->views->getViews($this,"categoria",$data);
			}
		}

		public function producto($params){
			if (empty($params)) {
				header("Location:".base_url());
			} else {
				$arrParams = explode(',', $params);
				$idProducto = intval($arrParams[0]);
				$ruta = strClean($arrParams[1]);
				$infoProductos = $this->getProductoT($idProducto, $ruta);
				if (empty($infoProductos)) {
					header("Location:".base_url());
				}

				$data['Etiqueta_Pagina']= NOMBRE_EMPESA." - ".$infoProductos['Nombre_producto'];
				$data['Titulo_pagina'] = $infoProductos['Nombre_producto'];;
				$data['Nombre_pagina'] = "producto";
				$data['producto'] = $infoProductos;
				$data['productos'] = $this->getProductosRandom($infoProductos['id_categoria'],8,"r");
				$this->views->getViews($this,"producto",$data);
			}
		}
	}
?>