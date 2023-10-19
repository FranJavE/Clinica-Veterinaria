<?php 
	//Pagina principal

	Class informe_consulta extends Controllers{

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

		public function informe_consulta($params) {
			
			$data['page_id']=10;
			$data['Etiqueta_Pagina']="Informe_Consulta-Veterinaria";
			$data['Titulo_pagina'] = "Informe de consulta";
			$data['Nombre_pagina'] = "Informe de Consultas";
			$data['page_functions_js'] = "function_informe_consulta.js";
			$this->views->getViews($this,"informe_consulta",$data);
		}


	   public function getInformeConsulta($idConsulta) {
			if(empty($_SESSION['PermisosMod']['r'])) {
				header('Location: '.base_url().'/Dashboard');
			}
			$arrData = $this->modelo->selectConsulta($idConsulta);
			$data['NombreMascota'] =  $arrData['NombreMascota'];
			$data['page_functions_js'] = "function_informe_consulta.js";
			$this->views->getViews($this,"reporte_informe_consulta",$data);
		}
		
	}


?>