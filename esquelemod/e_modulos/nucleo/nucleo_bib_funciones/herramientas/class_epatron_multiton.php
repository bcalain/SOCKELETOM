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
   * Multiton class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */
    namespace Emod\Nucleo\Herramientas;

    abstract class Multiton
        {

        private static $laInstancias = array( );

        //Obtiene la instancia de la clase a instanciar, pero si la instancia ya existe, entonces debuelbe null
        //se podr�a programar de forma tal que si la instancia estaba creada se debuelba la instancia pero prefiero ser fiel al nombre del procedimiento
        //ademas de por cuestiones de claridad y organizaci�n si quiero acceder a la instancia ya creada anteriormente , entonces la pondr�a en un contenedor de referencias a objetos.

        final public static function instanciar()
            {
            $clase = get_called_class();
            if ( !isset( self::$laInstancias[$clase] ) || !( self::$laInstancias[$clase] instanceof $clase ) )
                {
                self::$laInstancias[$clase] = new $clase;
                }
            else
                {
                return null;
                }
            return self::$laInstancias[$clase];
            }

        //se privatiza el metodo constructor para que no se pueda instanciar la clase 

        private function __construct()
            {
            
            }

        //se privatiza el metodo __clone para que no se pueda clonar el objeto

        final private function __clone()
            {
            
            }

        }

?>