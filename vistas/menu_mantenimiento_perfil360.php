<?php
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_visualizar.php');

if (permiso_ver('155') == '1') {

    $_SESSION['mantenimiento_estado_reactivacion_vista'] = "...";
} else {
    $_SESSION['mantenimiento_estado_reactivacion_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('157') == '1') {

    $_SESSION['mantenimiento_estado_expediente_vista'] = "...";
} else {
    $_SESSION['mantenimiento_estado_expediente_vista'] = "No 
  tiene permisos para visualizar";
}


if (permiso_ver('159') == '1') {

    $_SESSION['mantenimiento_estado_suficiencia_vista'] = "...";
} else {
    $_SESSION['mantenimiento_estado_suficiencia_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('161') == '1') {

    $_SESSION['mantenimiento_estado_servicio_vista'] = "...";
} else {
    $_SESSION['mantenimiento_estado_servicio_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('163') == '1') {

    $_SESSION['mantenimiento_estado_practica_vista'] = "...";
} else {
    $_SESSION['mantenimiento_estado_practica_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('156') == '1') {

    $_SESSION['mantenimiento_crear_estado_reactivacion_vista'] = "...";
} else {
    $_SESSION['mantenimiento_crear_estado_reactivacion_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('158') == '1') {

    $_SESSION['mantenimiento_crear_estado_expediente_vista'] = "...";
} else {
    $_SESSION['mantenimiento_crear_estado_expediente_vista'] = "No 
  tiene permisos para visualizar";
}


if (permiso_ver('160') == '1') {

    $_SESSION['mantenimiento_crear_estado_suficiencia_vista'] = "...";
} else {
    $_SESSION['mantenimiento_crear_estado_suficiencia_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('162') == '1') {

    $_SESSION['mantenimiento_crear_estado_servicio_vista'] = "...";
} else {
    $_SESSION['mantenimiento_crear_estado_servicio_vista'] = "No 
  tiene permisos para visualizar";
}

if (permiso_ver('164') == '1') {

    $_SESSION['mantenimiento_crear_estado_practica_vista'] = "...";
} else {
    $_SESSION['mantenimiento_crear_estado_practica_vista'] = "No 
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
                            <h1 class="m-0 text-dark">MANTENIMIENTOS PERFIL360 ESTUDIANTIL</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Inicio</a></li>

                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->



            <div class="card card-default">
                <div class="card-header">
                   
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>

                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">



                            <!-- Main content -->
                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Info boxes -->
                                    <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">



                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-light">
                                                <div class="inner">
                                                    <h4>Crear Estado Reactivacion Cuenta </h4>
                                                    <p><?php echo $_SESSION['mantenimiento_perfil360']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="far fa-plus-square"></i>
                                                </div>
                                                <a href="../vistas/mantenimiento_crear_estado_reactivacion_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.col -->
                                        <!-- fix for small devices only -->
                                        <div class="clearfix hidden-md-up"></div>

                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-primary">
                                                <div class="inner">
                                                    <h4>Mantenimiento Estado Reactivacion Cuenta </h4>
                                                    <p><?php echo $_SESSION['mantenimiento_perfil360']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </div>
                                                <a href="../vistas/mantenimiento_estado_reactivacion_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!--/. container-fluid -->
                                </div>
                            </section>
                            <!-- /.content -->



                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Info boxes -->
                                    <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">

                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-light">
                                                <div class="inner">
                                                    <h4>Crear Estado Expediente de Graduaci??n</h4>
                                                    <p><?php echo $_SESSION['mantenimiento_perfil360']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-plus-square"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_crear_estado_expediente_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                            <!-- /.info-box -->
                                        </div>
                                        <!-- fix for small devices only -->
                                        <div class="clearfix hidden-md-up"></div>

                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-primary">
                                                <div class="inner">
                                                    <h4>Mantenimiento Estado Expediente de Graduaci??n </h4>
                                                    <p><?php echo $_SESSION['mantenimiento_perfil360']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_estado_expediente_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>
                                            <!-- /.info-box -->
                                        </div>

                                        <!-- /.row -->
                                    </div>
                                    <!--/. container-fluid -->
                                </div>
                            </section>


                            <!-- /.info-box -->
                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Info boxes -->
                                    <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">
                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-light">
                                                <div class="inner">
                                                    <h4>Crear Estado Examen de Suficiencia </h4>
                                                    <p><?php echo $_SESSION['mantenimiento_perfil360']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-plus-square"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_crear_estado_suficiencia_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>

                                        </div>
                                        <!-- fix for small devices only -->
                                        <div class="clearfix hidden-md-up"></div>
                                        <!-- /.info-box -->
                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-primary">
                                                <div class="inner">
                                                    <h4>Mantenimiento Estado Examen de Suficiencia </h4>
                                                    <p><?php echo $_SESSION['mantenimiento_perfil360']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_estado_suficiencia_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>

                                        </div>
                                        <!-- /.row -->
                                    </div>
                                    <!--/. container-fluid -->
                                </div>
                            </section>



                            <!-- /.info-box -->
                            <section class="content">
                                <div class="container-fluid">
                                    <!-- Info boxes -->
                                    <div class="row" style="  display: flex;
    align-items: center;
    justify-content: center;">
                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-light">
                                                <div class="inner">
                                                    <h4>Crear Estado Servicio Comunitario</h4>
                                                    <p><?php echo $_SESSION['mantenimiento_perfil360']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-plus-square"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_crear_estado_servicio_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>

                                        </div>
                                        <!-- fix for small devices only -->
                                        <div class="clearfix hidden-md-up"></div>
                                        <!-- /.info-box -->
                                        <div class="col-6 col-sm-6 col-md-4">
                                            <div class="small-box bg-primary">
                                                <div class="inner">
                                                    <h4>Mantenimiento Estado Servicio Comunitario </h4>
                                                    <p><?php echo $_SESSION['mantenimiento_perfil360']; ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-edit"></i>
                                                </div>

                                                <a href="../vistas/mantenimiento_estado_servicio_vista.php" class="small-box-footer">
                                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                                </a>
                                            </div>

                                        </div>
                                        
                                        <!-- /.row -->
                                    </div>
                                    <!--/. container-fluid -->
                                </div>
                            </section>

                                
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->
            </div>



        </div>

    </div>

</body>

</html>