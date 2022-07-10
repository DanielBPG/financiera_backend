<?php
require_once 'clases/respuesta.php';
require_once 'clases/cliente.php';
require_once './allowaccess.php';

$respuesta = new Respuesta();
$cliente = new Cliente();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if(isset($_GET["id"])){
            $idCliente = $_GET["id"];
            $informacionCliente = $cliente->obtenerCliente($idCliente);
            $respuesta->response['result'] = $informacionCliente;

            if (count($informacionCliente) == 0) {
                $respuesta->response['mensaje'] = "No se encontró información del Cliente con Id: <" . $idCliente . ">";
            }

            header("Content-Type: application/json");
            echo json_encode($respuesta->response);
        } else {
            $listaClientes = $cliente->listaClientes();
            $respuesta->response['result'] = $listaClientes;
            header("Content-Type: application/json");
            echo json_encode($respuesta->response);
        }
        break;
    
    default:
        header('Content-Type: application/json');
        $datosArray = $respuesta->error_405();
        echo json_encode($datosArray);
        break;
}

?>