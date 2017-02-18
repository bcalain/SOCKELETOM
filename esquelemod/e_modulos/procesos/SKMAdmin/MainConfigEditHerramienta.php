<?php
/*
 * Cuadro de "Editar herramienta" de "Herramienta del sistema" de ventana de inicio
 */
$tool       = trim(filter_input(INPUT_GET,'tool',FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH));
$entidad    = trim(filter_input(INPUT_GET,'entidad',FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH));
$referencia = trim(filter_input(INPUT_GET,'referencia',FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH));
$tipo       = filter_input(INPUT_GET,'tipo',FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH);


?>


<div class="modal-body">
    <div class = "panel-body">
        <!-- Muestra un comentario
        <div class="alert alert-info ">
        <?php //echo $comentario ?>
        </div>
        -->
        <table width="100%">
            <tr><td align="right">&numsp;&numsp;Nombre:</td><td>&numsp;<div class="col-lg-10"><input class="form-control input-sm" type="text" name="datosAddHerramienta" value="<?php echo $tool ?>" /></div></td></tr>
            <tr><td>
                </td></tr>

            <?php

            // path_entidad_clase
            echo '<tr><td align="right">&numsp;&numsp;path_entidad_clase:</td><td>&numsp;<div class="col-lg-10"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . $tool . '][' . 'path_entidad_clase' . ']" value="'.$entidad.'" /></div></td></tr>';
            // referencia_path_entidad
            echo '<tr><td align="right">&numsp;&numsp;referencia_path_entidad:</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . $tool . '][' . 'referencia_path_entidad' . ']" value="'.$referencia.'" /></div></td></tr>';
            // tipo_entidad
            echo '<tr><td align="right">&numsp;&numsp;tipo_entidad:</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . $tool . '][' . 'tipo_entidad' . ']" value="'.$tipo.'" /></div></td></tr>';
            // instancias
            echo '<tr><td align="right">&numsp;&numsp;instancias/' . $tool . ':</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . $tool . '][' . 'instancias' . '][' . $tool . ']" value="" /></div></td></tr>';
            echo '';
            ?>
        </table>
    </div>
</div>

