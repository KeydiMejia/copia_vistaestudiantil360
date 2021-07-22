<?php
    
require_once ('../clases/Conexion.php');

    if(isset($_POST['txt_nombre']) && $_POST['txt_nombre']!==""  && $_POST['txt_cuenta']!=="" && $_POST['txt_correo']!=="" 
        && isset($_POST['txt_codigo']) && $_POST['txt_codigo']!==""){
        
        $cuenta= $_POST['txt_cuenta'];
        $correo = $_POST['txt_correo'];
        $verificado1 = $_POST['txt_verificado1'];
        $verificado2 = $_POST['txt_verificado2'];
       // $observacion = $_POST['txt_observacion'];
       
     

        $sql="SELECT p.id_persona, p.nombres,p.apellidos,pe.valor
             FROM tbl_personas p, tbl_personas_extendidas pe
             WHERE pe.id_persona = p.id_persona
             AND pe.valor = $cuenta";
        $resultado = $mysqli->query($sql);
        $data= $resultado->fetch_assoc();

        if($resultado->num_rows>=1){
            if($_FILES['txt_solicitud']['name']!=null && $_FILES['txt_historial']['name']!=null){
                $documento_nombre[] = $_FILES['txt_solicitud']['name'];
                $documento_nombre[] = $_FILES['txt_historial']['name'];

                $documento_nombre_temporal[] = $_FILES['txt_solicitud']['tmp_name'];
                $documento_nombre_temporal[] = $_FILES['txt_historial']['tmp_name'];
                
                
                $micarpeta = '../archivos/reactivacion_cuenta/'.$cuenta;
                if (!file_exists($micarpeta)) {
                     mkdir($micarpeta, 0777, true);
                    }else{
                        $documento = glob('../archivos/reactivacion_cuenta/'.$cuenta.'/*'); // obtiene los documentos
                        foreach($documento as $documento){ // itera los documentos
                        if(is_file($documento)) 
                        unlink($documento); // borra los documentos
                        } 
                    }
                for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                    
                    move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                    $ruta= '../archivos/reactivacion_cuenta/'.$cuenta."/".$documento_nombre[$i];
                    $direccion[]= $ruta;
                }
                $documento = json_encode($direccion);

                // if($verificado1!=="" && $verificado2!==""){
                //     $insertanombre ="call upd_nombre('$cuenta','$verificado1','$verificado2')";
                //     $resultadon = $mysqli->query($insertanombre);
                //    $resultadon->free();
                //     $mysqli->next_result();
                // }

                // $sqlp = "call ins_equivalencias('$cuenta','$documento','CODIGO','$correo')";
                $id_persona=$data['id_persona'];
               
               $sqlp= "INSERT INTO tbl_reactivacion_cuenta (id_persona, documento,fecha_creacion,observacion, id_estado_reactivacion, correo)
                                                   VALUES ('$id_persona', '$documento', now() ,'Revisión Pendiente','1', '$correo')";
               
                $resultadop = $mysqli->query($sqlp);
                if($resultadop == true){
                    echo '<script type="text/javascript">
                            swal({
                                title:"¿Deseas ver reporte en PDF?",
                                        text:"Solicitud enviada...",
                                        type: "question",
                                        showCancelButton: true,     
                                        confirmButtonText: "Aceptar",
                                        cancelButtonText: "Cancelar"
                                    }).then(function() {
                                        window.open("../Controlador/reporte_revision_reactivacion_controlador.php");
                                    });
                                        $(".FormularioAjax")[0].reset();
                                       </script>'; 
                        } 
                    else {
                        echo "Error: " . $sqlp;
                        }
            }else{
                echo '<script type="text/javascript">
                        swal({
                        title:"",
                        text:"Faltan documentos por subir....",
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
                                text:"El numero de cuenta es incorrecto....",
                                type: "error",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $(".FormularioAjax")[0];
                      </script>';
        }

    // }elseif(isset($_POST['txt_contenido']) && $_POST['txt_contenido']!=="" && $_POST['txt_nombre']!=="" 
    //  && $_POST['txt_cuenta']!=="" && $_POST['txt_correo']!==""){
    //     $cuenta=$_POST['txt_cuenta'];
    //     $verificado1 = $_POST['txt_verificado1'];
    //     $verificado2 = $_POST['txt_verificado2'];
    //     $correo = $_POST['txt_correo'];

    //     $sql="SELECT p.id_persona,p.nombres,p.apellidos,pe.valor
    //          FROM tbl_personas p, tbl_personas_extendidas pe
    //          WHERE pe.id_persona = p.id_persona
    //          AND pe.valor = $cuenta";
    //     $resultado = $mysqli->query($sql);
    //     $data= $resultado->fetch_assoc();

    //     if($resultado->num_rows>=1){

    //         if($_FILES['txt_solicitud']['name']!=null && $_FILES['txt_historial']['name']!=null){
    //             $documento_nombre[] = $_FILES['txt_solicitud']['name'];
    //             $documento_nombre[] = $_FILES['txt_historial']['name'];
    
    //             $documento_nombre_temporal[] = $_FILES['txt_solicitud']['tmp_name'];
    //             $documento_nombre_temporal[] = $_FILES['txt_historial']['tmp_name'];
                
    //             $micarpeta = '../archivos/equivalencias/contenido/'.$cuenta;
    //             if (!file_exists($micarpeta)) {
    //                  mkdir($micarpeta, 0777, true);
    //                 }else{
    //                     $documento = glob('../archivos/equivalencias/contenido/'.$cuenta.'/*'); // obtiene los documentos
    //                     foreach($documento as $documento){ // itera los documentos
    //                     if(is_file($documento)) 
    //                     unlink($documento); // borra los documentos
    //                     }
    //                 }
    //             for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                    
    //                 move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
    //                 $ruta= '../archivos/equivalencias/contenido/'.$cuenta."/".$documento_nombre[$i];
    //                 $direccion[]= $ruta;
    //             }
    //             $documento = json_encode($direccion);

    //             // if($verificado1!=="" && $verificado2!==""){
    //             //     $insertanombre ="call upd_nombre('$cuenta','$verificado2','$verificado2')";
    //             //     $resultadon = $mysqli->query($insertanombre);
    //             //     $resultadon->free();
    //             //     $mysqli->next_result();
    //             // }
    
    //             // $sqlp = "call ins_equivalencias('$cuenta','$documento','CONTENIDO','$correo')";
               
    //             $id_persona=$data['id_persona'];
               
    //             $sqlp= "INSERT INTO tbl_equivalencias (id_persona, observacion, Fecha_creacion, aprobado, documento,tipo,correo)
    //              VALUES ('$id_persona', 'revisión pendiente', current_timestamp(),'Nueva', '$documento','CONTENIDO','$correo')";

    //             $resultadop = $mysqli->query($sqlp);
    //             if($resultadop == true){
    //                 echo '<script type="text/javascript">
    //                         swal({
    //                             title:"",
    //                             text:"Solicitud enviada...",
    //                             type: "success",
    //                             showConfirmButton: false,
    //                             timer: 1500
    //                             });
    //                             $(".FormularioAjax")[0].reset();
    //                         </script>'; 
    //                     } 
    //                 else {
    //                     echo "Error: " . $sql ;
    //                     }
    //         }else{
    //             echo '<script type="text/javascript">
    //                         swal({
    //                         title:"",
    //                         text:"Faltan documentos por subir....",
    //                         type: "error",
    //                         showConfirmButton: false,
    //                         timer: 1500
    //                         });
    //                         $(".FormularioAjax")[0];
    //                     </script>';
    //         }

    //     }else{
    //             echo '<script type="text/javascript">
    //                     swal({
    //                             title:"",
    //                             text:"El numero de cuenta es incorrecto....",
    //                             type: "error",
    //                             showConfirmButton: false,
    //                             timer: 1500
    //                         });
    //                         $(".FormularioAjax")[0];
    //                   </script>'; 
    //         }

    }else if(isset($_POST['aprobado']) && $_POST['aprobado']!==""){
        $aprobado = $_POST['aprobado'];
        $cuenta = $_POST['txt_cuenta1'];
        $observacion = $_POST['txt_observacion'];
       // $tipo = $_POST['txt_tipo'];

        $sql=$mysqli->prepare("select p.id_persona,p.nombres,p.apellidos, pe.valor 
                               from tbl_personas p,tbl_personas_extendidas pe 
                               where p.id_persona = pe.id_persona
                               AND pe.valor =  ?");
        $sql->bind_param("i",$cuenta);
        $sql->execute();
        $resultado = $sql->get_result();
        $row = $resultado->fetch_array(MYSQLI_ASSOC);
        $id = $row['id_persona'];
        
        if($observacion!==""){
           //`id_estado_reactivacion` = '$aprobado'
            $sqlp = "UPDATE `tbl_reactivacion_cuenta` 
            SET  `fecha_creacion` = now(),
            `observacion` = '$observacion'
            
            WHERE id_persona = '$id'";
            $resultadop = $mysqli->query($sqlp);
            if($resultadop >= 1){
                echo '<script type="text/javascript">
                        swal({
                            title:"",
                            text:"Solicitud enviada...",
                            type: "success",
                            allowOutsideClick:false,
                            showConfirmButton: true,
                            }).then(function () {
                            window.location.href = "revision_reactivacion_vista.php";
                            });
                            $(".FormularioAjax")[0].reset();
                        </script>'; 
                 } 
            else {
                echo "Error: " . $sqlp ;
                }

        }else{
            
            $sqlp = "UPDATE `tbl_reactivacion_cuenta` 
                    SET  `fecha_creacion` = now(),
                    `observacion` = '$observacion',
                    `id_estado_reactivacion` = '1'
                    WHERE id_persona = '$id'
                    ";
            $resultadop = $mysqli->query($sqlp);
            if($resultadop >= 1){
                echo '<script type="text/javascript">
                        swal({
                            title:"",
                            text:"Solicitud enviada...",
                            type: "success",
                            allowOutsideClick:false,
                            showConfirmButton: true,
                            }).then(function () {
                            window.location.href = "revision_reactivacion_vista.phphp";
                            });
                            $(".FormularioAjax")[0].reset();
                        </script>'; 
                 } 
            else {
                echo "Error: " . $sqlp ;
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

