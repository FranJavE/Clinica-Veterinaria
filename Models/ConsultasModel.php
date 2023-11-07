
<?php 

	Class ConsultasModel extends Mysql
	{
		private $IdConsulta; 
		Private $IdMascota;
		Private $IdMedico;

		Private $strDescripcion;
		Private $strfecha;
		Private $strhora;
		Private $intStatus;
		public function __construct()
		{
			parent::__construct();
			
		}

		public function insertConsulta($intIsPaciente ,$intIsMedico ,$strDescripcion ,$DateFecha ,$strHora ,$intPrecio)
		{
			$this->IdMascota = $intIsPaciente;
			$this->IdMedico = $intIsMedico;
			$this->strDescripcion = $strDescripcion;
			$this->intPrecio = $intPrecio;
			$this->strfecha = $DateFecha;
			$this->strhora = $strHora;
			$return = 0;

			$sql = "SELECT * FROM tbl_consultas where fechaConsulta = '{$this->strfecha}' and Hora ='{$this->strhora}' and status = 1 and id_mascota ='{$this->IdMascota}'";
			$request = $this->select_all($sql);
			if(empty($request)){
				$query_insert = "INSERT INTO tbl_consultas(id_mascota,id_medico,Descripcion,fechaConsulta,Precio,hora) VALUES(?,?,?,?,?,?)";
				$arrData = array($this->IdMascota,
								$this->IdMedico,
								$this->strDescripcion,
								$this->strfecha,
								$this->intPrecio,
								$this->strhora);

				$request_insert = $this->insert($query_insert,$arrData);
				$return = $request_insert;
			}else{
				$return="exist";
			}
			return $return;
		}
		public function updateConsulta($idConsulta,$intIsPaciente ,$intIsMedico ,$strDescripcion ,$DateFecha ,$strHora ,$intPrecio)
		{
			$this->IdConsulta = $idConsulta;
			$this->IdMascota = $intIsPaciente;
			$this->IdMedico = $intIsMedico;
			$this->strDescripcion = $strDescripcion;
			$this->intPrecio = $intPrecio;
			$this->strfecha = $DateFecha;
			$this->strhora = $strHora;
			$return = 0;
			$sql = "SELECT * FROM tbl_consultas where fechaConsulta = '{$this->strfecha}' and Hora ='{$this->strhora}' and status = 1 and id_mascota ='{$this->IdMascota}' and id_Consulta != $this->IdConsulta";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				
				$sql = "UPDATE tbl_consultas SET id_mascota=?, id_medico=?, Descripcion=?,Precio=?,fechaConsulta=?,hora=?
				where id_Consulta = $this->IdConsulta";
				$arrData = array($this->IdMascota,
								$this->IdMedico,
								$this->strDescripcion,
								$this->intPrecio,
								$this->strfecha,
								$this->strhora);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		}
	public function insertDetalleConsulta($idConsulta, $idProducto, $descripcion, $stock, $precio, $cantidad, $total)
	{
		$query_insert = "INSERT INTO tbl_detalle_consultas(id_consulta, id_producto, descripcion, stock, precio, cantidad, total) VALUES (?, ?, ?, ?, ?, ?, ?)";
		$arrData = array(
				$idConsulta,
				$idProducto,
				$descripcion,
				$stock,
				$precio,
				$cantidad,
				$total
			);

		return $this->insert($query_insert, $arrData);
	}

	public function updateDetalleConsulta($idDetalleConsulta, $idProducto, $descripcion, $stock, $precio, $cantidad, $total)
	{
		$sql = "UPDATE tbl_detalle_consultas SET id_producto=?, descripcion=?, stock=?, precio=?, cantidad=?, total=? WHERE id_detalle_consulta = ?";
		$arrData = array(
			$idProducto,
			$descripcion,
			$stock,
			$precio,
			$cantidad,
			$total,
			$idDetalleConsulta
		);

		return $this->update($sql, $arrData);
	}
	public function getProductosActivos() {
		$sql = "SELECT id_producto, Nombre_producto FROM tbl_producto WHERE status = 1";
		$request = $this->select_all($sql);
		return $request;

		$model = new ConsultasModel();
		$productosActivos = $model->getProductosActivos();
	  
		echo json_encode($productosActivos);
	}
	
		public function selecConsultas() {
			$sql = "SELECT c.id_Consulta,concat(p.Nombre,' ', p.Apellido) as 'Dueño', m.Nombre as 'NombreMascota', me.NombreMedico, e.NombreEspecie, c.Descripcion, c.fechaconsulta, c.hora,c.Precio, c.status
				FROM tbl_consultas c
				INNER JOIN tbl_mascota m
				ON c.id_mascota = m.id_mascota
				INNER JOIN tbl_persona p 
				ON p.id_persona = m.id_persona
				INNER JOIN tbl_raza r 
				ON r.id_raza = m.id_raza
				INNER JOIN tbl_especie e 
				ON e.id_especie = r.id_especie
                INNER JOIN tbl_medico me 
                ON me.id_medico = c.id_medico
				where c.status != 0";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectConsulta(int $idConsulta)
		{
			$this->IdConsulta = $idConsulta;
			$sql = "SELECT c.id_Consulta,concat(p.Nombre,' ', p.Apellido) as 'Dueño', m.Nombre as 'NombreMascota', me.NombreMedico, e.NombreEspecie,r.NombreRaza, c.Descripcion, c.fechaconsulta, c.hora,c.Precio, c.status,me.id_medico, m.id_mascota, p.id_persona
				FROM tbl_consultas c
				INNER JOIN tbl_mascota m
				ON c.id_mascota = m.id_mascota
				INNER JOIN tbl_persona p 
				ON p.id_persona = m.id_persona
				INNER JOIN tbl_raza r 
				ON r.id_raza = m.id_raza
				INNER JOIN tbl_especie e 
				ON e.id_especie = r.id_especie
                INNER JOIN tbl_medico me 
                ON me.id_medico = c.id_medico
				where c.status != 0 and id_Consulta = $this->IdConsulta ";
			$request = $this->select($sql);
			return $request;
		}

		public function deleteConsulta(int $idConsulta)
		{
			$this->IdConsulta = $idConsulta;
			$sql = "UPDATE tbl_consultas SET status = ? WHERE id_Consulta = $this->IdConsulta";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}


	}
?>