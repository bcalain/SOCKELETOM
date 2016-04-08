<?php
/*
    SOCKELETOM Esqueleto con Sockets, como Motor de Códigos PHP en forma de módulos  
    Copyright (C) 2010  Alain Borrell Castellanos

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

    email-contact bcalain@gmail.com
*/
/**
   * NucleoControl class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

    namespace Emod\Nucleo;

    class NucleoControl extends \Emod\Nucleo\NucleoEntidadBase
        {

        //crear un contenedor con objetos para ser brindados a los procesos y otros, estar a dispocicion de los demas se declara en la configuracion del sistema
        //////////////////////////////////Propiedades del sistema de archivos del esquelemod////////////////////////////// 
        //valor del path del directorio esquelemod )esta propiedad debe tener valor vacio al instanciarse el objeto nucleo ya que de esto depende todo el proceso de inicializacion del objeto  
        private $lsPathDirEsquelemod           = null;
        //valor del path del directorio modulos, se fabrica a partir del valor del directorio esquelemod, su valor contiene la misma raiz que el directorio esquelemod seguido del directorio modulos
        private $lsPathDirModulos              = null;
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////Punteros a objetos heredados//////////////////////////////////////////////////
        //protected $EEoInterfazDatos = null ;
        //protected $EEoConfiguracion = null ;
        //protected $EEoSeguridad = null ;
        //protected $EEoImplementacionProcesos = null ;
        //protected $EEoErrores = null ;
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
        ////////////////////////////////////////Propiedades respectivos al objeto nucleo//////////////////////////////////////////////////
        //es el identificador del proceso nucleo en las estructuras de datos de los objetos del nuceo como son, objeto seguridad, contenedor datos, configuracion etc
        private $lsIdProcesoNucleo             = 'NucleoEsquelemod';
        private $lsNamespaceGedeeProcesoNucleo = '\\Emod\\Nucleo\\Gedees';
        private $lsClaseGedeeProcesoNucleo     = 'GedeeENucleo';
        private $lsIdGedeeProcesoNucleo        = 'GedeeENucleo';
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
        ////////////////////////////////////////Propiedades respectivas a los GEDEEs//////////////////////////////////////////////////
        //identifica si la inicializacion de la clase GEDEEs fue ejecutada con exito
        private $lbIniciacionGedee             = null;
        ////////////////////////////////////Propiedades del Sistema de configuacion para la configuracion del Esquelemod/////////////////////////////
        //identifica si la configuracion del sistema esquelemod fue ejecutada con exito
        private $lbEConfiguracionEjecutada     = false;
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////Propiedades del Sistema de seguridad para el Esquelemod//////////////////////////////////////////////////
        //identifica si la seccion de seguridad del sistema esquelemod fue inicializada con exito, esta seccion es la correspondiente al objeto seguridad
        private $lbESeguridadIniciada          = false;
        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ////////////////////////////////////////Propiedades respectivas a los errores//////////////////////////////////////////////////
        //identifica si la iniciacion de la clase Errores fue ejecutada con exito
        private $lbIniciacionErrores           = null;
        ////////////////////////////////////////Propiedades respectivas a las herramientas//////////////////////////////////////////////////
        //identifica si la iniciacion de la clase Herramientas fue ejecutada con exito
        private $lbIniciacionHerramientas      = null;
        ////////////////////////////////////////Propiedades respectivas a los utiles//////////////////////////////////////////////////
        //identifica si la iniciacion de la clase Utiles fue ejecutada con exito
        private $lbIniciacionUtiles            = null;
        ////////////////////////////////////////Propiedades respectivas a los procesos//////////////////////////////////////////////////
        //valor del path del directorio raiz del proceso en ejecucion, este path comienza a partir del dierctorio procesos del arbol de directorios del sistema esquelemod  proceso en ejecucion, nombre del proceso, en caso de los procesos appmod aqui se muestra el id del proceso que no es lo mismo que el id de la aplicacion o el id del modulo, sino el proceso que trabaja las aplicaciones o modulos
        private $lsPathDirRaizProcesoEjecucion = ''; //esto va vacio el valor que tiene es para hacer pruebas
        //valor del proceso en ejecucion, nombre del proceso, en caso de los procesos appmod aqui se muestra el id del proceso que no es lo mismo que el id de la aplicacion o el id del modulo, sino el proceso que trabaja las aplicaciones o modulos
        private $lsIdProcesoEjecucion          = ''; //esto va vacio el valor que tiene es para hacer pruebas
        private $lsNamespaceGedeeProcesoEjecucion = '';
        private $lsClaseGedeeProcesoEjecucion = '';
        private $lsIdGedeeProcesoEjecucion = ''; //esto va vacio el valor que tiene es para hacer pruebas
        //en versiones futuras se podran controlar la cuantia maxima de cada uno de estos datos como control del nucleo sobre la ejecucion de proceso. 
        //arbol de procesos activos por el que trabaja la logica de procesos del nucleo, el primer proceso en actualizar este arbol es el nucleo
        //la esructura de este arreglo es la siguiente
        //array( 0 => array( 'id_proceso'=> valor id_proceso,(string)
        //                   'tipo_proceso'=> valor tipo_proceso,(string)
        //                   'apuntador_procesoPadre'=> &valor apuntador_procesoPadre,(& referencia a areglo)
        //                   'idorejecSubProceso'=> valor idorejecSubProceso,(int)
        //                   'id_clave_ejecucion'=> valor id_clave_ejecucion, (string)idorejecGlobal::idorejecRecursivoProImpEjec::idorejecRecursivoProceso          
        //                   'procesos' => array( 0 => array(   'id_proceso'=> valor id_proceso,(string)
        //                                                      'tipo_proceso'=> valor tipo_proceso,(string)
        //                                                      'apuntador_procesoPadre'=> &valor apuntador_procesoPadre,(& referencia a areglo)
        //                                                      'idorejecSubProceso'=> valor idorejecSubProceso,(int)
        //                                                      'id_clave_ejecucion'=> valor id_clave_ejecucion, (string)idorejecGlobal::idorejecRecursivoProImpEjec::idorejecRecursivoProceso          
        //                                                      'procesos' => array(...)
        //                                          
        //                                                   )
        //                                        ...sigue aqui con los sigiente indices numericos y la misma estructura de arriva  
        //                                      ) 
        //
                //                  )
        //        ...sigue aqui con los sigiente indices numericos y la misma estructura de arriva                                  
        //      )
        //                   
        private $laArbolProcesos             = null;
        //identificativo de orden de ejecucion a escala global, es decir el orden consecutivo que cada proceso ocupa en la ejecucion de procesos durante la ejecucion del sistema de forma global
        private $idorejecGlobal                    = 0;
        private $limiteIdorejecGlobal              = -1;
        //identificativo de orden de ejecucion en el bloque de procesos, es decir el orden consecutivo que cada proceso ocupa en el bloque declarado en la configuracion del sistema
        private $idorejecBloqueProcesos            = 0;
        private $limiteIdorejecBloqueProcesos      = -1;
        //identificativo de orden de ejecucion de un proceso como subproceso de otro, es decir el orden consecutivo que cada proceso ocupa en la ejecucion de procesos como subproceso de otro proceso
        private $idorejecSubProceso                = 0;
        private $limiteIdorejecSubProceso          = -1;
        //identificativo de orden de ejecucion de un proceso de forma recursiva, es decir el orden consecutivo que cada proceso ocupa cuando es ejecutato por el mismo proceso, de forma recursiva
        private $idorejecRecursivoProceso          = 0;
        private $limiteIdorejecRecursivoProceso    = -1;
        //identificativo de orden de ejecucion de un proceso cuando el procedimiento que implementacion la ejecucion los procesos es llamado recursivamente, es decir el que es llamado recursivamente es el procedimiento de ejecucion no el proceso, es cuando un proceso llama dentro de si el procedimiento de ejecucion para ejecutarse asi mismo o a otro proceso 
        private $idorejecRecursivoProImpEjec       = 0;
        private $limiteIdorejecRecursivoProImpEjec = -1;
        //es un puntero al arreglo estructura del proceso actual(ejecutandose) y cituada en el arreglo $laArbolProcesos de esta misma clase.
        private $apuntadorProcesoActual      = null;
        //indica si el bloque appmod se ha ejecutado al menos una ves
        //private $ejecucion_bloque_fundator = false ;
        //estado de la ejecucion del proceso, admite los siguientes valores inicializado, finalizado , null(cuando no existe ningun proceso ejecutandose)
        private $statuEjecucionProceso       = null;

        /////////////////////////////procedimientos GEDEEs////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 

        final private function iniciacionClassGedees( $La_configuracion_nucleo_gedees = null )
            {
            if ( empty( $this->lbEConfiguracionEjecutada ) && empty( $this->lbIniciacionGedee ) && !empty( $La_configuracion_nucleo_gedees ) )
                {
                if ( !( \Emod\Nucleo\GEDEEs::iniciacion( $La_configuracion_nucleo_gedees ) ) || ( !( \Emod\Nucleo\GEDEEs::existenciaEntidad( '\Emod\Nucleo\Gedees' , 'GedeeEPadre' ) ) ) || ( !( \Emod\Nucleo\GEDEEs::entidad( '\Emod\Nucleo\Gedees' , 'GedeeEPadre' , 'GedeeEPadre' ) ) ) )
                    {
                    //exit( '<p>ERROR FATAL, ' . __METHOD__ . ', fallida la iniciaci&oacute;n de la clase GEDEEs<p>' );
                    trigger_error('fallida la iniciaci&oacute;n de la clase GEDEEs' , E_USER_ERROR ) ;
                    }
                    
                $this->lbIniciacionGedee = true;
                }
            }

        //////////////////////////////procedimientos proceso nucleo////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
        // inicializando el path del directorio esquelemod y el directorio modulos
        //este procedimiento define el path global del directorio esquelemod y e directorio modulos
        //$cantidad_niveles es la cantidad de niveles de directorio que hay que ir hacia atras, en el arbol de directorio, para llegar al dierctorio esquelemod desde el lugar donde se encuentra el fichero de esta clase, la cantiad se comienza a contar a partir de 1, no de cero,
        //en versiones posteriores se introducira otro parametro para elegir si el sgimiento del directorio se hara hacia atras(saliendo) o hacia adelante(entrando) en el arbol de directorios, por el momento solo es hacia atras (saliendo). 
        final public function iniciacionImplementacionNucleo( $cantidad_niveles = 3 )
            {
            if ( empty( $this->lsPathDirEsquelemod ) )
                {
                $Ls_dir_gestion         = str_replace( '\\' , '/' , __DIR__ );
                $Ls_path_dir_esquelemod = '';
                $Ls_path_dir_modulos    = '';

                if ( $cantidad_niveles == 0 )
                    {
                    $Ls_path_dir_esquelemod = $Ls_dir_gestion;
                    $pos_ult_apar           = strripos( $Ls_dir_gestion , '/' );
                    $Ls_dir_gestion         = substr( $Ls_dir_gestion , 0 , $pos_ult_apar );
                    $Ls_path_dir_modulos    = $Ls_dir_gestion;
                    }
                elseif ( empty( $cantidad_niveles ) || ( $cantidad_niveles < 0 ) )
                    {
                    //exit( '<p>ERROR FATAL, en: ' . __FILE__ . '->(Procedimiento)' . __FUNCTION__ . '->(Linea)' . __LINE__ );
                    trigger_error('No pudo iniciarse el proceso n&uacute;cleo' , E_USER_ERROR ) ;
                    }
                else
                    {
                    for ( $i = $cantidad_niveles; $i >= 0; $i-- )
                        {
                        $pos_ult_apar   = strripos( $Ls_dir_gestion , '/' );
                        $Ls_dir_gestion = substr( $Ls_dir_gestion , 0 , $pos_ult_apar );
                        if ( $i == 1 )
                            {
                            $Ls_path_dir_esquelemod = $Ls_dir_gestion;
                            continue;
                            }
                        if ( $i == 0 )
                            {
                            $Ls_path_dir_modulos = $Ls_dir_gestion . '/modulos';
                            }
                        }
                    }


                if ( (!empty( $Ls_path_dir_esquelemod ) && is_dir( $Ls_path_dir_esquelemod ) ) && (!empty( $Ls_path_dir_modulos ) && is_dir( $Ls_path_dir_modulos ) ) )
                    {
                    $this->lsPathDirEsquelemod = $Ls_path_dir_esquelemod;
                    $this->lsPathDirModulos    = $Ls_path_dir_modulos;
                    
                    return true;
                    }
                else
                    {
                    //exit( '<p>ERROR FATAL, en: ' . __FILE__ . '->(Procedimiento)' . __FUNCTION__ . '->(Linea)' . __LINE__ );
                    trigger_error('No pudo iniciarse el proceso n&uacute;cleo' , E_USER_ERROR ) ;
                    }
                }
            return null;
            }

        //debuelve el valor del path del directorio esquelemod relativo al lugar donde se implementa el objeto de esta clase 	
        public function pathDirEsquelemod()
            {
            return $this->lsPathDirEsquelemod;
            }

        //debuelve el valor del path del directorio modulos relativo al lugar donde se implementa el objeto de esta clase 	
        public function pathDirModulos()
            {
            return $this->lsPathDirModulos;
            }

        //debuelve el valor del id del proceso nucleo en ejecucion 	
        public function idProcesoNucleo()
            {
            return $this->lsIdProcesoNucleo;
            }

        //debuelve el valor del gedee del proceso nucleo en ejecucion 	
        public function gedeeProcesoNucleo()
            {
            return $this->lsNamespaceGedeeProcesoNucleo . '\\' . $this->lsClaseGedeeProcesoNucleo.'\\'.$this->lsIdGedeeProcesoNucleo;
            }

        public function idGedeeProcesoNucleo()
            {
            return $this->lsIdGedeeProcesoNucleo;
            }

        public function namespaceGedeeProcesoNucleo()
            {
            return $this->lsNamespaceGedeeProcesoNucleo;
            }

        public function claseGedeeProcesoNucleo()
            {
            return $this->lsClaseGedeeProcesoNucleo;
            }

        //inicializa la configuracion del sistema esquelemod, depende de el procedimiento inicializacion_propiedades_gestion_configuracion de esta misma clase, pues parte de los datos inicializado por ella
        //el control nucleo se registra en los diferentes gestores de datos, en este caso en el objeto configuracion, como un procedimiento de gedee $this->lsGedeeProcesoNucleo y con id $this->lsIdProcesoNucleo que se configura para el proceso nucleo en esta clase  
        //
    public function gestionIniciacionConfiguracionEsquelemod( $La_fich_interfaz_config , $La_fich_datos_config = null )
            {
            if ( empty( $this->lbEConfiguracionEjecutada ) && !empty( $this->lsIdProcesoNucleo ) && is_object( $this->EEoInterfazDatos ) && is_object( $this->EEoConfiguracion ) && !empty( $La_fich_interfaz_config ) )
                {
                $resultado           = null;
                /* 
                $id_proceso_pausa              = $this->lsIdProcesoEjecucion;
                $namespace_gedee_proceso_pausa = $this->lsNamespaceGedeeProcesoEjecucion;
                $clase_gedee_proceso_pausa     = $this->lsClaseGedeeProcesoEjecucion;
                $id_gedee_proceso_pausa        = $this->lsIdGedeeProcesoEjecucion;

                $this->lsIdProcesoEjecucion             = $this->lsIdProcesoNucleo;
                $this->lsNamespaceGedeeProcesoEjecucion = $this->lsNamespaceGedeeProcesoNucleo;
                $this->lsClaseGedeeProcesoEjecucion     = $this->lsClaseGedeeProcesoNucleo;
                $this->lsIdGedeeProcesoEjecucion        = $this->lsIdGedeeProcesoNucleo;
                */
                $datos_configuracion = $this->EEoInterfazDatos->gestionEjecucionInterfazSalida( $this->lsIdProcesoNucleo , $La_fich_interfaz_config , $La_fich_datos_config , 'adyacente' );

                if ( !empty( $datos_configuracion ) )
                    {
                    if ( !empty( $datos_configuracion['identificador_referencia_local'] ) )
                        {

                        //seccion para filtrar los valores que tienen identificador_referencia_local y contruir una referencia real
                        //$La_elementos_filtrado, es el arreglo donde estan los datos reales y las referencias
                        //$La_elementos_filtrado['identificador_referencia_local']es el string prefijo, que identifica que una variable o elemento es referencia a otra variable o elemento 
                        //cuando se llega a este punto se sabe que existe $La_elementos_filtrado['identificador_referencia_local'] por una condicion puesta anterior a esta linea, es por eso que la funcion no chequea que exista este valor
                        //de utilizarse esta funcion closure en otra parte debe tenerse en cuenta que no se chequean los parametros en su interior    
                        
                        $filtrar_irl =
                                function ( &$valor , $clave , $La_elementos_filtrado )
                                    {
                                    $longitud_string_irl = strlen( $La_elementos_filtrado['identificador_referencia_local'] );
                                    if ( !empty( $valor ) && !empty( $La_elementos_filtrado ) && ( $clave !== 'identificador_referencia_local' ) )
                                        {
                                        $irl_probable = substr( $valor , 0 , $longitud_string_irl );

                                        if ( $irl_probable === $La_elementos_filtrado['identificador_referencia_local'] )
                                            {
                                            $variable_referenciada = substr( $valor , $longitud_string_irl );
                                            $string_filtro         = 'if( isset( $La_elementos_filtrado' . $variable_referenciada . '))
                                                                       {
                                                                            $valor = $La_elementos_filtrado' . $variable_referenciada . ';
                                                                       }';
                                            eval( $string_filtro );
                                            }
                                        }
                                    };
                         			 
                        array_walk_recursive( $datos_configuracion , $filtrar_irl , $datos_configuracion );

                        }
                    
                    //seccion para iniciar y actualizar la configuracion del sistema o proceso nucleo 

                    if ( !empty( $datos_configuracion['sistema']['propiedades_proceso']['id_proceso'] ) && !empty( $datos_configuracion['sistema']['propiedades_proceso']['namespace_gedee'] ) && !empty( $datos_configuracion['sistema']['propiedades_proceso']['clase_gedee'] ) && !empty( $datos_configuracion['sistema']['propiedades_proceso']['id_gedee'] ) )
                        {
                        
                        $this->lsIdProcesoNucleo = $datos_configuracion['sistema']['propiedades_proceso']['id_proceso'] ;
                        $this->lsNamespaceGedeeProcesoNucleo = $datos_configuracion['sistema']['propiedades_proceso']['namespace_gedee'] ;
                        $this->lsClaseGedeeProcesoNucleo = $datos_configuracion['sistema']['propiedades_proceso']['clase_gedee'] ;
                        $this->lsIdGedeeProcesoNucleo = $datos_configuracion['sistema']['propiedades_proceso']['id_gedee'] ;
                        
                        $this->lsIdProcesoEjecucion             = $this->lsIdProcesoNucleo;
                        $this->lsNamespaceGedeeProcesoEjecucion = $this->lsNamespaceGedeeProcesoNucleo;
                        $this->lsClaseGedeeProcesoEjecucion     = $this->lsClaseGedeeProcesoNucleo;
                        $this->lsIdGedeeProcesoEjecucion        = $this->lsIdGedeeProcesoNucleo;
                        
                        $this->procesoHijo( $this->lsIdProcesoNucleo , '*' );
                        
                        }
                    else
                        {
                        //exit( '<p>ERROR FATAL, procedimiento: ' . __METHOD__ . ', no se encuentra valor para propiedad correspondiente a la configuracion de las Herramientas ' );
                        trigger_error('La gesti&oacute;n de propiedades del proceso n&uacute;cleo fue insatisfactoria ' , E_USER_ERROR );
                        }    
                        
                    //seccion para iniciar y actualizar la configuracion de las herramientas 

                    if ( !empty( $datos_configuracion['herramientas']['ejecucion'] ) )
                        {
                        $this->iniciacionClassHerramientas( $datos_configuracion['herramientas'] );
                        unset($datos_configuracion['herramientas']);
                        }
                    else
                        {
                        //exit( '<p>ERROR FATAL, procedimiento: ' . __METHOD__ . ', no se encuentra valor para propiedad correspondiente a la configuracion de las Herramientas ' );
                        trigger_error('La ejecuci&oacute;n de gesti&oacute;n de herramientas por el sistema esquelemod esta desactivada, la propiedad correspondiente a la ejecuci&oacute;n de las Herramientas tiene valor vac&iacute;o en la configuraci&oacute;n del sistema' , E_USER_WARNING);
                        }

                    //seccion para iniciar y actualizar la configuracion de los utiles 

                    if ( !empty( $datos_configuracion['utiles']['ejecucion'] ) )
                        {
                        $this->iniciacionClassUtiles( $datos_configuracion['utiles'] );
                        unset($datos_configuracion['utiles']);
                        }
                    else
                        {
                        //exit( '<p>ERROR FATAL, procedimiento: ' . __METHOD__ . ', no se encuentra valor para propiedad correspondiente a la configuracion de los Utiles ' );
                        trigger_error('La ejecuci&oacute;n de gesti&oacute;n de &uacute;tiles por el sistema esquelemod esta desactivada, la propiedad correspondiente a la ejecuci&oacute;n de los &uacute;tiles tiene valor vac&iacute;o en la configuraci&oacute;n del sistema' , E_USER_WARNING);
                        }

                    //seccion para iniciar y actualizar la configuracion de los Errores

                    if ( !empty( $datos_configuracion['errores']['ejecucion'] ) )
                        {
                        $iniciacion_errores = $this->iniciacionErrores( $datos_configuracion['errores'] ) ;
                        if( empty( $iniciacion_errores ) )
                            {
                            //exit( '<p>ERROR FATAL, procedimiento: ' . __METHOD__ . ', no se pudo iniciar la seccion de errores sel sistema Esquelemod ' );
                            trigger_error('La ejecuci&oacute;n de gesti&oacute;n de errores por el sistema esquelemod esta desactivada, la propiedad correspondiente a la ejecuci&oacute;n de los errores tiene valor vac&iacute;o en la configuraci&oacute;n del sistema' , E_USER_WARNING);
                            }
                        \Emod\Nucleo\CropNucleo::ingresarNuevoObjeto( 'EEoErrores' , $this->EEoErrores );
                        unset($datos_configuracion['errores']);
                        }
                   
                    //seccion para iniciar y actualizar la configuracion de los GEDEEs

                    if ( !empty( $datos_configuracion['gedees']['path_dir_raiz'] ) && !empty( $datos_configuracion['gedees']['existentes_sistema'] ) )
                        {
                        $this->iniciacionClassGedees( $datos_configuracion['gedees'] );
                        unset($datos_configuracion['gedees']);
                        }
                    else
                        {
                        //exit( '<p>ERROR FATAL, procedimiento: ' . __METHOD__ . ', no se encuentra valor para propiedad correspondiente a la configuraci&oacute;n de los GEDEEs ' );
                        trigger_error('No se encuentra valor para propiedad correspondiente a la configuraci&oacute;n de los GEDEEs' , E_USER_ERROR ) ;
                        }
                    
                    //seccion para iniciar y actualizar la configuracion de los Procesos

                    if ( !empty( $datos_configuracion['procesos'] ) )
                        {
                        $this->iniciacionProcesos( $datos_configuracion['procesos'] );
                        }
                    else
                        {
                        //exit( '<p>ERROR FATAL, procedimiento: ' . __METHOD__ . ', no se encuentra valor para propiedad correspondiente a la configuraci&oacute;n de los GEDEEs ' );
                        trigger_error('No se encuentra valor para propiedad correspondiente a la configuraci&oacute;n de los Procesos' , E_USER_ERROR ) ;
                        }    
                        
                    //seccion para iniciar y actualizar la configuracion del proceso nucleo 
                    $resultado = $this->EEoConfiguracion->iniciarDatosConfiguracionProceso( $datos_configuracion );
                    
                    
                    }
                /* 
                $this->lsIdProcesoEjecucion             = $id_proceso_pausa;
                $this->lsNamespaceGedeeProcesoEjecucion = $namespace_gedee_proceso_pausa;
                $this->lsClaseGedeeProcesoEjecucion     = $clase_gedee_proceso_pausa;
                $this->lsIdGedeeProcesoEjecucion        = $id_gedee_proceso_pausa;
                */

                if ( !empty( $resultado ) )
                    {
                    $this->lbEConfiguracionEjecutada = true;
                    return $resultado;
                    }
                }
            return null;
            }
		/*
        public function iniciacionDatosSeguridadEsquelemod()
            {
            if ( empty( $this->lbESeguridadIniciada ) && !empty( $this->lsIdProcesoNucleo ) && !empty( $this->lbEConfiguracionEjecutada ) && is_object( $this->EEoConfiguracion ) )
                {
                $resultado       = null;

                $id_proceso_pausa              = $this->lsIdProcesoEjecucion;
                $namespace_gedee_proceso_pausa = $this->lsNamespaceGedeeProcesoEjecucion;
                $clase_gedee_proceso_pausa     = $this->lsClaseGedeeProcesoEjecucion;
                $id_gedee_proceso_pausa        = $this->lsIdGedeeProcesoEjecucion;

                $this->lsIdProcesoEjecucion             = $this->lsIdProcesoNucleo;
                $this->lsNamespaceGedeeProcesoEjecucion = $this->lsNamespaceGedeeProcesoNucleo;
                $this->lsClaseGedeeProcesoEjecucion     = $this->lsClaseGedeeProcesoNucleo;
                $this->lsIdGedeeProcesoEjecucion        = $this->lsIdGedeeProcesoNucleo;


                $datos_seguridad = $this->EEoConfiguracion->accederDatosConfiguracionProceso( 'hereda' , 'hereda' , 'hereda' , 'hereda' , "['sistema']['datos_seguridad']" );
                $datos_seguridad_eliminar = array( 'sistema' => array('datos_seguridad' => array() ) );
                $this->EEoConfiguracion->accederDatosConfiguracionProceso( 'hereda' , 'hereda' , 'hereda' , 'hereda' , $datos_seguridad_eliminar , 3 );
                
                if ( !empty( $datos_seguridad ) )
                    {
                    $resultado = $this->EEoSeguridad->iniciarDatosSeguridadProceso( $datos_seguridad );
                    }

                $this->lsIdProcesoEjecucion             = $id_proceso_pausa;
                $this->lsNamespaceGedeeProcesoEjecucion = $namespace_gedee_proceso_pausa;
                $this->lsClaseGedeeProcesoEjecucion     = $clase_gedee_proceso_pausa;
                $this->lsIdGedeeProcesoEjecucion        = $id_gedee_proceso_pausa;

                if ( !empty( $resultado ) )
                    {
                    $this->lbESeguridadIniciada = true;
                    return $resultado;
                    }
                }
            return null;
            }
		*/
