<?php

/*
 * SOCKELETOM Esqueleto con Sockets, como Motor de Códigos PHP en forma de módulos
 * Copyright (C) 2010-2017 Alain Borrell Castellanos
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * email-contact bcalain@gmail.com
 */
/**
 * ProcedimientosElementosLog class
 *
 * @version 0.0.1
 * @author Alain Borrell Castellanos <bcalain@gmail.com>
 * @link https://github.com/bcalain/SOCKELETOM
 * @copyright Copyright 2010-2017 Alain Borrell Castellanos
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
 *          @dependency trait \Emod\Nucleo\DependenciasEstaticasEntidadesEmod
 *          @dependency class \Emod\Nucleo\NucleoControl
 */

namespace Emod\Nucleo\Logs\Gedegl;

class ProcedimientosGestoresElementosLog
	{
		use \Emod\Nucleo\DependenciasEstaticasEntidadesEmod ;
		
		public static function fichero( $fichero = NULL )
			{
				return $fichero;
			}
		
		public static function linea( $linea = NULL )
			{
				return $linea;
			}
		
		public static function namespace_gedee_proceso()
			{
				if( empty( self::$EEoNucleo ) )
					{
						self::cargarObjetosDependencia( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' );
					}
				return self::$EEoNucleo->namespaceGedeeProcesoEjecucion();
			}
		
		public static function class_gedee_proceso()
			{
				if( empty( self::$EEoNucleo ) )
					{
						self::cargarObjetosDependencia( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' );
					}
				return self::$EEoNucleo->claseGedeeProcesoEjecucion();
			}
		
		public static function id_proceso()
			{
				if( empty( self::$EEoNucleo ) )
					{
						self::cargarObjetosDependencia( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' );
					}
				return self::$EEoNucleo->idProcesoEjecucion();
			}
		
		public static function tiempo_unix()
			{
				return time();
			}
		
		public static function estado_proceso( $estado = 1 )
			{
				if( !empty( $estado ) && is_int( $estado ) )
					{
						switch( $estado )
							{
								case 1 :
									return 'comienzo_ejecucion';
								case 2 :
									return 'fin_ejecucion';
								default :
									return 'indefinido';
							}
						return NULL;
					}
			}
		
		public static function registro_ejecucion_arbol_procesos()
			{
				if( empty( self::$EEoNucleo ) )
					{
						self::cargarObjetosDependencia( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' );
					}
				return self::$EEoNucleo->reapProcesoEjecucion();
			}
	}

?>