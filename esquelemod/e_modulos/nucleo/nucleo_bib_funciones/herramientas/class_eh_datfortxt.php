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
   * EDatosFormatoTxt class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */
    namespace Emod\Nucleo\Herramientas ;

    class EDatosFormatoTxt
    {

        public static function crearNuevaLinea( $Ls_path_fich, $Ls_linea )
        {
            if ( empty($Ls_path_fich) || empty($Ls_linea) )
            {
                return null ;
            }
            return file_put_contents( $Ls_path_fich, $Ls_linea, FILE_APPEND ) ;
        }

        public static function filtrarEliminarLineaDatos( $La_estructura_llaves_base, $La_estructura_filtro, $Ls_separador, $Ls_path_fich, $Ls_llave_unica = null )
        {
            if ( !is_array($La_estructura_llaves_base) || empty($La_estructura_llaves_base) || !is_array($La_estructura_filtro) || empty($La_estructura_filtro) || empty($Ls_separador) || empty($Ls_path_fich) )
            {
                return null ;
            }
            if ( $Lp_fichero = fopen( $Ls_path_fich , "r+") )
            {
                $Ls_contenido_fich = '' ;
                $fin_filtrado = false ;
                $condicion1 = false ;
                
                while ( !feof($Lp_fichero) )
                {
                    if ( $Ls_buffer = fgets($Lp_fichero, 4096) )
                    {
                        $La_buffer = explode( $Ls_separador, $Ls_buffer ) ;
                        if ( count($La_buffer) < 2 )
                        {
                            continue ;
                        }
                        if ( $fin_filtrado == true )
                        {
                            $Ls_contenido_fich .= $Ls_buffer ;
                            continue ;
                        }
                        foreach ( $La_buffer as & $Ls_valor )
                        {
                            $Ls_valor = trim( $Ls_valor ) ;
                        }
                        $La_miembro_valor = array_combine( $La_estructura_llaves_base, $La_buffer ) ;

                        $condicion2 = true ;
                        $condicion3 = false ;

                        
                        foreach ( $La_estructura_filtro as $key_miembrocomp => &$Ls_valor_miembrocomp )
                        {
                            $key_miembrocomp = trim( $key_miembrocomp ) ;
                            $Ls_valor_miembrocomp = trim( $Ls_valor_miembrocomp ) ;
                            if ( !empty($Ls_valor_miembrocomp) && !empty($La_miembro_valor[$key_miembrocomp]) )
                            {
                                $condicion2 = ( $condicion2 && ($Ls_valor_miembrocomp == $La_miembro_valor[$key_miembrocomp]) ) ;
                                $condicion3 = $condicion2 ;
                               
                                if ( !empty($Ls_llave_unica) && $condicion2 && ($key_miembrocomp == $Ls_llave_unica) )
                                {
                                    $fin_filtrado = true ;
                                    break ;
                                }
                            }
                        }
                        
                        if ( (!$condicion1 && $condicion3) || $fin_filtrado )
                        {
                            $condicion1 = true ;
                        }

                        
                        if ( $condicion3 || $fin_filtrado )
                        {
                            continue ;
                        }
                        $Ls_contenido_fich .= $Ls_buffer ;
                    }
                }
                fclose( $Lp_fichero ) ;
            }

            
            if ( $condicion1 )
            {
                if ( !empty($Ls_contenido_fich) && file_put_contents($Ls_path_fich, $Ls_contenido_fich) )
                {
                    return true ;
                }
                else
                {
                    return false ;
                }
            }
            else
            {
                return null ;
            }
        }

        public static function filtrarLeerLineaDatos( $La_estructura_llaves_base, $La_estructura_filtro, $Ls_separador, $Ls_path_fich, $Ls_llave_unica = null, $tipo_retorno = 'txt' )
        {
            if ( !is_array($La_estructura_llaves_base) || empty($La_estructura_llaves_base) || !is_array($La_estructura_filtro) || empty($La_estructura_filtro) || empty($Ls_separador) || empty($Ls_path_fich) )
            {
                echo 'Error, se han introducido valores incompatibles como parametros en la funcion . <p>' ;
                return null ;
            }
            if ( $Lp_fichero = fopen($Ls_path_fich, "r") )
            {
                $fin_filtrado = false ;
                while ( !feof($Lp_fichero) )
                {
                    if ( $Ls_buffer = fgets($Lp_fichero, 4096) )
                    {
                        $La_buffer = explode( $Ls_separador, $Ls_buffer ) ;
                        if ( count($La_buffer) < 2 )
                        {
                            continue ;
                        }
                        foreach ( $La_buffer as & $Ls_valor )
                        {
                            $Ls_valor = trim( $Ls_valor ) ;
                        }
                    
                        $La_miembro_valor = array_combine( $La_estructura_llaves_base, $La_buffer ) ;

                        $condicion2 = false ;

                        foreach ( $La_estructura_filtro as $key_miembrocomp => $Ls_valor_miembrocomp )
                        {
                            $key_miembrocomp = trim( $key_miembrocomp ) ;
                            $Ls_valor_miembrocomp = trim( $Ls_valor_miembrocomp ) ;
                            
                            if ( !empty($Ls_valor_miembrocomp) && !empty($La_miembro_valor[$key_miembrocomp]) )
                            {
                                $condicion2 = ( $Ls_valor_miembrocomp == $La_miembro_valor[$key_miembrocomp] ) ;
                                
                                if ( !empty($Ls_llave_unica) && $condicion2 && ($key_miembrocomp == $Ls_llave_unica) )
                                {
                                    $fin_filtrado = true ;
                                    break ;
                                }
                            }
                        }
                        if ( $condicion2 )
                        {
                            if ( $tipo_retorno == 'txt' )
                            	{
                        			$La_datos_result[] = $Ls_buffer ;
                            	}
                            elseif ($tipo_retorno == 'array')
                            	{
                            		$La_datos_result[] = $La_buffer ;
                            	}
                            elseif ($tipo_retorno == 'array_key_valor')
                            	{
                            		$La_datos_result[] = $La_miembro_valor ;
                            	}
                            if ( $fin_filtrado )
                            {
                                break ;
                            }
                        }
                    }
                }
                fclose( $Lp_fichero ) ;
                if ( !empty( $La_datos_result ) )
                {
                    return $La_datos_result ;
                }
            }
            return null ;
        }

        public static function fltrarModificarLineaDatos( $La_estructura_llaves_base, $La_estructura_filtro, $La_estructura_sustituta, $Ls_separador, $Ls_path_fich, $Ls_llave_unica = null )
        {   
            if ( !is_array($La_estructura_llaves_base) || empty($La_estructura_llaves_base) || ( !is_array($La_estructura_filtro) && ( $La_estructura_filtro != '*' ) ) || empty($La_estructura_filtro) || !is_array($La_estructura_sustituta) || empty($La_estructura_sustituta) || empty($Ls_separador) || empty($Ls_path_fich) )
            {
                echo 'Error, se han introducido valores incompatibles como parametros en la funcion . <p>' ;
                return null ;
            }
            if ( $Lp_fichero = fopen($Ls_path_fich, "r+") )
            {
                $Ls_contenido_fich = '' ;
                $fin_filtrado = false ;
                $condicion1 = false ;
                while ( !feof($Lp_fichero) )
                {
                    if ( $Ls_buffer = fgets($Lp_fichero, 4096) )
                    {
                        $La_buffer = explode( $Ls_separador, $Ls_buffer ) ;
                        if ( count($La_buffer) < 2 )
                        {
                            continue ;
                        }
                        if ( $fin_filtrado == true )
                        {
                            $Ls_contenido_fich .= $Ls_buffer ;
                            continue ;
                        }
                        foreach ( $La_buffer as & $Ls_valor )
                        {
                            $Ls_valor = trim( $Ls_valor ) ;
                        }
                        $La_miembro_valor = array_combine( $La_estructura_llaves_base, $La_buffer ) ;

                        $Ls_dato_condic = '' ;

                        $condicion2 = true ;
                        $condicion3 = false ;

                        if ( $La_estructura_filtro != '*' )
                        {
                            foreach ( $La_estructura_filtro as $key_miembrocomp => &$Ls_valor_miembrocomp )
                            {
                                $key_miembrocomp = trim( $key_miembrocomp ) ;
                                $Ls_valor_miembrocomp = trim( $Ls_valor_miembrocomp ) ;
                                if ( !empty($Ls_valor_miembrocomp) && !empty($La_miembro_valor[$key_miembrocomp]) )
                                {
                                    $condicion2 = ( $condicion2 && ($Ls_valor_miembrocomp == $La_miembro_valor[$key_miembrocomp]) ) ;
                                    $condicion3 = $condicion2 ;
                                    
                                    if ( !empty($Ls_llave_unica) && $condicion2 && ($key_miembrocomp == $Ls_llave_unica) )
                                    {
                                        $fin_filtrado = true ;
                                        break ;
                                    }
                                }
                            }
                        }

                        if ( $La_estructura_filtro == '*' || $condicion3 )
                        {
                            if ( !$condicion1 )
                            {
                                $condicion1 = true ;
                            }

                            foreach ( $La_miembro_valor as $key_miembrovalor => $Ls_valor_miembrovalor )
                            {
                                if ( !empty($La_estructura_sustituta[$key_miembrovalor]) )
                                {
                                    $Ls_valor_miembrovalor = ( $key_miembrovalor != end($La_estructura_llaves_base) ) ? $La_estructura_sustituta[$key_miembrovalor] . $Ls_separador : $La_estructura_sustituta[$key_miembrovalor] ;
                                    $Ls_dato_condic .= $Ls_valor_miembrovalor ;
                                    if ( !empty($Ls_llave_unica) )
                                    {
                                        if ( $key_miembrovalor == $Ls_llave_unica )
                                        {
                                            $fin_filtrado = true ;
                                        }
                                    }
                                    continue ;
                                }
                                $Ls_valor_miembrovalor = ( $key_miembrovalor != end($La_estructura_llaves_base) ) ? $Ls_valor_miembrovalor . $Ls_separador : $Ls_valor_miembrovalor ;
                                $Ls_dato_condic .= $Ls_valor_miembrovalor ;
                            }
                            $Ls_contenido_fich .= $Ls_dato_condic . "\n" ;
                            continue ;
                        }
                        $Ls_contenido_fich .= $Ls_buffer ;
                    }
                }
                fclose( $Lp_fichero ) ;
            }

            if ( $condicion1 )
            {
                if ( !empty($Ls_contenido_fich) && file_put_contents($Ls_path_fich, $Ls_contenido_fich) )
                {
                    return true ;
                }
                else
                {
                    return false ;
                }
            }
            else
            {
                return null ;
            }
        }

    }

?>