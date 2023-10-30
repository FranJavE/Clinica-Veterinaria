<?php 
	include "conex.php";
	
	class Respaldo
	{
		public function __construct(){}

        public function Respaldo($params) {
            // Introduce aquí la información de tu base de datos
            $mysqlDatabaseName = 'bd_veterinaria';
            $mysqlUserName = 'root';
            $mysqlPassword = '';
            $mysqlHostName = 'localhost';
            $fecha = date("Ymd-His");

            // Define el nombre y la ruta del archivo de copia de seguridad
            $mysqlExportPath = 'C:/xampp_3/htdocs/Clinica_Veterinaria/Respaldos/';
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