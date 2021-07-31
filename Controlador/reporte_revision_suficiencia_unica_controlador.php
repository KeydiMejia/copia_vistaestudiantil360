

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
        $this->Cell(60, 7, "NOMBRE", 1, 0, 'C');
        $this->Cell(70, 7, utf8_decode("CORREO"), 1, 0, 'C');
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

        //global $instancia_conexion;
        //$sql ="SELECT Id_cancelar_clases, motivo, correo, observacion, cambio, Fecha_creacion FROM tbl_cancelar_clases WHERE Id_cancelar_clases=(SELECT MAX(Id_cancelar_clases) FROM tbl_cancelar_clases)";
        //$stmt = $instancia_conexion->ejecutarConsulta($sql);

        //while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {
            if (isset($_GET['alumno'])){
            $sqltabla = json_decode( file_get_contents("http://localhost/copia_automatizacion/copia_vistaestudiantil360/api/examen_suficiencia.php?alumno=".$_GET['alumno']), true ); 
            }

            $nombre= $sqltabla["ROWS"][0]['nombres'];
            $correo= $sqltabla["ROWS"][0]['correo'];
            $observ= $sqltabla["ROWS"][0]['observacion'];
            $estado= $sqltabla["ROWS"][0]['id_estado_suficiencia'];
            $fecha =$sqltabla["ROWS"][0]['fecha_creacion'];
            $tipo =$sqltabla["ROWS"][0]['tipo'];

            $this->SetFont('Times', '', 12);
            $this->Cell(60, 7, $nombre, 1, 0, 'C');
            $this->Cell(70, 7, $correo, 1, 0, 'C');
            $this->Cell(30, 7, $tipo, 1, 0, 'C');
            $this->Cell(30, 7, $estado, 1, 0, 'C');
            $this->Cell(60, 7, $observ, 1, 0, 'C');
            $this->Cell(50, 7, $fecha, 1, 0, 'C');

            $this->ln();
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
