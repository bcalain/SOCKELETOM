<?php
                                             

$datos =array (
  'identificador_referencia_local' => 'localis_',
  'gedees' => 
  array (
    'path_dir_raiz' => 'gedees',
    'seguridad' => 
    array (
      'gestion_seguridad' => true,
      'propietario_entidad' => true,
      'ambito_seguridad' => 'restrictivo',
      'actualizar_datos_seguridad' => false,
      'datos_seguridad' => 
      array (
        '\\Emod\\Nucleo\\Gedees' => 
        array (
          0 => 'GedeeEPadre',
          1 => 'GedeeENucleo',
          2 => 'GedeeEComun',
        ),
      ),
    ),
    'existentes_sistema' => 
    array (
      '\\Emod\\Nucleo\\Gedees' => 
      array (
        'GedeeEPadre' => 
        array (
          'path_control' => 'eclase_padre/gedee_epadre_control.php',
          'referencia_path_control' => 'relativo',
        ),
        'GedeeENucleo' => 
        array (
          'path_control' => 'enucleo/gedee_enucleo_control.php',
          'referencia_path_control' => 'relativo',
        ),
        'GedeeEComun' => 
        array (
          'path_control' => 'ecomun/gedee_ecomun_control.php',
          'referencia_path_control' => 'relativo',
        ),
      ),
    ),
  ),
  'sistema' => 
  array (
    'propiedades_servidor_hospedero' => 
    array (
      'nombre_dominio_web' => '',
    ),
    'propiedades_proceso' => 
    array (
      'version_sistema' => '1.0.0',
      'id_proceso' => 'NucleoEsquelemod',
      'namespace_gedee' => '\\Emod\\Nucleo\\Gedees',
      'clase_gedee' => 'GedeeENucleo',
      'id_gedee' => 'GedeeENucleo',
      'dependencias' => '',
      'conflictos' => '',
    ),
  ),
  'herramientas' => 
  array (
    'ejecucion' => true,
    'path_dir_raiz' => 'herramientas',
    'seguridad' => 
    array (
      'gestion_seguridad' => true,
      'propietario_entidad' => true,
      'ambito_seguridad' => 'permisivo',
      'actualizar_datos_seguridad' => false,
      'datos_seguridad' => 
      array (
        'nombre_namespace1' => 
        array (
          0 => 'nombre_clase1',
          1 => 'nombre_clase2',
          2 => 'nombre_claseN',
        ),
        'nombre_namespaceN' => 
        array (
          0 => 'nombre_clase1',
          1 => 'nombre_clase2',
          2 => 'nombre_claseN',
        ),
      ),
    ),
    'existentes_sistema' => 
    array (
      '\\Emod\\Nucleo\\Herramientas' => 
      array (
        'Spyc' => 
        array (
          'path_entidad_clase' => 'e_modulos/nucleo/nucleo_bib_funciones/herramientas/spyc.php',
          'referencia_path_entidad' => 'relativo_esquelemod',
          'tipo_entidad' => 'clase',
          'instancias' => 
          array (
            'Spyc' => '',
          ),
        ),
        'EArreglo' => 
        array (
          'path_entidad_clase' => 'e_modulos/nucleo/nucleo_bib_funciones/herramientas/class_herramienta_earreglo.php',
          'referencia_path_entidad' => 'relativo_esquelemod',
          'tipo_entidad' => 'clase',
          'instancias' => 
          array (
            'EArreglo' => '',
          ),
        ),
        'EDatosFormatoTxt' => 
        array (
          'path_entidad_clase' => 'e_modulos/nucleo/nucleo_bib_funciones/herramientas/class_eh_datfortxt.php',
          'referencia_path_entidad' => 'relativo_esquelemod',
          'tipo_entidad' => 'clase',
          'instancias' => 
          array (
            'EDatosFormatoTxt' => '',
          ),
        ),
      ),
    ),
  ),
  'utiles' => 
  array (
    'ejecucion' => true,
    'path_dir_raiz' => 'utiles',
    'seguridad' => 
    array (
      'gestion_seguridad' => true,
      'propietario_entidad' => true,
      'ambito_seguridad' => 'permisivo',
      'actualizar_datos_seguridad' => false,
      'datos_seguridad' => 
      array (
        'nombre_namespace1' => 
        array (
          0 => 'nombre_clase1',
          1 => 'nombre_clase2',
          2 => 'nombre_claseN',
        ),
        'nombre_namespaceN' => 
        array (
          0 => 'nombre_clase1',
          1 => 'nombre_clase2',
          2 => 'nombre_claseN',
        ),
      ),
    ),
  ),
  'errores' => 
  array (
    'ejecucion' => true,
    'path_dir_raiz' => 'errores',
    'seguridad' => 
    array (
      'gestion_seguridad' => true,
      'propietario_entidad' => true,
      'ambito_seguridad' => 'permisivo',
      'actualizar_datos_seguridad' => false,
      'datos_seguridad' => 
      array (
        'nombre_namespace1' => 
        array (
          0 => 'nombre_clase1',
          1 => 'nombre_clase2',
          2 => 'nombre_claseN',
        ),
        'nombre_namespaceN' => 
        array (
          0 => 'nombre_clase1',
          1 => 'nombre_clase2',
          2 => 'nombre_claseN',
        ),
      ),
    ),
    'entidad_errores_emod' => 
    array (
      '\\Emod\\Nucleo\\Errores' => 
      array (
        'EErrores' => 
        array (
          'path_entidad_clase' => 'e_modulos/nucleo/nucleo_bib_funciones/class_eerrores.php',
          'referencia_path_entidad' => 'relativo_esquelemod',
          'tipo_entidad' => 'objeto',
          'iniciacion' => 'construct',
          'instancias' => 
          array (
            'EEoErrores' => 
            array (
              'parametros_iniciacion' => 
              array (
                0 => 'localis_[\'errores\'][\'entidad_gedege_emod\']',
                1 => 'localis_[\'errores\'][\'funcion_gestor_errores\']',
                2 => 'localis_[\'errores\'][\'elementos_error\']',
                3 => 'localis_[\'errores\'][\'formato_mensaje\']',
                4 => 'localis_[\'errores\'][\'fuente_datos_error\']',
                5 => 'localis_[\'errores\'][\'formato_filtrado\']',
                6 => 'localis_[\'errores\'][\'tipos_error\']',
              ),
              'datos' => '',
            ),
          ),
        ),
      ),
    ),
    'funcion_gestor_errores' => 
    array (
      'identificador' => 'gestorErroresEmod',
      'nombre_funcion' => 'gestorErroresEmod',
    ),
    'entidad_gedege_emod' => 
    array (
      'Emod\\Nucleo\\Errores\\Gedege' => 
      array (
        'GedegeTxtEmod' => 
        array (
          'path_entidad_clase' => 'gedeges/gedege_txt_emod/gedege_bib_funciones/class_gedege_txt_emod.php',
          'referencia_path_entidad' => 'relativo',
          'tipo_entidad' => 'objeto',
          'instancias' => 
          array (
            'GedegeTxtEmod' => 
            array (
              'datos' => '',
            ),
          ),
        ),
      ),
    ),
    'elementos_error' => 
    array (
      'miembros_errorlog' => 
      array (
        0 => 'tiempo',
        1 => 'fichero',
        2 => 'linea',
        3 => 'proceso',
        4 => 'gedee_proceso',
      ),
      'miembros_error' => 
      array (
        0 => 'id',
        1 => 'tipo',
        2 => 'mensaje',
      ),
    ),
    'fuente_datos_error' => 
    array (
      'path_fich_error' => 'error.txt',
      'referencia_path_error' => 'relativo',
      'path_fich_errorlog' => 'errorlog.txt',
      'referencia_path_errorlog' => 'relativo',
    ),
    'formato_filtrado' => 
    array (
      'formato' => 
      array (
        'separador' => '::',
      ),
      'filtrado' => 
      array (
        'marca_ausente' => true,
      ),
    ),
    'formato_mensaje' => 
    array (
      'formato_mensaje_error' => 
      array (
        0 => 'id',
        1 => 'tipo',
        2 => 'mensaje',
      ),
      'formato_mensaje_errorlog' => 
      array (
        0 => 'id',
        1 => 'tipo',
        2 => 'mensaje',
        3 => 'tiempo',
        4 => 'fichero',
        5 => 'linea',
        6 => 'proceso',
        7 => 'gedee_proceso',
      ),
    ),
    'tipos_error' => 'E_ALL',
  ),
  'procesos' => 
  array (
    'path_raiz_procesos' => 'procesos',
    'orden_permiso_ejecucion_bloques' => 
    array (
      0 => 'bloque_defecto',
    ),
    'arbol_procesos' => 
    array (
      'limite_idorejec_global' => -1,
      'limite_idorejec_bloqueprocesos' => -1,
      'limite_idorejec_subproceso' => -1,
      'limite_idorejec_recursivoproceso' => -1,
      'limite_idorejec_recursivoproimpejec' => -1,
    ),
    'seguridad_procesos' => 
    array (
      'permision_nucleo' => 
      array (
        'ambito_seguridad' => 'permisivo',
        'procesos' => 
        array (
          0 => 'proceso1',
          1 => 'procesoN',
        ),
      ),
      'permision_clientes' => 
      array (
        'ambito_seguridad' => 'permisivo',
        'procesos' => 
        array (
          '\\namespace' => 
          array (
            'clase' => 
            array (
              0 => 'proceso1',
              1 => 'procesoN',
            ),
          ),
        ),
      ),
    ),
    'bloques_procesos' => 
    array (
      'bloque_defecto' => 
      array (
        'apertura' => 
        array (
          'gedee_proceso' => 
          array (
            'namespace' => '\\Emod\\Nucleo\\Gedees',
            'clase' => 'GedeeEComun',
            'id_entidad' => 'GedeeEComun',
          ),
          'propiedades_implementacion_proceso' => 
          array (
            'path_raiz' => 'apertura',
            'path_arranque' => 'apertura_control.php',
            'obligatoriedad' => 1,
          ),
        ),
      ),
    ),
  ),
);
return $datos ;


	                                      ?>