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
        $this->Cell(330, 10, utf8_decode("DEPARTAMENTO DE INFORMÁTICA ADMINITRATIVA"), 0, 0, 'C');
        $this->ln(10);
        $this->SetFont('times', 'B', 20);
        $this->Cell(330, 10, utf8_decode("CLASES APROBADAS"), 0, 0, 'C');
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
        $this->Cell(10, 7, utf8_decode("Nª"), 1, 0, 'C');
        $this->Cell(130, 7, "ASIGNATURA", 1, 0, 'C');
        $this->Cell(65, 7, utf8_decode("CODIGO"), 1, 0, 'C');
        $this->Cell(65, 7, utf8_decode("UV"), 1, 0, 'C');
        

        $this->ln();
    }
    function viewTable()
    {
        global $instancia_conexion;
        $sql = "SELECT row_number() OVER (ORDER BY asignatura) AS NP, a.asignatura, a.codigo, a.uv FROM tbl_asignaturas a, tbl_asignaturas_aprobadas b
        WHERE a.Id_asignatura= b.Id_asignatura AND b.id_persona = 6";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);
            $this->Cell(10, 7, $reg['NP'], 1, 0, 'C');
            $this->Cell(130, 7, utf8_decode($reg['asignatura']), 1, 0, 'C');
            $this->Cell(65, 7, utf8_decode($reg['codigo']), 1, 0, 'C');
            $this->Cell(65, 7, $reg['uv'], 1, 0, 'C');
            

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
$pdf->SetTitle('CLASES_APROBADAS.PDF');


$pdf->Output();