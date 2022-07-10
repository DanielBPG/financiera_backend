<?php
require_once 'clases/respuesta.php';
require_once 'clases/prestamo.php';
require_once './allowaccess.php';

$respuesta = new Respuesta();
$prestamo = new Prestamo();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if(isset($_GET["nombre"])){
            $nombreCliente = $_GET["nombre"];
            $prestamosCliente = $prestamo->obtenerPrestamosCliente($nombreCliente);
            $respuesta->response['result'] = $prestamosCliente;

            if (count($prestamosCliente) == 0) {
                $respuesta->response['mensaje'] = "No se encontraron préstamos del Cliente con nombre: <" . $nombreCliente . ">";
            }

            header("Content-Type: application/json");
            echo json_encode($respuesta->response);
        } else {
            $listaPrestamos = $prestamo->listaPrestamos();
            $respuesta->response['result'] = $listaPrestamos;
            header("Content-Type: application/json");
            echo json_encode($respuesta->response);
        }
        break;

    case 'POST':
        //recibimos los datos enviados en metodo
        $postBody = file_get_contents("php://input");

        //extraer datos
        $json = json_decode($postBody, true);
        $cliente = $json['cliente'];
        $monto = $json['monto'];
        $plazo = $json['plazo'];    

        //enviar datos
        $resultado = $prestamo->agregarPrestamo($cliente, $monto, $plazo);

        header('Content-Type: application/json');

        if ($resultado) {
            $respuesta->response['result'] = $resultado;
        } else {
            $respuesta->response['mensaje'] = "Ocurrió un error al guardar información";
            $respuesta->response['status'] = "error";
        }
        
        echo json_encode($respuesta->response);
        break;
    
    default:
        header('Content-Type: application/json');
        $datosArray = $respuesta->error_405();
        echo json_encode($datosArray);
        break;
}

?>