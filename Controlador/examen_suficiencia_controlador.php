
<?php
     
    require_once ('../clases/Conexion.php');
    
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
    
        }elseif(isset($_POST['txt_contenido']) && $_POST['txt_contenido']!=="" && $_POST['txt_nombre']!=="" 
         && $_POST['txt_cuenta']!=="" && $_POST['txt_correo']!==""){
            $cuenta=$_POST['txt_cuenta'];
            $verificado1 = $_POST['txt_verificado1'];
            $verificado2 = $_POST['txt_verificado2'];
            $correo = $_POST['txt_correo'];
    
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
    
                     if($verificado1!=="" && $verificado2!==""){
                   
                   
                    $id_persona=$data['id_persona'];
                   
                    $sqlp= "INSERT INTO  tbl_examen_suficiencia (id_persona,fecha_creacion,documento,observacion,id_estado_suficiencia,correo,tipo)
                    VALUES ('$id_persona',current_timestamp(),'$documento', 'Revisión pendiente','1','$correo','contenido')";
                    
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
                                    window.open("../Controlador/reporte_revision_suficiencia_controlador.php");
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
                                text:"Faltan documentos por subir....",
                                type: "error",
                                showConfirmButton: false,
                                timer: 1500
                                });
                                $(".FormularioAjax")[0];
                            </script>';
                }
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
    
        }else if(isset($_POST['aprobado']) && $_POST['aprobado']!==""){
            $documento = $_POST['documento'];
            $cuenta = $_POST['txt_cuenta1'];
            $observacion = $_POST['txt_observacion'];
            
    
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
               
                 $sqlp = "UPDATE `tbl_examen_suficiencia` 
                SET `fecha_creacion` = now(), 
                observacion = '$observacion'
                WHERE id_persona = '$id'
                AND tipo = '$tipo'"; 
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
                                window.location.href = "revision_suficiencia_vista.php";
                                });
                                $(".FormularioAjax")[0].reset();
                            </script>'; 
                     } 
                else {
                    echo "Error: " . $sqlp ;
                    }
    
            }else{
                
                $sqlp = "UPDATE `tbl_examen_suficiencia `
                SET `fecha_creacion` = now(), 
                observacion = '$observacion'
                WHERE id_persona = '$id'
                AND tipo = '$tipo'";
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
                                window.location.href = "revision_suficiencia_vista.php";
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
    
    