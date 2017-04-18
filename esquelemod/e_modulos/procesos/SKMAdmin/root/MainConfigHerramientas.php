<?php 
//include $path2loadAbs . 'root/MainConfigHerramientasModalWindows.php'; 
include $path2loadAbs . 'root/ModalWindows.php';
?>

<table width="90%" border="0" align="center">
    <tr><td>
            <?php
            $Keys = array_keys($datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas']);

            foreach ($Keys as $key => $llaves1) {
                if (is_array($datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'][$llaves1])) {
                    ?>
                    <div class = "panel panel-default">
                        <div class = "panel-heading"><?php echo $llaves1 ?></div>
                        <div class = "panel-body">
                            <?php
                            echo '<table width="100%">';
                            // path_entidad_clase
                            echo '<tr><td align="right">&numsp;&numsp;path_entidad_clase:</td><td>&numsp;<div class="col-lg-10"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . $llaves1 . '][' . 'path_entidad_clase' . ']" value="' . $datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'][$llaves1]['path_entidad_clase'] . '" /></div></td></tr>';
                            // referencia_path_entidad
                            echo '<tr><td align="right">&numsp;&numsp;referencia_path_entidad:</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . $llaves1 . '][' . 'referencia_path_entidad' . ']" value="' . $datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'][$llaves1]['referencia_path_entidad'] . '" /></div></td></tr>';
                            // tipo_entidad
                            echo '<tr><td align="right">&numsp;&numsp;tipo_entidad:</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . $llaves1 . '][' . 'tipo_entidad' . ']" value="' . $datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'][$llaves1]['tipo_entidad'] . '" /></div></td></tr>';
                            // instancias
                            echo '<tr><td align="right">&numsp;&numsp;instancias/' . $llaves1 . ':</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . $llaves1 . '][' . 'instancias' . '][' . $llaves1 . ']" value="' . $datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'][$llaves1]['instancias'][$llaves1] . '" /></div></td></tr>';
                            echo '</table>';
                            ?>
                        </div>
                    </div>
                    <?php
                } else {
                    
                }
            }
            ?>
        </td>
    </tr>
</table>
<!--
<select name="lista">
    <option>1aas</option>
    <option selected="true">2cvc</option>
    <option>3ggff</option>
</select>

<input name="form_url" id="form_url" type="url" list="url_list">  
    <datalist id="url_list">  
        <option value="http://www.google.com" label="Google" selected="true">  
        <option value="http://net.tutsplus.com" label="NetTuts+">  
    </datalist>
-->