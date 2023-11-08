<?php 
	//Pagina principal

	Class informe_ventas extends Controllers{

		Public function __construct() {
			$this->views = new Views();
			parent::__construct();
			session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(10);
		}

		public function informe_ventas($params) {
			
			$data['page_id']=10;
			$data['Etiqueta_Pagina']="Informe ventas Veterinaria";
			$data['Titulo_pagina'] = "Informe de ventas";
			$data['Nombre_pagina'] = "Informe de ventas";
			$data['page_functions_js'] = "function_informe_ventas.js";
			$this->views->getViews($this,"informe_ventas",$data);
		}
		
	}


?>