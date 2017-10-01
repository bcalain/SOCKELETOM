<?php 
//include $path2loadAbs . 'root/MainConfigSistemaModalWindows.php'; 
//include $path2loadAbs . 'root/ModalWindows.php';

/* Arreglo con los nombres que se van a mostrar en el formulario */
$nombrePropiedad = array(
                "Versión",
                "id proceso",
                "namespace gedee",
                "Clase gedee",
                "id gedee",
                "Dependencias",
                "Conflictos");
?>


<div class="row">

    <div class="col-md-1"></div>
    <div class="col-md-10">
        
            <div class="form-group">
                <label for="version" class="col-sm-3 control-label input-label"><?php echo $nombrePropiedad[0] ?></label>
                <div class="col-sm-8">
                    <input type="tel" class="form-control input-sm" id="version" name="datos[sistema][propiedades_proceso][version_sistema]" value="<?php echo $datos['sistema']['propiedades_proceso']['version_sistema'] ?>" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="id_proceso" class="col-sm-3 control-label input-label"><?php echo $nombrePropiedad[1] ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="id_proceso" name="datos[sistema][propiedades_proceso][id_proceso]" value="<?php echo $datos['sistema']['propiedades_proceso']['id_proceso'] ?>" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="namespace_gedee" class="col-sm-3 control-label input-label"><?php echo $nombrePropiedad[2] ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="namespace_gedee" name="datos[sistema][propiedades_proceso][namespace_gedee]" value="<?php echo $datos['sistema']['propiedades_proceso']['namespace_gedee'] ?>" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="clase_gedee" class="col-sm-3 control-label input-label"><?php echo $nombrePropiedad[3] ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="clase_gedee" name="datos[sistema][propiedades_proceso][clase_gedee]" value="<?php echo $datos['sistema']['propiedades_proceso']['clase_gedee'] ?>" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="id_gedee" class="col-sm-3 control-label input-label"><?php echo $nombrePropiedad[4] ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="id_gedee" name="datos[sistema][propiedades_proceso][id_gedee]" value="<?php echo $datos['sistema']['propiedades_proceso']['id_gedee'] ?>" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="dependencias" class="col-sm-3 control-label input-label"><?php echo $nombrePropiedad[5] ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="dependencias" name="datos[sistema][propiedades_proceso][dependencias]" value="<?php echo $datos['sistema']['propiedades_proceso']['dependencias'] ?>" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="conflictos" class="col-sm-3 control-label input-label"><?php echo $nombrePropiedad[6] ?></label>
                <div class="col-sm-8">
                    <input type="text" class="form-control input-sm" id="conflictos" name="datos[sistema][propiedades_proceso][conflictos]" value="<?php echo $datos['sistema']['propiedades_proceso']['conflictos'] ?>" placeholder="">
                </div>
            </div>
       
        
        
        
        <table width="90%" border="0">
            <?php /*
            // Versión del sistema
            echo '<tr><td class="text-right">' . $nombrePropiedad[0] . ':</td><td><div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'sistema' . '][' . 'propiedades_proceso' . '][' . 'version_sistema' . ']" value="' . $datos['sistema']['propiedades_proceso']['version_sistema'] . '" /></div></td></tr>';
            // id proceso
            echo '<tr><td class="text-right">' . $nombrePropiedad[1] . ':</td><td><div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'sistema' . '][' . 'propiedades_proceso' . '][' . 'id_proceso' . ']" value="' . $datos['sistema']['propiedades_proceso']['id_proceso'] . '" /></div></td></tr>';
            // namespace gedee
            echo '<tr><td class="text-right">' . $nombrePropiedad[2] . ':</td><td><div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'sistema' . '][' . 'propiedades_proceso' . '][' . 'namespace_gedee' . ']" value="' . $datos['sistema']['propiedades_proceso']['namespace_gedee'] . '" /></div></td></tr>';
            // clase gedee
            echo '<tr><td class="text-right">' . $nombrePropiedad[3] . ':</td><td><div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'sistema' . '][' . 'propiedades_proceso' . '][' . 'clase_gedee' . ']" value="' . $datos['sistema']['propiedades_proceso']['clase_gedee'] . '" /></div></td></tr>';
            // id gedee
            echo '<tr><td class="text-right">' . $nombrePropiedad[4] . ':</td><td><div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'sistema' . '][' . 'propiedades_proceso' . '][' . 'id_gedee' . ']" value="' . $datos['sistema']['propiedades_proceso']['id_gedee'] . '" /></div></td></tr>';
            // dependencias
            echo '<tr><td class="text-right">' . $nombrePropiedad[5] . ':</td><td><div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'sistema' . '][' . 'propiedades_proceso' . '][' . 'dependencias' . ']" value="' . $datos['sistema']['propiedades_proceso']['dependencias'] . '" /></div></td></tr>';
            // conflictos
            echo '<tr><td class="text-right">' . $nombrePropiedad[6] . ':</td><td><div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'sistema' . '][' . 'propiedades_proceso' . '][' . 'conflictos' . ']" value="' . $datos['sistema']['propiedades_proceso']['conflictos'] . '" /></div></td></tr>';
          */  ?>
        </table>
    </div>
    <div class="col-md-1"></div>
</div>