<?php 
	Class Errores extends Controllers{
		public function __construct()
		{
			//Como estamos heredando ejecutamos el metodo constructor de la clase padre
			parent::__construct();
		}
		public function notFound()
		{
			$this->views->getViews($this,"Error");
			session_start();
		//	session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
		}
	}

	//Instancioamos la clase error
	$notFound = new Errores();
	$notFound -> notFound();
?>