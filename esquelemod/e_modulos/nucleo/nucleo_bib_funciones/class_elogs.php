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
 * ELogs class
 *
 * @version 0.0.1
 * @author Alain Borrell Castellanos <bcalain@gmail.com>
 * @link https://github.com/bcalain/SOCKELETOM
 * @copyright Copyright 2010-2017 Alain Borrell Castellanos
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
 *          @dependency trait \Emod\Nucleo\DependenciasEntidadesEmod
 *          @dependency class \Emod\Nucleo\NucleoControl
 *          @dependency class \Emod\Nucleo\Herramientas
 */

namespace Emod\Nucleo\Logs;

class ELogs
	{
		use \Emod\Nucleo\DependenciasEntidadesEmod ;
		
		// protected $EEoNucleo = NULL ;
		
		private $lbIniciacion = NULL;
		
		private $GEDEGLDefecto = NULL;
		private $lsTipoEntidadGEDEGLDefecto = NULL;
		
		private $PGERLDefecto = NULL;
		private $lsTipoEntidadPGERLDefecto = NULL;
		
		private $laElementosRegistroLog = NULL;
		private $laFuenteDatosLog = NULL;
		private $laFormatoRegistroLog = NULL;
		
		public function __construct( $Ls_path_raiz_log , array $La_gedegl_emod , array $La_pgerl_emod , array $La_elementos_registro_log , array $La_formato_registro_log , array $La_fuente_datos_log )
			{
				
				if( !empty( $La_gedegl_emod ) )
					{
						$this->cargarObjetosDependencia( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' );
						
						reset( $La_gedegl_emod );
						$namespace_gedegl_emod = key( $La_gedegl_emod );
						reset( $La_gedegl_emod[$namespace_gedegl_emod] );
						$clase_gedegl_emod = key( $La_gedegl_emod[$namespace_gedegl_emod] );
						reset( $La_gedegl_emod[$namespace_gedegl_emod][$clase_gedegl_emod]['instancias'] );
						$id_entidad_gedegl_emod = key( $La_gedegl_emod[$namespace_gedegl_emod][$clase_gedegl_emod]['instancias'] );
					}
				if( empty( $this->lbIniciacion ) && !empty( $Ls_path_raiz_log ) && !empty( $namespace_gedegl_emod ) && !empty( $clase_gedegl_emod ) && !empty( $id_entidad_gedegl_emod ) && !empty( $La_elementos_registro_log ) && !empty( $La_formato_registro_log ) && !empty( $La_fuente_datos_log ) )
					{
						$iniciacion1 = FALSE;
						$a = \Emod\Nucleo\Herramientas::gestionIngresoEntidad( $namespace_gedegl_emod , $clase_gedegl_emod , $La_gedegl_emod[$namespace_gedegl_emod][$clase_gedegl_emod]['path_entidad_clase'] , $La_gedegl_emod[$namespace_gedegl_emod][$clase_gedegl_emod]['referencia_path_entidad'] , $La_gedegl_emod[$namespace_gedegl_emod][$clase_gedegl_emod]['tipo_entidad'] , $La_gedegl_emod[$namespace_gedegl_emod][$clase_gedegl_emod]['instancias'] , $Ls_iniciacion = NULL );
						$this->lsTipoEntidadGEDEGLDefecto = \Emod\Nucleo\Herramientas::existenciaEntidad( $namespace_gedegl_emod , $clase_gedegl_emod , $id_entidad_gedegl_emod );
						
						if( $this->lsTipoEntidadGEDEGLDefecto )
							{
								$this->GEDEGLDefecto = \Emod\Nucleo\Herramientas::entidad( $namespace_gedegl_emod , $clase_gedegl_emod , $id_entidad_gedegl_emod );
								$iniciacion1 = TRUE;
							}
					}
				if( !empty( $La_pgerl_emod ) )
					{
						$this->cargarObjetosDependencia( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' );
						
						reset( $La_pgerl_emod );
						$namespace_pgerl_emod = key( $La_pgerl_emod );
						reset( $La_pgerl_emod[$namespace_pgerl_emod] );
						$clase_pgerl_emod = key( $La_pgerl_emod[$namespace_pgerl_emod] );
						reset( $La_pgerl_emod[$namespace_pgerl_emod][$clase_pgerl_emod]['instancias'] );
						$id_entidad_pgerl_emod = key( $La_pgerl_emod[$namespace_pgerl_emod][$clase_pgerl_emod]['instancias'] );
					}
				
				if( empty( $this->lbIniciacion ) && !empty( $Ls_path_raiz_log ) && !empty( $namespace_pgerl_emod ) && !empty( $clase_pgerl_emod ) && !empty( $id_entidad_pgerl_emod ) && !empty( $La_elementos_registro_log ) && !empty( $La_formato_registro_log ) && !empty( $La_fuente_datos_log ) )
					{
						$iniciacion2 = FALSE;
						\Emod\Nucleo\Herramientas::gestionIngresoEntidad( $namespace_pgerl_emod , $clase_pgerl_emod , $La_pgerl_emod[$namespace_pgerl_emod][$clase_pgerl_emod]['path_entidad_clase'] , $La_pgerl_emod[$namespace_pgerl_emod][$clase_pgerl_emod]['referencia_path_entidad'] , $La_pgerl_emod[$namespace_pgerl_emod][$clase_pgerl_emod]['tipo_entidad'] , $La_pgerl_emod[$namespace_pgerl_emod][$clase_pgerl_emod]['instancias'] , $Ls_iniciacion = NULL );
						$this->lsTipoEntidadPGERLDefecto = \Emod\Nucleo\Herramientas::existenciaEntidad( $namespace_pgerl_emod , $clase_pgerl_emod , $id_entidad_pgerl_emod );
						if( $this->lsTipoEntidadPGERLDefecto )
							{
								$this->PGERLDefecto = \Emod\Nucleo\Herramientas::entidad( $namespace_pgerl_emod , $clase_pgerl_emod , $id_entidad_pgerl_emod );
								$iniciacion2 = TRUE;
							}
					}
				
				if( $iniciacion1 && $iniciacion2 )
					{
						$this->laElementosRegistroLog = $La_elementos_registro_log;
						
						$this->laFormatoRegistroLog = $La_formato_registro_log;
						
						if( empty( $La_fuente_datos_log['referencia_path_fichlog'] ) || ( ( $La_fuente_datos_log['referencia_path_fichlog'] != 'relativo' ) && ( $La_fuente_datos_log['referencia_path_fichlog'] != 'relativo_esquelemod' ) && ( $La_fuente_datos_log['referencia_path_fichlog'] != 'absoluto' ) ) )
							{
								$La_fuente_datos_log['referencia_path_fichlog'] = 'relativo';
							}
						
						if( $La_fuente_datos_log['referencia_path_fichlog'] == 'relativo' )
							{
								$La_fuente_datos_log['path_fich_log'] = $this->EEoNucleo->pathDirEsquelemod() . '/e_modulos/' . $Ls_path_raiz_log . '/' . $La_fuente_datos_log['path_fich_log'];
							}
						elseif( $La_fuente_datos_log['referencia_path_fichlog'] == 'relativo_esquelemod' )
							{
								$La_fuente_datos_log['path_fich_log'] = $this->EEoNucleo->pathDirEsquelemod() . '/' . $La_fuente_datos_error['path_fich_log'];
							}
						
						$this->laFuenteDatosLog = $La_fuente_datos_log;
						
						$this->lbIniciacion = TRUE;
						return TRUE;
					}
				
				die( 'ERROR, existen par&aacute;metros incompatibles con la gesti&oacute;n de instanciaci&oacute;n de esta clase :' . __CLASS__ );
			}
		
		protected function implementarProcedimientosEntidades( $Ls_nombre_funcion , &$La_parametros = NULL )
			{
				if( !empty( $this->lbIniciacion ) && !empty( $Ls_nombre_funcion ) )
					{
						$resultado = NULL;
						$cantidad_parametros = NULL;
						if( is_array( $La_parametros ) && !empty( $La_parametros ) )
							{
								$cantidad_parametros = count( $La_parametros );
							}
						
						if( $cantidad_parametros )
							{
								if( ( $this->lsTipoEntidadGEDEGLDefecto == 'objeto' ) && is_object( $this->GEDEGLDefecto ) )
									{
										$sentencia = ' $resultado = $this->GEDEGLDefecto->' . $Ls_nombre_funcion . '( ';
									}
								elseif( ( $this->lsTipoEntidadGEDEGLDefecto == 'clase' ) && is_string( $this->GEDEGLDefecto ) )
									{
										$sentencia = ' $resultado = $this->GEDEGLDefecto::' . $Ls_nombre_funcion . '( ';
									}
								else
									{
										die( "<p> ERROR FATAL, no se puede implementar la funci&oacute;n $Ls_nombre_funcion en  " . __METHOD__ . __LINE__ );
									}
								
								for( $i = 0 ; $i < $cantidad_parametros ; $i++ )
									{
										if( $i == ( $cantidad_parametros - 1 ) )
											{
												$sentencia .= "\$La_parametros[$i] );";
											}
										else
											{
												$sentencia .= "\$La_parametros[$i] , ";
											}
									}
							}
						else
							{
								if( ( $this->lsTipoEntidadGEDEGLDefecto == 'objeto' ) && is_object( $this->GEDEGLDefecto ) )
									{
										$sentencia = ' $resultado = $this->GEDEGLDefecto->' . $Ls_nombre_funcion . '() ';
									}
								elseif( ( $this->lsTipoEntidadGEDEGLDefecto == 'clase' ) && is_string( $this->GEDEGLDefecto ) )
									{
										$sentencia = ' $resultado = $this->GEDEGLDefecto::' . $Ls_nombre_funcion . '() ';
									}
								else
									{
										die( "<p> ERROR FATAL, no se puede implementar la funci&oacute;n $Ls_nombre_funcion en  " . __METHOD__ . __LINE__ );
									}
							}
						
						eval( $sentencia );
						
						return $resultado;
					}
				
				die( "<p> ERROR FATAL, no se puede implementar la funci&oacute;n $Ls_nombre_funcion en  " . __METHOD__ . __LINE__ );
			}
		
		public function filtrarDatosLog()
			{
				if( !empty( $this->lbIniciacion ) )
					{
						$La_parametros = func_get_args();
						
						if( !empty( $La_parametros ) && is_array( $La_parametros ) )
							{
								$ultimo_parametro = end( $La_parametros );
								$La_arreglo_intercambio = array ();
								
								if( !empty( $ultimo_parametro['formato'] ) || !empty( $ultimo_parametro['filtrado'] ) )
									{
										if( isset( $ultimo_parametro['formato'] ) && !empty( $this->laFormatoRegistroLog['formato'] ) )
											{
												$La_arreglo_intercambio['formato'] = array_merge( $ultimo_parametro['formato'] , $this->laFormatoRegistroLog['formato'] );
											}
										elseif( isset( $ultimo_parametro['formato'] ) )
											{
												$La_arreglo_intercambio['formato'] = $ultimo_parametro['formato'];
											}
										elseif( !empty( $this->laFormatoRegistroLog['formato'] ) )
											{
												$La_arreglo_intercambio['formato'] = $this->laFormatoRegistroLog['formato'];
											}
										
										if( isset( $ultimo_parametro['filtrado'] ) && !empty( $this->laFormatoRegistroLog['filtrado'] ) )
											{
												$La_arreglo_intercambio['filtrado'] = array_merge( $ultimo_parametro['filtrado'] , $this->laFormatoRegistroLog['filtrado'] );
											}
										elseif( isset( $ultimo_parametro['filtrado'] ) )
											{
												$La_arreglo_intercambio['filtrado'] = $ultimo_parametro['filtrado'];
											}
										elseif( !empty( $this->laFormatoRegistroLog['filtrado'] ) )
											{
												$La_arreglo_intercambio['filtrado'] = $this->laFormatoRegistroLog['filtrado'];
											}
										
										if( !empty( $La_arreglo_intercambio ) )
											{
												$ultimo_parametro = $La_arreglo_intercambio;
											}
										reset( $La_parametros );
									
									}
								elseif( !empty( $this->laFormatoRegistroLog ) )
									{
										$La_parametros[] = $this->laFormatoRegistroLog;
									}
							}
						elseif( !empty( $this->laFormatoRegistroLog ) )
							{
								$La_parametros[] = $this->laFormatoRegistroLog;
							}
						
						if( !empty( $this->laElementosRegistroLog ) )
							{
								$La_parametros[] = $this->laElementosRegistroLog;
							}
						
						return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros );
					}
			}
		
		public function crearDatosLog()
			{
				if( !empty( $this->lbIniciacion ) )
					{
						$La_parametros = func_get_args();
						
						if( !empty( $La_parametros ) && is_array( $La_parametros ) )
							{
								$ultimo_parametro = end( $La_parametros );
								$La_arreglo_intercambio = array ();
								
								if( !empty( $ultimo_parametro['formato'] ) || !empty( $ultimo_parametro['filtrado'] ) )
									{
										if( isset( $ultimo_parametro['formato'] ) && !empty( $this->laFormatoRegistroLog['formato'] ) )
											{
												$La_arreglo_intercambio['formato'] = array_merge( $ultimo_parametro['formato'] , $this->laFormatoRegistroLog['formato'] );
											}
										elseif( isset( $ultimo_parametro['formato'] ) )
											{
												$La_arreglo_intercambio['formato'] = $ultimo_parametro['formato'];
											}
										elseif( !empty( $this->laFormatoRegistroLog['formato'] ) )
											{
												$La_arreglo_intercambio['formato'] = $this->laFormatoRegistroLog['formato'];
											}
										
										if( isset( $ultimo_parametro['filtrado'] ) && !empty( $this->laFormatoRegistroLog['filtrado'] ) )
											{
												$La_arreglo_intercambio['filtrado'] = array_merge( $ultimo_parametro['filtrado'] , $this->laFormatoRegistroLog['filtrado'] );
											}
										elseif( isset( $ultimo_parametro['filtrado'] ) )
											{
												$La_arreglo_intercambio['filtrado'] = $ultimo_parametro['filtrado'];
											}
										elseif( !empty( $this->laFormatoRegistroLog['filtrado'] ) )
											{
												$La_arreglo_intercambio['filtrado'] = $this->laFormatoRegistroLog['filtrado'];
											}
										
										if( !empty( $La_arreglo_intercambio ) )
											{
												$ultimo_parametro = $La_arreglo_intercambio;
											}
										reset( $La_parametros );
									
									}
								elseif( !empty( $this->laFormatoRegistroLog ) )
									{
										$La_parametros[] = $this->laFormatoRegistroLog;
									}
							}
						elseif( !empty( $this->laFormatoRegistroLog ) )
							{
								$La_parametros[] = $this->laFormatoRegistroLog;
							}
						
						if( !empty( $this->laElementosRegistroLog ) )
							{
								$La_parametros[] = $this->laElementosRegistroLog;
							}
						if( !empty( $this->laFuenteDatosLog ) )
							{
								$La_parametros[] = $this->laFuenteDatosLog;
							}
						
						return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros );
					}
				return NULL;
			}
		
		public function eliminarDatosLog()
			{
				if( !empty( $this->lbIniciacion ) )
					{
						$La_parametros = func_get_args();
						
						if( !empty( $La_parametros ) && is_array( $La_parametros ) )
							{
								$ultimo_parametro = end( $La_parametros );
								$La_arreglo_intercambio = array ();
								
								if( !empty( $ultimo_parametro['formato'] ) || !empty( $ultimo_parametro['filtrado'] ) )
									{
										if( isset( $ultimo_parametro['formato'] ) && !empty( $this->laFormatoRegistroLog['formato'] ) )
											{
												$La_arreglo_intercambio['formato'] = array_merge( $ultimo_parametro['formato'] , $this->laFormatoRegistroLog['formato'] );
											}
										elseif( isset( $ultimo_parametro['formato'] ) )
											{
												$La_arreglo_intercambio['formato'] = $ultimo_parametro['formato'];
											}
										elseif( !empty( $this->laFormatoRegistroLog['formato'] ) )
											{
												$La_arreglo_intercambio['formato'] = $this->laFormatoRegistroLog['formato'];
											}
										
										if( isset( $ultimo_parametro['filtrado'] ) && !empty( $this->laFormatoRegistroLog['filtrado'] ) )
											{
												$La_arreglo_intercambio['filtrado'] = array_merge( $ultimo_parametro['filtrado'] , $this->laFormatoRegistroLog['filtrado'] );
											}
										elseif( isset( $ultimo_parametro['filtrado'] ) )
											{
												$La_arreglo_intercambio['filtrado'] = $ultimo_parametro['filtrado'];
											}
										elseif( !empty( $this->laFormatoRegistroLog['filtrado'] ) )
											{
												$La_arreglo_intercambio['filtrado'] = $this->laFormatoRegistroLog['filtrado'];
											}
										
										if( !empty( $La_arreglo_intercambio ) )
											{
												$ultimo_parametro = $La_arreglo_intercambio;
											}
										reset( $La_parametros );
									
									}
								elseif( !empty( $this->laFormatoRegistroLog ) )
									{
										$La_parametros[] = $this->laFormatoRegistroLog;
									}
							}
						elseif( !empty( $this->laFormatoRegistroLog ) )
							{
								$La_parametros[] = $this->laFormatoRegistroLog;
							}
						
						if( !empty( $this->laElementosRegistroLog ) )
							{
								$La_parametros[] = $this->laElementosRegistroLog;
							}
						if( !empty( $this->laFuenteDatosLog ) )
							{
								$La_parametros[] = $this->laFuenteDatosLog;
							}
						
						return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros );
					}
				return NULL;
			}
		
		public function leerDatosLog()
			{
				if( !empty( $this->lbIniciacion ) )
					{
						$La_parametros = func_get_args();
						
						if( !empty( $La_parametros ) && is_array( $La_parametros ) )
							{
								$ultimo_parametro = end( $La_parametros );
								$La_arreglo_intercambio = array ();
								
								if( !empty( $ultimo_parametro['formato'] ) || !empty( $ultimo_parametro['filtrado'] ) )
									{
										if( isset( $ultimo_parametro['formato'] ) && !empty( $this->laFormatoRegistroLog['formato'] ) )
											{
												$La_arreglo_intercambio['formato'] = array_merge( $ultimo_parametro['formato'] , $this->laFormatoRegistroLog['formato'] );
											}
										elseif( isset( $ultimo_parametro['formato'] ) )
											{
												$La_arreglo_intercambio['formato'] = $ultimo_parametro['formato'];
											}
										elseif( !empty( $this->laFormatoRegistroLog['formato'] ) )
											{
												$La_arreglo_intercambio['formato'] = $this->laFormatoRegistroLog['formato'];
											}
										
										if( isset( $ultimo_parametro['filtrado'] ) && !empty( $this->laFormatoRegistroLog['filtrado'] ) )
											{
												$La_arreglo_intercambio['filtrado'] = array_merge( $ultimo_parametro['filtrado'] , $this->laFormatoRegistroLog['filtrado'] );
											}
										elseif( isset( $ultimo_parametro['filtrado'] ) )
											{
												$La_arreglo_intercambio['filtrado'] = $ultimo_parametro['filtrado'];
											}
										elseif( !empty( $this->laFormatoRegistroLog['filtrado'] ) )
											{
												$La_arreglo_intercambio['filtrado'] = $this->laFormatoRegistroLog['filtrado'];
											}
										
										if( !empty( $La_arreglo_intercambio ) )
											{
												$ultimo_parametro = $La_arreglo_intercambio;
											}
										reset( $La_parametros );
									
									}
								elseif( !empty( $this->laFormatoRegistroLog ) )
									{
										$La_parametros[] = $this->laFormatoRegistroLog;
									}
							}
						elseif( !empty( $this->laFormatoRegistroLog ) )
							{
								$La_parametros[] = $this->laFormatoRegistroLog;
							}
						
						if( !empty( $this->laElementosRegistroLog ) )
							{
								$La_parametros[] = $this->laElementosRegistroLog;
							}
						if( !empty( $this->laFuenteDatosLog ) )
							{
								$La_parametros[] = $this->laFuenteDatosLog;
							}
						
						return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros );
					}
				return NULL;
			}
		
		public function modificarDatosLog()
			{
				if( !empty( $this->lbIniciacion ) )
					{
						$La_parametros = func_get_args();
						
						if( !empty( $La_parametros ) && is_array( $La_parametros ) )
							{
								$ultimo_parametro = end( $La_parametros );
								$La_arreglo_intercambio = array ();
								
								if( !empty( $ultimo_parametro['formato'] ) || !empty( $ultimo_parametro['filtrado'] ) )
									{
										if( isset( $ultimo_parametro['formato'] ) && !empty( $this->laFormatoRegistroLog['formato'] ) )
											{
												$La_arreglo_intercambio['formato'] = array_merge( $ultimo_parametro['formato'] , $this->laFormatoRegistroLog['formato'] );
											}
										elseif( isset( $ultimo_parametro['formato'] ) )
											{
												$La_arreglo_intercambio['formato'] = $ultimo_parametro['formato'];
											}
										elseif( !empty( $this->laFormatoRegistroLog['formato'] ) )
											{
												$La_arreglo_intercambio['formato'] = $this->laFormatoRegistroLog['formato'];
											}
										
										if( isset( $ultimo_parametro['filtrado'] ) && !empty( $this->laFormatoRegistroLog['filtrado'] ) )
											{
												$La_arreglo_intercambio['filtrado'] = array_merge( $ultimo_parametro['filtrado'] , $this->laFormatoRegistroLog['filtrado'] );
											}
										elseif( isset( $ultimo_parametro['filtrado'] ) )
											{
												$La_arreglo_intercambio['filtrado'] = $ultimo_parametro['filtrado'];
											}
										elseif( !empty( $this->laFormatoRegistroLog['filtrado'] ) )
											{
												$La_arreglo_intercambio['filtrado'] = $this->laFormatoRegistroLog['filtrado'];
											}
										
										if( !empty( $La_arreglo_intercambio ) )
											{
												$ultimo_parametro = $La_arreglo_intercambio;
											}
										reset( $La_parametros );
									
									}
								elseif( !empty( $this->laFormatoRegistroLog ) )
									{
										$La_parametros[] = $this->laFormatoRegistroLog;
									}
							}
						elseif( !empty( $this->laFormatoRegistroLog ) )
							{
								$La_parametros[] = $this->laFormatoRegistroLog;
							}
						
						if( !empty( $this->laElementosRegistroLog ) )
							{
								$La_parametros[] = $this->laElementosRegistroLog;
							}
						if( !empty( $this->laFuenteDatosLog ) )
							{
								$La_parametros[] = $this->laFuenteDatosLog;
							}
						
						return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros );
					}
				return NULL;
			}
		
		public function crearFuenteDatosLog()
			{
				if( !empty( $this->lbIniciacion ) )
					{
						$La_parametros = func_get_args();
						
						return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros );
					}
				return NULL;
			}
		
		public function eliminarFuenteDatosLog()
			{
				if( !empty( $this->lbIniciacion ) )
					{
						$La_parametros = func_get_args();
						if( !empty( $this->laFuenteDatosLog ) )
							{
								$La_parametros[] = $this->laFuenteDatosLog;
							}
						
						return $this->implementarProcedimientosEntidades( __FUNCTION__ , $La_parametros );
					}
				return NULL;
			}
		
		public function log( $La_datos_miembros_registro = NULL , $La_elementos_registro_log = NULL , $La_formato_registro_log = NULL , $La_fuente_datos_log = NULL )
			{
				if( !empty( $this->lbIniciacion ) )
					{
						if( empty( $La_elementos_registro_log ) || !is_array( $La_elementos_registro_log ) )
							{
								$La_elementos_registro_log = $this->laElementosRegistroLog;
							}
						if( empty( $La_formato_registro_log ) || !is_array( $La_formato_registro_log ) )
							{
								$La_formato_registro_log = $this->laFormatoRegistroLog;
							}
						if( empty( $La_fuente_datos_log ) || !is_array( $La_fuente_datos_log ) )
							{
								$La_fuente_datos_log = $this->laFuenteDatosLog;
							}
						
						$La_registro_log = array ();
						$func_array_ejecucion = array ();
						foreach( $La_elementos_registro_log as $miembro_registro_log )
							{
								if( $this->lsTipoEntidadPGERLDefecto == 'clase' )
									{
										$func_array_ejecucion = array ( $this->PGERLDefecto , $miembro_registro_log );
										
										if ( isset( $La_datos_miembros_registro[$miembro_registro_log] ) )
										{
											$Ls_ejecutando_procedimientos = '$La_registro_log[$miembro_registro_log] = $func_array_ejecucion(';
											$Li_cantid_parametros = count( $La_datos_miembros_registro[$miembro_registro_log] );
											
											$Li_contador=1;
											
											foreach ( $La_datos_miembros_registro[$miembro_registro_log] as $dato_parametro )
											{
												$Ls_ejecutando_procedimientos.= '$La_datos_miembros_registro[$miembro_registro_log][$Li_contador-1]';
												
												if ( $Li_contador < ( $Li_cantid_parametros ) )
												{
													$Ls_ejecutando_procedimientos.= ' , ';
													$Li_contador++;
												}
												else
												{
													$Ls_ejecutando_procedimientos.= ' ) ; ';
												}
											}
											
											eval( $Ls_ejecutando_procedimientos);
										}
										else
										{
											$La_registro_log[$miembro_registro_log] = $func_array_ejecucion();
										}
									}
								elseif( $this->lsTipoEntidadPGERLDefecto == 'objeto' )
									{
										$func_array_ejecucion = $miembro_registro_log;
										
										if ( isset( $La_datos_miembros_registro[$miembro_registro_log] ) )
										{
											$Ls_ejecutando_procedimientos = '$La_registro_log[$miembro_registro_log] = $this->lsTipoEntidadPGERLDefecto->$func_array_ejecucion(';
											$Li_cantid_parametros = count( $La_datos_miembros_registro[$miembro_registro_log] );
											
											$Li_contador=1;
											
											foreach ( $La_datos_miembros_registro[$miembro_registro_log] as $dato_parametro )
											{
												$Ls_ejecutando_procedimientos.= '$La_datos_miembros_registro[$miembro_registro_log][$Li_contador-1]';
												
												if ( $Li_contador < ( $Li_cantid_parametros ) )
												{
													$Ls_ejecutando_procedimientos.= ' , ';
													$Li_contador++;
												}
												else
												{
													$Ls_ejecutando_procedimientos.= ' ) ; ';
												}
											}
											eval( $Ls_ejecutando_procedimientos);
										}
										else
										{
											$La_registro_log[$miembro_registro_log] = $this->lsTipoEntidadPGERLDefecto->$func_array_ejecucion();
										}
									}
							}
						
						if( !empty( $La_registro_log ) && $this->crearDatosLog( $La_registro_log , $La_formato_registro_log , $La_elementos_registro_log , $La_fuente_datos_log ) )
							{
								return TRUE;
							}
					}
				trigger_error( 'No se pudo crear el registro log' , E_USER_WARNING );
				return NULL;
			}
		
		public function entidadGEDEGLDefecto()
			{
				return $this->GEDEGLDefecto;
			}
		
		public function tipoEntidadGEDEGLDefecto()
			{
				return $this->lsTipoEntidadGEDEGLDefecto;
			}
	
	}
?>