//esta funcion es para acceder a las propiedades declaradas en la seccion ['propiedades_proceso'] del fichero de configuracion del sistema            
        public function accesoPropiedadesEsquelemod()
            {
            if ( !empty( $this->lbESeguridadIniciada ) && !empty( $this->lsIdProcesoNucleo ) && !empty( $this->lbEConfiguracionEjecutada ) && is_object( $this->EEoConfiguracion ) )
                {
                
                $id_proceso_pausa              = $this->lsIdProcesoEjecucion;
                $namespace_gedee_proceso_pausa = $this->lsNamespaceGedeeProcesoEjecucion;
                $clase_gedee_proceso_pausa     = $this->lsClaseGedeeProcesoEjecucion;
                $id_gedee_proceso_pausa        = $this->lsIdGedeeProcesoEjecucion;

                $this->lsIdProcesoEjecucion             = $this->lsIdProcesoNucleo;
                $this->lsNamespaceGedeeProcesoEjecucion = $this->lsNamespaceGedeeProcesoNucleo;
                $this->lsClaseGedeeProcesoEjecucion     = $this->lsClaseGedeeProcesoNucleo;
                $this->lsIdGedeeProcesoEjecucion        = $this->lsIdGedeeProcesoNucleo;

                $propiedades_sistema = $this->EEoConfiguracion->accederDatosConfiguracionProceso( 'hereda' , 'hereda' ,'hereda' , 'hereda' , "['sistema']['propiedades_proceso']" );

                $this->lsIdProcesoEjecucion             = $id_proceso_pausa;
                $this->lsNamespaceGedeeProcesoEjecucion = $namespace_gedee_proceso_pausa;
                $this->lsClaseGedeeProcesoEjecucion     = $clase_gedee_proceso_pausa;
                $this->lsIdGedeeProcesoEjecucion        = $id_gedee_proceso_pausa;

                return $propiedades_sistema;
                }
            return null;
            }

