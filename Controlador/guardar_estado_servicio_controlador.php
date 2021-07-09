<?php
 session_start();

 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_bitacora.php'); 

        $Id_objeto=153 ;


$estado=strtoupper ($_POST['txt_estado']);
$descripcion=strtoupper ($_POST['txt_descripcion']);
	//$Horario_salida=strtoupper ($_POST['txt_Horario_salida']);


 
///Logica para el que se repite
 $sqlexiste=("select count(estado) as estado  from tbl_estado_servicio where estado='$estado'");
 //Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



/* Logica para que no acepte campos vacios */
if ($_POST['txt_estado'] <>' ')
{

 
  /* Condicion para que no se repita el rol*/
    if ($existe['estado']== 1)
    {
        echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos el estado ya existe",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
    
    }
    else
    {
       
    			/* Query para que haga el insert*/
               // $sql="INSERT INTO `tbl_estado_reactivacion`(`estado`, `descripcion`) VALUES ('$estado','$descripcion')"
               //$sql="INSERT INTO tbl_estado_reactivacion (estado , descripcion) VALUES ('$estado','$descripcion')";
				$sql = "call proc_crear_estado_servicio('$estado' , '$descripcion')";
                $resultado = $mysqli->query($sql);
       
        
	        if($resultado === TRUE) 
          {
                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'EL ESTADO '. $estado.'');

         /*   require"../contenidos/crearRol-view.php"; 
    		header('location: ../contenidos/crearRol-view.php?msj=2');*/
         echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Los datos  se almacenaron correctamente",
                                   type: "success",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                            </script>';
           
			} 
			else 
			{


    		echo "Error: " . $sql ;
			}

    }


} 

else
{
  echo '<script type="text/javascript">
                                    swal({
                                       title:"",
                                       text:"Lo sentimos tiene campos por rellenar",
                                       type: "error",
                                       showConfirmButton: false,
                                       timer: 3000
                                    });
                                </script>';
}
