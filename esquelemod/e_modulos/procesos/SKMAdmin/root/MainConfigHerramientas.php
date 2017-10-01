<?php 
//include $path2loadAbs . 'root/MainConfigHerramientasModalWindows.php'; 
//include $path2loadAbs . 'root/ModalWindows.php';
?>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <?php
        $Keys = array_keys($datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas']);

        foreach ($Keys as $key => $llaves1) {
            if (is_array($datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'][$llaves1])) {
                ?> 
                <div class = "panel panel-default">
                    <div class = "panel-heading"><?php echo $llaves1 ?></div>
                    <div class = "panel-body">

                        <div class="form-group">
                            <label for="version" class="col-sm-3 control-label input-label11">path_entidad_clase:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control input-sm" id="version" name="datos[herramientas][existentes_sistema][\Emod\Nucleo\Herramientas][<?php echo $llaves1 ?>][path_entidad_clase]" value="<?php echo $datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'][$llaves1]['path_entidad_clase'] ?>" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="version" class="col-sm-3 control-label input-label11">referencia_path_entidad:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control input-sm" id="version" name="datos[herramientas][existentes_sistema][\Emod\Nucleo\Herramientas][<?php echo $llaves1 ?>][referencia_path_entidad]" value="<?php echo $datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'][$llaves1]['referencia_path_entidad'] ?>" placeholder="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="version" class="col-sm-3 control-label input-label11">tipo_entidad:</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control input-sm" id="version" name="datos[herramientas][existentes_sistema][\Emod\Nucleo\Herramientas][<?php echo $llaves1 ?>][tipo_entidad]" value="<?php echo $datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'][$llaves1]['tipo_entidad'] ?>" placeholder="">
                            </div>
                        </div>                            
                        <div class="form-group">
                            <label for="version" class="col-sm-3 control-label input-label11">instancias/ <?php echo $llaves1 ?> :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control input-sm" id="version" name="datos[herramientas][existentes_sistema][\Emod\Nucleo\Herramientas][<?php echo $llaves1 ?>][instancias][<?php echo $llaves1 ?>]" value="<?php echo $datos['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'][$llaves1]['instancias'][$llaves1] ?>" placeholder="">
                            </div>
                        </div>                            

                    </div>
                </div>
                <?php
            } else {
                
            }
        }
        ?>
    </div>
</div>