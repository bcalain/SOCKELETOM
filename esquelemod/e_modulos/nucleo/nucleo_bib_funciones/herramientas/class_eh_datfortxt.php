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

        //procedimiento para crear una nueva linea en un fichero txt, si el fichero no existe lo crea
        //$Ls_path_fich es el path del fichero al que se adicionara un nueva linea
        //$Ls_linea informacion a escribir
        //retorna null si alguno de los parametros tiene valor vacio, de lo contrario el valor que debuelve la funcion file_put_contents al crear la linea
        //recordar que cada linea a crear debe llevar el caracter de retorno de carro o linea, antes o despues del contenido de la linea, sino se escribira siempre al final de la ultima linea del fichero sin crearse una nueva linea
        public static function crearNuevaLinea( $Ls_path_fich, $Ls_linea )
        {
            if ( empty($Ls_path_fich) || empty($Ls_linea) )
            {
                return null ;
            }
            return file_put_contents( $Ls_path_fich, $Ls_linea, FILE_APPEND ) ;
        }

        // este procedimiento elimina lineas del fichero txt si estas coinciden con la regla de filtrado
        //$La_estructura_llaves_base es un arreglo cullos elementos seran las llaves que formaran parte de un arreglo asociativo que sera construido con estos elementos como llave y las secciones de una linea del fichero txt como valor de estas llaves, es como una matriz de llaves para los valores que se contienen en cada seccion de cada linea seccionada con separadores perteneciente al fichero a filtrar, los resultados de la combinacion de estas dos estructuras se hace con array_combine por lo que su resultado se rige por la gestion de esta funcion
        //ejemplo para una linea del fichero con la siguiente estructura
        //seccion1::seccion2::seccion3::seccionN
        //y un arreglo $La_estructura_llaves_base = array(rojo,verde,azul,amarillo)
        // se fromaran los pares
        //$arregloresult['rojo']= 'seccion1'
        //$arregloresult['verde']= 'seccion2'
        //$arregloresult['azul']= 'seccion3'
        //$arregloresult['amarillo']= 'seccionN'
        // $La_estructura_filtro es un arreglo con los pares $llave -> $valor que hacen funcion de filtro, deben coincidir en la o las lineas de fichero a eliminar, puede ser un par $llave -> $valor o varios, si son varios pares $llave -> $valor como regla de filtrado para eliminar la linea de fichero, tienen que coincidir todos para que sea eliminada la linea
        //con estos elementos de la estructura de filtro se compararan cada uno de los elementos de la estructura $arregloresult explicada anteriormente
        //$Ls_separador es el string separador de los elemento de la linea del fichero txt, en el ejemplo anterior se tomo como separador '::'
        //$Ls_path_fich es el path del fichero txt al que se hara el filtrado
        //$Ls_llave_unica define una llave de las contenidas en el arreglo $La_estructura_filtro como condicion para que cuando esta llave y su valor sean encontrados en la linea del txt, se detenga la busqueda por las lineas restantes del fichero, es decir se detenga el proceso de filtrado y se pase a al termino de la gestion de este procedimiento
        //si su valor es vacio no se tomara en cuenta como condicion, esta llave puede estar sola o acompanada de otras en $La_estructura_filtro
        //este procedimiento retorna
        //retorna true si encuentra elemento al que aplicar la condicion de filtrado y lo realiza satisfactoriamente
        //retorna false si encuentra elemento al que aplicar la condicion de filtrado y no le es posible realizar los cambios en el fichero o se le pasan valores incompatibles a los parametros del procedimiento.
        //retorna null si no encuentra elemento al que aplicar la condicion de filtrado
        public static function filtrarEliminarLineaDatos( $La_estructura_llaves_base, $La_estructura_filtro, $Ls_separador, $Ls_path_fich, $Ls_llave_unica = null )
        {
            if ( !is_array($La_estructura_llaves_base) || empty($La_estructura_llaves_base) || !is_array($La_estructura_filtro) || empty($La_estructura_filtro) || empty($Ls_separador) || empty($Ls_path_fich) )
            {
                //echo 'Error, se han introducido valores incompatibles como parametros en la funcion . <p>' ;
                return null ;
            }
            if ( $Lp_fichero = fopen( $Ls_path_fich , "r+") )
            {
                $Ls_contenido_fich = '' ;
                $fin_filtrado = false ;
                $condicion1 = false ;
                //bucle de recorrido de lineas del fichero
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

                        //bucle para la comparacion del filtrado
                        foreach ( $La_estructura_filtro as $key_miembrocomp => &$Ls_valor_miembrocomp )
                        {
                            $key_miembrocomp = trim( $key_miembrocomp ) ;
                            $Ls_valor_miembrocomp = trim( $Ls_valor_miembrocomp ) ;
                            if ( !empty($Ls_valor_miembrocomp) && !empty($La_miembro_valor[$key_miembrocomp]) )
                            {
                                $condicion2 = ( $condicion2 && ($Ls_valor_miembrocomp == $La_miembro_valor[$key_miembrocomp]) ) ;
                                $condicion3 = $condicion2 ;
                                //si un elemento de filtrado es id y es llave unica, $fin_filtrado = true acaba con la busqueda por ser este id de valor unico en este tipo de fichero txt
                                if ( !empty($Ls_llave_unica) && $condicion2 && ($key_miembrocomp == $Ls_llave_unica) )
                                {
                                    $fin_filtrado = true ;
                                    break ;
                                }
                            }
                        }
                        //define que se encontro al menos una coincidencia de filtrado para modificar el fichero
                        if ( (!$condicion1 && $condicion3) || $fin_filtrado )
                        {
                            $condicion1 = true ;
                        }

                        //aqui se decide que linea se desecha y cual no desecha
                        if ( $condicion3 || $fin_filtrado )
                        {
                            //se omite que esta linea sea cargada para formar parte nuevamente del fichero
                            continue ;
                        }
                        $Ls_contenido_fich .= $Ls_buffer ;
                    }
                }
                fclose( $Lp_fichero ) ;
            }

            //se modifica o no el fichero
            if ( $condicion1 )
            {
                if ( !empty($Ls_contenido_fich) && file_put_contents($Ls_path_fich, $Ls_contenido_fich) )
                {
                    //echo 'El filtrado se realizo satisfactoriamente. <p>';
                    return true ;
                }
                else
                {
                    //echo 'No se pudo realizar el filtrado. <p>';
                    return false ;
                }
            }
            else
            {
                //echo 'No se encontro elemento a aplicar condicion de filtrado. <p>';
                return null ;
            }
        }

        // este procedimiento lee lineas del fichero txt si estas coinciden con la regla de filtrado
        //$La_estructura_llaves_base es un arreglo cullos elementos seran las llaves que formaran parte de un arreglo asociativo que sera construido con estos elementos como llave y las secciones de una linea del fichero txt como valor de estas llaves, es como una matriz de llaves para los valores que se contienen en cada seccion de cada linea seccionada con separadores, perteneciente al fichero a filtrar, los resultados de la combinacion de estas dos estructuras se hace con array_combine por lo que su resultado se rige por la gestion de esta funcion
        //ejemplo para una linea del fichero con la siguiente estructura
        //seccion1::seccion2::seccion3::seccionN
        //y un arreglo $La_estructura_llaves_base = array(rojo,verde,azul,amarillo)
        // se fromaran los pares
        //$arregloresult['rojo']= 'seccion1'
        //$arregloresult['verde']= 'seccion2'
        //$arregloresult['azul']= 'seccion3'
        //$arregloresult['amarillo']= 'seccionN'
        // $La_estructura_filtro es un arreglo con los pares $llave -> $valor que hacen funcion de filtro, deben coincidir en la o las lineas de fichero a eliminar, puede ser un par $llave -> $valor o varios, si son varios pares $llave -> $valor como regla de filtrado para leer la linea de fichero, tienen que coincidir todos para que sea leida la linea
        //con estos elementos de la estructura de filtro se compararan cada uno de los elementos de la estructura $arregloresult explicada anteriormente
        //$Ls_separador es el string separador de los elemento de la linea del fichero txt, en el ejemplo anterior se tomo como separador '::'
        //$Ls_path_fich es el path del fichero txt al que se hara el filtrado
        //$Ls_llave_unica define una llave de las contenidas en el arreglo $La_estructura_filtro como condicion para que cuando esta llave y su valor sean encontrados en la linea del txt, se detenga la busqueda por las lineas restantes del fichero, es decir se detenga el proceso de filtrado y se pase al termino de la gestion de este procedimiento
        //si su valor es vacio no se tomara en cuenta como condicion, esta llave puede estar sola o acompanada de otras en $La_estructura_filtro
        //$tipo_retorno es el tipo de dato y la estructura del dato que va a retornar este procedimiento
        //este parametro tien tres posibles valores 1-'txt' 2-'array' 3-'array_key_valor' mas adelante en la explicacion de retornos de este procedimiento se explica cada tipo de retorno
        //este procedimiento retorna
        //el retorno de este procedimiento esta condicionado por el parametro $tipo_retorno donde:
        //si $tipo_retorno = 'txt', este procedimiento retorna un arreglo no asociativo donde cada uno de sus elementos contendra como valor un string que seran las lineas del txt que coincidieron con el filtrado
        //si $tipo_retorno = 'array', este procedimiento retorna un arreglo no asociativo donde cada uno de sus elementos contendra un arreglo no asociativo que a la vez contendra en sus elementos las secciones de la linea txt que coincidieron con el filtrado, las secciones estaran en el mismo orden en que aparecen en el txt.
        //si $tipo_retorno = 'array_key_valor', este procedimiento retorna un arreglo no asociativo donde cada uno de sus elementos contendra un arreglo asociativo que a la vez contendrá en sus elementos las secciones de la línea txt que coincidieron con el filtrado, los elementos del arreglo asociativo seran los pares clave valor que se forman al fucionar el paramtro $La_estructura_llaves_base con los segmentos de linea del txt, estos pares estaran en el mismo orden en que aparecen en el txt las correspondientes secciones.
        //retorna null si se le pasan valores incompatibles a los parametros del procedimiento, o si no encuentra elemento al que aplicar la condicion de filtrado

        public static function filtrarLeerLineaDatos( $La_estructura_llaves_base, $La_estructura_filtro, $Ls_separador, $Ls_path_fich, $Ls_llave_unica = null , $tipo_retorno = 'txt' )
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

                        //$condicion1 = false ;
                        $condicion2 = false ;

                        foreach ( $La_estructura_filtro as $key_miembrocomp => $Ls_valor_miembrocomp )
                        {
                            $key_miembrocomp = trim( $key_miembrocomp ) ;
                            $Ls_valor_miembrocomp = trim( $Ls_valor_miembrocomp ) ;
                            
                            if ( !empty($Ls_valor_miembrocomp) && !empty($La_miembro_valor[$key_miembrocomp]) )
                            {
                                //$condicion1 = true ;
                                $condicion2 = ( $Ls_valor_miembrocomp == $La_miembro_valor[$key_miembrocomp] ) ;
                                //si un elemento de filtrado es id y es llave unica, $fin_filtrado = true acaba con la busqueda por ser este id de valor unico en este tipo de fichero txt
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
            //echo "No se han encontrado datos para la combinacion de elementos de un error a que se hace referencia. <p> " ;
            return null ;
        }

        //este procedimiento modifica lineas del fichero txt si estas coinciden con la regla de filtrado
        //$La_estructura_llaves_base es un arreglo cullos elementos seran las llaves que formaran parte de un arreglo asociativo que sera construido con estos elementos como llave y las secciones de una linea del fichero txt como valor de estas llaves, es como una matriz de llaves para los valores que se contienen en cada seccion de cada linea seccionada con separadores, perteneciente al fichero a filtrar, los resultados de la combinacion de estas dos estructuras se hace con array_combine por lo que su resultado se rige por la gestion de esta funcion
        //ejemplo para una linea del fichero con la siguiente estructura
        //seccion1::seccion2::seccion3::seccionN
        //y un arreglo $La_estructura_llaves_base = array(rojo,verde,azul,amarillo)
        //se fromaran los pares
        //$arregloresult['rojo']= 'seccion1'
        //$arregloresult['verde']= 'seccion2'
        //$arregloresult['azul']= 'seccion3'
        //$arregloresult['amarillo']= 'seccionN'
        //$La_estructura_filtro es un arreglo con los pares $llave -> $valor que hacen funcion de filtro, deben coincidir en la o las lineas de fichero a eliminar, puede ser un par $llave -> $valor o varios, si son varios pares $llave -> $valor como regla de filtrado para leer la linea de fichero, tienen que coincidir todos para que sea leida la linea, 
        //con estos elementos de la estructura de filtro se compararan cada uno de los elementos de la estructura $arregloresult explicada anteriormente
        //(importante) en caso e querer modificar valores en todas las lineas del fichero, este par�metro soporta el valor '*', que le indica al procedimiento que realize la sustituci�n en todas las lineas del fichero sin hacer filtrado
        //$La_estructura_sustituta es un arreglo con los pares $llave -> $valor que se sustituiran en la linea del txt si coincide la combinacion de filtrado, estos pares pueden o no ser parte de los pares de la combinacion de filtrado
        //$Ls_separador es el string separador de los elemento de la linea del fichero txt, en el ejemplo anterior se tomo como separador '::'
        //$Ls_path_fich es el path del fichero txt al que se hara el filtrado
        //$Ls_llave_unica define una llave de las contenidas en el arreglo $La_estructura_filtro como condicion para que cuando esta llave y su valor sean encontrados en la linea del txt, se detenga la busqueda por las lineas restantes del fichero, es decir se detenga el proceso de filtrado y se pase al termino de la gestion de este procedimiento
        //si su valor es vacio no se tomara en cuenta como condicion, esta llave puede estar sola o acompanada de otras en $La_estructura_filtro
        //este procedimiento retorna
        //true si encuentra elemento al que aplicar la condicion de filtrado y lo realiza satisfactoriamente
        //retorna false si encuentra elemento al que aplicar la condicion de filtrado y no le es posible realizar los cambios en el fichero o se le pasan valores incompatibles a los parametros del procedimiento.
        //retorna null si no encuentra elemento al que aplicar la condicion de filtrado

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
                                    //si un elemento de filtrado es id y es llave unica, $fin_filtrado = true acaba con la busqueda por ser este id de valor unico en este tipo de fichero txt
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
                    //echo 'El filtrado se realizo satisfactoriamente. <p>';
                    return true ;
                }
                else
                {
                    //echo 'No se pudo realizar el filtrado. <p>';
                    return false ;
                }
            }
            else
            {
                //echo 'No se encontro elemento a aplicar condicion de filtrado. <p>';
                return null ;
            }
        }

    }

?>