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
   * GedeeEComun class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

    namespace Emod\Nucleo\Gedees ;

    class GedeeEComun 
        {

        static private $EEoNucleo = null ;
        static private $EEoSeguridad = null ;
        static private $namespaceEntidad = null ;
        static private $claseEntidad = null ;
        static private $idEntidad = null ;
        static private $classIniciacion = null ;
        static private $ambitoSeguridad = 'restrictivo' ;

        ////////////////////////////////////Procedimientos///////////////////////////////////////////

        static public function iniciarParametrosBase( $id_entidad )
            {
            if ( empty( self::$classIniciacion ) && empty( self::$EEoNucleo ) && empty( self::$EEoSeguridad ) && !empty( $id_entidad ) )
                {
                $EEoNucleo = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ;
                $EEoSeguridad = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoSeguridad' , 'SeguridadProcesos' , 'Emod\Nucleo' ) ;
                if ( is_object( $EEoNucleo ) && is_object( $EEoSeguridad ) )
                    {
                    self::$EEoNucleo = $EEoNucleo ;
                    self::$EEoSeguridad = $EEoSeguridad ;
                    
                    self::$namespaceEntidad = '\\'.__NAMESPACE__ ;
                    $clase_entidad = __CLASS__ ;
                    $distancia = strlen( self::$namespaceEntidad );
                    self::$claseEntidad = substr( $clase_entidad , $distancia ) ;
                    self::$idEntidad = $id_entidad ; 
                    
                    self::$classIniciacion = true ;
                    return true ;
                    }
                }
            return null ;
            }

        static public function existenciaIdProceso( &$fuente_datos_procesos , $id_proceso = 'hereda'  )
            {
            if ( !empty( self::$classIniciacion ) && !empty( $fuente_datos_procesos ) && !empty( $id_proceso ) )
                {
                if ( ( $id_proceso == 'hereda' ) )
                    {
                    $id_proceso = self::$EEoNucleo->idProcesoEjecucion() ;
                    }
                if ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ] ) )
                    {
                    return true ;
                    }
                }
            return null ;
            }

        static public function iniciarDatosProceso( &$fuente_datos_procesos , $datos )
            {
            if ( !empty( self::$classIniciacion ) )
                {
                
                $id_proceso_ejecucion = self::$EEoNucleo->idProcesoEjecucion() ;

                if ( ( self::$EEoNucleo->namespaceGedeeProcesoEjecucion() == self::$namespaceEntidad ) && ( self::$EEoNucleo->claseGedeeProcesoEjecucion() == self::$claseEntidad ) && !self::existenciaIdProceso( $fuente_datos_procesos , $id_proceso_ejecucion  ) && !empty( $datos ) )
                    {
                    $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso_ejecucion ] = $datos ;
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
            if ( !empty( self::$classIniciacion ) && !empty( $fuente_datos_procesos ) && !empty( $id_proceso ) && self::existenciaIdProceso( $fuente_datos_procesos , $id_proceso ) && ( ( $tipo_modificacion == 1 ) || ( $tipo_modificacion == 2 ) || ( $tipo_modificacion == 3 ) ) )
                {
                if ( empty( $estructura_acceder ) && ( ( $tipo_modificacion == 2 ) || ( $tipo_modificacion == 3 ) ) )
                    {
                    return null ;
                    }
                
                $id_proceso_actual = self::$EEoNucleo->idProcesoEjecucion() ;
                
                if ( strtolower( $id_proceso ) == 'hereda' )
                    {
                    $id_proceso = $id_proceso_actual ;
                    }
                if ( ( $id_proceso != $id_proceso_actual ) || ( self::$claseEntidad != self::$EEoNucleo->claseGedeeProcesoEjecucion() ) || ( self::$namespaceEntidad != self::$EEoNucleo->namespaceGedeeProcesoEjecucion() ) )
                    {
                    
                    $tipo_acceso = self::$EEoSeguridad->clienteAccesoConfiguracionProceso( $id_proceso , self::$idEntidad , self::$claseEntidad , self::$namespaceEntidad ) ;

                    if ( $tipo_acceso )
                        {
                        $acceso_leer = null ;
                        $acceso_escribir = null ;
                        $acceso_eliminar = null ;

                        if ( is_string( $tipo_acceso ) )
                            {
                            $arreglo_acceso = explode( '::' , $tipo_acceso ) ;
                            foreach ( $arreglo_acceso as $elemento )
                                {
                                switch ( $elemento )
                                    {
                                    case 'leer' : $acceso_leer = 'leer' ;
                                        break ;
                                    case 'escribir' : $acceso_escribir = 'escribir' ;
                                        break ;
                                    case 'eliminar' : $acceso_eliminar = 'eliminar' ;
                                        break ;
                                    }
                                }
                            }

                        if ( ( ( $tipo_modificacion == 1 ) && ( $acceso_leer != 'leer' ) ) || ( ( $tipo_modificacion == 2 ) && ( $acceso_escribir != 'escribir' ) ) || ( ( $tipo_modificacion == 3 ) && ( $acceso_eliminar != 'eliminar' ) ) )
                            {
                            return null ;
                            }
                        }
                    else
                        {
                        return null ;
                        }
                    }
                $La_resultado = null ;
                switch ( $tipo_modificacion )
                    {
                    case 1 : //leer
                        if ( is_array( $estructura_acceder ) && empty( $estructura_acceder ) )
                            {
                            $La_resultado = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ] ;
                            }
                        elseif ( is_string( $estructura_acceder ) && ( stripos( $estructura_acceder , ';' ) === false ) && ( stripos( $estructura_acceder , ')' ) === false ) && ( stripos( $estructura_acceder , '{' ) === false ) )
                            {

                            $cadena_ejecutar = " if ( isset( \$fuente_datos_procesos[self::\$namespaceEntidad][self::\$claseEntidad][\$id_proceso]$estructura_acceder ) )
																						{
																							\$La_resultado = \$fuente_datos_procesos[self::\$namespaceEntidad][self::\$claseEntidad][\$id_proceso]$estructura_acceder ;
																						}
																					" ;
                            eval( $cadena_ejecutar ) ;
                            }
                        return $La_resultado ;

                    case 2 : //escribir o modificar
                        $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloModificarRecursivo( $estructura_acceder , $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ] , $condicion_modificacion ) ;
                        break ;

                    case 3 : //eliminar
                        $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloEliminarRecursivo( $estructura_acceder , $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ] , $condicion_modificacion ) ;
                        break ;
                    }
                if ( ( $tipo_modificacion != 1 ) && !empty( $La_resultado [ 'arreglo_base' ] ) )
                    {
                    $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ] = $La_resultado [ 'arreglo_base' ] ;
                    return true ;
                    }
                }
            return null ;
            }

        static public function iniciarDatosSeguridadProceso( &$fuente_datos_procesos , $datos_seguridad )
            {
            return self::iniciarDatosProceso( $fuente_datos_procesos , $datos_seguridad ) ;
            }

        static public function accederDatosSeguridadProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' , $estructura_acceder = array( ) , $tipo_accion = 1 , $condicion_modificacion = 0 )
            {
            if ( !empty( self::$classIniciacion ) && !empty( $fuente_datos_procesos ) && !empty( $id_proceso ) && self::existenciaIdProceso( $fuente_datos_procesos , $id_proceso ) && ( ( $tipo_accion == 1 ) || ( $tipo_accion == 2 ) || ( $tipo_accion == 3 ) ) )
                {
                $namespace_gedee_proceso_actual = self::$EEoNucleo->namespaceGedeeProcesoEjecucion() ;
                $clase_gedee_proceso_actual = self::$EEoNucleo->claseGedeeProcesoEjecucion() ;
                $id_proceso_actual = self::$EEoNucleo->idProcesoEjecucion() ;
                
                if ( empty( $estructura_acceder ) && ( ( $tipo_accion == 2 ) || ( $tipo_accion == 3 ) ) )
                    {
                    return null ;
                    }

                if ( strtolower( $id_proceso ) == 'hereda' )
                    {
                    $id_proceso = $id_proceso_actual ;
                    }
                if ( ( $id_proceso != $id_proceso_actual ) || ( self::$claseEntidad != $clase_gedee_proceso_actual ) || ( self::$namespaceEntidad != $namespace_gedee_proceso_actual ) )
                    {
                    $tipo_acceso = null ;

                    if ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'ambito' ] ) && ( ( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'ambito' ] == 'restrictivo' ) || ( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'ambito' ] == 'permisivo' ) ) )
                        {
                        $ambito_seguridad_operativo = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'ambito' ] ;
                        }
                    else
                        {
                        $ambito_seguridad_operativo = self::$ambitoSeguridad ;
                        }

                    if ( $ambito_seguridad_operativo == 'restrictivo' )
                        {
                        if ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ $id_proceso_actual ] ) )
                            {
                            $tipo_acceso = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ $id_proceso_actual ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ '*' ] ) )
                            {
                            $tipo_acceso = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ '*' ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ '*' ] ) )
                            {
                            $tipo_acceso = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ '*' ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ '*' ] ) )
                            {
                            $tipo_acceso = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ '*' ] ;
                            }
                        else
                            {
                            return null ;
                            }

                        $acceso_leer = null ;
                        $acceso_escribir = null ;
                        $acceso_eliminar = null ;

                        if ( is_string( $tipo_acceso ) )
                            {
                            $arreglo_acceso = explode( '::' , $tipo_acceso ) ;
                            foreach ( $arreglo_acceso as $elemento )
                                {
                                switch ( $elemento )
                                    {
                                    case 'leer' : $acceso_leer = 'leer' ;
                                        break ;
                                    case 'escribir' : $acceso_escribir = 'escribir' ;
                                        break ;
                                    case 'eliminar' : $acceso_eliminar = 'eliminar' ;
                                        break ;
                                    }
                                }
                            }

                        if ( ( ( $tipo_accion == 1 ) && ( $acceso_leer != 'leer' ) ) || ( ( $tipo_accion == 2 ) && ( $acceso_escribir != 'escribir' ) ) || ( ( $tipo_accion == 3 ) && ( $acceso_eliminar != 'eliminar' ) ) )
                            {
                            return null ;
                            }
                        }
                    elseif ( $ambito_seguridad_operativo == 'permisivo' )
                        {
                        if ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ $id_proceso_actual ] ) )
                            {
                            $varcorta = &$fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ $id_proceso_actual ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ '*' ] ) )
                            {
                            $varcorta = &$fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ '*' ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ '*' ] ) )
                            {
                            $varcorta = &$fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ '*' ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ '*' ] ) )
                            {
                            $varcorta = &$fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_seguridad' ][ 'procesos' ][ '*' ] ;
                            }
                        if ( isset( $varcorta ) )
                            {
                            if ( ( $varcorta == 'leer::escribir::eliminar' ) || ( $varcorta == 'leer::eliminar::escribir' ) || ( $varcorta == 'eliminar::leer::escribir' ) || ( $varcorta == 'eliminar::escribir::leer' ) || ( $varcorta == 'escribir::eliminar::leer' ) || ( $varcorta == 'escribir::leer::eliminar' ) )
                                {
                                return null ;
                                }

                            $tipo_acceso = $varcorta ;

                            $acceso_leer = 'leer' ;
                            $acceso_escribir = 'escribir' ;
                            $acceso_eliminar = 'eliminar' ;

                            if ( is_string( $tipo_acceso ) )
                                {
                                $arreglo_acceso = explode( '::' , $tipo_acceso ) ;
                                foreach ( $arreglo_acceso as $elemento )
                                    {
                                    switch ( $elemento )
                                        {
                                        case 'leer' : $acceso_leer = null ;
                                            break ;
                                        case 'escribir' : $acceso_escribir = null ;
                                            break ;
                                        case 'eliminar' : $acceso_eliminar = null ;
                                            break ;
                                        }
                                    }
                                }

                            if ( ( ( $tipo_accion == 1 ) && ( $acceso_leer != 'leer' ) ) || ( ( $tipo_accion == 2 ) && ( $acceso_escribir != 'escribir' ) ) || ( ( $tipo_accion == 3 ) && ( $acceso_eliminar != 'eliminar' ) ) )
                                {
                                return null ;
                                }
                            }
                        }
                    else
                        {
                        return null ;
                        }
                    }
                $La_resultado = null ;
                switch ( $tipo_accion )
                    {
                    case 1 : //leer

                        if ( is_array( $estructura_acceder ) && empty( $estructura_acceder ) )
                            {
                            $La_resultado = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ] ;
                            }
                        elseif ( is_string( $estructura_acceder ) && ( stripos( $estructura_acceder , ';' ) === false ) && ( stripos( $estructura_acceder , ')' ) === false ) && ( stripos( $estructura_acceder , '{' ) === false ) )
                            {

                            $cadena_ejecutar = " if ( isset( \$fuente_datos_procesos[self::\$namespaceEntidad][self::\$claseEntidad][\$id_proceso]$estructura_acceder ) )
				    {
				         \$La_resultado = \$fuente_datos_procesos[self::\$namespaceEntidad][self::\$claseEntidad][\$id_proceso]$estructura_acceder ;
				    }
			           	" ;
                            eval( $cadena_ejecutar ) ;
                            }

                        return $La_resultado ;
                        break ;

                    case 2 : //escribir o modificar
                        $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloModificarRecursivo( $estructura_acceder , $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ] , $condicion_modificacion ) ;
                        break ;

                    case 3 : //eliminar
                        $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloEliminarRecursivo( $estructura_acceder , $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ] , $condicion_modificacion ) ;
                        break ;
                    }
                if ( ( $tipo_accion != 1 ) && !empty( $La_resultado [ 'arreglo_base' ] ) )
                    {
                    $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ] = $La_resultado [ 'arreglo_base' ] ;
                    return true ;
                    }
                }
            return null ;
            }

        static public function clienteEjecucionProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' )
            {
            if ( !empty( self::$classIniciacion ) && !empty( $fuente_datos_procesos ) && !empty( $id_proceso ) )
                {
                $namespace_gedee_proceso_actual = self::$EEoNucleo->namespaceGedeeProcesoEjecucion() ;
                $clase_gedee_proceso_actual = self::$EEoNucleo->claseGedeeProcesoEjecucion() ;
                $id_proceso_actual = self::$EEoNucleo->idProcesoEjecucion() ;
                
                if ( strtolower( $id_proceso ) == 'hereda' )
                    {
                    $id_proceso = $id_proceso_actual ;
                    }

                $existencia_id_proceso_comun = self::existenciaIdProceso( $fuente_datos_procesos , $id_proceso ) ;
                if ( !empty( $existencia_id_proceso_comun ) )
                    {
                    if ( !empty( $fuente_datos_procesos[self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'permiso_ejecucion' ][ 'ambito' ] ) && ( ( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'permiso_ejecucion' ][ 'ambito' ] == 'retrictivo' ) || ( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'permiso_ejecucion' ][ 'ambito' ] == 'permisivo' ) ) )
                        {
                        $ambito_seguridad_operativo = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'permiso_ejecucion' ][ 'ambito' ] ;
                        }
                    else
                        {
                        $ambito_seguridad_operativo = self::$ambitoSeguridad ;
                        }

                    if ( $ambito_seguridad_operativo == 'restrictivo' )
                        {
                        if ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'permiso_ejecucion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ] ) && is_array( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'permiso_ejecucion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ] ) )
                            {
                            foreach ( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'permiso_ejecucion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ] as $proceso_cliente )
                                {
                                if ( ( $proceso_cliente == $id_proceso_actual ) || ( $proceso_cliente == '*' ) )
                                    {
                                    return 'ejecucion' ;
                                    }
                                }
                            }
                        if ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'permiso_ejecucion' ][ 'procesos' ][ '*' ] ) )
                            {
                            return 'ejecucion' ;
                            }
                        }
                    elseif ( $ambito_seguridad_operativo == 'permisivo' )
                        {
                        $ejecucion = true ;
                        if ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'permiso_ejecucion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ] ) && is_array( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'permiso_ejecucion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ] ) )
                            {
                            foreach ( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'permiso_ejecucion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ] as $proceso_cliente )
                                {
                                if ( ( $proceso_cliente == $id_proceso_actual ) || ( $proceso_cliente == '*' ) )
                                    {
                                    $ejecucion = false ;
                                    break ;
                                    }
                                }
                            }
                        if ( $ejecucion )
                            {
                            if ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'permiso_ejecucion' ][ 'procesos' ][ '*' ] ) )
                                {
                                $ejecucion = false ;
                                }
                            }
                        if ( $ejecucion == true )
                            {
                            return 'ejecucion' ;
                            }
                        }
                    }
                else
                    {
                    return 'ejecucion' ;
                    }
                }
            return null ;
            }

        static public function clienteAccesoDatosProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' )
            {
            if ( !empty( self::$classIniciacion ) && !empty( $fuente_datos_procesos ) && !empty( $id_proceso ) )
                {
                $namespace_gedee_proceso_actual = self::$EEoNucleo->namespaceGedeeProcesoEjecucion() ;
                $clase_gedee_proceso_actual = self::$EEoNucleo->claseGedeeProcesoEjecucion() ;
                $id_proceso_actual = self::$EEoNucleo->idProcesoEjecucion() ;
                
                if ( strtolower( $id_proceso ) == 'hereda' )
                    {
                    $id_proceso = $id_proceso_actual ;
                    }
                if ( !self::existenciaIdProceso( $fuente_datos_procesos , $id_proceso ) )
                    {
                    return null ;
                    }
                
                if ( ( $id_proceso != $id_proceso_actual ) || ( self::$claseEntidad != $clase_gedee_proceso_actual ) || ( self::$namespaceEntidad != $namespace_gedee_proceso_actual ) )
                    {
                    if ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'ambito' ] ) && ( ( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'ambito' ] == 'restrictivo' ) || ( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'ambito' ] == 'permisivo' ) ) )
                        {
                        $ambito_seguridad_operativo = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'ambito' ] ;
                        }
                    else
                        {
                        $ambito_seguridad_operativo = self::$ambitoSeguridad ;
                        }

                    if ( $ambito_seguridad_operativo == 'restrictivo' )
                        {
                        if ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ $id_proceso_actual ] ) )
                            {
                            return $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ $id_proceso_actual ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ '*' ] ) )
                            {
                            return $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ '*' ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ '*' ] ) )
                            {
                            return $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ '*' ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ '*' ] ) )
                            {
                            return $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ '*' ] ;
                            }
                        }
                    elseif ( $ambito_seguridad_operativo == 'permisivo' )
                        {
                        if ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ $id_proceso_actual ] ) )
                            {
                            $tipo_acceso = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ $id_proceso_actual ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ '*' ] ) )
                            {
                            $tipo_acceso = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ '*' ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ '*' ] ) )
                            {
                            $tipo_acceso = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ '*' ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ '*' ] ) )
                            {
                            $tipo_acceso = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_datos' ][ 'procesos' ][ '*' ] ;
                            }
                        else
                            {
                            return 'leer::escribir::eliminar' ;
                            }
                        if ( !empty( $tipo_acceso ) )
                            {
                            $acceso_leer = 'leer' ;
                            $acceso_escribir = 'escribir' ;
                            $acceso_eliminar = 'eliminar' ;

                            if ( is_string( $tipo_acceso ) )
                                {
                                $arreglo_acceso = explode( '::' , $tipo_acceso ) ;
                                foreach ( $arreglo_acceso as $elemento )
                                    {
                                    switch ( $elemento )
                                        {
                                        case 'leer' : $acceso_leer = null ;
                                            break ;
                                        case 'escribir' : $acceso_escribir = null ;
                                            break ;
                                        case 'eliminar' : $acceso_eliminar = null ;
                                            break ;
                                        }
                                    }
                                }
                            if ( !empty( $acceso_leer ) && (!empty( $acceso_escribir ) || !empty( $acceso_eliminar ) ) )
                                {
                                $acceso_leer.='::' ;
                                }
                            if ( !empty( $acceso_escribir ) && !empty( $acceso_eliminar ) )
                                {
                                $acceso_escribir.='::' ;
                                }
                            $tipo_acceso = $acceso_leer . $acceso_escribir . $acceso_eliminar ;
                            if ( !empty( $tipo_acceso ) )
                                {
                                return $tipo_acceso ;
                                }
                            }
                        }
                    }
                else
                    {
                    return 'leer::escribir::eliminar' ; 
                    }
                }
            return null ;
            }

        static public function clienteAccesoConfiguracionProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' )
            {
            if ( !empty( self::$classIniciacion ) && !empty( $fuente_datos_procesos ) && !empty( $id_proceso ) )
                {
                $namespace_gedee_proceso_actual = self::$EEoNucleo->namespaceGedeeProcesoEjecucion() ;
                $clase_gedee_proceso_actual = self::$EEoNucleo->claseGedeeProcesoEjecucion() ;
                $id_proceso_actual = self::$EEoNucleo->idProcesoEjecucion() ;
                
                if ( strtolower( $id_proceso ) == 'hereda' )
                    {
                    $id_proceso = $id_proceso_actual ;
                    }
                if ( !self::existenciaIdProceso( $fuente_datos_procesos , $id_proceso ) )
                    {
                    return null ;
                    }
                
                if ( ( $id_proceso != $id_proceso_actual ) || ( self::$claseEntidad != $clase_gedee_proceso_actual ) || ( self::$namespaceEntidad != $namespace_gedee_proceso_actual ) )
                    {
                    if ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'ambito' ] ) && ( ( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'ambito' ] == 'restrictivo' ) || ( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'ambito' ] == 'permisivo' ) ) )
                        {
                        $ambito_seguridad_operativo = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'ambito' ] ;
                        }
                    else
                        {
                        $ambito_seguridad_operativo = self::$ambitoSeguridad ;
                        }

                    if ( $ambito_seguridad_operativo == 'restrictivo' )
                        {
                        if ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ $id_proceso_actual ] ) )
                            {
                            return $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ $id_proceso_actual ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ '*' ] ) )
                            {
                            return $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ '*' ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ '*' ] ) )
                            {
                            return $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ '*' ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ '*' ] ) )
                            {
                            return $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ '*' ] ;
                            }
                        }
                    elseif ( $ambito_seguridad_operativo == 'permisivo' )
                        {
                        if ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ $id_proceso_actual ] ) )
                            {
                            $tipo_acceso = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ $id_proceso_actual ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ '*' ] ) )
                            {
                            $tipo_acceso = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ $clase_gedee_proceso_actual ][ '*' ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ '*' ] ) )
                            {
                            $tipo_acceso = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ $namespace_gedee_proceso_actual ][ '*' ] ;
                            }
                        elseif ( !empty( $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ '*' ] ) )
                            {
                            $tipo_acceso = $fuente_datos_procesos[ self::$namespaceEntidad ][ self::$claseEntidad ][ $id_proceso ][ 'acceso_configuracion' ][ 'procesos' ][ '*' ] ;
                            }
                        else
                            {
                            return 'leer::escribir::eliminar' ;
                            }
                        if ( !empty( $tipo_acceso ) )
                            {
                            $acceso_leer = 'leer' ;
                            $acceso_escribir = 'escribir' ;
                            $acceso_eliminar = 'eliminar' ;

                            if ( is_string( $tipo_acceso ) )
                                {
                                $arreglo_acceso = explode( '::' , $tipo_acceso ) ;
                                foreach ( $arreglo_acceso as $elemento )
                                    {
                                    switch ( $elemento )
                                        {
                                        case 'leer' : $acceso_leer = null ;
                                            break ;
                                        case 'escribir' : $acceso_escribir = null ;
                                            break ;
                                        case 'eliminar' : $acceso_eliminar = null ;
                                            break ;
                                        }
                                    }
                                }
                            if ( !empty( $acceso_leer ) && (!empty( $acceso_escribir ) || !empty( $acceso_eliminar ) ) )
                                {
                                $acceso_leer.='::' ;
                                }
                            if ( !empty( $acceso_escribir ) && !empty( $acceso_eliminar ) )
                                {
                                $acceso_escribir.='::' ;
                                }
                            $tipo_acceso = $acceso_leer . $acceso_escribir . $acceso_eliminar ;
                            if ( !empty( $tipo_acceso ) )
                                {
                                return $tipo_acceso ;
                                }
                            }
                        }
                    }
                else
                    {
                    return 'leer::escribir::eliminar' ; 
                    }
                }
            return null ;
            
            }

        static public function iniciarDatosSalidaProceso( &$fuente_datos_procesos , $datos_salida )
            {
            return self::iniciarDatosProceso( $fuente_datos_procesos , $datos_salida ) ;
            }

        static public function accederDatosSalidaProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' , $estructura_acceder = array( ) , $tipo_modificacion = 1 , $condicion_modificacion = 0 )
            {
            if ( !empty( self::$classIniciacion ) && !empty( $fuente_datos_procesos ) && !empty( $id_proceso ) && self::existenciaIdProceso( $fuente_datos_procesos , $id_proceso ) && ( ( $tipo_modificacion == 1 ) || ( $tipo_modificacion == 2 ) || ( $tipo_modificacion == 3 ) ) )
                {
                if ( empty( $estructura_acceder ) && ( ( $tipo_modificacion == 2 ) || ( $tipo_modificacion == 3 ) ) )
                    {
                    return null ;
                    }
                $namespace_gedee_proceso_actual = self::$EEoNucleo->namespaceGedeeProcesoEjecucion() ;
                $clase_gedee_proceso_actual = self::$EEoNucleo->claseGedeeProcesoEjecucion() ;
                $id_proceso_actual = self::$EEoNucleo->idProcesoEjecucion() ;
                
                if ( strtolower( $id_proceso ) == 'hereda' )
                    {
                    $id_proceso = $id_proceso_actual ;
                    }
                if ( ( $id_proceso != $id_proceso_actual ) || ( self::$claseEntidad != $clase_gedee_proceso_actual ) || ( self::$namespaceEntidad != $namespace_gedee_proceso_actual ) )
                    {
                    
                    $tipo_acceso = self::$EEoSeguridad->clienteAccesoDatosProceso( $id_proceso , self::$idEntidad ,self::$claseEntidad , self::$namespaceEntidad ) ;

                    if ( $tipo_acceso )
                        {
                        $acceso_leer = null ;
                        $acceso_escribir = null ;
                        $acceso_eliminar = null ;

                        if ( is_string( $tipo_acceso ) )
                            {
                            $arreglo_acceso = explode( '::' , $tipo_acceso ) ;
                            foreach ( $arreglo_acceso as $elemento )
                                {
                                switch ( $elemento )
                                    {
                                    case 'leer' : $acceso_leer = 'leer' ;
                                        break ;
                                    case 'escribir' : $acceso_escribir = 'escribir' ;
                                        break ;
                                    case 'eliminar' : $acceso_eliminar = 'eliminar' ;
                                        break ;
                                    }
                                }
                            }

                        if ( ( ( $tipo_modificacion == 1 ) && ( $acceso_leer != 'leer' ) ) || ( ( $tipo_modificacion == 2 ) && ( $acceso_escribir != 'escribir' ) ) || ( ( $tipo_modificacion == 3 ) && ( $acceso_eliminar != 'eliminar' ) ) )
                            {
                            return null ;
                            }
                        }
                    else
                        {
                        return null ;
                        }
                    }
                $La_resultado = null ;
                switch ( $tipo_modificacion )
                    {
                    case 1 : //leer
                        if ( is_array( $estructura_acceder ) && empty( $estructura_acceder ) )
                            {
                            $La_resultado = $fuente_datos_procesos[self::$namespaceEntidad][self::$claseEntidad][ $id_proceso ] ;
                            }
                        elseif ( is_string( $estructura_acceder ) && ( stripos( $estructura_acceder , ';' ) === false ) && ( stripos( $estructura_acceder , ')' ) === false ) && ( stripos( $estructura_acceder , '{' ) === false ) )
                            {

                            $cadena_ejecutar = " if ( isset( \$fuente_datos_procesos[self::\$namespaceEntidad][self::\$claseEntidad][\$id_proceso]$estructura_acceder ) )
				     {
				     \$La_resultado = \$fuente_datos_procesos[self::\$namespaceEntidad][self::\$claseEntidad][\$id_proceso]$estructura_acceder ;
				     }
		    		" ;
                            eval( $cadena_ejecutar ) ;
                            }
                        return $La_resultado ;

                    case 2 : //escribir o modificar
                        $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloModificarRecursivo( $estructura_acceder , $fuente_datos_procesos[self::$namespaceEntidad][self::$claseEntidad][ $id_proceso ] , $condicion_modificacion ) ;
                        break ;

                    case 3 : //eliminar
                        $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloEliminarRecursivo( $estructura_acceder , $fuente_datos_procesos[self::$namespaceEntidad][self::$claseEntidad][ $id_proceso ] , $condicion_modificacion ) ;
                        break ;
                    }
                if ( ( $tipo_modificacion != 1 ) && !empty( $La_resultado [ 'arreglo_base' ] ) )
                    {
                    $fuente_datos_procesos[self::$namespaceEntidad][self::$claseEntidad][ $id_proceso ] = $La_resultado [ 'arreglo_base' ] ;
                    return true ;
                    }
                }
            return null ;
            }

        }

?>		