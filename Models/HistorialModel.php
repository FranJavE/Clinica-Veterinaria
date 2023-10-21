<?php
Class HistorialModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getHistorialventas()
    {
      $sql = "SELECT * FROM tbl_ventas";
      $data = $this->select_all($sql);
      return $data;
    }
   
    public function deleteHistorial($intidHistorial)
    {
        $this->idHistorial = $intidHistorial;
    
        // Mensaje de depuración
        echo "El ID del registro es: " . $this->idHistorial;
    
        $sql = "DELETE FROM tbl_ventas WHERE id = $this->idHistorial";
        $request = $this->delete($sql);
        return $request;
    }

}