<?php
Class VentasModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getProCod(string $cod)
    {
        $sql = "SELECT * FROM tbl_producto WHERE Codigo = '$cod'";
        $data = $this->select($sql);
        return $data;
    }

    public function getProductos(int $id_producto)
    {
        $sql = "SELECT * FROM tbl_producto WHERE id_producto = $id_producto";
        $data = $this->select($sql);
        return $data;
    }

    public function registrarDetalles(int $id_producto, int $idUsuario, string $precio, int $cantidad, string $sub_total)
    {
        $sql = "INSERT INTO tbl_detalle_venta(id_producto, id_persona, precio, cantidad, sub_total) VALUES (?,?,?,?,?)";
        $datos = array($id_producto, $idUsuario, $precio, $cantidad, $sub_total);
        $data = $this->insert($sql, $datos);
        
        if ($data === false) {
            throw new Exception("Error al insertar en la base de datos");
        }
    }
    
    public function getDetalle(int $id)
    {
        $sql = "SELECT d.*, p.id_producto AS id_pro, p.Descripcion FROM tbl_detalle_venta d INNER JOIN tbl_producto p ON d.id_producto = p.id_producto WHERE d.id_persona = $id";
        $data = $this->select_all($sql);
        return $data;
    }

    public function calcularVenta(int $idUsuario)
    {
        $sql = "SELECT sub_total, SUM(sub_total) AS total FROM  tbl_detalle_venta WHERE id_persona = $idUsuario";
        $data = $this->select($sql);
        return $data;
    }

    public function deleteDetalle(int $id)
    {
        $sql = "DELETE FROM tbl_detalle_venta WHERE id = ?";
        $datos = array($id);
        
        $data = $this->insert($sql, $datos);
        if ($data == 1) {
            return 'ok';
        } else {
            return 'error';
        }
    }

    public function registrarVenta(string $total)
    {
        $sql ="INSERT INTO tbl_ventas (total) VALUES (?)";
        $datos = array($total);
        $data = $this->insert($sql, $datos);
        
        if ($data === false) {
            throw new Exception("Error al insertar en la base de datos");
        }
    }

    public function id_venta()
    {
       $sql = "SELECT MAX(id) AS id FROM tbl_ventas";
       $data = $this->select($sql);
       return $data;
    }

    public function registrarDetalleVenta(int $id_venta, int $id_pro, int $cantidad, string $precio, string $sub_total)
    {
        $sql ="INSERT INTO tbl_venta_detalle (id_venta, id_producto, cantidad, precio, sub_total) VALUES (?,?,?,?,?)";
        $datos = array($id_venta, $id_pro, $cantidad, $precio, $sub_total);
        $data = $this->insert($sql, $datos);
        
        if ($data === false) {
            throw new Exception("Error al insertar en la base de datos");
        }
    }

    public function vaciarDetalle(int $idUsuario)
    {
        $sql ="DELETE FROM tbl_detalle_venta WHERE id_persona = ?";
        $datos = array($idUsuario);
        $data = $this->insert($sql, $datos);
        
        if ($data === false) {
            throw new Exception("Error al insertar en la base de datos");
        }

    }

    public function getProVenta(string $id_venta)
    {
        $sql = "SELECT v.*, d.*, p.id_producto, p.Descripcion FROM tbl_ventas v INNER JOIN tbl_venta_detalle d ON v.id = d.id_venta INNER JOIN tbl_producto p ON p.id_producto = d.id_producto WHERE v.id = '$id_venta'";
        $data = $this->select_all($sql);
        return $data;
    }

}