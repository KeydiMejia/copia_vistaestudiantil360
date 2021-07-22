<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once ('../clases/Conexion.php');

if(isset($_GET['alumno'])){
    $alumno= $_GET['alumno'];
    //"call sel_cancelar_clases_unica('$alumno')"
    $sql="SELECT valor, nombres, apellidos, correo, motivo, observacion, tbl_cancelar_clases.Id_cancelar_clases, tbl_personas.id_persona
    FROM tbl_cancelar_clases INNER JOIN tbl_personas
    ON tbl_cancelar_clases.id_persona=tbl_personas.id_persona INNER JOIN tbl_personas_extendidas
    ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona
    WHERE tbl_cancelar_clases.Id_cancelar_clases='$alumno'";
    
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
    //"call sel_cancelar_clases()"
    $consulta="SELECT nombres, apellidos, correo, tbl_personas.id_persona, motivo, observacion, cambio, documento, fecha_creacion, Id_cancelar_clases FROM 
    tbl_personas INNER JOIN tbl_cancelar_clases ON tbl_personas.id_persona = tbl_cancelar_clases.id_persona";
    if ($R = $mysqli->query($consulta)) {
        //$items = [];

        //while ($row = $R->fetch_assoc()) {

            //array_push($items, $row);
        //}
        //$R->close();
        //$result["ROWS"] = $items;
        $items = [];

        while ($row = $R->fetch_assoc()) {

            array_push($items, $row);
        }
        $R->close();
        $result["ROWS"] = $items;
    
    }
    echo json_encode($result);
}