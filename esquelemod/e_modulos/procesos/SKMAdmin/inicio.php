<!DOCTYPE html>
<!--
Muestra la lista de procesos y herramientas en Inicio
-->
<?php
/**
 * Leemos el directorio procesos
 */
$readDir = 'esquelemod/e_modulos/procesos/';
$arrayDir = scandir($readDir);
################3
//$running = $this->EEoNucleo->accederHistorialArbolProcesos();

/* $contenidoFichPHP = "<?php \n" . '$datos = ' . var_export($running, true) . "\n?>";
  //file_put_contents("d:/TMP/procesos_ejecutados.php", $contenidoFichPHP);
  //die(); */
######################3
?>
<div class="table-responsive">
    <table class="table">
        <tr>
            <td align="">
                <form action="?app=savemainconfig&seccion=<?php ?>" method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><label class="">Procesos del sistema</label>        
                                <ul class="nav navbar-nav navbar-right">
                                    <li>
                                        <div class="btn-group btn-group-xs">
                                            <a href="#myModal" data-toggle="modal" title="Listar/Configurar procesos">
                                                <span class="glyphicon glyphicon-list-alt"></span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>&numsp; </li>
                                    <li>
                                        <div class="btn-group btn-group-xs">
                                            <a href="#myModal" data-toggle="modal" title="Ayuda">
                                                <span class="glyphicon glyphicon-question-sign"></span> 
                                            </a>
                                        </div>
                                    </li> 
                                    <!--<li>
                                        <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModalHelp">
                                            <span class="glyphicon glyphicon-question-sign"></span> Ayuda
                                        </button>
                                    </li>-->

                                </ul>
                            </h3>

                        </div>
                        <div class="panel-body">

                            <table class="table table-hover table-condensed">
                                <thead>
                                <th align="center">Nombre</th>
                                <th align="center">Estado</th>
                                <th align="center">Estructura</th>
                                <th align="center"></th>
                                <th align="center"></th>
                                <th align="center"></th>
                                <th align="center"></th>
                                </thead>
                                <?php
                                foreach ($arrayDir as $key => $nombreDir) {
                                    if ($nombreDir != "." && $nombreDir != ".." && is_dir($readDir . $nombreDir)) {
                                        ?>

                                        <tr>
                                            <td align=""><span class="glyphicon glyphicon-cog"></span> <?php echo $nombreDir ?></td>
                                            <td align="">Corriendo...</td>
                                            <td align="">Estructura</td>
                                            <td align=""> <!-- Play/Pause a los procesos -->
                                                <a href="#myModal" data-toggle="modal" title="Pausa">
                                                    <span class="glyphicon glyphicon-play"></span> 
                                                </a>
                                            </td>
                                            <td align=""> <!-- Editar configuración de un proceso -->
                                                <a href="" data-toggle="modal" data-target="#myModalAgregar" title="Editar configuraci&oacute;n">
                                                    <span class="glyphicon glyphicon-pencil"></span> 
                                                </a>
                                            </td>
                                            <td align=""> <!-- Editar permisos de un proceso -->
                                                <a href="#myModal" data-toggle="modal" title="Editar permisos">
                                                    <span class="glyphicon glyphicon-user"></span> 
                                                </a>
                                            </td>
                                            <td align=""> <!-- Exportar un proceso -->
                                                <a href="#myModal" data-toggle="modal" title="Exportar proceso">
                                                    <span class="glyphicon glyphicon-export"></span> 
                                                </a>
                                            </td>
                                        </tr>  

                                        <?php
                                    }
                                }
                                ?> 
                            </table>                            
                        </div>
                    </div>
                </form>

            </td>
            <td width="5%"> <!-- Separacion entre las dos columnas --> </td>
            <td align="">
                <form action="?app=savemainconfig&seccion=<?php ?>" method="post">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><label class="">Herramientas del sistema</label>        
                                <ul class="nav navbar-nav navbar-right">
                                    <li>
                                        <div class="btn-group btn-group-xs">
                                            <a href="?app=inicioconfig&tab=1&fs=herramientas" data-toggle="modal" title="Listar/Configurar herramientas">
                                                <span class="glyphicon glyphicon-list-alt"></span>
                                            </a>
                                        </div>
                                    </li>
                                    <li>&numsp;  </li>
                                    <li>
                                        <div class="btn-group btn-group-xs">
                                            <a href="#myModal" data-toggle="modal" title="Ayuda">
                                                <span class="glyphicon glyphicon-question-sign"></span> 
                                            </a>
                                        </div>
                                    </li>
                                   <!-- <li>
                                        <div class="btn-group btn-group-xs">
                                            <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModalHelp">
                                                <span class="glyphicon glyphicon-pencil"></span> Editar
                                            </button>
                                        </div>
                                    </li>                                    
                                    <li>
                                        <div class="btn-group btn-group-xs">
                                            <button class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModalHelp">
                                                <span class="glyphicon glyphicon-question-sign"></span> Ayuda
                                            </button></div>
                                    </li>    -->                                

                                </ul>
                            </h3>

                        </div>
                        <div class="panel-body">
                            <table class="table table-hover table-condensed">
                                <thead>
                                <th align="">Nombre</th>
                                <th align="">Descargar</th>
                                </thead>
                                <?php
                                foreach ($datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'] as $key => $tool) {
                                    ?>

                                    <tr>
                                        <td align=""><span class="glyphicon glyphicon-wrench"></span> <?php echo $key ?></td>
                                        <td align="">Corriendo...</td>
                                        <td align=""> <!-- Play/Pause a los procesos -->
                                            <a href="#myModal" data-toggle="modal" title="Pausa">
                                                <span class="glyphicon glyphicon-play"></span> 
                                            </a>
                                        </td>
                                        <td align=""> <!-- Editar configuración de una herramienta -->
                                            <a href="?app=inicioconfig&tab=1&fs=editherramienta&tool=<?php echo $key ?>
                                                                                               &entidad=<?php echo $datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'][$key]['path_entidad_clase'] ?>
                                                                                               &referencia=<?php echo $datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'][$key]['referencia_path_entidad'] ?> 
                                                                                               &tipo=<?php echo $datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'][$key]['tipo_entidad'] ?>" 
                                                                                               title="Editar configuraci&oacute;n">
                                                <span class="glyphicon glyphicon-pencil"></span> 
                                            </a>
                                        </td>
                                        <td align=""> <!-- Editar permisos de un proceso -->
                                            <a href="#myModal" data-toggle="modal" title="Editar permisos">
                                                <span class="glyphicon glyphicon-user"></span> 
                                            </a>
                                        </td>
                                        <td align=""> <!-- Exportar un proceso -->
                                            <a href="#myModal" data-toggle="modal" title="Exportar proceso">
                                                <span class="glyphicon glyphicon-export"></span> 
                                            </a>
                                        </td>
                                    </tr>  

                                    <?php
                                }
                                ?>
                            </table>                            
                        </div>
                    </div>
                </form>

            </td>
        </tr>        

    </table>

</div>

