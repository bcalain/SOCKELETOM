<!--
Cuadro de "Agregar Proceso" de "Valores referentes a bloques de procesos" del fichero de configuración
-->
<div class="modal-body">
    <div class = "panel-body">
        <div class="col-lg-12">
            <input class="form-control input-sm" type="text" name="datosAddProceso" value="" placeholder="Nombre proceso" autofocus/>
        </div> 
        <div class="col-lg-12"><br />
            Agregar en el bloque:
            <select class="form-control input-sm" name="datoBloque">
                <?php
                $valor = $datos['procesos']['bloques_procesos'];
                foreach ($valor as $key => $value) {

                        echo '<option value="' . $key . '">' . $key . '</option>';

                }
                ?>
            </select>
        </div>         
    </div>
</div>