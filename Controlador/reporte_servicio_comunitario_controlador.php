<?php
session_start();
require_once('../clases/conexion_mantenimientos.php');
require_once "../Modelos/reporte_docentes_modelo.php";
require_once('../Reporte/pdf/fpdf.php');
$instancia_conexion = new conexion();


//$stmt = $instancia_conexion->query("SELECT tp.nombres FROM tbl_personas tp INNER JOIN tbl_usuarios us ON us.id_persona=tp.id_persona WHERE us.Id_usuario= 8");



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
        $this->Cell(330, 10, utf8_decode("REPORTE SOLICITUD - SERVICIO COMUNITARIO"), 0, 0, 'C');
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
        $this->Cell(70, 7, "ID", 1, 0, 'C');
        $this->Cell(70, 7, utf8_decode("NOMBRE PROYECTO"), 1, 0, 'C');
        $this->Cell(80, 7, "OBSERVACION", 1, 0, 'C');
        $this->Cell(60, 7, "fecha_creacion", 1, 0, 'C');

        $this->ln();
    }
    function viewTable()
    {
        global $instancia_conexion;
        $sql = "select id_servicio_comunitario, nombre_proyecto, observacion,  fecha_creacion 
        FROM tbl_servicio_comunitario";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);
            $this->Cell(70, 7, $reg['id_servicio_comunitario'], 1, 0, 'C');
            $this->Cell(70, 7, utf8_decode($reg['nombre_proyecto']), 1, 0, 'C');
            $this->Cell(80, 7, $reg['observacion'], 1, 0, 'C');
            $this->Cell(60, 7, $reg['fecha_creacion'], 1, 0, 'C');

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