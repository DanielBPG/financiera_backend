<?php
require_once (dirname(__FILE__) . '/../tcpdf/tcpdf.php');


// Clase para crear header y footer personalizado
class ReporteAmortizacion extends TCPDF {
    private $cliente;
    private $numeroPago;

    public function setCliente($pCliente) {
        $this->cliente = $pCliente;
    }

    public function setNumeroPago($pNumeroPago) {
        $this->numeroPago = $pNumeroPago;
    }

    public function Header() {
        $this->SetFont('helvetica', 'B', 11);
        // Titulo
        $this->Cell(0, 3, 'Cliente: '. $this->cliente, 0, false, 'L', 0, '', 0, false, 'M', 'M');
        $this->SetY(10);
        $this->Cell(0, 3, 'No. Pago: '. $this->numeroPago, 0, false, 'L', 0, '', 0, false, 'M', 'M');
    }

    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        // Numero de paginas
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}
?>
