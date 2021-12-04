<?php
session_start();
require_once('../clases/conexion_mantenimientos.php');
require_once "../Modelos/reporte_docentes_modelo.php";
require_once('../Reporte/pdf/fpdf.php');
$instancia_conexion = new conexion();


//$stmt = $instancia_conexion->query("SELECT tp.nombres FROM tbl_personas tp INNER JOIN tbl_usuarios us ON us.id_persona=tp.id_persona WHERE us.Id_usuario= 8");



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
        $this->Cell(330, 10, utf8_decode("SOLICITUDES CAMBIO DE CARRERA INTERNA"), 0, 0, 'C');
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

    function headerTable()
    {
        $this->SetFont('Times', 'B', 12);
        $this->SetLineWidth(0.3);
        $this->Cell(9, 7, utf8_decode("Nª"), 1, 0, 'C');
        $this->Cell(90, 7, "NOMBRE", 1, 0, 'C');
        $this->Cell(25, 7, utf8_decode("TIPO"), 1, 0, 'C');
        $this->Cell(45, 7, utf8_decode("CORREO"), 1, 0, 'C');
        $this->Cell(80, 7, "OBSERVACION", 1, 0, 'C');
        $this->Cell(25, 7, "ESTADO", 1, 0, 'C');
        $this->Cell(40, 7, "FECHA", 1, 0, 'C');

        $this->ln();
    }
    function viewTable()
    {
        global $instancia_conexion;
        $sql = "SELECT row_number() OVER (ORDER BY nombres) AS NP, p.nombres, p.apellidos, c.correo, c.observacion, 
        c.tipo, c.fecha_creacion, c.aprobado FROM tbl_cambio_carrera c, tbl_personas p 
        WHERE p.id_persona=c.id_persona and c.tipo= 'interno'";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);
            $this->Cell(9, 7, $reg['NP'], 1, 0, 'C');
            $this->Cell(90, 7, $reg['nombres'].$reg['apellidos'], 1, 0, 'C');
            $this->Cell(25, 7, utf8_decode($reg['tipo']), 1, 0, 'C');
            $this->Cell(45, 7, utf8_decode($reg['correo']), 1, 0, 'C');
            $this->Cell(80, 7, $reg['observacion'], 1, 0, 'C');
            $this->Cell(25, 7, $reg['aprobado'], 1, 0, 'C');
            $this->Cell(40, 7, $reg['fecha_creacion'], 1, 0, 'C');

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
$pdf->SetTitle('SOLICITUD_CAMBIO_CARRERA_INTERNO.PDF');


$pdf->Output();