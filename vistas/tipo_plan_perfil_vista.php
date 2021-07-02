<?php
ob_start();
session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');




$Id_objeto = 119;

$visualizacion = permiso_ver($Id_objeto);


if ($visualizacion == 0) {
    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_perfil360_vista.php";

                            </script>';
} else {

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'DESCRIPCION DEL TIPO DE PLAN');

    // if (permisos::permiso_modificar($Id_objeto) == '1') {
    //     $_SESSION['btn_historial'] = "";
    // } else {
    //     $_SESSION['btn_historial'] = "disabled";
    // }
}


?>

