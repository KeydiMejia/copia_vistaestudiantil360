<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once ('../clases/Conexion.php');

if(isset($_GET['alumno'])){
    $alumno= $_GET['alumno'];
    
    // "call sel_equivalencias_unica('$alumno')"

    $sql="SELECT nombres,apellidos,valor as cuenta, correo, tbl_equivalencias.Id_equivalencia FROM tbl_equivalencias INNER JOIN tbl_personas 
    ON tbl_equivalencias.id_persona= tbl_personas.id_persona INNER JOIN tbl_personas_extendidas
    ON tbl_personas.id_persona= tbl_personas_extendidas.id_persona WHERE tbl_equivalencias.Id_equivalencia='$alumno'";
    
    if ($R = $mysqli->query($sql)) {
        $items = [];

        while ($row = $R->fetch_assoc()) {

            array_push($items, $row);
        }
        $R->close();
        $result["ROWS"] = $items;
    }
    echo json_encode($result);


}elseif(isset($_GET['tipo'])){
    $tipo = $_GET['tipo'];

    $sql="SELECT nombres,apellidos,valor as cuenta, correo, tbl_equivalencias.Id_equivalencia FROM tbl_equivalencias INNER JOIN tbl_personas 
    ON tbl_equivalencias.id_persona= tbl_personas.id_persona INNER JOIN tbl_personas_extendidas
    ON tbl_personas.id_persona= tbl_personas_extendidas.id_persona WHERE tbl_equivalencias.tipo='$tipo'";
    // "call sel_equivalencias_codigo('$tipo')"

    if ($R = $mysqli->query($sql)) {
        $items = [];

        while ($row = $R->fetch_assoc()) {

            array_push($items, $row);
        }
        $R->close();
        $result["ROWS"] = $items;
    }
    echo json_encode($result);
}
else{

    $sql="SELECT nombres,apellidos,valor as cuenta, correo, tbl_equivalencias.Id_equivalencia,tipo,Fecha_creacion FROM tbl_equivalencias INNER JOIN tbl_personas 
    ON tbl_equivalencias.id_persona= tbl_personas.id_persona INNER JOIN tbl_personas_extendidas
    ON tbl_personas.id_persona= tbl_personas_extendidas.id_persona";
    // "call sel_equivalencias()"
    if ($R = $mysqli->query($sql)) {
        $items = [];

        while ($row = $R->fetch_assoc()) {

            array_push($items, $row);
        }
        $R->close();
        $result["ROWS"] = $items;
    }
    echo json_encode($result);
}