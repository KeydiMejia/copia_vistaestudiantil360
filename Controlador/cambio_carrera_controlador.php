<?php
     
    require_once ('../clases/Conexion.php');
 

    if(isset($_POST['txt_nombre']) && $_POST['txt_nombre']!==""  && $_POST['txt_cuenta']!=="" && $_POST['txt_correo']!==""
    && $_POST['txt_centrore']!=="" && $_POST['txt_facultad']!=="" && $_POST['txt_razon']!==""
    && isset($_POST['txt_interno']) && $_POST['txt_interno']!==""){ 
       
        if($_FILES['txt_historial']['name']!=null && $_FILES['txt_voae']['name']!=null && $_FILES['txt_identidad']['name']!=null
        && $_FILES['txt_foto']['name']!=null && $_FILES['txt_carne']['name']!=null && $_FILES['txt_conducta']['name']!=null
        ){
            $facultad=$_POST['txt_facultad'];
            $centro=$_POST['txt_centrore'];
            $cuenta = $_POST['txt_cuenta'];
            $razon =$_POST ['txt_razon'];
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
    
                $documento_nombre[] = $_FILES['txt_historial']['name'];
                    $documento_nombre[] = $_FILES['txt_voae']['name'];
                    $documento_nombre[] = $_FILES['txt_identidad']['name'];
                    $documento_nombre[] = $_FILES['txt_foto']['name'];
                    $documento_nombre[] = $_FILES['txt_carne']['name'];
                    $documento_nombre[] = $_FILES['txt_conducta']['name'];

                    $documento_nombre_temporal[] = $_FILES['txt_historial']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_voae']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_identidad']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_foto']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_carne']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_conducta']['tmp_name'];
    
                $micarpeta = '../archivos/cambio/interno/'.$cuenta;
                if (!file_exists($micarpeta)) {
                     mkdir($micarpeta, 0777, true);
                    }else{
                        $documento = glob('../archivos/cambio/interno/'.$cuenta.'/*'); // obtiene los documentos
                        foreach($documento as $documento){ // itera los documentos
                        if(is_file($documento)) 
                        unlink($documento); // borra los documentos
                        } 
                    }
                for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                    
                    move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                    $ruta= '../archivos/cambio/interno/'.$cuenta."/".$documento_nombre[$i];
                    $direccion[]= $ruta;
                }
                $documento = json_encode($direccion);

                $sql = "INSERT INTO tbl_cambio_carrera( id_persona, razon_cambio, observacion, aprobado, Id_centro_regional, fecha_creacion, documento, Id_facultad, tipo, correo) 
                VALUES ('$id_persona','$razon', 'pendiente', 'nuevo', '$centro', now(), '$documento','$facultad', 'interno','$correo');";

                
              
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
                        confirmButtonText:"Aceptar",
                        cancelButtonText:"Cancelar",
                        }).then(function () {
                        window.location.href = "../Controlador/reporte_revision_cambio_carrera_controlador.php?servicio='.$ultimo_id_hash.'";
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
    }elseif(isset($_POST['txt_nombre']) && $_POST['txt_nombre']!==""  && $_POST['txt_cuenta']!=="" && $_POST['txt_correo']!==""
    
    && isset($_POST['txt_simultanea']) && $_POST['txt_simultanea']!==""){ 

        if($_FILES['txt_historial']['name']!=null  && $_FILES['txt_identidad']['name']!=null
        &&  $_FILES['txt_carne']['name']!=null && $_FILES['txt_solicitud']['name']!=null
        ){
            
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
    
                $documento_nombre[] = $_FILES['txt_historial']['name'];
                  //  $documento_nombre[] = $_FILES['txt_voae']['name'];
                    $documento_nombre[] = $_FILES['txt_identidad']['name'];
                  //  $documento_nombre[] = $_FILES['txt_foto']['name'];
                    $documento_nombre[] = $_FILES['txt_carne']['name'];
                    $documento_nombre[] = $_FILES['txt_solicitud']['name'];

                    $documento_nombre_temporal[] = $_FILES['txt_historial']['tmp_name'];
                   // $documento_nombre_temporal[] = $_FILES['txt_voae']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_identidad']['tmp_name'];
                   // $documento_nombre_temporal[] = $_FILES['txt_foto']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_carne']['tmp_name'];
                    $documento_nombre_temporal[] = $_FILES['txt_solicitud']['tmp_name'];
    
        
                    $micarpeta = '../archivos/cambio/simultanea/'.$cuenta;
                    if (!file_exists($micarpeta)) {
                         mkdir($micarpeta, 0777, true);
                        }else{
                            $documento = glob('../archivos/cambio/simultanea/'.$cuenta.'/*'); // obtiene los documentos
                            foreach($documento as $documento){ // itera los documentos
                            if(is_file($documento)) 
                            unlink($documento); // borra los documentos
                            } 
                        }
                    for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                        
                        move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                        $ruta= '../archivos/cambio/simultanea/'.$cuenta."/".$documento_nombre[$i];
                        $direccion[]= $ruta;
                    }
                    $documento = json_encode($direccion);
                  
                    
                    $sql = "INSERT INTO tbl_cambio_carrera( id_persona, razon_cambio, observacion, aprobado, Id_centro_regional, fecha_creacion, documento, Id_facultad, tipo, correo) 
                VALUES ('$id_persona','N/A', 'pendiente', 'nuevo', 0, now(), '$documento',0, 'simultanea','$correo');";

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
                            confirmButtonText:"Aceptar",
                            cancelButtonText:"Cancelar",
                            }).then(function () {
                            window.location.href = "../Controlador/reporte_revision_suficiencia_controlador.php?servicio='.$ultimo_id_hash.'";
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
            
            
        else if(isset($_POST['aprobado']) && $_POST['aprobado']!==""){

        $aprobado = $_POST['aprobado'];
        $cuenta = $_POST['txt_cuenta'];
        $observacion = $_POST['txt_observacion'];
        $id_cambio = $_POST['Id_cambio'];
       

        ($aprobado=="aprobado")? $estado=2:$estado=3;
      
        
        if($observacion!==""){
            // $sqlp = "call upd_carta_egresado_observacion('$aprobado','$observacion','$cuenta')";
             
            $sql = "UPDATE tbl_cambio_carrera 
            SET aprobado = '$aprobado', fecha_creacion = now(),
            observacion = '$observacion'
            WHERE Id_cambio = '$id_cambio'";
 
           
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
                            window.location.href = "menu_revision_cambio.php";
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
    
    
    
    





<?php
	