<!DOCTYPE html>
<!--
Contiene el menu principal e incluye las ventanas modales.
-->
<?php
$path2load = 'esquelemod/e_modulos/procesos/' . $this->EEoNucleo->pathDirRaizProcesoEjecucion() . '/';
$path2loadAbs = $this->EEoNucleo->pathAbsolutoDirRaizProcesoEjecucion() . '/';
$path2loadEsquelemod = $this->EEoNucleo->pathDirEsquelemod() . '/';

require $path2loadAbs.'root/ChequeoSesion.php';
require_once $path2loadEsquelemod . 'e_modulos/nucleo/nucleo_bib_funciones/herramientas/spyc.php';

require_once $path2loadAbs . 'class/class_PathBootstrap.php';
require_once $path2loadAbs . 'class/class_Validar.php';


// Leemos config del sistema SKM
$datos = \Emod\Nucleo\Herramientas\Spyc::YAMLLoad($path2loadEsquelemod .'e_sistema/e_sistema_config.cnf', false);
// Leemos config del sistema SKMAdmin
$datosConfig = \Emod\Nucleo\Herramientas\Spyc::YAMLLoad($path2loadAbs . 'config.yml', false);


// Control del tab seleccionado
$arrayTab[] = array();
if (isset($_GET['tab'])) {
    $selectTab = filter_input(INPUT_GET, 'tab', FILTER_SANITIZE_SPECIAL_CHARS);

    for ($i = 0; $i <= $datosConfig['cant_menu']; $i++) {
        if ($i == $selectTab) {
            $arrayTab[$i] = 'class="active"';
        } else {
            $arrayTab[$i] = '';
        }
    }
}


?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Configuracion</title>
        <link rel="stylesheet" href="<?php echo $path2load ?>style.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $pathRelBootstrap ?>/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $pathRelBootstrap ?>/bootstrap/dist/css/bootstrap-theme.min.css">
        <!-- <script src="<?php echo $path2load ?>js-bootstrap/bootstrap.min.jsm"></script>         -->
    </head>
    <body>
      
        <!-- XXXXXX  -->

        <div class="containerNO">
            <div class="row">
                <div class="span6">
                    <script src="<?php echo $pathRelBootstrap ?>/bootstrap/assets/js/jquery.js"></script>
                    <script src="<?php echo $pathRelBootstrap ?>/bootstrap/dist/js/bootstrap.min.js"></script>
                    <div >
                        <!--<h3>SKM. <small>Administraci&oacute;n del sistema</small></h3>-->
                        <img src="<?php echo $path2load ?>img/SKMAdmin.jpg" alt="SKMAdmin"/>
                        
                    </div>


                    <nav class="navbar navbar-default" role="navigation">
                        <!-- Brand and toggle get grouped for better mobile display -->
                        <div class="navbar-header">
                            <!-- Sin uso por el momento 
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                              <span class="sr-only">Toggle navigation</span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                              <span class="icon-bar"></span>
                            </button>
                            
                            <a class="navbar-brand" href="#">Inicio</a>
                            -->
                        </div>

                        <!-- Collect the nav links, forms, and other content for toggling -->
                        <div class="collapse navbar-collapse navbar-ex1-collapse">
                            <ul class="nav navbar-nav">
                                <li <?php echo $arrayTab[0] ?>><a href="?app=inicioconfig&tab=0&fs=inicio">Inicio</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Configuraci&oacute;n principal <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="?app=inicioconfig&tab=1&fs=sistema">Valores del sistema</a></li>
                                        <li><a href="?app=inicioconfig&tab=1&fs=herramientas">Valores referentes a Herramientas</a></li>
                                        <li class="disabled"><a href="#">Valores referentes a Utiles</a></li>
                                        <li class="disabled"><a href="#">Tratamiento de errores</a></li>
                                        <li><hr></li>
                                        <li><a href="?app=inicioconfig&tab=1&fs=bprocesos">Valores referentes a bloques de procesos</a></li>
                                    </ul>
                                </li>        
                                <li <?php echo $arrayTab[2] ?>><a href="?app=inicioconfig&tab=2">Usuarios</a></li>
                                <li <?php echo $arrayTab[3] ?>><a href="?app=acercade" target="newtab">Acerca de</a></li>

                            </ul>
                            <!-- La busqueda no estará implementada por ahora 
                            <form class="navbar-form navbar-left" role="search">
                              <div class="form-group">
                                <input type="text" class="form-control" placeholder="Search">
                              </div>
                              <button type="submit" class="btn btn-default">Submit</button>
                            </form> 
                            -->
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="?app=config&log=out" class="navbar-link"><span class="glyphicon glyphicon-log-out margen"></span>Cerrar sesi&oacute;n</a></li>
                            </ul>

                        </div><!-- /.navbar-collapse -->
                    </nav>

                    <?php
                    if (isset($_GET['tab'])) {
                        switch ($selectTab) {
                            case 0:
                                require $path2loadAbs . 'root/inicio.php';
                                break;
                            case 1:
                                require $path2loadAbs . 'root/MainConfig.php';
                                break;
                            case 2:
                                //require $path2loadAbs . 'root/MainConfig.php';
                                break;
                            case 3:
                                require $path2loadAbs . 'root/Acercade.php';
                                break;
                            default:
                                break;
                        }
                    }
                    include $path2loadAbs . 'root/ModalWindows.php';
                    ?>                 
                </div>
                <div class="text-center"><h4><small>SKMAdmin &COPY; 2017</small></h4></div>
            </div>
        </div>

        <!-- XXXXXX  -->
</html>
