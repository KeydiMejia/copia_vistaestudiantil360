


<?php
session_start();
require_once('../clases/Conexion.php');
require_once "../Modelos/reporte_docentes_modelo.php";
require_once('../Reporte/pdf/fpdf.php');

$instancia_conexion = new conexion();


class myPDF extends FPDF
{
    function header()
    {
        //h:i:s
        date_default_timezone_set("America/Tegucigalpa");
        $fecha = date('d-m-Y h:i:s');
        //$fecha = date("Y-m-d ");

        $this->Image('../dist/img/logo_ia.jpg', 30, 10, 35);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(330, 10, utf8_decode("UNIVERSIDAD NACIONAL AUTÓNOMA DE HONDURAS"), 0, 0, 'C');
        $this->ln(7);
        $this->Cell(325, 10, utf8_decode("FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES"), 0, 0, 'C');
        $this->ln(7);
        $this->Cell(330, 10, utf8_decode("DEPARTAMENTO DE INFORMÁTICA "), 0, 0, 'C');
        $this->ln(10);
        $this->SetFont('times', 'B', 20);
        $this->Cell(330, 10, utf8_decode("REPORTE SOLICITUD DE EXAMEN SUFICIENCIA"), 0, 0, 'C');
        $this->ln(17);
        $this->SetFont('Arial', '', 12);
        $this->Cell(60, 10, utf8_decode("SOLICITUDES"), 0, 0, 'C');
        $this->Cell(420, 10, "FECHA: " . $fecha, 0, 0, 'C');
        $this->ln();
    }
    function footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 10);
        $this->cell(0, 10, 'Pagina' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function headerTable()
    {
        $this->SetFont('Times', 'B', 12);
        $this->SetLineWidth(0.3);
        $this->Cell(83, 7, "NOMBRE", 1, 0, 'C');
        $this->Cell(65, 7, utf8_decode("CORREO"), 1, 0, 'C');
        $this->Cell(30, 7, "TIPO", 1, 0, 'C');
        $this->Cell(30, 7, "ESTADO", 1, 0, 'C');
        $this->Cell(60, 7, "OBSERVACION", 1, 0, 'C');
        $this->Cell(50, 7, "FECHA", 1, 0, 'C');

        $this->ln();
    }
    function viewTable()
    {   //global $Id_cancelar_clases;
        //$sqlp="select MAX(Id_cancelar_clases) FROM tbl_cancelar_clases";
        //$Id_cancelar_clases= $instancia_conexion->ejecutarConsulta($sqlp);

        global $instancia_conexion;
     

        
        $sql ="SELECT p.nombres, p.apellidos, s.tipo, s.correo, s.observacion, s.id_estado_suficiencia, s.fecha_creacion FROM tbl_examen_suficiencia s, tbl_personas p WHERE s.id_suficiencia=(SELECT MAX(id_suficiencia) FROM tbl_examen_suficiencia) AND p.id_persona=s.id_persona";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);
           
            $this->Cell(83, 7, $reg['nombres'].$reg['apellidos'], 1, 0, 'C');
            $this->Cell(65, 7, utf8_decode($reg['correo']), 1, 0, 'C');
            $this->Cell(30, 7, $reg['tipo'], 1, 0, 'C');
            $this->Cell(30, 7, $reg['id_estado_suficiencia'], 1, 0, 'C');
            $this->Cell(60, 7, $reg['observacion'], 1, 0, 'C');
            $this->Cell(50, 7, $reg['fecha_creacion'], 1, 0, 'C');

            $this->ln();
        }
    }
}


$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('C', 'Legal', 0);
$pdf->headerTable();
$pdf->viewTable();

//$pdf->viewTable2($instancia_conexion);
$pdf->SetFont('Arial', '', 15);


$pdf->Output();
