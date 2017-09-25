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
 * DependenciasEntidadesEmod trait
 *
 * @version 0.0.1
 * @author Alain Borrell Castellanos <bcalain@gmail.com>
 * @link https://github.com/
 * @copyright Copyright 2010-2017 Alain Borrell Castellanos
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
 *          @dependency class \Emod\Nucleo\CropNucleo
 */

namespace Emod\Nucleo;

trait DependenciasEstaticasEntidadesEmod
  {
	
	protected static $EEoNucleo = NULL;
	protected static $EEoInterfazDatos = NULL;
	protected static $EEoConfiguracion = NULL;
	protected static $EEoSeguridad = NULL;
	protected static $EEoDatos = NULL;
	protected static $EEoImplementacionProcesos = NULL;
	protected static $EEoErrores = NULL;
	
	final static public function cargarObjetosDependencia( $id_objeto , $class , $namespace )
		{
			if( !empty( $id_objeto ) && ( \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace ) != NULL ) )
				{
					switch( $id_objeto )
						{
							case 'EEoNucleo' :
								if( self::$EEoNucleo == NULL )
									{
										self::$EEoNucleo = \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace );
										if( empty( self::$EEoNucleo ) )
											{
												trigger_error( "No se pudo referenciar la entidad EEoNucleo en __CLASS__" , E_USER_ERROR );
											}
										return TRUE;
									}
								break;
							
							case 'EEoInterfazDatos' :
								if( self::$EEoInterfazDatos == NULL )
									{
										self::$EEoInterfazDatos = \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace );
										if( empty( self::$EEoInterfazDatos ) )
											{
												trigger_error( "No se pudo referenciar la entidad EEoInterfazDatos en __CLASS__" , E_USER_ERROR );
											}
										return TRUE;
									}
								break;
							
							case 'EEoSeguridad' :
								if( self::$EEoSeguridad == NULL )
									{
										self::$EEoSeguridad = \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace );
										if( empty( self::$EEoSeguridad ) )
											{
												trigger_error( "No se pudo referenciar la entidad EEoSeguridad en __CLASS__" , E_USER_ERROR );
											}
										return TRUE;
									}
								break;
							
							case 'EEoConfiguracion' :
								if( self::$EEoConfiguracion == NULL )
									{
										self::$EEoConfiguracion = \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace );
										if( empty( self::$EEoConfiguracion ) )
											{
												trigger_error( "No se pudo referenciar la entidad EEoConfiguracion en __CLASS__" , E_USER_ERROR );
											}
										return TRUE;
									}
								break;
							
							case 'EEoDatos' :
								if( self::$EEoDatos == NULL )
									{
										self::$EEoDatos = \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace );
										if( empty( self::$EEoDatos ) )
											{
												trigger_error( "No se pudo referenciar la entidad EEoDatos en __CLASS__" , E_USER_ERROR );
											}
										return TRUE;
									}
								break;
							
							case 'EEoImplementacionProcesos' :
								if( self::$EEoImplementacionProcesos == NULL )
									{
										self::$EEoImplementacionProcesos = \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace );
										if( empty( self::$EEoImplementacionProcesos ) )
											{
												trigger_error( "No se pudo referenciar la entidad EEoImplementacionProcesos en __CLASS__" , E_USER_ERROR );
											}
										return TRUE;
									}
								break;
							
							case 'EEoErrores' :
								if( self::$EEoErrores == NULL )
									{
										self::$EEoErrores = \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace );
										if( empty( self::$EEoErrores ) )
											{
												trigger_error( "No se pudo referenciar la entidad EEoErrores en __CLASS__" , E_USER_ERROR );
											}
										return TRUE;
									}
								break;
						}
				}
			return NULL;
		}
  }

?>
