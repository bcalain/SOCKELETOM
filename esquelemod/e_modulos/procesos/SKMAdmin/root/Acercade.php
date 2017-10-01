<!DOCTYPE html>
<?php
$path2load = 'esquelemod/e_modulos/procesos/' . $this->EEoNucleo->pathDirRaizProcesoEjecucion() . '/';
$path2loadAbs = $this->EEoNucleo->pathAbsolutoDirRaizProcesoEjecucion() . '/';
$path2loadEsquelemod = $this->EEoNucleo->pathDirEsquelemod() . '/';

require_once $path2loadEsquelemod . 'e_modulos/nucleo/nucleo_bib_funciones/herramientas/spyc.php';
require_once $path2loadAbs . '../class/class_PathBootstrap.php';

// Leemos config del sistema SKM
$datos = \Emod\Nucleo\Herramientas\Spyc::YAMLLoad($path2loadEsquelemod . 'e_sistema/e_sistema_config.cnf', false);
// Leemos config del sistema SKMAdmin
$datosConfig = \Emod\Nucleo\Herramientas\Spyc::YAMLLoad($path2loadAbs . '../config.yml', false);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SKM Administracion</title>
        <meta charset="UTF-8">

        <link rel="stylesheet" href="<?php echo $path2load ?>style.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $pathRelBootstrap ?>/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $pathRelBootstrap ?>/bootstrap/dist/css/bootstrap-theme.min.css">
        <!-- <script src="<?php echo $path2load ?>js-bootstrap/bootstrap.min.js"></script> -->       
    </head>
    <body>
        <p>
        <div class="container">
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div >
                                <h4>Informaci&oacute;n</h4>
                                <img src="<?php echo $path2load ?>../img/SKMAdmin.jpg" alt="SKMAdmin"/>
                            </div>
                            <table class="table">
                                <tr>
                                    <td>
                                        <p class="text-muted">Aplicaci&oacute;n creada para la configuraci&oacute;n y mantenimiento de SocKeletoM (<strong>SKM</strong>).
                                            <strong>SKMAdmin</strong> es un proceso de SocKeletoM</p>
                                        <p class="text-muted">Versi&oacute;n  <?php echo $datosConfig['version'] ?></p>
                                    </td>
                                </tr>
                            </table>
                            <table class="table">
                                <tr>
                                    <td>
                                        <p class="text-muted"><h6>SKM en la web</h6></p>
                                        <p><a href="facebook.com/Sockeletom/" target="newtab">facebook</a></p>
                                        <p><a href="https://github.com/bcalain/SOCKELETOM"  target="newtab">GitHub</a></p>
                                    </td>
                                </tr>            
                            </table>
                        </div>
                    </div>

                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </p>
</body>
</html>
