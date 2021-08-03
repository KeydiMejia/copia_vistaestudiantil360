<?php
session_start();
require_once('../clases/Conexion.php');
require_once "../Modelos/reporte_docentes_modelo.php";
require_once('../Reporte/pdf/fpdf.php');
//require_once('../Controlador/cancelar_clases_controlador.php');
//include("../Controlador/cancelar_clases_controlador.php");
$instancia_conexion = new conexion();


class myPDF extends FPDF
{
    public $titulo;
    public $sub_titulo;
    public $sql;

    public function __construct($titulo='undefine',$sql='undefine') {
        parent::__construct();
        $this->titulo = $titulo;
        
        $this->sql= $sql;
    }
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
        $this->Cell(60, 10, utf8_decode(""), 0, 0, 'C');
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

        global $instancia_conexion;
        $sql ="SELECT p.nombres, p.apellidos, c.Id_cancelar_clases, c.motivo, c.correo, c.observacion, c.cambio, c.Fecha_creacion FROM tbl_cancelar_clases c, tbl_personas p WHERE c.Id_cancelar_clases=(SELECT MAX(Id_cancelar_clases) FROM tbl_cancelar_clases) AND p.id_persona=c.id_persona";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

$this->SetXY(25, 80);
$this->Cell(35, 8, 'SOLICITUD Nº:', 0, 'L');
$this->Cell(20, 8, $reg['Id_cancelar_clases'], 120, 85.5);
//*****
$this->SetXY(25, 90);
$this->Cell(35, 8, 'NOMBRE:', 0, 'L');
$this->Cell(20, 8, $reg['nombres'].$reg['apellidos'], 120, 85.5);
//*****
$this->SetXY(25,100);
$this->Cell(35, 8, 'MOTIVO:', 0, 'L');
$this->Cell(20, 8, utf8_decode($reg['motivo']), 120, 85.5);

//*****
$this->SetXY(25, 110);
$this->Cell(35, 8, 'CORREO:', 0, 'L');
$this->Cell(20, 8, utf8_decode($reg['correo']), 120, 85.5);
//****
$this->SetXY(25, 120);
$this->Cell(35, 8, 'OBSERVACION:', 0, 'L');
$this->Cell(20, 8, $reg['observacion'], 120, 85.5);

$this->SetXY(25, 130);
$this->Cell(35, 8, 'ESTADO:', 0, 'L');
$this->Cell(20, 8,$reg['cambio'], 120, 85.5);

$this->SetXY(25, 140);
$this->Cell(35, 8, 'FECHA:', 0, 'L');
$this->Cell(20, 8, $reg['Fecha_creacion'], 120, 85.5);
           
            
        }
    }
}


$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('C', 'Legal', 0);

$pdf->view();
$pdf->SetFont('Arial', '', 15);
$pdf->SetTitle('SOLICITUD_CANCELAR_CLASES.PDF');


$pdf->Output();