//////////////////////////////////////////procedimientos de errores///////////////////////////////////////////////////////            

        private function iniciacionErrores( $La_configuracion_nucleo_errores = null )
            {
            if ( !empty( $La_configuracion_nucleo_errores ) && is_array( $La_configuracion_nucleo_errores ) && !empty( $La_configuracion_nucleo_errores['ejecucion'] ) && class_exists( '\Emod\Nucleo\Errores' ) && !is_object( $this->EEoErrores ) && empty( $this->lbEConfiguracionEjecutada ) && empty( $this->lbIniciacionErrores ) )
                {
                //iniciando la clase errores, se le pasa el arreglo correspondiente a la sección errores completo pero el objeto errores solo se queda con lo que necesita, no con el arreglo completo
                if ( !( \Emod\Nucleo\Errores::iniciacion( $La_configuracion_nucleo_errores ) ) )
                    {
                    //exit( '<p>ERROR FATAL, ' . __METHOD__ . ', fallida la iniciaci&oacute;n de la clase errores<p>' );
                    trigger_error('Fallida la iniciaci&oacute;n de la clase errores' , E_USER_ERROR ) ;
                    }
                //ingresando y gestionando en la entidad gedege necesaria para la entidad que manejara errores del nucleo esquelemod
                //se crea antes que la entidad que manejara los errores del esquelemod por si este utimo en su iniciacion o construccion chequea la existencia de su gedege    
                if ( !empty( $La_configuracion_nucleo_errores['entidad_gedege_emod'] ) && is_array( $La_configuracion_nucleo_errores['entidad_gedege_emod'] ) )
                    {
                    reset( $La_configuracion_nucleo_errores['entidad_gedege_emod'] );
                    $namespace1 = key( $La_configuracion_nucleo_errores['entidad_gedege_emod'] );
                    reset( $La_configuracion_nucleo_errores['entidad_gedege_emod'][$namespace1] );
                    $clase1     = key( $La_configuracion_nucleo_errores['entidad_gedege_emod'][$namespace1] );
                    reset( $La_configuracion_nucleo_errores['entidad_gedege_emod'][$namespace1][$clase1]['instancias'] );
                    $id_error1  = key( $La_configuracion_nucleo_errores['entidad_gedege_emod'][$namespace1][$clase1]['instancias'] );

                    $existencia_entidad_error_gedege = \Emod\Nucleo\Errores::existenciaEntidad( $namespace1 , $clase1 , $id_error1 );
                    if ( empty( $existencia_entidad_error_gedege ) )
                        {
                        $gestion_ingresos_errores_gedege = \Emod\Nucleo\Errores::gestionIngresosEntidades( $La_configuracion_nucleo_errores['entidad_gedege_emod'] );

                        if ( empty( $gestion_ingresos_errores_gedege ) )
                            {
                            //exit( '<p>ERROR FATAL, ' . __METHOD__ . ', fallida la iniciaci&oacute;n del GEDEGE<p>' );
                            trigger_error('Fallida la iniciaci&oacute;n del GEDEGE' , E_USER_ERROR ) ;
                            }
                        }
                    }
                //ingresando y gestionando la clase errores, la entidad que manejara errores del nucleo esquelemod      
                if ( !empty( $La_configuracion_nucleo_errores['entidad_errores_emod'] ) && is_array( $La_configuracion_nucleo_errores['entidad_errores_emod'] ) )
                    {
                    reset( $La_configuracion_nucleo_errores['entidad_errores_emod'] );
                    $namespace2 = key( $La_configuracion_nucleo_errores['entidad_errores_emod'] );
                    reset( $La_configuracion_nucleo_errores['entidad_errores_emod'][$namespace2] );
                    $clase2     = key( $La_configuracion_nucleo_errores['entidad_errores_emod'][$namespace2] );
                    reset( $La_configuracion_nucleo_errores['entidad_errores_emod'][$namespace2][$clase2]['instancias'] );
                    $id_error2  = key( $La_configuracion_nucleo_errores['entidad_errores_emod'][$namespace2][$clase2]['instancias'] );

                    $existencia_entidad_error_emod = \Emod\Nucleo\Errores::existenciaEntidad( $namespace2 , $clase2 , $id_error2 );
                    if ( empty( $existencia_entidad_error_emod ) )
                        {
//echo 'borrar esto es solo para pruebas, esta en:'.__FILE__.' linea '.__LINE__.'<p>'; var_dump( $La_configuracion_nucleo_errores['entidad_errores_emod'] );

                        $gestion_ingresos_errores_emod = \Emod\Nucleo\Errores::gestionIngresosEntidades( $La_configuracion_nucleo_errores['entidad_errores_emod'] );
                        
                        if ( empty( $gestion_ingresos_errores_emod ) )
                            {
                            //exit( '<p>ERROR FATAL, ' . __METHOD__ . ', fallido el registro de la Entidad Errores del Esquelemod<p>' );
                            trigger_error('Fallido el registro de la Entidad Errores del Esquelemod' , E_USER_ERROR ) ;
                            }
                        }
                    //gestionando el objeto $this->EEoErrores, referencia al objeto entidad que manejara errores del nucleo esquelemod 
                    $this->EEoErrores = \Emod\Nucleo\Errores::entidad( $namespace2 , $clase2 , $id_error2 );

                    if ( empty( $this->EEoErrores ) )
                        {
                        //exit( '<p>ERROR FATAL, ' . __METHOD__ . ', fallida la iniciaci&oacute;n de la Entidad Errores del Esquelemod<p>' );
                        trigger_error('Fallida la iniciaci&oacute;n de la Entidad Errores del Esquelemod' , E_USER_ERROR ) ;
                        }
                    $this->lbIniciacionErrores = true;
                    return true ;
                    }
                else
                    {
                    //exit( '<p>ERROR FATAL, ' . __METHOD__ . ', no existe valor para Entidad Errores del Esquelemod<p>' );
                    trigger_error('No existe valor para Entidad Errores del Esquelemod' , E_USER_ERROR ) ;
                    }
                }
            //exit( '<p>ERROR FATAL, ' . __METHOD__ . ', no se pudo gestionar la iniciaci&oacute;n de errores del sistema Esquelemod<p>' );
            trigger_error('No se pudo gestionar la iniciaci&oacute;n de errores del sistema Esquelemod' , E_USER_ERROR ) ;
            }

