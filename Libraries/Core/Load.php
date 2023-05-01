<?php 
	$controller = ucwords($controller);
	$controllerFile = "Controllers/".$controller.".php";
	if(file_exists($controllerFile))
	{
		require_once($controllerFile);
		$controller = new $controller();
		//Si existe el metodo en este controlador entonces utilizamos ese metodo por medio de la instancia que hemos creado
		if(method_exists($controller, $metodo))
		{
			//Nos referimos al metodo y parametros en el caso que hayamos enviado parametros por medio de la URL
			$controller->{$metodo}($params);
		}else{
			require_once("Controllers/Error.php");
		}
	}else{
		require_once("Controllers/Error.php");
	}
?>