<?php

require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=35; 
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
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A REVISION LISTA CAMBIO DE CARRERA SIMULTANEA');
}
$tipo= $_GET['tipo'];
$counter = 0;
$sql_tabla = json_decode( file_get_contents('http://localhost/copia_automatizacion/copia_vistaestudiantil360/api/carrera_simultanea.php?tipo='.$tipo), true );


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


            <h1>Solicitudes de Cambio de Carrera Suficiencia</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item"><a href="../vistas/menu_revision_cambio.php">Solicitudes</a></li>
              
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
              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NOMBRE</th>
                  <th># DE CUENTA</th>
                  <th>CORREO</th>
                  <th>APROBADO</th>
                  <th>TIPO</th>
                  <th>OBSERVACION</th>
                  <th>REVISAR SOLICITUD</th>
                  </tr>
                </thead>
                <tbody>

                
                  <?php 
                  if($sql_tabla["ROWS"]!=""){
                  while($counter< count($sql_tabla["ROWS"])) { 
                    
                        $estado=$sql_tabla["ROWS"][$counter]["Id_cambio"];
                        
                        if ($estado==2) {
                          $banner ="Aprobado";
                          $mostrarEstado= "<span class='badge badge-pill badge-success d-block'>$banner</span>";
                        }
                        elseif($estado==1){
                          $banner ="Nuevo";
                          $mostrarEstado= "<span class='badge badge-pill badge-info d-block'>$banner</span>";  
    
                        }else{
                          $banner ="Desaprobado";
                          $mostrarEstado= "<span class='badge badge-pill badge-warning d-block'>$banner</span>";  
                        }
                        
                      ?>
                <tr>
                <td><?php echo $sql_tabla["ROWS"][$counter]["nombres"].' '.$sql_tabla["ROWS"][$counter]["apellidos"] ?></td>
                <td><?php echo $sql_tabla["ROWS"][$counter]["valor"]?></td>
                <td><?php echo $sql_tabla["ROWS"][$counter]["correo"] ?></td>  
                <td><?php echo $sql_tabla["ROWS"][$counter]["aprobado"] ?></td>  
                <td><?php echo $sql_tabla["ROWS"][$counter]["tipo"] ?></td>  
                <td><?php echo $sql_tabla["ROWS"][$counter]["observacion"] ?></td>     
                <td style="text-align: center;">                    
                    <a href="../vistas/revision_cambio_unico_simultanea.php?alumno=<?php echo $sql_tabla["ROWS"][$counter]["Id_cambio"] ?>&tipo=<?php echo $tipo?>" class="btn btn-primary btn-raised btn-xs">
                    <i class="far fa-check-circle"></i>
                    </a>
                </td>
               </tr>
                 <?php  $counter = $counter + 1; }} ?>
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