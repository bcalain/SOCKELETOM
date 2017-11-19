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
   * @link https://github.com/bcalain/SOCKELETOM
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

    namespace Emod\Nucleo;

    class NucleoControl extends \Emod\Nucleo\NucleoEntidadBase
        {

        private $lsPathDirEsquelemod           = null;
        private $lsPathDirModulos              = null;
        private $lsNombreDominioWeb = '';
        private $lsIdProcesoNucleo             = 'NucleoEsquelemod';
        private $lsNamespaceGedeeProcesoNucleo = '\\Emod\\Nucleo\\Gedees';
        private $lsClaseGedeeProcesoNucleo     = 'GedeeENucleo';
        private $lsIdGedeeProcesoNucleo        = 'GedeeENucleo';
        private $lbIniciacionGedee             = null;
        private $lbEConfiguracionEjecutada     = false;
        private $lbIniciacionErrores           = null;
        private $lbIniciacionHerramientas      = null;
        private $lbIniciacionUtiles            = null;
        private $lbIniciacionLogs              = NULL;
        private $EEoLogsProcesos               = NULL;
        private $lsPathDirRaizProcesoEjecucion = ''; 
        private $lsIdProcesoEjecucion          = ''; 
        private $lsNamespaceGedeeProcesoEjecucion = '';
        private $lsClaseGedeeProcesoEjecucion = '';
        private $lsIdGedeeProcesoEjecucion = ''; 
        private $laArbolProcesos             = null;
        private $idorejecGlobal                    = 0;
        private $limiteIdorejecGlobal              = -1;
        private $idorejecBloqueProcesos            = 0;
        private $limiteIdorejecBloqueProcesos      = -1;
        private $idorejecSubProceso                = 0;
        private $limiteIdorejecSubProceso          = -1;
        private $idorejecRecursivoProceso          = 0;
        private $limiteIdorejecRecursivoProceso    = -1;
        private $idorejecRecursivoProImpEjec       = 0;
        private $limiteIdorejecRecursivoProImpEjec = -1;
        private $apuntadorProcesoActual      = null;
        private $statuEjecucionProceso       = null;

        final private function iniciacionClassGedees( $La_configuracion_nucleo_gedees = null )
            {
            if ( empty( $this->lbEConfiguracionEjecutada ) && empty( $this->lbIniciacionGedee ) && !empty( $La_configuracion_nucleo_gedees ) )
                {
                if ( !( \Emod\Nucleo\GEDEEs::iniciacion( $La_configuracion_nucleo_gedees ) ) || ( !( \Emod\Nucleo\GEDEEs::existenciaEntidad( '\Emod\Nucleo\Gedees' , 'GedeeEPadre' ) ) ) || ( !( \Emod\Nucleo\GEDEEs::entidad( '\Emod\Nucleo\Gedees' , 'GedeeEPadre' , 'GedeeEPadre' ) ) ) )
                    {
                    trigger_error('fallida la iniciaci&oacute;n de la clase GEDEEs' , E_USER_ERROR ) ;
                    }
                    
                $this->lbIniciacionGedee = true;
                }
            }

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
                    trigger_error('No pudo iniciarse el proceso n&uacute;cleo' , E_USER_ERROR ) ;
                    }
                }
            return null;
            }

        public function pathDirEsquelemod()
            {
            return $this->lsPathDirEsquelemod;
            }

        public function pathDirModulos()
            {
            return $this->lsPathDirModulos;
            }

        public function idProcesoNucleo()
            {
            return $this->lsIdProcesoNucleo;
            }

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

        
    public function gestionIniciacionConfiguracionEsquelemod( $La_fich_interfaz_config , $La_fich_datos_config = null )
            {
            if ( empty( $this->lbEConfiguracionEjecutada ) && !empty( $this->lsIdProcesoNucleo ) && is_object( $this->EEoInterfazDatos ) && is_object( $this->EEoConfiguracion ) && !empty( $La_fich_interfaz_config ) )
                {
                $resultado           = null;
                
                $datos_configuracion = $this->EEoInterfazDatos->gestionEjecucionInterfazSalida( $this->lsIdProcesoNucleo , $La_fich_interfaz_config , $La_fich_datos_config , 'adyacente' );

                if ( !empty( $datos_configuracion ) )
                    {
                    if ( !empty( $datos_configuracion['identificador_referencia_local'] ) )
                        {

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
                    
                    if ( !empty( $datos_configuracion['sistema']['propiedades_servidor_hospedero']['nombre_dominio_web'] ) )
                        {
                           	$this->lsNombreDominioWeb= $datos_configuracion['sistema']['propiedades_servidor_hospedero']['nombre_dominio_web'];
                        }
                    else 
                    	{
                    		$this->lsNombreDominioWeb = $_SERVER['SERVER_NAME'];
                   		}
                        	
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
                        trigger_error('La gesti&oacute;n de propiedades del proceso n&uacute;cleo fue insatisfactoria ' , E_USER_ERROR );
                        }    
                        
                    if ( !empty( $datos_configuracion['herramientas']['ejecucion'] ) )
                        {
                        $this->iniciacionClassHerramientas( $datos_configuracion['herramientas'] );
                        }
                    else
                        {
                        trigger_error('La ejecuci&oacute;n de gesti&oacute;n de herramientas por el sistema esquelemod esta desactivada, la propiedad correspondiente a la ejecuci&oacute;n de las Herramientas tiene valor vac&iacute;o en la configuraci&oacute;n del sistema' , E_USER_WARNING);
                        }

                    if ( !empty( $datos_configuracion['utiles']['ejecucion'] ) )
                        {
                        $this->iniciacionClassUtiles( $datos_configuracion['utiles'] );
                        }
                    else
                        {
                        trigger_error('La ejecuci&oacute;n de gesti&oacute;n de &uacute;tiles por el sistema esquelemod esta desactivada, la propiedad correspondiente a la ejecuci&oacute;n de los &uacute;tiles tiene valor vac&iacute;o en la configuraci&oacute;n del sistema' , E_USER_WARNING);
                        }

                    if ( !empty( $datos_configuracion['errores']['ejecucion'] ) )
                        {
                        $iniciacion_errores = $this->iniciacionErrores( $datos_configuracion['errores'] ) ;
                        if( empty( $iniciacion_errores ) )
                            {
                            trigger_error('La ejecuci&oacute;n de gesti&oacute;n de errores por el sistema esquelemod esta desactivada, la propiedad correspondiente a la ejecuci&oacute;n de los errores tiene valor vac&iacute;o en la configuraci&oacute;n del sistema' , E_USER_WARNING);
                            }
                        \Emod\Nucleo\CropNucleo::ingresarNuevoObjeto( 'EEoErrores' , $this->EEoErrores );
                        }
                   
                    if ( !empty( $datos_configuracion['logs']['ejecucion'] ) )
                        {
                        	if( empty( $this->iniciacionLogs( $datos_configuracion['logs'] )) )
                        	{
                        		trigger_error('La gesti&oacute;n de logs por el sistema esquelemod no pudo ser iniciada' , E_USER_WARNING);
                        	}
                        }
                        else
                        {
                        	trigger_error('La ejecuci&oacute;n de gesti&oacute;n de logs por el sistema esquelemod esta desactivada, la propiedad correspondiente a la ejecuci&oacute;n de los logs tiene valor vac&iacute;o en la configuraci&oacute;n del sistema' , E_USER_WARNING);
                        }
                    
                    if ( !empty( $datos_configuracion['gedees']['path_dir_raiz'] ) && !empty( $datos_configuracion['gedees']['existentes_sistema'] ) )
                        {
                        $this->iniciacionClassGedees( $datos_configuracion['gedees'] );
                        }
                    else
                        {
                        trigger_error('No se encuentra valor para propiedad correspondiente a la configuraci&oacute;n de los GEDEEs' , E_USER_ERROR ) ;
                        }
                        
                    if ( !empty( $datos_configuracion['procesos'] ) )
                        {
                        $this->iniciacionProcesos( $datos_configuracion['procesos'] );
                        }
                    else
                        {
                        trigger_error('No se encuentra valor para propiedad correspondiente a la configuraci&oacute;n de los Procesos' , E_USER_ERROR ) ;
                        }    
                        
                    $resultado = $this->EEoConfiguracion->iniciarDatosConfiguracionProceso( $datos_configuracion );
                                        
                    }
                if ( !empty( $resultado ) )
                    {
                    $this->lbEConfiguracionEjecutada = true;
                    return $resultado;
                    }
                }
            return null;
            }
		
		public function accesoPropiedadesEsquelemod()
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

                $propiedades_sistema = $this->EEoConfiguracion->accederDatosConfiguracionProceso( 'hereda' , 'hereda' ,'hereda' , 'hereda' , "['sistema']['propiedades_proceso']" );

                $this->lsIdProcesoEjecucion             = $id_proceso_pausa;
                $this->lsNamespaceGedeeProcesoEjecucion = $namespace_gedee_proceso_pausa;
                $this->lsClaseGedeeProcesoEjecucion     = $clase_gedee_proceso_pausa;
                $this->lsIdGedeeProcesoEjecucion        = $id_gedee_proceso_pausa;

                return $propiedades_sistema;
                }
            return null;
            }

		private function iniciacionErrores( $La_configuracion_nucleo_errores = null )
            {
            if ( !empty( $La_configuracion_nucleo_errores ) && is_array( $La_configuracion_nucleo_errores ) && !empty( $La_configuracion_nucleo_errores['ejecucion'] ) && class_exists( '\Emod\Nucleo\Errores' ) && !is_object( $this->EEoErrores ) && empty( $this->lbEConfiguracionEjecutada ) && empty( $this->lbIniciacionErrores ) )
                {
                if ( !( \Emod\Nucleo\Errores::iniciacion( $La_configuracion_nucleo_errores ) ) )
                    {
                    trigger_error('Fallida la iniciaci&oacute;n de la clase errores' , E_USER_ERROR ) ;
                    }
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
                            trigger_error('Fallida la iniciaci&oacute;n del GEDEGE' , E_USER_ERROR ) ;
                            }
                        }
                    }
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
						$gestion_ingresos_errores_emod = \Emod\Nucleo\Errores::gestionIngresosEntidades( $La_configuracion_nucleo_errores['entidad_errores_emod'] );
                        
                        if ( empty( $gestion_ingresos_errores_emod ) )
                            {
                            trigger_error('Fallido el registro de la Entidad Errores del Esquelemod' , E_USER_ERROR ) ;
                            }
                        }
                    $this->EEoErrores = \Emod\Nucleo\Errores::entidad( $namespace2 , $clase2 , $id_error2 );

                    if ( empty( $this->EEoErrores ) )
                        {
                        trigger_error('Fallida la iniciaci&oacute;n de la Entidad Errores del Esquelemod' , E_USER_ERROR ) ;
                        }
                    $this->lbIniciacionErrores = true;
                    return true ;
                    }
                else
                    {
                    trigger_error('No existe valor para Entidad Errores del Esquelemod' , E_USER_ERROR ) ;
                    }
                }
            trigger_error('No se pudo gestionar la iniciaci&oacute;n de errores del sistema Esquelemod' , E_USER_ERROR ) ;
            }

		private function iniciacionClassHerramientas( $La_configuracion_nucleo_herramientas = null )
            {
            if ( class_exists( '\Emod\Nucleo\Herramientas' ) && empty( $this->lbEConfiguracionEjecutada ) && empty( $this->lbIniciacionHerramientas ) && !empty( $La_configuracion_nucleo_herramientas ) )
                {
                if ( !( \Emod\Nucleo\Herramientas::iniciacion( $La_configuracion_nucleo_herramientas ) ) )
                    {
                    trigger_error('Fallida la iniciaci&oacute;n de la clase Herramientas' , E_USER_ERROR ) ;
                    }
                    
                $this->lbIniciacionHerramientas = true;
                }
            }

		private function iniciacionClassUtiles( $La_configuracion_nucleo_utiles = null )
            {
            if ( class_exists( '\Emod\Nucleo\Utiles' ) && empty( $this->lbEConfiguracionEjecutada ) && empty( $this->lbIniciacionUtiles ) && !empty( $La_configuracion_nucleo_utiles ) )
                {
                if ( !( \Emod\Nucleo\Utiles::iniciacion( $La_configuracion_nucleo_utiles ) ) )
                    {
                    trigger_error('Fallida la iniciaci&oacute;n de la clase &Uacute;tiles' , E_USER_ERROR ) ;
                    }
                $this->lbIniciacionUtiles = true;
                }
            }
            
        private function iniciacionLogs( $La_configuracion_nucleo_logs = NULL )
            {
            	if ( !empty( $La_configuracion_nucleo_logs ) && is_array( $La_configuracion_nucleo_logs ) && !empty( $La_configuracion_nucleo_logs['ejecucion'] ) && !empty( $La_configuracion_nucleo_logs['path_dir_raiz'] ) && empty( $this->lbEConfiguracionEjecutada ) && empty( $this->lbIniciacionLogs ) )
            	{
            		if ( !( $this->lbIniciacionHerramientas ) )
            		{
            			trigger_error('Fallida la iniciaci&oacute;n de la clase Logs, Clase herramientas no iniciada' , E_USER_ERROR ) ;
            		}
            		
            		if ( !empty( $La_configuracion_nucleo_logs['entidad_logs_emod'] ) && is_array( $La_configuracion_nucleo_logs['entidad_logs_emod'] ) )
            		{
            			reset( $La_configuracion_nucleo_logs['entidad_logs_emod'] );
            			$entidad_logs_emod['namespace']= key( $La_configuracion_nucleo_logs['entidad_logs_emod'] );
            			reset( $La_configuracion_nucleo_logs['entidad_logs_emod'][$entidad_logs_emod['namespace']] );
            			$entidad_logs_emod['clase']= key( $La_configuracion_nucleo_logs['entidad_logs_emod'][$entidad_logs_emod['namespace']] );
            			reset( $La_configuracion_nucleo_logs['entidad_logs_emod'][$entidad_logs_emod['namespace']][$entidad_logs_emod['clase']]['instancias'] );
            			$entidad_logs_emod['id_instancia']= key( $La_configuracion_nucleo_logs['entidad_logs_emod'][$entidad_logs_emod['namespace']][$entidad_logs_emod['clase']]['instancias'] );
            			
            			if ( !empty($La_configuracion_nucleo_logs['tipos_log']) && is_array($La_configuracion_nucleo_logs['tipos_log']) )
            			{
            				$La_configuracion_nucleo_logs['tipos_log'] = array_unique($La_configuracion_nucleo_logs['tipos_log']);
            				
            				foreach( $La_configuracion_nucleo_logs['tipos_log'] as $tipo_log => $instancia_asociada )
            				{
            					if ( isset($La_configuracion_nucleo_logs['entidad_logs_emod'][$entidad_logs_emod['namespace']][$entidad_logs_emod['clase']]['instancias'][$instancia_asociada]) && !empty( $La_configuracion_nucleo_logs[$tipo_log]) && is_array($La_configuracion_nucleo_logs[$tipo_log]) && $La_configuracion_nucleo_logs[$tipo_log]['ejecucion'] )
            					{
            						if (!empty($La_configuracion_nucleo_logs[$tipo_log]['parametros_instanciacion_entidadlog']))
            						{
            							$La_configuracion_nucleo_logs[$tipo_log]['parametros_instanciacion_entidadlog'] = array('path_raiz_log' => $La_configuracion_nucleo_logs['path_dir_raiz'])+$La_configuracion_nucleo_logs[$tipo_log]['parametros_instanciacion_entidadlog'];
            							$La_configuracion_nucleo_logs['entidad_logs_emod'][$entidad_logs_emod['namespace']][$entidad_logs_emod['clase']]['instancias'][$instancia_asociada]['parametros_iniciacion'] = $La_configuracion_nucleo_logs[$tipo_log]['parametros_instanciacion_entidadlog'] ;
            						}
            						
            						\Emod\Nucleo\Herramientas::gestionIngresoEntidad($entidad_logs_emod['namespace'] , $entidad_logs_emod['clase'] , $La_configuracion_nucleo_logs['entidad_logs_emod'][$entidad_logs_emod['namespace']][$entidad_logs_emod['clase']]['path_entidad_clase'] , $La_configuracion_nucleo_logs['entidad_logs_emod'][$entidad_logs_emod['namespace']][$entidad_logs_emod['clase']]['referencia_path_entidad'] , $La_configuracion_nucleo_logs['entidad_logs_emod'][$entidad_logs_emod['namespace']][$entidad_logs_emod['clase']]['tipo_entidad'] , $La_configuracion_nucleo_logs['entidad_logs_emod'][$entidad_logs_emod['namespace']][$entidad_logs_emod['clase']]['instancias'],  $La_configuracion_nucleo_logs['entidad_logs_emod'][$entidad_logs_emod['namespace']][$entidad_logs_emod['clase']]['iniciacion']);
            						
            						if ( $instancia_asociada == 'EEoLogsProcesos')
            						{
            							$this->EEoLogsProcesos = \Emod\Nucleo\Herramientas::entidad($entidad_logs_emod['namespace'] , $entidad_logs_emod['clase'] , $instancia_asociada);
            						}
            					}
            					else
            					{
            						trigger_error("No se pudo crear o está deshabilitada la entidad log $tipo_log en __METHOD__", E_USER_WARNING);
            					}
            				}
            			}
            			
            			if ( empty( $this->EEoLogsProcesos) )
            			{
            				trigger_error('Fallida la iniciaci&oacute;n de la Entidad EEoLogsProcesos del Sockeletom' , E_USER_WARNING ) ;
            			}
            			$this->lbIniciacionLogs = true ;
            			return true ;
            		}
            	}
            	trigger_error('No se pudo gestionar la iniciaci&oacute;n de Logs del sistema Esquelemod' , E_USER_WARNING) ;
            }

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

        private $lsEjecucionBloquesProcesos  = false;
        private $lsIdBloqueEjecucionProcesos = null;

        public function bloqueEjecucionProcesos()
            {
            return $this->lsIdBloqueEjecucionProcesos;
            }

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
            $this->lsIdGedeeProcesoEjecucion        = $this->lsIdGedeeProcesoNucleo; 
            
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
                                unset ( $valores_proceso['propiedades_implementacion_proceso']['condicion_ejecucion'] ) ;
                                }
                            $ejecucion_proceso = $this->EEoImplementacionProcesos->cargaControlProcesos( $id_proceso , $Ls_id_gedee_proceso_ejecucion , $Ls_clase_gedee_proceso_ejecucion , $Ls_namespace_gedee_proceso_ejecucion , $valores_proceso['propiedades_implementacion_proceso'] );
                            if ( !$ejecucion_proceso )
                                {
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
                trigger_error('No se encuentra el bloque de procesos '.$id_bloque.' en la configuraci&oacute;n del sistema ' , E_USER_ERROR ) ;
                }

            $this->lsIdProcesoEjecucion             = $id_proceso_pausa;
            $this->lsNamespaceGedeeProcesoEjecucion = $namespace_gedee_proceso_pausa;
            $this->lsClaseGedeeProcesoEjecucion     = $clase_gedee_proceso_pausa;
            $this->lsIdGedeeProcesoEjecucion        = $id_gedee_proceso_pausa;

            return null;
            }

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
                
                $La_lista_bloques_procesos              = $this->EEoConfiguracion->accederDatosConfiguracionProceso( 'hereda' , 'hereda' , 'hereda' , 'hereda' , "['procesos']['orden_permiso_ejecucion_bloques']" );

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

        public function nombreDominioWeb()
        	{
        		return $this->lsNombreDominioWeb ;
        	}
        public function pathDirRaizProcesoEjecucion()
            {
            return $this->lsPathDirRaizProcesoEjecucion;
            }
        
        public function pathAbsolutoDirRaizProcesoEjecucion()
            {
            return $this->lsPathDirEsquelemod.'/e_modulos/'.$this->pathDirRaizProcesos().'/'.$this->lsPathDirRaizProcesoEjecucion;
            }    

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

                $llave_arreglo = 0;
                
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

                    $id_clave_ejecucion = "$this->idorejecGlobal::$this->idorejecRecursivoProImpEjec::$this->idorejecRecursivoProceso";
                    $this->apuntadorProcesoActual['procesos'][$llave_arreglo]['id_clave_ejecucion'] = $id_clave_ejecucion;

                    $this->apuntadorProcesoActual = &$this->apuntadorProcesoActual['procesos'][$llave_arreglo];
                    }
                return $id_clave_ejecucion;
                }
            return null;
            }

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

        private $lsUbicacionPedidoActualizacionComienzoProceso     = null;
        private $lsUbicacionPedidoActualizacionFinalizacionProceso = null;

        public function actualizacionComienzoProceso( $id_proceso , $Ls_path_dir_raiz_proceso , $Ls_id_gedee_proceso , $Ls_namespace_gedee_proceso , $Ls_clase_gedee_proceso , $ubicacion_pedido_actualizacion )
            {
            if ( !empty( $id_proceso ) && !empty( $Ls_path_dir_raiz_proceso ) && !empty( $Ls_namespace_gedee_proceso ) && !empty( $Ls_clase_gedee_proceso ) && !empty( $ubicacion_pedido_actualizacion ) )
                {
                if ( empty( $this->lsUbicacionPedidoActualizacionComienzoProceso ) )
                    {
                    $this->lsUbicacionPedidoActualizacionComienzoProceso = $ubicacion_pedido_actualizacion;
                    }
                if ( $ubicacion_pedido_actualizacion == $this->lsUbicacionPedidoActualizacionComienzoProceso )
                    {
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

                    $clave_proceso = $this->procesoHijo( $id_proceso , $Ls_path_dir_raiz_proceso );
                    
                    if (!empty($this->lbIniciacionLogs))
                    {
                    	if (!empty($this->EEoLogsProcesos))
                    	{
                    		$this->EEoLogsProcesos->log( array( 'linea' => array( __LINE__ ) , 'fichero' => array( __FILE__) ) );
                    	}
                    }
                    
                    return $clave_proceso ;
                    }
                }
            return null;
            }

        public function actualizacionFinalizacionProceso( $id_clave_ejecucion , $ubicacion_pedido_actualizacion )
            {
            if ( !empty( $id_clave_ejecucion ) && !empty( $ubicacion_pedido_actualizacion ) )
                {
                if ( empty( $this->lsUbicacionPedidoActualizacionFinalizacionProceso ) )
                    {
                    $this->lsUbicacionPedidoActualizacionFinalizacionProceso = $ubicacion_pedido_actualizacion;
                    }
                if ( $ubicacion_pedido_actualizacion == $this->lsUbicacionPedidoActualizacionFinalizacionProceso )
                    { 
                    if ( $id_clave_ejecucion == $this->apuntadorProcesoActual['id_clave_ejecucion'] )
                        {
                        
                        if (!empty($this->lbIniciacionLogs))
                        	{
                        		if (!empty($this->EEoLogsProcesos))
                        		{
                        			$this->EEoLogsProcesos->log( array( 'estado_proceso' => array( 2 ) , 'linea' => array( __LINE__ ) , 'fichero' => array( __FILE__ ) ) );
                        		}
                        	}
                        	
                        $this->procesoPadre();
                        
                        if( ( $this->lsNamespaceGedeeProcesoNucleo == $this->apuntadorProcesoActual['namespace_gedee'] ) && ( $this->lsClaseGedeeProcesoNucleo == $this->apuntadorProcesoActual['clase_gedee'] ) )
                    		{
                    		$this->lsIdProcesoNucleo      = $this->apuntadorProcesoActual['id_proceso'];
                    		$this->lsIdGedeeProcesoNucleo = $this->apuntadorProcesoActual['id_entidad_gedee'];
                    		}
                        
                        $this->lsIdProcesoEjecucion             = $this->apuntadorProcesoActual['id_proceso'];
                        $this->lsPathDirRaizProcesoEjecucion    = $this->apuntadorProcesoActual['path_dir_raiz_proceso'];
                        $this->lsNamespaceGedeeProcesoEjecucion = $this->apuntadorProcesoActual['namespace_gedee'];
                        $this->lsClaseGedeeProcesoEjecucion     = $this->apuntadorProcesoActual['clase_gedee'];
                        $this->lsIdGedeeProcesoEjecucion        = $this->apuntadorProcesoActual['id_entidad_gedee'];
                        
                        return true;
                        }
                    }
                }

            trigger_error('Finalizaci&oacute;n de procesos no correspondientes ' , E_USER_ERROR ) ;
            }

        private function filtrarHistorialArbolProcesos( &$La_historial_procesos , $Li_nivel = 0 )
            {
            if ( $Li_nivel == 0 )
                {
                if ( !is_array( $La_historial_procesos ) || empty( $La_historial_procesos ) )
                    {
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

        public function accederHistorialArbolProcesos()
            {
            if ( !empty( $this->laArbolProcesos ) )
                {
                $historial_arbol_procesos = $this->laArbolProcesos;
                return $this->filtrarHistorialArbolProcesos( $historial_arbol_procesos );
                }
            return null;
            }

        public function reapProcesoEjecucion()
            {
            	return $this->apuntadorProcesoActual['id_clave_ejecucion'] ;
            }
        
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