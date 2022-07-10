<?php
require_once "conexion/conexion.php";


class Prestamo extends Conexion {

    private $table = "prestamos";

    public function listaPrestamos(){
        $query = "SELECT a.id, b.nombre, a.monto, a.plazo FROM " . $this->table . " as A " . 
            "INNER JOIN clientes AS b 
            ON a.id_cliente = b.id
            ORDER BY b.nombre";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }

    public function obtenerPrestamosCliente($nombreCliente){
        $query = "SELECT a.id, b.nombre, a.monto, a.plazo 
                    FROM " . $this->table . " AS a " .
                    "INNER JOIN clientes AS b " .
                    "ON a.id_cliente = b.id " .
                    "WHERE b.nombre LIKE '%". $nombreCliente . "%'
                     ORDER BY b.nombre";
        return parent::obtenerDatos($query);
    }

    public function agregarPrestamo($cliente, $monto, $plazo) {
        $query = "INSERT INTO " . $this->table . " 
            (id_cliente, monto, plazo) VALUES 
            (" . $cliente . "," . $monto . "," . $plazo .")"; 
        $resp = parent::nonQueryId($query);
        return $resp;
    }

    public function obtenerAmortizacion($idPrestamo){
        $query = "SELECT a.numero_pago, a.fecha, b.monto, a.interes, a.abono 
                    FROM amortizaciones AS a " .
                    "INNER JOIN " . $this->table . " AS b " .
                    "ON a.id_prestamo = b.id " .
                    "WHERE a.id_prestamo = " . $idPrestamo . " ORDER BY a.fecha";
        return parent::obtenerDatos($query);
    }

}