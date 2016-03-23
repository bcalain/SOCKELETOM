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
   * Herramientas class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

    namespace Emod\Nucleo;

    class Herramientas
        {

        use \Emod\Nucleo\Herramientas\GECO ;
        
        ///////////////////////////////////////////////////////////////////////////////////////
        //inicia datos para la gestion de Herramientas por parte del sistema esquelemod,
        //solo lo inicia el proceso nucleo 
        //$La_configuracion_nucleo_herramientas es un arreglo con la configuracion de del nucleo que pertenece a herramientas 
        //este procedimiento retorna null si ya estaba inicializada la clase herramientas , retorna true si la gestion es exitosa, detiene el proceso php si los parametros son incompatibles con el procedimiento 
        public static function iniciacion( $La_configuracion_nucleo_herramientas )
            {
            if ( empty( self::$iniciacion ) )
                {
                //chequeo de entidades elementales
                if ( is_object( \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ) && is_object( \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoInterfazDatos' , 'InterfazDatos' , 'Emod\Nucleo\Herramientas' ) ) )
                    {
                    self::$EEoNucleo = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' );
                    }
                else
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', no se encuentra referencia a objetos EEoNucleo, EEoInterfazDatos para la definici&oacute;n de Herramientas<p>' );
                    }

                //chequeo de proceso que inicia esta clase, obligatorio el proceso nucleo
                if ( self::$EEoNucleo->gedeeProcesoNucleo() . '::' . self::$EEoNucleo->idProcesoNucleo() != self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion() )
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', este procedimiento no est&aacute; siendo invocado por el proceso n&uacute;cleo<p>' );
                    }

                //chequeo de parametros de seguridad
                if ( isset( $La_configuracion_nucleo_herramientas['seguridad']['gestion_seguridad'] ) && empty( $La_configuracion_nucleo_herramientas['seguridad']['gestion_seguridad'] ) && ( ( $La_configuracion_nucleo_herramientas['seguridad']['propietario_entidad'] == true ) || ( $La_configuracion_nucleo_herramientas['seguridad']['propietario_entidad'] == false ) ) )
                    {
                    self::$lbGestionSeguridad = false;
                    self::$lbPropietarioEntidad = $La_configuracion_nucleo_herramientas['seguridad']['propietario_entidad'];
                    }
                elseif ( !empty( $La_configuracion_nucleo_herramientas['seguridad']['gestion_seguridad'] )
                        && ( ( $La_configuracion_nucleo_herramientas['seguridad']['propietario_entidad'] == true ) || ( $La_configuracion_nucleo_herramientas['seguridad']['propietario_entidad'] == false ) )
                        && ( ( $La_configuracion_nucleo_herramientas['seguridad']['ambito_seguridad'] == 'permisivo' ) || ( $La_configuracion_nucleo_herramientas['seguridad']['ambito_seguridad'] == 'restrictivo' ) )
                        && ( ( $La_configuracion_nucleo_herramientas['seguridad']['actualizar_datos_seguridad'] == true ) || ( $La_configuracion_nucleo_herramientas['seguridad']['actualizar_datos_seguridad'] == false ) )
                )
                    {
                    self::$lbGestionSeguridad = true;
                    self::$lbPropietarioEntidad = $La_configuracion_nucleo_herramientas['seguridad']['propietario_entidad'];
                    self::$lsAmbitoSeguridad = $La_configuracion_nucleo_herramientas['seguridad']['ambito_seguridad'];
                    self::$lbActualizarDatosSeguridad = $La_configuracion_nucleo_herramientas['seguridad']['actualizar_datos_seguridad'];
                    if ( !empty( $La_configuracion_nucleo_herramientas['seguridad']['datos_seguridad'] ) && is_array( $La_configuracion_nucleo_herramientas['seguridad']['datos_seguridad'] ) )
                        {
                        self::$laDatosSeguridad = $La_configuracion_nucleo_herramientas['seguridad']['datos_seguridad'];
                        }
                    }
                else
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', no se encuentran &oacute;ptimos los par&aacute;metros de seguridad para la definici&oacute;n de Herramientas<p>' );
                    }

                //chequeo de parametros de herramientas
                if ( !empty( $La_configuracion_nucleo_herramientas['path_dir_raiz'] ) )
                    {

                    self::$lsPathDirRaizEntidades = $La_configuracion_nucleo_herramientas['path_dir_raiz'];

                    if ( !empty( $La_configuracion_nucleo_herramientas['existentes_sistema'] ) && is_array( $La_configuracion_nucleo_herramientas['existentes_sistema'] ) )
                        {
                        $ingreso_herramientas = false;
                        $ingreso_herramientas = self::gestionIngresosEntidades( $La_configuracion_nucleo_herramientas['existentes_sistema'] );
                        
                        if ( $ingreso_herramientas )
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
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', no se encuentran datos imprescindibles de la configuraci&oacute;n de Herramientas<p>' );
                    }
                }

            return null;
            }

        }

?>	