//////////////////////////////////////////procedimientos de herramientas///////////////////////////////////////////////////////            

        private function iniciacionClassHerramientas( $La_configuracion_nucleo_herramientas = null )
            {
            if ( class_exists( '\Emod\Nucleo\Herramientas' ) && empty( $this->lbEConfiguracionEjecutada ) && empty( $this->lbIniciacionHerramientas ) && !empty( $La_configuracion_nucleo_herramientas ) )
                {
                if ( !( \Emod\Nucleo\Herramientas::iniciacion( $La_configuracion_nucleo_herramientas ) ) )
                    {
                    //exit( '<p>ERROR FATAL, ' . __METHOD__ . ', fallida la iniciaci&oacute;n de la clase Herramientas<p>' );
                    trigger_error('Fallida la iniciaci&oacute;n de la clase Herramientas' , E_USER_ERROR ) ;
                    }
                    
                $this->lbIniciacionHerramientas = true;
                }
            }

//////////////////////////////////////////procedimientos de utiles///////////////////////////////////////////////////////            

        private function iniciacionClassUtiles( $La_configuracion_nucleo_utiles = null )
            {
            if ( class_exists( '\Emod\Nucleo\Utiles' ) && empty( $this->lbEConfiguracionEjecutada ) && empty( $this->lbIniciacionUtiles ) && !empty( $La_configuracion_nucleo_utiles ) )
                {
                if ( !( \Emod\Nucleo\Utiles::iniciacion( $La_configuracion_nucleo_utiles ) ) )
                    {
                    //exit( '<p>ERROR FATAL, ' . __METHOD__ . ', fallida la iniciaci&oacute;n de la clase &Uacute;tiles<p>' );
                    trigger_error('Fallida la iniciaci&oacute;n de la clase &Uacute;tiles' , E_USER_ERROR ) ;
                    }
                $this->lbIniciacionUtiles = true;
                }
            }

