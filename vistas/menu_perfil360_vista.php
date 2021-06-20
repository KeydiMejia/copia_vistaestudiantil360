<?php
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_visualizar.php');

if (permiso_ver('49') == '1') {

  $_SESSION['menu_perfil360_vista'] = "...";
} else {
  $_SESSION['menu_perfil360_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('50') == '1') {

  $_SESSION['registro_perfil360_vista'] = "...";
} else {
  $_SESSION['registro_perfil360_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('51') == '1') {

  $_SESSION['gestion_perfil360_vista'] = "...";
} else {
  $_SESSION['gestion_perfil360_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('52') == '1') {

  $_SESSION['comisiones_actividades_perfil360_vista'] = "...";
} else {
  $_SESSION['comisiones_actividades_perfil360_vista'] = "No 
  tiene permisos para visualizar";
}



if (permiso_ver('54') == '1') {

  $_SESSION['perfil_perfil360_vista'] = "...";
} else {
  $_SESSION['perfil_perfil360_vista'] = "No 
  tiene permisos para visualizar";
}


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  


</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Perfil 360 Estudiantil </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                <li class="breadcrumb-item active">Perfil 360 estudiantil</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header ----->

<!------------------------- Main content ----------------------------->
<section class="content">
      <div class="container-fluid">
      <div class="row">
			<div class="col">
            
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

    <!--------- Info boxes ----------->
    <div class="row" style="  display: flex;">

            <div class="col-6 col-sm-6 col-md-4">
              <div class="small-box bg-success">
                <div class="inner">
                  <h4>Solicitud nueva </h4>
                  <p><?php echo $_SESSION['registro_perfil360_vista']; ?></p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-plus"></i>
                </div>
                <a href="../vistas/registro_perfil360_vista.php" class="small-box-footer">
                  Ir <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>

          

              <!-- /.info-box -->
            </div>
            <!-- /.col -->


            </div>

            <!-- /.row -->
          </div>
          <!--/. container-fluid -->
        </div>
      </section>
      <!-- /.content -->
    </div>

  </div>

</body>

</html>