<?php
session_start();
require_once('../clases/Conexion.php');
require_once "../Modelos/reporte_docentes_modelo.php";
require_once('../Reporte/pdf/fpdf.php');
//require_once('../Controlador/cancelar_clases_controlador.php');
//include("../Controlador/cancelar_clases_controlador.php");
$instancia_conexion = new conexion();


//$sqltabla = json_decode( file_get_contents("http://localhost/copia_automatizacion/copia_vistaestudiantil360/api/cancelar_clases.php?alumno=".$_GET['alumno']), true );


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
        $this->Cell(330, 10, utf8_decode("SOLICITUD DE CANCELACION DE CLASES"), 0, 0, 'C');
        $this->ln(17);
        $this->SetFont('Arial', '', 12);
        $this->Cell(60, 10, utf8_decode(" "), 0, 0, 'C');
        $this->Cell(420, 10, "FECHA: " . $fecha, 0, 0, 'C');
        $this->ln();
    }
    function footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 10);
        $this->cell(0, 10, 'Pagina' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function view()
    {   
            if (isset($_GET['alumno'])){
            $sqltabla = json_decode( file_get_contents("http://localhost/copia_automatizacion/copia_vistaestudiantil360/api/cancelar_clases.php?alumno=".$_GET['alumno']), true ); 
            }

            $nombre= $sqltabla["ROWS"][0]['nombres'];
            $apellid= $sqltabla["ROWS"][0]['apellidos'];
            $motiv= $sqltabla["ROWS"][0]['motivo'];
            //$corr= $sqltabla["ROWS"][0]['correo'];
            $observ= $sqltabla["ROWS"][0]['observacion'];
            $cambi= $sqltabla["ROWS"][0]['cambio'];
            $fechi =$sqltabla["ROWS"][0]['Fecha_creacion'];

$this->SetXY(25,90);
$this->Cell(30, 8, 'NOMBRE:', 0, 'L');
$this->Cell(20, 8, $nombre.$apellid, 120, 85.5);

//*****
$this->SetXY(25, 100);
$this->Cell(30, 8, 'MOTIVO:', 0, 'L');
$this->Cell(20, 8, utf8_decode($motiv), 120, 85.5);
//****
$this->SetXY(25, 110);
$this->Cell(35, 8, 'OBSERVACION:', 0, 'L');
$this->Cell(20, 8, $observ, 120, 85.5);

$this->SetXY(25, 120);
$this->Cell(30, 8, 'ESTADO:', 0, 'L');
$this->Cell(20, 8,$cambi, 120, 85.5);

$this->SetXY(25, 130);
$this->Cell(30, 8, 'FECHA:', 0, 'L');
$this->Cell(20, 8, $fechi, 120, 85.5);

            // $this->SetFont('Times', '', 12);
            // $this->Cell(60, 7, $nombre, 1, 0, 'C');
            // $this->Cell(50, 7, $motiv, 1, 0, 'C');
            // $this->Cell(70, 7, $corr, 1, 0, 'C');
            // $this->Cell(60, 7, $observ, 1, 0, 'C');
            // $this->Cell(30, 7, $cambi, 1, 0, 'C');
            // $this->Cell(50, 7, $fechi, 1, 0, 'C');

            // $this->ln();
        }
    }



$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('C', 'Legal', 0);
//$pdf->headerTable();
$pdf->view();

//$pdf->viewTable2($instancia_conexion);
$pdf->SetFont('Arial', '', 15);


$pdf->Output();