//////////////////////////////////////////procedimientos de bloques procesos///////////////////////////////////////////////////////            
       
       private function iniciacionProcesos ( $La_configuracion_nucleo_procesos = null )
           {
           if( !isset( $La_configuracion_nucleo_procesos['arbol_procesos']['limite_idorejec_global'] ) || !isset( $La_configuracion_nucleo_procesos['arbol_procesos']['limite_idorejec_bloqueprocesos'] ) || !isset( $La_configuracion_nucleo_procesos['arbol_procesos']['limite_idorejec_subproceso'] ) || !isset( $La_configuracion_nucleo_procesos['arbol_procesos']['limite_idorejec_recursivoproceso'] ) || !isset( $La_configuracion_nucleo_procesos['arbol_procesos']['limite_idorejec_recursivoproimpejec'] ) )
               {
               trigger_error('Fallida la iniciaci&oacute;n de las propiedades del &aacute;rbol de procesos' , E_USER_ERROR ) ;
               }
           
           $this->limiteIdorejecGlobal = $La_configuracion_nucleo_procesos['arbol_procesos']['limite_idorejec_global'] ;
           settype( $this->limiteIdorejecGlobal , 'integer') ;
        
           $this->limiteIdorejecBloqueProcesos = $La_configuracion_nucleo_procesos['arbol_procesos']['limite_idorejec_bloqueprocesos'] ;
           settype( $this->limiteIdorejecBloqueProcesos , 'integer') ;
        
           $this->limiteIdorejecSubProceso = $La_configuracion_nucleo_procesos['arbol_procesos']['limite_idorejec_subproceso'] ;
           settype( $this->limiteIdorejecSubProceso , 'integer') ;
        
           $this->limiteIdorejecRecursivoProceso = $La_configuracion_nucleo_procesos['arbol_procesos']['limite_idorejec_recursivoproceso'] ;
           settype( $this->limiteIdorejecRecursivoProceso , 'integer') ;
           
           $this->limiteIdorejecRecursivoProImpEjec = $La_configuracion_nucleo_procesos['arbol_procesos']['limite_idorejec_recursivoproimpejec'] ;
           settype( $this->limiteIdorejecRecursivoProImpEjec , 'integer') ;
           }  
            
       public function permisionProcesoNucleo( $Ls_id_proceso )
            {
             $permision = null ;
             if( $this->lbEConfiguracionEjecutada && !empty( $Ls_id_proceso ) )
                 {
                  $id_proceso_pausa              = $this->lsIdProcesoEjecucion;
                  $namespace_gedee_proceso_pausa = $this->lsNamespaceGedeeProcesoEjecucion;
                  $clase_gedee_proceso_pausa     = $this->lsClaseGedeeProcesoEjecucion;
                  $id_gedee_proceso_pausa        = $this->lsIdGedeeProcesoEjecucion;

                  $this->lsIdProcesoEjecucion             = $this->lsIdProcesoNucleo;
                  $this->lsNamespaceGedeeProcesoEjecucion = $this->lsNamespaceGedeeProcesoNucleo;
                  $this->lsClaseGedeeProcesoEjecucion     = $this->lsClaseGedeeProcesoNucleo;
                  $this->lsIdGedeeProcesoEjecucion        = $this->lsIdGedeeProcesoNucleo;
                  
                  if ( $Ls_id_proceso == 'hereda' )
                    {
                    $Ls_id_proceso = $id_proceso_pausa ;
                    }
                  
                  if ( is_array( $La_bloque_procesos = $this->EEoConfiguracion->accederDatosConfiguracionProceso( 'hereda' , 'hereda' , 'hereda' , 'hereda' , "['procesos']['seguridad_procesos']['permision_nucleo']" ) ) )
                      {
                          /////////////////////////////////////////////////////////////////////////////////////
                         if ( !empty( $La_bloque_procesos['ambito_seguridad'] ) && ( ( $La_bloque_procesos['ambito_seguridad'] == 'permisivo' ) || ( $La_bloque_procesos['ambito_seguridad'] == 'restrictivo' ) ) )
                            {
                            if ( $La_bloque_procesos['ambito_seguridad'] == 'permisivo' )
                                {
                                
                                $permision = 'ejecucion' ;
                                
                                if ( $La_bloque_procesos['procesos'] == '*' )
                                    {
                                    $permision = null ;
                                    }
                                if ( is_array( $La_bloque_procesos['procesos'] ) )
                                    {    
                                        foreach ( $La_bloque_procesos['procesos'] as $id_proceso )
                                            {
                                            if ( $id_proceso == $Ls_id_proceso )
                                                {
                                                $permision = null ;
                                                }
                                            }
                                     
                                    }
                                }
                            elseif ( $La_bloque_procesos['ambito_seguridad'] == 'restrictivo' )
                                {
                                if ( $La_bloque_procesos['procesos'] == '*' )
                                    {
                                    $permision = 'ejecucion';
                                    }
                                if ( is_array( $La_bloque_procesos['procesos'] ) )
                                        {
                                        foreach ( $La_bloque_procesos['procesos'] as $id_proceso )
                                            {
                                            if ( $id_proceso == $Ls_id_proceso )
                                                {
                                                $permision = 'ejecucion';
                                                }
                                            }
                                        }
                                 }
                            }
                            
                         /////////////////////////////////////////////////////////////////////////////////////  
                      }
                          
                  $this->lsIdProcesoEjecucion             = $id_proceso_pausa;
                  $this->lsNamespaceGedeeProcesoEjecucion = $namespace_gedee_proceso_pausa;
                  $this->lsClaseGedeeProcesoEjecucion     = $clase_gedee_proceso_pausa;
                  $this->lsIdGedeeProcesoEjecucion        = $id_gedee_proceso_pausa;        
                          
                 }
             return $permision ;    
            }
            
        public function permisionProcesoCliente( $Ls_id_proceso ,  $Ls_clase_gedee_proceso , $Ls_namespace_gedee_proceso )
            {
             $permision = null ;
             if( $this->lbEConfiguracionEjecutada && !empty( $Ls_id_proceso ) && !empty( $Ls_clase_gedee_proceso ) && !empty( $Ls_namespace_gedee_proceso )  )
                 {
                  if ( $Ls_id_proceso == 'hereda' )
                        {
                        $Ls_id_proceso = self::$EEoNucleo->idProcesoEjecucion() ;
                        }
                  if ( $Ls_clase_gedee_proceso == 'hereda' )
                        {
                        $Ls_clase_gedee_proceso = self::$EEoNucleo->claseGedeeProcesoEjecucion() ;
                        }
                  if ( $Ls_namespace_gedee_proceso == 'hereda' )
                        {
                        $Ls_namespace_gedee_proceso = self::$EEoNucleo->namespaceGedeeProcesoEjecucion() ;
                        } 
                        
                  $id_proceso_pausa              = $this->lsIdProcesoEjecucion;
                  $namespace_gedee_proceso_pausa = $this->lsNamespaceGedeeProcesoEjecucion;
                  $clase_gedee_proceso_pausa     = $this->lsClaseGedeeProcesoEjecucion;
                  $id_gedee_proceso_pausa        = $this->lsIdGedeeProcesoEjecucion;

                  $this->lsIdProcesoEjecucion             = $this->lsIdProcesoNucleo;
                  $this->lsNamespaceGedeeProcesoEjecucion = $this->lsNamespaceGedeeProcesoNucleo;
                  $this->lsClaseGedeeProcesoEjecucion     = $this->lsClaseGedeeProcesoNucleo;
                  $this->lsIdGedeeProcesoEjecucion        = $this->lsIdGedeeProcesoNucleo;
                  
                  if ( is_array( $La_bloque_procesos = $this->EEoConfiguracion->accederDatosConfiguracionProceso( 'hereda' , 'hereda' , 'hereda' , 'hereda' , "['procesos']['seguridad_procesos']['permision_clientes']" ) ) )
                      {
                          /////////////////////////////////////////////////////////////////////////////////////
                         if ( !empty( $La_bloque_procesos['ambito_seguridad'] ) && ( ( $La_bloque_procesos['ambito_seguridad'] == 'permisivo' ) || ( $La_bloque_procesos['ambito_seguridad'] == 'restrictivo' ) ) )
                            {
                            if ( $La_bloque_procesos['ambito_seguridad'] == 'permisivo' )
                                {
                                
                                $permision = 'ejecucion' ;
                                
                                if ( $La_bloque_procesos['procesos'] == '*' )
                                    {
                                    $permision = null ;
                                    }
                                if ( is_array( $La_bloque_procesos['procesos'] ) )
                                    {    
                                        foreach ( $La_bloque_procesos['procesos'] as $namespace => $arreglo_namespace )
                                            {
                                            if( is_array( $arreglo_namespace ) )
                                                {
                                                foreach ( $arreglo_namespace as $clase => $arreglo_clase )
                                                    {
                                                    if( is_array( $arreglo_clase ) )
                                                       {
                                                       foreach ( $arreglo_clase as $id_proceso )
                                                           {
                                                           if ( ( $id_proceso == $Ls_id_proceso) && ( $clase == $Ls_clase_gedee_proceso ) &&( $namespace == $Ls_namespace_gedee_proceso ) )
                                                               {
                                                               $permision = null ;
                                                               }
                                                           }
                                                       }
                                                    }
                                                }        
                                            }
                                    }
                                 
                                }
                            elseif ( $La_bloque_procesos['ambito_seguridad'] == 'restrictivo' )
                                {
                                if ( $La_bloque_procesos['procesos'] == '*' )
                                    {
                                    $permision = 'ejecucion' ;
                                    }
                                if ( is_array( $La_bloque_procesos['procesos'] ) )
                                    {    
                                        foreach ( $La_bloque_procesos['procesos'] as $namespace => $arreglo_namespace )
                                            {
                                            if( is_array( $arreglo_namespace ) )
                                                {
                                                foreach ( $arreglo_namespace as $clase => $arreglo_clase )
                                                    {
                                                    if( is_array( $arreglo_clase ) )
                                                       {
                                                       foreach ( $arreglo_clase as $id_proceso )
                                                           {
                                                           if ( ( $id_proceso == $Ls_id_proceso) && ( $clase == $Ls_clase_gedee_proceso ) &&( $namespace == $Ls_namespace_gedee_proceso ) )
                                                               {
                                                               $permision = 'ejecucion' ;
                                                               }
                                                           }
                                                       }
                                                    }
                                                }        
                                            }
                                    }
                                 }
                            }
                            
                         /////////////////////////////////////////////////////////////////////////////////////  
                      }
                          
                  $this->lsIdProcesoEjecucion             = $id_proceso_pausa;
                  $this->lsNamespaceGedeeProcesoEjecucion = $namespace_gedee_proceso_pausa;
                  $this->lsClaseGedeeProcesoEjecucion     = $clase_gedee_proceso_pausa;
                  $this->lsIdGedeeProcesoEjecucion        = $id_gedee_proceso_pausa;        
                          
                 }
             return $permision ;    
            }    

        //marca para definir si ya se ejecutaron o ejecuto algun bloque de procesos
        private $lsEjecucionBloquesProcesos  = false;
        //identificador del bloque de procesos actual, en ejecucion
        private $lsIdBloqueEjecucionProcesos = null;

        //marca para definir si ya se ejecuto el bloque de procesos comun
        //private $ejecucion_bloque_comun = false ;
        //retornar identificador del bloque de procesos actual, en ejecucion 
        public function bloqueEjecucionProcesos()
            {
            return $this->lsIdBloqueEjecucionProcesos;
            }

