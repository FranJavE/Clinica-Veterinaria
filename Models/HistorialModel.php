<?php
Class HistorialModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getHistorialventas()
    {
        $sql = "SELECT tbl_ventas.*, CONCAT(tbl_persona.Nombre, ' ', tbl_persona.Apellido) AS NombreCompleto
                FROM tbl_ventas
                JOIN tbl_persona ON tbl_ventas.id_cliente = tbl_persona.id_persona";
        $data = $this->select_all($sql);
        return $data;
    }
    
   
    public function deleteHistorial($intidHistorial)
    {
        $this->idHistorial = $intidHistorial;
        $sql = "DELETE FROM tbl_ventas WHERE id = $this->idHistorial";
        $request = $this->delete($sql);
        
        if ($request) {
            $response = array("status" => true, "msg" => "Se ha eliminado el registro");
        } else {
            $response = array("status" => false, "msg" => "Error al eliminar el registro: " . $this->error());
        }
        
        return $response;
    }
    
}