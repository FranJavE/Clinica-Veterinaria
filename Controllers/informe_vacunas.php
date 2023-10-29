<?php 
	//Pagina principal

	Class informe_vacunas extends Controllers{

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

		public function informe_vacunas($params) {
			
			$data['page_id']=10;
			$data['Etiqueta_Pagina']="Informe Vacunas Veterinaria";
			$data['Titulo_pagina'] = "Informe de Vacunas";
			$data['Nombre_pagina'] = "Informe de Vacunas";
			$data['page_functions_js'] = "function_informe_vacunas.js";
			$this->views->getViews($this,"informe_vacunas",$data);
		}
		
	}


?>