//escribir la ayuda de este procedimiento
        private function ejecutarBloqueProcesos( $id_bloque )
            {
            $La_bloque_procesos = null;

            $id_proceso_pausa              = $this->lsIdProcesoEjecucion;
            $namespace_gedee_proceso_pausa = $this->lsNamespaceGedeeProcesoEjecucion;
            $clase_gedee_proceso_pausa     = $this->lsClaseGedeeProcesoEjecucion;
            $id_gedee_proceso_pausa        = $this->lsIdGedeeProcesoEjecucion;

            $this->lsIdProcesoEjecucion             = $this->lsIdProcesoNucleo;
            $this->lsNamespaceGedeeProcesoEjecucion = $this->lsNamespaceGedeeProcesoNucleo;
            $this->lsClaseGedeeProcesoEjecucion     = $this->lsClaseGedeeProcesoNucleo;
            $this->lsIdGedeeProcesoEjecucion        = $this->lsIdGedeeProcesoNucleo; //porque en este punto esta corriendo el proceso nucleo

            if ( !empty( $id_bloque ) && is_array( $La_bloque_procesos = $this->EEoConfiguracion->accederDatosConfiguracionProceso( 'hereda' , 'hereda' , 'hereda' , 'hereda' , "['procesos']['bloques_procesos']['$id_bloque']" ) ) )
                {
                $this->lsIdBloqueEjecucionProcesos = $id_bloque;

                $this->idorejecBloqueProcesos = 0;

                if ( !empty( $La_bloque_procesos ) && is_array( $La_bloque_procesos ) )
                    {
                    foreach ( $La_bloque_procesos as $id_proceso => $valores_proceso )
                        {
                        if ( !empty( $valores_proceso ) && is_array( $valores_proceso ) && ( $this->statuEjecucionProceso == null ) )
                            {
                            if( ( $this->limiteIdorejecBloqueProcesos != -1 ) && ( $this->limiteIdorejecBloqueProcesos < $this->idorejecBloqueProcesos+1 ) )
                                {
                                trigger_error( 'se intenta exeder el valor de la propiedad limiteIdorejecBloqueProcesos' , E_USER_ERROR );
                                }
                            
                            if ( !empty( $valores_proceso['gedee_proceso'] ) )
                                {
                                $Ls_namespace_gedee_proceso_ejecucion = $valores_proceso['gedee_proceso']['namespace'];
                                $Ls_clase_gedee_proceso_ejecucion     = $valores_proceso['gedee_proceso']['clase'];
                                $Ls_id_gedee_proceso_ejecucion = $valores_proceso['gedee_proceso']['id_entidad'];
                                }
                            else
                                {
                                //exit( "<p> ERROR FATAL, procedimiento: " . __METHOD__ . ", no se encontr&oacute; gedee para el proceso $id_proceso " );
                                trigger_error('No se encontr&oacute; gedee para el proceso '.$id_proceso , E_USER_ERROR ) ;
                                }
                            
                                
                            $this->statuEjecucionProceso = 'inicializado';
                            $this->idorejecBloqueProcesos++;

                            if ( !empty( $valores_proceso['propiedades_implementacion_proceso']['condicion_ejecucion'] ) )
                                {
                                $continue  = true;
                                $condicion = 'if( ' . $valores_proceso['propiedades_implementacion_proceso']['condicion_ejecucion'] . ' )
																						{
																							$continue = false ;
																						}
																				 ';
                                eval( $condicion );

                                if ( $continue == true )
                                    {
                                    $this->statuEjecucionProceso = null;
                                    continue;
                                    }
                                }
                            $ejecucion_proceso = $this->EEoImplementacionProcesos->cargaControlProcesos( $id_proceso , $Ls_id_gedee_proceso_ejecucion , $Ls_clase_gedee_proceso_ejecucion , $Ls_namespace_gedee_proceso_ejecucion , $valores_proceso['propiedades_implementacion_proceso'] );
                            if ( !$ejecucion_proceso )
                                {
                                //echo "<p>ADVERTENCIA, El proceso: $id_proceso, de id gedee: $Ls_id_gedee_proceso_ejecucion, clase gedee: $Ls_namespace_gedee_proceso_ejecucion\\$Ls_clase_gedee_proceso_ejecucion no se pudo ejecutar satisfact&oacute;riamente<p>" ;
                                trigger_error('El proceso: '.$id_proceso.', de id gedee: '.$Ls_id_gedee_proceso_ejecucion.', clase gedee: '.$Ls_namespace_gedee_proceso_ejecucion.'\\'.$Ls_clase_gedee_proceso_ejecucion.' no se pudo ejecutar satisfact&oacute;riamente ' , E_USER_WARNING ) ;
                                }

                            $this->statuEjecucionProceso            = null;
                            }
                        }
                    $this->lsIdProcesoEjecucion             = $id_proceso_pausa;
                    $this->lsNamespaceGedeeProcesoEjecucion = $namespace_gedee_proceso_pausa;
                    $this->lsClaseGedeeProcesoEjecucion     = $clase_gedee_proceso_pausa;
                    $this->lsIdGedeeProcesoEjecucion        = $id_gedee_proceso_pausa;

                    return true;
                    }
                }
            else
                {
                //exit( "<p> ERROR FATAL, procedimiento: " . __METHOD__ . ", no se encuentra el bloque de procesos $id_bloque en la configuraci&oacute;n del sistema, " );
                trigger_error('No se encuentra el bloque de procesos '.$id_bloque.' en la configuraci&oacute;n del sistema ' , E_USER_ERROR ) ;
                }

            $this->lsIdProcesoEjecucion             = $id_proceso_pausa;
            $this->lsNamespaceGedeeProcesoEjecucion = $namespace_gedee_proceso_pausa;
            $this->lsClaseGedeeProcesoEjecucion     = $clase_gedee_proceso_pausa;
            $this->lsIdGedeeProcesoEjecucion        = $id_gedee_proceso_pausa;

            return null;
            }

        //ejecutar los bloque declarados para ejecucion en el fichero de configuracion del sistema. 			
        public function ejecutarBloquesProcesos()
            {
            if ( ( $this->lsEjecucionBloquesProcesos == false ) && !empty( $this->lbEConfiguracionEjecutada ) && !empty( $this->lsIdProcesoNucleo ) && is_object( $this->EEoConfiguracion ) && is_object( $this->EEoImplementacionProcesos ) )
                {
                $id_proceso_pausa              = $this->lsIdProcesoEjecucion;
                $namespace_gedee_proceso_pausa = $this->lsNamespaceGedeeProcesoEjecucion;
                $clase_gedee_proceso_pausa     = $this->lsClaseGedeeProcesoEjecucion;
                $id_gedee_proceso_pausa        = $this->lsIdGedeeProcesoEjecucion;

                $this->lsIdProcesoEjecucion             = $this->lsIdProcesoNucleo;
                $this->lsNamespaceGedeeProcesoEjecucion = $this->lsNamespaceGedeeProcesoNucleo;
                $this->lsClaseGedeeProcesoEjecucion     = $this->lsClaseGedeeProcesoNucleo;
                $this->lsIdGedeeProcesoEjecucion        = $this->lsIdGedeeProcesoNucleo; 
                //porque en este punto esta corriendo el proceso nucleo
                //tomar lista de bloques de procesos de la configuracion
                $La_lista_bloques_procesos              = $this->EEoConfiguracion->accederDatosConfiguracionProceso( 'hereda' , 'hereda' , 'hereda' , 'hereda' , "['procesos']['orden_permiso_ejecucion_bloques']" );

                //tomar bloque de procesos de la configuracion y ejecutarlo
                foreach ( $La_lista_bloques_procesos as $id_bloque_procesos )
                    {
                    $this->ejecutarBloqueProcesos( $id_bloque_procesos );
                    }

                $this->lsIdProcesoEjecucion             = $id_proceso_pausa;
                $this->lsNamespaceGedeeProcesoEjecucion = $namespace_gedee_proceso_pausa;
                $this->lsClaseGedeeProcesoEjecucion     = $clase_gedee_proceso_pausa;
                $this->lsIdGedeeProcesoEjecucion        = $id_gedee_proceso_pausa;
                }
            return null;
            }

