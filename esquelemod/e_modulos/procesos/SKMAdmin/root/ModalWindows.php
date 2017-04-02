<!DOCTYPE html>
<!--
Muestra las ventanas modales "Ayuda" y "Agregar"
-->
<?php
switch ($_GET['fs']) {
    case 'sistema':
        $IncluirContenido = 'root/ModalMainConfigSistemaIncluir.php';
        break;

    case 'herramientas':
        $IncluirContenido  = 'root/ModalMainConfigHerramientasIncluir.php';
        $IncluirContenido2 = 'root/ModalMainConfigHerraEditIncluir.php';
        $frmAction = '?app=savemainconfig&seccion=herramientas';
        $titulo = 'Nueva Herramienta';
        $comentario = 'Después de agregada la herramienta modifique los parámetros.';
        break; 
    
    case 'editherramienta':
        $IncluirContenido  = 'root/ModalMainConfigHerramientasIncluir.php';
        $IncluirContenido2 = '';
        $frmAction = '';
        $titulo = '';
        $comentario = '';
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
                    <h4 class="modal-title" id="myModalLabel"><?php echo $titulo ?></h4>
                </div>

                
                 <?php 
                 if($IncluirContenido2 != ''){
                 include $path2loadAbs . $IncluirContenido2; 
                 }
                 ?>
                
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div><!-- /.modal-content --></form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->