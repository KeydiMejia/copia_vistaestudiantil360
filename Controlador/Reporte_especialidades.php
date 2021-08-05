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
        $this->Cell(330, 10, utf8_decode("SOLICITUD DE ". $this->titulo), 0, 0, 'C');
        $this->ln(17);
        $this->SetFont('Arial', '', 12);
        
        $this->Cell(420, 10, "FECHA: " . $fecha, 0, 2, 'C');
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
        $this->Cell(10, 7, utf8_decode("N°"), 1, 0, 'C');
        $this->Cell(50, 7, utf8_decode("NOMBRE"), 1, 0, 'C');
        $this->Cell(50, 7, utf8_decode("APELLIDOS"), 1, 0, 'C');
        $this->Cell(40, 7, utf8_decode("#CUENTA"), 1, 0, 'C');
        $this->Cell(70, 7, utf8_decode("CORREO"), 1, 0, 'C');
        $this->Cell(50, 7, utf8_decode("TIPO"), 1, 0, 'C');
        $this->Cell(50, 7, utf8_decode("ESTADO"), 1, 0, 'C');
        $this->ln();
    }

    function headerExpediente()
    {
        $this->SetFont('Times', 'B', 12);
        $this->SetLineWidth(0.3);
        $this->Cell(10, 7, utf8_decode("N°"), 1, 0, 'C');
        $this->Cell(50, 7, utf8_decode("NOMBRE"), 1, 0, 'C');
        $this->Cell(50, 7, utf8_decode("APELLIDOS"), 1, 0, 'C');
        $this->Cell(40, 7, utf8_decode("#CUENTA"), 1, 0, 'C');
        $this->Cell(50, 7, utf8_decode("IDENTIDAD"), 1, 0, 'C');
        $this->Cell(50, 7, utf8_decode("FECHA"), 1, 0, 'C');
        $this->Cell(50, 7, utf8_decode("ESTADO"), 1, 0, 'C');
        $this->ln();
    }

    function header_Servicio_Comunitario()
    {
        $this->ln();
        $this->SetFont('Times', 'B', 12);
        $this->SetLineWidth(0.1);
        $this->Cell(10, 7, utf8_decode("N°"), 1, 0, 'C');
        $this->Cell(50, 7, utf8_decode("NOMBRE"), 1, 0, 'C');
        $this->Cell(50, 7, utf8_decode("APELLIDOS"), 1, 0, 'C');
        $this->Cell(40, 7, utf8_decode("#CUENTA"), 1, 0, 'C');
        $this->Cell(70, 7, utf8_decode("CORREO"), 1, 0, 'C');
        $this->Cell(50, 7, utf8_decode("PROYECTO"), 1, 0, 'C');
        $this->Cell(50, 7, utf8_decode("OBSERVACION"), 1, 0, 'C');
        $this->ln();
    }


    function viewTable()
    {
        
        
        global $instancia_conexion;
       
        $stmt = $instancia_conexion->ejecutarConsulta($this->sql);

     

        $n=1;
        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);
            $this->Cell(10, 7, utf8_decode($n), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['nombres']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['apellidos']), 1, 0, 'C');
            $this->Cell(40, 7, utf8_decode($reg['cuenta']), 1, 0, 'C');
            $this->Cell(70, 7, utf8_decode($reg['correo']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['tipo']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['aprobado']), 1, 0, 'C');

            $this->ln();
            $n++;
        }
    }

    function viewTable_equivalencia_V()
    {
        
        
        global $instancia_conexion;
       
        $stmt = $instancia_conexion->ejecutarConsulta($this->sql);

     

        $n=1;
        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

            
            $this->Cell(50, 10, utf8_decode("SOLICITUD N°"), 0, 0, 'L');
            
            $this->Cell(0, 10, utf8_decode($reg['Id_equivalencia']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("NOMBRES"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['nombres']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("APELLIDOS"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['apellidos']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("#CUENTA"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['cuenta']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("CORREO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['correo']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("TIPO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['tipo']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("ESTADO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['aprobado']), 0, 2, 'L');
            $this->ln();

            $n++;
        }
    }
    /**** */
    function viewTable_suficiencia_V()
    {
        
        
        global $instancia_conexion;
       
        $stmt = $instancia_conexion->ejecutarConsulta($this->sql);

     

        $n=1;
        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

            
            $this->Cell(50, 10, utf8_decode("SOLICITUD N°"), 0, 0, 'L');
            
            $this->Cell(0, 10, utf8_decode($reg['id_suficiencia']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("NOMBRES"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['nombres']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("APELLIDOS"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['apellidos']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("#CUENTA"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['valor']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("CORREO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['correo']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("TIPO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['tipo']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("OBSERVACION"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['observacion']), 0, 2, 'L');
            $this->ln();

            $this->Cell(50, 10, utf8_decode("ESTADO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['descripcion']), 0, 2, 'L');
            $this->ln();

            $n++;
        }
    }

    function viewTable_reactivacion_V()
    {
        
        
        global $instancia_conexion;
       
        $stmt = $instancia_conexion->ejecutarConsulta($this->sql);

     

        $n=1;
        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

            
            $this->Cell(50, 10, utf8_decode("SOLICITUD N°"), 0, 0, 'L');
            
            $this->Cell(0, 10, utf8_decode($reg['id_reactivacion']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("NOMBRES"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['nombres']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("APELLIDOS"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['apellidos']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("#CUENTA"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['valor']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("CORREO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['correo']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("OBSERVACION"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['observacion']), 0, 2, 'L');
            $this->ln();

            $this->Cell(50, 10, utf8_decode("ESTADO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['descripcion']), 0, 2, 'L');
            $this->ln();

            $n++;
        }
    }

    function viewTable_cambio_carrera_V()
    {
        
        
        global $instancia_conexion;
       
        $stmt = $instancia_conexion->ejecutarConsulta($this->sql);

     

        $n=1;
        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

            
            $this->Cell(50, 10, utf8_decode("SOLICITUD N°"), 0, 0, 'L');
            
            $this->Cell(0, 10, utf8_decode($reg['Id_cambio']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("NOMBRES"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['nombres']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("APELLIDOS"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['apellidos']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("#CUENTA"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['valor']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("CORREO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['correo']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("TIPO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['tipo']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("FACULTAD"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['nombre']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("CENTRO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['centro_regional']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("OBSERVACION"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['observacion']), 0, 2, 'L');
            $this->ln();

            $this->Cell(50, 10, utf8_decode("ESTADO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['aprobado']), 0, 2, 'L');
            $this->ln();

            $n++;
        }
    }
    function  viewTable_cambio_carrera_H()
    { 
        global $instancia_conexion;
       
        $stmt = $instancia_conexion->ejecutarConsulta($this->sql);

        $n=1;
        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

            
            $this->Cell(50, 10, utf8_decode("SOLICITUD N°"), 0, 0, 'L');
            
            $this->Cell(0, 10, utf8_decode($reg['Id_cambio']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("NOMBRES"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['nombres']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("APELLIDOS"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['apellidos']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("#CUENTA"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['valor']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("CORREO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['correo']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("TIPO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['tipo']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("OBSERVACION"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['observacion']), 0, 2, 'L');
            $this->ln();

            $this->Cell(50, 10, utf8_decode("ESTADO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['aprobado']), 0, 2, 'L');
            $this->ln();

            $n++;
        }
    }
    /**** */

    function viewTable2()
    {
        
        
        global $instancia_conexion;
       
        $stmt = $instancia_conexion->ejecutarConsulta($this->sql);

     

        $n=1;
        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);
            $this->Cell(10, 7, utf8_decode($n), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['nombres']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['apellidos']), 1, 0, 'C');
            $this->Cell(40, 7, utf8_decode($reg['cuenta']), 1, 0, 'C');
            $this->Cell(70, 7, utf8_decode($reg['correo']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['tipo']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['aprobado']), 1, 0, 'C');

            $this->ln();
            $n++;
        }
    }

    function viewTable_egresados()
    {
        
        
        global $instancia_conexion;
       
        $stmt = $instancia_conexion->ejecutarConsulta($this->sql);

     

        $n=1;
        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);
            $this->Cell(10, 7, utf8_decode($n), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['nombres']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['apellidos']), 1, 0, 'C');
             $this->Cell(40, 7, utf8_decode($reg['valor']), 1, 0, 'C');
            $this->Cell(70, 7, utf8_decode($reg['correo']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode('N/A'), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['aprobado']), 1, 0, 'C');

            $this->ln();
            $n++;
        }
    }

    function viewTable_egresados_V()
    {
        
        
        global $instancia_conexion;
       
        $stmt = $instancia_conexion->ejecutarConsulta($this->sql);

     

        $n=1;
        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

            
            $this->Cell(50, 10, utf8_decode("SOLICITUD N°"), 0, 0, 'L');
            
            $this->Cell(0, 10, utf8_decode($reg['Id_carta']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("NOMBRES"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['nombres']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("APELLIDOS"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['apellidos']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("#CUENTA"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['valor']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("CORREO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['correo']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("FECHA"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['Fecha_creacion']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("ESTADO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['aprobado']), 0, 2, 'L');
            $this->ln();

            $n++;
        }
    }

    function viewTable_egresados2()
    {
        
        
        global $instancia_conexion;
       
        $stmt = $instancia_conexion->ejecutarConsulta($this->sql);

     

        $n=1;
        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);
            $this->Cell(10, 7, utf8_decode($n), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['nombres']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['apellidos']), 1, 0, 'C');
             $this->Cell(40, 7, utf8_decode($reg['valor']), 1, 0, 'C');
            $this->Cell(70, 7, utf8_decode($reg['correo']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode('N/A'), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['aprobado']), 1, 0, 'C');

            $this->ln();
            $n++;
        }
    }

    function viewTable_expediente()
    {
        global $instancia_conexion;
       
        $stmt = $instancia_conexion->ejecutarConsulta($this->sql);

        $n=1;
        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);
            $this->Cell(10, 7, utf8_decode($n), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['nombres']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['apellidos']), 1, 0, 'C');
             $this->Cell(40, 7, utf8_decode($reg['valor']), 1, 0, 'C');
             $this->Cell(50, 7, utf8_decode($reg['identidad']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode('N/A'), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['observacion']), 1, 0, 'C');

            $this->ln();
            $n++;
        }
    }

    function viewTable_expediente_V()
    {
        
        
        global $instancia_conexion;
       
        $stmt = $instancia_conexion->ejecutarConsulta($this->sql);

     

        $n=1;
        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

            
            $this->Cell(50, 10, utf8_decode("SOLICITUD N°"), 0, 0, 'L');
            
            $this->Cell(0, 10, utf8_decode($reg['id_expediente']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("NOMBRES"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['nombres']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("APELLIDOS"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['apellidos']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("#CUENTA"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['valor']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("IDENTIDAD"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['identidad']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("FECHA"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['fecha_creacion']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("ESTADO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['observacion']), 0, 2, 'L');
            $this->ln();

            $n++;
        }
    }

    function viewTable_expediente2()
    {
        
        
        global $instancia_conexion;
       
        $stmt = $instancia_conexion->ejecutarConsulta($this->sql);

     

        $n=1;
        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);
            $this->Cell(10, 7, utf8_decode($n), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['nombres']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['apellidos']), 1, 0, 'C');
             $this->Cell(40, 7, utf8_decode($reg['valor']), 1, 0, 'C');
             $this->Cell(50, 7, utf8_decode($reg['identidad']), 1, 0, 'C'); 
            $this->Cell(50, 7, utf8_decode($reg['fecha_creacion']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['observacion']), 1, 0, 'C');

            $this->ln();
            $n++;
        }
    }

    function viewTable_Servicio_Comunitario_H()
    {
        
        
        global $instancia_conexion;
       
        $stmt = $instancia_conexion->ejecutarConsulta($this->sql);

     

        $n=1;
        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);
            $this->Cell(10, 7, utf8_decode($n), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['nombres']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['apellidos']), 1, 0, 'C');
             $this->Cell(40, 7, utf8_decode($reg['valor']), 1, 0, 'C');
             $this->Cell(70, 7, utf8_decode($reg['correo']), 1, 0, 'C'); 
            $this->Cell(50, 7, utf8_decode($reg['nombre_proyecto']), 1, 0, 'C');
            $this->Cell(50, 7, utf8_decode($reg['observacion']), 1, 0, 'C');

            $this->ln();
            $n++;
        }
    }

    function viewTable_Servicio_Comunitario_V()
    {
        
        
        global $instancia_conexion;
       
        $stmt = $instancia_conexion->ejecutarConsulta($this->sql);

     

        $n=1;
        while ($reg = $stmt->fetch_array(MYSQLI_ASSOC)) {

            $this->SetFont('Times', '', 12);

            
            $this->Cell(50, 10, utf8_decode("SOLICITUD N°"), 0, 0, 'L');
            
            $this->Cell(0, 10, utf8_decode($reg['id_servicio_comunitario']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("NOMBRES"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['nombres']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("APELLIDOS"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['apellidos']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("#CUENTA"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['valor']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("CORREO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['correo']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("PROYECTO"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['nombre_proyecto']), 0, 2, 'L');
            $this->ln(2);

            $this->Cell(50, 10, utf8_decode("OBSERVACION"), 0, 0, 'L');
            $this->Cell(0, 10, utf8_decode($reg['observacion']), 0, 2, 'L');
            $this->ln();

            $n++;
        }
    }
}

// REPORTE DE EQUIVALENCIAS
if (isset($_GET['ruby'])) {
    

    if ($_GET['ruby']!=="") {
        # code...
        // decodificamos la variable pasada por get.
        $buscar= base64_decode($_GET['ruby']);
        
        //confeccion de la consulta para filtrar los datos 
       $sql= "SELECT nombres,apellidos,valor as cuenta, correo,aprobado,
                tbl_equivalencias.Id_equivalencia,tipo,Fecha_creacion
                FROM tbl_equivalencias INNER JOIN tbl_personas 
                ON tbl_equivalencias.id_persona= tbl_personas.id_persona
                INNER JOIN tbl_personas_extendidas ON tbl_personas.id_persona= tbl_personas_extendidas.id_persona
             WHERE
                nombres LIKE '%".$buscar."%' OR
                apellidos LIKE '%".$buscar."%' OR
                valor LIKE '%".$buscar."%' OR
                correo LIKE '%".$buscar."%' OR
                aprobado LIKE '%".$buscar."%' OR
                tipo LIKE '%".$buscar."%' OR
                tbl_equivalencias.id_persona LIKE '%".$buscar."%' OR
                tbl_personas_extendidas.id_persona LIKE '%".$buscar."%' OR
                tbl_personas.id_persona LIKE '%".$buscar."%'";
        //instacia de la clase 
        $pdf = new myPDF("EQUIVALENCIAS",$sql);
        //llamamos los metodos correspondientes
        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
        $pdf->headerTable();
        $pdf->viewTable2();
        $pdf->SetTitle('SOLICITUD_EQUIVALENCIA.PDF');
        $pdf->SetFont('Arial', '', 15);
        $pdf->Output();
    
        return false;
    }else{
        $sql = "SELECT nombres,apellidos,valor as cuenta, correo,aprobado, tbl_equivalencias.Id_equivalencia,tipo,Fecha_creacion FROM tbl_equivalencias INNER JOIN tbl_personas ON tbl_equivalencias.id_persona= tbl_personas.id_persona INNER JOIN tbl_personas_extendidas ON tbl_personas.id_persona= tbl_personas_extendidas.id_persona"; 
        $pdf = new myPDF("EQUIVALENCIAS GENERAL",$sql);
        
        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
        $pdf->headerTable();
        $pdf->viewTable();
        $pdf->SetTitle('SOLICITUD_EQUIVALENCIA.PDF');
        $pdf->SetFont('Arial', '', 15);
        $pdf->Output();
    
        return false;
    }
}

/*************REPORTES DE LESS *************** */
//REPORTE EXPEDIENTE GRADUACION
if (isset($_GET['scala'])) {
    if ($_GET['scala']!=='') {
        
        // decodificamos la variable pasada por get.
        $buscar= base64_decode($_GET['scala']);
        
        //confeccion de la consulta para filtrar los datos 
       $sql= "SELECT valor, nombres, apellidos,observacion,fecha_creacion, tbl_expediente_graduacion.id_expediente, 
       tbl_personas.id_persona,tbl_expediente_graduacion.id_estado_expediente,tbl_expediente_graduacion.fecha_creacion,tbl_personas.identidad
       FROM tbl_expediente_graduacion INNER JOIN tbl_personas ON tbl_expediente_graduacion.id_persona=tbl_personas.id_persona
       INNER JOIN tbl_personas_extendidas ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona
             WHERE
                nombres LIKE '%".$buscar."%' OR
                apellidos LIKE '%".$buscar."%' OR
                valor LIKE '%".$buscar."%' OR
                
                observacion LIKE '%".$buscar."%' OR
                fecha_creacion LIKE '%".$buscar."%' OR
                identidad LIKE '%".$buscar."%' OR
                tbl_expediente_graduacion.id_estado_expediente LIKE '%".$buscar."%'";
        //instacia de la clase 
        $pdf = new myPDF("EXPEDIENTE DE GRADUACION",$sql);
        //llamamos los metodos correspondientes
        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
        $pdf->headerExpediente();
        $pdf->viewTable_expediente2();
        $pdf->SetFont('Arial', '', 15);
        $pdf->SetTitle('SOLICITUD_EXPEDIENTE_DE_GRADUACION.PDF');
        $pdf->Output();
    
        return false;
    }else{
        $sql="SELECT valor, nombres, apellidos,observacion, tbl_expediente_graduacion.id_expediente, 
        tbl_personas.id_persona,tbl_expediente_graduacion.id_estado_expediente,tbl_expediente_graduacion.fecha_creacion,tbl_personas.identidad
        FROM tbl_expediente_graduacion INNER JOIN tbl_personas ON tbl_expediente_graduacion.id_persona=tbl_personas.id_persona
        INNER JOIN tbl_personas_extendidas ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona";
    
        $pdf = new myPDF("EXPEDIENTE DE GRADUACION",$sql);
        
        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
        $pdf->headerExpediente();
        $pdf->viewTable_expediente2();
        $pdf->SetFont('Arial', '', 15);
        $pdf->SetTitle('SOLICITUD_EXPEDIENTE_DE_GRADUACION.PDF');
        $pdf->Output();
    
        return false;
    }
}
//REPORTE DE CARTA DE EGRESADO
if (isset($_GET['perl'])) {
    if ($_GET['perl']!=='') {
        
        // decodificamos la variable pasada por get.
        $buscar= base64_decode($_GET['perl']);
        
        //confeccion de la consulta para filtrar los datos 
       $sql= "SELECT nombres, apellidos, correo,tbl_personas.id_persona, 
                observacion, aprobado, documento, Fecha_creacion,Id_carta,valor,Fecha_creacion
                 FROM tbl_personas INNER JOIN tbl_carta_egresado 
                 ON tbl_personas.id_persona = tbl_carta_egresado.id_persona
                 INNER JOIN tbl_personas_extendidas 
                 ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona
             WHERE
                nombres LIKE '%".$buscar."%' OR
                apellidos LIKE '%".$buscar."%' OR
                valor LIKE '%".$buscar."%' OR
                correo LIKE '%".$buscar."%' OR
                aprobado LIKE '%".$buscar."%' OR
                Fecha_creacion LIKE '%".$buscar."%' OR
                tbl_personas_extendidas.id_persona LIKE '%".$buscar."%' OR
                tbl_personas.id_persona LIKE '%".$buscar."%'";
        //instacia de la clase 
        $pdf = new myPDF("CARTA DE EGRESADOS",$sql);
        //llamamos los metodos correspondientes
        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
        $pdf->headerTable();
        $pdf->viewTable_egresados2();
        $pdf->SetFont('Arial', '', 15);
        $pdf->SetTitle('SOLICITUD_CARTA_DE_EGRESADO.PDF');
        $pdf->Output();
    
        return false;
    }else{
        $sql="SELECT nombres, apellidos, correo,tbl_personas.id_persona,
             observacion, aprobado, documento, Fecha_creacion,Id_carta,valor
              FROM tbl_personas INNER JOIN tbl_carta_egresado 
              ON tbl_personas.id_persona = tbl_carta_egresado.id_persona 
              INNER JOIN tbl_personas_extendidas 
              ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona";
    
        $pdf = new myPDF("CARTA DE EGRESADOS GENERAL",$sql);
        
        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
        $pdf->headerTable();
        $pdf->viewTable_egresados();
        $pdf->SetFont('Arial', '', 15);
        $pdf->SetTitle('SOLICITUD_CARTA_DE_EGRESADO.PDF');
        $pdf->Output();
    
        return false;
    }
}

//REPORTE DE LA SOLICITUD FILTRADO POR ID
if (isset($_GET['id_expediente'])) {
    if ($_GET['id_expediente']!=='') {
        
        // decodificamos la variable pasada por get.
        $buscar= base64_decode($_GET['id_expediente']);
        
        //confeccion de la consulta para filtrar los datos 
       $sql= "SELECT valor, nombres, apellidos,observacion, tbl_expediente_graduacion.id_expediente, 
       tbl_personas.id_persona,tbl_expediente_graduacion.id_estado_expediente,tbl_expediente_graduacion.fecha_creacion,tbl_personas.identidad
       FROM tbl_expediente_graduacion INNER JOIN tbl_personas ON tbl_expediente_graduacion.id_persona=tbl_personas.id_persona
       INNER JOIN tbl_personas_extendidas ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona
       WHERE tbl_expediente_graduacion.id_expediente='$buscar'";
        //instacia de la clase 
        $pdf = new myPDF("EXPEDIENTE DE GRADUACION",$sql);
        //llamamos los metodos correspondientes
        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
        
        $pdf->viewTable_expediente_V();
        $pdf->SetFont('Arial', '', 15);
        $pdf->SetTitle('SOLICITUD_EXPEDIENTE_DE_GRADUACION.PDF');
        $pdf->Output();
    
        return false;
    }
}

if (isset($_GET['id_carta'])) {
    if ($_GET['id_carta']!=='') {
        
        // decodificamos la variable pasada por get.
        $buscar= base64_decode($_GET['id_carta']);
        
        //confeccion de la consulta para filtrar los datos 
       $sql= "SELECT nombres, apellidos, correo,tbl_personas.id_persona,
       observacion, aprobado, documento, Fecha_creacion,Id_carta,valor
        FROM tbl_personas INNER JOIN tbl_carta_egresado 
        ON tbl_personas.id_persona = tbl_carta_egresado.id_persona 
        INNER JOIN tbl_personas_extendidas 
        ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona
       WHERE tbl_carta_egresado.Id_carta='$buscar'";
        //instacia de la clase 
        $pdf = new myPDF("CARTA DE EGRESADOS",$sql);
        //llamamos los metodos correspondientes
        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
        
        $pdf->viewTable_egresados_v();
        $pdf->SetFont('Arial', '', 15);
        $pdf->SetTitle('SOLICITUD_CARTA_DE_EGRESADO.PDF');
        $pdf->Output();
    
    
        return false;
    }
}

if (isset($_GET['id_equivalencia'])) {
    if ($_GET['id_equivalencia']!=='') {
        
        // decodificamos la variable pasada por get.
        $buscar= base64_decode($_GET['id_equivalencia']);
        
        //confeccion de la consulta para filtrar los datos 
        $sql = "SELECT nombres,apellidos,valor as cuenta, correo,aprobado,
                tbl_equivalencias.Id_equivalencia,tipo,Fecha_creacion FROM 
                tbl_equivalencias INNER JOIN tbl_personas 
                ON tbl_equivalencias.id_persona= tbl_personas.id_persona 
                INNER JOIN tbl_personas_extendidas 
                ON tbl_personas.id_persona= tbl_personas_extendidas.id_persona
                WHERE tbl_equivalencias.Id_equivalencia='$buscar'"; 
        $pdf = new myPDF("EQUIVALENCIAS",$sql);
        
        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
        // $pdf->headerTable();
        $pdf->SetTitle('SOLICITUD_EQUIVALENCIA.PDF');
        $pdf->viewTable_equivalencia_V();
        $pdf->SetFont('Arial', '', 15);
        $pdf->Output();
    
    
        return false;
    }
}
/***** REPORTE RUDY*/
if (isset($_GET['id_suficiencia'])) {
    if ($_GET['id_suficiencia']!=='') {
        
        // decodificamos la variable pasada por get.
        $buscar= base64_decode($_GET['id_suficiencia']);
        
        //confeccion de la consulta para filtrar los datos 
        $sql="SELECT valor, nombres, apellidos, correo, tipo, observacion, tbl_examen_suficiencia.id_suficiencia, 
        tbl_personas.id_persona, tbl_estado_suficiencia.descripcion FROM tbl_examen_suficiencia INNER JOIN tbl_personas 
        ON tbl_examen_suficiencia.id_persona=tbl_personas.id_persona INNER JOIN tbl_personas_extendidas 
        ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona INNER JOIN tbl_estado_suficiencia 
        ON tbl_examen_suficiencia.id_estado_suficiencia=tbl_estado_suficiencia.id_estado_suficiencia 
        WHERE tbl_examen_suficiencia.id_suficiencia='$buscar'";
        $pdf = new myPDF("SUFICIENCIA",$sql);
        
        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
        // $pdf->header_suficiencia();
        $pdf->SetTitle('SOLICITUD_SUFICIENCIA.PDF');
        $pdf->viewTable_suficiencia_V();
        $pdf->SetFont('Arial', '', 15);
        $pdf->Output();
    
    
        return false;
    }
}

if (isset($_GET['id_reactivacion'])) {
    if ($_GET['id_reactivacion']!=='') {
        
        // decodificamos la variable pasada por get.
        $buscar= base64_decode($_GET['id_reactivacion']);
        
        //confeccion de la consulta para filtrar los datos 
        $sql="SELECT valor, nombres, apellidos, correo, observacion,fecha_creacion, 
        tbl_reactivacion_cuenta.id_reactivacion, tbl_estado_reactivacion.descripcion,
         tbl_personas.id_persona FROM tbl_reactivacion_cuenta INNER JOIN tbl_personas 
         ON tbl_reactivacion_cuenta.id_persona=tbl_personas.id_persona INNER JOIN tbl_personas_extendidas 
         ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona INNER JOIN tbl_estado_reactivacion 
         ON tbl_reactivacion_cuenta.id_estado_reactivacion=tbl_estado_reactivacion.id_estado_reactivacion 
         WHERE tbl_reactivacion_cuenta.id_reactivacion='$buscar'";
        $pdf = new myPDF("REACTIVACION CUENTA",$sql);
        
        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
       // $pdf->header_reactivacion();
        $pdf->SetTitle('SOLICITUD_REACTIVACION_CUENTA.PDF');
        $pdf->viewTable_reactivacion_V();
        $pdf->SetFont('Arial', '', 15);
        $pdf->Output();
    
    
        return false;
    }
}

if (isset($_GET['Id_cambio'])) {
    if ($_GET['Id_cambio']!=='') {
        
        // decodificamos la variable pasada por get.
        $buscar= base64_decode($_GET['Id_cambio']);
        
        //confeccion de la consulta para filtrar los datos 
        
        $sql="SELECT tbl_personas_extendidas.valor, tbl_personas.nombres, tbl_personas.apellidos, 
        tbl_cambio_carrera.correo, tbl_cambio_carrera.tipo, tbl_cambio_carrera.aprobado,observacion,
         tbl_cambio_carrera.Id_cambio, tbl_personas.id_persona FROM tbl_cambio_carrera 
         INNER JOIN tbl_personas ON tbl_cambio_carrera.id_persona=tbl_personas.id_persona 
         INNER JOIN tbl_personas_extendidas ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona 
         WHERE tbl_cambio_carrera.Id_cambio='$buscar'and tbl_cambio_carrera.tipo ='simultanea'";
        $pdf = new myPDF("CAMBIO CARRERA SIMULTANEA",$sql);

        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
       // $pdf->header_cambio();
        $pdf->SetTitle('SOLICITUD_CAMBIO_CARRERA.PDF');
        $pdf->viewTable_cambio_carrera_H();
        $pdf->SetFont('Arial', '', 15);
        $pdf->Output();
    
       // return false;
    } 

   else{
        $sql="SELECT tbl_personas_extendidas.valor, tbl_personas.nombres, tbl_facultades.nombre, tbl_personas.apellidos, tbl_centros_regionales.centro_regional, tbl_cambio_carrera.correo, tbl_cambio_carrera.tipo, tbl_cambio_carrera.aprobado, 
        tbl_cambio_carrera.razon_cambio,observacion, tbl_cambio_carrera.Id_cambio, tbl_personas.id_persona, 
        tbl_facultades.Id_facultad, tbl_centros_regionales.Id_centro_regional FROM tbl_cambio_carrera 
        INNER JOIN tbl_personas ON tbl_cambio_carrera.id_persona=tbl_personas.id_persona 
        INNER JOIN tbl_personas_extendidas ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona 
        INNER JOIN tbl_facultades ON tbl_cambio_carrera.Id_facultad=tbl_facultades.Id_facultad 
        INNER JOIN tbl_centros_regionales ON tbl_cambio_carrera.Id_centro_regional = tbl_centros_regionales.Id_centro_regional
         WHERE tbl_cambio_carrera.Id_cambio='$buscar'";
        $pdf = new myPDF("CAMBIO CARRERA INTERNA",$sql);
        
        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
       // $pdf->header_cambio);
        $pdf->SetTitle('SOLICITUD_CAMBIO_CARRERA.PDF');
        $pdf->viewTable_cambio_carrera_V();
        $pdf->SetFont('Arial', '', 15);
        $pdf->Output();
    
        return false;
    }

}


/***********FIN REPORTES RUDY */

/**** FIN DE REPORTES DE LESS *************** */


/*-----------REPORTES DE SUANY------- */
//Reporte cuando se cre una solicitud de servivicio comunitario
//ESTA FUNCION TAMBIEN GENERA EL REPORTE 
if (isset($_GET['servicio'])) {
    if ($_GET['servicio']!=='') {
        
        // decodificamos la variable pasada por get.
        $buscar= base64_decode($_GET['servicio']);
        
        //confeccion de la consulta para filtrar los datos 
       $sql= "SELECT nombres, apellidos, correo, observacion,nombre_proyecto,valor,
       tbl_servicio_comunitario.id_servicio_comunitario FROM tbl_servicio_comunitario 
       INNER JOIN tbl_personas ON tbl_servicio_comunitario.id_persona=tbl_personas.id_persona
       INNER JOIN tbl_personas_extendidas ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona
       WHERE tbl_servicio_comunitario.id_servicio_comunitario=$buscar";
        //instacia de la clase 
        $pdf = new myPDF("SERVICIO COMUNITARIO",$sql);
        //llamamos los metodos correspondientes
        $pdf->AliasNbPages();
        $pdf->AddPage('P', 'A3',0);
        // $pdf->header_Servicio_Comunitario();
        $pdf->viewTable_Servicio_Comunitario_V();
        $pdf->SetFont('Arial', '', 15);
        $pdf->SetTitle('SOLICITUD_SERVICIO_COMUNITARIO.PDF');
        $pdf->Output();
    
        return false;
    }
}

//reporte de la solicitud de servicio comunitario espesifico
if (isset($_GET['alumno'])) {
    if ($_GET['alumno']!=='') {
        
        // decodificamos la variable pasada por get.
        $buscar= base64_decode($_GET['alumno']);
        
        //confeccion de la consulta para filtrar los datos 
       $sql= "SELECT nombres, apellidos, correo, observacion,nombre_proyecto,valor FROM tbl_servicio_comunitario 
       INNER JOIN tbl_personas ON tbl_servicio_comunitario.id_persona=tbl_personas.id_persona
       INNER JOIN tbl_personas_extendidas ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona
       WHERE tbl_servicio_comunitario.id_servicio_comunitario='$buscar'";
        //instacia de la clase 
        $pdf = new myPDF("SERVICIO COMUNITARIO",$sql);
        //llamamos los metodos correspondientes
        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
        $pdf->header_Servicio_Comunitario();
        $pdf->viewTable_Servicio_Comunitario_V();
        $pdf->SetFont('Arial', '', 15);
        $pdf->Output();
    
        return false;
    }
}
//reporte de la solicitud de servicio comunitario en general
if (isset($_GET['php'])) {
    if ($_GET['php']!=='') {
        
        // decodificamos la variable pasada por get.
        $buscar= base64_decode($_GET['php']);
        
        //confeccion de la consulta para filtrar los datos 
       $sql= "SELECT nombres, apellidos, correo, observacion,nombre_proyecto,valor,tbl_personas.id_persona FROM tbl_servicio_comunitario 
       INNER JOIN tbl_personas ON tbl_servicio_comunitario.id_persona=tbl_personas.id_persona
       INNER JOIN tbl_personas_extendidas ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona
       
             WHERE
                nombres LIKE '%".$buscar."%' OR
                apellidos LIKE '%".$buscar."%' OR
                valor LIKE '%".$buscar."%' OR
                correo LIKE '%".$buscar."%' OR
                nombre_proyecto LIKE '%".$buscar."%' OR
                observacion LIKE '%".$buscar."%' OR
                tbl_personas.id_persona LIKE '%".$buscar."%'";
        //instacia de la clase 
        $pdf = new myPDF("SERVICIO COMUNITARIO",$sql);
        //llamamos los metodos correspondientes
        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
        $pdf->header_Servicio_Comunitario();
        $pdf->viewTable_Servicio_Comunitario_H();
        $pdf->SetFont('Arial', '', 15);
        $pdf->SetTitle('SOLICITUD_SERVICIO_COMUNITARIO.PDF');
        $pdf->Output();
    
        return false;
    }else{
        $sql= "SELECT nombres, apellidos, correo, observacion,nombre_proyecto,valor FROM tbl_servicio_comunitario 
       INNER JOIN tbl_personas ON tbl_servicio_comunitario.id_persona=tbl_personas.id_persona
       INNER JOIN tbl_personas_extendidas ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona
       ";
    
        $pdf = new myPDF("SERVICIO COMUNITARIO",$sql);
        
        $pdf->AliasNbPages();
        $pdf->AddPage('C', 'Legal', 0);
        $pdf->header_Servicio_Comunitario();
        $pdf->viewTable_Servicio_Comunitario_H();
        $pdf->SetFont('Arial', '', 15);
        $pdf->SetTitle('SOLICITUD_SERVICIO_COMUNITARIO.PDF');
        $pdf->Output();
    
        return false;
    }
}
/**-------FIN DE REPORTES DE SUANY----- */




