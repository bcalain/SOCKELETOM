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
 * GedeglTxtEmod class
 *
 * @version 0.0.1
 * @author Alain Borrell Castellanos <bcalain@gmail.com>
 * @link https://github.com/bcalain/SOCKELETOM
 * @copyright Copyright 2010-2017 Alain Borrell Castellanos
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
 *          @dependency class \Emod\Nucleo\Herramientas\EDatosFormatoTxt
 *          @dependency class \Emod\Nucleo\Herramientas
 */

namespace Emod\Nucleo\Logs\Gedegl;

class GedeglTxtEmod
	{
		
		private $EDatosFormatoTxt = NULL;
		
		public function __construct()
			{
				if( \Emod\Nucleo\Herramientas::existenciaEntidad( '\Emod\Nucleo\Herramientas' , 'EDatosFormatoTxt' , 'EDatosFormatoTxt' ) )
					{
						$this->EDatosFormatoTxt = \Emod\Nucleo\Herramientas::entidad( '\Emod\Nucleo\Herramientas' , 'EDatosFormatoTxt' , 'EDatosFormatoTxt' );
						return TRUE;
					}
				else
					{
						trigger_error( 'Error de instanciaci&oacute;n, ' . __METHOD__ . ' no se encuentra la herramienta clase (dependencia ) \Emod\Nucleo\Herramientas\EDatosFormatoTxt.' , E_USER_WARNING );
					}
			}
			
		public function filtrarDatosLog( $La_datos_log_filtro , $La_formato_filtrado , $La_matriz_elementos_log )
			{
				if( !empty( $La_datos_log_filtro ) && is_array( $La_datos_log_filtro ) && !empty( $La_matriz_elementos_log ) && isset( $La_formato_filtrado['filtrado']['marca_ausente'] ) )
					{
						foreach( $La_datos_log_filtro as $Ls_llave => &$Ls_valor )
							{
								$Ls_valor = trim( $Ls_valor );
							}
						$La_log_llaves = &$La_matriz_elementos_log;
						$La_datos_log_filtro_result = array ();
						foreach( $La_log_llaves as $Ls_log_llave )
							{
								if( !empty( $La_datos_log_filtro[$Ls_log_llave] ) )
									{
										$La_datos_log_filtro_result[$Ls_log_llave] = trim( $La_datos_log_filtro[$Ls_log_llave] );
									}
								else
									{
										if( $La_formato_filtrado['filtrado']['marca_ausente'] )
											{
												$La_datos_log_filtro_result[$Ls_log_llave] = "( $Ls_log_llave )";
											}
									}
							}
						
						if( !empty( $La_datos_log_filtro_result ) )
							{
								return $La_datos_log_filtro_result;
							}
					}
				return NULL;
			}
			
		public function crearDatosLog( $La_datos_log_filtro , $La_formato_filtrado , $La_matriz_elementos_log , $La_fuente_datos_log )
			{
				if( !empty( $La_datos_log_filtro ) && is_array( $La_datos_log_filtro ) && !empty( $La_matriz_elementos_log ) && !empty( $La_fuente_datos_log['path_fich_log'] ) && !empty( $La_formato_filtrado['formato']['separador'] ) && isset( $La_formato_filtrado['filtrado']['marca_ausente'] ) )
					{
						$La_datos_log_filtro_filtrado = $this->filtrarDatosLog( $La_datos_log_filtro , $La_formato_filtrado , $La_matriz_elementos_log );
						if( $La_datos_log_filtro_filtrado )
							{
								$Ls_datos_log_linea = "\n";
								end( $La_datos_log_filtro_filtrado );
								$Ls_key_elemen_final = key( $La_datos_log_filtro_filtrado );
								foreach( $La_datos_log_filtro_filtrado as $key_dato_log => $valor_dato_log )
									{
										$Ls_datos_log_linea .= $valor_dato_log;
										if( $key_dato_log == $Ls_key_elemen_final )
											{
												break;
											}
										$Ls_datos_log_linea .= $La_formato_filtrado['formato']['separador'];
									}
								
								if( file_put_contents( $La_fuente_datos_log['path_fich_log'] , $Ls_datos_log_linea , FILE_APPEND ) )
									{
										return TRUE;
									}
							}
					}
				return NULL;
			}
			
		public function eliminarDatosLog( $La_datos_log_filtro , $La_formato_filtrado , $La_matriz_elementos_log , $La_fuente_datos_log )
			{
				if( !empty( $La_datos_log_filtro ) && is_array( $La_datos_log_filtro ) && !empty( $La_matriz_elementos_log ) && !empty( $La_fuente_datos_log['path_fich_log'] ) && !empty( $La_formato_filtrado['formato']['separador'] ) )
					{
						if( empty( $La_formato_filtrado['filtrado']['llave_unica'] ) )
							{
								$La_formato_filtrado['filtrado']['llave_unica'] = NULL;
							}
						return \Emod\Nucleo\Herramientas\EDatosFormatoTxt::filtrarEliminarLineaDatos( $La_matriz_elementos_log , $La_datos_log_filtro , $La_formato_filtrado['formato']['separador'] , $La_fuente_datos_log['path_fich_log'] , $La_formato_filtrado['filtrado']['llave_unica'] );
					}
				return NULL;
			}
			
		public function leerDatosLog( $La_datos_log_filtro , $La_formato_filtrado , $La_matriz_elementos_log , $La_fuente_datos_log )
			{
				if( !empty( $La_datos_log_filtro ) && is_array( $La_datos_log_filtro ) && !empty( $La_matriz_elementos_log ) && !empty( $La_fuente_datos_log['path_fich_log'] ) && !empty( $La_formato_filtrado['formato']['separador'] ) )
					{
						if( empty( $La_formato_filtrado['filtrado']['llave_unica'] ) )
							{
								$La_formato_filtrado['filtrado']['llave_unica'] = NULL;
							}
						
						$La_resultado = \Emod\Nucleo\Herramientas\EDatosFormatoTxt::filtrarLeerLineaDatos( $La_matriz_elementos_log , $La_datos_log_filtro , $La_formato_filtrado['formato']['separador'] , $La_fuente_datos_log['path_fich_log'] , $La_formato_filtrado['filtrado']['llave_unica'] );
						if( $La_resultado )
							{
								$La_resultado_datos_log = NULL;
								if( !empty( $La_resultado ) && is_array( $La_resultado ) )
									{
										foreach( $La_resultado as $Ls_linea_log )
											{
												$La_linea_log = explode( $La_formato_filtrado['formato']['separador'] , $Ls_linea_log );
												$La_erreglo_combinado = NULL;
												$La_erreglo_combinado = array_combine( $La_matriz_elementos_log , $La_linea_log );
												if( !empty( $La_erreglo_combinado ) )
													{
														$La_resultado_datos_log[] = $La_erreglo_combinado;
													}
											}
									}
								if( !empty( $La_resultado_datos_log ) )
									{
										return $La_resultado_datos_log;
									}
							}
					}
				return NULL;
			}
			
		public function modificarDatosLog( $La_datos_log_filtro , $La_datos_sustitutos , $La_formato_filtrado , $La_matriz_elementos_log , $La_fuente_datos_log )
			{
				if( !empty( $La_datos_log_filtro ) && is_array( $La_datos_log_filtro ) && is_array( $La_datos_sustitutos ) && !empty( $La_datos_sustitutos ) && !empty( $La_matriz_elementos_log ) && !empty( $La_fuente_datos_log['path_fich_log'] ) && !empty( $La_formato_filtrado['formato']['separador'] ) )
					{
						if( empty( $La_formato_filtrado['filtrado']['llave_unica'] ) )
							{
								$La_formato_filtrado['filtrado']['llave_unica'] = NULL;
							}
						return \Emod\Nucleo\Herramientas\EDatosFormatoTxt::fltrarModificarLineaDatos( $La_matriz_elementos_log , $La_datos_log_filtro , $La_datos_sustitutos , $La_formato_filtrado['formato']['separador'] , $La_fuente_datos_log['path_fich_log'] , $La_formato_filtrado['filtrado']['llave_unica'] );
					}
				return NULL;
			}
			
		public function crearFuenteDatosLog( $La_fuente_datos_log , $Ls_cadena_inicio = '' )
			{
				if( file_put_contents( $La_fuente_datos_log['path_fich_log'] , $Ls_cadena_inicio ) )
					{
						return TRUE;
					}
				else
					{
						return NULL;
					}
			}
			
		public function eliminarFuenteDatosLog( $La_fuente_datos_log )
			{
				if( unlink( $La_fuente_datos_log['path_fich_log'] ) )
					{
						return TRUE;
					}
				else
					{
						return NULL;
					}
			}
	
	}

?>
