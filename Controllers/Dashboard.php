<?php 
	//Pagina principal

	Class Dashboard extends Controllers{

		Public function __construct()
		{
			$this->views = new Views();
			parent::__construct();
			session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(1);
		}

		public function Dashboard($params)
		{
			
			$data['page_id']=2;
			$data['Etiqueta_Pagina']="Dashboard-Veterinaria";
			$data['Titulo_pagina'] = "Clinica Veterinaria";
			$data['Nombre_pagina'] = "Dashboard";
			$this->views->getViews($this,"Dashboard",$data);
		}
		
	}


?>