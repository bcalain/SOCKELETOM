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
        
        //esta funcion es para implementar las demas funciones que seran las que realmente hagan el trabajo de esta clase
        //$nombre_funcion es el nombre de la funcion que se implementara
        //$La_argumentos es un arreglo con los argumentos que se le pasaran a esta funcion al estilo func_get_args()
        //$estructura_datos es la estructura de datos sobre la que operara la funcion implementada.
        //$chequeo_procesoygedee es para definir si ese procedimiento debe chequear el gedee al que se quiere acceder en la gestion.
        //procedimiento candidato a TRAITS.
        final protected function implementarProcedimientosEE( &$estructura_datos , $nombre_funcion , &$La_argumentos = null , $chequeo_procesoygedee = false )
            { //no se chequean los demas parametros porque efectivamente pueden estar vacios
            if ( !empty( $nombre_funcion ) )
                {
                                        
                ///////////////////defino el gedee de la gestion de este procedimiento/////////////////////////////////////////////////////////////////
                //aqui debajo chequeo los parametros ofrecidos por el usuario para deducir el gedee de la gestion
                //el usuario siempre pasara como ultimo parametro de su procedimiento el gedee del procezo sobre el que se realizar''a la gestion
                //si la lista de parametros es igual a cero se tomara como gedee el gedee del proceso en ejecucion en ese momento 
                if ( is_array( $La_argumentos ) && !empty( $La_argumentos ) )
                    {

                    $cantidad_parametros_usuario = count( $La_argumentos ) ;
                    }
                else
                    {
                    $cantidad_parametros_usuario = 0 ;
                    }

                //chequeo si la gestion es del tipo que requiere chequeo de gedee 
                if ( $chequeo_procesoygedee == true )
                    {
                    if ( $cantidad_parametros_usuario != 0 )
                        {
                        //chequeo si el ultimo elemento (namespace) no es vacio
                        if ( !empty( $La_argumentos[ 3 ] ) )
                            {
                            //chequeo si hereda explicitamente el namespace del gedee
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


                        //chequeo si el penultimo elemento  (clase) no es vacio
                        if ( !empty( $La_argumentos[ 2 ] ) )
                            {
                            //chequeo si hereda explicitamente la clase del gedee
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
                            
                            //chequeo si el penultimo elemento  (id_entidad_gedee) no es vacio
                        if ( !empty( $La_argumentos[ 1 ] ) )
                            {
                            //chequeo si hereda explicitamente la clase del gedee
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




                        //chequeo si el antepenultimo elemento  (id_proceso al que se le pide servicio) no es vacio
                        if ( !empty( $La_argumentos[ 0 ] ) )
                            {
                            //chequeo si hereda explicitamente el id_proceso
                            if ( $La_argumentos[ 0 ] == 'hereda' )
                                {
                                $Ls_id_proceso_servidor = $this->EEoNucleo->idProcesoEjecucion() ;
                                }
                            else
                                {
                                $Ls_id_proceso_servidor = $La_argumentos[ 0 ] ;
                                }
                            //aqui se elimina estos ultimos para contruir la funcion con los parametros requeridos por esta 
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
                        //hereda por defecto el namespace y clase del gedee
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


                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

                $tipo_entidad = \Emod\Nucleo\GEDEEs::existenciaEntidad( $Ls_namespace_gedee_proceso_servidor , $Ls_clase_gedee_proceso_servidor , $Ls_id_gedee_proceso_servidor ) ;
                if ( empty( $tipo_entidad ) )
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', el gedee de id_entidad: '.$Ls_id_gedee_proceso_servidor.', clase ' . $Ls_namespace_gedee_proceso_servidor . '\\' . $Ls_clase_gedee_proceso_servidor . ' no se puede gestionar<p>' ) ;
                    }


                //cargo las caracteristicas de la entidad

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

        //esta clase serbira de base en la herencia de otras clases implementadas en el nucleo del esquelemod
        }

?>