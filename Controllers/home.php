<?php 
	//Pagina principal
	require_once("Models/TCategoria.php");
	require_once("Models/TProducto.php");

	Class home extends Controllers {
		use TCategoria, TProducto;

		Public function __construct() {
			$this->views = new Views();
			parent::__construct();	
		}

		public function home($params) {
			
			$data['page_id'] = 1;
			$data['Etiqueta_Pagina']= NOMBRE_EMPESA;
			$data['Titulo_pagina'] = NOMBRE_EMPESA;
			$data['Nombre_pagina'] = "Clinica_veterinaria ";
			$data['slider'] = $this->getCategoriasT(CAT_SLIDER);
			$data['banner'] = $this->getCategoriasT(CAT_BANNER);
			$data['producto'] = $this->getProductosT();
			$this->views->getViews($this,"home",$data);
		}	
	}
?>