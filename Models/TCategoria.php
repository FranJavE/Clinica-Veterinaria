<?php 
	require_once("Libraries/Core/MySQL.php");

	trait TCategoria{
		private $con;


		public function getCategoriasT(string $categorias) {
			$this->con = new MySQL();
			$sql = "SELECT id_categoria, nombre_categoria, Descripcion, portada, ruta  FROM tbl_categoria
			WHERE status != 0 AND id_categoria IN ($categorias)";
			$request = $this->con->select_all($sql);
			if (count($request) > 0) {
				for ($c=0; $c < count($request); $c++) {
					$request[$c]['portada'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['portada'];

				}
			}
			return $request;
		}

	}

?>