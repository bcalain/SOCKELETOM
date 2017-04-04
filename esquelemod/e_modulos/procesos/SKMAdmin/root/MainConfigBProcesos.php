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
}else{
    $datosGet['bproc'] = 'bloque_defecto';
    $datosGet['proc']  = 'apertura';
}


?>
     
        <!--<div class="panel panel-default"> -->
        <table border="0" width="100%" class="table">
            <tbody>
                <tr>
                    <td>

                        <!-- Bloque de procesos  -->
                        <div class="btn-group">
                            <?php
                            foreach ($datos['procesos']['bloques_procesos'] as $key => $value) {

                                $space = '';
                                if (strlen($key) < $datosConfig['btn_longitud']) {
                                    $rellenar = $datosConfig['btn_longitud'] - (strlen($key));
                                    for ($i = 0; $i <= $rellenar; $i++) {
                                        $space .= '&numsp;';
                                    }
                                }

                                echo '<div class="btn-group">'
                                . '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">' .
                                substr($key, 0, 20) . $space . ' <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">';

                                foreach ($datos['procesos']['bloques_procesos'][$key] as $key2 => $value2) {
                                    echo '<li><a href="?app=inicioconfig&tab=1&fs=bprocesos&bproc=' . $key . '&proc=' . $key2 . '">' . $key2 . '</a></li>';
                                }

                                echo '</ul></div><br><br>';
                            }
                            ?>

                        </div>
                        <!-- FIN Bloque de procesos  -->

                    </td>


                    <td>
                        <!-- Procesos  -->
                        <div class="panel panel-default">
                            <div class="panel-heading">Bloque:<b><i><?php echo $datosGet['bproc'] . '</i></b>&numsp;&numsp; Proceso:<b><i>' . $datosGet['proc'] ?></i></b></div>
                            <table width="100%" border="0" class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th colspan="2">gedee_proceso</th>
                                    </tr>
                                </thead>
                                <tr><td align="right" width="20%">&numsp;&numsp;namespace:</td>
                                    <td>&numsp;
                                        <div class="col-lg-11">
                                            <input class="form-control input-sm" id="disabledInput" type="text" name="datos[procesos][bloques_procesos][<?php echo $datosGet['bproc']?>][<?php echo $datosGet['proc']?>][gedee_proceso][namespace]" value="<?php echo $datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['gedee_proceso']['namespace'] ?>">
                                        </div>
                                    </td>
                                </tr>
                                <tr><td align="right">&numsp;&numsp;clase:</td>
                                    <td>&numsp;
                                        <div class="col-lg-10">
                                            <!-- path_entidad_clase -->
                                            <input class="form-control input-sm" type="text" name="datos[procesos][bloques_procesos][<?php echo $datosGet['bproc']?>][<?php echo $datosGet['proc']?>][gedee_proceso][clase]" value="<?php echo $datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['gedee_proceso']['clase'] ?>"/>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td align="right">&numsp;&numsp;id_entidad:</td>
                                    <td>&numsp;
                                        <div class="col-lg-8">
                                            <!-- referencia_path_entidad -->
                                            <input class="form-control input-sm" type="text" name="datos[procesos][bloques_procesos][<?php echo $datosGet['bproc']?>][<?php echo $datosGet['proc']?>][gedee_proceso][id_entidad]" value="<?php echo $datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['gedee_proceso']['id_entidad'] ?>"/>
                                        </div>
                                    </td>
                                </tr>
                                <thead>
                                    <tr>
                                        <th width="20%" colspan="2">propiedades_implementacion_proceso</th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td align="right">&numsp;&numsp;path_raiz:</td>
                                    <td>&numsp;
                                        <div class="col-lg-8">
                                            <input class="form-control input-sm" type="text" name="datos[procesos][bloques_procesos][<?php echo $datosGet['bproc']?>][<?php echo $datosGet['proc']?>][propiedades_implementacion_proceso][path_raiz]" value="<?php echo $datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['propiedades_implementacion_proceso']['path_raiz'] ?>"/>

                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">&numsp;&numsp;path_arranque:</td>
                                    <td>&numsp;
                                        <div class="col-lg-10">
                                            <input class="form-control input-sm" type="text" name="datos[procesos][bloques_procesos][<?php echo $datosGet['bproc']?>][<?php echo $datosGet['proc']?>][propiedades_implementacion_proceso][path_arranque]" value="<?php echo $datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['propiedades_implementacion_proceso']['path_arranque'] ?>"/>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">&numsp;&numsp;obligatoriedad:</td>
                                    <td>&numsp;
                                        <div class="col-lg-10">
                                            <select class="form-control input-sm" name="datos[procesos][bloques_procesos][<?php echo $datosGet['bproc'] ?>][<?php echo $datosGet['proc'] ?>][propiedades_implementacion_proceso][obligatoriedad]">
                                                <?php
                                                $varBool = array("1" => 'TRUE', "0" => 'FALSE');
                                                $valor = $datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['propiedades_implementacion_proceso']['obligatoriedad'];
                                                foreach ($varBool as $key => $value) {
                                                    if ($key == $valor) {
                                                        echo '<option value="'.$key.'" selected="selected">' . $value . '</option>';
                                                    } else {
                                                        echo '<option value="'.$key.'">' . $value . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>                                            
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right">&numsp;&numsp;condicion_ejecucion:</td>
                                    <td>&numsp;
                                        <div class="col-lg-10">
                                            <input class="form-control input-sm" type="text" name="datos[procesos][bloques_procesos][<?php echo $datosGet['bproc']?>][<?php echo $datosGet['proc']?>][propiedades_implementacion_proceso][condicion_ejecucion]" value="<?php echo $datos['procesos']['bloques_procesos'][$datosGet['bproc']][$datosGet['proc']]['propiedades_implementacion_proceso']['condicion_ejecucion'] ?>"/>
                                        </div>
                                    </td>
                                </tr>
                            </table>                                
                        </div>
                        <!-- FIN  Procesos  -->

                    </td>
                </tr>
            </tbody>
        </table>
        <!--</div>-->