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
   * NucleoEntidadBase class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

    namespace Emod\Nucleo ;

    class NucleoEntidadBase extends \Emod\Nucleo\Herramientas\Multiton
        {
         use \Emod\Nucleo\DependenciasEntidadesEmod ;
        
        final protected function implementarProcedimientosEE( &$estructura_datos , $nombre_funcion , &$La_argumentos = null , $chequeo_procesoygedee = false )
            { 
            if ( !empty( $nombre_funcion ) )
                {
                                        
                if ( is_array( $La_argumentos ) && !empty( $La_argumentos ) )
                    {

                    $cantidad_parametros_usuario = count( $La_argumentos ) ;
                    }
                else
                    {
                    $cantidad_parametros_usuario = 0 ;
                    }

                 
                if ( $chequeo_procesoygedee == true )
                    {
                    if ( $cantidad_parametros_usuario != 0 )
                        {
                        
                        if ( !empty( $La_argumentos[ 3 ] ) )
                            {
                            
                            if ( $La_argumentos[ 3 ] == 'hereda' )
                                {
                                $Ls_namespace_gedee_proceso_servidor = $this->EEoNucleo->namespaceGedeeProcesoEjecucion() ;
                                }
                            else
                                {
                                $Ls_namespace_gedee_proceso_servidor = $La_argumentos[ 3 ] ;
                                }
                            }
                        else
                            {
                            exit( '<p> ERROR FATAL, ' . __METHOD__ . ' no se encuentra el namespace del gedee declarado para la gesti&oacute;n de este procedimiento ' ) ;
                            }


                        if ( !empty( $La_argumentos[ 2 ] ) )
                            {
                            if ( $La_argumentos[ 2 ] == 'hereda' )
                                {
                                $Ls_clase_gedee_proceso_servidor = $this->EEoNucleo->claseGedeeProcesoEjecucion() ;
                                }
                            else
                                {
                                $Ls_clase_gedee_proceso_servidor = $La_argumentos[ 2 ] ;
                                }
                            }
                        else
                            {
                            exit( '<p> ERROR FATAL, ' . __METHOD__ . ' no se encuentra la clase del gedee declarado para la gesti&oacute;n de este procedimiento ' ) ;
                            }
                            
                        if ( !empty( $La_argumentos[ 1 ] ) )
                            {
                            if ( $La_argumentos[ 1 ] == 'hereda' )
                                {
                                $Ls_id_gedee_proceso_servidor = $this->EEoNucleo->idGedeeProcesoEjecucion() ;
                                }
                            else
                                {
                                $Ls_id_gedee_proceso_servidor = $La_argumentos[ 1 ] ;
                                }
                            }
                        else
                            {
                            exit( '<p> ERROR FATAL, ' . __METHOD__ . ' no se encuentra el id_entidad_gedee declarado para la gesti&oacute;n de este procedimiento ' ) ;
                            }

						if ( !empty( $La_argumentos[ 0 ] ) )
                            {
                            if ( $La_argumentos[ 0 ] == 'hereda' )
                                {
                                $Ls_id_proceso_servidor = $this->EEoNucleo->idProcesoEjecucion() ;
                                }
                            else
                                {
                                $Ls_id_proceso_servidor = $La_argumentos[ 0 ] ;
                                }
                            $La_argumentos = array_slice( $La_argumentos , 4 ) ;
                            $cantidad_parametros_usuario -= 4 ;
                            }
                        else
                            {
                            exit( '<p> ERROR FATAL, ' . __METHOD__ . ' no se encuentra el id_proceso servidor declarado para la gesti&oacute;n de este procedimiento ' ) ;
                            }
                        }
                    else
                        {
                        $Ls_namespace_gedee_proceso_servidor = $this->EEoNucleo->namespaceGedeeProcesoEjecucion() ;
                        $Ls_clase_gedee_proceso_servidor = $this->EEoNucleo->claseGedeeProcesoEjecucion() ;
                        $Ls_id_gedee_proceso_servidor = $this->EEoNucleo->idGedeeProcesoEjecucion() ;
                        $Ls_id_proceso_servidor = $this->EEoNucleo->idProcesoEjecucion() ;
                        }
                    }
                else
                    {
                    $Ls_namespace_gedee_proceso_servidor = $this->EEoNucleo->namespaceGedeeProcesoEjecucion() ;
                    $Ls_clase_gedee_proceso_servidor = $this->EEoNucleo->claseGedeeProcesoEjecucion() ;
                    $Ls_id_gedee_proceso_servidor = $this->EEoNucleo->idGedeeProcesoEjecucion() ;
                    $Ls_id_proceso_servidor = $this->EEoNucleo->idProcesoEjecucion() ;
                    }


                $tipo_entidad = \Emod\Nucleo\GEDEEs::existenciaEntidad( $Ls_namespace_gedee_proceso_servidor , $Ls_clase_gedee_proceso_servidor , $Ls_id_gedee_proceso_servidor ) ;
                if ( empty( $tipo_entidad ) )
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', el gedee de id_entidad: '.$Ls_id_gedee_proceso_servidor.', clase ' . $Ls_namespace_gedee_proceso_servidor . '\\' . $Ls_clase_gedee_proceso_servidor . ' no se puede gestionar<p>' ) ;
                    }

				$entidad = \Emod\Nucleo\GEDEEs::entidad( $Ls_namespace_gedee_proceso_servidor , $Ls_clase_gedee_proceso_servidor , $Ls_id_gedee_proceso_servidor ) ;

				if ( $cantidad_parametros_usuario != 0 )
                    {

                    if ( ( $tipo_entidad == 'objeto' ) && is_object( $entidad ) )
                        {
                        if ( $chequeo_procesoygedee == true )
                            {
                            $sentencia = '$resultado = $entidad->' . $nombre_funcion . '( $estructura_datos , $Ls_id_proceso_servidor , ' ;   
                            }
                        else
                            {
                            $sentencia = '$resultado = $entidad->' . $nombre_funcion . '( $estructura_datos , ' ;
                            }
                        }
                    elseif ( ( $tipo_entidad == 'clase' ) && is_string( $entidad ) )
                        {
                        if ( $chequeo_procesoygedee == true )
                            {
                            $sentencia = '$resultado = $entidad::' . $nombre_funcion . '( $estructura_datos , $Ls_id_proceso_servidor , ' ;   
                            }
                        else
                            {
                            $sentencia = '$resultado = $entidad::' . $nombre_funcion . '( $estructura_datos , ' ;
                            }
                        
                        }
                    else
                        {
                        exit( "<p> ERROR FATAL, no se puede implementar la funci&oacute;n $nombre_funcion en  " . __METHOD__ ) ;
                        }


                    for ( $i = 0 ; $i < $cantidad_parametros_usuario ; $i++ )
                        {
                        if ( $i == ( $cantidad_parametros_usuario - 1 ) )
                            {
                            $sentencia.= "\$La_argumentos[$i] );" ;
                            }
                        else
                            {
                            $sentencia.= "\$La_argumentos[$i] , " ;
                            }
                        }
                    }
                else
                    {
                    if ( ( $tipo_entidad == 'objeto' ) && is_object( $entidad ) )
                        {
                        if ( $chequeo_procesoygedee == true )
                            {
                            $sentencia = '$resultado = $entidad->' . $nombre_funcion . '( $estructura_datos , $Ls_id_proceso_servidor ) ;' ;   
                            }
                        else
                            {
                            $sentencia = '$resultado = $entidad->' . $nombre_funcion . '( $estructura_datos ) ;' ;
                            }
                        }
                    elseif ( ( $tipo_entidad == 'clase' ) && is_string( $entidad ) )
                        {
                        if ( $chequeo_procesoygedee == true )
                            {
                            $sentencia = '$resultado = $entidad::' . $nombre_funcion . '( $estructura_datos , $Ls_id_proceso_servidor ) ;' ;   
                            }
                        else
                            {
                            $sentencia = " \$resultado = $entidad::" . $nombre_funcion . '( $estructura_datos ) ;' ;
                            }
                        }
                    else
                        {
                        exit( "<p> ERROR FATAL, no se puede implementar la funci&oacute;n $nombre_funcion en  " . __METHOD__ ) ;
                        }
                    }

                eval( $sentencia ) ;

                return $resultado ;
                }

            exit( "<p> ERROR FATAL, no se puede implementar la funci&oacute;n $nombre_funcion en  " . __METHOD__ ) ;
            }

        }

?>