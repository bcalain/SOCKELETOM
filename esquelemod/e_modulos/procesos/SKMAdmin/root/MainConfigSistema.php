<?php 
//include $path2loadAbs . 'root/MainConfigSistemaModalWindows.php'; 
include $path2loadAbs . 'root/ModalWindows.php';
?>
<table width="90%" border="0" align="center">
    <?php
    /* Arreglo con los nombres que se van a mostrar en el formulario */
    $nombrePropiedad = array(
        "Versión del sistema",
        "id proceso",
        "namespace gedee",
        "Clase gedee",
        "id gedee",
        "Dependencias",
        "Conflictos");
    // Versión del sistema
    echo '<tr><td align="right">&numsp;&numsp;' . $nombrePropiedad[0] . ':</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'sistema' . '][' . 'propiedades_proceso' . '][' . 'version_sistema' . ']" value="' . $datos['sistema']['propiedades_proceso']['version_sistema'] . '" /></div></td></tr>';
    // id proceso
    echo '<tr><td align="right">&numsp;&numsp;' . $nombrePropiedad[1] . ':</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'sistema' . '][' . 'propiedades_proceso' . '][' . 'id_proceso' . ']" value="' . $datos['sistema']['propiedades_proceso']['id_proceso'] . '" /></div></td></tr>';
    // namespace gedee
    echo '<tr><td align="right">&numsp;&numsp;' . $nombrePropiedad[2] . ':</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'sistema' . '][' . 'propiedades_proceso' . '][' . 'namespace_gedee' . ']" value="' . $datos['sistema']['propiedades_proceso']['namespace_gedee'] . '" /></div></td></tr>';
    // clase gedee
    echo '<tr><td align="right">&numsp;&numsp;' . $nombrePropiedad[3] . ':</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'sistema' . '][' . 'propiedades_proceso' . '][' . 'clase_gedee' . ']" value="' . $datos['sistema']['propiedades_proceso']['clase_gedee'] . '" /></div></td></tr>';
    // id gedee
    echo '<tr><td align="right">&numsp;&numsp;' . $nombrePropiedad[4] . ':</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'sistema' . '][' . 'propiedades_proceso' . '][' . 'id_gedee' . ']" value="' . $datos['sistema']['propiedades_proceso']['id_gedee'] . '" /></div></td></tr>';
    // dependencias
    echo '<tr><td align="right">&numsp;&numsp;' . $nombrePropiedad[5] . ':</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'sistema' . '][' . 'propiedades_proceso' . '][' . 'dependencias' . ']" value="' . $datos['sistema']['propiedades_proceso']['dependencias'] . '" /></div></td></tr>';
    // conflictos
    echo '<tr><td align="right">&numsp;&numsp;' . $nombrePropiedad[6] . ':</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'sistema' . '][' . 'propiedades_proceso' . '][' . 'conflictos' . ']" value="' . $datos['sistema']['propiedades_proceso']['conflictos'] . '" /></div></td></tr>';
    ?>
</table>