<?php 

class Respuesta{

    public  $response = [
        'status' => "ok",
        'mensaje' => "",
        "result" => array()
    ];

    //En caso de que se quiera acceder a algo inexistente
    public function error_405(){
        $this->response['status'] = "error";
        $this->response['mensaje'] = "Metodo no permitido";
        return $this->response;
    }

    public function error_400(){
        $this->response['status'] = "error";
        $this->response['mensaje'] = "Datos enviados incompletos o con formato incorrecto";
        return $this->response;
    }

    public function error_500($valor = "Error interno del servidor"){
        $this->response['status'] = "error";
        $this->response['mensaje'] = $valor;
        return $this->response;
    }

    public function error_401($valor = "No autorizado"){
        $this->response['status'] = "error";
        $this->response['mensaje'] = $valor;
        return $this->response;
    }
    
    

}

?>