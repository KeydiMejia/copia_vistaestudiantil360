
<?php
	
require_once ('../clases/Conexion.php');

if(isset($_POST['txt_nombre']) && $_POST['txt_nombre']!==""  && $_POST['txt_cuenta']!=="" && $_POST['txt_correo']!==""){ 
   
    if($_FILES['txt_solicitud']['name']!=null && $_FILES['txt_historial']['name']!=null){
            
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

            $micarpeta = '../archivos/expediente_graduacion/'.$cuenta;
                if (!file_exists($micarpeta)) {
                        mkdir($micarpeta, 0777, true);

                }else{
                        $documento = glob('../archivos/expediente_graduacion/'.$cuenta.'/*'); // obtiene los documentos
                        
                        foreach($documento as $documento){ // itera los documentos
                           
                            if(is_file($documento)) 
                            unlink($documento); // borra los documentos
                        }
                    }
            for ($i = 0; $i <=count($documento_nombre_temporal)-1 ; $i++) {
            
                move_uploaded_file($documento_nombre_temporal[$i],"$micarpeta/$documento_nombre[$i]");
                $ruta= '../archivos/expediente_graduacion/'.$cuenta.'/'.$documento_nombre[$i];
                $direccion[]= $ruta;
            }
            $documento = json_encode($direccion);
            
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
            
            
            $sql= "INSERT INTO tbl_expediente_graduacion (id_persona, fecha_creacion,documento,observacion,id_estado_expediente)
            VALUES ('$id_persona', current_timestamp(), '$documento','Nuevo',1)";

            $resultadop = $mysqli->query($sql);
            if($resultadop == true){
                echo '<script type="text/javascript">
                                swal({
                                    title:"",
                                    text:"Solicitud enviada...",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 1500
                                    });
                                    $(".FormularioAjax")[0].reset();
                                    </script>'; 
                
                }else { 
                                
                    // echo "Error: " . $sql ;
                    echo '<script type="text/javascript">
                                swal({
                                    title:"Solicitud ya existe",
                                    text:"Para editar tu solicitud visita Perfil 360 Estudiantil",
                                    type: "info",
                                    showConfirmButton: false,
                                    timer: 5000
                                    });
                                    $(".FormularioAjax")[0].reset();
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
    $id_expediente=$_POST['id_expediente'];
    
    ($aprobado=="aprobado")? $estado=2:$estado=3;

    
    
    if($observacion!==""){
        // $sqlp = "call upd_carta_egresado_observacion('$aprobado','$observacion','$cuenta')";
         
        $sql = "UPDATE tbl_expediente_graduacion SET observacion='$observacion',id_estado_expediente='$estado'  WHERE id_expediente='$id_expediente'";
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
                        window.location.href = "revision_expediente_graduacion.php";
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


