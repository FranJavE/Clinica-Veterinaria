<?php 

	class Controllers
	{ 

		public function __construct() {
			$this->views = new Views();
			$this->CargarModelo();
		}
		public function CargarModelo() {
			$modelo = get_class($this). "Model";
			$rutaClase= "Models/".$modelo.".php";
			if (file_exists($rutaClase)) {
				require_once($rutaClase);
				$this->modelo = new $modelo();
			}
		}
	}

?>