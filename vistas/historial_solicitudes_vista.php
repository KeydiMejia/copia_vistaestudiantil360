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

$counter = 0;
 $url = "http://localhost/api/historial_solicitudes_api.php";
$sql_tabla = json_decode( file_get_contents($url), true );

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
                    <table id="tabla1" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                    <tr class="bg-basic">
                    <th> TIPO SOLICITUD </th>
                    <th> NOMBRE </th>
                    <th> # CUENTA </th>
                    <th> ESTADO</th>
                    <th> FECHA</th>
                    <th> CANCELAR SOLICITUD </th>
                    </tr>
                    </thead>
      <tbody>
                  <?php 
                 
                  if($sql_tabla["ROWS"]!=""){
                  while($counter < count($sql_tabla["ROWS"])) { 

                      $tipo_solicitud=$sql_tabla["ROWS"][$counter]["tipo"];

                      if ($tipo_solicitud=='CARTA EGRESADO') {
                      
                      
                       $id_solicitud= $sql_tabla["ROWS"][$counter]["id_suficiencia"];
                       $hash=base64_encode($id_solicitud);
                       $tabla="tbl_carta_egresado";
                       $campo="Id_carta";
                       $url="../Controlador/eliminar_solicitud_controlador.php?python=$hash &tabla=$tabla &campo=$campo";



                      }else if($tipo_solicitud=='PRE-EQUIVALENCIAS'){
                        
                        $id_solicitud= $sql_tabla["ROWS"][$counter]["id_suficiencia"];
                        $hash=base64_encode($id_solicitud);
                        $tabla="tbl_equivalencias";
                       $campo="Id_equivalencia";
                       $url="../Controlador/eliminar_solicitud_controlador.php?python=$hash&tabla=$tabla&campo=$campo";

                      }else if($tipo_solicitud=='REACTIVACION CUENTA'){
                        
                        $id_solicitud= $sql_tabla["ROWS"][$counter]["id_suficiencia"];
                        $hash=base64_encode($id_solicitud);
                        $tabla="tbl_reactivacion_cuenta";
                       $campo="id_reactivacion";
                       $url="../Controlador/eliminar_solicitud_controlador.php?python=$hash&tabla=$tabla&campo=$campo";

                      }else if($tipo_solicitud=='CAMBIO DE CARRERA'){
                        
                        $id_solicitud= $sql_tabla["ROWS"][$counter]["id_suficiencia"];
                        $hash=base64_encode($id_solicitud);
                        $tabla="tbl_cambio_carrera";
                       $campo="id_cambio";
                       $url="../Controlador/eliminar_solicitud_controlador.php?python=$hash&tabla=$tabla&campo=$campo";

                      }else if($tipo_solicitud=='CANCELAR CLASES'){
                        
                        $id_solicitud= $sql_tabla["ROWS"][$counter]["id_suficiencia"];
                        $hash=base64_encode($id_solicitud);
                        $tabla="tbl_cancelar_clases";
                       $campo="Id_cancelar_clases";
                       $url="../Controlador/eliminar_solicitud_controlador.php?python=$hash&tabla=$tabla&campo=$campo";

                      }else if($tipo_solicitud=='EXPEDIENTE DE GRADUACION'){
                        
                        $id_solicitud= $sql_tabla["ROWS"][$counter]["id_suficiencia"];
                        $hash=base64_encode($id_solicitud);
                        $tabla="tbl_expediente_graduacion";
                       $campo="id_expediente";
                       $url="../Controlador/eliminar_solicitud_controlador.php?python=$hash&tabla=$tabla&campo=$campo";

                      }else if($tipo_solicitud=='SERVICIO COMUNITARIO'){
                        
                        $id_solicitud= $sql_tabla["ROWS"][$counter]["id_suficiencia"];
                        $hash=base64_encode($id_solicitud);
                        $tabla="tbl_servicio_comunitario";
                       $campo="id_servicio_comunitario";
                       $url="../Controlador/eliminar_solicitud_controlador.php?python=$hash&tabla=$tabla&campo=$campo";

                      }else if($tipo_solicitud=='EXAMEN SUFICIENCIA'){
                        
                        $id_solicitud= $sql_tabla["ROWS"][$counter]["id_suficiencia"];
                        $hash=base64_encode($id_solicitud);
                        $tabla="tbl_examen_suficiencia";
                       $campo="id_suficiencia";
                       $url="../Controlador/eliminar_solicitud_controlador.php?python=$hash&tabla=$tabla&campo=$campo";


                      }
                      $estado=$sql_tabla["ROWS"][$counter]["descripcion"];
                      if ($estado=='Nueva' || $estado=='Nuevo' || $estado=='NUEVO') {
                       $boton=" <a href='$url'
                       class='btn btn-danger  ' >
                       <i class='far fa-trash-alt'></i>
                     </a>";
                      }else{
                        $boton=" <a href='#' onClick='activo()' 
                       class='btn btn-outline-danger ' >
                       <i class='far fa-trash-alt'></i>
                     </a>";
                      }
                      

                    ?>
                 
                <tr>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["tipo"]  ?></td>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["nombres"].' '. $sql_tabla["ROWS"][$counter]["apellidos"] ?></td>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["valor"]  ?></td>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["descripcion"]  ?></td>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["fecha_creacion"]  ?></td>
                
                    <td>
                                      <?php echo $boton?>
                    </td>
               </tr>
                 <?php $counter = $counter + 1; }} ?>
             </tbody>
                      </thead>
                    

        
          <!-- /.card-body -->
          <div class="card-footer">
            
          </div>
        </div>

</div>





</section>

</div>
    </form>
    <script src="desactivar_boton_cancelar.js"></script>


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
    window.open("../Controlador/reporte_historial_solicitudes_controlador.php", "REPORTE");
  }
</script>


<!-- <script type="text/javascript" src="../js/funciones_mantenimientos.js"></script> -->

<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>

<script>
  function activo() {
    swal({
        title: "ELIMINAR SOLICITUD",
        text: "La solicitud solo se puede eliminar cuando esta en estado Nueva",
        type: "info",
        showConfirmButton: false,
        timer: 8000
    });
  }
</script>