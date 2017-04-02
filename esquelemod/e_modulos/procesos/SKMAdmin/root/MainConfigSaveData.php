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
if (is_array($_POST['datos'])) 
{
    $datosOriginal = \Emod\Nucleo\Herramientas\Spyc::YAMLLoad($path2loadEsquelemod . 'e_sistema/e_sistema_config.cnf', true);

    $obj = new class_Validar();
    //$datosModificado = $obj->htmlentitiesGetPost($_POST);
    $datosModificado = $_POST['datos'];

    // Comprobaciones adicionales
    switch ($_GET['seccion']) {
        case 'sistema':
            // La sessión de configuración del sistema no requiere comprobaciones adicionales

            break;
        
        case 'herramientas':
            // Si se agrega una nueva herramienta
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
            
        case 'editherramienta':
            // Si se escoge la opcion "Edicion de Herramientas de SKM"
            // Comprobamos que el dato exista.
            if(!$obj->required($datosModificado['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas']['Spyc']['path_entidad_clase'])){
                $success = FALSE;
                continue;
            }
            
            //var_dump($datosModificado['herramientas']['existentes_sistema']['\Emod\Nucleo\Herramientas']['Spyc']['path_entidad_clase']);
            
            /*$contenidoFichPHP = "<?php \n" . '$datos = ' . var_export($datosModificado, true) . "\n?>";
            //file_put_contents("d:/TMP/datosModificado.php", $contenidoFichPHP);
            //die();*/
            

            break;
            
        default:
            break;
    }

    $arrayResult = array_replace_recursive($datosOriginal, $datosModificado);

    if ($arrayResult != $datosOriginal) {
        $structYaml = \Emod\Nucleo\Herramientas\Spyc::YAMLDump($arrayResult, 4);

        // Despues de guardada la conf tomamos T o F para pasarlo hacia InicioConfig
        $success = (file_put_contents($path2loadEsquelemod . 'e_sistema/e_sistema_config.cnf', $structYaml)) ? true : false;
    }
} else {
    $success = false;
}

/*
  if (is_array($_POST['datos'])) {
  $datosModificado = $_POST['datos'];
  // Comprobar si hay cambios que guardar
  $keysDatosModificado = array_keys($datosModificado);
  if ($datosOriginal[$keysDatosModificado[0]] != $datosModificado[$keysDatosModificado[0]]) {
  $arrayResult = array_replace($datosOriginal, $datosModificado);
  $struct_yaml = \Emod\Nucleo\Herramientas\Spyc::YAMLDump($arrayResult, 4);

  // Después de guardada la conf tomamos T o F para pasarlo hacia InicioConfig
  $success = (file_put_contents("esquelemod/e_sistema/e_sistema_config.cnf", $struct_yaml)) ? true : false;
  }
  } else {
  $success = false;
  }
 */


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
    default:
        break;
}
