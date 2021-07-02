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
    $sql="SELECT valor, nombres, apellidos, correo,observacion, tbl_carta_egresado.Id_carta, tbl_personas.id_persona FROM tbl_carta_egresado INNER JOIN tbl_personas 
    ON tbl_carta_egresado.id_persona=tbl_personas.id_persona INNER JOIN tbl_personas_extendidas
    ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona
    WHERE tbl_carta_egresado.Id_carta='$alumno'";

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
    
    $consulta="SELECT nombres, apellidos, correo,tbl_personas.id_persona, observacion, aprobado, documento, Fecha_creacion,Id_carta FROM
                     tbl_personas INNER JOIN tbl_carta_egresado ON tbl_personas.id_persona = tbl_carta_egresado.id_persona";
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