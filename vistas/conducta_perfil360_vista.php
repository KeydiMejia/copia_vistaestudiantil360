<?php
ob_start();
session_start();


require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');

$Id_objeto = 120;


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

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'MAS INFORMACION SOBRE CONDUCTA');


    //if (permisos::permiso_insertar($Id_objeto) == '1') {
     //$_SESSION['btn_solicitud'] = "";
    //} else {
    //$_SESSION['btn_solicitud'] = "disabled";
    // }
}

ob_end_flush();


?>


<!DOCTYPE html>
<html>

<head>


</head>


<body>
</body>
</html>