<?php
	
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
                $id_persona=$data['id_persona'];
    
            if($resultado->num_rows>=1){
    
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
                    $ruta= '../archivos/reactivacion_cuenta/'.$cuenta.'/'.$documento_nombre[$i];
                    $direccion[]= $ruta;
                }
                $documento = json_encode($direccion);
                
              
                
                $sql= "INSERT INTO tbl_reactivacion_cuenta(id_persona,documento,fecha_creacion,observacion,id_estado_reactivacion,correo)
                VALUES ('$id_persona','$documento',current_timestamp(), 'Nueva',1,'$correo')";
    
    $resultadop = $mysqli->query($sql);
    if($resultadop == true){
        echo '<script type="text/javascript">
                        swal({
                            title:"¿Deseas ver reporte en PDF?",
                            text:"Solicitud enviada...",
                            type: "question",
                            showCancelButton: true,     
                            confirmButtonText:"Sí",
                            cancelButtonText:"No",
                            })

            .then(function(isConfirm) {
                if (isConfirm)  {
                    window.open("../Controlador/reporte_revision_reactivacion_controlador.php");
                    window.location.href="../vistas/historial_solicitudes_vista.php";
                  }    
            })
            .catch(function(){
                window.location.href="../vistas/historial_solicitudes_vista.php";
                $(".FormularioAjax")[0].reset();
            });
        </script>'; 
   
                } 
                                    else {
                                        
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
        $id_reactivacion=$_POST['id_reactivacion'];
        
        ($aprobado=="aprobado")? $estado=2:$estado=3;
    

        
        if($observacion!==""){
            // $sqlp = "call upd_carta_egresado_observacion('$aprobado','$observacion','$cuenta')";
             
            $sql = "UPDATE tbl_reactivacion_cuenta SET observacion='$observacion',id_estado_reactivacion='$estado'  WHERE id_reactivacion='$id_reactivacion'";
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
                            window.location.href = "revision_reactivacion_vista.php";
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
    
    
    
    