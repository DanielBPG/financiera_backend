<?php

class Conexion {

    private $server;
    private $user;
    private $password;
    private $database;
    private $port;
    private $conexion;

    //Se crea la conexión a partir de los datos
    function __construct(){
        $listadatos = $this->datosConexion();
        foreach ($listadatos as $key => $value) {
            $this->server = $value['server'];
            $this->user = $value['user'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }
        $this->conexion = new mysqli($this->server, $this->user, $this->password, 
                            $this->database, $this->port);
        if($this->conexion->connect_errno){
            echo "Conexión fallida";
            die();
        }

    }

    //Se usan los datos que hay en el archivo config.php
    private function datosConexion(){
        $direccion = dirname(__FILE__);
        $jsondata = file_get_contents($direccion . "/" . "config");
        return json_decode($jsondata, true);
    }


    //toma cada elemento del arreglo para pasarlos a la funcion y  detectar su encoding
    //y convertir sus caracteres a utf-8
    private function convertirUTF8($array){
        array_walk_recursive($array, function(&$item,$key){
            if(!mb_detect_encoding($item,'utf-8',true)){
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

    //una vez creada la conexion se corre el query para obtener los datos
    public function obtenerDatos($sqlstr){
        $results = $this->conexion->query($sqlstr);
        $resultArray = array();
        foreach ($results as $key) {
            $resultArray[] = $key;
        }
        return $this->convertirUTF8($resultArray);

    }

    public function nonQuery($sqlstr){
        $results = $this->conexion->query($sqlstr);
        return $this->conexion->affected_rows;
    }

    //INSERT 
    public function nonQueryId($sqlstr){
        $this->conexion->query($sqlstr);
        $filas = $this->conexion->affected_rows;
        if($filas >= 1){
        return $this->conexion->insert_id;
        }else{
            return 0;
        }
    }    
}
?>
