<?php 
	
	class Respaldos extends Controllers{
		public $views;
		public $modelo;
		public function __construct(){
            $this->views = new Views();
			parent::__construct();
			session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login']))
			{
				header('Location: '.base_url().'/login');
			}
			getPermisos(2);

        }

        public function Respaldos(){
			$data['Etiqueta_Pagina']="Respaldo de base de datos";
			$data['Titulo_pagina'] = "Respaldo de base de datos";
			$data['Nombre_pagina'] = "Respaldo";
			$data['page_functions_js'] = "function_respaldos.js";
			$this->views->getViews($this,"Respaldos",$data);
		}

        public function Respaldo($params) {
            // Introduce aquí la información de tu base de datos
            $mysqlDatabaseName = 'bd_veterinaria';
            $mysqlUserName = 'root';
            $mysqlPassword = '';
            $mysqlHostName = 'localhost';
            $fecha = date("Ymd-His");

            // Define el nombre y la ruta del archivo de copia de seguridad
            $mysqlExportPath = 'C:/xampp/htdocs/Clinica_Veterinaria/Respaldos/';
            $salida_sql = $mysqlExportPath.$mysqlDatabaseName . '_' . $fecha . '.sql';

            //$command = "mysqldump -h$mysqlHostName  -u$mysqlUserName -p$mysqlPassword --opt $mysqlDatabaseName > $salida_sql";
            $command = 'mysqldump --opt -h' . $mysqlHostName . ' -u' . $mysqlUserName . ' --password="' . $mysqlPassword . '" ' . $mysqlDatabaseName . ' > ' . $salida_sql;
            system($command, $output);
            //$command = "mysqldump -h $mysqlHostName -u$mysqlUserName -p$mysqlPassword --opt $mysqlDatabaseName > respaldo.sql";
            echo "$command";
            //exec($command);
            // Verifica que la copia de seguridad se haya creado correctamente
            if (file_exists('backup.sql')) {
                echo "La copia de seguridad se ha creado correctamente.";
            } else {
                echo "Error al crear la copia de seguridad.";
            }

		}
	}



?>