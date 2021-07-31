<?php
	
require_once ('../clases/Conexion.php');

if(isset($_POST['txt_nombre']) && $_POST['txt_nombre']!=="" && $_POST['txt_cuenta']!=="" && $_POST['txt_correo']!=="" && $_POST['txt_razon']!==""){ 
    
    if($_FILES['txt_solicitud']['name']!=null && $_FILES['txt_constancia']['name']!=null
        && $_FILES['txt_forma']['name']!=null && $_FILES['txt_identidad']['name']!=null){
            
            $ncuenta = $_POST['txt_cuenta'];
            $correo = $_POST['txt_correo'];
            $motivo = $_POST['txt_razon'];
            $verificado1 = $_POST['txt_verificado1'];
            $verificado2 = $_POST['txt_verificado2'];
            $id_persona = $_POST['id_persona'];

            $sql="SELECT p.nombres,p.apellidos,pe.valor
                  FROM tbl_personas p, tbl_personas_extendidas pe
                  WHERE p.id_persona = pe.id_persona
                  AND pe.valor = $ncuenta";
            $resultado = $mysqli->query($sql);

            if($resultado->num_rows>=1){

                $documento_nombre[] = $_FILES['txt_solicitud']['name'];
                $documento_nombre[] = $_FILES['txt_constancia']['name'];
                $documento_nombre[] = $_FILES['txt_forma']['name'];
                $documento_nombre[] = $_FILES['txt_identidad']['name'];

                $documento_nombre_temporal[] = $_FILES['txt_solicitud']['tmp_name'];
                $documento_nombre_temporal[] = $_FILES['txt_constancia']['tmp_name'];
                $documento_nombre_temporal[] = $_FILES['txt_forma']['tmp_name'];
                $documento_nombre_temporal[] = $_FILES['txt_identidad']['tmp_name'];

                $micarpeta = '../archivos/cancelar_clases/'.$ncuenta;
                    if (!file_exists($micarpeta)) {
                         mkdir($micarpeta, 0777, true);
                        }else{
                            $documento = glob('../archivos/cancelar_clases/'.$ncuenta.'/*'); // obtiene los documentos
                            foreach($documento as $documento){ // itera los documentos
                            if(is_file($documento)) 
                            unlink($documento); // borra los documentos
                        }
                        }
                for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                
                    move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                    $ruta= '../archivos/cancelar_clases/'.$ncuenta.'/'.$documento_nombre[$i];
                    $direccion[]= $ruta;
                }
                $documento = json_encode($direccion);


                $sql= "INSERT INTO tbl_cancelar_clases (id_persona, motivo, Fecha_creacion, documento, cambio, observacion, correo)
                VALUES ('$id_persona', '$motivo', current_timestamp(),'$documento', 'Nuevo', 'revision pendiente','$correo')";
                
                $resultadop = $mysqli->query($sql);
                if($resultadop == true){
                    echo '<script type="text/javascript">
                                    swal({
                                        title:"¿Deseas ver reporte en PDF?",
                                        text:"Solicitud enviada...",
                                        type: "question",
                                        showCancelButton: true,     
                                        confirmButtonText: "Si",
                                        cancelButtonText: "No"
                                    }).then(function() {
                                        window.open("../Controlador/reporte_revision_cancelar_clases_controlador.php")
                                        window.location.href = "../vistas/historial_solicitudes_vista.php";
                                    });
                                        $(".FormularioAjax")[0].reset();
                                       </script>'; 
                    
                                } 
                else {
                    echo "Error: " . $sql ;
                    }


            }else{
                echo '<script type="text/javascript">
                        swal({
                                title:"",
                                text:"El numero de cuenta es incorrecto....",
                                type: "error",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $(".FormularioAjax")[0];
                      </script>'; 
            }

    }else{
        echo '<script type="text/javascript">
                swal({
                    title:"",
                    text:"Faltan Documentos por subir....",
                    type: "error",
                    showConfirmButton: false,
                    timer: 1500
                    });
                    $(".FormularioAjax")[0];
              </script>'; 
    } 
}
elseif(isset($_POST['cambio']) && $_POST['cambio']!==""){

    $cambio = $_POST['cambio'];
    $cuenta = $_POST['txt_cuenta'];
    //$motivo = $_POST['txt_razon'];
    $observacion = $_POST['txt_observacion'];
   $Id_cancelar_clases=$_POST['Id_cancelar_clases'];
    if($observacion!==""){
    
        
        $sql = "UPDATE tbl_cancelar_clases SET observacion='$observacion', cambio='$cambio' WHERE Id_cancelar_clases='$Id_cancelar_clases'";
        $resultadop = $mysqli->query($sql);
        if($resultadop == true){

            
            $mysqli->next_result();

            

            echo '<script type="text/javascript">
                    swal({
                        title:"",
                        text:"Solicitud enviada...",
                        type: "success",
                        allowOutsideClick:false,
                        showConfirmButton: true,
                        }).then(function () {
                        window.location.href = "revision_cancelar_clases.php";
                        });
                        $(".FormularioAjax")[0].reset();
                    </script>'; 
             } 
        else {
            echo "Error: " . $sql ;
            }
       
    }else{
        
        
        $sql= "UPDATE tbl_cancelar_clases SET cambio='$cambio' WHERE Id_cancelar_clases='$Id_cancelar_clases'";
        $resultadop = $mysqli->query($sql);
        if($resultadop == true){
            

            echo '<script type="text/javascript">
                    swal({
                        title:"",
                        text:"Solicitud enviada...",
                        type: "success",
                        allowOutsideClick:false,
                        showConfirmButton: true,
                        }).then(function () {
                        window.location.href = "revision_cancelar_clases.php";
                        });
                        $(".FormularioAjax")[0].reset();
                    </script>'; 
             } 
        else {
            echo "Error: " . $sql ;
            }
    }
                              
}
else{
    echo '<script type="text/javascript">
                                swal({
                                    title:"",
                                    text:"Faltan campos por llenar....",
                                    type: "error",
                                    showConfirmButton: false,
                                    timer: 1500
                                    });
                                    $(".FormularioAjax")[0];
                                </script>'; 
}
        
?>