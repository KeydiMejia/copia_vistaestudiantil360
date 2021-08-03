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
        $this->Cell(330, 10, utf8_decode("DEPARTAMENTO DE INFORMÁTICA ADMINISTRATIVA"), 0, 0, 'C');
        $this->ln(10);
        $this->SetFont('times', 'B', 20);
        $this->Cell(330, 10, utf8_decode("PERFIL ESTUDIANTIL"), 0, 0, 'C');
        $this->ln(17);
        $this->SetFont('Arial', '', 12);
        $this->Cell(75, 50, utf8_decode(""), 0, 0, 'C');
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
        $idpersona = $_SESSION['id_persona'];
        $sql ="SELECT p.nombres,p.apellidos,p.identidad, p.fecha_nacimiento, pe.valor
        FROM tbl_personas p, tbl_personas_extendidas pe WHERE p.id_persona = $idpersona AND pe.id_persona = $idpersona";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

        $this->SetFont('Arial', 'B', 14);
        $this->Cell(67, 30, utf8_decode("Datos personales:"), 0, 0, 'C');
        $this->ln();

            $this->SetFont('Times', '', 12);

$this->SetXY(21, 80);
$this->Cell(50, 8, 'NOMBRE COMPLETO:', 0, 'L');
$this->Cell(20, 8, $reg['nombres'].$reg['apellidos'], 120, 85.5);
//*****
$this->SetXY(21, 90);
$this->Cell(50, 8, 'IDENTIDAD:', 0, 'L');
$this->Cell(20, 8, utf8_decode($reg['identidad']), 120, 85.5);
//*****
$this->SetXY(21,100);
$this->Cell(50, 8, 'FECHA NACIMIENTO:', 0, 'L');
$this->Cell(20, 8, utf8_decode($reg['fecha_nacimiento']), 120, 85.5);

//*****
$this->SetXY(21, 110);
$this->Cell(50, 8, 'NUMERO DE CUENTA:', 0, 'L');
$this->Cell(20, 8, utf8_decode($reg['valor']), 120, 85.5);

}//WHILE
$sql ="SELECT c.id_tipo_contacto, c.valor FROM tbl_contactos c,  tbl_usuarios u WHERE u.id_persona = $idpersona AND c.id_tipo_contacto = 4 AND C.id_persona = $idpersona";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

$this->SetXY(21, 120);
$this->Cell(50, 8, 'CORREO ELECTRONICO:', 0, 'L');
$this->Cell(20, 8, $reg['valor'], 120, 85.5);
   
            
} //while
        $sql ="SELECT c.id_tipo_contacto, c.valor FROM tbl_contactos c,  tbl_usuarios u WHERE u.id_persona = $idpersona AND c.id_tipo_contacto = 1 AND C.id_persona = $idpersona";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

$this->SetXY(21, 130);
$this->Cell(50, 8, 'TELEFONO CELULAR:', 0, 'L');
$this->Cell(20, 8, $reg['valor'], 120, 85.5);
   
            
 } //while
        
        $sql ="SELECT c.id_tipo_contacto, c.valor FROM tbl_contactos c,  tbl_usuarios u WHERE u.id_persona = $idpersona AND c.id_tipo_contacto = 2 AND C.id_persona = $idpersona";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

$this->SetXY(21, 140);
$this->Cell(50, 8, 'TELEFONO FIJO:', 0, 'L');
$this->Cell(20, 8, $reg['valor'], 120, 85.5);
   
            
} //while
        $sql ="SELECT c.id_tipo_contacto, c.valor FROM tbl_contactos c,  tbl_usuarios u WHERE u.id_persona = $idpersona AND c.id_tipo_contacto = 3 AND C.id_persona = $idpersona";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

$this->SetXY(21, 150);
$this->Cell(50, 8, 'DIRECCION:', 0, 'L');
$this->Cell(20, 8, $reg['valor'], 120, 85.5);

