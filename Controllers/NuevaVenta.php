<?php 
	//Pagina principal

	Class NuevaVenta extends Controllers {
		Public function __construct() {
			$this->views = new Views();
			parent::__construct();
			session_start();
		//	session_regenerate_id(true);
			if(empty($_SESSION['login'])) {
				header('Location: '.base_url().'/login');
			}
			getPermisos(11);
		}

		public function NuevaVenta($params)	{
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['Etiqueta_Pagina']="Nueva Venta";
			$data['Titulo_pagina'] = "Nueva Venta";
			$data['Nombre_pagina'] = "Nueva Venta";
			$data['page_functions_js'] = "function_NuevaVenta.js";
			$this->views->getViews($this,"NuevaVenta",$data);
		}
	}
?>