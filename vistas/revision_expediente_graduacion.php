<?php

require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=36; 
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
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A REVISION LISTA CARTA DE EGRESADO');
}
  
$counter = 0;
// $sql_tabla = json_decode( file_get_contents('http://informaticaunah.com/automatizacion/api/carta_egresado.php'), true );

// $sql_tabla = json_decode( file_get_contents('http://localhost/copia_automatizacion/copia_vistaestudiantil360/api/equivalencias.php'), true );
//localhost:8008/copia_vistaestudiantil360/vistas/revision_expediente_graduacion.php
$sql_tabla = json_decode( file_get_contents('http://localhost/copia_automatizacion/copia_vistaestudiantil360/api/expediente_graduacion.php'), true );


?>



<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>


<body >


    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">


            <h1>Solicitudes de Expediente de Graduación</h1>
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
            </div>
            <!-- /.card-header -->
            <div class="card-body">

            <div class="dt-buttons btn-group ml-4 mb-2">
                  <button class="btn btn-secondary buttons-pdf buttons-html5 btn-danger"   onclick="pdf_expediente()" title="Exportar a PDF">
                      <i class="fas fa-file-pdf">
                      </i>
                  </button>
              </div>
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NOMBRE</th>
                  <th># DE CUENTA</th>
                  <th>ESTADO</th>
                  <th>FECHA</th>
                  <th>REVISAR SOLICITUD</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  if($sql_tabla["ROWS"]!=""){
                    
                  while($counter < count($sql_tabla["ROWS"])) { 
                    
                    $estado=$sql_tabla["ROWS"][$counter]["id_estado_expediente"];
                    
                    
                    if ($estado==2) {
                      $banner= "Aprobado";
                      $mostrarEstado= "<span class='badge badge-pill badge-success d-block'>$banner</span>";
                    }
                    elseif($estado==1){
                      $banner= "Nuevo";
                      $mostrarEstado= "<span class='badge badge-pill badge-info d-block'>$banner</span>";  

                    }else{
                      $banner= "Desaprobado";
                      $mostrarEstado= "<span class='badge badge-pill badge-warning d-block'>$banner</span>";  
                    }

                    
                    
                    ?>
                <tr>
                <td><?php echo $sql_tabla["ROWS"][$counter]["nombres"].' '.$sql_tabla["ROWS"][$counter]["apellidos"] ?></td>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["valor"]  ?></td>
                <td><?php echo  $mostrarEstado ?></td>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["fecha_creacion"]  ?></td>  
                <td style="text-align: center;">                    
                
                <!-- <a href="../vistas/revision_carta_egresado_unica_vista.php?alumno=<?php echo $sql_tabla["ROWS"][$counter]["valor"]; ?>" class="btn btn-primary btn-raised btn-xs"> -->


                    <a href="../vistas/revision_expediente_graduacion_unica.php?alumno=<?php echo $sql_tabla["ROWS"][$counter]["id_expediente"]; ?>" class="btn btn-primary btn-raised btn-xs">

                    <i class="far fa-check-circle"></i>
                    </a>

                    <a href="../Controlador/Reporte_especialidades.php?id_expediente=<?php echo base64_encode($sql_tabla["ROWS"][$counter]["id_expediente"]); ?>" target="_blank" class="btn btn-danger btn-raised btn-xs">
                      <i class="fas fa-file-pdf    "></i>
                    </a>
                </td>
               </tr>
                 <?php $counter = $counter + 1; }} ?>
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

<script src="../js/Reportes_solicitudes.js"></script>
</body>
</html>
