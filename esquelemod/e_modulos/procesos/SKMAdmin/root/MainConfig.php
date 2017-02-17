<?php
/*
  SKM Admin Herramienta para la configuraciÃ³n de SOCKELETOM (SKM)
  Copyright (C) 2016  Oscar Luis Inguanzo MartÃ­nez

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
?>
<?php
/**
 * Chequeo de sesion
 */
require $path2loadAbs.'root/ChequeoSesion.php';

$fs = $_GET['fs'];
switch ($fs) {
    case "sistema":
        $bloqueIncluir = $path2loadAbs . 'root/MainConfigSistema.php';
        $tituloFrm = 'Valores referentes al sistema SKM';
        $getVar = 'sistema';
        $MostrarBtnAdd = false;

        break;
    case "herramientas":
        $bloqueIncluir = $path2loadAbs . 'root/MainConfigHerramientas.php';
        $tituloFrm = 'Valores referentes a Herramientas de SKM';
        $getVar = 'herramientas';
        $MostrarBtnAdd = true;
        
        break;
    default:
        break;
}
?>  

<table border="0" align="center" width="70%">
    <?php
    // Si la conf se guardo mostramos msg de exito
    if (isset($_GET['success']) && $_GET['success'] == true) {
        ?>
        <tr><td>
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    La configuraci&oacute;n se actualiz&oacute; correctamente.
                </div>
            </td>
        </tr>
        <?php
    }
    // Si la conf no se guardo mostramos msg de error
    elseif (isset($_GET['success']) && $_GET['success'] == FALSE) {
        ?>

    <?php } ?>
    <tr><td>
            <form action="?app=savemainconfig&seccion=<?php echo $getVar ?>" method="post">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><label class=""><?php echo $tituloFrm; ?></label>        
                            <ul class="nav navbar-nav navbar-right">
                                <li>
                                    <?php if($MostrarBtnAdd){ ?>
                                    <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModalAgregar">
                                        <span class="glyphicon glyphicon-plus"></span> Agregar
                                    </button>
                                    <?php } ?>
                                </li>
                                <li>
                                    <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModalHelp">
                                        <span class="glyphicon glyphicon-question-sign"></span> Ayuda
                                    </button>
                                </li>

                            </ul>
                        </h3>

                    </div>
                    <div class="panel-body">
                        <!-- La sgte secciÃ³n depende de la selecciÃ³n que se hizo en el menÃº -->
                        <?php
                        include $bloqueIncluir;
                        ?>

                    </div>
                    <div class="panel-footer"  align="right"><button class="btn btn-primary btn-sm" type="submit">Aceptar</button></div>
                </div>
            </form>
        </td>
    </tr>
    <tr><td align="center"></td></tr>
</table>

