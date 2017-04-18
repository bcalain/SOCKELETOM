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
   * GEDEEs class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

namespace Emod\Nucleo ;

class GEDEEs
    {
    use \Emod\Nucleo\Herramientas\GECO ;
    
    public static function iniciacion( $La_configuracion_nucleo_gedees )
            {
            if ( empty( self::$iniciacion ) )
                {
                if ( is_object( \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ) )
                    {
                    self::$EEoNucleo = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' );
                    }
                else
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', no se encuentra referencia al objeto EEoNucleo para la definici&oacute;n de GEDEEs<p>' );
                    }

                if ( self::$EEoNucleo->gedeeProcesoNucleo() . '::' . self::$EEoNucleo->idProcesoNucleo() != self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion() )
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', este procedimiento no est&aacute; siendo invocado por el proceso n&uacute;cleo<p>' );
                    }

                if ( isset( $La_configuracion_nucleo_gedees['seguridad']['gestion_seguridad'] ) && empty( $La_configuracion_nucleo_gedees['seguridad']['gestion_seguridad'] ) && ( ( $La_configuracion_nucleo_gedees['seguridad']['propietario_entidad'] == true ) || ( $La_configuracion_nucleo_gedees['seguridad']['propietario_entidad'] == false ) ) )
                    {
                    self::$lbGestionSeguridad = false;
                    self::$lbPropietarioEntidad = $La_configuracion_nucleo_gedees['seguridad']['propietario_entidad'];
                    }
                elseif ( !empty( $La_configuracion_nucleo_gedees['seguridad']['gestion_seguridad'] )
                        && ( ( $La_configuracion_nucleo_gedees['seguridad']['propietario_entidad'] == true ) || ( $La_configuracion_nucleo_gedees['seguridad']['propietario_entidad'] == false ) )
                        && ( ( $La_configuracion_nucleo_gedees['seguridad']['ambito_seguridad'] == 'permisivo' ) || ( $La_configuracion_nucleo_gedees['seguridad']['ambito_seguridad'] == 'restrictivo' ) )
                        && ( ( $La_configuracion_nucleo_gedees['seguridad']['actualizar_datos_seguridad'] == true ) || ( $La_configuracion_nucleo_gedees['seguridad']['actualizar_datos_seguridad'] == false ) )
                )
                    {
                    self::$lbGestionSeguridad = true;
                    self::$lbPropietarioEntidad = $La_configuracion_nucleo_gedees['seguridad']['propietario_entidad'];
                    self::$lsAmbitoSeguridad = $La_configuracion_nucleo_gedees['seguridad']['ambito_seguridad'];
                    self::$lbActualizarDatosSeguridad = $La_configuracion_nucleo_gedees['seguridad']['actualizar_datos_seguridad'];
                    if ( !empty( $La_configuracion_nucleo_gedees['seguridad']['datos_seguridad'] ) && is_array( $La_configuracion_nucleo_gedees['seguridad']['datos_seguridad'] ) )
                        {
                        self::$laDatosSeguridad = $La_configuracion_nucleo_gedees['seguridad']['datos_seguridad'];
                        }
                    }
                else
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', no se encuentran &oacute;ptimos los par&aacute;metros de seguridad para la definici&oacute;n de GEDEEs<p>' );
                    }

                if ( !empty( $La_configuracion_nucleo_gedees['path_dir_raiz'] ) )
                    {

                    self::$lsPathDirRaizEntidades = $La_configuracion_nucleo_gedees['path_dir_raiz'];

                    if ( !empty( $La_configuracion_nucleo_gedees['existentes_sistema'] ) && is_array( $La_configuracion_nucleo_gedees['existentes_sistema'] ) )
                        {
                        $ingreso_gedees = self::gestionIngresosEntidades( $La_configuracion_nucleo_gedees['existentes_sistema'] );
                        
                        if ( $ingreso_gedees )
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
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', no se encuentran datos imprescindibles de la configuraci&oacute;n de GEDEEs<p>' );
                    }
                }
                
            return null;
            }
    }

?>	