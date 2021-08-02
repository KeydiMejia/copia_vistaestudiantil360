<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once ('../clases/Conexion.php');
// if(isset($_GET['alumno'])){
//     $alumno= $_GET['alumno'];
    $sql="SELECT 'EXAMEN SUFICIENCIA'tipo, s.id_suficiencia,s.id_persona,s.fecha_creacion,
    s.id_estado_suficiencia,e.descripcion,p.nombres,p.apellidos, pe.valor
    FROM tbl_estado_suficiencia e, tbl_examen_suficiencia s, tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
    WHERE pe.id_persona = p.id_persona
    AND p.id_persona = u.id_persona
    AND s.id_persona = p.id_persona
    AND e.id_estado_suficiencia = s.id_estado_suficiencia UNION ALL SELECT'REACTIVACION CUENTA'tipo, id_reactivacion,r.id_persona,r.fecha_creacion,
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
AND s.id_persona = p.id_persona UNION ALL SELECT 'CARTA EGRESADO'tipo, s.Id_carta,s.id_persona,s.Fecha_creacion,s.documento,s.aprobado,
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
AND s.id_persona = p.id_persona UNION ALL SELECT 'EXPEDIENTE DE GRADUACION' tipo, s.id_expediente,s.id_persona,s.fecha_creacion,
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

    
    if ($R = $mysqli->query($sql)) {
        $items = [];

        while ($row = $R->fetch_assoc()) {

            array_push($items, $row);
        }
        $R->close();
        $result["ROWS"] = $items;
    }
        echo json_encode($result);
    
?>