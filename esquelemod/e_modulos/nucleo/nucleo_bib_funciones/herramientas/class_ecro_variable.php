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
   * CroVariable class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */

    namespace Emod\Nucleo\Herramientas;

    abstract class CroVariable extends \Emod\Nucleo\Herramientas\CroPermanente
        {

        public static function eliminarReferenciaObjeto( $id_objeto , $class , $namespace )
            {
            if ( !empty( $id_objeto ) && !empty( $class ) && !empty( $namespace ) )
                {
                if ( !empty( self::$laContenedorObjetos[$namespace][$class][$id_objeto] ) )
                    {
                    unset( self::$laContenedorObjetos[$namespace][$class][$id_objeto] );
                    return true;
                    }
                }
            return null;
            }

        }

?>