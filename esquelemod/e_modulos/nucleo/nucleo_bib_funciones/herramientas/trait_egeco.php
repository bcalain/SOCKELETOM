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
   * GECO  trait
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */
  namespace Emod\Nucleo\Herramientas;
    
    trait GECO
        {

        protected static $EEoNucleo = null;
        ///////////////////////////////seccion seguridad//////////////////////////////////////////////
        protected static $lbGestionSeguridad = false;
        protected static $lbPropietarioEntidad = true;
        protected static $lsAmbitoSeguridad = null;
        protected static $lbActualizarDatosSeguridad = null;
        protected static $laDatosSeguridad = array( );
        ////////////////////////////////////////////////////////////////////////////////////////////// 

        protected static $lsPathDirRaizEntidades = null;
        protected static $iniciacion = null;
                                      
        protected static $laEntidades = array( );
        
        public static function iniciacion( $La_datos_iniciacion )
            {
            if ( empty( self::$iniciacion ) )
                {
                if ( is_object( \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ) )
                    {
                    self::$EEoNucleo = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' );
                    }
                else
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', no se encuentra referencia al objeto EEoNucleo para la definici&oacute;n de Entidades<p>' );
                    }

                if ( isset( $La_datos_iniciacion['seguridad']['gestion_seguridad'] ) && empty( $La_datos_iniciacion['seguridad']['gestion_seguridad'] ) && ( ( $La_datos_iniciacion['seguridad']['propietario_entidad'] == true ) || ( $La_datos_iniciacion['seguridad']['propietario_entidad'] == false ) ) )
                    {
                    self::$lbGestionSeguridad = false;
                    self::$lbPropietarioEntidad = $La_datos_iniciacion['seguridad']['propietario_entidad'];
                    }
                elseif ( !empty( $La_datos_iniciacion['seguridad']['gestion_seguridad'] )
                        && ( ( $La_datos_iniciacion['seguridad']['propietario_entidad'] == true ) || ( $La_datos_iniciacion['seguridad']['propietario_entidad'] == false ) )
                        && ( ( $La_datos_iniciacion['seguridad']['ambito_seguridad'] == 'permisivo' ) || ( $La_datos_iniciacion['seguridad']['ambito_seguridad'] == 'restrictivo' ) )
                        && ( ( $La_datos_iniciacion['seguridad']['actualizar_datos_seguridad'] == true ) || ( $La_datos_iniciacion['seguridad']['actualizar_datos_seguridad'] == false ) )
                       )
                    {
                    self::$lbGestionSeguridad = true;
                    self::$lbPropietarioEntidad = $La_datos_iniciacion['seguridad']['propietario_entidad'];
                    self::$lsAmbitoSeguridad = $La_datos_iniciacion['seguridad']['ambito_seguridad'];
                    self::$lbActualizarDatosSeguridad = $La_datos_iniciacion['seguridad']['actualizar_datos_seguridad'];
                    if ( !empty( $La_datos_iniciacion['seguridad']['datos_seguridad'] ) && is_array( $La_datos_iniciacion['seguridad']['datos_seguridad'] ) )
                        {
                        self::$laDatosSeguridad = $La_datos_iniciacion['seguridad']['datos_seguridad'];
                        }
                    }
                else
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', no se encuentran &oacute;ptimos los par&aacute;metros de seguridad para la iniciaci&oacute;n de esta entidad<p>' );
                    }

                if ( !empty( $La_datos_iniciacion['path_dir_raiz'] ) )
                    {
                    self::$lsPathDirRaizEntidades = $La_datos_iniciacion['path_dir_raiz'];
                    }
                else
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', no se encuentra el dato path_dir_raiz imprescindible para la iniciaci&oacute;n de esta entidad<p>' );
                    }
                self::$iniciacion = true ;
                return true ;    
                }
            return null;
            }
            
        public static function pathRaizEntidades()
            {
            if ( !empty( self::$iniciacion ) )
                {
                return self::$lsPathDirRaizEntidades;
                }
            return null;
            }

        public static function actualizarDatosSeguridadEntidades( $La_datos , $Ls_tipo_actualizacion )
            {
            $efectividad = null;
            if (
                    (!empty( self::$iniciacion ) || ( empty( self::$iniciacion ) && ( self::$EEoNucleo->gedeeProcesoNucleo() . '::' . self::$EEoNucleo->idProcesoNucleo() == self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion() ) ) )
                    && (
                    (
                    ( self::$EEoNucleo->gedeeProcesoNucleo() . '::' . self::$EEoNucleo->idProcesoNucleo() != self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion() )
                    && ( self::$lbActualizarDatosSeguridad == true )
                    )
                    || ( self::$EEoNucleo->gedeeProcesoNucleo() . '::' . self::$EEoNucleo->idProcesoNucleo() == self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion() )
                    )
                    && !empty( $La_datos )
                    && !empty( $Ls_tipo_actualizacion )
            )
                {

                switch ( $Ls_tipo_actualizacion )
                    {
                    case 'renovar' : self::$laDatosSeguridad = $La_datos;
                        $efectividad = true;
                        break;

                    case 'adicionar' : foreach ( $La_datos as $namespace => $valor_namespace )
                            {
                            if ( is_array( $valor_namespace ) && !empty( $valor_namespace ) )
                                {
                                if ( empty( self::$laDatosSeguridad[$namespace] ) )
                                    {
                                    self::$laDatosSeguridad[$namespace] = $valor_namespace;
                                    continue;
                                    }

                                foreach ( $valor_namespace as $clase_nueva )
                                    {
                                    if ( !empty( $clase_nueva ) )
                                        {
                                        $existe = false;
                                        foreach ( self::$laDatosSeguridad[$namespace] as $clase_existe )
                                            {
                                            if ( $clase_nueva == $clase_existe )
                                                {
                                                $existe = true;
                                                break;
                                                }
                                            }
                                        if ( !$existe )
                                            {
                                            self::$laDatosSeguridad[$namespace][] = $clase_nueva;
                                            if ( !$efectividad )
                                                {
                                                $efectividad = true;
                                            }
                                            }
                                        }
                                    }
                                }
                            }
                        break;

                    case 'eliminar' : foreach ( $La_datos as $namespace => $valor_namespace )
                            {
                            if ( is_array( $valor_namespace ) && !empty( $valor_namespace ) )
                                {
                                if ( empty( self::$laDatosSeguridad[$namespace] ) )
                                    {
                                    continue;
                                    }

                                foreach ( $valor_namespace as $clase_nueva )
                                    {
                                    if ( !empty( $clase_nueva ) )
                                        {
                                        $existe = false;
                                        foreach ( self::$laDatosSeguridad[$namespace] as &$clase_existe )
                                            {
                                            if ( $clase_nueva == $clase_existe )
                                                {
                                                unset( $clase_existe );
                                                if ( !$efectividad )
                                                    {
                                                    $efectividad = true;
                                                }
                                                break;
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        break;
                    }
                }
            return $efectividad;
            }

        public static function permisionEntidad( $Ls_namespace , $Ls_clase )
            {
            if ( (!empty( self::$iniciacion ) || ( empty( self::$iniciacion ) && ( self::$EEoNucleo->gedeeProcesoNucleo() . '::' . self::$EEoNucleo->idProcesoNucleo() == self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion() ) ) ) && !empty( $Ls_namespace ) && !empty( $Ls_clase ) && !empty( self::$lbGestionSeguridad ) )
                {
                if ( !empty( self::$lsAmbitoSeguridad ) && ( ( self::$lsAmbitoSeguridad == 'permisivo' ) || ( self::$lsAmbitoSeguridad == 'restrictivo' ) ) )
                    {
                    if ( self::$lsAmbitoSeguridad == 'permisivo' )
                        { 
                        if ( self::$laDatosSeguridad == '*' )
                            {
                            return null;
                            }
                        if ( !empty( self::$laDatosSeguridad[$Ls_namespace] ) )
                            {
                            if ( self::$laDatosSeguridad[$Ls_namespace] == '*' )
                                {
                                return null;
                                }
                            if ( is_array( self::$laDatosSeguridad[$Ls_namespace] ) )
                                {
                                $La_clases = self::$laDatosSeguridad[$Ls_namespace];
                                foreach ( $La_clases as $Ls_id_clase )
                                    {
                                    if ( $Ls_id_clase == $Ls_clase )
                                        {
                                        return null;
                                    }
                                    }
                                }
                            }
                        return true;
                        }
                    elseif ( self::$lsAmbitoSeguridad == 'restrictivo' )
                        {
                        if ( self::$laDatosSeguridad == '*' )
                            {
                            return true;
                            }
                        if ( !empty( self::$laDatosSeguridad[$Ls_namespace] ) )
                            {
                            if ( self::$laDatosSeguridad[$Ls_namespace] == '*' )
                                {
                                return true;
                                }
                            if ( is_array( self::$laDatosSeguridad[$Ls_namespace] ) )
                                {
                                $La_clases = self::$laDatosSeguridad[$Ls_namespace];
                                foreach ( $La_clases as $Ls_id_clase )
                                    {
                                    if ( $Ls_id_clase == $Ls_clase )
                                        {
                                        return true;
                                    }
                                    }
                                }
                            }
                        }
                    }
                else
                    {
                    exit( '<p>ERROR FATAL, ' . __METHOD__ . ', el valor del par&aacute;metro &aacute;mbito de este procedimiento presenta incompatibilidades<p>' );
                    }
                }
            return null;
            }

        public static function gestionControlIngresoEntidad( $Ls_path_control_entidad , $Ls_referencia_path_control = 'relativo' , $Ls_namespace = null , $Ls_clase = null , $Ls_path_entidad_clase = null , $Ls_referencia_path_entidad = null , $Ls_tipo_entidad = null , $La_instancias = null , $Ls_iniciacion = null )
            {
            if ( (!empty( self::$iniciacion ) || ( empty( self::$iniciacion ) && ( self::$EEoNucleo->gedeeProcesoNucleo() . '::' . self::$EEoNucleo->idProcesoNucleo() == self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion() ) ) ) && !empty( $Ls_path_control_entidad ) && ( ( $Ls_referencia_path_control == 'absoluto' ) || ( $Ls_referencia_path_control == 'relativo_esquelemod' ) || ( $Ls_referencia_path_control == 'relativo' ) ) )
                {
                $Ls_path_control_entidad_final = null;
                
                if ( $Ls_referencia_path_control == 'relativo' && is_file( self::$EEoNucleo->pathDirEsquelemod() . '/e_modulos/' . self::$lsPathDirRaizEntidades . '/' . $Ls_path_control_entidad ) )
                    {
                    $Ls_path_control_entidad_final = self::$EEoNucleo->pathDirEsquelemod() . '/e_modulos/' . self::$lsPathDirRaizEntidades . '/' . $Ls_path_control_entidad;
                    }
                if ( $Ls_referencia_path_control == 'relativo_esquelemod' && is_file( self::$EEoNucleo->pathDirEsquelemod() . '/' . $Ls_path_control_entidad ) )
                    {
                    $Ls_path_control_entidad_final = self::$EEoNucleo->pathDirEsquelemod() . '/' . $Ls_path_control_entidad;
                    }
                if ( $Ls_referencia_path_control == 'absoluto' && is_file( $Ls_path_control_entidad ) )
                    {
                    $Ls_path_control_entidad_final = $Ls_path_control_entidad;
                    }
                
                if ( !empty( $Ls_path_control_entidad_final ) && !empty( $Ls_namespace ) && !empty( $Ls_clase ) && !empty( $Ls_path_entidad_clase ) && !empty( $Ls_referencia_path_entidad ) && !empty( $Ls_tipo_entidad ) && !empty( $La_instancias ) && is_array( $La_instancias ) )
                    {
                    if ( empty( self::$lbGestionSeguridad ) || (!empty( self::$lbGestionSeguridad ) && self::permisionEntidad( $Ls_namespace , $Ls_clase ) ) )
                        {
                        require_once $Ls_path_control_entidad_final;
                        return self::gestionIngresoEntidad( $Ls_namespace , $Ls_clase , $Ls_path_entidad_clase , $Ls_referencia_path_entidad , $Ls_tipo_entidad , $La_instancias , $Ls_iniciacion );
                        }
                    return null;
                    }

                $La_resultado_require = require_once $Ls_path_control_entidad_final;
                				        
                if (
                        !empty( $La_resultado_require['namespace'] )
                        && !empty( $La_resultado_require['clase'] )
                        && !isset( self::$laEntidades[$La_resultado_require['namespace']][$La_resultado_require['clase']] )
                        && ( empty( self::$lbGestionSeguridad )
                        || (!empty( self::$lbGestionSeguridad )
                        && self::permisionEntidad( $La_resultado_require['namespace'] , $La_resultado_require['clase'] ) ) )
                        && !empty( $La_resultado_require['path_entidad_clase'] )
                        && !empty( $La_resultado_require['tipo_entidad'] )
                        && is_file( $La_resultado_require['path_entidad_clase'] )
                        && !empty( $La_resultado_require['instancias'] )
                        && is_array( $La_resultado_require['instancias'] )
                )
                    {
              
                    if ( empty( $La_resultado_require['referencia_path_entidad'] ) )
                        {   
                        self::$laEntidades[$La_resultado_require['namespace']][$La_resultado_require['clase']]['path_entidad_clase'] = $La_resultado_require['path_entidad_clase'];
                        self::$laEntidades[$La_resultado_require['namespace']][$La_resultado_require['clase']]['tipo_entidad'] = $La_resultado_require['tipo_entidad'];
                        if ( !empty( $La_resultado_require['iniciacion'] ) )
                            {
                            self::$laEntidades[$La_resultado_require['namespace']][$La_resultado_require['clase']]['iniciacion'] = $La_resultado_require['iniciacion'];
                            }
                        self::$laEntidades[$La_resultado_require['namespace']][$La_resultado_require['clase']]['instancias'] = $La_resultado_require['instancias'];
                        
                        foreach ( self::$laEntidades[$La_resultado_require['namespace']][$La_resultado_require['clase']]['instancias'] as $id_entidad => &$elementos_propios_entidad )
                            {
                            if ( !empty( self::$lbPropietarioEntidad ) )
                                {
                                $elementos_propios_entidad['proceso_propietario'] = self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion();
                                }
                            }

                        if ( !empty( self::$lbPropietarioEntidad ) )
                            {
                            self::$laEntidades[$La_resultado_require['namespace']][$La_resultado_require['clase']]['proceso_propietario'] = self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion();
                        }


                        return true;
                        }
                    elseif ( !empty( $La_resultado_require['referencia_path_entidad'] ) )
                        {
                        $existencia_elemento   = null;
                        $inexistencia_elemento = null;
                        foreach ( $La_resultado_require['instancias'] as $id_entidad => &$elementos_propios_entidad )
                        {
                        if ( $La_resultado_require['tipo_entidad'] == 'clase' )
                            {
                            if ( !empty( $elementos_propios_entidad['registro'] ) )
                                {
                                $existencia_elemento = true;
                                }
                            }
                        elseif ( $La_resultado_require['tipo_entidad'] == 'objeto' )
                            {
                            if ( !empty( $elementos_propios_entidad['objeto'] ) )
                                {
                                $existencia_elemento = true;
                                }
                            }
                        if ( $existencia_elemento )
                            {
                                trigger_error('Instancias de la entidad con valores incompatibles' , E_USER_WARNING );
                                return null;
                            }    
                        }
                        if ( !empty( $La_resultado_require['iniciacion'] ) )
                                {
                                $La_resultado_require['iniciacion'] = null;
                                }

                        return self::gestionIngresoEntidad( $La_resultado_require['namespace'] , $La_resultado_require['clase'] , $La_resultado_require['path_entidad_clase'] , $La_resultado_require['referencia_path_entidad'] , $La_resultado_require['tipo_entidad'] , $La_resultado_require['instancias'] , $La_resultado_require['iniciacion'] );
                           
                        }
                    }
                }
            return null;
            }

        public static function gestionIngresoEntidad( $Ls_namespace , $Ls_clase , $Ls_path_entidad_clase , $Ls_referencia_path_entidad , $Ls_tipo_entidad , $La_instancias , $Ls_iniciacion = null )
            {
            if ( (!empty( self::$iniciacion ) || ( empty( self::$iniciacion ) && ( self::$EEoNucleo->gedeeProcesoNucleo() . '::' . self::$EEoNucleo->idProcesoNucleo() == self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion() ) ) ) && !empty( $Ls_namespace ) && !empty( $Ls_clase ) && !isset( self::$laEntidades[$Ls_namespace][$Ls_clase] ) && !empty( $Ls_path_entidad_clase ) && !empty( $Ls_referencia_path_entidad ) && ( ( $Ls_referencia_path_entidad == 'absoluto' ) || ( $Ls_referencia_path_entidad == 'relativo_esquelemod' ) || ( $Ls_referencia_path_entidad == 'relativo' ) ) && !empty( $Ls_tipo_entidad ) && ( ( $Ls_tipo_entidad == 'clase' ) || ( $Ls_tipo_entidad == 'objeto' ) ) && !empty( $La_instancias ) && is_array( $La_instancias ) && ( empty( self::$lbGestionSeguridad ) || (!empty( self::$lbGestionSeguridad ) && self::permisionEntidad( $Ls_namespace , $Ls_clase ) ) ) )
                {
                if ( $Ls_referencia_path_entidad == 'relativo' )
                    {
                    $path_fich_class = self::$EEoNucleo->pathDirEsquelemod() . '/e_modulos/' . self::$lsPathDirRaizEntidades . '/' . $Ls_path_entidad_clase;
                    }
                elseif ( $Ls_referencia_path_entidad == 'relativo_esquelemod' )
                    {
                    $path_fich_class = self::$EEoNucleo->pathDirEsquelemod() . '/' . $Ls_path_entidad_clase;
                    }
                else
                    {
                    $path_fich_class = $Ls_path_entidad_clase;
                    }
                if ( is_file( $path_fich_class ) )
                    {
                    self::$laEntidades[$Ls_namespace][$Ls_clase]['path_entidad_clase'] = $path_fich_class;
                    self::$laEntidades[$Ls_namespace][$Ls_clase]['tipo_entidad'] = $Ls_tipo_entidad;
                    if ( !empty( $Ls_iniciacion ) )
                        {
                        self::$laEntidades[$Ls_namespace][$Ls_clase]['iniciacion'] = $Ls_iniciacion;
                        }

                    foreach ( $La_instancias as $id_entidad => $elementos_propios_entidad )
                        {
                        if ( !empty( $elementos_propios_entidad ) && is_array( $elementos_propios_entidad ) )
                            {
                            self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$id_entidad] = $elementos_propios_entidad;
                            }
                        else
                            {
                            self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$id_entidad] = array( );
                            }

                        if ( !empty( self::$lbPropietarioEntidad ) )
                            {
                            self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$id_entidad]['proceso_propietario'] = self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion();
                            }
                        }

                    if ( !empty( self::$lbPropietarioEntidad ) )
                        {
                        self::$laEntidades[$Ls_namespace][$Ls_clase]['proceso_propietario'] = self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion();
                    }

                    return true;
                    }
                }
            return null;
            }

        public static function gestionIngresosEntidades( $La_propiedades_entidades )
            {
            $entidad_entrante = null;  
            if ( (!empty( self::$iniciacion ) || ( empty( self::$iniciacion ) && ( self::$EEoNucleo->gedeeProcesoNucleo() . '::' . self::$EEoNucleo->idProcesoNucleo() == self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion() ) ) ) && !empty( $La_propiedades_entidades ) && is_array( $La_propiedades_entidades ) )
                {
                foreach ( $La_propiedades_entidades as $namespace => $valor_namespace )
                    {
                    if ( !empty( $valor_namespace ) && is_array( $valor_namespace ) )
                        {
                        foreach ( $valor_namespace as $clase => $valor_clase )
                            {
                            if ( !empty( $valor_clase["path_control"] ) && ( empty( self::$lbGestionSeguridad ) || (!empty( self::$lbGestionSeguridad ) && self::permisionEntidad( $namespace , $clase ) ) ) )
                                {
                                $efectividad             = false;
                                $referencia_path_control = (!empty( $valor_clase['referencia_path_control'] ) ) ? $valor_clase['referencia_path_control'] : 'relativo';
                                if (
                                        !empty( $valor_clase['path_entidad_clase'] )
                                        && !empty( $valor_clase['referencia_path_entidad'] )
                                        && !empty( $valor_clase['tipo_entidad'] )
                                        && (
                                        ( $valor_clase['tipo_entidad'] == 'clase' )
                                        || ( $valor_clase['tipo_entidad'] == 'objeto' )
                                        )
                                        && !empty( $valor_clase['instancias'] )
                                        && is_array( $valor_clase['instancias'] )
                                )
                                    {
                                    if ( empty( $valor_clase['iniciacion'] ) )
                                        {
                                        $valor_clase['iniciacion'] = null;
                                    }
                                    $efectividad = self::gestionControlIngresoEntidad( $valor_clase['path_control'] , $referencia_path_control , $namespace , $clase , $valor_clase['path_entidad_clase'] , $valor_clase['referencia_path_entidad'] , $valor_clase['tipo_entidad'] , $valor_clase['instancias'] , $valor_clase['iniciacion'] );
                                    }
                                else
                                    {
                                    $efectividad = self::gestionControlIngresoEntidad( $valor_clase['path_control'] , $referencia_path_control );
                                    }

                                if ( !$entidad_entrante && $efectividad )
                                    {
                                    $entidad_entrante = true;
                                    }
                                }
                            elseif (
                                    !empty( $valor_clase['path_entidad_clase'] )
                                    && !empty( $valor_clase['referencia_path_entidad'] )
                                    && !empty( $valor_clase['tipo_entidad'] )
                                    && (
                                    ( $valor_clase['tipo_entidad'] == 'clase' )
                                    || ( $valor_clase['tipo_entidad'] == 'objeto' )
                                    )
                                    && !empty( $valor_clase['instancias'] )
                                    && is_array( $valor_clase['instancias'] )
                                    && (
                                    empty( self::$lbGestionSeguridad )
                                    || (
                                    !empty( self::$lbGestionSeguridad )
                                    && self::permisionEntidad( $namespace , $clase )
                                    )
                                    )
                            )
                                {
                                if ( empty( $valor_clase['iniciacion'] ) )
                                    {
                                    $valor_clase['iniciacion'] = null;
                                    }
                                    
                                $efectividad = self::gestionIngresoEntidad( $namespace , $clase , $valor_clase['path_entidad_clase'] , $valor_clase['referencia_path_entidad'] , $valor_clase['tipo_entidad'] , $valor_clase['instancias'] , $valor_clase['iniciacion'] );
                                
                                if ( !$entidad_entrante && $efectividad )
                                    {
                                    $entidad_entrante = true;
                                    }
                                }
                            }
                        }
                    }
                }
            return $entidad_entrante;
            }

        public static function existenciaEntidad( $Ls_namespace , $Ls_clase , $Ls_id_entidad = null )
            {
            if ( !empty( self::$iniciacion ) && !empty( $Ls_namespace ) && !empty( $Ls_clase ) )
                {
                if ( ( !empty( $Ls_id_entidad ) && isset( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad] ) ) || ( empty( $Ls_id_entidad ) && isset( self::$laEntidades[$Ls_namespace][$Ls_clase] ) ) )
                    {
                    return self::$laEntidades[$Ls_namespace][$Ls_clase]['tipo_entidad'];
                    }
                }
            return null;
            }

        public static function ingresarEntidad( $Ls_namespace , $Ls_clase , $Ls_id_entidad , $La_parametros_iniciacion = null )
            {
            if ( !empty( self::$iniciacion ) && !empty( $Ls_namespace ) && !empty( $Ls_clase ) && !empty( $Ls_id_entidad ) && isset( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'] ) )
                {
                  if ( self::$laEntidades[$Ls_namespace][$Ls_clase]['tipo_entidad'] == 'objeto' )
                    {
                     self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][] = $Ls_id_entidad ;
                     if ( !empty( $La_parametros_iniciacion ) && is_array( $La_parametros_iniciacion ) )
                         {
                         self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['parametros_iniciacion'] = $La_parametros_iniciacion ;
                         }
                    }
                  elseif( self::$laEntidades[$Ls_namespace][$Ls_clase]['tipo_entidad'] == 'clase' )
                      {
                      self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][] = $Ls_id_entidad ;
                      }
                  if ( !empty( self::$lbPropietarioEntidad ) )
                      {
                      self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['proceso_propietario'] = self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion();
                      }
                }
            return null ;   
            }

        public static function entidad( $Ls_namespace , $Ls_clase , $Ls_id_entidad , $Ls_tipo_referencia = 'referencia' )
            {
            if ( !empty( self::$iniciacion ) && !empty( $Ls_namespace ) && !empty( $Ls_clase ) && !empty( $Ls_id_entidad ) && isset( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad] ) )
                {
                try {
               
                if ( self::$laEntidades[$Ls_namespace][$Ls_clase]['tipo_entidad'] == 'objeto' )
                    {
                    if ( !isset( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['objeto'] ) || !( is_object( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['objeto'] ) ) )
                        {
                        $clase_existe = class_exists( $Ls_namespace . '\\' . $Ls_clase );
                        
                        if ( !$clase_existe )
                            {
                            include self::$laEntidades[$Ls_namespace][$Ls_clase]['path_entidad_clase'];
                            $clase_existe = class_exists( $Ls_namespace . '\\' . $Ls_clase );
                            }

                        if ( $clase_existe )
                            { 
                            
                            $entidad = $Ls_namespace . '\\' . $Ls_clase;
                            
                            if ( !empty( self::$laEntidades[$Ls_namespace][$Ls_clase]['iniciacion'] ) && ( self::$laEntidades[$Ls_namespace][$Ls_clase]['iniciacion'] == 'construct' ) && !empty( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['parametros_iniciacion'] ) && is_array( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['parametros_iniciacion'] ) )
                                {
                                $Ls_instanciando    = '$objeto = new $entidad(';
                                $Li_cant_parametros = count( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['parametros_iniciacion'] );
                                for ( $Li_contador = 0; $Li_contador < $Li_cant_parametros; $Li_contador++ )
                                    {
                                    $Ls_instanciando.= 'self::$laEntidades[$Ls_namespace][$Ls_clase][\'instancias\'][$Ls_id_entidad][\'parametros_iniciacion\']' . "[$Li_contador]";
                                    if ( $Li_contador < ( $Li_cant_parametros - 1 ) )
                                        {
                                        $Ls_instanciando.= ' , ';
                                        }
                                    else
                                        {
                                        $Ls_instanciando.= ' ) ; ';
                                        }
                                    }
                                    
                                eval( $Ls_instanciando );
                                unset( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['parametros_iniciacion'] );
                                }
                            elseif ( !empty( self::$laEntidades[$Ls_namespace][$Ls_clase]['iniciacion'] ) && method_exists( $Ls_namespace . '\\' . $Ls_clase , self::$laEntidades[$Ls_namespace][$Ls_clase]['iniciacion'] ) && !empty( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['parametros_iniciacion'] ) && is_array( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['parametros_iniciacion'] ) )
                                {
                                $objeto             = new $entidad();
                                $Ls_iniciando       = '$objeto->' . self::$laEntidades[$Ls_namespace][$Ls_clase]['iniciacion'] . '(';
                                $Li_cant_parametros = count( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['parametros_iniciacion'] );

                                for ( $Li_contador = 0; $Li_contador < $Li_cant_parametros; $Li_contador++ )
                                    {
                                    $Ls_iniciando.= 'self::$laEntidades[$Ls_namespace][$Ls_clase][\'instancias\'][$Ls_id_entidad][\'parametros_iniciacion\']' . "[$Li_contador]";
                                    if ( $Li_contador < ( $Li_cant_parametros - 1 ) )
                                        {
                                        $Ls_iniciando.= ' , ';
                                        }
                                    else
                                        {
                                        $Ls_iniciando.= ' ) ; ';
                                        }
                                    }
                                
                                eval( $Ls_iniciando );
                                unset( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['parametros_iniciacion'] );
                                }
                            elseif ( !empty( self::$laEntidades[$Ls_namespace][$Ls_clase]['iniciacion'] ) && method_exists( $Ls_namespace . '\\' . $Ls_clase , self::$laEntidades[$Ls_namespace][$Ls_clase]['iniciacion'] ) && empty( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['parametros_iniciacion'] ) )
                                {
                                $objeto       = new $entidad();
                                $Ls_iniciando = '$objeto->' . self::$laEntidades[$Ls_namespace][$Ls_clase]['iniciacion'] . '() ;';
                                eval( $Ls_iniciando );
                                }
                            elseif( empty( self::$laEntidades[$Ls_namespace][$Ls_clase]['iniciacion'] ) )
                                {
                                $objeto = new $entidad();
                                }
                            else
                                {
                                return null;
                                }
                                
                                
                                
                            self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['objeto'] = &$objeto;
                            }
                        else
                            {
                            echo "<p>ADVERTENCIA, procedimiento: " . __METHOD__ . ", no se encontr&oacute; la namespace\\clase: $Ls_namespace\\$Ls_clase de la entidad a generar <p>";
                            return null;
                            }
                        }
                    if ( $Ls_tipo_referencia == 'referencia' )
                        {
                        return self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['objeto'];
                        }
                    elseif ( $Ls_tipo_referencia == 'clon' )
                        {
                        $clon = clone self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['objeto'];
                        return $clon;
                        }
                    }
                elseif ( self::$laEntidades[$Ls_namespace][$Ls_clase]['tipo_entidad'] == 'clase' )
                    {
                    $clase_existe = class_exists( $Ls_namespace . '\\' . $Ls_clase );
                    
                    if ( !$clase_existe )
                        {
                        include self::$laEntidades[$Ls_namespace][$Ls_clase]['path_entidad_clase'];
                        $clase_existe = class_exists( $Ls_namespace . '\\' . $Ls_clase );
                        }
                    if ( $clase_existe )
                        {
                           if ( !empty( self::$laEntidades[$Ls_namespace][$Ls_clase]['iniciacion'] ) && ( self::$laEntidades[$Ls_namespace][$Ls_clase]['iniciacion'] != 'construct' ) )
                                {
                                if( !method_exists( $Ls_namespace . '\\' . $Ls_clase , self::$laEntidades[$Ls_namespace][$Ls_clase]['iniciacion'] ) || empty( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['parametros_iniciacion'] ) || !is_array( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['parametros_iniciacion'] ) )
                                    {
                                    return null ;
                                    }        
                                reset( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'] );
                                $llave_primera_instancias = key( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'] );
                                
                                if ( $Ls_id_entidad == $llave_primera_instancias )
                                    {
                                    $Ls_iniciando       = $Ls_namespace . '\\' . $Ls_clase . '::' . self::$laEntidades[$Ls_namespace][$Ls_clase]['iniciacion'] . '(';
                                    $Li_cant_parametros = count( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['parametros_iniciacion'] );

                                    for ( $Li_contador = 0; $Li_contador < $Li_cant_parametros; $Li_contador++ )
                                        {
                                        $Ls_iniciando.= 'self::$laEntidades[$Ls_namespace][$Ls_clase][\'instancias\'][$Ls_id_entidad][\'parametros_iniciacion\']' . "[$Li_contador]";
                                        if ( $Li_contador < ( $Li_cant_parametros - 1 ) )
                                            {
                                            $Ls_iniciando.= ' , ';
                                            }
                                        else
                                            {
                                            $Ls_iniciando.= ' ) ; ';
                                            }
                                        }
                                    eval( $Ls_iniciando );
                                    unset( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['parametros_iniciacion'] );
                                    }
                                }
                            self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['registro'] = true; 
                            
                            return $Ls_namespace . '\\' . $Ls_clase ;
                            
                        }
                    }
                }
                catch( \Exception $e)
                {
                    echo '<p>Excepci&oacute;n capturada: '.$e->getMessage(). "<p>" ;
                    
                }
                }
                
            return null;
            }

        public static function datosEntidad( $Ls_namespace , $Ls_clase , $Ls_id_entidad )
            {
            if ( !empty( self::$iniciacion ) && !empty( $Ls_namespace ) && !empty( $Ls_clase ) && !empty( $Ls_id_entidad ) )
                {
                if ( !empty( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['datos'] ) )
                    {
                    return self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['datos'];
                    }
                }
            return null;
            }

        public static function idEntidades( $Ls_namespace , $Ls_clase )
            {
            if ( !empty( self::$iniciacion ) && !empty( $Ls_namespace ) && !empty( $Ls_clase ) )
                {
                if ( !empty( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'] ) )
                    {
                    return array_keys( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'] );
                    }
                }
            return null;
            }

        public static function eliminarEntidad( $Ls_namespace , $Ls_clase , $Ls_id_entidad = null )
            {
            if ( !empty( self::$iniciacion ) && !empty( $Ls_namespace ) && !empty( $Ls_clase ) )
                {
                if ( !empty( $Ls_id_entidad ) )
                    {
                    if ( !empty( self::$lbPropietarioEntidad ) )
                        {
                        if ( ( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad]['proceso_propietario'] == self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion() ) || ( self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion() == self::$EEoNucleo->gedeeProcesoNucleo() . '::' . self::$EEoNucleo->idProcesoNucleo() ) )
                            {
                            unset( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad] );
                            return true;
                            }
                        }
                    else
                        {
                        unset( self::$laEntidades[$Ls_namespace][$Ls_clase]['instancias'][$Ls_id_entidad] );
                        return true;
                        }
                    }
                else
                    {
                    if ( !empty( self::$lbPropietarioEntidad ) )
                        {
                        if ( ( self::$laEntidades[$Ls_namespace][$Ls_clase]['proceso_propietario'] == self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion() ) || ( self::$EEoNucleo->gedeeProcesoEjecucion() . '::' . self::$EEoNucleo->idProcesoEjecucion() == self::$EEoNucleo->gedeeProcesoNucleo() . '::' . self::$EEoNucleo->idProcesoNucleo() ) )
                            {
                            unset( self::$laEntidades[$Ls_namespace][$Ls_clase] );
                            return true;
                            }
                        }
                    else
                        {
                        unset( self::$laEntidades[$Ls_namespace][$Ls_clase] );
                        return true;
                        }
                    }
                }
            return null;
            }

        }

?>
