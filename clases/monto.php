<?php
require_once "conexion/conexion.php";

class Monto extends Conexion {

    private $table = "montos";

    public function listaMontos(){
        $query = "SELECT monto, plazo FROM " . $this->table;
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

}