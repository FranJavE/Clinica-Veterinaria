<?php 
	//Pagina principal

	Class Dashboard extends Controllers{
		public $views;
		public $modelo;

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

			$data ['cantidadUsuarios'] = $this->modelo->cantUsuarios();
			$data ['cantidadClientes'] = $this->modelo->cantClientes();
			$data ['cantidadMascotas'] = $this->modelo->cantMascotas();
			$data ['cantidadConsultas'] = $this->modelo->cantConsultas();
			$data ['cantidadCitas'] = $this->modelo->cantCitas();
			$data ['cantidadVacunas'] = $this->modelo->cantVacunas();
			$data ['cantidadProductos'] = $this->modelo->cantProductos();
			$data ['cantidadVentas'] = $this->modelo->cantVentas();
			$data ['cantidadGuarderia'] = $this->modelo->cantGuarderia();

			$this->views->getViews($this,"Dashboard",$data);
		}
		
	}


?>