$this->SetXY(10, 170);
$this->SetFont('Arial', 'B', 14);
$this->Cell(50, 8, utf8_decode("Asignaturas:"), 0, 0, 'C');
$this->ln();
            
} //while
        
        $sql ="SELECT COUNT(*) id_persona FROM tbl_asignaturas_aprobadas WHERE id_persona= $idpersona";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg1 = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

$this->SetXY(21, 180);
$this->Cell(50, 8, 'CLASES APROBADAS:', 0, 'L');
$this->Cell(20, 8, $reg1['id_persona'], 120, 85.5);

} //while de aprobadas
//------------------------------------------otra seccion--------------------------------
$this->SetXY(180, 60);
$this->SetFont('Arial', 'B', 14);
$this->Cell(145, 30, utf8_decode("Solicitudes realizadas:"), 0, 0, 'C');
$this->ln();

$sql ="SELECT COUNT(*) id_persona FROM tbl_examen_suficiencia
WHERE id_persona= $idpersona ";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

$this->SetXY(225, 80);
$this->Cell(70, 8, 'EXAMEN DE SUFICIENCIA:', 0, 'L');
$this->Cell(20, 8, $reg['id_persona'], 120, 85.5);

}//while suficiencia

$sql ="SELECT COUNT(*) id_persona FROM tbl_reactivacion_cuenta
WHERE id_persona= $idpersona ";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

$this->SetXY(225, 90);
$this->Cell(70, 8, 'REACTIVACION DE CUENTA:', 0, 'L');
$this->Cell(20, 8, $reg['id_persona'], 120, 85.5);

}//while REACTIVACION

$sql ="SELECT COUNT(*) id_persona FROM tbl_cambio_carrera
WHERE id_persona= $idpersona ";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

$this->SetXY(225, 100);
$this->Cell(70, 8, 'CAMBIO DE CARRERA:', 0, 'L');
$this->Cell(20, 8, $reg['id_persona'], 120, 85.5);

}//while carrera
$sql ="SELECT COUNT(*) id_persona FROM tbl_cancelar_clases
WHERE id_persona= $idpersona ";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

$this->SetXY(225, 110);
$this->Cell(70, 8, 'CANCELACION DE CLASES:', 0, 'L');
$this->Cell(20, 8, $reg['id_persona'], 120, 85.5);

}//while cancelacion
$sql ="SELECT COUNT(*) id_persona FROM tbl_servicio_comunitario
WHERE id_persona= $idpersona ";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

$this->SetXY(225, 120);
$this->Cell(70, 8, 'SERVICIO COMUNITARIO:', 0, 'L');
$this->Cell(20, 8, $reg['id_persona'], 120, 85.5);

}//while servicio
$sql ="SELECT COUNT(*) id_persona FROM tbl_equivalencias
WHERE id_persona= $idpersona ";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

$this->SetXY(225, 130);
$this->Cell(70, 8, 'PRE EQUIVALENCIAS:', 0, 'L');
$this->Cell(20, 8, $reg['id_persona'], 120, 85.5);

}//while pre equivalencias
$sql ="SELECT COUNT(*) id_persona FROM tbl_carta_egresado
WHERE id_persona= $idpersona ";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

$this->SetXY(225, 140);
$this->Cell(70, 8, 'CARTA DE EGRESADO:', 0, 'L');
$this->Cell(20, 8, $reg['id_persona'], 120, 85.5);

}//while egresado
$sql ="SELECT COUNT(*) id_persona FROM tbl_expediente_graduacion
WHERE id_persona= $idpersona ";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

$this->SetXY(225, 150);
$this->Cell(70, 8, 'EXPEDIENTE DE GRADUACION:', 0, 'L');
$this->Cell(20, 8, $reg['id_persona'], 120, 85.5);

}//while carrera




    } // function view()
}


$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('C', 'Legal', 0);

$pdf->view();
// $pdf->viewdos();
$pdf->SetFont('Arial', '', 15);
$pdf->SetTitle('PERFIL_ESTUDIANTIL.PDF');


$pdf->Output();
