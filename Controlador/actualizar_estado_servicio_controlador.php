<?php
session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');


$estado= strtoupper($_POST['txt_estado']);
$descripcion = strtoupper($_POST['txt_descripcion']);
$id_estado = $_GET['id_estado_servicio'];


/* Iniciar la variable de sesion y la crea */


///Logica para el rol que se repite
$sqlexiste = ("select count(estado) as estado  from tbl_estado_servicio where estado='$estado' and id_estado_servicio<>'$id_estado' ;");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if ($existe['estado'] == 1) {/*
header("location: ../contenidos/editarRoles-view.php?msj=1&Rol=$Rol2 ");*/

    header("location:../vistas/mantenimiento_estado_servicio_vista.php?msj=1");
} else {

    //$sql="UPDATE `tbl_estado_servicio` SET `estado`='$estado',`descripcion`='$descripcion',`id_estado_servicio`='$id_estado_servicio'";
    $sql = "call proc_actualizar_estado_servicio('$estado','$descripcion','$id_estado' )";
    $valor = "select estado, descripcion from tbl_estado_servicio WHERE id_estado_servicio= '$id_estado'";
    $result_valor = $mysqli->query($valor);
    $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);

    if ($valor_viejo['estado'] <> $estado and $valor_viejo['descripcion'] <> $descripcion) {

        $Id_objeto = 161;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' EL ESTADO ' . $valor_viejo['estado'] . ' POR:  ' . $estado .' ');



        /* Hace el query para que actualize*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_estado_servicio_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_estado_servicio_vista.php?msj=3");
        }
    } elseif ($valor_viejo['estado'] <> $estado) {

        $Id_objeto = 161;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL ESTADO ' . $valor_viejo['estado'] . ' POR:  ' . $estado . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_estado_servicio_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_estado_servicio_vista.php?msj=3");
        }
    } elseif ($valor_viejo['descripcion'] <> $descripcion) 
    {

        $Id_objeto = 161;
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', ' LA DESCRIPCION '. $valor_viejo['descripcion'] . ' POR:  ' . $descripcion . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/mantenimiento_estado_servicio_vista.php?msj=2");
        } else {
            header("location:../vistas/mantenimiento_estado_servicio_vista.php?msj=3");
        }
    } else {
        /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
        header("location:../vistas/mantenimiento_estado_servicio_vista.php?msj=3");
    }
}
