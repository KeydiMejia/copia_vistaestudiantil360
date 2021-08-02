<?php

require_once ('../clases/Conexion.php');




if (isset($_GET['python'])) {



    $id= base64_decode( $_GET['python']);
    $table=  $_GET['tabla'];
    $campo= $_GET['campo'];
    

    


    $sql="DELETE FROM $table WHERE $campo = '$id'";

       
    $resultado = $mysqli->query($sql);


    
    
    ;                      
	if($resultado ){

        // bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'ELIMINO' , 'EL ATRIBUTO   '.ctype_upper($atributo).'');
        echo '<script type="text/javascript">
       
        alert("Solucitud eliminada")
        window.location="../vistas/historial_solicitudes_vista.php";
        
        </script>';

        

    }else{
        //echo json_encode($_GET);
        echo '<script type="text/javascript">
        
        alert("Datos no eliminados")
         window.location="../vistas/historial_solicitudes_vista.php";
        
        </script>';
                          
    }

}





