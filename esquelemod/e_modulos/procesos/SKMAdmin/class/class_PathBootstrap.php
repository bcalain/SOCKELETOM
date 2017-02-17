<?php

$pathAbsBootstrap = $this->EEoDatos->accederDatosSalidaProceso('bootstrap', 'GedeeEComun', 'GedeeEComun', '\Emod\Nucleo\Gedees', '["paths"]');
$buscar = $pathAbsBootstrap['path_raiz_cms-bootstrap'];
$pathRelBootstrap = str_replace($path2loadEsquelemod, 'esquelemod/', $buscar);



