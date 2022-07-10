<?php
require_once "conexion/conexion.php";

class Cliente extends Conexion {

    private $table = "clientes";

    public function listaClientes(){
        $query = "SELECT id, nombre, telefono, edad FROM " . $this->table;
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

    public function obtenerCliente($id){
        $query = "SELECT id, nombre, telefono, edad FROM " . $this->table . " WHERE id = ". $id;
        return parent::obtenerDatos($query);

    }

}