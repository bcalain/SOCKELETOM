<!DOCTYPE html>
<?php
/*
  SKM Config Herramienta para la configuración de SOCKELETOM (SKM)
  Copyright (C) 2016  Oscar Luis Inguanzo Martínez

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

  email-contact oscarlim@nauta.cu
 */
/**
 * SKM Config
 * @version 0.0.1
 * @author Oscar Luis Inguanzo Martínez <oscarlim@nauta.cu>
 * @link https://github.com/
 * @copyright Copyright 2016
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
 */
$path2load = 'esquelemod/e_modulos/procesos/' . $this->EEoNucleo->pathDirRaizProcesoEjecucion() . '/';
$path2loadAbs = $this->EEoNucleo->pathAbsolutoDirRaizProcesoEjecucion() . '/';
$path2loadEsquelemod = $this->EEoNucleo->pathDirEsquelemod() . '/';


if (isset($_GET['log']) && $_GET['log'] == 'out') {
    if (!@include_once $path2loadAbs . 'class/class_SessionControl.php') {
        die("Error. Imposible cargar aplicaci&oacute;n. Existe un problema con el chequeo de la sesi&oacute;n. " . basename(__FILE__) . '. Linea:' . __LINE__);
    } else {
        session_start();
        $varSession = new class_SessionControl($path2load);
        $varSession->deleteTmpSession();
        $_SESSION = array();
        session_destroy();
    }
}

require_once $path2loadEsquelemod . 'e_modulos/nucleo/nucleo_bib_funciones/herramientas/spyc.php';
require_once $path2loadAbs . 'class/class_PathBootstrap.php';

$datosConfig = \Emod\Nucleo\Herramientas\Spyc::YAMLLoad($path2loadAbs . 'config.yml', false);
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="Description" content="SKMAdmin" />
        <meta name="Keywords" content="SKMAdmin, SKM, Framework, Sockeletom" />
        <title>SKMAdmin</title>

        <link rel="stylesheet" href="<?php echo $path2load ?>style.css" type="text/css" />
        <link rel="stylesheet" href="<?php echo $pathRelBootstrap ?>/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo $pathRelBootstrap ?>/bootstrap/dist/css/bootstrap-theme.min.css">  
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-3">
                    <h3 class="form-signin-heading text-center"><img src="<?php echo $path2load ?>img/SKMAdmin.jpg" alt="SKMAdmin"/></h3>
                    <form class="form-signin" action="?app=chklogin" method="post">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <p><input name="inputUser" type="text" class="form-control" placeholder="Usuario" autofocus></p>
                                <p><input name="inputPass" type="password" class="form-control" placeholder="Contraseña"></p>
                            </div>
                            <div class="panel-footer text-center"><button class="btn btn-primary btn-sm" type="submit">Aceptar</button></div>
                        </div>
                    </form>
                    <h5 class="text-center">ver <?php echo $datosConfig['version'] ?></h5>                   
                    <?php if (isset($_GET['login']) && $_GET['login'] === 'false') { ?>
                        <div class="alert alert-danger">Usuario o contrase&ntilde;a incorrectos</div>
                    <?php } ?>
                </div>
            </div><!-- Final de la celda central -->
            <div class="col-md-4"></div>
        </div>

    </body>
</html>
