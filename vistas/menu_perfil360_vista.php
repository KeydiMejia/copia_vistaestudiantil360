<?php
ob_start();
session_start();
 
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/conexion_mantenimientos.php');


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

  $_SESSION['historial_clases_vista'] = "...";
} else {
  $_SESSION['historial_clases_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('120') == '1') {

  $_SESSION['asignaturas_aprobadas_vista'] = "...";
} else {
  $_SESSION['asignaturas_aprobadas_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('121') == '1') {

  $_SESSION['asignaturas_por_aprobar_vista'] = "...";
} else {
  $_SESSION['asignaturas_por_aprobar_vista'] = "No 
  tiene permisos para visualizar";
}



?>

</html><!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  
  
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
  width: 40%;
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
            
            <button type="button" class="btn btn-success">Buscar</button>
            
        </form>
      </article>

      <p>                             </p>
      <p>                             </p>

      <article class="article">
      <table class="table table-responsive table-striped table-hover">
					<thead>
						<tr>
                        <tr class="bg-primary">
							<th COLSPAN=2>Datos Personales del estudiante</th>
                            

						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Nombre Completo:</th>
							<td>Keydi Michelle Mejia Palma</td>
							
						</tr>
                        <tr>
							<th>Numero de cuenta:</th>
							<td>20161032247</td>
							
						</tr>
						<tr>
							<th>Numero de identidad:</th>
							<td>0801199721807</td>
							
						</tr>
						<tr>
							<th>Fecha de nacimiento:</th>
							<td>18-10-1997</td>
							
						</tr>
                        <tr>
							<th>Correo institucional:</th>
							<td>keydipalma@unah.hn</td>
							
						</tr>
                        <tr>
							<th>Correo personal:</th>
							<td>keydimejia@gmial.com</td>
							
						</tr>
                        <tr>
							<th>Telefono o celular:</th>
							<td>98403492</td>
							
						</tr>
					</tbody>
				</table>
        
			
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

      </article>
      
      <article class="article"> 
      <table class="table table-responsive table-striped table-hover" style="margin-left: 15%; margin-top: 8%; width: 1000px;">
      
      
					<thead>
						<tr>
                        <tr class="bg-primary">
							<th COLSPAN=2>Solicitudes realizadas</th>
                            

						</tr>
					</thead>
					<tbody>
						<tr>
							<th>Examen de suficiencia:</th>
							<td>0</td>
							
						</tr>
                        <tr>
							<th>Reactivacion de cuenta:</th>
							<td>2</td>
							
						</tr>
						<tr>
							<th>cambio de carrera:</th>
							<td>0</td>
							
						</tr>
						<tr>
							<th>Practica profesional:</th>
							<td>0</td>
							
						</tr>
                        <tr>
							<th>Cancelacion de clases:</th>
							<td>3</td>
							
						</tr>
                        <tr>
							<th>Servicio comunitario:</th>
							<td>1</td>
							
						</tr>
                        <tr>
							<th>Equivalencias:</th>
							<td>0</td>
							
						</tr>
            </tr>
                        <tr>
							<th>Carta de egresado:</th>
							<td>0</td>
							
						</tr>
            </tr>
                        <tr>
							<th>Expediente de graduacion:</th>
							<td>0</td>
							
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
      <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row" style="  display: flex;
    align-items: center; justify-content: center; margin-top: 15%; margin-bottom:5%;">

            <div class="col-6 col-sm-6 col-md-4">
              <div class="small-box bg-primary" style="margin-right: 8%;">
                <div class="inner">
                  <h4>Realizar nueva solicitud </h4>
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
            <div class="col-6 col-sm-6 col-md-4">
              <div class="small-box bg-primary" style="margin-left: 5%;">
                <div class="inner">
                  <h4>Historial de clases </h4>
                  <p><?php echo $_SESSION['historial_clases_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-edit"></i>
                </div>
                <a href="../vistas/historial_clases_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>

            <!-- /.row -->
          </div>
          <!--/. container-fluid -->
        </div>
</article>
<div class="container-fluid">
          <!-- Info boxes -->
          <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center; margin-top: 5%; margin-bottom:10%;">

            <div class="col-6 col-sm-6 col-md-4">
              <div class="small-box bg-warning" style="margin-right: 8%;">
                <div class="inner">
                  <h4>Asignaturas aprobadas </h4>
                  <p><?php echo $_SESSION['asignaturas_aprobadas_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-plus"></i>
                </div>
                <a href="../vistas/asignaturas_aprobadas_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>
            <div class="col-6 col-sm-6 col-md-4">
              <div class="small-box bg-warning" style="margin-left: 5%;">
                <div class="inner">
                  <h4>Asignaturas por aprobar </h4>
                  <p><?php echo $_SESSION['asignaturas_por_aprobar_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-edit"></i>
                </div>
                <a href="../vistas/asignaturas_por_aprobar_vista.php" class="small-box-footer">
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