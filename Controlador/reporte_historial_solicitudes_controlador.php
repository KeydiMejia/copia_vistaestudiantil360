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
        $this->Cell(330, 10, utf8_decode("DEPARTAMENTO DE INFORMÁTICA ADMINISTRATIVA "), 0, 0, 'C');
        $this->ln(10);
        $this->SetFont('times', 'B', 20);
        $this->Cell(330, 10, utf8_decode("HISTORIAL DE SOLICITUDES"), 0, 0, 'C');
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
        $this->Cell(88, 7, "NOMBRE", 1, 0, 'C');
        $this->Cell(55, 7, utf8_decode("TIPO SOLICITUD"), 1, 0, 'C');
        $this->Cell(65, 7, utf8_decode("# CUENTA"), 1, 0, 'C');
        $this->Cell(35, 7, "ESTADO", 1, 0, 'C');
        $this->Cell(50, 7, "FECHA", 1, 0, 'C');

        $this->ln();

        
    }
    function viewTable()
    {
        global $instancia_conexion;
        $sql="SELECT 'EXAMEN SUFICIENCIA'tipo, s.id_suficiencia,s.id_persona,s.fecha_creacion,
    s.id_estado_suficiencia,e.descripcion,p.nombres,p.apellidos, pe.valor
    FROM tbl_estado_suficiencia e, tbl_examen_suficiencia s, tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
    WHERE pe.id_persona = p.id_persona
    AND p.id_persona = u.id_persona
    AND s.id_persona = p.id_persona
    AND e.id_estado_suficiencia = s.id_estado_suficiencia UNION ALL SELECT 'REACTIVACION CUENTA'tipo, id_reactivacion,r.id_persona,r.fecha_creacion,
    r.id_estado_reactivacion,f.descripcion,pr.nombres,pr.apellidos, per.valor
    FROM tbl_estado_reactivacion f, tbl_reactivacion_cuenta r, tbl_personas pr, tbl_personas_extendidas per, tbl_usuarios ur
    WHERE per.id_persona = pr.id_persona
    AND pr.id_persona = ur.id_persona
    AND r.id_persona = pr.id_persona
    AND f.id_estado_reactivacion = r.id_estado_reactivacion UNION ALL SELECT 'CAMBIO DE CARRERA'tipo, s.Id_cambio,s.id_persona,s.fecha_creacion,
s.documento,aprobado,p.nombres,p.apellidos, pe.valor
FROM  tbl_cambio_carrera s, tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
WHERE pe.id_persona = p.id_persona
AND p.id_persona = u.id_persona
AND s.id_persona = p.id_persona UNION ALL SELECT  'CARTA EGRESADO'tipo, s.Id_carta,s.id_persona,s.Fecha_creacion,s.documento,s.aprobado,
p.nombres,p.apellidos, pe.valor
FROM tbl_carta_egresado s,  tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
WHERE pe.id_persona = p.id_persona
AND p.id_persona = u.id_persona
AND s.id_persona = p.id_persona UNION ALL SELECT 'PRE-EQUIVALENCIAS'tipo, s.id_equivalencia,s.id_persona,s.Fecha_creacion,s.documento,s.aprobado,
p.nombres,p.apellidos, pe.valor
FROM tbl_equivalencias s,  tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
WHERE pe.id_persona = p.id_persona
AND p.id_persona = u.id_persona
AND s.id_persona = p.id_persona UNION ALL SELECT 'CANCELAR CLASES'tipo,s.Id_cancelar_clases,s.id_persona,s.Fecha_creacion,s.documento,
s.cambio,p.nombres,p.apellidos, pe.valor
FROM tbl_cancelar_clases s,  tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
WHERE pe.id_persona = p.id_persona
AND p.id_persona = u.id_persona
AND s.id_persona = p.id_persona UNION ALL SELECT  'EXPEDIENTE DE GRADUACION' tipo, s.id_expediente,s.id_persona,s.fecha_creacion,
 s.id_estado_expediente,e.descripcion,p.nombres,p.apellidos, pe.valor
 FROM tbl_estado_expediente e, tbl_expediente_graduacion s, tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
 WHERE pe.id_persona = p.id_persona
 AND p.id_persona = u.id_persona
 AND s.id_persona = p.id_persona
 AND e.id_estado_expediente = s.id_estado_expediente UNION ALL SELECT 'SERVICIO COMUNITARIO'tipo,s.id_servicio_comunitario,s.id_persona,s.fecha_creacion,
s.id_estado_servicio,e.descripcion,p.nombres,p.apellidos, pe.valor
FROM tbl_estado_servicio e, tbl_servicio_comunitario s, tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
WHERE pe.id_persona = p.id_persona
AND p.id_persona = u.id_persona
AND s.id_persona = p.id_persona
AND e.id_estado_servicio = s.id_estado_servicio";
        $stmt = $instancia_conexion->ejecutarConsulta($sql);

        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);
            $this->Cell(88, 7, $reg['nombres'].$reg['apellidos'], 1, 0, 'C');
            $this->Cell(55, 7, utf8_decode($reg['tipo']), 1, 0, 'C');
            $this->Cell(65, 7, utf8_decode($reg['valor']), 1, 0, 'C');
            $this->Cell(35, 7, $reg['descripcion'], 1, 0, 'C');
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
$pdf->SetTitle('HISTORIAL_CANCELAR_CLASES.PDF');



$pdf->Output();