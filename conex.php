<?php 
	$host = 'localhost';
	$user = 'root';
	$password = ''; 
	$db= 'bd_veterinaria';

	$conecction = @mysqli_connect($host,$user,$password,$db);
	if (!$conecction) {
		echo "Error de conexion";
	}

?>