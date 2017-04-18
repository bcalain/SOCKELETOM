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
   * GedeeENucleo class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

    namespace Emod\Nucleo\Gedees ;

    class GedeeENucleo
        {

        static private $EEoNucleo = null ;
        static private $EEoSeguridad = null ;
        
        static private $classIniciacion = null ;
        
        static public function iniciarParametrosBase()
            {
            if ( empty( self::$classIniciacion ) && empty( self::$EEoNucleo ) && empty( self::$EEoSeguridad ) )
                {
                $EEoNucleo = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ;
                $EEoSeguridad = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoSeguridad' , 'SeguridadProcesos' , 'Emod\Nucleo' ) ;
                if ( is_object( $EEoNucleo ) && is_object( $EEoSeguridad ) )
                    {
                    self::$EEoNucleo = $EEoNucleo ;
                    self::$EEoSeguridad = $EEoSeguridad ;
                    self::$classIniciacion = true ;
                    return true ;
                    }
                }
            return null ;
            }

        static private function chequearSeguridadCliente()
            {
            if ( !empty( self::$classIniciacion ) && ( self::$EEoNucleo->namespaceGedeeProcesoEjecucion() == self::$EEoNucleo->namespaceGedeeProcesoNucleo() ) && ( self::$EEoNucleo->claseGedeeProcesoEjecucion() == self::$EEoNucleo->claseGedeeProcesoNucleo() ) )
                {
                return true ;
                }
            return null ;
            }

        static public function existenciaIdProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' )
            {
            if ( self::chequearSeguridadCliente() && !empty( $fuente_datos_procesos ) && !empty( $id_proceso ) )
                {
                if ( ( $id_proceso == 'hereda' ) )
                    {
                    $id_proceso = self::$EEoNucleo->idProcesoEjecucion() ;
                    }
                if ( !empty( $fuente_datos_procesos[ self::$EEoNucleo->namespaceGedeeProcesoNucleo() ][ self::$EEoNucleo->claseGedeeProcesoNucleo() ][ $id_proceso ] ) )
                    {
                    return true ;
                    }
                }
            return null ;
            }

        static public function iniciarDatosProceso( &$fuente_datos_procesos , $datos )
            {
            if ( self::chequearSeguridadCliente() && !empty( $datos ) && isset( $fuente_datos_procesos ) )
                {
                $namespace_gedee_proceso_nucleo = self::$EEoNucleo->namespaceGedeeProcesoNucleo() ;
                $clase_gedee_proceso_nucleo = self::$EEoNucleo->claseGedeeProcesoNucleo() ;
                $id_proceso_nucleo = self::$EEoNucleo->idProcesoNucleo() ;

                if ( !self::existenciaIdProceso( $fuente_datos_procesos , $id_proceso_nucleo ) )
                    {
                    $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso_nucleo ] = $datos ;
                    return true ;
                    }
                }
            return null ;
            }

		static public function iniciarDatosConfiguracionProceso( &$fuente_datos_procesos , $datos_configuracion )
            {
            return self::iniciarDatosProceso( $fuente_datos_procesos , $datos_configuracion ) ;
            }

		static public function accederDatosConfiguracionProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' , $estructura_acceder = array( ) , $tipo_modificacion = 1 , $condicion_modificacion = 0 )
            {
            if ( self::chequearSeguridadCliente() && !empty( $fuente_datos_procesos ) && !empty( $id_proceso ) && ( ( $tipo_modificacion == 1 ) || ( $tipo_modificacion == 2 ) || ( $tipo_modificacion == 3 ) ) )
                {
                $namespace_gedee_proceso_nucleo = self::$EEoNucleo->namespaceGedeeProcesoNucleo() ;
                $clase_gedee_proceso_nucleo = self::$EEoNucleo->claseGedeeProcesoNucleo() ;

                $id_proceso_actual = self::$EEoNucleo->idProcesoEjecucion() ;

                if ( strtolower( $id_proceso ) == 'hereda' )
                    {
                    $id_proceso = $id_proceso_actual ;
                    }
                
                if ( !self::existenciaIdProceso( $fuente_datos_procesos , $id_proceso ) || ( empty( $estructura_acceder ) && ( ( $tipo_modificacion == 2 ) || ( $tipo_modificacion == 3 ) ) ) )
                    {
                    return null ;
                    }

                $La_resultado = null ;
                switch ( $tipo_modificacion )
                    {
                    case 1 : //leer
                        if ( is_array( $estructura_acceder ) && empty( $estructura_acceder ) )
                            {
                            $La_resultado = $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] ;
                            }
                        elseif ( is_string( $estructura_acceder ) && ( stripos( $estructura_acceder , ';' ) === false ) && ( stripos( $estructura_acceder , ')' ) === false ) && ( stripos( $estructura_acceder , '{' ) === false ) )
                            {

                            $cadena_ejecutar = " if ( isset( \$fuente_datos_procesos[\$namespace_gedee_proceso_nucleo][\$clase_gedee_proceso_nucleo][\$id_proceso]$estructura_acceder ) )
																						{
																							\$La_resultado = \$fuente_datos_procesos[\$namespace_gedee_proceso_nucleo][\$clase_gedee_proceso_nucleo][\$id_proceso]$estructura_acceder ;
																						}
																					" ;
                            eval( $cadena_ejecutar ) ;
                            }
                        return $La_resultado ;

                    case 2 : //escribir o modificar
                        $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloModificarRecursivo( $estructura_acceder , $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] , $condicion_modificacion ) ;
                        break ;

                    case 3 : //eliminar
                        $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloEliminarRecursivo( $estructura_acceder , $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] , $condicion_modificacion ) ;
                        break ;
                    }
                if ( ( $tipo_modificacion != 1 ) && !empty( $La_resultado [ 'arreglo_base' ] ) )
                    {
                    $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] = $La_resultado [ 'arreglo_base' ] ;
                    
                        return true ;
                    }
                }
            return null ;
            }

		static public function iniciarDatosSeguridadProceso( &$fuente_datos_procesos , $datos_seguridad )
            {
            return null ;
            }

		static public function accederDatosSeguridadProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' , $estructura_acceder = array( ) , $tipo_modificacion = 1 , $condicion_modificacion = 0 )
            {
            return null ;
            }

		static public function clienteEjecucionProceso()
            {
            if ( self::chequearSeguridadCliente() )
                {
                   return 'ejecucion' ;
                }
            return null ;
            }

		static public function clienteAccesoDatosProceso()
            {
            if ( self::chequearSeguridadCliente() )
                {
                return 'leer::escribir::eliminar' ;
                }
            return null ;
            }

		static public function clienteAccesoConfiguracionProceso()
            {           
            if ( self::chequearSeguridadCliente() )
                {
                return 'leer::escribir::eliminar' ;
                }
            return null ;
            }

		static public function iniciarDatosSalidaProceso( &$fuente_datos_procesos , $datos_salida )
            {
            return self::iniciarDatosProceso( $fuente_datos_procesos , $datos_salida ) ;
            }

  		static public function accederDatosSalidaProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' , $estructura_acceder = array( ) , $tipo_modificacion = 1 , $condicion_modificacion = 0 )
            {
            if ( self::chequearSeguridadCliente() && !empty( $fuente_datos_procesos ) && !empty( $id_proceso ) && ( ( $tipo_modificacion == 1 ) || ( $tipo_modificacion == 2 ) || ( $tipo_modificacion == 3 ) ) )
                {
                $namespace_gedee_proceso_nucleo = self::$EEoNucleo->namespaceGedeeProcesoNucleo() ;
                $clase_gedee_proceso_nucleo = self::$EEoNucleo->claseGedeeProcesoNucleo() ;

                $id_proceso_actual = self::$EEoNucleo->idProcesoEjecucion() ;

                if ( strtolower( $id_proceso ) == 'hereda' )
                    {
                    $id_proceso = $id_proceso_actual ;
                    }

                if ( !self::existenciaIdProceso( $fuente_datos_procesos , $id_proceso ) || ( empty( $estructura_acceder ) && ( ( $tipo_modificacion == 2 ) || ( $tipo_modificacion == 3 ) ) ) )
                    {
                    return null ;
                    }

                $La_resultado = null ;
                switch ( $tipo_modificacion )
                    {
                    case 1 : //leer
                        if ( is_array( $estructura_acceder ) && empty( $estructura_acceder ) )
                            {
                            $La_resultado = $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] ;
                            }
                        elseif ( is_string( $estructura_acceder ) && ( stripos( $estructura_acceder , ';' ) === false ) && ( stripos( $estructura_acceder , ')' ) === false ) && ( stripos( $estructura_acceder , '{' ) === false ) )
                            {

                            $cadena_ejecutar = " if ( isset( \$fuente_datos_procesos[\$namespace_gedee_proceso_nucleo][\$clase_gedee_proceso_nucleo][\$id_proceso]$estructura_acceder ) )
																						{
																							\$La_resultado = \$fuente_datos_procesos[\$namespace_gedee_proceso_nucleo][\$clase_gedee_proceso_nucleo][\$id_proceso]$estructura_acceder ;
																						}
																					" ;
                            eval( $cadena_ejecutar ) ;
                            }
                        return $La_resultado ;

                    case 2 : //escribir o modificar
                        $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloModificarRecursivo( $estructura_acceder , $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] , $condicion_modificacion ) ;
                        break ;

                    case 3 : //eliminar
                        $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloEliminarRecursivo( $estructura_acceder , $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] , $condicion_modificacion ) ;
                        break ;
                    }
                if ( ( $tipo_modificacion != 1 ) && !empty( $La_resultado [ 'arreglo_base' ] ) )
                    {
                    $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] = $La_resultado [ 'arreglo_base' ] ;
                    return true ;
                    }
                }
            return null ;
            }
		}

?>		