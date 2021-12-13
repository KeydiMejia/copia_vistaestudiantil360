<?php

require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=146; 
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
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A REVISION LISTA REACTIVACION DE CUENTAS');
}


$counter = 0;
//$url="http://localhost/copia_vistaestudiantil360/api/cancelar_clases.php";
//$url = "http://localhost/copia_automatizacion/copia_vistaestudiantil360/api/reactivacion_cuenta.php";
$sql_tabla = json_decode( file_get_contents('http://localhost/copia_automatizacion\copia_vistaestudiantil360/api/reactivacion_cuenta.php'), true );



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


            <h1>Solicitudes de Reactivacion de Cuenta</h1>
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
          <i class="fas fa-file-pdf">
</i>
        </button>
        </div>
        <br></br>

              <table id="tabla" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>NOMBRE</th>
               
                  <th>CORREO</th>
                  <th>OBSEVACION</th>
                  <th>ESTADO</th>
                  
                  <th>FECHA</th>
                  <th>REVISAR SOLICITUD</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                
                    
                    
                    if($sql_tabla["ROWS"]!=""){
                  
                      while($counter < count($sql_tabla["ROWS"])) { 
                        
                        $estado=$sql_tabla["ROWS"][$counter]["id_estado_reactivacion"];
                       
                        
                        if ($estado==2) {
                          $banner= "Aprobado";
                          $mostrarEstado= "<span class='badge badge-pill badge-success d-block'>$banner</span>";
                        }
                        elseif($estado==1){
                          $banner= "Nueva";
                          $mostrarEstado= "<span class='badge badge-pill badge-info d-block'>$banner</span>";  
    
                        }else{
                          $banner= "Desaprobado";
                          $mostrarEstado= "<span class='badge badge-pill badge-warning d-block'>$banner</span>";  
                        }
                    ?>
                 <!-- <tr>
                <td><?php echo $sql_tabla["ROWS"][$counter]["nombres"].' '.$sql_tabla["ROWS"][$counter]["apellidos"] ?></td>
                <td><?php echo $sql_tabla["ROWS"][$counter]["valor"] ?></td>
                <td><?php echo $sql_tabla["ROWS"][$counter]["correo"] ?></td>         
                <td style="text-align: center;">                    
                    <a href="../vistas/revision_cancelar_clases_unica.php?alumno=<?php echo $sql_tabla["ROWS"][$counter]["valor"]; ?>" class="btn btn-primary btn-raised btn-xs">
                    <i class="far fa-check-circle"></i>
                    </a>
                </td>
                </tr> -->
                <tr>
                
                <td><?php echo  $sql_tabla["ROWS"][$counter]["nombres"].' '.$sql_tabla["ROWS"][$counter]["apellidos"] ?></td>
                
                <td><?php echo  $sql_tabla["ROWS"][$counter]["correo"]  ?></td>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["observacion"]  ?></td>
                
                <td><?php echo $mostrarEstado ?></td> 
                <td><?php echo  $sql_tabla["ROWS"][$counter]["fecha_creacion"]  ?></td>
                <td style="text-align: center;">                    
                    <a href="../vistas/revision_reactivacion_unica.php?alumno=<?php echo $sql_tabla["ROWS"][$counter]["id_reactivacion"]; ?>" class="btn btn-primary btn-raised btn-xs">
                    <i class="far fa-check-circle"></i>
                    </a>
                  
                  <a href="../Controlador/Reporte_especialidades.php?id_reactivacion=<?php echo base64_encode($sql_tabla["ROWS"][$counter]["id_reactivacion"]); ?>" target="_blank" class="btn btn-danger btn-raised btn-xs">
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
      "language": {
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
    window.open("../Controlador/reporte_revision_reactivacion_general_controlador.php", "REPORTE");
  }
</script>

<!-- <script type="text/javascript" src="../js/funciones_mantenimientos.js"></script> -->

<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>