//////////////////////////////////////////procedimientos de procesos///////////////////////////////////////////////////////            
        //debuelve el valor del path raiz del directorio de procesos, declarado en la configuraci�n del sistema
        public function pathDirRaizProcesos()
            {
            if ( !empty( $this->lsIdProcesoNucleo ) && !empty( $this->lbEConfiguracionEjecutada ) && is_object( $this->EEoConfiguracion ) )
                {
                
                $id_proceso_pausa              = $this->lsIdProcesoEjecucion;
                $namespace_gedee_proceso_pausa = $this->lsNamespaceGedeeProcesoEjecucion;
                $clase_gedee_proceso_pausa     = $this->lsClaseGedeeProcesoEjecucion;
                $id_gedee_proceso_pausa        = $this->lsIdGedeeProcesoEjecucion;

                $this->lsIdProcesoEjecucion             = $this->lsIdProcesoNucleo;
                $this->lsNamespaceGedeeProcesoEjecucion = $this->lsNamespaceGedeeProcesoNucleo;
                $this->lsClaseGedeeProcesoEjecucion     = $this->lsClaseGedeeProcesoNucleo;
                $this->lsIdGedeeProcesoEjecucion        = $this->lsIdGedeeProcesoNucleo;

                $path_raiz_procesos = $this->EEoConfiguracion->accederDatosConfiguracionProceso( 'hereda' , 'hereda' , 'hereda' , 'hereda' , "['procesos']['path_raiz_procesos']" );

                $this->lsIdProcesoEjecucion             = $id_proceso_pausa;
                $this->lsNamespaceGedeeProcesoEjecucion = $namespace_gedee_proceso_pausa;
                $this->lsClaseGedeeProcesoEjecucion     = $clase_gedee_proceso_pausa;
                $this->lsIdGedeeProcesoEjecucion        = $id_gedee_proceso_pausa;

                return $path_raiz_procesos;
                }
            return null;
            }

        //debuelve el valor del path del dierctorio raiz del proceso en ejecucion 	
        public function pathDirRaizProcesoEjecucion()
            {
            return $this->lsPathDirRaizProcesoEjecucion;
            }

        //debuelve el valor del id del proceso en ejecucion 	
        public function idProcesoEjecucion()
            {
            return $this->lsIdProcesoEjecucion;
            }

        public function gedeeProcesoEjecucion()
            {
            return $this->lsNamespaceGedeeProcesoEjecucion . '\\' . $this->lsClaseGedeeProcesoEjecucion .'\\'. $this->lsIdGedeeProcesoEjecucion ;
            }

        public function idGedeeProcesoEjecucion()
            {
            return $this->lsIdGedeeProcesoEjecucion;
            }

        public function namespaceGedeeProcesoEjecucion()
            {
            return $this->lsNamespaceGedeeProcesoEjecucion;
            }

        public function claseGedeeProcesoEjecucion()
            {
            return $this->lsClaseGedeeProcesoEjecucion;
            }

        //procedimiento para la actualizacion del arbol de ejecucion de proceso y sus datos, y los punteros que se mueven por su estructura, en este caso es la creacion de un nuevo nodo como proceso hijo, y la actualizacion de apuntadores hacia este proximo nuevo nodo del arbol de ejecucion de procesos 
        //$id_proceso es el id del nuevo proceso a actualizar, si su valor es vacio el procedimiento no realiza la gestion y retorna null
        //$gedee es el gedee del nuevo proceso a actualizar, si su valor es vacio el procedimiento no realiza la gestion y retorna null
        //el procedimiento retorna una id-clave-ejecucion de este proceso para identificar esta ejecucion en particular, y null si fue insatisfactoria la gestion, el id-clave-ejecucion de este proceso esta compuesto de la siguiente manera "$this->idorejecGlobal::$this->idorejecRecursivoProImpEjec::$this->idorejecRecursivoProceso".
        private function procesoHijo( $id_proceso , $Ls_path_dir_raiz_proceso )
            {
            if ( !empty( $id_proceso ) && !empty( $Ls_path_dir_raiz_proceso ) )
                {
                if( ( $this->limiteIdorejecGlobal != -1 ) && ( $this->limiteIdorejecGlobal < $this->idorejecGlobal+1 ) )
                    {
                    trigger_error( 'se intenta exeder el valor de la propiedad limiteIdorejecGlobal' , E_USER_ERROR );
                    }
                if( ( $this->limiteIdorejecRecursivoProImpEjec != -1 ) && ( $this->limiteIdorejecRecursivoProImpEjec < $this->idorejecRecursivoProImpEjec+1 ) )
                    {
                    trigger_error( 'se intenta exeder el valor de la propiedad limiteIdorejecRecursivoProImpEjec' , E_USER_ERROR );
                    }    

                //creacion del espacio o nodo del nuevo proceso a ejecucion con sus propiedades
                $llave_arreglo = 0;
                //inicializando el primer proceso
                if ( empty( $this->laArbolProcesos ) )
                    {
                    $this->laArbolProcesos[0]['id_proceso']              = $id_proceso;
                    $this->laArbolProcesos[0]['path_dir_raiz_proceso']   = $Ls_path_dir_raiz_proceso;
                    $this->laArbolProcesos[0]['namespace_gedee']         = $this->lsNamespaceGedeeProcesoEjecucion;
                    $this->laArbolProcesos[0]['clase_gedee']             = $this->lsClaseGedeeProcesoEjecucion;
                    $this->laArbolProcesos[0]['id_entidad_gedee']        = $this->lsIdGedeeProcesoEjecucion;
                    $this->laArbolProcesos[0]['apuntador_proceso_padre'] = null;
                    $this->laArbolProcesos[0]['idorejec_subproceso']     = null;
                    $this->idorejecGlobal++;
                    $this->idorejecRecursivoProImpEjec++;
                    $id_clave_ejecucion                                  = "$this->idorejecGlobal::$this->idorejecRecursivoProImpEjec::$this->idorejecRecursivoProceso";
                    $this->laArbolProcesos[0]['id_clave_ejecucion']      = $id_clave_ejecucion;
                    $this->apuntadorProcesoActual                        = &$this->laArbolProcesos[0];
                    }
                else
                    {
                    if ( !empty( $this->apuntadorProcesoActual['procesos'] ) )
                        {
                        $llave_arreglo = count( $this->apuntadorProcesoActual['procesos'] );
                        }
                        
                    if( ( $this->limiteIdorejecSubProceso != -1 ) && ( $this->limiteIdorejecSubProceso < $llave_arreglo + 1 ) )
                        {
                        trigger_error( 'se intenta exeder el valor de la propiedad limiteIdorejecSubProceso' , E_USER_ERROR );
                        }    
                        
                    $this->apuntadorProcesoActual['procesos'][$llave_arreglo]['id_proceso']              = $id_proceso;
                    $this->apuntadorProcesoActual['procesos'][$llave_arreglo]['path_dir_raiz_proceso']   = $Ls_path_dir_raiz_proceso;
                    $this->apuntadorProcesoActual['procesos'][$llave_arreglo]['namespace_gedee']         = $this->lsNamespaceGedeeProcesoEjecucion;
                    $this->apuntadorProcesoActual['procesos'][$llave_arreglo]['clase_gedee']             = $this->lsClaseGedeeProcesoEjecucion;
                    $this->apuntadorProcesoActual['procesos'][$llave_arreglo]['id_entidad_gedee']        = $this->lsIdGedeeProcesoEjecucion;
                    $this->apuntadorProcesoActual['procesos'][$llave_arreglo]['apuntador_proceso_padre'] = &$this->apuntadorProcesoActual;
                    $this->apuntadorProcesoActual['procesos'][$llave_arreglo]['idorejec_subproceso']     = $llave_arreglo + 1;

                    //////////////////////////////////////////////////////
                    //actualizacion de los id de orden de ejecucion
                    $this->idorejecGlobal++;
                    $this->idorejecSubProceso = $llave_arreglo + 1;
                    if ( ( $this->apuntadorProcesoActual['id_proceso'] == $id_proceso ) && ( $this->apuntadorProcesoActual['path_dir_raiz_proceso'] == $Ls_path_dir_raiz_proceso ) )
                        {
                        if( ( $this->limiteIdorejecRecursivoProceso != -1 ) && ( $this->limiteIdorejecRecursivoProceso < $this->idorejecRecursivoProceso+1 ) )
                            {
                            trigger_error( 'se intenta exeder el valor de la propiedad limiteIdorejecRecursivoProceso' , E_USER_ERROR );
                            }
                        $this->idorejecRecursivoProceso++;
                        }
                    else
                        {
                        $this->idorejecRecursivoProceso = 0;
                        }
                    $this->idorejecRecursivoProImpEjec++;

                    ////////////////////////////////////////////////////////
                    //creacion del identificador descriptivo de la ejecucion
                    $id_clave_ejecucion = "$this->idorejecGlobal::$this->idorejecRecursivoProImpEjec::$this->idorejecRecursivoProceso";
                    $this->apuntadorProcesoActual['procesos'][$llave_arreglo]['id_clave_ejecucion'] = $id_clave_ejecucion;

                    /////////////////////////////////////////////////////////////
                    //redierccionamiento del apuntadorProcesoActual al nodo del proceso actual                            
                    $this->apuntadorProcesoActual = &$this->apuntadorProcesoActual['procesos'][$llave_arreglo];
                    }
                return $id_clave_ejecucion;
                }
            return null;
            }

        //procedimiento para la actualizacion del arbol de ejecucion de proceso y sus datos, y los punteros que se mueven por su estructura, en este caso en un movimiento hacia el proceso padre o nodo anterior del arbol de ejecucion de procesos 
        //el procedimiento retorna true si su gestion fue satisfactoria y null si fue insatisfactoria.
        private function procesoPadre()
            {
            if ( $this->idorejecRecursivoProImpEjec > 1 )
                {
                $this->apuntadorProcesoActual = &$this->apuntadorProcesoActual['apuntador_proceso_padre'];
                if ( $this->idorejecRecursivoProceso > 0 )
                    {
                    $this->idorejecRecursivoProceso--;
                    }
                $this->idorejecRecursivoProImpEjec--;
                $this->idorejecSubProceso = $this->apuntadorProcesoActual['idorejec_subproceso'];
                return true;
                }
            return null;
            }

        //esta propiedad es para guardar y luego comparar el lugar desde el que se hace el pedido de actualizacion de parametros de procesos desde la instancia de la clase ImplementacionProcesos
        //existe con el objetivo que los procesos no puedan tergiversar los datos de su ejecucion en el nucleo. 
        private $lsUbicacionPedidoActualizacionComienzoProceso     = null;
        private $lsUbicacionPedidoActualizacionFinalizacionProceso = null;

        //procedimiento que actualiza al objeto implementacion de esta clase(objeto e_nucleo)con los datos correspondientes a la ejecucion de un nuevo proceso, actualiza tambien el arbol de ejecucion de procesos que es propiedad de esta clase  
        //$id_proceso es el id del nuevo proceso a actualizar, si su valor es vacio el procedimiento no realiza la gestion y retorna null
        //$gedee es el gedee del nuevo proceso a actualizar, si su valor es vacio el procedimiento no realiza la gestion y retorna null
        //$ubicacion_pedido_actualizacion es la combinacion de clase-procedimiento y linea desde donde se hace el pedido de ejecucion de este procedimiento,luego de la primera ejecucion de este procedimiento se guarda este dato e nmemoria para tomarlo como comparacion en las demas llamadas a este procedimiento, si no coincidiera e nuna posterior llamada el procedimiento retorna null, este dato se mantiene en memoria logica no fisica, cuando el objeto muere, muere el dato con �l, si su valor es vacio el procedimiento no realiza la gestion y retorna null, el primer proceso en actualizar el arbol de procesos es el nucleo pero este lo hace internamente desde su instancia por lo que no actualiza $ubicacion_pedido_actualizacion, este parametro lo actualiza el segundo proceso que actualiza el arbol de procesos .
        //el procedimiento retorna una id-clave-ejecucion de este proceso para identificar esta ejecucion en particular, y null si fue insatisfactoria la gestion, el id-clave-ejecucion de este proceso esta compuesto de la siguiente manera "$this->idorejecGlobal::$this->idorejecRecursivoProImpEjec::$this->idorejecRecursivoProceso".
        public function actualizacionComienzoProceso( $id_proceso , $Ls_path_dir_raiz_proceso , $Ls_id_gedee_proceso , $Ls_namespace_gedee_proceso , $Ls_clase_gedee_proceso , $ubicacion_pedido_actualizacion )
            {
            if ( !empty( $id_proceso ) && !empty( $Ls_path_dir_raiz_proceso ) && !empty( $Ls_namespace_gedee_proceso ) && !empty( $Ls_clase_gedee_proceso ) && !empty( $ubicacion_pedido_actualizacion ) )
                {
                //chequeando que el pedido de actualizacion se haya echo por el objeto EEoImplementacionProcesos y no por un proceso en ejecucion que quiera manipular datos aqui en el nucleo
                if ( empty( $this->lsUbicacionPedidoActualizacionComienzoProceso ) )
                    {
                    $this->lsUbicacionPedidoActualizacionComienzoProceso = $ubicacion_pedido_actualizacion;
                    }
                if ( $ubicacion_pedido_actualizacion == $this->lsUbicacionPedidoActualizacionComienzoProceso )
                    {
                    //actualizar los datos correspondientes a la ejecucion de procesos y crear un id_ejecucion del proceso actual
                    
                    if( ( $Ls_namespace_gedee_proceso == $this->lsNamespaceGedeeProcesoNucleo ) && ( $Ls_clase_gedee_proceso == $this->lsClaseGedeeProcesoNucleo ) )
                    	{
                    	$this->lsIdProcesoNucleo             = $id_proceso;
                    	$this->lsIdGedeeProcesoNucleo        = $Ls_id_gedee_proceso ;
                    	}
                    	
                    $this->lsIdProcesoEjecucion             = $id_proceso;
                    $this->lsPathDirRaizProcesoEjecucion    = $Ls_path_dir_raiz_proceso;
                    $this->lsIdGedeeProcesoEjecucion        = $Ls_id_gedee_proceso ;
                    $this->lsNamespaceGedeeProcesoEjecucion = $Ls_namespace_gedee_proceso;
                    $this->lsClaseGedeeProcesoEjecucion     = $Ls_clase_gedee_proceso;

                    return $this->procesoHijo( $id_proceso , $Ls_path_dir_raiz_proceso );
                    }
                }
            return null;
            }

        //procedimiento que actualiza al objeto implementacion de esta clase(objeto e_nucleo)con los datos correspondientes a la finalizacion de la ejecucion de un proceso, actualiza tambien el arbol de ejecucion de procesos que es propiedad de esta clase  
        //$id_clave_ejecucion es el id clave de ejecucion que se le dio al proceso que finaliza en el comienzo de su ejecucion, si su valor es vacio el procedimiento no realiza la gestion y retorna null
        //$ubicacion_pedido_actualizacion es la combinacion de clase-procedimiento y linea desde donde se hace el pedido de ejecucion de este procedimiento,luego de la primera ejecucion de este procedimiento se guarda este dato e nmemoria para tomarlo como comparacion en las demas llamadas a este procedimiento, si no coincidiera e nuna posterior llamada el procedimiento retorna null, este dato se mantiene en memoria logica no fisica, cuando el objeto muere, muere el dato con �l, si su valor es vacio el procedimiento no realiza la gestion y retorna null.
        //el procedimiento retorna true si su gestion fue satisfactoria y null si fue insatisfactoria.
        public function actualizacionFinalizacionProceso( $id_clave_ejecucion , $ubicacion_pedido_actualizacion )
            {
            if ( !empty( $id_clave_ejecucion ) && !empty( $ubicacion_pedido_actualizacion ) )
                {
                //chequeando que el pedido de actualizacion se haya echo por el objeto EEoImplementacionProcesos y no por un proceso en ejecucion que quiera manipular datos aqui en el nucleo
                if ( empty( $this->lsUbicacionPedidoActualizacionFinalizacionProceso ) )
                    {
                    $this->lsUbicacionPedidoActualizacionFinalizacionProceso = $ubicacion_pedido_actualizacion;
                    }
                if ( $ubicacion_pedido_actualizacion == $this->lsUbicacionPedidoActualizacionFinalizacionProceso )
                    {
                    //actualizar los datos correspondientes a la ejecucion de procesos y crear un id_ejecucion del proceso actual
                    if ( $id_clave_ejecucion == $this->apuntadorProcesoActual['id_clave_ejecucion'] )
                        {
                        $this->procesoPadre();
                        
                        if( ( $this->lsNamespaceGedeeProcesoNucleo == $this->apuntadorProcesoActual['namespace_gedee'] ) && ( $this->lsClaseGedeeProcesoNucleo == $this->apuntadorProcesoActual['clase_gedee'] ) )
                    		{
                    		$this->lsIdProcesoNucleo      = $this->apuntadorProcesoActual['id_proceso'];
                    		$this->lsIdGedeeProcesoNucleo = $this->apuntadorProcesoActual['id_entidad_gedee'];
                    		}
                        echo 'vvvvvvvvvvvvvvvvvvvvvv'.$this->apuntadorProcesoActual['namespace_gedee'];
                        $this->lsIdProcesoEjecucion             = $this->apuntadorProcesoActual['id_proceso'];
                        $this->lsPathDirRaizProcesoEjecucion    = $this->apuntadorProcesoActual['path_dir_raiz_proceso'];
                        $this->lsNamespaceGedeeProcesoEjecucion = $this->apuntadorProcesoActual['namespace_gedee'];
                        $this->lsClaseGedeeProcesoEjecucion     = $this->apuntadorProcesoActual['clase_gedee'];
                        $this->lsIdGedeeProcesoEjecucion        = $this->apuntadorProcesoActual['id_entidad_gedee'];

                        return true;
                        }
                    }
                }

            //exit( '<p>ERROR FATAL, procedimiento: ' . __METHOD__ . ', finalizaci&oacute;n de procesos no correspondientes' );
            trigger_error('Finalizaci&oacute;n de procesos no correspondientes ' , E_USER_ERROR ) ;
            }

        //procedimiento para filtrar el arreglo laArbolProcesos de esta clase
        //$La_historial_procesos es el arreglo laArbolProcesos al que se va a filtrar, esta variable se pasa por referencia
        //$Li_nivel es para el funcionamiento interno del procedimiento, especificamente en la recurcion, no es necesario se utilize por el usuario 
        private function filtrarHistorialArbolProcesos( &$La_historial_procesos , $Li_nivel = 0 )
            {
            if ( $Li_nivel == 0 )
                {
                //Chequeo de errores
                if ( !is_array( $La_historial_procesos ) || empty( $La_historial_procesos ) )
                    {
                    //echo'ERROR, El par�metro $La_historial_procesos no es array o su valor es vac�o';
                    return NULL;
                    }
                }
            foreach ( $La_historial_procesos as $key_miembro_secc => &$valor_miembro_secc )
                {
                unset( $valor_miembro_secc['apuntador_proceso_padre'] );
                unset( $valor_miembro_secc['idorejec_subproceso'] );
                if ( isset( $valor_miembro_secc['procesos'] ) && is_array( $valor_miembro_secc['procesos'] ) && !empty( $valor_miembro_secc['procesos'] ) )
                    {
                    $this->filtrarHistorialArbolProcesos( $valor_miembro_secc["procesos"] , $Li_nivel + 1 );
                    }
                }
            return $La_historial_procesos;
            }

        //procedimiento para aceder al arreglo historial_arbol_procesos, basado en el arreglo laArbolProcesos de esta clase, arreglo que no modifica ya que hace el filtrado sobre una copia de la variable.
        //el arreglo tendra la misma estructura que el arreglo laArbolProcesos de esta clase pero sin los elementos 'apuntador_procesoPadre' y 'idorejecSubProceso'.
        public function accederHistorialArbolProcesos()
            {
            if ( !empty( $this->laArbolProcesos ) )
                {
                $historial_arbol_procesos = $this->laArbolProcesos;
                echo 'solo para pruebas *********************************';
                echo 'estructura real del arbol de procesos en ' . __METHOD__ . __LINE__ . '************<p>';
                var_dump( $this->laArbolProcesos );
                echo '<p>solo para pruebas *********************************fin de estructura real del arbol de procesos*************************************************';
                return $this->filtrarHistorialArbolProcesos( $historial_arbol_procesos );
                }
            return null;
            }

        //procedimiento para acceder a propiedades del proceso padre del proceso actual(ejecutandose), las propiedaes son id_proceso y tipo_proceso
        //el procedimiento retorna un arreglo asociativo con los id_clave: 'id_proceso' y 'tipo_proceso' y sus valores correspondientes al proceso padre del proceso actual
        //en caso de no ser exitosa la gestion retornara null.
        public function accederPropiedadesProcesoPadre()
            {
            if ( !empty( $this->apuntadorProcesoActual['apuntador_proceso_padre'] ) )
                {
                $apuntador_procesopadre                         = &$this->apuntadorProcesoActual['apuntador_proceso_padre'];
                $La_propiedades_procesopadre['id_proceso']      = $apuntador_procesopadre['id_proceso'];
                $La_propiedades_procesopadre['namespace_gedee'] = $apuntador_procesopadre['namespace_gedee'];
                $La_propiedades_procesopadre['clase_gedee']     = $apuntador_procesopadre['clase_gedee'];
                $La_propiedades_procesopadre['id_entidad_gedee'] = $apuntador_procesopadre['id_entidad_gedee'];

                return $La_propiedades_procesopadre;
                }
            return null;
            }

        }

?>