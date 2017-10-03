<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
       
        <meta name="Description" content="SKM" />
        <meta name="Keywords" content="SKMAdmin, SKM, Framework, Sockeletom" />
         <title>Sockeletom</title>

        <style type="text/css">
            .inicio{
                margin-top:30px;
                padding:10px;
                font-size:12px;
                font-family:Verdana;
                background-color: #E7E7FD;
            }
        </style>
    </head>
    <body>
        <?php
        $path2load = 'esquelemod/e_modulos/procesos/' . $this->EEoNucleo->pathDirRaizProcesoEjecucion(['propiedades_proceso']) . '/';
        $array = $this->EEoNucleo->accesoPropiedadesEsquelemod();
        $versionSKM = $array['version_sistema'];
        ?>
        <div id="wrap">

            <div style="text-align: center">
                <div class="text-center"><a href=""><img src="<?php echo $path2load ?>images/logo.png" class="text-center" alt="Sockeletom" /></a></div>
                <h1>BIENVENIDOS A SOCKELETOM </h1><?php echo 'Versión ' . $versionSKM; ?>
                <p class="inicio"><b>Sockeletom.</b> "Un framework para unirlos a todos"</p>
            </div>
        </div>
    </body>
</html>
