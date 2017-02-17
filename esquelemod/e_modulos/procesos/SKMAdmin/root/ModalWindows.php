<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
switch ($_GET['fs']) {
    case 'sistema':
        $IncluirContenido = 'root/ModalMainConfigSistemaIncluir.php';
        break;

    case 'herramientas':
        $IncluirContenido = 'root/ModalMainConfigHerramientasIncluir.php';
        $frmAction = "?app=savemainconfig&seccion=herramientas";
        $nuevaHerramienta = 'Nueva Herramienta';
        $comentario = 'Después de agregada la herramienta modifique los parámetros.';
        break;    
    default:
        break;
}
?>
<div class="modal fade" id="myModalHelp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-question-sign"></span> AYUDA. Valores referentes al sistema</h4>
            </div>


            <?php include $path2loadAbs . $IncluirContenido; ?>

            <div align="center">
                <label class="milabel" align="center">Puede descargar la ayuda completa en <a href="https://github.com/bcalain/SOCKELETOM/blob/master/Sockeletom%20Manual.pdf" target="external" title="Ayuda SKM">http://www.github.com </a></label>
            </div>            
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Modal Agregar una nueva Herramienta -->
<div class="modal fade" id="myModalAgregar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action=<?php echo $frmAction ?>>
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><?php echo $nuevaHerramienta ?></h4>
                </div>
                <div class="modal-body">
                    <div class = "panel-body">
                        <div class="alert alert-info ">
                            <?php echo $comentario ?>
                        </div>
                        <table width="100%">
                            <tr><td align="right">&numsp;&numsp;Nombre:</td><td>&numsp;<div class="col-lg-10"><input class="form-control input-sm" type="text" name="datosAddHerramienta" value="" /></div></td></tr>
                            <tr><td>
                                </td></tr>

                            <?php
                            /**
                              echo '';

                              // path_entidad_clase
                              echo '<tr><td align="right">&numsp;&numsp;path_entidad_clase:</td><td>&numsp;<div class="col-lg-10"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . '' . '][' . 'path_entidad_clase' . ']" value="" /></div></td></tr>';
                              // referencia_path_entidad
                              echo '<tr><td align="right">&numsp;&numsp;referencia_path_entidad:</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . '' . '][' . 'referencia_path_entidad' . ']" value="" /></div></td></tr>';
                              // tipo_entidad
                              echo '<tr><td align="right">&numsp;&numsp;tipo_entidad:</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . '' . '][' . 'tipo_entidad' . ']" value="" /></div></td></tr>';
                              // instancias
                              echo '<tr><td align="right">&numsp;&numsp;instancias/' . '' . ':</td><td>&numsp;<div class="col-lg-8"><input class="form-control input-sm" type="text" name="datos[' . 'herramientas' . '][' . 'existentes_sistema' . '][' . '\Emod\Nucleo\Herramientas' . '][' . '' . '][' . 'instancias' . '][' . '' . ']" value="" /></div></td></tr>';
                              echo '';
                             * * */
                            ?>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div><!-- /.modal-content --></form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->