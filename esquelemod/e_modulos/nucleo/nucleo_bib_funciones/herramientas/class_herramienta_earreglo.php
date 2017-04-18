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
   * EArreglo class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */
    namespace Emod\Nucleo\Herramientas;

    class EArreglo
        {

        public static function arregloModificarRecursivo( $La_elementos , &$La_base , &$comport = 0 , &$La_estruct_result = NULL , $Ls_estruct_elem = NULL , $Li_nivel = 0 )
            {
            if ( $Li_nivel == 0 )
                {
                
                if ( !is_array( $La_base ) || empty( $La_base ) )
                    {
                    return NULL;
                    }
                if ( !is_array( $La_elementos ) || empty( $La_elementos ) )
                    {
                    return NULL;
                    }
                if ( $La_elementos === $La_base )
                    {
                    return NULL;
                    }

                $incondicional = false;
                if ( is_string( $comport ) )
                    {
                    $dato_dec = bindec( $comport );
                    if ( ( $dato_dec < 0 ) || ( $dato_dec > 384 ) )
                        {
                        return null;
                        }
                    if ( ( $dato_dec == 0 ) || ( $dato_dec == 128 ) || ( $dato_dec == 384 ) )
                        {
                        $incondicional = true;
                        }
                    else
                        {
                        $arreglo_bin = str_split( $comport );
                        
                        $arreglo_bin = array_reverse( $arreglo_bin );
                        }
                    }
                elseif ( is_int( $comport ) )
                    {
                    $dato_dec = $comport;
                    if ( ( $dato_dec < 0 ) || ( $dato_dec > 384 ) )
                        {
                        return null;
                        }
                    if ( ( $dato_dec == 0 ) || ( $dato_dec == 128 ) || ( $dato_dec == 384 ) )
                        {
                        $incondicional = true;
                        }
                    else
                        {
                        $n           = $dato_dec;
                        $arreglo_bin = array( );
                        for ( $j = 8; $j >= 0; $j-- )
                            {
                            if ( $n < $m = pow( 2 , $j ) )
                                {
                                $arreglo_bin[$j] = '0';
                                continue;
                                }
                            $arreglo_bin[$j] = '1';
                            if ( ( $n               = $n - $m ) == 0 )
                                {
                                break;
                                }
                            }
                        $arreglo_bin = array_reverse( $arreglo_bin );
                        }
                    }

                if ( !$incondicional )
                    {

                    if ( $arreglo_bin[0] && ( $arreglo_bin[1] || $arreglo_bin[2] || $arreglo_bin[3] || $arreglo_bin[4] || $arreglo_bin[5] || $arreglo_bin[6] ) )
                        {
                        return null;
                        }
                    if ( $arreglo_bin[1] && ( $arreglo_bin[2] || $arreglo_bin[3] || $arreglo_bin[4] || $arreglo_bin[5] || $arreglo_bin[6] ) )
                        {
                        return null;
                        }
                    if ( $arreglo_bin[2] && ( $arreglo_bin[3] || $arreglo_bin[4] || $arreglo_bin[5] || $arreglo_bin[6] ) )
                        {
                        return null;
                        }
                    if ( $arreglo_bin[3] && ( $arreglo_bin[4] || $arreglo_bin[5] || $arreglo_bin[6] ) )
                        {
                        return null;
                        }
                    if ( $arreglo_bin[4] && ( $arreglo_bin[5] || $arreglo_bin[6] ) )
                        {
                        return null;
                        }
                    if ( $arreglo_bin[5] && ( $arreglo_bin[6] ) )
                        {
                        return null;
                        }
                    }

                if ( !empty( $arreglo_bin ) )
                    {
                    settype( $comport , 'array' );
                    $comport = null;

                    $comport['comp_valor_igual']      = ( isset( $arreglo_bin[0] ) && $arreglo_bin[0] == '1' ) ? true : false;
                    $comport['comp_valor_diferente']  = ( isset( $arreglo_bin[1] ) && $arreglo_bin[1] == '1' ) ? true : false;
                    $comport['comp_valor_noident']    = ( isset( $arreglo_bin[2] ) && $arreglo_bin[2] == '1' ) ? true : false;
                    $comport['comp_valor_menor']      = ( isset( $arreglo_bin[3] ) && $arreglo_bin[3] == '1' ) ? true : false;
                    $comport['comp_valor_mayor']      = ( isset( $arreglo_bin[4] ) && $arreglo_bin[4] == '1' ) ? true : false;
                    $comport['comp_valor_menorigual'] = ( isset( $arreglo_bin[5] ) && $arreglo_bin[5] == '1' ) ? true : false;
                    $comport['comp_valor_mayorigual'] = ( isset( $arreglo_bin[6] ) && $arreglo_bin[6] == '1' ) ? true : false;
                    $comport['comp_estruct_imgident'] = ( isset( $arreglo_bin[7] ) && $arreglo_bin[7] == '1') ? true : false;
                    }
                elseif ( $incondicional )
                    {
                    settype( $comport , 'array' );
                    $comport                  = null;
                    $comport['incondicional'] = true;
                    if ( ( $dato_dec == 128 ) || ( $dato_dec == 384 ) )
                        {
                        $comport['incondicional_conservador'] = true;
                        }
                    if ( ( $dato_dec == 256 ) || ( $dato_dec == 384 ) )
                        {
                        $comport['comp_estruct_imgident'] = true;
                        }
                    }
                }

            foreach ( $La_elementos as $key_miembro_secc => $valor_miembro_secc )
                {   
                $Ls_estruct_nextelem = $Ls_estruct_elem . "[\"" . $key_miembro_secc . "\"]";

                if ( is_array( $valor_miembro_secc ) && !empty( $valor_miembro_secc ) )
                    {
                    self::arregloModificarRecursivo( $valor_miembro_secc , $La_base , $comport , $La_estruct_result , $Ls_estruct_nextelem , $Li_nivel + 1 );
                    }
                else
                    {
                    $elemento_inexistente = false;
                    $cad_elemen_inexist   = '';
                    $cad_arreglo          = '';
                    $cad0                 = '';
                    $cad1                 = '';
                    $cad2                 = '';
                    $cad3                 = '';
                    $cad4                 = '';
                    $cad5                 = '';
                    $cad6                 = '';
                    $cad7                 = '';
                    $cad8                 = '';

                    $cad_elemen_inexist = " if ( !isset( \$La_base$Ls_estruct_nextelem ) )
      	                                       				   {
      	                         	              			 	   \$elemento_inexistente = true ;
      	                         	           				   }
                                           					";
                    eval( $cad_elemen_inexist );

                    if ( is_array( $valor_miembro_secc ) && empty( $valor_miembro_secc ) )
                        {  
                        $cad_arreglo = "if ( isset( \$La_base$Ls_estruct_nextelem ) )
								               					{
      	                         	             					unset ( \$La_base$Ls_estruct_nextelem ) ;
      	                         	          			 		}
								           					else 
      	                                      					{
      	                         	             					\$La_estruct_result['fallos']['comp_estruct_imgident'][]= '\$La_elementos$Ls_estruct_nextelem' ;
      	                         	          					}
                                          					";
                        eval( $cad_arreglo );
                        }
                    elseif ( !empty( $comport['comp_estruct_imgident'] ) && $elemento_inexistente )
                        {
                        $cad8 = "
      	                         	              			\$La_estruct_result['fallos']['comp_estruct_imgident'][]= '\$La_elementos$Ls_estruct_nextelem' ;
      	                         	              	   ";
                        eval( $cad8 );
                        }
                    if ( !empty( $comport['incondicional'] ) && empty( $elemento_inexistente ) )
                        {
                        $cad7 = "if ( isset( \$La_base$Ls_estruct_nextelem ) )
      	                                       			{  
      	                         	              			\$La_base$Ls_estruct_nextelem = \$valor_miembro_secc  ;
      	                                      			}
      	                                   			";
                        eval( $cad7 );
                        }
                    elseif ( !empty( $comport['incondicional'] ) && empty( $comport['incondicional_conservador'] ) && !empty( $elemento_inexistente ) )
                        {
                        $cad7 = "  
      	                         	              		\$La_base$Ls_estruct_nextelem = \$valor_miembro_secc  ;
      	                                      		";
                        eval( $cad7 );
                        }
                    elseif ( !$elemento_inexistente )
                        {
                        if ( $comport['comp_valor_igual'] )
                            {
                            $cad0 = "if ( isset( \$La_base$Ls_estruct_nextelem ) && ( \$La_elementos['$key_miembro_secc'] == \$La_base$Ls_estruct_nextelem ) )
      	                                       				{  
      	                         	             				 \$La_base$Ls_estruct_nextelem = \$valor_miembro_secc  ;
      	                                      				}
      	                                    				else
										       				{
										          				\$La_estruct_result['fallos']['comp_valor_igual'][]= '\$La_elementos$Ls_estruct_nextelem' ;
										       				}   
                                          			 	";
                            }

                        if ( $comport['comp_valor_diferente'] )
                            {
                            $cad1 = "if ( isset( \$La_base$Ls_estruct_nextelem ) && ( \$La_elementos['$key_miembro_secc'] != \$La_base$Ls_estruct_nextelem ) )
      	                                       				{
      	                         	              				\$La_base$Ls_estruct_nextelem = \$valor_miembro_secc  ;
      	                                      				}
      	                                    				else
										       				{
										 	      				\$La_estruct_result['fallos']['comp_valor_diferente'][]= '\$La_elementos$Ls_estruct_nextelem' ;
										       				}   
                                           				";
                            }

                        if ( $comport['comp_valor_noident'] )
                            {
                            $cad2 = "if ( isset( \$La_base$Ls_estruct_nextelem ) && ( \$La_elementos['$key_miembro_secc'] !== \$La_base$Ls_estruct_nextelem ) )
      	                                       				{
      	                         	              				\$La_base$Ls_estruct_nextelem = \$valor_miembro_secc  ;
      	                                       				}
      	                                     				else
										       				{
										 	      				\$La_estruct_result['fallos']['comp_valor_noident'][]= '\$La_elementos$Ls_estruct_nextelem' ;
										       				}   
                                           				";
                            }

                        if ( $comport['comp_valor_menor'] )
                            {
                            $cad3 = "if ( isset( \$La_base$Ls_estruct_nextelem ) && ( \$La_elementos['$key_miembro_secc'] < \$La_base$Ls_estruct_nextelem ) )
      	                                      				{
      	                         	             				 \$La_base$Ls_estruct_nextelem = \$valor_miembro_secc  ;
      	                                       				}
                                            				else
										       				{
										  	     				 \$La_estruct_result['fallos']['comp_valor_menor'][]= '\$La_elementos$Ls_estruct_nextelem' ;
										      				}   
                                           				";
                            }

                        if ( $comport['comp_valor_mayor'] )
                            {
                            $cad4 = "if ( isset( \$La_base$Ls_estruct_nextelem ) && ( \$La_elementos['$key_miembro_secc'] > \$La_base$Ls_estruct_nextelem ) )
      	                                       				{
      	                         	              				\$La_base$Ls_estruct_nextelem = \$valor_miembro_secc  ;
      	                                       				}
      	                                    				else
										      				{
										 						\$La_estruct_result['fallos']['comp_valor_mayor'][]= '\$La_elementos$Ls_estruct_nextelem' ;
										       				}   
                                           				";
                            }

                        if ( $comport['comp_valor_menorigual'] )
                            {
                            $cad5 = "if ( isset( \$La_base$Ls_estruct_nextelem ) && ( \$La_elementos['$key_miembro_secc'] <= \$La_base$Ls_estruct_nextelem ) )
      	                                       				{
      	                         	             				 \$La_base$Ls_estruct_nextelem = \$valor_miembro_secc  ;
      	                                       				}
      	                                    				else
										       				{
										 						\$La_estruct_result['fallos']['comp_valor_menorigual'][]= '\$La_elementos$Ls_estruct_nextelem' ;
										       				}   
                                           				";
                            }

                        if ( $comport['comp_valor_mayorigual'] )
                            {
                            $cad6 = "if ( isset( \$La_base$Ls_estruct_nextelem ) && ( \$La_elementos['$key_miembro_secc'] >= \$La_base$Ls_estruct_nextelem ) )
      	                                       				{
      	                         	              				\$La_base$Ls_estruct_nextelem = \$valor_miembro_secc  ;
      	                                       				}
      	                                    				else
										       				{
										 						\$La_estruct_result['fallos']['comp_valor_mayorigual'][]= '\$La_elementos$Ls_estruct_nextelem' ;
										       				}   
                                           				";
                            }


                        eval( $cad0 . $cad1 . $cad2 . $cad3 . $cad4 . $cad5 . $cad6 );
                        }
                    }
                }

            if ( $Li_nivel == 0 )
                {
                if ( empty( $La_base ) )
                    {
                    $La_base = null;
                    }

                $La_estruct_result ['arreglo_base'] = $La_base;
                return $La_estruct_result;
                }
            }

        public static function arregloEliminarRecursivo( $La_elementos , &$La_base , &$comport = 0 , &$La_estruct_result = NULL , $Ls_estruct_elem = NULL , $Li_nivel = 0 )
            {
            
            if ( $Li_nivel == 0 )
                {
                
                if ( !is_array( $La_base ) || empty( $La_base ) )
                    {
                    return NULL;
                    }
                if ( !is_array( $La_elementos ) || empty( $La_elementos ) )
                    {
                    return NULL;
                    }
                if ( $La_elementos === $La_base )
                    {
                    return NULL;
                    }

                $incondicional = false;
                if ( is_string( $comport ) )
                    {
                    $dato_dec = bindec( $comport );
                    if ( ( $dato_dec < 0 ) || ( $dato_dec > 384 ) )
                        {
                        return null;
                        }
                    if ( ( $dato_dec == 0 ) || ( $dato_dec == 256 ) )
                        {
                        $incondicional = true;
                        }
                    else
                        {
                        $arreglo_bin = str_split( $comport );
                        
                        $arreglo_bin = array_reverse( $arreglo_bin );
                        }
                    }
                elseif ( is_int( $comport ) )
                    {
                    $dato_dec = $comport;
                    if ( ( $dato_dec < 0 ) || ( $dato_dec > 384 ) )
                        {
                        return null;
                        }
                    if ( ( $dato_dec == 0 ) || ( $dato_dec == 256 ) )
                        {
                        $incondicional = true;
                        }
                    else
                        {
                        $n           = $dato_dec;
                        $arreglo_bin = array( );
                        for ( $j = 8; $j >= 0; $j-- )
                            {
                            if ( $n < $m = pow( 2 , $j ) )
                                {
                                $arreglo_bin[$j] = '0';
                                continue;
                                }
                            $arreglo_bin[$j] = '1';
                            if ( ( $n               = $n - $m ) == 0 )
                                {
                                break;
                                }
                            }
                        $arreglo_bin = array_reverse( $arreglo_bin );
                        }
                    }

                if ( !$incondicional )
                    {

                    if ( $arreglo_bin[0] && ( $arreglo_bin[1] || $arreglo_bin[2] || $arreglo_bin[3] || $arreglo_bin[4] || $arreglo_bin[5] || $arreglo_bin[6] || $arreglo_bin[7] ) )
                        {
                        return null;
                        }
                    if ( $arreglo_bin[1] && ( $arreglo_bin[3] || $arreglo_bin[6] || $arreglo_bin[7] ) )
                        {
                        return null;
                        }
                    if ( $arreglo_bin[2] && ( $arreglo_bin[3] || $arreglo_bin[4] || $arreglo_bin[5] || $arreglo_bin[6] || $arreglo_bin[7] ) )
                        {
                        return null;
                        }
                    if ( $arreglo_bin[3] && ( $arreglo_bin[4] || $arreglo_bin[5] || $arreglo_bin[6] || $arreglo_bin[7] ) )
                        {
                        return null;
                        }
                    if ( $arreglo_bin[4] && ( $arreglo_bin[5] || $arreglo_bin[6] || $arreglo_bin[7] ) )
                        {
                        return null;
                        }
                    if ( $arreglo_bin[5] && ( $arreglo_bin[6] || $arreglo_bin[7] ) )
                        {
                        return null;
                        }
                    if ( $arreglo_bin[6] && $arreglo_bin[7] )
                        {
                        return null;
                        }
                    }

                if ( !empty( $arreglo_bin ) )
                    {
                    settype( $comport , 'array' );
                    $comport = null;

                    $comport['comp_valor_igual']      = ( isset( $arreglo_bin[0] ) && $arreglo_bin[0] == '1' ) ? true : false;
                    $comport['comp_valor_ident']      = ( isset( $arreglo_bin[1] ) && $arreglo_bin[1] == '1' ) ? true : false;
                    $comport['comp_valor_diferente']  = ( isset( $arreglo_bin[2] ) && $arreglo_bin[2] == '1' ) ? true : false;
                    $comport['comp_valor_noident']    = ( isset( $arreglo_bin[3] ) && $arreglo_bin[3] == '1' ) ? true : false;
                    $comport['comp_valor_menor']      = ( isset( $arreglo_bin[4] ) && $arreglo_bin[4] == '1' ) ? true : false;
                    $comport['comp_valor_mayor']      = ( isset( $arreglo_bin[5] ) && $arreglo_bin[5] == '1' ) ? true : false;
                    $comport['comp_valor_menorigual'] = ( isset( $arreglo_bin[6] ) && $arreglo_bin[6] == '1' ) ? true : false;
                    $comport['comp_valor_mayorigual'] = ( isset( $arreglo_bin[7] ) && $arreglo_bin[7] == '1' ) ? true : false;
                    $comport['comp_estruct_imgident'] = ( isset( $arreglo_bin[8] ) && $arreglo_bin[8] == '1') ? true : false;
                    }
                elseif ( $incondicional )
                    {
                    settype( $comport , 'array' );
                    $comport                  = null;
                    $comport['incondicional'] = true;
                    if ( $dato_dec == 256 )
                        {
                        $comport['comp_estruct_imgident'] = true;
                        }
                    }
                }

            foreach ( $La_elementos as $key_miembro_secc => $valor_miembro_secc )
                {  
                $Ls_estruct_nextelem = $Ls_estruct_elem . "[\"" . $key_miembro_secc . "\"]";

                if ( is_array( $valor_miembro_secc ) && !empty( $valor_miembro_secc ) )
                    {
                    self::arregloEliminarRecursivo( $valor_miembro_secc , $La_base , $comport , $La_estruct_result , $Ls_estruct_nextelem , $Li_nivel + 1 );
                    }
                else
                    {
                    $elemento_inexistente = false;
                    $cad_elemen_inexist   = '';
                    $cad_arreglo          = '';
                    $cad0                 = '';
                    $cad1                 = '';
                    $cad2                 = '';
                    $cad3                 = '';
                    $cad4                 = '';
                    $cad5                 = '';
                    $cad6                 = '';
                    $cad7                 = '';
                    $cad8                 = '';

                    $cad_elemen_inexist = " if ( !isset( \$La_base$Ls_estruct_nextelem ) )
      	                                       				   {
      	                         	              			 	   \$elemento_inexistente = true ;
      	                         	           				   }
                                           					";
                    eval( $cad_elemen_inexist );

                    if ( is_array( $valor_miembro_secc ) && empty( $valor_miembro_secc ) )
                        {  
                        $cad_arreglo = "if ( isset( \$La_base$Ls_estruct_nextelem ) )
								               				{
      	                         	             				unset ( \$La_base$Ls_estruct_nextelem ) ;
      	                         	           				}
								           					else 
      	                                      				{
      	                         	             				\$La_estruct_result['fallos']['comp_estruct_imgident'][]= '\$La_elementos$Ls_estruct_nextelem' ;
      	                         	          				}
                   											";
                        eval( $cad_arreglo );
                        }
                    elseif ( !empty( $comport['comp_estruct_imgident'] ) && $elemento_inexistente )
                        {
                        $cad8 = "
      	                         	              		\$La_estruct_result['fallos']['comp_estruct_imgident'][]= '\$La_elementos$Ls_estruct_nextelem' ;
      	                         	               ";
                        eval( $cad8 );
                        }
                    if ( !empty( $comport['incondicional'] ) && !$elemento_inexistente )
                        {
                        $cad0 = "if ( isset( \$La_base$Ls_estruct_nextelem ) )
      	                                       			{  
      	                         	              			unset (\$La_base$Ls_estruct_nextelem) ;
      	                                       			}
      	                                   			";
                        eval( $cad0 );
                        }
                    elseif ( !$elemento_inexistente )
                        {
                        if ( $comport['comp_valor_igual'] )
                            {
                            $cad0 = "if ( isset( \$La_base$Ls_estruct_nextelem ) && ( \$La_elementos['$key_miembro_secc'] == \$La_base$Ls_estruct_nextelem ) )
      	                                       				{  
      	                         	              				unset (\$La_base$Ls_estruct_nextelem) ;
      	                                       				}
      	                                    				else
										       				{
										          				\$La_estruct_result['fallos']['comp_valor_igual'][]= '\$La_elementos$Ls_estruct_nextelem' ;
										       				}   
                                           					";
                            }

                        if ( $comport['comp_valor_ident'] )
                            {
                            $cad1 = "if ( isset( \$La_base$Ls_estruct_nextelem ) && ( \$La_elementos['$key_miembro_secc'] === \$La_base$Ls_estruct_nextelem ) )
      	                                       				{
      	                         	              				unset (\$La_base$Ls_estruct_nextelem) ;
      	                                       				}
                                            				else
										       				{
										          				\$La_estruct_result['fallos']['comp_valor_ident'][]= '\$La_elementos$Ls_estruct_nextelem' ;
										       				}   
                                           					";
                            }

                        if ( $comport['comp_valor_diferente'] )
                            {
                            $cad2 = "if ( isset( \$La_base$Ls_estruct_nextelem ) && ( \$La_elementos['$key_miembro_secc'] != \$La_base$Ls_estruct_nextelem ) )
      	                                       				{
      	                         	              				unset (\$La_base$Ls_estruct_nextelem) ;
      	                                       				}
      	                                    				else
										       				{
										 	      				\$La_estruct_result['fallos']['comp_valor_diferente'][]= '\$La_elementos$Ls_estruct_nextelem' ;
										       				}   
                                           					";
                            }

                        if ( $comport['comp_valor_noident'] )
                            {
                            $cad3 = "if ( isset( \$La_base$Ls_estruct_nextelem ) && ( \$La_elementos['$key_miembro_secc'] !== \$La_base$Ls_estruct_nextelem ) )
      	                                       				{
      	                         	              				unset (\$La_base$Ls_estruct_nextelem) ;
      	                                       				}
      	                                     				else
										       				{
										 	      				\$La_estruct_result['fallos']['comp_valor_noident'][]= '\$La_elementos$Ls_estruct_nextelem' ;
										       				}   
                                           					";
                            }

                        if ( $comport['comp_valor_menor'] )
                            {
                            $cad4 = "if ( isset( \$La_base$Ls_estruct_nextelem ) && ( \$La_elementos['$key_miembro_secc'] < \$La_base$Ls_estruct_nextelem ) )
      	                                       				{
      	                         	              				unset (\$La_base$Ls_estruct_nextelem) ;
      	                                       				}
                                            				else
										       				{
										  	      				\$La_estruct_result['fallos']['comp_valor_menor'][]= '\$La_elementos$Ls_estruct_nextelem' ;
										       				}   
                                           					";
                            }

                        if ( $comport['comp_valor_mayor'] )
                            {
                            $cad5 = "if ( isset( \$La_base$Ls_estruct_nextelem ) && ( \$La_elementos['$key_miembro_secc'] > \$La_base$Ls_estruct_nextelem ) )
      	                                       				{
      	                         	              				unset (\$La_base$Ls_estruct_nextelem) ;
      	                                       				}
      	                                    				else
										       				{
										 						\$La_estruct_result['fallos']['comp_valor_mayor'][]= '\$La_elementos$Ls_estruct_nextelem' ;
										       				}   
                                           					";
                            }

                        if ( $comport['comp_valor_menorigual'] )
                            {
                            $cad6 = "if ( isset( \$La_base$Ls_estruct_nextelem ) && ( \$La_elementos['$key_miembro_secc'] <= \$La_base$Ls_estruct_nextelem ) )
      	                                       				{
      	                         	              				unset (\$La_base$Ls_estruct_nextelem) ;
      	                                       				}
      	                                    				else
										       				{
										 						\$La_estruct_result['fallos']['comp_valor_menorigual'][]= '\$La_elementos$Ls_estruct_nextelem' ;
										      				}   
                                           					";
                            }

                        if ( $comport['comp_valor_mayorigual'] )
                            {
                            $cad7 = "if ( isset( \$La_base$Ls_estruct_nextelem ) && ( \$La_elementos['$key_miembro_secc'] >= \$La_base$Ls_estruct_nextelem ) )
      	                                       				{
      	                         	              				unset (\$La_base$Ls_estruct_nextelem) ;
      	                                       				}
      	                                    				else
										       				{
										 						\$La_estruct_result['fallos']['comp_valor_mayorigual'][]= '\$La_elementos$Ls_estruct_nextelem' ;
										       				}   
                                           					";
                            }

                        eval( $cad0 . $cad1 . $cad2 . $cad3 . $cad4 . $cad5 . $cad6 . $cad7 );
                        }
                    }
                $cad_arreglo_vacio = "if ( empty ( \$La_base$Ls_estruct_elem ) )
      	                                 			{
      	                         	        			unset (\$La_base$Ls_estruct_elem) ;
      	                                 			}
									 			";
                eval( $cad_arreglo_vacio );
                }

            if ( $Li_nivel == 0 )
                {
                if ( empty( $La_base ) )
                    {
                    $La_base = null;
                    }

                $La_estruct_result ['arreglo_base'] = $La_base;
                return $La_estruct_result;
                }
            }

		}

?>