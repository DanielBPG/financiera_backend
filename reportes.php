<?php
require_once 'clases/respuesta.php';
require_once 'clases/reporteAmortizacion.php';
require_once 'clases/prestamo.php';
require_once (dirname(__FILE__) . '/tcpdf/tcpdf.php');
require_once './allowaccess.php';

$respuesta = new Respuesta();
$prestamoInformacion = new Prestamo();

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $totalPrestamo = 0;
        $totalInteres = 0;
        $totalAbono = 0;  
        $bgColor = "#efefef";              
        //obtener datos del reporte
        $prestamo = $_GET["prestamo"];
        $nombreCliente = $_GET["cliente"];

        $resultado = $prestamoInformacion->obtenerAmortizacion($prestamo);

        if($resultado) {
            // create new PDF document
            $pdf = new ReporteAmortizacion(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            //Asignar datos de header
            $pdf->setCliente($nombreCliente);
            $pdf->setNumeroPago(count($resultado));
            // Información del documento
            $pdf->SetTitle('Tabla de amortización');
            $pdf->SetSubject('Reporte');

            // margenes
            $pdf->SetMargins(15, 15, 15);
            $pdf->SetHeaderMargin(5);
            $pdf->SetFooterMargin(5);

            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetFont('helvetica', 'BI', 12);

            // Agrega pagina
            $pdf->AddPage();

            // imrpime en reporte
            $tabla = <<<EOD
            <style>
                table {
                    border: 2px solid black;
                    text-align: center;
                }
                td {
                    border-right: 2px solid black;
                    border-left: 2px solid black;
                    height: 20px;
                }
                th {
                    border-right: 2px solid black;
                    border-left: 2px solid black; 
                    height: 20px;                      
                }
            </style>

            <table>
                <tr bgcolor="#e5e5e5">
                    <th>No. Pago</th>
                    <th>Fecha</th>
                    <th>Préstamo</th>
                    <th>Interés</th>
                    <th>Abono</th>
                </tr>                                    
            EOD;

            foreach ($resultado as $value) {
                //Calcular totales
                $totalPrestamo += $value['monto'];
                $totalInteres += $value['interes'];
                $totalAbono += $value['abono'];

                //formato de fecha
                $fechaFormato = date("d/m/Y", strtotime($value['fecha']));;

                //establecer formato con decimales
                $montoFormato = number_format($value['monto'], 2);
                $interesFormato = number_format($value['interes'], 2);
                $abonoFormato = number_format($value['abono'], 2);

                $tabla .= <<<EOD
                    <tr bgcolor="{$bgColor}">
                        <td> {$value['numero_pago']} </td>
                        <td> {$fechaFormato} </td>
                        <td> &#36;{$montoFormato} </td>
                        <td> &#36;{$interesFormato} </td>
                        <td> &#36;{$abonoFormato} </td>
                    </tr>                                    
                EOD;

                if ($bgColor == "#efefef") {
                    $bgColor = "#ffffff";
                } else {
                    $bgColor = "#efefef";
                }
                
            }

            //establecer formato con decimales
            $totalPrestamoFormato = number_format($totalPrestamo, 2);
            $totalInteresFormato = number_format($totalInteres, 2);
            $totalAbonoFormato = number_format($totalAbono, 2);
            $tabla .= <<<EOD
                <tr bgcolor="{$bgColor}">
                    <td></td>
                    <td>Totales</td>
                    <td> &#36;{$totalPrestamoFormato} </td>
                    <td> &#36;{$totalInteresFormato} </td>
                    <td> &#36;{$totalAbonoFormato} </td>
                </tr>
            </table>
            EOD;

            $pdf->writeHTML($tabla, true, false, false, false, '');

            //Close and output PDF document
            $pdf->Output('ReporteAmortizacion.pdf', 'I');
        } else {
            $respuesta->response['mensaje'] = "Ocurrió un error al generar reporte";
            $respuesta->response['status'] = "error";
        }
        break;
    
    default:
        header('Content-Type: application/json');
        $datosArray = $respuesta->error_405();
        echo json_encode($datosArray);
        break;
}

?>