<?php
	
require_once ('../clases/Conexion.php');

if(isset($_POST['txt_nombre']) && $_POST['txt_nombre']!=="" && $_POST['txt_cuenta']!=="" && $_POST['txt_correo']!==""){ 
   
    if($_FILES['txt_finalizacion']['name']!=null && $_FILES['txt_certificado']['name']!=null
        && $_FILES['txt_comunitario']['name']!=null && $_FILES['txt_identidad']['name']!=null){
            
            $ncuenta = $_POST['txt_cuenta'];
            $correo = $_POST['txt_correo'];
            $verificado1 = $_POST['txt_verificado1'];
            $verificado2 = $_POST['txt_verificado2'];
            $id_persona = $_POST['id_persona'];

            $sql="SELECT p.nombres,p.apellidos,pe.valor
                  FROM tbl_personas p, tbl_personas_extendidas pe
                  WHERE p.id_persona = pe.id_persona
                  AND pe.valor = $ncuenta";
            $resultado = $mysqli->query($sql);

            if($resultado->num_rows>=1){

                $documento_nombre[] = $_FILES['txt_finalizacion']['name'];
                $documento_nombre[] = $_FILES['txt_certificado']['name'];
                $documento_nombre[] = $_FILES['txt_comunitario']['name'];
                $documento_nombre[] = $_FILES['txt_identidad']['name'];

                $documento_nombre_temporal[] = $_FILES['txt_finalizacion']['tmp_name'];
                $documento_nombre_temporal[] = $_FILES['txt_certificado']['tmp_name'];
                $documento_nombre_temporal[] = $_FILES['txt_comunitario']['tmp_name'];
                $documento_nombre_temporal[] = $_FILES['txt_identidad']['tmp_name'];

                $micarpeta = '../archivos/carta_egresado/'.$ncuenta;
                    if (!file_exists($micarpeta)) {
                         mkdir($micarpeta, 0777, true);
                        }else{
                            $documento = glob('../archivos/carta_egresado/'.$ncuenta.'/*'); // obtiene los documentos
                            foreach($documento as $documento){ // itera los documentos
                            if(is_file($documento)) 
                            unlink($documento); // borra los documentos
                        }
                        }
                for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                
                    move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                    $ruta= '../archivos/carta_egresado/'.$ncuenta.'/'.$documento_nombre[$i];
                    $direccion[]= $ruta;
                }
                $documento = json_encode($direccion);
                
                // ? revisar este bloque de codigo y encontrar la relacion entre tablas persona_extendida y personas

                // if($verificado1!=="" && $verificado2!==""){
                //     $insertanombre ="call upd_nombre('$ncuenta','$verificado1','$verificado2')";
                //     $resultadon = $mysqli->query($insertanombre);
                //     $resultadon->free();
                //     $mysqli->next_result();
                // }

                /** procedimiento almacenado 
                 * ! se puede crear el procedimiento ins_carta_egresado() o mandar la consulta directa sql pasar id_persona y no 6
                 */
                // call ins_carta_egresado('$ncuenta','$documento','$correo')
                $sql= "INSERT INTO tbl_carta_egresado (id_persona, observacion, Fecha_creacion, aprobado, documento, correo)
                             VALUES ('$id_persona', 'revisión pendiente', current_timestamp(),'Nuevo', '$documento', '$correo')";
               
                $resultadop = $mysqli->query($sql);
                if($resultadop == true){
                  
                    $Ultimo_id= $mysqli->insert_id;
                    $ultimo_id_hash= base64_encode($Ultimo_id);
                    echo '<script type="text/javascript">
                    swal({
                        title:"¿Deseas ver reporte en PDF?",
                        text:"Solicitud enviada...",
                        type: "question",
                        allowOutsideClick:false,
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonText:"Sí",
                        cancelButtonText:"No",
                        })
        
                        .then(function(isConfirm) {
                            if (isConfirm)  {
                                window.open("../Controlador/Reporte_especialidades.php?id_carta='.$ultimo_id_hash.'");
                                window.location.href="../vistas/historial_solicitudes_vista.php";
                              }    
                        })
                        .catch(function(){
                            window.location.href="../vistas/historial_solicitudes_vista.php";
                            $(".FormularioAjax")[0].reset();
                        });
                    </script>'; 

                    // echo '<script type="text/javascript">
                    //                 swal({
                    //                     title:"",
                    //                     text:"Solicitud enviada...",
                    //                     type: "success",
                    //                     showConfirmButton: false,
                    //                     timer: 1500
                    //                     });
                    //                     $(".FormularioAjax")[0].reset();
                    //                    </script>'; 
                    
                                } 
                else {
                    // echo "Error: " . $sql ;

                    echo json_encode($sql); 
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
elseif(isset($_POST['aprobado']) && $_POST['aprobado']!==""){

    $aprobado = $_POST['aprobado'];
    $cuenta = $_POST['txt_cuenta'];
    $observacion = $_POST['txt_observacion'];
    $Id_carta=$_POST['Id_carta'];
    if($observacion!==""){
        // $sqlp = "call upd_carta_egresado_observacion('$aprobado','$observacion','$cuenta')";
         
        $sql = "UPDATE tbl_carta_egresado SET observacion='$observacion', aprobado='$aprobado'  WHERE Id_carta='$Id_carta'";
        $resultadop = $mysqli->query($sql);
        if($resultadop == true){

            //$resultadop->free();
            $mysqli->next_result();

            // if($aprobado==="aprobado"){
            //     $consulta= "call ins_himno('$cuenta')";
            //     $consultar =  $mysqli->query($consulta);
            //     $consultar->free();
            //     $mysqli->next_result();
            // }

            echo '<script type="text/javascript">
                    swal({
                        title:"",
                        text:"Solicitud enviada...",
                        type: "success",
                        allowOutsideClick:false,
                        showConfirmButton: true,
                        }).then(function () {
                        window.location.href = "revision_carta_egresado_vista.php";
                        });
                        $(".FormularioAjax")[0].reset();
                    </script>'; 
             } 
        else {
            echo "Error: " . $sql ;
            }
       
    }else{
        // $sqlp = "call upd_carta_egresado('$aprobado','$cuenta')";

        $sql = "UPDATE tbl_carta_egresado SET  aprobado='$aprobado'  WHERE Id_carta='$Id_carta'";
        $resultadop = $mysqli->query($sql);
        if($resultadop == true){
            //$resultadop->free();
           // $mysqli->next_result();

            // if($aprobado==="aprobado"){
            //     $consulta= "call ins_himno('$cuenta')";
            //     $consultar =  $mysqli->query($consulta);
            //     $consultar->free();
            //     $mysqli->next_result();
        
            //     }

            echo '<script type="text/javascript">
                    swal({
                        title:"",
                        text:"Solicitud enviada...",
                        type: "success",
                        allowOutsideClick:false,
                        showConfirmButton: true,
                        }).then(function () {
                        window.location.href = "revision_carta_egresado_vista.php";
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
