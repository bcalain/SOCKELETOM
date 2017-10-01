<?php
/*
 * Edicion de Bloques de Procesos
 */
$obj = new class_Validar();

if (isset($_GET['bproc']) && isset($_GET['proc'])) {
    if (!$obj->filtrarSpecialChars(array('bproc', 'proc'))) {
        die('Existen errores en el filtrado de los datos');
    }
    $datosGet = $_GET;
} else {
    $datosGet['bproc'] = 'bloque_defecto';
    $datosGet['proc'] = 'apertura';
}


$path_raiz = (isset($datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['propiedades_implementacion_proceso']['path_raiz'])) ?
        $datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['propiedades_implementacion_proceso']['path_raiz'] : '';

$path_arranque = (isset($datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['propiedades_implementacion_proceso']['path_arranque'])) ?
        $datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['propiedades_implementacion_proceso']['path_arranque'] : '';

$condicionEjecucion = (isset($datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['propiedades_implementacion_proceso']['condicion_ejecucion'])) ?
        $datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['propiedades_implementacion_proceso']['condicion_ejecucion'] : '';
?>

<!--<div class="panel panel-default"> -->
<div class="table-responsive">
    <table class="table">

        <tr>
            <td width="28%">

                <!-- Bloque de procesos  -->
                <div class="table-responsive">
                    <table class="table">  

                        <?php
                        foreach ($datos['procesos']['bloques_procesos'] as $key => $value) {                           
                            if (strlen($key) < $datosConfig['btn_longitud']) {
                                $rellenar = $datosConfig['btn_longitud'] - (strlen($key));
                            }

                            echo '<tr><td><div class="btn-group">'
                            . '<button type="button" class="btn btn-default btn-xs" title="Bloque \'' . $key . '\'">
                                        <span class="glyphicon glyphicon-list" data-toggle="modal"> ' . substr($key, 0, 15) . '</span>
                                    </button>'
                            . '<button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown" title="Lista de procesos">'
                            . '<span class="caret"></span> '
                            . ' <span class="sr-only">Toggle Dropdown</span>
                                   </button>
                                   <ul class="dropdown-menu" role="menu">';

                            foreach ($datos['procesos']['bloques_procesos'][$key] as $key2 => $value2) {
                                echo '<li><a href="?app=inicioconfig&tab=1&fs=bprocesos&bproc=' . $key . '&proc=' . $key2 . '">' . $key2 . '</a></li>';
                            }

                            echo '<li class="divider"></li>'
                            . '</ul></div></td></tr>';
                        }
                        ?>
                        <tr><td><div class="btn-group">
                                    <button type="button" class="btn btn-success">
                                        <span class="glyphicon glyphicon-plus" href="#myModalAgregar" data-toggle="modal"> AGREGAR</span>
                                    </button>
                                </div></td>
                        </tr>
                    </table>
                </div>
                <!-- FIN Bloque de procesos  -->
            </td>
            <td>
                <!-- Procesos  -->
                <div class="panel panel-default">
                    <div class="panel-heading">Bloque:<b><i><?php echo $datosGet['bproc'] . '</i></b>   Proceso:<b><i>' . $datosGet['proc'] ?></i></b>
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <div class="btn-group btn-group-xs">
                                    <a href="#myModalAgregar" data-toggle="modal" title="Crear bloque de procesos">
                                        <span class="glyphicon glyphicon-list" data-toggle="modal"></span>
                                    </a>
                                </div>
                            </li>
                            <li class="margen"></li>
                            <li>
                                <div class="btn-group btn-group-xs">
                                    <a href="#myModalAgregar2" data-toggle="modal" title="Crear proceso">
                                        <span class="glyphicon glyphicon-cog" data-toggle="modal"></span>
                                    </a>
                                </div>
                            </li>
                            <li class="margen"></li>
                            <li>
                                <div class="btn-group btn-group-xs">
                                    <a href="#myModalAgregar2" data-toggle="modal" title="Renombrar proceso '<?php echo $datosGet['proc'] ?>'">
                                        <span class="glyphicon glyphicon-pencil" data-toggle="modal"></span>
                                    </a>
                                </div>
                            </li>
                            <li class="margen"></li>
                        </ul>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th colspan="2">gedee_proceso</th>
                                </tr>
                            </thead>
                            <tr><td class="text-right" width="20%">namespace:</td>
                                <td>
                                    <div class="col-lg-8">
                                        <input class="form-control input-sm" id="disabledInput" type="text" name="datos[procesos][bloques_procesos][<?php echo $datosGet['bproc'] ?>][<?php echo $datosGet['proc'] ?>][gedee_proceso][namespace]" value="<?php echo $datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['gedee_proceso']['namespace'] ?>">
                                    </div>
                                </td>
                            </tr>
                            <tr><td class="text-right">clase:</td>
                                <td>
                                    <div class="col-lg-8">
                                        <!-- path_entidad_clase -->
                                        <input class="form-control input-sm" type="text" name="datos[procesos][bloques_procesos][<?php echo $datosGet['bproc'] ?>][<?php echo $datosGet['proc'] ?>][gedee_proceso][clase]" value="<?php echo $datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['gedee_proceso']['clase'] ?>"/>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-right">id_entidad:</td>
                                <td>
                                    <div class="col-lg-8">
                                        <!-- referencia_path_entidad -->
                                        <input class="form-control input-sm" type="text" name="datos[procesos][bloques_procesos][<?php echo $datosGet['bproc'] ?>][<?php echo $datosGet['proc'] ?>][gedee_proceso][id_entidad]" value="<?php echo $datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['gedee_proceso']['id_entidad'] ?>"/>
                                    </div>
                                </td>
                            </tr>
                            <thead>
                                <tr>
                                    <th width="20%" colspan="2">propiedades_implementacion_proceso</th>
                                </tr>
                            </thead>
                            <tr>
                                <td class="text-right">path_raiz:</td>
                                <td>
                                    <div class="col-lg-8">
                                        <input class="form-control input-sm" type="text" name="datos[procesos][bloques_procesos][<?php echo $datosGet['bproc'] ?>][<?php echo $datosGet['proc'] ?>][propiedades_implementacion_proceso][path_raiz]" value="<?php echo $path_raiz ?>"/>

                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">path_arranque:</td>
                                <td>
                                    <div class="col-lg-8">
                                        <input class="form-control input-sm" type="text" name="datos[procesos][bloques_procesos][<?php echo $datosGet['bproc'] ?>][<?php echo $datosGet['proc'] ?>][propiedades_implementacion_proceso][path_arranque]" value="<?php echo $path_arranque ?>"/>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">obligatoriedad:</td>
                                <td>
                                    <div class="col-lg-5">
                                        <select class="form-control input-sm" name="datos[procesos][bloques_procesos][<?php echo $datosGet['bproc'] ?>][<?php echo $datosGet['proc'] ?>][propiedades_implementacion_proceso][obligatoriedad]">
                                            <?php
                                            $varBool = array("1" => 'TRUE', "0" => 'FALSE');
                                            $valor = $datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['propiedades_implementacion_proceso']['obligatoriedad'];
                                            foreach ($varBool as $key => $value) {
                                                if ($key == $valor) {
                                                    echo '<option value="' . $key . '" selected="selected">' . $value . '</option>';
                                                } else {
                                                    echo '<option value="' . $key . '">' . $value . '</option>';
                                                }
                                            }
                                            ?>
                                        </select>                                            
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">condicion_ejecucion:</td>
                                <td>
                                    <div class="col-lg-8">
                                        <input class="form-control input-sm" type="text" name="datos[procesos][bloques_procesos][<?php echo $datosGet['bproc'] ?>][<?php echo $datosGet['proc'] ?>][propiedades_implementacion_proceso][condicion_ejecucion]" value="<?php echo $condicionEjecucion ?>"/>
                                    </div>
                                </td>
                            </tr>
                        </table> 
                    </div>
                </div>
                <!-- FIN  Procesos  -->

            </td>
        </tr>


        <div class="modal fade" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header btn-default form-control">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h5 class="modal-title">Modal title</h5>
                    </div>
                    <div class="modal-body">
                        <p>One fine body&hellip;</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->       
    </table>
</div>    
<!--</div>-->