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
    $sql="SELECT nombre_proyecto,correo,valor, nombres, apellidos,observacion, tbl_servicio_comunitario.id_servicio_comunitario, tbl_personas.id_persona,
          tbl_servicio_comunitario.nombre_proyecto,tbl_servicio_comunitario.correo,tbl_servicio_comunitario.id_estado_servicio,tbl_servicio_comunitario.fecha_creacion,tbl_servicio_comunitario.documento
          FROM tbl_servicio_comunitario INNER JOIN tbl_personas ON tbl_servicio_comunitario.id_persona=tbl_personas.id_persona
          INNER JOIN tbl_personas_extendidas ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona
          WHERE tbl_servicio_comunitario.id_servicio_comunitario='$alumno'";

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
    
    $consulta="SELECT nombre_proyecto,correo, valor, nombres, apellidos,observacion, tbl_servicio_comunitario.id_servicio_comunitario, 
    tbl_personas.id_persona,tbl_servicio_comunitario.id_estado_servicio,tbl_servicio_comunitario.fecha_creacion
    FROM tbl_servicio_comunitario INNER JOIN tbl_personas ON tbl_servicio_comunitario.id_persona=tbl_personas.id_persona
    INNER JOIN tbl_personas_extendidas ON tbl_personas.id_persona=tbl_personas_extendidas.id_persona
    ";
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