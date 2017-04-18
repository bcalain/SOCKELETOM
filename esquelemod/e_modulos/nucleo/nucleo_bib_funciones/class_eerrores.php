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
   * EErrores class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

    namespace Emod\Nucleo\Errores ; 
    
    class EErrores
        {
            use \Emod\Nucleo\DependenciasEntidadesEmod ;
            
            private $lbIniciacion = null ;
            private $liTiposError = null ;
            private $GEDEGEDefecto = null ;
            private $lsTipoEntidadGEDEGEDefecto = null ;
            private $lsIdGestorErrores = null ;
            private $lsFuncionGestorErrores = null ; 
            private $laMatrizElementosError = null ;
            private $laFuenteDatosError = null ;
            private $laFormatoFiltrado = null ;
            private $laFormatoMensajeError = null ;
            private $laFormatoMensajeErrorlog = null ;
            
            public function __construct ( $La_gedege_emod , $La_funcion_gestor_errores , $La_matriz_elementos_error , $La_formato_mensaje , $La_fuente_datos_error , $La_formato_filtrado , $Li_tipos_error = null )
                {
                    
                     if ( !empty( $La_gedege_emod ) && is_array( $La_gedege_emod ) && ( empty( $La_gedege_emod['namespace'] ) || empty( $La_gedege_emod['clase'] ) || empty( $La_gedege_emod['id_entidad'] ) ) )
                        {
                            $this->cargarObjetosDependencia( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ;
                            
                            reset( $La_gedege_emod ) ;
                            $namespace1 = key( $La_gedege_emod ) ;
                            reset( $La_gedege_emod[$namespace1] ) ;
                            $clase1 = key( $La_gedege_emod[$namespace1] ) ;
                            reset( $La_gedege_emod[$namespace1][$clase1]['instancias'] ) ;
                            $id_entidad1 = key( $La_gedege_emod[$namespace1][$clase1]['instancias'] ) ;
                            
                            $La_gedege_emod = null ;
                            
                            $La_gedege_emod['namespace'] = $namespace1 ;
                            $La_gedege_emod['clase'] = $clase1 ;
                            $La_gedege_emod['id_entidad'] = $id_entidad1 ;
                        }             
                    if ( empty( $this->lbIniciacion ) && !empty( $La_gedege_emod['namespace'] ) && !empty( $La_gedege_emod['clase'] ) && !empty( $La_gedege_emod['id_entidad'] ) && !empty( $La_funcion_gestor_errores['identificador'] ) && !empty( $La_funcion_gestor_errores['nombre_funcion'] ) && !empty( $La_matriz_elementos_error['miembros_errorlog'] ) && !empty( $La_matriz_elementos_error['miembros_error'] ) && !empty( $La_formato_mensaje['formato_mensaje_error'] ) && is_array( $La_formato_mensaje['formato_mensaje_error'] ) && !empty( $La_formato_mensaje['formato_mensaje_errorlog'] ) && is_array( $La_formato_mensaje['formato_mensaje_errorlog'] ) && !empty( $La_fuente_datos_error ) && is_array( $La_fuente_datos_error ) && !empty( $La_formato_filtrado ) && is_array( $La_formato_filtrado ) )
                        {
                            $iniciacion = false ;
                            $this->lsTipoEntidadGEDEGEDefecto = \Emod\Nucleo\Errores::existenciaEntidad( $La_gedege_emod['namespace'] , $La_gedege_emod['clase'] , $La_gedege_emod['id_entidad'] ) ;
                            if ( $this->lsTipoEntidadGEDEGEDefecto )
                               {
                                   $this->GEDEGEDefecto = \Emod\Nucleo\Errores::entidad( $La_gedege_emod['namespace'] , $La_gedege_emod['clase'] , $La_gedege_emod['id_entidad'] ) ;
                                   $iniciacion = true ;  
                               }
                               
                            $this->lsIdGestorErrores = $La_funcion_gestor_errores['identificador'] ;
                            
                            if( !method_exists( $this , $La_funcion_gestor_errores['nombre_funcion'] ) )
                                {
                                die ( 'ERROR, La funcion gestor de errores no exite '.__METHOD__.' linea '.__LINE__) ;
                                }
                            
                            $this->lsFuncionGestorErrores = $La_funcion_gestor_errores['nombre_funcion'] ;
                            
                            $this->laMatrizElementosError = $La_matriz_elementos_error ;
                            
                            foreach ( $La_matriz_elementos_error['miembros_error'] as $valor_miembros_error )
                                {
                                    foreach ( $La_formato_mensaje['formato_mensaje_error'] as $valor_mensaje )
                                        {
                                            if ( $valor_mensaje == $valor_miembros_error )
                                                   {
                                                       $this->laFormatoMensajeError[] = $valor_mensaje ;
                                                       break ;
                                                   }
                                                   
                                        }
                                }
                               
                            if ( empty( $this->laFormatoMensajeError ) )
                                {
                                    $iniciacion = false ;
                                }
                                
                            $this->laFormatoMensajeErrorlog = $La_formato_mensaje['formato_mensaje_errorlog'] ;
                               
                            /////////////////////////////////////////////////////////////////////////////////////
                            if ( empty( $La_fuente_datos_error['referencia_path_error'] ) || ( ( $La_fuente_datos_error['referencia_path_error'] != 'relativo' ) && ( $La_fuente_datos_error['referencia_path_error'] != 'relativo_esquelemod' ) && ( $La_fuente_datos_error['referencia_path_error'] != 'absoluto' ) ) ){ $La_fuente_datos_error['referencia_path_error'] = 'relativo' ; }
                            if ( empty( $La_fuente_datos_error['referencia_path_errorlog'] ) || ( ( $La_fuente_datos_error['referencia_path_errorlog'] != 'relativo' ) && ( $La_fuente_datos_error['referencia_path_errorlog'] != 'relativo_esquelemod' ) && ( $La_fuente_datos_error['referencia_path_errorlog'] != 'absoluto' ) ) ){ $La_fuente_datos_error['referencia_path_errorlog'] = 'relativo' ; }
                            
                            if ( $La_fuente_datos_error['referencia_path_error'] == 'relativo' )
                                {
                                 $La_fuente_datos_error['path_fich_error'] = $this->EEoNucleo->pathDirEsquelemod() . '/e_modulos/' . \Emod\Nucleo\Errores::pathRaizEntidades() . '/' . $La_fuente_datos_error['path_fich_error'] ;
                                }
                            elseif ( $La_fuente_datos_error['referencia_path_error'] == 'relativo_esquelemod' )
                                {
                                 $La_fuente_datos_error['path_fich_error'] = $this->EEoNucleo->pathDirEsquelemod() . '/' . $La_fuente_datos_error['path_fich_error'] ;
                                }
                                
                            if ( $La_fuente_datos_error['referencia_path_errorlog'] == 'relativo' )
                                {
                                 $La_fuente_datos_error['path_fich_errorlog'] = $this->EEoNucleo->pathDirEsquelemod() . '/e_modulos/' . \Emod\Nucleo\Errores::pathRaizEntidades() . '/' . $La_fuente_datos_error['path_fich_errorlog'] ;
                                }
                            elseif ( $La_fuente_datos_error['referencia_path_errorlog'] == 'relativo_esquelemod' )
                                {
                                 $La_fuente_datos_error['path_fich_errorlog'] = $this->EEoNucleo->pathDirEsquelemod() . '/' . $La_fuente_datos_error['path_fich_errorlog'] ;
                                }     
                                                       
                            $this->laFuenteDatosError = $La_fuente_datos_error ;
                            
                            $this->laFormatoFiltrado = $La_formato_filtrado ;
                            
                             if ( !empty( $Li_tipos_error ) )
                                {
                                    $this->liTiposError = $Li_tipos_error ;
                                }
                               
                             if ( !empty( $iniciacion ) )
                                {
                                    $this->lbIniciacion = true ;  
                                    return true ;
                                }    
                        }
                        
                    die ( 'ERROR, existen parametros incompatibles con la gestion de instanciacion de esta clase Emod\Nucleo\Errores\EErrores.' ) ;
                }
            
            public function gestorErroresEmod( $errno, $errstr )
                {
                    if ( !( error_reporting() & $errno ) ) {
                    // Este código de error no está incluido en error_reporting
                    return null ;
                }
                    $parametros_backtrace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS , 3 ) ;
                    
                    switch ( $errno )
                        {
                            case E_USER_ERROR:
                                                echo "<p><b>ERROR</b>:$errstr ";
                                                echo "línea ". $parametros_backtrace[2]['line']." fichero ". $parametros_backtrace[2]['file'].'<p>' ;
                                                exit ;
                                                break ;

                            case E_USER_WARNING:
                                                echo "<p><b>WARNING</b>:$errstr ";
                                                echo "línea ". $parametros_backtrace[2]['line']." fichero ". $parametros_backtrace[2]['file'].'<p>' ;
                                                break ;

                            case E_USER_NOTICE:
                                                echo "<p><b>NOTICE</b>:$errstr ";
                                                echo "línea ". $parametros_backtrace[2]['line']." fichero ". $parametros_backtrace[2]['file'].'<p>' ;
                                                break ;

                            default:
                                                echo "<p>Tipo de error desconocido:$errstr ";
                                                echo "línea ". $parametros_backtrace[2]['line']." fichero ". $parametros_backtrace[2]['file'].'<p>' ;
                                                break ;
                        }

                        return true ;
                }

                
            protected function implementarProcedimientosEntidades(  $Ls_nombre_funcion , &$La_parametros = null )
            { 
            if ( !empty( $this->lbIniciacion ) && !empty( $Ls_nombre_funcion ) )
                {
                $resultado = null ;                        
                
                $cantidad_parametros = null ;
                if ( is_array( $La_parametros ) && !empty( $La_parametros ) )
                    {
                        $cantidad_parametros = count( $La_parametros ) ;
                    }
                
                if ( $cantidad_parametros )
                    {

                    if ( ( $this->lsTipoEntidadGEDEGEDefecto == 'objeto' ) && is_object( $this->GEDEGEDefecto ) )
                        {
                            $sentencia = ' $resultado = $this->GEDEGEDefecto->' . $Ls_nombre_funcion . '( ' ;   
                        }
                    elseif ( ( $this->lsTipoEntidadGEDEGEDefecto == 'clase' ) && is_string( $this->GEDEGEDefecto ) )
                        {
                            $sentencia = ' $resultado = $this->GEDEGEDefecto::' . $Ls_nombre_funcion . '( ' ;   
                        }
                    else
                        {
                            exit( "<p> ERROR FATAL, no se puede implementar la funcion $Ls_nombre_funcion en  " . __METHOD__.__LINE__ ) ;
                        }


                    for ( $i = 0 ; $i < $cantidad_parametros ; $i++ )
                        {
                        if ( $i == ( $cantidad_parametros - 1 ) )
                            {
                                $sentencia.= "\$La_parametros[$i] );" ;
                            }
                        else
                            {
                                $sentencia.= "\$La_parametros[$i] , " ;
                            }
                        }
                    }
                else
                    {
                    if ( ( $this->lsTipoEntidadGEDEGEDefecto == 'objeto' ) && is_object( $this->GEDEGEDefecto ) )
                        {
                            $sentencia = ' $resultado = $this->GEDEGEDefecto->' . $Ls_nombre_funcion . '() ' ;   
                        }
                    elseif ( ( $this->lsTipoEntidadGEDEGEDefecto == 'clase' ) && is_string( $this->GEDEGEDefecto ) )
                        {
                            $sentencia = ' $resultado = $this->GEDEGEDefecto::' . $Ls_nombre_funcion . '() ' ;   
                        }
                    else
                        {
                            exit( "<p> ERROR FATAL, no se puede implementar la funcion $Ls_nombre_funcion en  " . __METHOD__.__LINE__ ) ;
                        }
                    }

                echo '<p>' . $sentencia . ' en ' . __METHOD__ . ' linea ' . __LINE__ . '<p>' ;
                
                eval( $sentencia ) ;

                return $resultado ;
                }

            exit( "<p> ERROR FATAL, no se puede implementar la funcion $Ls_nombre_funcion en  " . __METHOD__.__LINE__ ) ;
            }
            
            public function filtrarDatosError()
	    {
	            if ( !empty( $this->lbIniciacion ) )
                    {
                        $La_parametros = func_get_args();
                        
                        if ( !empty ( $La_parametros ) && is_array( $La_parametros ) )
                            {
                                 $ultimo_parametro = end( $La_parametros ) ;
                                 $La_arreglo_intercambio = array() ;
                                 
                                 if ( !empty( $ultimo_parametro['formato'] ) || !empty( $ultimo_parametro['filtrado'] ) )
                                     {
                                         if ( isset( $ultimo_parametro['formato'] ) && !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = array_merge( $ultimo_parametro['formato'] , $this->laFormatoFiltrado['formato'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $ultimo_parametro['formato'] ;
                                             }
                                         elseif ( !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $this->laFormatoFiltrado['formato'] ;
                                             }
                                         
                                         if ( isset( $ultimo_parametro['filtrado'] ) && !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = array_merge( $ultimo_parametro['filtrado'] , $this->laFormatoFiltrado['filtrado'] );
                                             }
                                         elseif ( isset( $ultimo_parametro['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $ultimo_parametro['filtrado'] ;
                                             }    
                                         elseif ( !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $this->laFormatoFiltrado['filtrado'] ;
                                             }
                                             
                                         if ( !empty ( $La_arreglo_intercambio ) )
                                             {
                                                 $ultimo_parametro = $La_arreglo_intercambio ;
                                             }
                                        reset( $La_parametros ) ;     
 
                                     }
                                 elseif ( !empty( $this->laFormatoFiltrado ) )
                                    {
                                         $La_parametros[] = $this->laFormatoFiltrado ;
                                    }
                            }
                        elseif ( !empty( $this->laFormatoFiltrado ) )
                            {
                                 $La_parametros[] = $this->laFormatoFiltrado ;
                            }
                            
                        if ( !empty( $this->laMatrizElementosError ) )
                            {
                                $La_parametros[] = $this->laMatrizElementosError ;
                            }
                        
				            
                        return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros ) ;
                    }
            }
            
            public function crearDatosError()
	    {
	            if ( !empty( $this->lbIniciacion ) )
                    {
                        $La_parametros = func_get_args();
                        
                        if ( !empty ( $La_parametros ) && is_array( $La_parametros ) )
                            {
                                 $ultimo_parametro = end( $La_parametros ) ;
                                 $La_arreglo_intercambio = array() ;
                                 
                                 if ( !empty( $ultimo_parametro['formato'] ) || !empty( $ultimo_parametro['filtrado'] ) )
                                     {
                                         if ( isset( $ultimo_parametro['formato'] ) && !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = array_merge( $ultimo_parametro['formato'] , $this->laFormatoFiltrado['formato'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $ultimo_parametro['formato'] ;
                                             }
                                         elseif ( !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $this->laFormatoFiltrado['formato'] ;
                                             }
                                         
                                         if ( isset( $ultimo_parametro['filtrado'] ) && !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = array_merge( $ultimo_parametro['filtrado'] , $this->laFormatoFiltrado['filtrado'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $ultimo_parametro['filtrado'] ;
                                             }    
                                         elseif ( !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $this->laFormatoFiltrado['filtrado'] ;
                                             }
                                             
                                         if ( !empty ( $La_arreglo_intercambio ) )
                                             {
                                                 $ultimo_parametro = $La_arreglo_intercambio ;
                                             }
                                        reset( $La_parametros ) ;     
 
                                     }
                                 elseif ( !empty( $this->laFormatoFiltrado ) )
                                    {
                                         $La_parametros[] = $this->laFormatoFiltrado ;
                                    }
                            }
                        elseif ( !empty( $this->laFormatoFiltrado ) )
                            {
                                 $La_parametros[] = $this->laFormatoFiltrado ;
                            }
                            
                        if ( !empty( $this->laMatrizElementosError ) )
                            {
                                $La_parametros[] = $this->laMatrizElementosError ;
                            }
                        if ( !empty( $this->laFuenteDatosError ) )
                            {
                                $La_parametros[] = $this->laFuenteDatosError ;
                            }
                            
                        return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros ) ;
                    }
            }
            
            public function eliminarDatosError()
	    {
	            if ( !empty( $this->lbIniciacion ) )
                    {
                        $La_parametros = func_get_args();
                        
                        if ( !empty ( $La_parametros ) && is_array( $La_parametros ) )
                            {
                                 $ultimo_parametro = end( $La_parametros ) ;
                                 $La_arreglo_intercambio = array() ;
                                 
                                 if ( !empty( $ultimo_parametro['formato'] ) || !empty( $ultimo_parametro['filtrado'] ) )
                                     {
                                         if ( isset( $ultimo_parametro['formato'] ) && !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = array_merge( $ultimo_parametro['formato'] , $this->laFormatoFiltrado['formato'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $ultimo_parametro['formato'] ;
                                             }
                                         elseif ( !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $this->laFormatoFiltrado['formato'] ;
                                             }
                                         
                                         if ( isset( $ultimo_parametro['filtrado'] ) && !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = array_merge( $ultimo_parametro['filtrado'] , $this->laFormatoFiltrado['filtrado'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $ultimo_parametro['filtrado'] ;
                                             }    
                                         elseif ( !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $this->laFormatoFiltrado['filtrado'] ;
                                             }
                                             
                                         if ( !empty ( $La_arreglo_intercambio ) )
                                             {
                                                 $ultimo_parametro = $La_arreglo_intercambio ;
                                             }
                                        reset( $La_parametros ) ;     
 
                                     }
                                 elseif ( !empty( $this->laFormatoFiltrado ) )
                                    {
                                         $La_parametros[] = $this->laFormatoFiltrado ;
                                    }
                            }
                        elseif ( !empty( $this->laFormatoFiltrado ) )
                            {
                                 $La_parametros[] = $this->laFormatoFiltrado ;
                            }
                            
                        if ( !empty( $this->laMatrizElementosError ) )
                            {
                                $La_parametros[] = $this->laMatrizElementosError ;
                            }
                        if ( !empty( $this->laFuenteDatosError ) )
                            {
                                $La_parametros[] = $this->laFuenteDatosError ;
                            }
                            
                        return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros ) ;
                    } 
            }
            
            public function leerDatosError()
	    {
	            if ( !empty( $this->lbIniciacion ) )
                    {
                        $La_parametros = func_get_args();
                        
                        if ( !empty ( $La_parametros ) && is_array( $La_parametros ) )
                            {
                                 $ultimo_parametro = end( $La_parametros ) ;
                                 $La_arreglo_intercambio = array() ;
                                 
                                 if ( !empty( $ultimo_parametro['formato'] ) || !empty( $ultimo_parametro['filtrado'] ) )
                                     {
                                         if ( isset( $ultimo_parametro['formato'] ) && !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = array_merge( $ultimo_parametro['formato'] , $this->laFormatoFiltrado['formato'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $ultimo_parametro['formato'] ;
                                             }
                                         elseif ( !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $this->laFormatoFiltrado['formato'] ;
                                             }
                                         
                                         if ( isset( $ultimo_parametro['filtrado'] ) && !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = array_merge( $ultimo_parametro['filtrado'] , $this->laFormatoFiltrado['filtrado'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $ultimo_parametro['filtrado'] ;
                                             }    
                                         elseif ( !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $this->laFormatoFiltrado['filtrado'] ;
                                             }
                                             
                                         if ( !empty ( $La_arreglo_intercambio ) )
                                             {
                                                 $ultimo_parametro = $La_arreglo_intercambio ;
                                             }
                                        reset( $La_parametros ) ;     
 
                                     }
                                 elseif ( !empty( $this->laFormatoFiltrado ) )
                                    {
                                         $La_parametros[] = $this->laFormatoFiltrado ;
                                    }
                            }
                        elseif ( !empty( $this->laFormatoFiltrado ) )
                            {
                                 $La_parametros[] = $this->laFormatoFiltrado ;
                            }
                            
                        if ( !empty( $this->laMatrizElementosError ) )
                            {
                                $La_parametros[] = $this->laMatrizElementosError ;
                            }
                        if ( !empty( $this->laFuenteDatosError ) )
                            {
                                $La_parametros[] = $this->laFuenteDatosError ;
                            }
                            
			return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros ) ;
                    } 
            }
         
            public function modificarDatosError()
	    {
	            if ( !empty( $this->lbIniciacion ) )
                    {
                        $La_parametros = func_get_args();
                        
                        if ( !empty ( $La_parametros ) && is_array( $La_parametros ) )
                            {
                                 $ultimo_parametro = end( $La_parametros ) ;
                                 $La_arreglo_intercambio = array() ;
                                 
                                 if ( !empty( $ultimo_parametro['formato'] ) || !empty( $ultimo_parametro['filtrado'] ) )
                                     {
                                         if ( isset( $ultimo_parametro['formato'] ) && !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = array_merge( $ultimo_parametro['formato'] , $this->laFormatoFiltrado['formato'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $ultimo_parametro['formato'] ;
                                             }
                                         elseif ( !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $this->laFormatoFiltrado['formato'] ;
                                             }
                                         
                                         if ( isset( $ultimo_parametro['filtrado'] ) && !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = array_merge( $ultimo_parametro['filtrado'] , $this->laFormatoFiltrado['filtrado'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $ultimo_parametro['filtrado'] ;
                                             }    
                                         elseif ( !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $this->laFormatoFiltrado['filtrado'] ;
                                             }
                                             
                                         if ( !empty ( $La_arreglo_intercambio ) )
                                             {
                                                 $ultimo_parametro = $La_arreglo_intercambio ;
                                             }
                                        reset( $La_parametros ) ;     
 
                                     }
                                 elseif ( !empty( $this->laFormatoFiltrado ) )
                                    {
                                         $La_parametros[] = $this->laFormatoFiltrado ;
                                    }
                            }
                        elseif ( !empty( $this->laFormatoFiltrado ) )
                            {
                                 $La_parametros[] = $this->laFormatoFiltrado ;
                            }
                            
                        if ( !empty( $this->laMatrizElementosError ) )
                            {
                                $La_parametros[] = $this->laMatrizElementosError ;
                            }
                        if ( !empty( $this->laFuenteDatosError ) )
                            {
                                $La_parametros[] = $this->laFuenteDatosError ;
                            }
                            
				        return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros ) ;
                    } 
            }
            
            
	    public function crearFuenteDatosError()
	    {
	            if ( !empty( $this->lbIniciacion ) )
                    {
                        $La_parametros = func_get_args();
                        				            
                        return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros ) ;
                    }
            }
            
            public function eliminarFuenteDatosError()
	    {
	            if ( !empty( $this->lbIniciacion ) )
                    {
                        $La_parametros = func_get_args();
                        if ( !empty( $this->laFuenteDatosError ) )
                            {
                                $La_parametros[] = $this->laFuenteDatosError ;
                            }
                        
                        return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros ) ;
                    } 
            }
            
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            
            public function filtrarDatosErrorlog()
	    {
	            if ( !empty( $this->lbIniciacion ) )
                    {
                        $La_parametros = func_get_args();
                        
                        if ( !empty ( $La_parametros ) && is_array( $La_parametros ) )
                            {
                                 $ultimo_parametro = end( $La_parametros ) ;
                                 $La_arreglo_intercambio = array() ;
                                 
                                 if ( !empty( $ultimo_parametro['formato'] ) || !empty( $ultimo_parametro['filtrado'] ) )
                                     {
                                         if ( isset( $ultimo_parametro['formato'] ) && !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = array_merge( $ultimo_parametro['formato'] , $this->laFormatoFiltrado['formato'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $ultimo_parametro['formato'] ;
                                             }
                                         elseif ( !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $this->laFormatoFiltrado['formato'] ;
                                             }
                                         
                                         if ( isset( $ultimo_parametro['filtrado'] ) && !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = array_merge( $ultimo_parametro['filtrado'] , $this->laFormatoFiltrado['filtrado'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $ultimo_parametro['filtrado'] ;
                                             }    
                                         elseif ( !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $this->laFormatoFiltrado['filtrado'] ;
                                             }
                                             
                                         if ( !empty ( $La_arreglo_intercambio ) )
                                             {
                                                 $ultimo_parametro = $La_arreglo_intercambio ;
                                             }
                                        reset( $La_parametros ) ;     
 
                                     }
                                 elseif ( !empty( $this->laFormatoFiltrado ) )
                                    {
                                         $La_parametros[] = $this->laFormatoFiltrado ;
                                    }
                            }
                        elseif ( !empty( $this->laFormatoFiltrado ) )
                            {
                                 $La_parametros[] = $this->laFormatoFiltrado ;
                            }
                            
                        if ( !empty( $this->laMatrizElementosError ) )
                            {
                                $La_parametros[] = $this->laMatrizElementosError ;
                            }
                            
                        return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros ) ;
                    }   
            }
          

            public function crearDatosErrorLog()
	    {
	            if ( !empty( $this->lbIniciacion ) )
                    {
                        $La_parametros = func_get_args();
                        
                        if ( !empty ( $La_parametros ) && is_array( $La_parametros ) )
                            {
                                 $ultimo_parametro = end( $La_parametros ) ;
                                 $La_arreglo_intercambio = array() ;
                                 
                                 if ( !empty( $ultimo_parametro['formato'] ) || !empty( $ultimo_parametro['filtrado'] ) )
                                     {
                                         if ( isset( $ultimo_parametro['formato'] ) && !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = array_merge( $ultimo_parametro['formato'] , $this->laFormatoFiltrado['formato'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $ultimo_parametro['formato'] ;
                                             }
                                         elseif ( !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $this->laFormatoFiltrado['formato'] ;
                                             }
                                         
                                         if ( isset( $ultimo_parametro['filtrado'] ) && !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = array_merge( $ultimo_parametro['filtrado'] , $this->laFormatoFiltrado['filtrado'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $ultimo_parametro['filtrado'] ;
                                             }    
                                         elseif ( !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $this->laFormatoFiltrado['filtrado'] ;
                                             }
                                             
                                         if ( !empty ( $La_arreglo_intercambio ) )
                                             {
                                                 $ultimo_parametro = $La_arreglo_intercambio ;
                                             }
                                        reset( $La_parametros ) ;     
 
                                     }
                                 elseif ( !empty( $this->laFormatoFiltrado ) )
                                    {
                                         $La_parametros[] = $this->laFormatoFiltrado ;
                                    }
                            }
                        elseif ( !empty( $this->laFormatoFiltrado ) )
                            {
                                 $La_parametros[] = $this->laFormatoFiltrado ;
                            }
                            
                        if ( !empty( $this->laMatrizElementosError ) )
                            {
                                $La_parametros[] = $this->laMatrizElementosError ;
                            }
                        if ( !empty( $this->laFuenteDatosError ) )
                            {
                                $La_parametros[] = $this->laFuenteDatosError ;
                            }
                            
			return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros ) ;
                    }
                return null ;    
            }
     
            public function eliminarDatosErrorLog()
	    {
	            if ( !empty( $this->lbIniciacion ) )
                    {
                        $La_parametros = func_get_args();
                        
                        if ( !empty ( $La_parametros ) && is_array( $La_parametros ) )
                            {
                                 $ultimo_parametro = end( $La_parametros ) ;
                                 $La_arreglo_intercambio = array() ;
                                 
                                 if ( !empty( $ultimo_parametro['formato'] ) || !empty( $ultimo_parametro['filtrado'] ) )
                                     {
                                         if ( isset( $ultimo_parametro['formato'] ) && !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = array_merge( $ultimo_parametro['formato'] , $this->laFormatoFiltrado['formato'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $ultimo_parametro['formato'] ;
                                             }
                                         elseif ( !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $this->laFormatoFiltrado['formato'] ;
                                             }
                                         
                                         if ( isset( $ultimo_parametro['filtrado'] ) && !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = array_merge( $ultimo_parametro['filtrado'] , $this->laFormatoFiltrado['filtrado'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $ultimo_parametro['filtrado'] ;
                                             }    
                                         elseif ( !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $this->laFormatoFiltrado['filtrado'] ;
                                             }
                                             
                                         if ( !empty ( $La_arreglo_intercambio ) )
                                             {
                                                 $ultimo_parametro = $La_arreglo_intercambio ;
                                             }
                                        reset( $La_parametros ) ;     
 
                                     }
                                 elseif ( !empty( $this->laFormatoFiltrado ) )
                                    {
                                         $La_parametros[] = $this->laFormatoFiltrado ;
                                    }
                            }
                        elseif ( !empty( $this->laFormatoFiltrado ) )
                            {
                                 $La_parametros[] = $this->laFormatoFiltrado ;
                            }
                            
                        if ( !empty( $this->laMatrizElementosError ) )
                            {
                                $La_parametros[] = $this->laMatrizElementosError ;
                            }
                        if ( !empty( $this->laFuenteDatosError ) )
                            {
                                $La_parametros[] = $this->laFuenteDatosError ;
                            }
                            
			return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros ) ;
                    }
                return null ;    
            }
     
            
	   public function leerDatosErrorLog()
	   {
	            if ( !empty( $this->lbIniciacion ) )
                    {
                        $La_parametros = func_get_args();
                        
                        if ( !empty ( $La_parametros ) && is_array( $La_parametros ) )
                            {
                                 $ultimo_parametro = end( $La_parametros ) ;
                                 $La_arreglo_intercambio = array() ;
                                 
                                 if ( !empty( $ultimo_parametro['formato'] ) || !empty( $ultimo_parametro['filtrado'] ) )
                                     {
                                         if ( isset( $ultimo_parametro['formato'] ) && !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = array_merge( $ultimo_parametro['formato'] , $this->laFormatoFiltrado['formato'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $ultimo_parametro['formato'] ;
                                             }
                                         elseif ( !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $this->laFormatoFiltrado['formato'] ;
                                             }
                                         
                                         if ( isset( $ultimo_parametro['filtrado'] ) && !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = array_merge( $ultimo_parametro['filtrado'] , $this->laFormatoFiltrado['filtrado'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $ultimo_parametro['filtrado'] ;
                                             }    
                                         elseif ( !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $this->laFormatoFiltrado['filtrado'] ;
                                             }
                                             
                                         if ( !empty ( $La_arreglo_intercambio ) )
                                             {
                                                 $ultimo_parametro = $La_arreglo_intercambio ;
                                             }
                                        reset( $La_parametros ) ;     
 
                                     }
                                 elseif ( !empty( $this->laFormatoFiltrado ) )
                                    {
                                         $La_parametros[] = $this->laFormatoFiltrado ;
                                    }
                            }
                        elseif ( !empty( $this->laFormatoFiltrado ) )
                            {
                                 $La_parametros[] = $this->laFormatoFiltrado ;
                            }
                            
                        if ( !empty( $this->laMatrizElementosError ) )
                            {
                                $La_parametros[] = $this->laMatrizElementosError ;
                            }
                        if ( !empty( $this->laFuenteDatosError ) )
                            {
                                $La_parametros[] = $this->laFuenteDatosError ;
                            }
                            
			return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros ) ;
                    }
                return null ;    
           }    
        
            
	   public function modificarDatosErrorLog()
	   {
	            if ( !empty( $this->lbIniciacion ) )
                    {
                        $La_parametros = func_get_args();
                        
                        if ( !empty ( $La_parametros ) && is_array( $La_parametros ) )
                            {
                                 $ultimo_parametro = end( $La_parametros ) ;
                                 $La_arreglo_intercambio = array() ;
                                 
                                 if ( !empty( $ultimo_parametro['formato'] ) || !empty( $ultimo_parametro['filtrado'] ) )
                                     {
                                         if ( isset( $ultimo_parametro['formato'] ) && !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = array_merge( $ultimo_parametro['formato'] , $this->laFormatoFiltrado['formato'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $ultimo_parametro['formato'] ;
                                             }
                                         elseif ( !empty( $this->laFormatoFiltrado['formato'] ) )
                                             {
                                                 $La_arreglo_intercambio['formato'] = $this->laFormatoFiltrado['formato'] ;
                                             }
                                         
                                         if ( isset( $ultimo_parametro['filtrado'] ) && !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = array_merge( $ultimo_parametro['filtrado'] , $this->laFormatoFiltrado['filtrado'] ) ;
                                             }
                                         elseif ( isset( $ultimo_parametro['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $ultimo_parametro['filtrado'] ;
                                             }    
                                         elseif ( !empty( $this->laFormatoFiltrado['filtrado'] ) )
                                             {
                                                 $La_arreglo_intercambio['filtrado'] = $this->laFormatoFiltrado['filtrado'] ;
                                             }
                                             
                                         if ( !empty ( $La_arreglo_intercambio ) )
                                             {
                                                 $ultimo_parametro = $La_arreglo_intercambio ;
                                             }
                                        reset( $La_parametros ) ;     
 
                                     }
                                 elseif ( !empty( $this->laFormatoFiltrado ) )
                                    {
                                         $La_parametros[] = $this->laFormatoFiltrado ;
                                    }
                            }
                        elseif ( !empty( $this->laFormatoFiltrado ) )
                            {
                                 $La_parametros[] = $this->laFormatoFiltrado ;
                            }
                            
                        if ( !empty( $this->laMatrizElementosError ) )
                            {
                                $La_parametros[] = $this->laMatrizElementosError ;
                            }
                        if ( !empty( $this->laFuenteDatosError ) )
                            {
                                $La_parametros[] = $this->laFuenteDatosError ;
                            }
                            
			return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros ) ;
                    }
                return null ;    
            }
        
            
	    public function crearFuenteDatosErrorLog()
	    {
	         if ( !empty( $this->lbIniciacion ) )
                    {
                        $La_parametros = func_get_args();
                            
                        return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros ) ;
                    }
                 return null ;   
            }

            
	    public function eliminarFuenteDatosErrorLog()
	    {
	         if ( !empty( $this->lbIniciacion ) )
                    {
                        $La_parametros = func_get_args();
                        if ( !empty( $this->laFuenteDatosError ) )
                            {
                                $La_parametros[] = $this->laFuenteDatosError ;
                            }
                            
                        return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros ) ;
                    }
                 return null ;   
            }
       
            public function error ( $Ls_id_error , $La_formato_mensaje_error = null , $La_formato_mensaje_errorlog = null , $La_formato_filtrado = null )
            {
                if ( !empty( $this->lbIniciacion ) && !empty( $Ls_id_error ) )
                    {
                        $gestor_errores_ejecucion = \Emod\Nucleo\Errores::gestorErroresEjecucion() ;
                        if (  $gestor_errores_ejecucion[0] != $this->lsIdGestorErrores )
                            {
                                \Emod\Nucleo\Errores::implantarGestorErrores ( array( $this , $this->lsFuncionGestorErrores ) , $this->lsIdGestorErrores , $this->liTiposError ) ;
                            }
                    
                        $La_datos_error_filtro['id'] = $Ls_id_error ;
                        
                        if( empty( $La_formato_filtrado ) || !is_array( $La_formato_filtrado ) )
                            {
                            settype($La_formato_filtrado, "array") ; 
                            $La_formato_filtrado = $this->laFormatoFiltrado ;
                            }
                        $La_formato_filtrado['filtrado']['llave_unica'] = true ;
                           
                         
                        $La_datos_error = $this->leerDatosError( $La_datos_error_filtro , $La_formato_filtrado ) ;

                        if ( !empty( $La_datos_error ) )
                            {
                                $Ls_mensaje_error = null ;
                                $La_formato_mensaje_error_final = ( !empty( $La_formato_mensaje_error ) && is_array( $La_formato_mensaje_error ) ) ? $La_formato_mensaje_error : $this->laFormatoMensajeError ;           
                                
                                foreach( $La_formato_mensaje_error_final as $llave_formato_error )
                                    {
                                        if( isset( $La_datos_error[0][$llave_formato_error] ) )
                                            {   if( $llave_formato_error == 'tipo' ){ continue ;}
                                                if( $llave_formato_error == 'id' ){ $Ls_mensaje_error.=' '.$La_datos_error[0][$llave_formato_error].':' ; continue ;}
                                                $Ls_mensaje_error.=' '.$La_datos_error[0][$llave_formato_error] ;
                                            }
                                    }
                                
                                if( !empty( $La_datos_error[0]['tipo'] ) )
                                    {
                                    switch ($La_datos_error[0]['tipo'])
                                        {
                                        case 'E_USER_ERROR' : $tipo_error_final = E_USER_ERROR ;
                                                              break;
                                                          
                                        case 'E_USER_WARNING' : $tipo_error_final = E_USER_WARNING ;
                                                                 break;
                                                             
                                        case 'E_USER_NOTICE ' : $tipo_error_final = E_USER_NOTICE  ;
                                                                 break;
                                        
                                        default : $tipo_error_final = E_USER_ERROR ;                    
                                        }
                                    
                                    }
                                elseif ( empty( $La_datos_error[0]['tipo'] ) )
                                    {
                                    $tipo_error_final = E_USER_ERROR ;
                                    }
                                    
                                 
                                $La_datos_errorlog = $La_datos_error[0] ;
                                
                                $parametros_backtrace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS , 3 ) ;
                              
                                $La_formato_mensaje_errorlog_final = ( !empty( $La_formato_mensaje_errorlog ) && is_array( $La_formato_mensaje_errorlog ) ) ? $La_formato_mensaje_error : $this->laFormatoMensajeErrorlog ;
                               
                                $La_datos_errorlog ['tiempo'] = time();
                                foreach( $La_formato_mensaje_errorlog_final as $miembro_mensaje_errorlog )
                                    {
                                     if( $miembro_mensaje_errorlog == 'fichero' ){ $La_datos_errorlog ['fichero'] = $parametros_backtrace[2]['file'] ; }
                                     if( $miembro_mensaje_errorlog == 'linea' ){ $La_datos_errorlog ['linea'] = $parametros_backtrace[2]['line'] ; }
                                     if( $miembro_mensaje_errorlog == 'proceso' ){ $La_datos_errorlog ['proceso'] = $this->EEoNucleo->idProcesoEjecucion() ; }
                                     if( $miembro_mensaje_errorlog == 'gedee_proceso' ){ $La_datos_errorlog ['gedee_proceso'] = $this->EEoNucleo->gedeeProcesoEjecucion() ; }
                                     if( !empty( $La_datos_error[0][$miembro_mensaje_errorlog] ) ){ $La_datos_errorlog [$miembro_mensaje_errorlog] = $La_datos_error[0][$miembro_mensaje_errorlog] ; }
                                    }
                               
                               if ( !$this->crearDatosErrorLog( $La_datos_errorlog ) )
                               {
                                   echo 'Advertencia: no se pudo crear el registro en errorlog' ;
                               }
                               
                               trigger_error( $Ls_mensaje_error , $tipo_error_final ) ;
                                
                                \Emod\Nucleo\Errores::implantarGestorErroresAnterior();
                                return true ;
                            }
                    }
                return null ;    
            }
            
       }
?>
