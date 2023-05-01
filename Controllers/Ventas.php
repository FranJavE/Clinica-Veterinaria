<?php 
	//Pagina principal

	Class Ventas extends Controllers{

		Public function __construct()
		{
			$this->views = new Views();
			parent::__construct();
			session_start();
		//	session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(4);
		}

		public function Ventas($params)
		{
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$data['Etiqueta_Pagina']="Ventas";
			$data['Titulo_pagina'] = "Ventas";
			$data['Nombre_pagina'] = "Ventas";
			$data['page_functions_js'] = "function_Ventas.js";
			$this->views->getViews($this,"Ventas",$data);
		}
		public function setVentas(){

		}

		public function getVenta($idVenta)
		{

		}
		
		public function DelVenta($idVenta)
		{

		}
	}
?>