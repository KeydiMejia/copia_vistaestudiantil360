
<?php
     
    require_once ('../clases/Conexion.php');
    /*
        if(isset($_POST['txt_nombre']) && $_POST['txt_nombre']!==""  && $_POST['txt_cuenta']!=="" && $_POST['txt_correo']!=="" 
            && isset($_POST['txt_codigo']) && $_POST['txt_codigo']!==""){
            
            $cuenta= $_POST['txt_cuenta'];
            $correo = $_POST['txt_correo'];
            $verificado1 = $_POST['txt_verificado1'];
            $verificado2 = $_POST['txt_verificado2'];
          //  $observacion = $_POST['txt_observacion'];
    
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
                    
                    
                    $micarpeta = '../archivos/suficiencia/codigo/'.$cuenta;
                    if (!file_exists($micarpeta)) {
                         mkdir($micarpeta, 0777, true);
                        }else{
                            $documento = glob('../archivos/suficiencia/codigo/'.$cuenta.'/*'); // obtiene los documentos
                            foreach($documento as $documento){ // itera los documentos
                            if(is_file($documento)) 
                            unlink($documento); // borra los documentos
                            } 
                        }
                    for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                        
                        move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                        $ruta= '../archivos/suficiencia/codigo/'.$cuenta."/".$documento_nombre[$i];
                        $direccion[]= $ruta;
                    }
                    $documento = json_encode($direccion);
    
                     if($verificado1!=="" && $verificado2!==""){
                  
                    $id_persona=$data['id_persona'];
                   
                   $sqlp= "INSERT INTO  tbl_examen_suficiencia (id_persona,fecha_creacion,documento ,observacion, id_estado_suficiencia,correo,tipo)
                                                        VALUES ('$id_persona', current_timestamp(),'$documento', 'Revisión pendiente','1','$correo','codigo')";

    
                    $resultadop = $mysqli->query($sqlp);
                    if($resultadop == true){
                        echo '<script type="text/javascript">
                                swal({
                                    title:"¿Deseas ver reporte en PDF?",
                                    text:"Solicitud enviada...",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 1500
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
        }
    */

    if(isset($_POST['txt_nombre']) && $_POST['txt_nombre']!==""  && $_POST['txt_cuenta']!=="" && $_POST['txt_correo']!==""&& $_POST['txt_nombre']!==""
    && isset($_POST['txt_contenido']) && $_POST['txt_contenido']!==""){ 
       
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
    
                $micarpeta = '../archivos/suficiencia/contenido/'.$cuenta;
                if (!file_exists($micarpeta)) {
                     mkdir($micarpeta, 0777, true);
                    }else{
                        $documento = glob('../archivos/suficiencia/contenido/'.$cuenta.'/*'); // obtiene los documentos
                        foreach($documento as $documento){ // itera los documentos
                        if(is_file($documento)) 
                        unlink($documento); // borra los documentos
                        } 
                    }
                for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                    
                    move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                    $ruta= '../archivos/suficiencia/contenido/'.$cuenta."/".$documento_nombre[$i];
                    $direccion[]= $ruta;
                }
                $documento = json_encode($direccion);
              
                
                $sql= "INSERT INTO tbl_examen_suficiencia(id_persona,fecha_creacion,documento,observacion,id_estado_suficiencia,tipo,correo)
                VALUES ('$id_persona',current_timestamp(),'$documento', 'Nuevo',1,'contenido','$correo')";
    
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
    }elseif(isset($_POST['txt_nombre']) && $_POST['txt_nombre']!==""  && $_POST['txt_cuenta']!=="" && $_POST['txt_correo']!==""&& $_POST['txt_nombre']!==""
        && isset($_POST['txt_codigo']) && $_POST['txt_codigo']!==""){ 
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
        
                    $micarpeta = '../archivos/suficiencia/codigo/'.$cuenta;
                    if (!file_exists($micarpeta)) {
                         mkdir($micarpeta, 0777, true);
                        }else{
                            $documento = glob('../archivos/suficiencia/codigo/'.$cuenta.'/*'); // obtiene los documentos
                            foreach($documento as $documento){ // itera los documentos
                            if(is_file($documento)) 
                            unlink($documento); // borra los documentos
                            } 
                        }
                    for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
                        
                        move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                        $ruta= '../archivos/suficiencia/codigo/'.$cuenta."/".$documento_nombre[$i];
                        $direccion[]= $ruta;
                    }
                    $documento = json_encode($direccion);
                  
                    
                    $sql= "INSERT INTO tbl_examen_suficiencia(id_persona,fecha_creacion,documento,observacion,id_estado_suficiencia,tipo,correo)
                    VALUES ('$id_persona',current_timestamp(),'$documento', 'Nuevo',1,'codigo','$correo')";
        
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
        $id_suficiencia=$_POST['id_suficiencia'];
        
        ($aprobado=="aprobado")? $estado=2:$estado=3;
    
        
        
        if($observacion!==""){
            // $sqlp = "call upd_carta_egresado_observacion('$aprobado','$observacion','$cuenta')";
             
            $sql = "UPDATE tbl_examen_suficiencia SET observacion='$observacion',id_estado_suficiencia='$estado'  WHERE id_suficiencia='$id_suficiencia'";
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
                            window.location.href = "revision_suficiencia_vista.php";
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
    
    
    
    