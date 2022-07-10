<?php
require_once 'clases/respuesta.php';
require_once 'clases/monto.php';
require_once './allowaccess.php';

$respuesta = new Respuesta();
$monto = new Monto();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $listaMontos = $monto->listaMontos();
        $respuesta->response['result'] = $listaMontos;
        
        if (count($listaMontos) == 0) {
            $respuesta->response['mensaje'] = "No se encontraron montos ni plazos de pago";
        }

        header("Content-Type: application/json");
        echo json_encode($respuesta->response);
        break;
    
    default:
        header('Content-Type: application/json');
        $datosArray = $respuesta->error_405();
        echo json_encode($datosArray);
        break;
}

?>