<?php
ob_start();
session_start();
 
 require_once ('../vistas/pagina_inicio_vista.php');
 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_visualizar.php');
 require_once ('../clases/funcion_bitacora.php');
 require_once ('../clases/funcion_permisos.php');
 require "../clases/conexion_mantenimientos.php";
 
 $Id_objeto=7147; 
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
   bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A VER CLASES APROBADAS');
 }

 $counter = 0;
 $url = "http://localhost/copia_automatizacion/copia_vistaestudiantil360/api/clases_aprobadas.php";
$sql_tabla = json_decode( file_get_contents($url), true );

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../plugins/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
<link rel=" stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">
<style>
  body{
    
}
.content-wrapper{
    width: auto;
    margin: 0px auto;
    
    
}
header{
  background: gray;
  color: white;
  margin-left:0%;
  height: 50px;
  width: 100%;
  text-align: center;
  line-height: 100px;

}
.clearfix{
  clear:both;
}

footer{
  background: lightblue;
  color: black;
  text-align: center;
  height: 50px;
  line-height: 50px;
}


</style>
</head>

<body>


<div class="wrapper">
<div class="content-wrapper">
<header>
    <h1>Clases aprobadas</h1>
</header>


<section class="content">
<div class="container-fluid">
   <div class="row">
   <div class="col-lg-7">
     

   <div class="card-body">
   <button class="btn btn-secondary buttons-pdf buttons-html5 btn-danger" tabindex="0" aria-controls="tabla" type="buttton" onclick="ventana()" title="Exportar a PDF">
          <i class="fas fa-file-pdf">
</i>
        </button>
        <br></br>
<table id="tabla15" class="table table-bordered table-striped">
      <thead>
            <tr>
            <tr class="bg-basic">
			<th>Nº</th>
            <th>Asignatura</th>
            <th>Codigo</th>
            <th>Unidades valorativas</th>
            </tr>
      </thead>
      <tbody>
                  <?php 
                 
                  if($sql_tabla["ROWS"]!=""){
                  while($counter < count($sql_tabla["ROWS"])) { 
                    ?>
                 
                <tr>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["NP"]  ?></td>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["asignatura"] ?></td>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["codigo"]  ?></td>
                <td><?php echo  $sql_tabla["ROWS"][$counter]["uv"]  ?></td>

               </tr>
                 <?php $counter = $counter + 1; }} ?>
             </tbody>
      </table>




</section>
<script type="text/javascript" language="javascript">
  function ventana() {
    window.open("../Controlador/reporte_clases_aprobadas_controlador.php", "REPORTE");
  }
</script>
</body>
</html>

