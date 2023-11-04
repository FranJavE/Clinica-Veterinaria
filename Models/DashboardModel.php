<?php 
	class DashboardModel extends Mysql {
        public function __construct() {
			parent::__construct();
		}
        public function cantUsuarios() {
            $sql= "SELECT COUNT(*) AS cantidad
            FROM tbl_persona AS p
            WHERE p.status != 0 and p.id_rol != 3";
			$request = $this->select($sql);
            $total = $request['cantidad'];
			return $total;
        }
        public function cantClientes() {
            $sql= "SELECT COUNT(*) AS cantidadClientes
            FROM tbl_persona AS p
            INNER JOIN tbl_rol AS r USING(id_rol) 
            WHERE p.status != 0 and (r.NombreRol = 'Cliente' or p.id_rol = 3)";
			$request = $this->select($sql);
            $total = $request['cantidadClientes'];
			return $total;
        }
        public function cantMascotas() {
            $sql= "SELECT COUNT(*) AS cantidad
            FROM tbl_mascota AS m
            WHERE m.status != 0";
			$request = $this->select($sql);
            $total = $request['cantidad'];
			return $total;
        }

        public function cantConsultas() {
            $sql= "SELECT COUNT(*) AS cantidad
            FROM tbl_consultas AS c
            WHERE c.status != 0";
			$request = $this->select($sql);
            $total = $request['cantidad'];
			return $total;
        }
        public function cantCitas() {
            $sql= "SELECT COUNT(*) AS cantidad
            FROM tbl_citas AS c
            WHERE c.status != 0";
			$request = $this->select($sql);
            $total = $request['cantidad'];
			return $total;
        }

        public function cantVacunas() {
            $sql= "SELECT COUNT(*) AS cantidad
            FROM tbl_vacunaxmascota AS v
            WHERE v.status != 0";
			$request = $this->select($sql);
            $total = $request['cantidad'];
			return $total;
        }
        
        public function cantProductos() {
            $sql= "SELECT COUNT(*) AS cantidad
            FROM tbl_producto AS p
            WHERE p.status != 0";
			$request = $this->select($sql);
            $total = $request['cantidad'];
			return $total;
        }

        public function cantVentas() {
            $sql= "SELECT COUNT(*) AS cantidad
            FROM tbl_ventas AS v";
			$request = $this->select($sql);
            $total = $request['cantidad'];
			return $total;
        }

        public function cantGuarderia() {
            $sql= "SELECT COUNT(*) AS cantidad
            FROM tbl_guarderia AS g
            WHERE g.status != 0";
			$request = $this->select($sql);
            $total = $request['cantidad'];
			return $total;
        }
    }
?>