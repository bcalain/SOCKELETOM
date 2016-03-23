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

        //funcion para modificar valores de un arreglo ($La_base), vasandose en la estructura de otro arreglo como referencia ($La_elementos), 
        //esta funcion resulta solo con php4 o superior y trabaja con arreglos asociativos
        //$La_elementos (referencia) es un arreglo asociativo con los elementos que se quieren modificar en el arreglo $La_base (base),
        // esta matriz contendra la estructura exacta en la que se encuentra el elemento que se quiere modificar,
        // es como un mapa, una imagen de la matriz y su rama o elemento que se quiere modificar, llamemosle de ahora en adelante "estructura imagen"
        // en caso de que toda una rama del arreglo se quiera eliminar basta con poner 'elemento'=array() y se eliminara ese elemento junto a la rama que el constitulle,
        // el primer elemento del arreglo $La_elementos sera el primer elemento a buscar en el arreglo $La_base , y as� sucecivamente.  
        //$La_base (base) es un arreglo asociativo al cual se le modificaran elementos que son representados en la estructura del arreglo $La_elemetos
        //$comport es la forma como se comportar� la funci�n con los par�metros restantes
        //el valor puede ser un string representando un binario ('011000001')o un decimal, en caso de ser un decimal se convierte a binario donde 
        //si se escoge una condicion y esta no se cumple, el elemento base no es modificado. 
        //quedaran representados de la siguiente manera
        //
			//1er bit ( bit menos significativo, estremo derecho )en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a modificar los elementos si sus valores son iguales (==)
        //2do bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a modificar los elementos si sus valores son diferentes (!= , <>)
        //3er bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a modificar los elementos si sus valores son no identicos (!==)
        //4to bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es menor que el de la base (<)
        //5to bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es mayor que el de la base (>)
        //6to bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es menor o igual que el de la base (<=)
        //7mo bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es mayor o igual que el de la base (>=)
        //8vo bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a modificar los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n, pero si existe una estructura o elemento en la imagen que no existe en la base no es modificada la base, es decir no se transfiere el elemento de la imagen a la base.
        //9no bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a registrar en los resultados, en el elemento 'fallos' de esta funci�n, los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores
        //los valores sigientes son exepciones validas de aclarar
        //binarios:
        //000000000 (dec 0) modifica los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n, si existe una estructura o elemento en la imagen que no existe en la base es modificada la base con el elemento en cuestion, es decir se transfiere el elemento de la imagen a la base. 
        //100000000 (dec 256) modifica los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n pero manteniendo el criterio de registrar en los resultados de esta funci�n, en el elemento 'fallos' de esta funci�n, los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores, ademas mantiene el comportamiento del 8vo bit segun su valor.
        //110000000 (dec 384) modifica los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n pero manteniendo el criterio de registrar en los resultados de esta funci�n, en el elemento 'fallos' de esta funci�n, los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores, ademas mantiene el comportamiento del 8vo bit segun su valor.
        //110000000+1 (dec mayor que 384)retorna un valor null
        //si la l�gica de los bit del 1ro al 7mo activados equivalen a modificar todo el arreglo o existe redundancia, la funci�n retorna un valor null
        //ej: 000000101 o 001010000
        //el 8vo y 9no bit siempre pueden estar activados, no pertenece a la logica coparativa del lenguage    
        //$La_estruct_result es para el desarrollo interno de la funcion y es un arreglo asociativo con los resultados de las operaciones internas de la funcion
        //de introducirse un valor en este parametro no se predice el comportamiento de la funcion.
        //$Ls_estruct_elem es para el desarrollo interno de la funcion ya que esta se llama de forma recursiva
        //no necesita que le pasen valores y es una cadena que va concatenando a traves de los ciclos la estructura a modificar de la matriz 
        //de introducirse un valor en este parametro no se predice el comportamiento de la funcion.
        //
			//$Li_nivel es para el desarrollo interno de la funcion, es un entero que cuenta los niveles o dimensiones por los que pasa la funcion 
        //de introducirse un valor en este parametro no se predice el comportamiento de la funcion.
        //La funci�n devolvera un arreglo con las siguientes keys
        //  ['arreglo_base'] contendr� el arreglo resultante de las modificaciones hechas a $La_base. 
        //  ['fallos']['comp_valor_igual']contendr� las estructuras que en la comparacion de sus valores no resultaron iguales(==) , los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #1, sino no aparece este elemento en el arreglo
        //  ['fallos']['comp_valor_diferente']contendr� las estructuras que en la comparacion de sus valores no resultaron diferentes(!=) , los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #2, sino no aparece este elemento en el arreglo 
        //  ['fallos']['comp_valor_noident']contendr� las estructuras que en la comparacion de sus valores no resultaron no identicos(!==) , los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #3, sino no aparece este elemento en el arreglo
        //  ['fallos']['comp_valor_menor']contendr� las estructuras que en la comparacion de sus valores no resultaron menor que(<) , los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #4, sino no aparece este elemento en el arreglo
        //  ['fallos']['comp_valor_mayor']contendr� las estructuras que en la comparacion de sus valores no resultaron mayor que(>) , los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #5, sino no aparece este elemento en el arreglo 
        //  ['fallos']['comp_valor_menorigual']contendr� las estructuras que en la comparacion de sus valores no resultaron menor o igual que(<=) , los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #6, sino no aparece este elemento en el arreglo
        //  ['fallos']['comp_valor_mayorigual']contendr� las estructuras que en la comparacion de sus valores no resultaron mayor o igual que(>=) , los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #7, sino no aparece este elemento en el arreglo 
        //  ['fallos']['comp_estruct_imgident'] contendr� las estructuras que no se encontraron en $La_base, los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #8, sino no aparece este elemento en el arreglo, esto no quiere decir que la operacion se detenga cuando la estructura no sea identica, solo se registra que no existe el elemento en el arreglo base y se continua el recorrido por el resto del arreglo 
        //si los par�metros $La_elementos y $La_base son identicos el procedimiento retornara null 

        public static function arregloModificarRecursivo( $La_elementos , &$La_base , &$comport = 0 , &$La_estruct_result = NULL , $Ls_estruct_elem = NULL , $Li_nivel = 0 )
            {
            if ( $Li_nivel == 0 )
                {
                //Chequeo de errores

                if ( !is_array( $La_base ) || empty( $La_base ) )
                    {
                    //echo'ERROR, El par�metro $La_base no es array o su valor es vac�o';
                    return NULL;
                    }
                if ( !is_array( $La_elementos ) || empty( $La_elementos ) )
                    {
                    //echo'ERROR, El par�metro $La_elementos no es array o su valor es vac�o';
                    return NULL;
                    }
                if ( $La_elementos === $La_base )
                    {
                    //echo'ERROR, El par�metro $La_elementos y el par�metro $La_base son identicos';
                    return NULL;
                    }

                //Chequeo y conversion del comportamiento a binario, si no, heredar el comportamiento de la recursividad

                $incondicional = false;
                if ( is_string( $comport ) )
                    {
                    $dato_dec = bindec( $comport );
                    if ( ( $dato_dec < 0 ) || ( $dato_dec > 384 ) )
                        {
                        //echo 'ERROR, El par�metro $comport no puede tener valor menor que 0 o mayor que 384';	
                        return null;
                        }
                    if ( ( $dato_dec == 0 ) || ( $dato_dec == 128 ) || ( $dato_dec == 384 ) )
                        {
                        $incondicional = true;
                        }
                    else
                        {
                        $arreglo_bin = str_split( $comport );
                        //homologando posici�n del bit en arreglo con la posici�n del bit en el n�mero binario
                        $arreglo_bin = array_reverse( $arreglo_bin );
                        }
                    }
                elseif ( is_int( $comport ) )
                    {
                    $dato_dec = $comport;
                    if ( ( $dato_dec < 0 ) || ( $dato_dec > 384 ) )
                        {
                        //echo 'ERROR, El par�metro $comport no puede tener valor menor que 0 o mayor que 384';	
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
                        //homologando posici�n del bit en arreglo con la posici�n del bit en el n�mero binario	
                        $arreglo_bin = array_reverse( $arreglo_bin );
                        }
                    }

                //chequeo logico de ineficiencia o redundancia en los comportamientos

                if ( !$incondicional )
                    {

                    if ( $arreglo_bin[0] && ( $arreglo_bin[1] || $arreglo_bin[2] || $arreglo_bin[3] || $arreglo_bin[4] || $arreglo_bin[5] || $arreglo_bin[6] ) )
                        {
                        //echo 'ERROR, Ineficiencia o redundancia en los comportamientos declarados en el parametro $comport';
                        return null;
                        }
                    if ( $arreglo_bin[1] && ( $arreglo_bin[2] || $arreglo_bin[3] || $arreglo_bin[4] || $arreglo_bin[5] || $arreglo_bin[6] ) )
                        {
                        //echo 'ERROR, Ineficiencia o redundancia en los comportamientos declarados en el parametro $comport';
                        return null;
                        }
                    if ( $arreglo_bin[2] && ( $arreglo_bin[3] || $arreglo_bin[4] || $arreglo_bin[5] || $arreglo_bin[6] ) )
                        {
                        //echo 'ERROR, Ineficiencia o redundancia en los comportamientos declarados en el parametro $comport';
                        return null;
                        }
                    if ( $arreglo_bin[3] && ( $arreglo_bin[4] || $arreglo_bin[5] || $arreglo_bin[6] ) )
                        {
                        //echo 'ERROR, Ineficiencia o redundancia en los comportamientos declarados en el parametro $comport';
                        return null;
                        }
                    if ( $arreglo_bin[4] && ( $arreglo_bin[5] || $arreglo_bin[6] ) )
                        {
                        //echo 'ERROR, Ineficiencia o redundancia en los comportamientos declarados en el parametro $comport';
                        return null;
                        }
                    if ( $arreglo_bin[5] && ( $arreglo_bin[6] ) )
                        {
                        //echo 'ERROR, Ineficiencia o redundancia en los comportamientos declarados en el parametro $comport';
                        return null;
                        }
                    }

                //Conversion del comportamiento a tipos logicos boolean
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
                        //incondicional pero conservando la estructura de la base
                        $comport['incondicional_conservador'] = true;
                        }
                    if ( ( $dato_dec == 256 ) || ( $dato_dec == 384 ) )
                        {
                        $comport['comp_estruct_imgident'] = true;
                        }
                    }
                }

            //Construccion del arreglo con los parametros a eliminar en $La_base

            foreach ( $La_elementos as $key_miembro_secc => $valor_miembro_secc )
                {   //se prepara una cadena con los elementos del arreglo hasta este punto de la recursividad
                $Ls_estruct_nextelem = $Ls_estruct_elem . "[\"" . $key_miembro_secc . "\"]";

                if ( is_array( $valor_miembro_secc ) && !empty( $valor_miembro_secc ) )
                    {//esto es si el elemento es un arreglo y no esta vacio
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

                    //esto es si el elemento de la imagen no existe en la base
                    $cad_elemen_inexist = " if ( !isset( \$La_base$Ls_estruct_nextelem ) )
      	                                       				   {
      	                         	              			 	   \$elemento_inexistente = true ;
      	                         	           				   }
                                           					";
                    eval( $cad_elemen_inexist );

                    //esto es si es un arreglo vacio o un elemento final de la rama del arreglo			
                    if ( is_array( $valor_miembro_secc ) && empty( $valor_miembro_secc ) )
                        {  //esto es si el elemnto es un arreglo y esta vacio
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

            //conformando y retornando resultado final 
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

        //funcion para eliminar valores de un arreglo ($La_base), vasandose en la estructura de otro arreglo como referencia ($La_elementos), 
        //esta funci�n resulta solo con php4 o superior y trabaja con arreglos asociativos
        //$La_elementos (referencia) es un arreglo asociativo con los elementos que se quieren eliminar en el arreglo $La_base (base),
        // esta matriz contendra la estructura exacta en la que se encuentra el elemento que se quiere eliminar,
        // es como un mapa, una imagen de la matriz y su rama o elemento que se quiere eliminar, llamemosle de ahora en adelante "estructura imagen"
        // en caso de que toda una rama del arreglo se quiera eliminar basta con poner 'elemento'=array() y se eliminara ese elemento junto a la rama que el constitulle,
        // el primer elemento del arreglo $La_elementos ser� el primer elemento a buscar en el arreglo $La_base , y as� sucecivamente.  
        //$La_base (base) es un arreglo asociativo al cual se le eliminaran elementos que son representados en la estructura del arreglo $La_elemetos
        //$comport es la forma como se comportar� la funci�n con los par�metros restantes
        //el valor puede ser un string representando un binario ('011000001')o un decimal, en caso de ser un decimal se convierte a binario donde 
        //si se escoge una condicion y esta no se cumple, el elemento base no es eliminado.
        //quedaran representados de la siguiente manera
        //
			//1er bit ( bit menos significativo, estremo derecho )en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a eliminar los elementos si sus valores son iguales (==)
        //2do bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a eliminar los elementos si sus valores son identicos (===) 
        //3er bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a eliminar los elementos si sus valores son diferentes (!= , <>)
        //4to bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a eliminar los elementos si sus valores son no identicos (!==)
        //5to bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es menor que el de la base (<)
        //6to bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es mayor que el de la base (>)
        //7mo bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es menor o igual que el de la base (<=)
        //8vo bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es mayor o igual que el de la base (>=)
        //9no bit en cero desactivado) no se tiene en cuenta
        //        en 1 (activado)corresponde a registrar en los resultados de esta funci�n los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores
        //los valores sigientes son exepciones validas de aclarar
        //binarios:
        //000000000 (dec 0) elimina los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir elimina todo sin citerios de comparaci�n 
        //100000000 (dec 256) elimina los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir elimina todo sin citerios de comparaci�n pero manteniendo el criterio de registrar en los resultados de esta funci�n los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores
        //110000000+1 (dec mayor que 384)retorna un valor null
        //si la l�gica de los bit del 1ro al 8vo activados equivalen a eliminar todo el arreglo o existe redundancia, la funci�n retorna un valor null
        //ej: 00000101 o 001010000
        //entre el 1er y el 8vo bit solo pueden coexistir las convinaciones 2do y 3ro, o 2do y 5to, o 2do y 6to
        //el 9no bit siempre puede estar activado, no pertenece a la logica coparativa del lenguage    
        //$La_estruct_result es para el desarrollo interno de la funcion y es un arreglo asociativo con los resultados de las operaciones internas de la funcion
        //de introducirse un valor en este parametro no se predice el comportamiento de la funcion.
        //$Ls_estruct_elem es para el desarrollo interno de la funcion ya que esta se llama de forma recursiva
        //no necesita que le pasen valores y es una cadena que va concatenando a traves de los ciclos la estructura a eliminar de la matriz 
        //de introducirse un valor en este parametro no se predice el comportamiento de la funcion.
        //
			//$Li_nivel es para el desarrollo interno de la funcion, es un entero que cuenta los niveles o dimensiones por los que pasa la funcion 
        //de introducirse un valor en este parametro no se predice el comportamiento de la funcion.
        //La funci�n devolvera un arreglo con las siguientes keys
        //  ['arreglo_base'] contendr� el arreglo resultante de las modificaciones hechas a $La_base, si al arreglo $La_base le fueron eliminados todos sus elementos quedando un arreglo vac�o, este elemento tendr� valor null  
        //  ['fallos']['comp_valor_igual']contendr� las estructuras que en la comparacion de sus valores no resultaron iguales(==) , los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #1, sino no aparece este elemento en el arreglo
        //  ['fallos']['comp_valor_ident']contendr� las estructuras que en la comparacion de sus valores no resultaron identicas(===) , los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #2, sino no aparece este elemento en el arreglo 
        //  ['fallos']['comp_valor_diferente']contendr� las estructuras que en la comparacion de sus valores no resultaron diferentes(!=) , los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #3, sino no aparece este elemento en el arreglo 
        //  ['fallos']['comp_valor_noident']contendr� las estructuras que en la comparacion de sus valores no resultaron no identicos(!==) , los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #4, sino no aparece este elemento en el arreglo
        //  ['fallos']['comp_valor_menor']contendr� las estructuras que en la comparacion de sus valores no resultaron menor que(<) , los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #5, sino no aparece este elemento en el arreglo
        //  ['fallos']['comp_valor_mayor']contendr� las estructuras que en la comparacion de sus valores no resultaron mayor que(>) , los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #6, sino no aparece este elemento en el arreglo 
        //  ['fallos']['comp_valor_menorigual']contendr� las estructuras que en la comparacion de sus valores no resultaron menor o igual que(<=) , los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #7, sino no aparece este elemento en el arreglo
        //  ['fallos']['comp_valor_mayorigual']contendr� las estructuras que en la comparacion de sus valores no resultaron mayor o igual que(>=) , los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #8, sino no aparece este elemento en el arreglo 
        //  ['fallos']['comp_estruct_imgident'] contendr� las estructuras que no se encontraron en $La_base, los elementos seran strings de la forma '$La_elementos[elemnto 1][elemnto n]', para esto debe estar habilitado en el par�metro $comport el bit #9, sino no aparece este elemento en el arreglo, esto no quiere decir que la operacion se detenga cuando la estructura no sea identica, solo se registra que no existe el elemento en el arreglo base y se continua el recorrido por el resto del arreglo 
        //si los par�metros $La_elementos y $La_base son identicos el procedimiento retornara null 

        public static function arregloEliminarRecursivo( $La_elementos , &$La_base , &$comport = 0 , &$La_estruct_result = NULL , $Ls_estruct_elem = NULL , $Li_nivel = 0 )
            {
            
            if ( $Li_nivel == 0 )
                {
                //Chequeo de errores

                if ( !is_array( $La_base ) || empty( $La_base ) )
                    {
                    //echo'ERROR, El par�metro $La_base no es array o su valor es vac�o';
                    return NULL;
                    }
                if ( !is_array( $La_elementos ) || empty( $La_elementos ) )
                    {
                    //echo'ERROR, El par�metro $La_elementos no es array o su valor es vac�o';
                    return NULL;
                    }
                if ( $La_elementos === $La_base )
                    {
                    //echo'ERROR, El par�metro $La_elementos y el par�metro $La_base son identicos';
                    return NULL;
                    }

                //Chequeo y conversion del comportamiento a binario, si no, heredar el comportamiento de la recursividad

                $incondicional = false;
                if ( is_string( $comport ) )
                    {
                    $dato_dec = bindec( $comport );
                    if ( ( $dato_dec < 0 ) || ( $dato_dec > 384 ) )
                        {
                        //echo 'ERROR, El par�metro $comport no puede tener valor 0 o mayor que 384';	
                        return null;
                        }
                    if ( ( $dato_dec == 0 ) || ( $dato_dec == 256 ) )
                        {
                        $incondicional = true;
                        }
                    else
                        {
                        $arreglo_bin = str_split( $comport );
                        //homologando posici�n del bit en arreglo con la posici�n del bit en el n�mero binario
                        $arreglo_bin = array_reverse( $arreglo_bin );
                        }
                    }
                elseif ( is_int( $comport ) )
                    {
                    $dato_dec = $comport;
                    if ( ( $dato_dec < 0 ) || ( $dato_dec > 384 ) )
                        {
                        //echo 'ERROR, El par�metro $comport no puede tener valor 0 o mayor que 384';	
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
                        //homologando posici�n del bit en arreglo con la posici�n del bit en el n�mero binario	
                        $arreglo_bin = array_reverse( $arreglo_bin );
                        }
                    }

                //chequeo logico de ineficiencia o redundancia en los comportamientos

                if ( !$incondicional )
                    {

                    if ( $arreglo_bin[0] && ( $arreglo_bin[1] || $arreglo_bin[2] || $arreglo_bin[3] || $arreglo_bin[4] || $arreglo_bin[5] || $arreglo_bin[6] || $arreglo_bin[7] ) )
                        {
                        //echo 'ERROR, Ineficiencia o redundancia en los comportamientos declarados en el parametro $comport';
                        return null;
                        }
                    if ( $arreglo_bin[1] && ( $arreglo_bin[3] || $arreglo_bin[6] || $arreglo_bin[7] ) )
                        {
                        //echo 'ERROR, Ineficiencia o redundancia en los comportamientos declarados en el parametro $comport';
                        return null;
                        }
                    if ( $arreglo_bin[2] && ( $arreglo_bin[3] || $arreglo_bin[4] || $arreglo_bin[5] || $arreglo_bin[6] || $arreglo_bin[7] ) )
                        {
                        //echo 'ERROR, Ineficiencia o redundancia en los comportamientos declarados en el parametro $comport';
                        return null;
                        }
                    if ( $arreglo_bin[3] && ( $arreglo_bin[4] || $arreglo_bin[5] || $arreglo_bin[6] || $arreglo_bin[7] ) )
                        {
                        //echo 'ERROR, Ineficiencia o redundancia en los comportamientos declarados en el parametro $comport';
                        return null;
                        }
                    if ( $arreglo_bin[4] && ( $arreglo_bin[5] || $arreglo_bin[6] || $arreglo_bin[7] ) )
                        {
                        //echo 'ERROR, Ineficiencia o redundancia en los comportamientos declarados en el parametro $comport';
                        return null;
                        }
                    if ( $arreglo_bin[5] && ( $arreglo_bin[6] || $arreglo_bin[7] ) )
                        {
                        //echo 'ERROR, Ineficiencia o redundancia en los comportamientos declarados en el parametro $comport';
                        return null;
                        }
                    if ( $arreglo_bin[6] && $arreglo_bin[7] )
                        {
                        //echo 'ERROR, Ineficiencia o redundancia en los comportamientos declarados en el parametro $comport';
                        return null;
                        }
                    }

                //Conversion del comportamiento a tipos logicos boolean
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

            //Construccion del arreglo con los parametros a eliminar en $La_base

            foreach ( $La_elementos as $key_miembro_secc => $valor_miembro_secc )
                {   //se prepara una cadena con los elementos del arreglo hasta este punto de la recursividad
                $Ls_estruct_nextelem = $Ls_estruct_elem . "[\"" . $key_miembro_secc . "\"]";

                if ( is_array( $valor_miembro_secc ) && !empty( $valor_miembro_secc ) )
                    {//esto es si el elemento es un arreglo y no esta vacio
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

                    //esto es si el elemento de la imagen no existe en la base
                    $cad_elemen_inexist = " if ( !isset( \$La_base$Ls_estruct_nextelem ) )
      	                                       				   {
      	                         	              			 	   \$elemento_inexistente = true ;
      	                         	           				   }
                                           					";
                    eval( $cad_elemen_inexist );

                    //esto es si es una arreglo vacio o un elemento final de la rama del arreglo
                    if ( is_array( $valor_miembro_secc ) && empty( $valor_miembro_secc ) )
                        {  //esto es si el elemnto es un arreglo y esta vacio
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
                //chequea si al eliminar cada elemento del arreglo este se queda vacio, si es asi, lo elimina del todo	 
                $cad_arreglo_vacio = "if ( empty ( \$La_base$Ls_estruct_elem ) )
      	                                 			{
      	                         	        			unset (\$La_base$Ls_estruct_elem) ;
      	                                 			}
									 			";
                eval( $cad_arreglo_vacio );
                }

            //conformando y retornando resultado final 
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

//esta funcion la coji de la ayuda del esquelemod, y la utilizo para poder ver bien la estructura del arreglo		
        public static function doDump( &$var , $var_name = NULL , $indent = NULL , $reference = NULL )
            {
            $do_dump_indent = "<span style='color:#666666;'>|</span> &nbsp;&nbsp; ";
            $reference      = $reference . $var_name;
            $keyvar         = 'the_do_dump_recursion_protection_scheme';
            $keyname        = 'referenced_object_name';

            // So this is always visible and always left justified and readable
            echo "<div style='text-align:left; background-color:white; font: 100% monospace; color:black;'>";

            if ( is_array( $var ) && isset( $var[$keyvar] ) )
                {
                $real_var  = &$var[$keyvar];
                $real_name = &$var[$keyname];
                $type      = ucfirst( gettype( $real_var ) );
                echo "$indent$var_name <span style='color:#666666'>$type</span> = <span style='color:#e87800;'>&amp;$real_name</span><br>";
                }
            else
                {
                $var = array( $keyvar  => $var , $keyname => $reference );
                $avar    = &$var[$keyvar];

                $type       = ucfirst( gettype( $avar ) );
                if ( $type == "String" )
                    $type_color = "<span style='color:green'>";
                elseif ( $type == "Integer" )
                    $type_color = "<span style='color:red'>";
                elseif ( $type == "Double" )
                    {
                    $type_color = "<span style='color:#0099c5'>";
                    $type       = "Float";
                    }
                elseif ( $type == "Boolean" )
                    $type_color = "<span style='color:#92008d'>";
                elseif ( $type == "NULL" )
                    $type_color = "<span style='color:black'>";

                if ( is_array( $avar ) )
                    {
                    $count = count( $avar );
                    echo "$indent" . ($var_name ? "$var_name => " : "") . "<span style='color:#666666'>$type ($count)</span><br>$indent(<br>";
                    $keys  = array_keys( $avar );
                    foreach ( $keys as $name )
                        {
                        $value = &$avar[$name];
                        self::doDump( $value , "['$name']" , $indent . $do_dump_indent , $reference );
                        }
                    echo "$indent)<br>";
                    }
                elseif ( is_object( $avar ) )
                    {
                    echo "$indent$var_name <span style='color:#666666'>$type</span><br>$indent(<br>";
                    foreach ( $avar as $name => $value )
                        do_dump( $value , "$name" , $indent . $do_dump_indent , $reference );
                    echo "$indent)<br>";
                    }
                elseif ( is_int( $avar ) )
                    echo "$indent$var_name = <span style='color:#666666'>$type(" . strlen( $avar ) . ")</span> $type_color" . htmlentities( $avar ) . "</span><br>";
                elseif ( is_string( $avar ) )
                    echo "$indent$var_name = <span style='color:#666666'>$type(" . strlen( $avar ) . ")</span> $type_color\"" . htmlentities( $avar ) . "\"</span><br>";
                elseif ( is_float( $avar ) )
                    echo "$indent$var_name = <span style='color:#666666'>$type(" . strlen( $avar ) . ")</span> $type_color" . htmlentities( $avar ) . "</span><br>";
                elseif ( is_bool( $avar ) )
                    echo "$indent$var_name = <span style='color:#666666'>$type(" . strlen( $avar ) . ")</span> $type_color" . ($avar == 1 ? "TRUE" : "FALSE") . "</span><br>";
                elseif ( is_null( $avar ) )
                    echo "$indent$var_name = <span style='color:#666666'>$type(" . strlen( $avar ) . ")</span> {$type_color}NULL</span><br>";
                else
                    echo "$indent$var_name = <span style='color:#666666'>$type(" . strlen( $avar ) . ")</span> " . htmlentities( $avar ) . "<br>";

                $var = $var[$keyvar];
                }

            echo "</div>";
            }

        }

?>