<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once ('../clases/Conexion.php');

if(isset($_GET['alumno'])){
    $alumno= $_GET['alumno'];
    // "call sel_carta_egresado_unica('$alumno')"
    $sql="SELECT valor, nombres, apellidos, correo, tipo, observacion, tbl_examen_suficiencia.id_suficiencia, tbl_personas.id_persona FROM tbl_examen_suficiencia INNER JOIN tbl_personas
    ON tbl_examen_suficiencia.id_persona=tbl_personas.id_persona INNER JOIN tbl_personas_extendidas
    ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona
    WHERE tbl_examen_suficiencia.id_suficiencia='$alumno'";

    if ($R = $mysqli->query($sql)) {
        $items = [];

        while ($row = $R->fetch_assoc()) {

            array_push($items, $row);
        }
        $R->close();
        $result["ROWS"] = $items;
    }
    echo json_encode($result);
}else{
    
    // "call sel_carta_egresado()"
    
    
$consulta="SELECT nombres, apellidos, correo, tbl_personas.id_persona,  observacion,  documento, fecha_creacion, id_suficiencia, id_estado_suficiencia, tipo FROM 
tbl_personas INNER JOIN tbl_examen_suficiencia ON tbl_personas.id_persona = tbl_examen_suficiencia.id_persona";
    if ($R = $mysqli->query($consulta)) {
        // $items = [];

        // while ($row = $R->fetch_assoc()) {

        //     array_push($items, $row);
        // }
        // $R->close();
        // $result["ROWS"] = $items;

        $items = [];

        while ($row = $R->fetch_assoc()) {

            array_push($items, $row);
        }
        $R->close();
        $result["ROWS"] = $items;
    }
    echo json_encode($result);
}