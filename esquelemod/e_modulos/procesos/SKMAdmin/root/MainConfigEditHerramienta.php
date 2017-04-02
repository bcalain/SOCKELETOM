<?php
/*
 * Cuadro de "Editar herramienta" de "Herramienta del sistema" de ventana de inicio
 */
$obj = new class_Validar();

if(!$obj->filtrarSpecialChars(array('tool', 'entidad', 'referencia', 'tipo')))
{
    die('Existen errores en el filtrado de los datos');
}

//$datosGet = $obj->htmlentitiesGetPost($_GET);
$datosGet = $_GET;
?>

<div class="modal-body">
    <div class = "panel-body">
        <!-- Muestra un comentario
        <div class="alert alert-info ">
        <?php //echo $comentario ?>
        </div>
        -->
        <table width="100%">
            <tr><td align="right">&numsp;&numsp;Nombre:</td>
                <td>&numsp;
                    <div class="col-lg-10">
                        <input class="form-control input-sm" id="disabledInput" type="text" name="datos[herramientas][existentes_sistema][\Emod\Nucleo\Herramientas]" value="<?php echo $datosGet['tool'] ?>" disabled>
                    </div>
                </td>
            </tr>
            <tr><td align="right">&numsp;&numsp;path_entidad_clase:</td>
                <td>&numsp;
                    <div class="col-lg-10">
                        <!-- path_entidad_clase -->
                        <input class="form-control input-sm" type="text" name="datos[herramientas][existentes_sistema][\Emod\Nucleo\Herramientas][<?php echo $datosGet['tool']?>][path_entidad_clase]" value="<?php echo $datosGet['entidad'] ?>"/>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">&numsp;&numsp;referencia_path_entidad:</td>
                <td>&numsp;
                    <div class="col-lg-8">
                        <!-- referencia_path_entidad -->
                        <select class="form-control input-sm" name="datos[herramientas][existentes_sistema][\Emod\Nucleo\Herramientas][<?php echo $datosGet['tool']?>][referencia_path_entidad]">
                            <?php                            
                            $valor = array('relativo','relativo_esquelemod','absoluto');
                            foreach ($valor as $key => $value) {
                                if($value === $datosGet['referencia']){
                                    echo '<option selected="selected">'.$value.'</option>';
                                }else{
                                    echo '<option>'.$value.'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">&numsp;&numsp;tipo_entidad:</td>
                <td>&numsp;
                    <div class="col-lg-8">
                        <select class="form-control input-sm" name="datos[herramientas][existentes_sistema][\Emod\Nucleo\Herramientas][<?php echo $datosGet['tool']?>][tipo_entidad]">
                            <?php                            
                            $valor2 = array('clase','objeto');
                            foreach ($valor2 as $key => $value) {
                                if($value === $datosGet['tipo']){
                                    echo '<option selected="selected">'.$value.'</option>';
                                }else{
                                    echo '<option>'.$value.'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="right">&numsp;&numsp;instancias / <?php echo $datosGet['tool'] ?> :</td>
                <td>&numsp;
                    <div class="col-lg-10">
                        <textarea class="form-control input-sm" rows="5"  name="datos[herramientas][existentes_sistema][\Emod\Nucleo\Herramientas][<?php echo $datosGet['tool'] ?>][instancias][<?php echo $datosGet['tool'] ?>]">
                        <?php echo trim($datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'][$datosGet['tool']]['instancias'][$datosGet['tool']]) ?>
                        </textarea>
                    </div>
                </td>
            </tr>
            <?php

            // path_entidad_clase
            //echo '<tr><td align="right">&numsp;&numsp;path_entidad_clase:</td><td>&numsp;<div class="col-lg-10"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . $datosGet['tool'] . '][' . 'path_entidad_clase' . ']" value="'.$datosGet['entidad'].'" /></div></td></tr>';
            // referencia_path_entidad
            //echo '<tr><td align="right">&numsp;&numsp;referencia_path_entidad:</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . $datosGet['tool'] . '][' . 'referencia_path_entidad' . ']" value="'.$datosGet['referencia'].'" /></div></td></tr>';
            // tipo_entidad
            //echo '<tr><td align="right">&numsp;&numsp;tipo_entidad:</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . $datosGet['tool'] . '][' . 'tipo_entidad' . ']" value="'.$datosGet['tipo'].'" /></div></td></tr>';
            // instancias
            //echo '<tr><td align="right">&numsp;&numsp;instancias/' . $datosGet['tool'] . ':</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . $datosGet['tool'] . '][' . 'instancias' . '][' . $datosGet['tool'] . ']" value="" /></div></td></tr>';
            //echo '';
            ?>
        </table>
    </div>
</div>

