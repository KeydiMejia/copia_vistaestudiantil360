<?php

require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=151; 
$visualizacion= permiso_ver($Id_objeto);
if($visualizacion==0){
  echo '<script type="text/javascript">
  swal({
        title:"",
        text:"Lo sentimos no tiene permiso de visualizar la pantalla",
        type: "error",
        showConfirmButton: false,
        timer: 3000
      });
  window.location = "../vistas/pagina_principal_vista.php";

   </script>'; 
}else{
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A REVISION SERVICIO COMUNITARIO');
}
  
$counter = 0;
// $sql_tabla = json_decode( file_get_contents('http://informaticaunah.com/automatizacion/api/carta_egresado.php'), true );

// $sql_tabla = json_decode( file_get_contents('http://localhost/copia_automatizacion/copia_vistaestudiantil360/api/equivalencias.php'), true );
// http://localhost:8008/copia_vistaestudiantil360/vistas/revision_expediente_graduacion.php
$sql_tabla = json_decode( file_get_contents('http://localhost/copia_automatizacion/copia_vistaestudiantil360/api/servicio_comunitario.php'), true );


/* Manda a llamar datos de la tabla para llenar la tabla suficiencia  */
$sql=$mysqli->prepare("SELECT s.id_suficiencia,s.id_persona,s.fecha_creacion,
s.documento,s.observacion,s.id_estado_suficiencia,s.correo,e.descripcion,p.nombres,p.apellidos, pe.valor
FROM tbl_estado_suficiencia e, tbl_examen_suficiencia s, tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
WHERE pe.id_persona = p.id_persona
AND p.id_persona = u.id_persona
AND s.id_persona = p.id_persona
AND e.id_estado_suficiencia = s.id_estado_suficiencia
AND u.Usuario = ?");
$sql->bind_param("s",$_SESSION['usuario']);
$sql->execute();
$resultadotabla = $sql->get_result();
$row = $resultadotabla->fetch_array(MYSQLI_ASSOC);

/* Manda a llamar datos de la tabla para llenar la tabla historial de reactivacion  */
$sql=$mysqli->prepare("SELECT s.id_reactivacion,s.id_persona,s.fecha_creacion,
s.documento,s.observacion,s.id_estado_reactivacion,s.correo,e.descripcion,p.nombres,p.apellidos, pe.valor
FROM tbl_estado_reactivacion e, tbl_reactivacion_cuenta s, tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
WHERE pe.id_persona = p.id_persona
AND p.id_persona = u.id_persona
AND s.id_persona = p.id_persona
AND e.id_estado_reactivacion = s.id_estado_reactivacion
AND u.Usuario = ?");
$sql->bind_param("s",$_SESSION['usuario']);
$sql->execute();
$resultadotabla = $sql->get_result();
$row1 = $resultadotabla->fetch_array(MYSQLI_ASSOC);

/* Manda a llamar datos de la tabla para llenar la tabla historial de Cambio de carrera  */
$sql=$mysqli->prepare("SELECT s.id_cambio,s.id_persona,s.observacion,aprobado,s.fecha_creacion,
s.documento,p.nombres,p.apellidos, pe.valor,s.correo
FROM  tbl_cambio_carrera s, tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
WHERE pe.id_persona = p.id_persona
AND p.id_persona = u.id_persona
AND s.id_persona = p.id_persona
AND u.Usuario = ?");
$sql->bind_param("s",$_SESSION['usuario']);
$sql->execute();
$resultadotabla = $sql->get_result();
$row2 = $resultadotabla->fetch_array(MYSQLI_ASSOC);

/* Manda a llamar datos de la tabla para llenar la tabla historial de carta de egresado */
$sql=$mysqli->prepare("SELECT s.id_carta,s.id_persona,s.observacion,s.fecha_creacion,s.aprobado,
s.documento,s.correo,p.nombres,p.apellidos, pe.valor
FROM tbl_carta_egresado s,  tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
WHERE pe.id_persona = p.id_persona
AND p.id_persona = u.id_persona
AND s.id_persona = p.id_persona
AND u.Usuario = ?");
$sql->bind_param("s",$_SESSION['usuario']);
$sql->execute();
$resultadotabla = $sql->get_result();
 $row3 = $resultadotabla->fetch_array(MYSQLI_ASSOC);


/* Manda a llamar datos de la tabla para llenar la tabla historial pre-equivalencias  */
$sql=$mysqli->prepare("SELECT s.id_equivalencia,s.id_persona,s.observacion,s.Fecha_creacion,s.aprobado,
s.documento,s.correo,p.nombres,p.apellidos, pe.valor
FROM tbl_equivalencias s,  tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
WHERE pe.id_persona = p.id_persona
AND p.id_persona = u.id_persona
AND s.id_persona = p.id_persona
AND u.Usuario = ?");
$sql->bind_param("s",$_SESSION['usuario']);
$sql->execute();
$resultadotabla = $sql->get_result();
$row4 = $resultadotabla->fetch_array(MYSQLI_ASSOC);

/* Manda a llamar datos de la tabla para llenar la tabla historial de cancelacion de clases  */
$sql=$mysqli->prepare("SELECT s.id_cancelar_clases,s.id_persona,s.fecha_creacion,
s.documento,s.cambio,s.correo,p.nombres,p.apellidos, pe.valor
FROM tbl_cancelar_clases s,  tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
WHERE pe.id_persona = p.id_persona
AND p.id_persona = u.id_persona
AND s.id_persona = p.id_persona
AND u.Usuario = ?");
$sql->bind_param("s",$_SESSION['usuario']);
$sql->execute();
$resultadotabla = $sql->get_result();
$row5 = $resultadotabla->fetch_array(MYSQLI_ASSOC);



/* Manda a llamar datos de la tabla para llenar la tabla historial de expediente de graduacion  */
$sql=$mysqli->prepare("SELECT s.id_expediente,s.id_persona,s.fecha_creacion,
 s.documento,s.observacion,s.id_estado_expediente,s.correo,e.descripcion,p.nombres,p.apellidos, pe.valor
 FROM tbl_estado_expediente e, tbl_expediente_graduacion s, tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
 WHERE pe.id_persona = p.id_persona
 AND p.id_persona = u.id_persona
 AND s.id_persona = p.id_persona
 AND e.id_estado_expediente = s.id_estado_expediente
 AND u.Usuario =? ");
 $sql->bind_param("s",$_SESSION['usuario']);
 $sql->execute();
$resultadotabla = $sql->get_result();
$row6 = $resultadotabla->fetch_array(MYSQLI_ASSOC);


/* Manda a llamar datos de la tabla para llenar la tabla historial de servicio comunitario  */
$sql=$mysqli->prepare("SELECT s.id_servicio_comunitario,s.id_persona,s.fecha_creacion,
s.id_estado_servicio,s.correo,e.descripcion,p.nombres,p.apellidos, pe.valor
FROM tbl_estado_servicio e, tbl_servicio_comunitario s, tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
WHERE pe.id_persona = p.id_persona
AND p.id_persona = u.id_persona
AND s.id_persona = p.id_persona
AND e.id_estado_servicio = s.id_estado_servicio
AND u.Usuario = ?");
$sql->bind_param("s",$_SESSION['usuario']);
$sql->execute();
$resultadotabla = $sql->get_result();
$row7 = $resultadotabla->fetch_array(MYSQLI_ASSOC);
?>



<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../plugins/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
<link rel=" stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">
  <title></title>
</head>


<body >


    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">


            <h1>Historial de Solicitudes</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>
   

<!--Pantalla 2-->


 
              <div class="card card-default">
                          <div class="card-header">
                            <h3 class="card-title">Solicitudes</h3>
                            <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                          </div>
                          <br>
                      <div class=" px-12">
                        <!-- <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()">Exportar a PDF</a> </button> -->
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="dt-buttons btn-group">
                        <button class="btn btn-secondary buttons-pdf buttons-html5 btn-danger" tabindex="0" aria-controls="tabla" type="buttton" onclick="ventana()" title="Exportar a PDF">
                        <i class="fas fa-file-pdf"></i>
        </button>
        </div>
        <br></br>
              <table id="tabla" class="table table-bordered table-striped">
              <thead>
            <tr>
            <tr class="bg-basic">
			      <th> TIPO SOLICITUD </th>
            <th> NOMBRE </th>
            <th> # CUENTA </th>
            <th> CORREO </th>
            <th> ESTADO</th>
            <th> FECHA</th>
            <th> CANCELAR SOLICITUD </th>
            </tr>
             </thead>
              <tbody>
                  
                <tr>
                <th>EXAMEN SUFICIENCIA</th>
                <td><?php echo $row['nombres'].' '.$row['apellidos'] ?></td> 
                <td><?php echo $row['valor'] ?></td>
                <td><?php echo $row['correo'] ?></td>
                <td><?php echo $row['descripcion'] ?></td>
                <td><?php echo $row['fecha_creacion'] ?></td>  
                <form action="../Controlador/cancelar_solicitud_controlador.php?id_reactivacion=<?php echo $row1['id_reactivacion']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                <td><button type="submit" class="btn btn-danger btn-raised btn-xs">
                <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['cancelar_solicitud'] ?> "></i>
                </button><td>    
                <div class="RespuestaAjax"></div>
                </form>
                <td style="text-align: center;">  
                  </tr>
                  
                  <th>REACTIVACION DE CUENTA</th>
                  <td><?php echo $row1['nombres'].' '.$row1['apellidos'] ?></td> 
                  <td><?php echo $row1['valor'] ?></td>
                  <td><?php echo $row1['correo'] ?></td>
                  <td><?php echo $row1['descripcion'] ?></td>
                  <td><?php echo $row1['fecha_creacion'] ?></td>
                  <form action="../Controlador/cancelar_solicitud_controlador.php?id_reactivacion=<?php echo $row1['id_reactivacion']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                  <td><button type="submit" class="btn btn-danger btn-raised btn-xs">
                  <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['cancelar_solicitud'] ?> "></i>
                  </button><td>  
                  <div class="RespuestaAjax"></div>
                </form>
                  <td style="text-align: center;">  
                  </tr>

                  <tr>
                  <th>CAMBIO DE CARRERA</th>
                  <td><?php echo $row2['nombres'].' '.$row2['apellidos'] ?></td> 
                  <td><?php echo $row2['valor'] ?></td>
                  <td><?php echo $row1['correo'] ?></td>
                  <td><?php echo $row2['aprobado'] ?></td>
                  <td><?php echo $row2['fecha_creacion'] ?></td>
                  <form action="../Controlador/cancelar_solicitud_controlador.php?id_reactivacion=<?php echo $row1['id_reactivacion']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                  <td><button type="submit" class="btn btn-danger btn-raised btn-xs">
                  <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['cancelar_solicitud'] ?> "></i>
                  </button><td>    
                  <td style="text-align: center;">  
                  </tr>
                  <tr>
                  <th>CARTA EGRESADO</th>
                  <td><?php echo $row3['nombres'].' '.$row3['apellidos'] ?></td> 
                  <td><?php echo $row3['valor'] ?></td>
                  <td><?php echo $row3['correo'] ?></td>
                  <td><?php echo $row3['aprobado'] ?></td>
                  <td><?php echo $row3['fecha_creacion'] ?></td>
                  <form action="../Controlador/cancelar_solicitud_controlador.php?id_reactivacion=<?php echo $row1['id_reactivacion']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                  <td><button type="submit" class="btn btn-danger btn-raised btn-xs">
                  <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['cancelar_solicitud'] ?> "></i>
                  </button><td>    

                  <td style="text-align: center;">  
                  </tr>

                
                  <tr>
                  <th>PRE-EQUIVALENCIA</th>
                  <td><?php echo $row4['nombres'].' '.$row4['apellidos'] ?></td> 
                  <td><?php echo $row4['valor'] ?></td>
                  <td><?php echo $row4['correo'] ?></td>
                  <td><?php echo $row4['aprobado'] ?></td>
                  <td><?php echo $row4['Fecha_creacion'] ?></td>
                  <form action="../Controlador/cancelar_solicitud_controlador.php?id_reactivacion=<?php echo $row1['id_reactivacion']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                  <td><button type="submit" class="btn btn-danger btn-raised btn-xs">
                  <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['cancelar_solicitud'] ?> "></i>
                  </button><td>    
                  <td style="text-align: center;">  
                  </tr>

                  <tr>
                  <th>CANCELACION DE CLASES</th>
                  <td><?php echo $row5['nombres'].' '.$row5['apellidos'] ?></td> 
                  <td><?php echo $row5['valor'] ?></td>
                  <td><?php echo $row5['correo'] ?></td>
                  <td><?php echo $row5['cambio'] ?></td>
                  <td><?php echo $row5['fecha_creacion'] ?></td>
                  <form action="../Controlador/cancelar_solicitud_controlador.php?id_reactivacion=<?php echo $row1['id_reactivacion']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                  <td><button type="submit" class="btn btn-danger btn-raised btn-xs">
                  <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['cancelar_solicitud'] ?> "></i>
                  </button><td>    
                  <td style="text-align: center;">  
                  </tr>

                  <tr>
                  <th>EXPEDIENTE DE GRADUACION</th>
                  <td><?php echo $row6['nombres'].' '.$row6['apellidos'] ?></td> 
                  <td><?php echo $row6['valor'] ?></td>
                  <td><?php echo $row6['correo'] ?></td>
                  <td><?php echo $row6['descripcion'] ?></td>
                  <td><?php echo $row6['fecha_creacion'] ?></td>
                  <form action="../Controlador/cancelar_solicitud_controlador.php?id_reactivacion=<?php echo $row1['id_reactivacion']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                  <td><button type="submit" class="btn btn-danger btn-raised btn-xs">
                  <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['cancelar_solicitud'] ?> "></i>
                  </button><td>    
                  <td style="text-align: center;">  
                  </tr>
                  
                  <tr>
                  <th>SERVICIO COMUNITARIO</th>
                  <td><?php echo $row7['nombres'].' '.$row7['apellidos'] ?></td> 
                  <td><?php echo $row7['valor'] ?></td>
                  <td><?php echo $row7['correo'] ?></td>
                  <td><?php echo $row7['descripcion'] ?></td>
                  <td><?php echo $row7['fecha_creacion'] ?></td>
                  <form action="../Controlador/cancelar_solicitud_controlador.php?id_reactivacion=<?php echo $row1['id_reactivacion']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                  <td><button type="submit" class="btn btn-danger btn-raised btn-xs">
                  <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['cancelar_solicitud'] ?> "></i>
                  </button><td>    
                  <td style="text-align: center;">  
                  </tr>
                
                 
                <!-- <tr>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["id_servicio_comunitario"]  ?></td>
                <td><?php echo $sql_tabla["ROWS"][$counter]["nombres"].' '.$sql_tabla["ROWS"][$counter]["apellidos"] ?></td>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["valor"]  ?></td>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["correo"]  ?></td>
                <td><?php echo  $mostrarEstado ?></td>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["fecha_creacion"]  ?></td>  
                <td style="text-align: center;">                     -->
                
                <!-- <a href="../vistas/revision_carta_egresado_unica_vista.php?alumno=<?php echo $sql_tabla["ROWS"][$counter]["valor"]; ?>" class="btn btn-primary btn-raised btn-xs"> -->
                <!-- <td style="text-align: center;">

                <form action="../Controlador/cancelar_solicitud_controlador.php?id_solicitud=<?php echo $row['estado']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                    <button type="submit" class="btn btn-danger btn-raised btn-xs">

                        <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['eliminar_estado'] ?> "></i>
                    </button>
                    <div class="RespuestaAjax"></div>
                </form>
                </td> -->

                 <!--    <a href="../vistas/revision_servicio_comunitario_unica_vista.php?alumno=<?php echo $sql_tabla["ROWS"][$counter]["id_servicio_comunitario"]; ?>" class="btn btn-primary btn-raised btn-xs">

                    <i class="far fa-check-circle"></i>
                    </a>
                </td> -->
               
             </tbody>
            </table>
            
         </div>
            <!-- /.card-body -->
          </div>

        
          <!-- /.card-body -->
          <div class="card-footer">
            
          </div>
        </div>

</div>





</section>

</div>
    </form>


    <script type="text/javascript">
  

  $(function () {
    
     $('#tabla').DataTable({
         "language":{
             "url":"../plugins/lenguaje.json"},
       "paging": true,
       "lengthChange": true,
       "searching": true,
       "ordering": true,
       "info": true,
       "autoWidth": true,
       "responsive": true,
     });
   });
 
 
 </script>

</body>
</html>
<script type="text/javascript" language="javascript">
  function ventana() {
    window.open("../Controlador/reporte_servicio_comunitario_controlador.php", "REPORTE");
  }
</script>

<!-- <script type="text/javascript" src="../js/funciones_mantenimientos.js"></script> -->

<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>