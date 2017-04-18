<?php
$path2loadEsquelemod = $this->EEoNucleo->pathDirEsquelemod() . '/';
$path2loadAbs = $this->EEoNucleo->pathAbsolutoDirRaizProcesoEjecucion() . '/';

require_once $path2loadEsquelemod . 'e_modulos/nucleo/nucleo_bib_funciones/herramientas/spyc.php';
require_once $path2loadAbs . '../class/class_Validar.php';


/*
  $contenidoFichPHP = "<?php \n" . '$datos = ' . var_export($datosOriginal['herramientas']['existentes_sistema'], true) . "\n?>";
  //file_put_contents("d:/TMP/original.php", $contenidoFichPHP);
  //die();
 */
if (is_array($_POST)) 
{
    $datosOriginal = \Emod\Nucleo\Herramientas\Spyc::YAMLLoad($path2loadEsquelemod . 'e_sistema/e_sistema_config.cnf', true);

    $obj = new class_Validar();
    //$datosModificado = $obj->htmlentitiesGetPost($_POST);
    
    if (isset($_POST['datos'])) {
        $datosModificado = $_POST['datos'];
    }
    
    $success = TRUE;
    // Comprobaciones adicionales
    switch ($_GET['seccion']) 
    {
        case 'sistema': // La sessión de configuración del sistema no requiere comprobaciones adicionales
                break;
        
        case 'herramientas': // Si se agrega una nueva herramienta
                if (isset($_POST['datosAddHerramienta']) && $_POST['datosAddHerramienta'] != "") {
                    $datosHerramienta = $_POST['datosAddHerramienta'];


                    if(isset($datosOriginal['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas'][$datosHerramienta])){
                        die("EXISTE");
                    }

                    $datosModificado = array('herramientas' =>
                        array('existentes_sistema' =>
                            array('\Emod\Nucleo\Herramientas' =>
                                array($datosHerramienta =>
                                    array(
                                        'path_entidad_clase' => '',
                                        'referencia_path_entidad' => 'relativo_esquelemod',
                                        'tipo_entidad' => 'clase',
                                        'instancias' =>
                                        array(
                                            $datosHerramienta => '',
                                        )
                                    )
                                )
                            )
                        )
                    );
                }

                break;

        case 'editherramienta': // Si se escoge la opcion "Edicion de Herramientas de SKM"
                // Comprobamos que el dato exista.
                if(!$obj->required($datosModificado['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas']['Spyc']['path_entidad_clase'])){
                    $success = FALSE;
                    continue;
                }
                break;

        case 'addbloquesprocesos': // Si se agrega un nuevo bloque de procesos
                // Comprobamos que el dato exista.
                if (!$obj->required($_POST['datosAddBloque'])) {
                    $success = FALSE;

                } elseif (isset($datosOriginal['procesos']['bloques_procesos'][$_POST['datosAddBloque']])) {
                    $success = FALSE;

                } else {
                    $nuevoBloque = $_POST['datosAddBloque'];

                    $datosModificado = array('procesos' =>
                        array('bloques_procesos' =>
                            array($nuevoBloque =>
                                array('proceso1' =>
                                    array(
                                        'gedee_proceso' =>
                                        array(
                                            'namespace' => '\\Emod\\Nucleo\\Gedees',
                                            'clase' => 'GedeeEComun',
                                            'id_entidad' => 'GedeeEComun',
                                        ),
                                        'propiedades_implementacion_proceso' =>
                                        array(
                                            'path_raiz' => '',
                                            'path_arranque' => '',
                                            'obligatoriedad' => 1,
                                            'condicion_ejecucion' => '',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    );
                }
                break;
            
        
        case 'bloquesprocesos':
                break;

        
        case 'addproceso': // Si se agrega un nuevo proceso

                // Comprobamos que el dato exista.
                if (!$obj->required($_POST['datosAddProceso'])) {
                    $success = FALSE;

                } elseif (isset($datosOriginal['procesos']['bloques_procesos'][$_POST['datoBloque']][$_POST['datosAddProceso']])) {
                    $success = FALSE;

                } else {
                    $nuevoBloque  = $_POST['datoBloque'];
                    $nuevoProceso = $_POST['datosAddProceso'];

                    $datosModificado = array('procesos' =>
                        array('bloques_procesos' =>
                            array($nuevoBloque =>
                                array($nuevoProceso =>
                                    array(
                                        'gedee_proceso' =>
                                        array(
                                            'namespace' => '\\Emod\\Nucleo\\Gedees',
                                            'clase' => 'GedeeEComun',
                                            'id_entidad' => 'GedeeEComun',
                                        ),
                                        'propiedades_implementacion_proceso' =>
                                        array(
                                            'path_raiz' => '',
                                            'path_arranque' => '',
                                            'obligatoriedad' => 1,
                                            'condicion_ejecucion' => '',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    );

                }
                break;
                
        default:
                break;
    }

    
    if ($success == TRUE) {
        $arrayResult = array_replace_recursive($datosOriginal, $datosModificado);

        if ($arrayResult != $datosOriginal) {
            $structYaml = \Emod\Nucleo\Herramientas\Spyc::YAMLDump($arrayResult, 4);

            // Despues de guardada la conf tomamos T o F para pasarlo hacia InicioConfig
            $success = (\file_put_contents($path2loadEsquelemod . 'e_sistema/e_sistema_config.cnf', $structYaml)) ? true : false;
        }
    }
} else {
    $success = false;
}


/**
 * Siempre regresamos a mostrar la misma sección de configuración guardada
 */
switch ($_GET['seccion']) {
    case 'sistema':
        header('Location: ?app=inicioconfig&tab=1&fs=sistema&success=' . $success);

        break;
    case 'herramientas':
        header('Location: ?app=inicioconfig&tab=1&fs=herramientas&success=' . $success);

        break;
    case 'editherramienta':
        header('Location: ?app=inicioconfig&tab=0&fs=inicio&success=' . $success);
        
        break;
    case 'bloquesprocesos':
        header('Location: ?app=inicioconfig&tab=1&fs=bprocesos&success=' . $success);
 
    case 'addbloquesprocesos':
        header('Location: ?app=inicioconfig&tab=1&fs=bprocesos&success=' . $success);
        
        break;
    case 'addproceso':
        header('Location: ?app=inicioconfig&tab=1&fs=bprocesos&success=' . $success);
        
        break;    
    default:
        break;
}
