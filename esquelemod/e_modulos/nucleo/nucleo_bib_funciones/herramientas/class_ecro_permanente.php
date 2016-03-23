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
   * CroPermanente class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */

    namespace Emod\Nucleo\Herramientas;

    //clase que sirve de contenedor de referencias a objetos y servidor de estos, sirve punteros por referencia a estos objetos o clonaciones de ellos
    //esta clase anula la posibilidad de eliminar una referencia de objeto ingresada en el contenedor de ereferencia de esta clase $La_contenedor_objetos 
    abstract class CroPermanente
        {

        //es un arreglo que contendr� las referencias a objetos junto con el id para referenciarlo y el nameespace y class a que este objeto pertenece, la estructura quedaria asi:
        //$laContenedorObjetos = array( 
        //                                  'nombre nameespace' = array( 
        //                                                               'nombre clase' = array(
        //                                                                                       'id_objeto' = objeto(referencia)
        //                                                                                      )                          
        //                                                              )                                
        //                                 )  
        protected static $laContenedorObjetos = null;

        //procedimiento para ingresar una referencia de objeto al contenedor $this->La_contenedor_objetos
        //$id_objeto es el nombre o id conque se pedira la referencia o clonacion del objeto
        //$objeto objeto a referenciar
        //si al menos uno de los parametros es vacio o $objeto no es de tipo objeto el procedimiento retorna null, , si ya existe una referencia a un objeto con igual $id_objeto, clase y namespace el procedimiento retorna null, si la gestion del procedimiento es satisfactoria el procedimiento retorna true  
        public static function ingresarNuevoObjeto( $id_objeto , &$objeto )
            {
            if ( !empty( $id_objeto ) && !empty( $objeto ) && is_object( $objeto ) )
                {
                $namespace_class = get_class( $objeto );
                $posicion        = strripos( $namespace_class , '\\' );
                $namespace       = substr( $namespace_class , 0 , $posicion );
                $clase           = substr( $namespace_class , $posicion + 1 );

                if ( empty( self::$laContenedorObjetos[$namespace][$clase][$id_objeto] ) )
                    {
                    self::$laContenedorObjetos[$namespace][$clase][$id_objeto] = $objeto;
                    return true;
                    }
                }
            return null;
            }

        //procedimiento para retornar una referencia a un objeto determinado
        //$id_objeto es el nombre o id conque fue referenciado el objeto en su ingreso a la propiedad $laContenedorObjetos de esta clase
        //$class clase a la que pertenece el objeto
        //$namespace nameespace al que pertenece la clase del objeto

        public static function referenciarObjeto( $id_objeto , $class , $namespace )
            {
            if ( !empty( $id_objeto ) && !empty( $class ) && !empty( $namespace ) )
                {
                if ( !empty( self::$laContenedorObjetos[$namespace][$class][$id_objeto] ) )
                    {
                    return self::$laContenedorObjetos[$namespace][$class][$id_objeto];
                    }
                }
            return null;
            }

        //procedimiento para retornar una copia, clonacion de un objeto, retorna la referencia a la clonacion de un objeto
        //$id_objeto es el nombre o id conque fue referenciado el objeto en su ingreso a la propiedad $laContenedorObjetos de esta clase
        //$class clase a la que pertenece el objeto
        //$namespace nameespace al que pertenece la clase del objeto
        public static function clonarObjeto( $id_objeto , $class , $namespace )
            {
            if ( !empty( $id_objeto ) && !empty( $class ) && !empty( $namespace ) )
                {
                if ( !empty( self::$laContenedorObjetos[$namespace][$class][$id_objeto] ) )
                    {
                    return clone self::$laContenedorObjetos[$namespace][$class][$id_objeto];
                    }
                }
            return null;
            }

        //procedimiento para retornar si existe o no un objeto, retorna true si existe y null si no existe en self::$laContenedorObjetos el objeto a gestionar su existencia
        //$id_objeto es el nombre o id conque fue referenciado el objeto en su ingreso a la propiedad $laContenedorObjetos de esta clase
        //$class clase a la que pertenece el objeto
        //$namespace nameespace al que pertenece la clase del objeto
        public static function existenciaObjeto( $id_objeto , $class , $namespace )
            {
            if ( !empty( $id_objeto ) && !empty( $class ) && !empty( $namespace ) )
                {
                if ( !empty( self::$laContenedorObjetos[$namespace][$class][$id_objeto] ) )
                    {
                    return true;
                    }
                }
            return null;
            }

        }

?>