<?php 
	//require_once("CategoriasModel.php");
	Class homeModel extends Mysql {

		private $objCategoria;

		public function __construct() {
			parent::__construct();
			//$this->objCategoria = new CategoriasModel();
		}

		public function getCategorias() {
			//return $this->objCategoria->selectCategorias();
		}

	}
?>