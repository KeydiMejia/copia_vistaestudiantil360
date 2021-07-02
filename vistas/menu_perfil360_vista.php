<?php
ob_start();
session_start();

 
 require_once ('../vistas/pagina_inicio_vista.php');
 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_visualizar.php');
 require_once ('../clases/funcion_bitacora.php');
 require "../clases/conexion_mantenimientos.php";


if (permiso_ver('117') == '1') {

  $_SESSION['menu perfil360'] = "...";
} else {
  $_SESSION['menu perfil360'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('118') == '1') {

  $_SESSION['realizar_nueva_solicitud_vista'] = "...";
} else {
  $_SESSION['realizar_nueva_solicitud_vista'] = "No 
  tiene permisos para realizar esta accion";
}

if (permiso_ver('119') == '1') {

  $_SESSION['tipo_plan_perfil_vista'] = "...";
} else {
  $_SESSION['tipo_plan_perfil_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('120') == '1') {

  $_SESSION['conducta_perfil360_vista'] = "...";
} else {
  $_SESSION['conducta_perfil360_vista'] = "No 
  tiene permisos para visualizar";
}


$Id_objeto=117; 
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
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A PERFIL 360 ESTUDIANTIL');
}


/* Manda a llamar todos las datos de la tabla para llenar la tabla de datos personales  */
$sql=$mysqli->prepare("SELECT p.nombres,p.apellidos,p.identidad, p.fecha_nacimiento, pe.valor
FROM tbl_personas p, tbl_personas_extendidas pe, tbl_usuarios u
WHERE pe.id_persona = p.id_persona
AND p.id_persona = u.id_persona
AND u.Usuario = ?");
$sql->bind_param("s",$_SESSION['usuario']);
$sql->execute();
$resultadotabla = $sql->get_result();
$row = $resultadotabla->fetch_array(MYSQLI_ASSOC);

/* Manda a llamar las clases aprobadas por el id */
$idUsuario = $_SESSION['id_persona'];

$sqlaprobadas="SELECT COUNT(*) id_persona FROM tbl_asignaturas_aprobadas
WHERE id_persona= $idUsuario ";
$resultado = $mysqli->query($sqlaprobadas);
$fila = $resultado->fetch_assoc();

/* Manda a llamar para solicitud de examen de suficiencia */
$sqlsuficiencia="SELECT COUNT(*) id_persona FROM tbl_examen_suficiencia
WHERE id_persona= $idUsuario ";
$resultado = $mysqli->query($sqlsuficiencia);
$fila1 = $resultado->fetch_assoc();

/* Manda a llamar para solicitud de Reactivacion de cuenta */
$sqlreactivacion="SELECT COUNT(*) id_persona FROM tbl_reactivacion_cuenta
WHERE id_persona= $idUsuario ";
$resultado = $mysqli->query($sqlreactivacion);
$fila2 = $resultado->fetch_assoc();

/* Manda a llamar para solicitud para cambio de carrera */
$sqlcarrera="SELECT COUNT(*) id_persona FROM tbl_cambio_carrera
WHERE id_persona= $idUsuario ";
$resultado = $mysqli->query($sqlcarrera);
$fila3 = $resultado->fetch_assoc();

/* Manda a llamar para solicitud para practica profesional*/
$sqlpractica="SELECT COUNT(*) id_persona FROM tbl_practica_estudiantes
WHERE id_persona= $idUsuario ";
$resultado = $mysqli->query($sqlpractica);
$fila4 = $resultado->fetch_assoc();

/* Manda a llamar para solicitud de cancelacion de clases */
$sqlclases="SELECT COUNT(*) id_persona FROM tbl_cancelar_clases
WHERE id_persona= $idUsuario ";
$resultado = $mysqli->query($sqlclases);
$fila5 = $resultado->fetch_assoc();

/* Manda a llamar para solicitud para servicio comunitario */
$sqlservicio="SELECT COUNT(*) id_persona FROM tbl_servicio_comunitario
WHERE id_persona= $idUsuario ";
$resultado = $mysqli->query($sqlservicio);
$fila6 = $resultado->fetch_assoc();

/* Manda a llamar para solicitud para equivalencias */
$sqlequivalencias="SELECT COUNT(*) id_persona FROM tbl_equivalencias
WHERE id_persona= $idUsuario ";
$resultado = $mysqli->query($sqlequivalencias);
$fila7 = $resultado->fetch_assoc();

/* Manda a llamar para solicitud para carta egresado */
$sqlcarta="SELECT COUNT(*) id_persona FROM tbl_carta_egresado
WHERE id_persona= $idUsuario ";
$resultado = $mysqli->query($sqlcarta);
$fila8 = $resultado->fetch_assoc();

/* Manda a llamar para solicitud expediente graduacion */
$sqlgraduacion="SELECT COUNT(*) id_persona FROM tbl_expediente_graduacion
WHERE id_persona= $idUsuario ";
$resultado = $mysqli->query($sqlgraduacion);
$fila9 = $resultado->fetch_assoc();



    ob_end_flush();

?>

</html><!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
  
<style>
  body{
    
}
.content-wrapper{
    width: 82%;
    margin: 0px auto;
    border: 1px solid black;
    
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

#content{
  float:left;
  margin-left:1%;
  width: 41%;
  height:100%;
  background: white;
}

aside{
  float:left;
  height: 70%;
  width: 58%;
  margin:0px;
  background: white;
  min-height: 500px;
  padding: 10px;
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
    <h1>Perfil 360 Estudiantil</h1>
  </header>
<div class="clearfix"></div>

    <section id="content"> <!--------- INICIO DE LA SECCION------->
    <article class="article" style="margin-top: 5%;">
      <h4>Buscar estudiante<h4>
        <form> 
            <input type="text">
            <button type="button" class="btn btn-info">Buscar</button>
            </form>
      </article>
<p>                             </p>
<p>                             </p>
      <article class="article">
      <div class="card-body">
<table id="tabla15" class="table table-bordered table-striped">
      <thead>
            <tr>
            <tr class="bg-basic">
			<th COLSPAN=2>Datos Personales del estudiante</th>
            </tr>
      </thead>
        <tbody>

    
         <tr>
      <th>Nombre Completo:</th>
      <td><?php echo $row['nombres'].' '.$row['apellidos'] ?></td>
        </tr>
        <tr>
      <th>Identidad:</th>
      <td><?php echo $row['identidad'] ?></td>
        </tr>

        <tr>
      <th>Numero de cuenta:</th>
      <td><?php echo $row['valor'] ?></td>
        </tr>

        <tr>
      <th>fecha de Nacimiento:</th>
      <td><?php echo $row['fecha_nacimiento'] ?></td>
        </tr>
        <tr>
      <th>Correo:</th>
      <td></td>
        </tr>
        <tr>
      <th>Telefono:</th>
      <td></td>
        </tr>

                  
        </tbody>
      </table>

      <!--------------------------------------------------------------------------->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

      </article>
      
      <article class="article"> 
      <table class="table table-responsive table-striped table-hover" style="margin-left: 15%; margin-top: 8%; width: 1000px;">
      
      
					<thead>
						<tr>
                        <tr class="bg-basic">
							<th COLSPAN=2>Solicitudes realizadas</th>
            </tr>
					</thead>

          <?php 
          /*$id_persona = $_POST['id_persona'];
          $sqlexiste = ("select id_persona from tbl_cambio_carrera where id_persona= '$id_persona'");
          $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

          if ($_POST['id_persona'] == $id_persona ) {
          $resultado=1;
          echo "si tiene solicitud en cambio de carrera";
        } else {
          echo "a es menor que b"; 
      } */
      ?>


					<tbody>
						<tr>
							<th>Examen de suficiencia:</th>
              <td><?php echo $fila1['id_persona'] ?></td>

						</tr>
                        <tr>
							<th>Reactivacion de cuenta:</th>
							<td><?php echo $fila2['id_persona'] ?></td>
							
						</tr>
						<tr>
							<th>cambio de carrera:</th>
							<td><?php echo $fila3['id_persona'] ?></td>
							
						</tr>
						<tr>
							<th>Practica profesional:</th>
							<td><?php echo $fila4['id_persona'] ?></td>
							
						</tr>
                        <tr>
							<th>Cancelacion de clases:</th>
							<td><?php echo $fila5['id_persona'] ?></td>
							
						</tr>
                        <tr>
							<th>Servicio comunitario:</th>
							<td><?php echo $fila6['id_persona'] ?></td>
							
						</tr>
                        <tr>
							<th>Equivalencias:</th>
							<td><?php echo $fila7['id_persona'] ?></td>
							
						</tr>
            </tr>
                        <tr>
							<th>Carta de egresado:</th>
							<td><?php echo $fila8['id_persona'] ?></td>
							
						</tr>
            </tr>
                        <tr>
							<th>Expediente de graduacion:</th>
							<td><?php echo $fila9['id_persona'] ?></td>
							
						</tr>
					</tbody>
				</table>
<p>                  
               </p>

      </article>
<p>               
                    </p>
    </section>
<!----------------Fin de seccion---------------->
    
<aside class="Content">
  <article>
  <div class="card" style="width: 15rem; margin-left:30%;">
  <img class="card-img-top" src="../archivos/avatar1.jpg" alt="Card image cap">
  <div class="card-body">
    <p class="card-text">[Nombre del estudiante]</p>
  </div>
</div>
</article>

      <article>
      <h3 class="mb-2">Tus Clases</h3>
      <div class="container-fluid">
      <div class="row">
      
          <div class="col-md-6 col-sm-8 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-info" style="border: 2px"><i class="far fa-copy"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Aprobadas</span>
                <span class="info-box-number"><?php echo $fila['id_persona'] ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-md-6 col-sm-8 col-12">
            <div class="info-box">
              <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Por aprobar</span>
                <span class="info-box-number"><?php echo 52 - $fila['id_persona']  ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
</article>


<article>
          <!----------- Info boxes ------------->
          <div class="row" style="  display: flex;
    align-items: center; margin-top: 3%; margin-bottom:1%;">

            <div class="col-md-6 col-sm-8 col-12">
            
              <div class="small-box bg-primary" style="margin-right: 0%;">
                <div class="inner">
                  <h4>Nueva solicitud </h4>
                  <p><?php echo $_SESSION['realizar_nueva_solicitud_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-plus"></i>
                </div>
                <a href="../vistas/realizar_nueva_solicitud_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-md-6 col-sm-8 col-12">
              <div class="small-box bg-primary" style="margin-left: 0%;">
                <div class="inner">
                  <h4>Tipo de plan </h4>
                  <p><?php echo $_SESSION['tipo_plan_perfil_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-edit"></i>
                </div>
                <a href="../vistas/tipo_plan_perfil_vista.php" class="small-box-footer">
                  Mas informacion <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>

            <!-- /.row -->
          </div>
          <!--/. container-fluid -->
        </div>
</article>
<article>
<div class="container-fluid">
          <!-- Info boxes -->
          <div class="row" style="  display: flex;
    align-items: center; margin-top: 3%; margin-bottom: 0%;">

            <div class="col-md-6 col-sm-8 col-12">
              <div class="small-box bg-warning" style="margin-right: 0%;">
                <div class="inner">
                  <h4>VOAE Conducta </h4>
                  <p><?php echo $_SESSION['conducta_perfil360_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-plus"></i>
                </div>
                <a href="../vistas/conducta_perfil360_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-md-6 col-sm-8 col-12">
              <div class="small-box bg-warning" style="margin-right: 0%;">
                <div class="inner">
                  <h4>VOAE Asistencia </h4>
                  <p><?php echo $_SESSION['tipo_plan_perfil_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-plus"></i>
                </div>
                <a href="../vistas/tipo_plan_perfil_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
          

            <!-- /.row -->
          </div>
          <!--/. container-fluid -->
        </div>
</article>

    </aside>
<!-----------Fin de barra lateral----------->
<div class="clearfix"></div>
<footer>
  Este es el pie de pagina &copy; 2021 Departamento de Informatica Administrativa

</footer>
<!-----------Fin del pie de pagina----------->


</div>

</body>

</html>