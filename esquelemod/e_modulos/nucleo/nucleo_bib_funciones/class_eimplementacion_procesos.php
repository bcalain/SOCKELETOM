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
   * ImplementacionProcesos class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

    namespace Emod\Nucleo ;

    class ImplementacionProcesos extends \Emod\Nucleo\NucleoEntidadBase
        {

        final private function controlEntidadesNucleo( $La_entidades = null )
            {
        	$this->EEoImplementacionProcesos = $this ;
            if ( $La_entidades == null )
                {
                if ( $this->EEoNucleo !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) )
                    {
                    $this->EEoNucleo = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ;
                    }

                if ( $this->EEoConfiguracion !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoConfiguracion' , 'ConfiguracionProcesos' , 'Emod\Nucleo' ) )
                    {
                    $this->EEoConfiguracion = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoConfiguracion' , 'ConfiguracionProcesos' , 'Emod\Nucleo' ) ;
                    }

                if ( $this->EEoSeguridad !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoSeguridad' , 'SeguridadProcesos' , 'Emod\Nucleo' ) )
                    {
                    $this->EEoSeguridad = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoSeguridad' , 'SeguridadProcesos' , 'Emod\Nucleo' ) ;
                    }

                if ( $this->EEoDatos !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoDatos' , 'DatosProcesos' , 'Emod\Nucleo' ) )
                    {
                    $this->EEoDatos = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoDatos' , 'DatosProcesos' , 'Emod\Nucleo' ) ;
                    }

                if ( $this->EEoInterfazDatos !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoInterfazDatos' , 'InterfazDatos' , 'Emod\Nucleo\Herramientas' ) )
                    {
                    $this->EEoInterfazDatos = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoInterfazDatos' , 'InterfazDatos' , 'Emod\Nucleo\Herramientas' ) ;
                    }
                return true ;
                }
            elseif ( is_array( $La_entidades ) && !empty( $La_entidades ) )
                {
                $marca_entidad = false ;
                foreach ( $La_entidades as $entidad )
                    {
                    if ( $entidad == 'EEoNucleo' )
                        {
                        if ( !$marca_entidad )
                            {
                            $marca_entidad = true ;
                            }
                        if ( $this->EEoNucleo !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) )
                            {
                            $this->EEoNucleo = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ;
                            }
                        }
                    if ( $entidad == 'EEoConfiguracion' )
                        {
                        if ( !$marca_entidad )
                            {
                            $marca_entidad = true ;
                            }
                        if ( $this->EEoConfiguracion !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoConfiguracion' , 'ConfiguracionProcesos' , 'Emod\Nucleo' ) )
                            {
                            $this->EEoConfiguracion = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoConfiguracion' , 'ConfiguracionProcesos' , 'Emod\Nucleo' ) ;
                            }
                        }
                    if ( $entidad == 'EEoSeguridad' )
                        {
                        if ( !$marca_entidad )
                            {
                            $marca_entidad = true ;
                            }
                        if ( $this->EEoSeguridad !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoSeguridad' , 'SeguridadProcesos' , 'Emod\Nucleo' ) )
                            {
                            $this->EEoSeguridad = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoSeguridad' , 'SeguridadProcesos' , 'Emod\Nucleo' ) ;
                            }
                        }
                    if ( $entidad == 'EEoDatos' )
                        {
                        if ( !$marca_entidad )
                            {
                            $marca_entidad = true ;
                            }
                        if ( $this->EEoDatos !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoDatos' , 'DatosProcesos' , 'Emod\Nucleo' ) )
                            {
                            $this->EEoDatos = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoDatos' , 'DatosProcesos' , 'Emod\Nucleo' ) ;
                            }
                        }
                    if ( $entidad == 'EEoInterfazDatos' )
                        {
                        if ( !$marca_entidad )
                            {
                            $marca_entidad = true ;
                            }
                        if ( $this->EEoInterfazDatos !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoInterfazDatos' , 'InterfazDatos' , 'Emod\Nucleo\Herramientas' ) )
                            {
                            $this->EEoInterfazDatos = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoInterfazDatos' , 'InterfazDatos' , 'Emod\Nucleo\Herramientas' ) ;
                            }
                        }
                    }
                if ( $marca_entidad )
                    {
                    return true ;
                    }
                }
            return null ;
            }

        final private function controlEjecucionProcesos( $Ls_id_proceso , $Ls_id_gedee_proceso , $Ls_clase_gedee_proceso , $Ls_namespace_gedee_proceso )
            {
            if ( is_object( $this->EEoNucleo ) && is_object( $this->EEoSeguridad ) )
                {
                if ( !empty( $Ls_id_proceso ) && !empty( $Ls_namespace_gedee_proceso ) && !empty( $Ls_clase_gedee_proceso ) )
                    {
                    if ( $Ls_id_proceso == 'hereda' )
                        {
                        $Ls_id_proceso = $this->EEoNucleo->idProcesoEjecucion() ;
                        }
                    if ( $Ls_id_gedee_proceso == 'hereda' )
                        {
                        $Ls_id_gedee_proceso = $this->EEoNucleo->idGedeeProcesoEjecucion() ;
                        }
                    if ( $Ls_clase_gedee_proceso == 'hereda' )
                        {
                        $Ls_clase_gedee_proceso = $this->EEoNucleo->claseGedeeProcesoEjecucion() ;
                        }
                    if ( $Ls_namespace_gedee_proceso == 'hereda' )
                        {
                        $Ls_namespace_gedee_proceso = $this->EEoNucleo->namespaceGedeeProcesoEjecucion() ;
                        }
                /////////////////////////////////////////////////////////////////////////////////
                    
                    $permiso_ejecucion = null ;
                        
                    if ( ( $this->EEoNucleo->idProcesoEjecucion() == $this->EEoNucleo->idProcesoNucleo() ) && ( $this->EEoNucleo->namespaceGedeeProcesoEjecucion() == $this->EEoNucleo->namespaceGedeeProcesoNucleo()) && ( $this->EEoNucleo->claseGedeeProcesoEjecucion() == $this->EEoNucleo->claseGedeeProcesoNucleo() ) && ( $Ls_namespace_gedee_proceso == $this->EEoNucleo->namespaceGedeeProcesoNucleo() ) && ( $Ls_clase_gedee_proceso == $this->EEoNucleo->claseGedeeProcesoNucleo() ) )
                        {
                        $permiso_ejecucion = $this->EEoNucleo->permisionProcesoNucleo( $Ls_id_proceso ) ;
                        if( empty( $permiso_ejecucion ) )
                        	{
                        	trigger_error('El proceso n&uacute;ucleo de id: '.$Ls_id_proceso.' no est&aacute; permitida su ejecuci&oacute;n, seg&uacute;n configuraci&oacute;n del sistema.' , E_USER_WARNING );
                        	}
                        }
                    else
                        {
                        if( !( ( $Ls_namespace_gedee_proceso == $this->EEoNucleo->namespaceGedeeProcesoNucleo() ) && ( $Ls_clase_gedee_proceso == $this->EEoNucleo->claseGedeeProcesoNucleo() ) ) )
                        	 {
                        	 $permiso_ejecucion = $this->EEoNucleo->permisionProcesoCliente( $Ls_id_proceso , $Ls_clase_gedee_proceso , $Ls_namespace_gedee_proceso ) ;
                        	 }
                        if( empty( $permiso_ejecucion ) )
                        	 {
                        	 trigger_error('El proceso cliente de id: '.$Ls_id_proceso.' no est&aacute; permitida su ejecuci&oacute;n, seg&uacute;n configuraci&oacute;n del sistema.' , E_USER_WARNING );
                        	 }	 
                        }
                        
                    
                    if( $permiso_ejecucion == 'ejecucion' )
                        { 
                         if( ( $this->EEoNucleo->idProcesoEjecucion() != $this->EEoNucleo->idProcesoNucleo() ) || ( $this->EEoNucleo->namespaceGedeeProcesoEjecucion() != $this->EEoNucleo->namespaceGedeeProcesoNucleo() ) || ( $this->EEoNucleo->claseGedeeProcesoEjecucion() != $this->EEoNucleo->claseGedeeProcesoNucleo() ) || ( $this->EEoNucleo->idGedeeProcesoEjecucion() != $this->EEoNucleo->idGedeeProcesoNucleo() ) )    
                             {
                             	return $this->EEoSeguridad->clienteEjecucionProceso( $Ls_id_proceso , $Ls_id_gedee_proceso , $Ls_clase_gedee_proceso , $Ls_namespace_gedee_proceso  ) ;
                             }
                         return $permiso_ejecucion ;    
                        }    
                    }
                }

            return null ;
            }

        final public function cierreEjecucionProcesoActual($id_clave_ejecucion)
        	{
        		$ejecucion_proceso = null;
        		if ( empty( $id_clave_ejecucion ) )
        		{
        			return null ;
        		}
        		 
        		if ( !$this->controlEntidadesNucleo( $La_entidades = array( 'EEoNucleo' ) ) )
        		{
        			trigger_error('El control a entidades del n&uacute;cleo no se puede realizar ' , E_USER_ERROR ) ;
        		}
        		$ejecucion_proceso = $this->EEoNucleo->actualizacionFinalizacionProceso( $id_clave_ejecucion , __CLASS__.'::'.__METHOD__.'::'.__LINE__ ) ;
        		
        		return $ejecucion_proceso ;
        	}
        
        
        final public function cargaControlProcesos( $Ls_id_proceso , $Ls_id_gedee_proceso , $Ls_clase_gedee_proceso , $Ls_namespace_gedee_proceso , $La_entrada_datos_proceso )
            {
            $ejecucion_proceso = null ;

            if ( !$this->controlEntidadesNucleo() )
                {
                trigger_error('El control a entidades del n&uacute;cleo no se puede realizar ' , E_USER_ERROR ) ;
                }
            if( !empty( $La_entrada_datos_proceso['condicion_ejecucion']) )
                {
                	if (\Emod\Nucleo\Herramientas::existenciaEntidad ( '\Emod\Nucleo\Herramientas' , 'ESentenciasDeControl' , 'ESentenciasDeControl' ))
                		{
                			\Emod\Nucleo\Herramientas::entidad ( '\Emod\Nucleo\Herramientas' , 'ESentenciasDeControl' , 'ESentenciasDeControl' );
                		}
                	if(	!(\Emod\Nucleo\Herramientas\ESentenciasDeControl::sentenciaIf( $La_entrada_datos_proceso['condicion_ejecucion'] ) ) )
                		{
                			return $ejecucion_proceso ;
                		}
                }

            if ( !empty( $Ls_id_proceso ) && !empty( $Ls_namespace_gedee_proceso ) && !empty( $Ls_clase_gedee_proceso ) && is_array( $La_entrada_datos_proceso ) && !empty( $La_entrada_datos_proceso[ 'path_raiz' ] ) && !empty( $La_entrada_datos_proceso[ 'path_arranque' ] ) && is_file( $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/'.$this->EEoNucleo->pathDirRaizProcesos().'/'.$La_entrada_datos_proceso[ 'path_raiz' ].'/'.$La_entrada_datos_proceso[ 'path_arranque' ] ) )
                {
                if ( $Ls_id_proceso == 'hereda' )
                    {
                    $Ls_id_proceso = $this->EEoNucleo->idProcesoEjecucion() ;
                    }
                if ( $Ls_id_gedee_proceso == 'hereda' )
                    {
                    $Ls_id_gedee_proceso = $this->EEoNucleo->idGedeeProcesoEjecucion() ;
                    }
                if ( $Ls_clase_gedee_proceso == 'hereda' )
                    {
                    $Ls_clase_gedee_proceso = $this->EEoNucleo->claseGedeeProcesoEjecucion() ;
                    }
                if ( $Ls_namespace_gedee_proceso == 'hereda' )
                    {
                    $Ls_namespace_gedee_proceso = $this->EEoNucleo->namespaceGedeeProcesoEjecucion() ;
                    }
                    
                $permiso_ejecucion = $this->controlEjecucionProcesos( $Ls_id_proceso , $Ls_id_gedee_proceso , $Ls_clase_gedee_proceso , $Ls_namespace_gedee_proceso ) ; 
                
                if ( $permiso_ejecucion == 'ejecucion' )
                    {
                    $id_clave_ejecucion = $this->EEoNucleo->actualizacionComienzoProceso( $Ls_id_proceso , $La_entrada_datos_proceso[ 'path_raiz' ] , $Ls_id_gedee_proceso , $Ls_namespace_gedee_proceso , $Ls_clase_gedee_proceso , __CLASS__.'::'.__METHOD__.'::'.__LINE__ ) ;
                    if ( empty( $id_clave_ejecucion ) )
                        {
                        return null ;
                        }
                        
                    $this->statu_ejecucion_proceso = null ;

                    if ( empty( $La_entrada_datos_proceso [ 'obligatoriedad' ] ) )
                        {
                        $La_entrada_datos_proceso [ 'obligatoriedad' ] = 4 ;
                        }

                    switch ( $La_entrada_datos_proceso [ 'obligatoriedad' ] )
                        {
                        case 1 : require_once ( $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/'.$this->EEoNucleo->pathDirRaizProcesos().'/'.$La_entrada_datos_proceso[ 'path_raiz' ].'/'.$La_entrada_datos_proceso[ 'path_arranque' ] ) ;
                            break ;

                        case 2 : require ( $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/'.$this->EEoNucleo->pathDirRaizProcesos().'/'.$La_entrada_datos_proceso[ 'path_raiz' ].'/'.$La_entrada_datos_proceso[ 'path_arranque' ] ) ;
                            break ;

                        case 3 : include_once ( $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/'.$this->EEoNucleo->pathDirRaizProcesos().'/'.$La_entrada_datos_proceso[ 'path_raiz' ].'/'.$La_entrada_datos_proceso[ 'path_arranque' ] ) ;
                            break ;

                        case 4 : include ( $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/'.$this->EEoNucleo->pathDirRaizProcesos().'/'.$La_entrada_datos_proceso[ 'path_raiz' ].'/'.$La_entrada_datos_proceso[ 'path_arranque' ] ) ;
                            break ;

                        case 5 : eval( $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/'.$this->EEoNucleo->pathDirRaizProcesos().'/'.$La_entrada_datos_proceso[ 'path_raiz' ].'/'.$La_entrada_datos_proceso[ 'path_arranque' ] ) ;
                            break ;
                        }
                        
                        if ( !$this->controlEntidadesNucleo( $La_entidades = array( 'EEoNucleo' ) ) )
                        {
                        	trigger_error('El control a entidades del n&uacute;cleo no se puede realizar ' , E_USER_ERROR ) ;
                        }
                        $ejecucion_proceso = $this->EEoNucleo->actualizacionFinalizacionProceso( $id_clave_ejecucion , __CLASS__.'::'.__METHOD__.'::'.__LINE__ ) ;
                        
                    }
                }
            return $ejecucion_proceso ;
            }
		
            final public function ejecutarBloqueProcesos( $La_bloque_procesos )
            	{
            		if ( !empty( $La_bloque_procesos ) && is_array( $La_bloque_procesos ) )
            		{
            			$ejecucion_proceso = NULL ;
            			foreach ( $La_bloque_procesos['procesos'] as $id_proceso => $valores_proceso )
            			{
            				if ( !empty( $valores_proceso ) && is_array( $valores_proceso ) )
            				{
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
            
            
            				if ( !empty( $valores_proceso['propiedades_implementacion_proceso']['condicion_ejecucion'] ) )
            					{
            					$continue  = true;
            					$condicion = 'if( ' . $valores_proceso['propiedades_implementacion_proceso']['condicion_ejecucion'] . ' )
												{
													$continue = false ;
												}';
            					eval( $condicion );
            
            					if ( $continue == true )
            						{
            						continue;
            						}
            					}
            				$ejecucion_proceso = $this->cargaControlProcesos( $id_proceso , $Ls_id_gedee_proceso_ejecucion , $Ls_clase_gedee_proceso_ejecucion , $Ls_namespace_gedee_proceso_ejecucion , $valores_proceso['propiedades_implementacion_proceso'] );
            				if ( !$ejecucion_proceso )
            					{
            					trigger_error('El proceso: '.$id_proceso.', de id gedee: '.$Ls_id_gedee_proceso_ejecucion.', clase gedee: '.$Ls_namespace_gedee_proceso_ejecucion.'\\'.$Ls_clase_gedee_proceso_ejecucion.' no se pudo ejecutar satisfact&oacute;riamente en '.__CLASS__ , E_USER_WARNING ) ;
            					}
            
            				}
            			}
            
            		return $ejecucion_proceso ;
            		}
            
            	trigger_error("El bloque de procesos no tiene valores o el tipo asociado a este dato en __METHOD__" , E_USER_ERROR ) ;
           	 	}
        
           	 final public function ejecutarProcesoBloque( $Ls_id_proceso_ejecutar , $La_bloque_procesos )
           	 	{
           	 		if ( !empty( $La_bloque_procesos ) && is_array( $La_bloque_procesos ) && !empty( $Ls_id_proceso_ejecutar ) )
           	 			{
           	 			$ejecucion_proceso = NULL ;
           	 			foreach ( $La_bloque_procesos['procesos'] as $id_proceso => $valores_proceso )
           	 				{
           	 				if ( ($id_proceso == $Ls_id_proceso_ejecutar ) && !empty( $valores_proceso ) && is_array( $valores_proceso ) )
           	 					{
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
           	 	
           	 	
           	 					if ( !empty( $valores_proceso['propiedades_implementacion_proceso']['condicion_ejecucion'] ) )
           	 						{
           	 						$continue  = true;
           	 						$condicion = 'if( ' . $valores_proceso['propiedades_implementacion_proceso']['condicion_ejecucion'] . ' )
													{
														$continue = false ;
													}' ;
           	 						eval( $condicion );
           	 	
           	 						if ( $continue == true )
           	 							{
           	 							continue;
           	 							}
           	 						}
           	 					$ejecucion_proceso = $this->cargaControlProcesos( $id_proceso , $Ls_id_gedee_proceso_ejecucion , $Ls_clase_gedee_proceso_ejecucion , $Ls_namespace_gedee_proceso_ejecucion , $valores_proceso['propiedades_implementacion_proceso'] );
           	 					if ( !$ejecucion_proceso )
           	 						{
           	 						trigger_error('El proceso: '.$id_proceso.', de id gedee: '.$Ls_id_gedee_proceso_ejecucion.', clase gedee: '.$Ls_namespace_gedee_proceso_ejecucion.'\\'.$Ls_clase_gedee_proceso_ejecucion.' no se pudo ejecutar satisfact&oacute;riamente en '.__CLASS__ , E_USER_WARNING ) ;
           	 						}
           	 	
           	 					}
           	 				}
           	 	
           	 			return $ejecucion_proceso ;
           	 			}
           	 	
           	 		trigger_error("El bloque de procesos o el id del proceso a ejecutar, no tienen valores o el tipo asociado a estos datos " , E_USER_ERROR ) ;
           	 	}
           	 	
        }

        
?>