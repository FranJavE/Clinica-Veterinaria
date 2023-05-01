<?php 
	Class Views
	{
		//Resive el controlador y la vista que vamos a mostrar
		function getViews($controller, $view, $data="")
		{
			$controller = get_class($controller);
			if($controller == "home")
			{
				//bsucamos la vista para el home
				$view = "Views/".$view.".php";
			}else{
				//si no el controlador no es homo por lo tanto buscamos entro contolador y armamos la
				$view = "Views/". $controller."/".$view.".php";
			}
			require_once($view);
		}
	
}
	
	

?>