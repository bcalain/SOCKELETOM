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
   * Errores class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */
    namespace Emod\Nucleo;

    class Errores 
        {
        
        use \Emod\Nucleo\Herramientas\GECO ;
        
        private static $laPilaGestoresErrores = null;
        private static $lsIdGestorErroresEjecucion = 'PHP Nativo';
        private static $laGestorErroresEjecucion = array( );

        public static function iniciacion( $La_configuracion_nucleo_errores )
            {
            if ( empty( self::$iniciacion ) )
                {
                if ( is_object( \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ) )
                    {
                    self::$EEoNucleo = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' );
                    }
                else
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', no se encuentra referencia al objeto EEoNucleo para la definici&oacute;n de Errores<p>' );
                    }

                if ( self::$EEoNucleo->gedeeProcesoNucleo() . '::' . self::$EEoNucleo->idProcesoNucleo() != self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion() )
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', este procedimiento no est&aacute; siendo invocado por el proceso n&uacute;cleo<p>' );
                    }

                if ( isset( $La_configuracion_nucleo_errores['seguridad']['gestion_seguridad'] ) && empty( $La_configuracion_nucleo_errores['seguridad']['gestion_seguridad'] ) && ( ( $La_configuracion_nucleo_errores['seguridad']['propietario_entidad'] == true ) || ( $La_configuracion_nucleo_errores['seguridad']['propietario_entidad'] == false ) ) )
                    {
                    self::$lbGestionSeguridad = false;
                    self::$lbPropietarioEntidad = $La_configuracion_nucleo_errores['seguridad']['propietario_entidad'];
                    }
                elseif ( !empty( $La_configuracion_nucleo_errores['seguridad']['gestion_seguridad'] )
                        && ( ( $La_configuracion_nucleo_errores['seguridad']['propietario_entidad'] == true ) || ( $La_configuracion_nucleo_errores['seguridad']['propietario_entidad'] == false ) )
                        && ( ( $La_configuracion_nucleo_errores['seguridad']['ambito_seguridad'] == 'permisivo' ) || ( $La_configuracion_nucleo_errores['seguridad']['ambito_seguridad'] == 'restrictivo' ) )
                        && ( ( $La_configuracion_nucleo_errores['seguridad']['actualizar_datos_seguridad'] == true ) || ( $La_configuracion_nucleo_errores['seguridad']['actualizar_datos_seguridad'] == false ) )
                )
                    {
                    self::$lbGestionSeguridad = true;
                    self::$lbPropietarioEntidad = $La_configuracion_nucleo_errores['seguridad']['propietario_entidad'];
                    self::$lsAmbitoSeguridad = $La_configuracion_nucleo_errores['seguridad']['ambito_seguridad'];
                    self::$lbActualizarDatosSeguridad = $La_configuracion_nucleo_errores['seguridad']['actualizar_datos_seguridad'];
                    if ( !empty( $La_configuracion_nucleo_errores['seguridad']['datos_seguridad'] ) && is_array( $La_configuracion_nucleo_errores['seguridad']['datos_seguridad'] ) )
                        {
                        self::$laDatosSeguridad = $La_configuracion_nucleo_errores['seguridad']['datos_seguridad'];
                        }
                    }
                else
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', no se encuentran &oacute;ptimos los par&aacute;metros de seguridad para la definici&oacute;n de Errores<p>' );
                    }

                if ( !empty( $La_configuracion_nucleo_errores['path_dir_raiz'] ) )
                    {

                    self::$lsPathDirRaizEntidades = $La_configuracion_nucleo_errores['path_dir_raiz'];

                    if ( !empty( $La_configuracion_nucleo_errores['existentes_sistema'] ) && is_array( $La_configuracion_nucleo_errores['existentes_sistema'] ) )
                        {
                        $ingreso_errores = self::gestionIngresosEntidades( $La_configuracion_nucleo_errores['existentes_sistema'] );
                        if ( $ingreso_errores )
                            {
                            self::$iniciacion = true;
                            return true;
                            }
                        }
                    else
                        {
                        self::$iniciacion = true;
                        return true;
                        }
                    }
                else
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', no se encuentran datos imprescindibles de la configuraci&oacute;n de Errores<p>' );
                    }
                }

            return null;
            }

        public static function implantarGestorErrores( $La_gestor_errores , $Ls_id_gestor_errores , $Ls_tipos_error = null )
            {
            if ( !empty( self::$iniciacion ) && !empty( $La_gestor_errores ) && is_array( $La_gestor_errores ) && !empty( $Ls_id_gestor_errores ) && ( empty(self::$laGestorErroresEjecucion ) || ( ( $La_gestor_errores[0] != self::$laGestorErroresEjecucion[0] ) && ( $La_gestor_errores[1] != self::$laGestorErroresEjecucion[1] ) ) ) )
                {
                
                $gestor_errores_anterior = ( empty( $tipos_error ) ) ? set_error_handler( $La_gestor_errores ) : set_error_handler( $La_gestor_errores , $Ls_tipos_error );

                self::$laPilaGestoresErrores[] = array( self::$laGestorErroresEjecucion , self::$lsIdGestorErroresEjecucion );
                self::$laGestorErroresEjecucion = $La_gestor_errores;
                self::$lsIdGestorErroresEjecucion = $Ls_id_gestor_errores;

                return $gestor_errores_anterior;
                }
            return null;
            }

        public static function implantarGestorErroresAnterior()
            {
            if ( !empty( self::$iniciacion ) && !empty( self::$laPilaGestoresErrores ) )
                {
                $retorno = restore_error_handler() ;
                
                if ( $retorno )
                    {
                    $parametros_suplentes = array_pop( self::$laPilaGestoresErrores );
                    if ( $parametros_suplentes )
                        {
                        self::$laGestorErroresEjecucion = $parametros_suplentes[0];
                        self::$lsIdGestorErroresEjecucion = $parametros_suplentes[1];
                        return $retorno;
                        }
                    }
                }
            return null;
            }

        public static function implantarGestorErroresPila( $Ls_posicion_gestor_pila )
            {
            if ( !empty( self::$iniciacion ) && !empty( $Ls_posicion_gestor_pila ) && is_int( $Ls_posicion_gestor_pila ) && !empty( self::$laPilaGestoresErrores[$Ls_posicion_gestor_pila] ) )
                {
                return self::implantarGestorErrores( self::$laPilaGestoresErrores[$Ls_posicion_gestor_pila][0] , self::$laPilaGestoresErrores[$Ls_posicion_gestor_pila][1] );
                }
            return null;
            }

        public static function gestorErroresEjecucion()
            {
            if ( !empty( self::$iniciacion ) && !empty( self::$lsIdGestorErroresEjecucion ) )
                {
                if( self::$lsIdGestorErroresEjecucion == 'PHP Nativo' )
                    {return array( self::$lsIdGestorErroresEjecucion );}
                elseif( !empty( self::$laGestorErroresEjecucion ) )
                    { return array( self::$lsIdGestorErroresEjecucion , self::$laGestorErroresEjecucion );}
                } 
            return null;
            }

        }

?>
