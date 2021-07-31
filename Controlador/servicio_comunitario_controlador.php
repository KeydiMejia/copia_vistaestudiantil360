<<?php
	
    require_once ('../clases/Conexion.php');
    
    if(isset($_POST['txt_nombre']) && $_POST['txt_nombre']!==""  && $_POST['txt_cuenta']!=="" && $_POST['txt_correo']!==""&& $_POST['txt_nombre']!==""){ 
       
        if($_FILES['txt_solicitud']['name']!=null && $_FILES['txt_historial']['name']!=null){
            $proyecto=$_POST['txt_nombre'];
            $cuenta = $_POST['txt_cuenta'];
            $correo = $_POST['txt_correo'];
            $verificado1 = $_POST['txt_verificado1'];
            $verificado2 = $_POST['txt_verificado2'];
                
    
            $sql="SELECT p.nombres,p.apellidos,pe.valor,p.id_persona
                    FROM tbl_personas p, tbl_personas_extendidas pe
                    WHERE p.id_persona = pe.id_persona
                    AND pe.valor = $cuenta";
    
                $resultado = $mysqli->query($sql);
                $data= $resultado->fetch_assoc();
                
                if($resultado->num_rows>=1){
                $id_persona=$data['id_persona'];
    
                $documento_nombre[] = $_FILES['txt_solicitud']['name'];
                $documento_nombre[] = $_FILES['txt_historial']['name'];
            
                $documento_nombre_temporal[] = $_FILES['txt_solicitud']['tmp_name'];
                $documento_nombre_temporal[] = $_FILES['txt_historial']['tmp_name'];
    
                $micarpeta = '../archivos/servicio_comunitario/'.$cuenta.'/'.$proyecto;
                    if (!file_exists($micarpeta)) {
                            mkdir($micarpeta, 0777, true);
    
                    }// }else{
                    //         $documento = glob('../archivos/servicio_comunitario/'.$cuenta.'/*'); // obtiene los documentos
                            
                    //         foreach($documento as $documento){ // itera los documentos
                               
                    //             if(is_file($documento)) 
                    //             unlink($documento); // borra los documentos
                    //         }
                    //     }
                for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                
                    move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                    $ruta= '../archivos/servicio_comunitario/'.$cuenta.'/'.$documento_nombre[$i];
                    $direccion[]= $ruta;
                }
                $direccion_documento = json_encode($direccion);
                
                // ? revisar este bloque de codigo y encontrar la relacion entre tablas persona_extendida y personas
    
                // if($verificado1!=="" && $verificado2!==""){
                //     $insertanombre ="call upd_nombre('$cuenta','$verificado1','$verificado2')";
                //     $resultadon = $mysqli->query($insertanombre);
                //     $resultadon->free();
                //     $mysqli->next_result();
                // }
    
                /** procedimiento almacenado 
                 * ! se puede crear el procedimiento ins_carta_egresado() o mandar la consulta directa sql pasar id_persona y no 6
                 */
                // call ins_carta_egresado('$ncuenta','$documento','$correo')
                
                
                $sql= "INSERT INTO tbl_servicio_comunitario (id_persona,nombre_proyecto,fecha_creacion,documento,observacion,id_estado_servicio,correo)
                VALUES ($id_persona,'$proyecto', current_timestamp(), '$direccion_documento','Nuevo',1,'$correo')";
    
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
                        }).then(function () {
                       
                            window.open("../Controlador/Reporte_especialidades.php?servicio='.$ultimo_id_hash.'")
                        });
                        $(".FormularioAjax")[0].reset();
                        windows.location.href("../vistas/historial_solicitudes_vista.php"); 
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
    
    elseif(isset($_POST['aprobado']) && $_POST['aprobado']!==""){
    
        $aprobado = $_POST['aprobado'];
        $cuenta = $_POST['txt_cuenta'];
        $observacion = $_POST['txt_observacion'];
        $id_servicio=$_POST['id_servicio_comunitario'];
        
        ($aprobado=="aprobado")? $estado=2:$estado=3;
    
        
        
        if($observacion!==""){
            // $sqlp = "call upd_carta_egresado_observacion('$aprobado','$observacion','$cuenta')";
             
            $sql = "UPDATE tbl_servicio_comunitario SET observacion='$observacion',id_estado_servicio='$estado'  WHERE id_servicio_comunitario='$id_servicio'";
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
                            window.location.href = "revision_servicio_comunitario_vista.php";
                            });
                            $(".FormularioAjax")[0].reset();
                        </script>'; 

               

                       
                 } 
            else {
                echo '<script type="text/javascript">
                                    swal({
                                        title:"Control de Excepciones",
                                        text:"No se realizó la operación, contactar a Sporte Técnico.",
                                        type: "error",
                                        showConfirmButton: false,
                                        timer: 3000
                                        });
                                        $(".FormularioAjax")[0];
                                    </script>'; 
                }
           
        }else{
             echo '<script type="text/javascript">
                                    swal({
                                        title:"Validación de Campos",
                                        text:"Faltan campos por llenar....",
                                        type: "error",
                                        showConfirmButton: false,
                                        timer: 3000
                                        });
                                        $(".FormularioAjax")[0];
                                    </script>'; 
    
            
           
        }
                                  
    }
    else{
        echo '<script type="text/javascript">
                                    swal({
                                        title:"Validación de Campos",
                                        text:"Faltan campos por llenar....",
                                        type: "error",
                                        showConfirmButton: false,
                                        timer: 3000
                                        });
                                        $(".FormularioAjax")[0];
                                    </script>'; 
       
    }
    ?>
    
    
    
    