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
 * ERouter class
 * @version 0.0.1
 * @author Alain Borrell Castellanos <bcalain@gmail.com>
 * @link https://github.com/bcalain/SOCKELETOM
 * @copyright Copyright 2017 Alain Borrell Castellanos
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
 * @dependence \Emod\Nucleo\Herramientas\ETratamientoMIME
 * @dependence \Emod\Nucleo\DependenciasEntidadesEmod
 */

 namespace Emod\Nucleo\Routers;
 
 class ERouter
 {
 	use \Emod\Nucleo\DependenciasEntidadesEmod ;
 	 	
 	////////////////////////////////////////Punteros a objetos heredados//////////////////////////////////////////////////
 	/* Grupo heredado de \Emod\Nucleo\DependenciasEntidadesEmod
 	protected $EEoNucleo = NULL ;
 	protected $EEoInterfazDatos = NULL ;
 	protected $EEoDatos = NULL ;
 	protected $EEoImplementacionProcesos = NULL ;
 	*/
 	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
 	private $localizacion = NULL ;
 	private $nombreDominioWeb = NULL ;
 	private $lsTipoTransporte = NULL ;
 	private $lsTipoMascara = NULL ;
 	private $laParametrosComplementarios = NULL ;
 	private $laParametrosEntidadEEoInterfazDatos = NULL ;
 	private $lsObjetivoGestion = NULL ;
 	private $lsObjetivoGestionDefecto = NULL ;
 	private $laRestoUrlRealEntradaSeccionada = NULL ;
 	
 	public function __construct($La_configuracion)
 		{
 			if(    empty($La_configuracion['localizacion'])
 				|| empty($La_configuracion['nombre_dominio_web'])
 				|| empty($La_configuracion['tipo_transporte'])
 				|| empty($La_configuracion['tipo_mascara'])
 				|| empty($La_configuracion['parametros_entidad_EEoInterfazDatos'])
 				|| empty($La_configuracion['objetivo_gestion'])
 				|| empty($La_configuracion['objetivo_gestion_defecto'])
 			  )
 				{
 					trigger_error('Uno o mas par&aacute;metros en la construcci&oacute;n del objeto instancia de la clase '.__CLASS__.' tienen valor vac&iacute;o', E_USER_ERROR );
 				}
 			
 			if ( $La_configuracion['localizacion'] == 'hereda' )
 				{
 					$this->localizacion = $this->EEoNucleo->idProcesoEjecucion() ;
 				}
 			else 
 				{
 					$this->localizacion = $La_configuracion['localizacion'] ;
 				}
 				
 			if ( $La_configuracion['nombre_dominio_web'] == 'hereda' )
 				{
 					$this->nombreDominioWeb = $this->EEoNucleo->nombreDominioWeb() ;
 				}
 			else
 				{
 					$this->nombreDominioWeb = $La_configuracion['nombre_dominio_web'] ;
 				}
 			
 			$this->lsTipoTransporte = $La_configuracion['tipo_transporte'] ;
 			$this->lsTipoMascara = $La_configuracion['tipo_mascara'] ;
			if(!empty($La_configuracion['parametros_complementarios'])){$this->laParametrosComplementarios = $La_configuracion['parametros_complementarios'] ;}
 			$this->laParametrosEntidadEEoInterfazDatos = $La_configuracion['parametros_entidad_EEoInterfazDatos'] ;
 			$this->lsObjetivoGestion = $La_configuracion['objetivo_gestion'] ;
 			$this->lsObjetivoGestionDefecto = $La_configuracion['objetivo_gestion_defecto'] ;
 			
 			$this->cargarObjetosDependencia('EEoNucleo', 'NucleoControl', 'Emod\Nucleo');
 			$this->cargarObjetosDependencia('EEoDatos', 'DatosProcesos', 'Emod\Nucleo');
 			$this->cargarObjetosDependencia('EEoInterfazDatos', 'InterfazDatos', 'Emod\Nucleo\Herramientas');
 			$this->cargarObjetosDependencia('EEoImplementacionProcesos', 'ImplementacionProcesos', 'Emod\Nucleo');
 		}
 	
 	public function desenmascararUrlEntrada( $Ls_tipo_transporte = NULL , $Ls_tipo_mascara = NULL , $La_parametros_complementarios = NULL , $La_parametros_entidad_EEoInterfazDatos = NULL )
 		{
 			if( empty( $Ls_tipo_transporte ) ){ $Ls_tipo_transporte = $this->lsTipoTransporte ; }
 				
 			if( empty( $Ls_tipo_mascara ) ){ $Ls_tipo_mascara = $this->lsTipoMascara ; }
 			
 			if( empty( $La_parametros_complementarios ) ){ $La_parametros_complementarios = $this->laParametrosComplementarios ; }
 			
 			if( empty( $La_parametros_entidad_EEoInterfazDatos ) ){ $La_parametros_entidad_EEoInterfazDatos = $this->laParametrosEntidadEEoInterfazDatos ; }
 			
 			if( empty( $La_parametros_entidad_EEoInterfazDatos['id_nombre_fich_cache'] ) || empty( $La_parametros_entidad_EEoInterfazDatos['fichero_interfaz']['Ls_pathfich_interfaz'] ) )
 				{
 					trigger_error("Los par&aacute;metros para el desempe&ntilde;o de la entidad EEoInterfazDatos no est&aacute;n completos ", E_USER_WARNING);
 				}
 			
 			$Ls_resultado_objeto_gestion = NULL;
 			
 			switch ($Ls_tipo_transporte)
 				{
 					case 'url-path-directorios': $Ls_ruta_entrada_virtual = substr( $_SERVER['REQUEST_URI'] , strlen('/') );
												 if( substr( $Ls_ruta_entrada_virtual , -1) == '/')
												 	{
												 		$Ls_ruta_entrada_virtual = substr( $Ls_ruta_entrada_virtual , 0 , -1);
													}
												 $La_rev_fragmentada = array();
												 if ( !empty( $Ls_ruta_entrada_virtual ) )
												 	{
												 		$La_rev_fragmentada = explode( '/', $Ls_ruta_entrada_virtual );
 										 		 		
												 		if ( empty( $La_parametros_complementarios['cantidad_secciones_identificador'] ) )
															{
																if( empty( $this->laParametrosComplementarios['cantidad_secciones_identificador'] ) )
																	{
																		trigger_error("No se ha declarado la cantidad de secciones que conformar&aacute;n el cuerpo o string identificador a gestionar en __CLASS__" , E_USER_ERROR) ;
																	}
																$La_parametros_complementarios['cantidad_secciones_identificador'] = $this->laParametrosComplementarios['cantidad_secciones_identificador'];
															}
												 		
												 		if ( empty( $La_parametros_complementarios['comienzo_secciones_identificador'] ) && ( $La_parametros_complementarios['comienzo_secciones_identificador'] !== 0 ) )	
															{
																if( empty( $this->laParametrosComplementarios['comienzo_secciones_identificador'] ) && ( $this->laParametrosComplementarios['comienzo_secciones_identificador'] !== 0 ) )
																	{
																		trigger_error("No se ha declarado el n&uacute;mero entero que hara de indice en el arreglo contenedor de las secciones de la url ruta virtual en __CLASS__" , E_USER_ERROR ) ;
																	}
																$La_parametros_complementarios['comienzo_secciones_identificador'] = $this->laParametrosComplementarios['comienzo_secciones_identificador'];
															}
												 		$contador = 1 ;
												 		$La_posiciones_eliminar = array();
												 		$Ls_identificador_objeto_gestion = '';
												 		$cantidad_elementos = count( $La_rev_fragmentada );
												 		if( $La_parametros_complementarios['cantidad_secciones_identificador'] <= $cantidad_elementos )
															{
																foreach ($La_rev_fragmentada as $fragmento_ruta_entrada_virtual)
																	{
																		if( $contador < $La_parametros_complementarios['comienzo_secciones_identificador'] )
																			{
																				$contador++ ;
																				continue ;
																			}
																		$Ls_identificador_objeto_gestion .= $fragmento_ruta_entrada_virtual ;
																		$La_posiciones_eliminar[] = $contador-1 ;
																			 	
																		if ( $contador == ( $La_parametros_complementarios['comienzo_secciones_identificador'] + $La_parametros_complementarios['cantidad_secciones_identificador'] - 1 ) )
																			{
																				break ;
																			}
																		$Ls_identificador_objeto_gestion .= '/' ;
																		$contador++ ;
																	}
															}
												 		else 
															{
																trigger_error('La cantidad de secciones de url a extraer es mayor que las existentes', E_USER_WARNING );
																break;
															}
												 		 	
												 		$contador_posicion_eliminar = 0 ;
														foreach ( $La_posiciones_eliminar as $Li_posicion_eliminar )
															{
																array_splice( $La_rev_fragmentada , $Li_posicion_eliminar - $contador_posicion_eliminar , 1 );
																$contador_posicion_eliminar++ ;
															}
												 		$this->laRestoUrlRealEntradaSeccionada = $La_rev_fragmentada ;
													}				 		
 												 switch($Ls_tipo_mascara)
 													{
 														case 'literal'	   : 
 																			 if ( !empty( $Ls_identificador_objeto_gestion ) )
 																				{
 																					$La_resultado_objeto_gestion[0] = $Ls_identificador_objeto_gestion ;
 																					$La_resultado_objeto_gestion[1] = $Ls_identificador_objeto_gestion ;
 																				}
 																			 break ;	
 														case 'url-amigable': if ( !empty( $Ls_identificador_objeto_gestion ) )
 																				{
																			   		if( empty( $La_parametros_entidad_EEoInterfazDatos['fichero_datos'] ) ){$La_parametros_entidad_EEoInterfazDatos['fichero_datos'] = NULL ;}
																			  		
																			 		if ( !empty( $La_parametros_complementarios['cantidad_secciones_nomenclador']) )
																			 			{
																							switch($La_parametros_complementarios['cantidad_secciones_nomenclador'])
																			 					{
																			 						case 2 : $La_parametros_entidad_EEoInterfazDatos['parametros_complementarios']['secciones_nomenclador'] = array('url_entrada_virtual','url_entrada_real' );
																			 								 break;
																			 						case 3 : $La_parametros_entidad_EEoInterfazDatos['parametros_complementarios']['secciones_nomenclador'] = array('url_entrada_virtual','url_entrada_real','objetivo_gestion' );
																			 								 break;
																			 						default: $La_parametros_entidad_EEoInterfazDatos['parametros_complementarios']['secciones_nomenclador'] = array('url_entrada_virtual','url_entrada_real','objetivo_gestion','localizacion_recurso' );
																			 								 break;
																			 					}
																			 			}
																			  		
																			 		$La_parametros_entidad_EEoInterfazDatos['parametros_complementarios']['Ls_identificador_objeto_gestion']= $Ls_identificador_objeto_gestion ;
	
																			  		$La_resultado_objeto_gestion = $this->EEoInterfazDatos->gestionEjecucionInterfazSalida( $La_parametros_entidad_EEoInterfazDatos['id_nombre_fich_cache'] , $La_parametros_entidad_EEoInterfazDatos['fichero_interfaz'] , $La_parametros_entidad_EEoInterfazDatos['fichero_datos'] , $La_parametros_entidad_EEoInterfazDatos['pathdir_cache'] , $La_parametros_entidad_EEoInterfazDatos['parametros_complementarios'] );
	
 																				}
																			  break ;					 	
													}
 												break ;
 				}
 			
 			if( !empty( $La_resultado_objeto_gestion ) && is_array( $La_resultado_objeto_gestion ) ){return $La_resultado_objeto_gestion ;}
 			
 			return NULL;
 		}
 		
 	public function localizacion()
 		{
 			if( !empty( $this->localizacion ) )
 				{
 					return $this->localizacion ;
 				}
 			return NULL ; 
 		}
 	
 	public function restoUrlRealEntradaSeccionada()
 		{
 			return $this->laRestoUrlRealEntradaSeccionada ;
 		}
 	 
 	public function salidaRecursoMIME( $Ls_path_recurso , $Ls_localizacion_recurso = 'procesos' , $Ls_gestion_fallida = 'error' )
 		{
 			if ( class_exists(  '\Emod\Nucleo\ETratamientoMIME') )
 				{
 					$Ls_path_final_recurso = NULL ;
 					if ( $Ls_localizacion_recurso == 'procesos' )
 						{
 							$Ls_path_final_recurso = $this->EEoNucleo->pathDirRaizProcesoEjecucion().'/'.$Ls_path_recurso ; 
 						}
 					elseif ( $Ls_localizacion_recurso == 'modulos' )
 						{
 							//$Ls_path_final_recurso = $this->EEoNucleo->pathDirRaizModuloProcesoEjecucion().'/'.$Ls_path_recurso ;
 						}
 					if ( is_file( $Ls_path_final_recurso ) )
 						{
 							return \Emod\Nucleo\Herramientas\ETratamientoMIME::salidaRecursoMIME( $Ls_path_final_recurso );
 						}
 					else
 						{
 							if ( $Ls_gestion_fallida == 'error')
 								{
 									trigger_error( 'El path del recurso MIME a gestionar no apunta a un fichero' , E_USER_ERROR ) ;
 								}
 							elseif ( $Ls_gestion_fallida == 'warning')
 								{
 									trigger_error( 'El path del recurso MIME a gestionar no apunta a un fichero' , E_USER_WARNING ) ;
 								}
 							elseif ( $Ls_gestion_fallida == 'mute')
 								{
 									return NULL ;
 								}
 						}
 				}
 			die();
 		}
 	
 	public function router( $La_datos_router , $Ls_objetivo_gestion = 'global' )
 		{
 			$La_proceso_real = NULL ;
 			$La_proceso_real = $this->desenmascararUrlEntrada( $La_datos_router['tipo_transporte'] , $La_datos_router['tipo_mascara'] , $La_datos_router['parametros_complementarios'] , $La_datos_router['parametros_entidad_EEoInterfazDatos'] ) ;

 			$ejecucion_defecto = TRUE ;
 			if ( !empty( $La_proceso_real[1] ) )
 				{
 					if ( empty( $Ls_objetivo_gestion ) || ( $Ls_objetivo_gestion == 'hereda' ) )
 						{
 							$Ls_objetivo_gestion = $this->lsObjetivoGestion ;
 						}
 			  		
 					if ( ( $Ls_objetivo_gestion == 'global') && ( ( $La_proceso_real[2] == 'mime') || ( $La_proceso_real[2] == 'proceso' ) || ( $La_proceso_real[2] == 'llave_valor' ) ) )
 						{
 							$Ls_objetivo_gestion = $La_proceso_real[2] ;
 						}
 					elseif ( !( ( $Ls_objetivo_gestion == 'mime') || ( $Ls_objetivo_gestion == 'proceso' ) || ( $Ls_objetivo_gestion == 'llave_valor' ) ) )
 						{   
 							trigger_error('El objeto de gesti&oacute;n no es reconocido por el sistema' , E_USER_ERROR );
 						}
 					
 						
 					switch ( $Ls_objetivo_gestion )
 						{
 							case 'llave_valor' :	$Ls_path_final_recurso = NULL ;
 													if ( ( $La_datos_router['tipo_transporte'] == 'url-path-directorios' ) && ( $La_datos_router['tipo_mascara'] == 'literal' ) && !empty( $La_proceso_real[0] ) )
 														{
 															$Ls_path_final_recurso = $La_proceso_real[1] ;
 														}
 													else 
 														{
 															if ( !empty( $La_proceso_real[3] ) && ( ($La_proceso_real[3] == 'procesos' ) || ($La_proceso_real[3] == 'modulos' ) ) )
 																{
 																	$Ls_localizacion_recurso = $La_proceso_real[3] ;
 																}
 															else
 																{
 																	$Ls_localizacion_recurso = 'procesos' ;
 																}
 													
 															if ( $Ls_localizacion_recurso == 'procesos' )
 																{
 																	$Ls_path_final_recurso = $this->EEoNucleo->pathAbsolutoDirRaizProcesoEjecucion().'/'.$La_proceso_real[1] ;
 																}
 															elseif ( $Ls_localizacion_recurso == 'modulos' )
 																{
 																	//$Ls_path_final_recurso = $this->EEoNucleo->pathDirRaizModuloProcesoEjecucion().'/'.$La_proceso_real[1] ;
 																}
 														}
 													if ( !empty( $Ls_path_final_recurso ) && is_file( $Ls_path_final_recurso ) )
 														{
 															return $Ls_path_final_recurso ;
 														}
 													break ;
 							case 'mime'		   :	if ( !empty( $La_proceso_real[3] ) && ( ($La_proceso_real[3] == 'procesos' ) || ($La_proceso_real[3] == 'modulos' ) ) )
 														{
 															$Ls_localizacion_recurso = $La_proceso_real[3] ;
 														}
 													else
 														{
 															$Ls_localizacion_recurso = 'procesos' ;
 														}
 														
 													$this->salidaRecursoMIME( $La_proceso_real[1] , $Ls_localizacion_recurso , 'mute' ) ;
 													break ;
 							case 'proceso'     :	if ( !empty( $La_datos_router['proceso'] ) )
 														{
 															if ( $La_datos_router['proceso']['parametros_entidad_EEoInterfazDatos'] )
 																{   																	
 																	$La_bloque_procesos = $this->EEoInterfazDatos->gestionEjecucionInterfazSalida( $this->EEoNucleo->idProcesoEjecucion() , $La_datos_router['proceso']['parametros_entidad_EEoInterfazDatos']['fichero_interfaz'] , $La_datos_router['proceso']['parametros_entidad_EEoInterfazDatos']['fichero_datos'] , $La_datos_router['proceso']['parametros_entidad_EEoInterfazDatos']['pathdir_cache'] ) ;
 																	
 																}
 															if ( !empty( $La_bloque_procesos ) )
 																{
 																	$ejecucion_proceso = NULL ;
 																	$ejecucion_proceso = $this->EEoImplementacionProcesos->ejecutarProcesoBloque(  $La_proceso_real[1] , $La_bloque_procesos );
 																	if ( $ejecucion_proceso )
 																		{
 																			$ejecucion_defecto = FALSE ;
 																		}
 																}
 														}
 													break ;	
 						}
 				}
 			if ( $ejecucion_defecto ) 
 				{	if ( empty( $La_datos_router['objetivo_gestion_defecto'] ) || ( $La_datos_router['objetivo_gestion_defecto'] == 'hereda' ) )
 						{
 							$Ls_objetivo_gestion = $this->lsObjetivoGestionDefecto ;
 						}
 					else 
 						{
 							$Ls_objetivo_gestion = $La_datos_router['objetivo_gestion_defecto'];
 						}
 					
 					if ( !( ( $Ls_objetivo_gestion == 'mime') || ( $Ls_objetivo_gestion == 'proceso' ) || ( $Ls_objetivo_gestion == 'llave_valor' ) ) )
 						{ 
 							trigger_error('El objeto de gesti&oacute;n no es reconocido por el sistema' , E_USER_ERROR );
 						}
 					switch ( $Ls_objetivo_gestion )
 						{
 							case 'llave_valor' :	if ( !empty( $La_datos_router['llave_valor']['defecto']['localizacion_recurso'] ) )
 														{
 															$Ls_localizacion_recurso = $La_datos_router['llave_valor']['defecto']['localizacion_recurso']  ;
 														}
 													else
 														{
 															$Ls_localizacion_recurso = 'procesos' ;
 														}
 														
 													if ( !empty( $La_datos_router['llave_valor']['defecto']['path_recurso'] ) )
 														{
 															$Ls_path_final_recurso = NULL ;
 															if ( $Ls_localizacion_recurso == 'procesos' )
 																{
 																	$Ls_path_final_recurso = $this->EEoNucleo->pathAbsolutoDirRaizProcesoEjecucion().'/'.$La_datos_router['llave_valor']['defecto']['path_recurso'] ;
 																}
 															elseif ( $Ls_localizacion_recurso == 'modulos' )
 																{
 																	//$Ls_path_final_recurso = $this->EEoNucleo->pathDirRaizModuloProcesoEjecucion().'/'.$La_datos_router['llave_valor']['path_recurso'] ;
 																}
 															 
 															if ( !empty( $Ls_path_final_recurso ) && is_file( $Ls_path_final_recurso ) )
 																{
 																	return $Ls_path_final_recurso ;
 																}
 														}
 													trigger_error('No existe el recurso por defecto asignado a esta gesti&oacute;n' , E_USER_WARNING ) ;
 													break ;
 							case 'mime'		   :	if ( !empty( $La_datos_router['mime']['defecto']['localizacion_recurso'] )  )
 														{
 															$Ls_localizacion_recurso = $La_datos_router['mime']['defecto']['localizacion_recurso'] ;
 														}
 													else
 														{
 															$Ls_localizacion_recurso = 'procesos' ;
 														}
 													$this->salidaRecursoMIME( $La_datos_router['mime']['defecto']['path_recurso']  , $Ls_localizacion_recurso , 'error' ) ;
 													break ;
 							case 'proceso'     :	if ( !empty( $La_datos_router['proceso'] ) )
 														{	
 															if( !empty( $La_datos_router['proceso']['defecto']['procesos'] ) && is_array( $La_datos_router['proceso']['defecto']['procesos'] ) )
 																{	return $this->EEoImplementacionProcesos->ejecutarBloqueProcesos( $La_datos_router['proceso']['defecto'] );
 																}
 														}
 													break ;
 						}
 				}
 			return NULL ;
 		}
 }






?>