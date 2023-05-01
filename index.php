<?php 
	require_once("Config/Config.php");
	require_once("Helpers/Helpers.php");
	 
	$url =!empty($_GET['ruta']) ? $_GET['ruta'] : 'home/home';

	//decaracion de variables 
	$arrUrl = explode("/", $url);
	$controller = $arrUrl[0];
	$metodo = $arrUrl[0];
	$params = "";

	//Validacion para el metodo
	if (!empty($arrUrl[1]))
	{
		if ($arrUrl[1] != "")
		{
			$metodo = $arrUrl[1];
		}
	}
	//Validacion para los parametros
	if (!empty($arrUrl[2]))
	{
		if ($arrUrl[2] != "")
		{
			//ciclo para asignar a la variable lo que hay despues de la posicion dos 
			for ($i=2; $i < count($arrUrl); $i++)
		    { 
				$params .= $arrUrl[$i].',';	
			}
			//con esta funcion estamos eliminando la ultima coma al final de la cadena
			$params = trim($params,',');
		}
	}
	
	//Autoload
	require_once("Libraries/Core/Autoload.php");

	//Load
	require_once("Libraries/Core/Load.php");
	

 ?>