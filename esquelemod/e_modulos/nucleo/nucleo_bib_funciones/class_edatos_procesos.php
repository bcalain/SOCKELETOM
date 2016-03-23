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
   * DatosProcesos class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

	namespace Emod\Nucleo ;
    
        class DatosProcesos extends \Emod\Nucleo\NucleoEntidadBase
			{
				//protected $EEoNucleo = null ;
				//protected $EEoSeguridad = null ;
				
//**************crear un contenedor de objetos parecido a e nucleo entidad pero que no herede de multiton sino que solo ponga a dispocicion de cualquiera un objeto determinado, es posible que pueda ser aislando el procedimiento que hace eso en nucleo interfas en una interfaz del lenguaje es decir la solucion a la herencia multiple, esto es necesario para los plugin s y otros proceso que quieran dejar objetos herramientas al servicio de todos
                /////////////////////////////////PROCESOS////////////////////////////////////////////////////////////////////////////////
                
                /*
				(valores que los procesos (bloques, controles, etc) guardan como producto de sus gestiones y tienen la sigiente estructura )
				['id_proceso' = identificador del proceso] = 'datos_salida' = arreglo con datos de salida
				*/
 				private $datosSalidaProcesos = array () ;

                //procedimiento para la iniciacion de los datos de salida de un proceso deterinado, la estructura de estos datos estara definida por el gedee del proceso que inicializa sus datos de seguridad
				//en este procedimiento se utilizan listas variables de parametros por lo que se debe tener en cuenta el orden de estos para un correcto desempeno del procedimiento 
                //el primer argumento, argumentos[0] sera el arreglo de datos de la seguridad a inicializar
                
				public function iniciarDatosSalidaProceso()
							{
								$La_argumentos = func_get_args();
							
								return $this->implementarProcedimientosEE( $this->datosSalidaProcesos , __FUNCTION__ , $La_argumentos ) ;
							
							}
				
				//procedimiento para la indagacion de existencia de los datos de salida de un proceso determinado, la estructura de estos datos estara definida por el gedee del proceso que inicializa sus datos de seguridad
				//en este procedimiento se utilizan listas variables de parametros por lo que se debe tener en cuenta el orden de estos para un correcto desempeno del procedimiento 
                //el primer argumento, argumentos[0] sera el arreglo de datos de la seguridad a inicializar
                
				public function existenciaIdProceso()
							{
								$La_argumentos = func_get_args();
							
								return $this->implementarProcedimientosEE( $this->datosSalidaProcesos , __FUNCTION__ , $La_argumentos , true ) ;
							
							}
				
				//prcedimiento para acceder los datos de salida de un proceso deterinado, la estructura de estos datos estara definida por el gedee del proceso que accede sus datos de seguridad 
				//en este procedimiento se utilizan listas variables de parametros por lo que se debe tener en cuenta el orden de estos para un correcto desempeno del procedimiento 
                //el primer argumento, argumentos[0] sera el arreglo de datos de la configuracion a acceder
                
				public function accederDatosSalidaProceso()
							{
								$La_argumentos = func_get_args();
							
								return $this->implementarProcedimientosEE( $this->datosSalidaProcesos , __FUNCTION__ , $La_argumentos , true ) ;
							
							}
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				/*
                (valores que las aplicaciones y modulos de estas devuelven al control principal y tienen la sigiente estructura )
				['id_proceso o aplicacion' = identificador del proceso o aplicacion] = array ( 
				 														                         'generales' = array () 
 														                                         
																	                              'id-modulo' = array()
																		                          'id-modulo' = array()
																		                          'id-modulo' = array() 
																	                           );
				*/
 				
                
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				/////////////////////////////////APLICACIONES Y MODULOS////////////////////////////////////////////////////////////////////////////////
                 
//                private $datos_salida_appmod = array () ;
                
                //**********************************me falta hacer todo el mecanismo acceso a este arreglo de arriva que es muy parecido al de private $datosSalidaProcesos = array () ;  
                
                
                /////////////////////////////////PROCESOS////////////////////////////////////////////////////////////////////////////////
                
				
                            
                /////////////////////////////////APLICACIONES Y MODULOS////////////////////////////////////////////////////////////////////////////////
                
                //procedimiento para buscar la existencia de un idaplicacion o modulo de aplicacion en el contenedor de datos de salida de las aplicaciones y modulos
				//$id_aplicacion es el id de la aplicacion que se quiere buscar si existe, si se le da el valor 'hereda' este hara referencia a la aplicacion actual en ejecucion', si su valor es vacio el procedimiento retorna el valor null
                //$id_modulo es el id del modulo que se quiere buscar si existe, si se le da el valor 'hereda' este hara referencia al mmodulo actual en ejecucion', los modulos tienen obligatoriamente que estar asociados con una aplicacion
				//este procedimiento retorna la cadena 'aplicacion' en caso de ser una busqueda de aplicacion solamente y haber sido satisfactoria la operacion, retorna la cadena 'modulo' en caso de ser una busqueda de modulo y haber sido satisfactoria la operacion, si es una busqueda de modulo y este no es ncontrado en la estructura del arreglo datos_salida_appmod se retorna null  ,si es insatisfactoria la operacion el valor retornado por este procedimiento es null 
/*				public function existencia_id_appmod( $id_aplicacion = 'hereda' , $id_modulo = '' )
		 		 			{
		 		 				if ( !empty ( $id_aplicacion ) )
									{
										if ( $id_aplicacion == 'hereda' && is_object( $this->EEoNucleo ) )
											{
												$id_aplicacion = $this->EEoNucleo->aplicacion_ejecucion() ;	
											}
										if ( !empty ( $this->datos_salida_appmod[$id_aplicacion] ) )
											{
												if ( !empty ( $id_modulo ) )
                                                    {
                                                        if ( $id_modulo == 'hereda' && is_object( $this->EEoNucleo ) )
											                 {
												                $id_modulo = $this->EEoNucleo->modulo_ejecucion() ;	
											                 }
                                                        if ( !empty ( $this->datos_salida_appmod[$id_aplicacion]['modulos'][$id_modulo] ) )
											                 {
											                    return 'modulo' ;
                                                              }
                                                        return null ; 
                                                    } 
                                                return 'aplicacion' ;
											}
									}
								return null ;
		 		 			}
                
                //procedimiento para crear o inicializar un nuevo espacio de seguridad perteneciente a la aplicacion o modulo correspondiente
				//El $id_aplicacion y/o $id_modulo para la inicializacion de los datos lo toma automaticamente la funcion de la aplicacion y/o modulo que se ejecuta en ese momento, es el identificador de la aplicacion y/o modulo a nuevo ingreso de sus datos, y es la aplicacion y/o modulo que se encuentra como activo en ese momento en el objeto nucleo, si su valor es vacio el procedimiento retorna el valor null 
				//$datos_seguridad es la estructura de datos de seguridad a guardar, no olvidar que esta debe ajustarse a una estructura preconsevida para esta clase, sino algunas de sus prestaciones no funcionaran con la estructura de datos atipica, si su valor es vacio el procedimiento retorna el valor null 
				//$tipo es para definir si los datos a inicializar seran de una aplicacion $tipo = 'aplicacion', un modulo de aplicacion $tipo = 'modulo', en caso de contener un valor diferente de los mencionados el procedimiento retorna el valor null
                //este procedimiento utiliza un procedimiento del objeto $EEoNucleo a travez de $this->EEoNucleo
				//este procedimiento retorna true si la operacion es satisfactoria y null si es insatisfactoria
				//si se intenta inicializar datos en espacios corespondientes a datos inicialisados ya, el procedimiento retorna el valor null
                public function inicializar_datosalida_appmod( $datos_salida )
							{
								if( !empty( $this->EEoNucleo ) && !empty ( $datos_salida  ) && ( ( $this->EEoNucleo->gedeeProcesoEjecucion() == 'aplicacion' ) || ( $this->EEoNucleo->gedeeProcesoEjecucion() == 'modulo' ) ) )
									{
										$id_aplicacion = $this->EEoNucleo->aplicacion_ejecucion() ;
                                        if ( !empty( $id_aplicacion ) )
										  {
                                                switch( $this->EEoNucleo->gedeeProcesoEjecucion() )
                                                    {
                                                        case 'aplicacion' :  if( $this->existencia_id_appmod( $id_aplicacion ) == null )
                                                                                {
                                                                                    $this->datos_salida_appmod[ $id_aplicacion ] = $datos_salida ;
                                                                                    return true ;
                                                                                }
                                                                             break ;
                                                        
                                                        case 'modulo' :  $id_modulo = $this->EEoNucleo->modulo_ejecucion() ;
                                                                             if( !empty( $id_modulo ) && ( $this->existencia_id_appmod( $id_aplicacion , $id_modulo ) != 'modulo' ) )
                                                                                {
                                                                                    $this->datos_salida_appmod[ $id_aplicacion ]['modulos'][ $id_modulo ] = $datos_salida ;
                                                                                    return true ;
                                                                                }
                                                                              break ;    
                                                    }
										  }
									}
								return null ;
							}
                            
                //procedimiento para modificar los datos de salida de un proceso aplicacion o modulo de aplicacion que se encuentran en la propiedad datos_salida_appmod de esta clase, para ello deberan cumplrse las siguientes condiciones
                // - existir una seccion de seguridad de la aplicacion o modulo proceso al que se quieren leer o modificar los datos en la propiedad $datos_seguridad_appmod de la instancia de la clase seguridad procesos 
				// - existir el id de la aplicacion o modulo proceso que ejecuta este procedimiento en la estructura 'acceso_datos',perteneciente a la seccion de seguridad de la aplicacion o modulo proceso al que se quieren modificar los datos, en la propiedad $datos_seguridad_appmod de la instancia de la clase seguridad procesos, y corresponderse con los permisos otorgados, solo se prescinde de esta condicion si el proceso aplicacion o modulo intenta acceder a sus propios datos 
				//$id_aplicacion es el identificador del proceso aplicacion al que se quieren modificar los datos de seguridad, si se quieren modificar los datos del proceso aplicacion actual(en ejecucion) se introduce el valor 'hereda', o el id que le corresponde, por defecto este par�metro tiene el valor 'hereda', si el valor de este parametro es vacio el procedimiento retorna el valor null, 
				//$id_modulo es el identificador del proceso modulo al que se quieren modificar los datos de seguridad, si se quieren modificar los datos del proceso modulo actual(en ejecucion) se introduce el valor 'hereda', o el id que le corresponde, por defecto este par�metro tiene el valor '' (string vacio), para complementar esta aayuda debe verse la ayuda de la propiedad $datos_seguridad_appmod de la clase seguridad procesos.
				//$estructura_acceder //
				
					//para valor 1 del parametro $tipo_accion (referencia) este puede contener un arreglo vacio para obtener todo el arreglo perteneciente al arreglo $datos_salida_appmod[id_aplicacion], array() un arreglo vacio es por defecto el valor que tiene, o se puede acceder solo a una parte de su estructura si se le da el valor a este parametro de una cadena con la esrtuctura a la que se quiere acceder, ejemplo '[modulos][idmodulo][datox]' y el debolvera el elemento $datos_seguridad_appmod[id_aplicacion][modulos][idmodulo][datox], todo esto en dependencia de los permisos de acceso a esta estructura del proceso aplicacion o modulo cliente 
				
					//para valores 2 y 3 del parametro $tipo_accion (referencia) es un arreglo asociativo con los elementos que se quieren eliminar o modificar en el arreglo $datos_seguridad_appmod[id_aplicacion] o $datos_seguridad_appmod[id_aplicacion][modulos][id_modulo], segun corresponda 
					// esta matriz contendra la estructura exacta en la que se encuentra el elemento que se quiere eliminar o modificar,
					// es como un mapa, una imagen de la matriz y su rama o elemento que se quiere eliminar o modificar, llamemosle de ahora en adelante "estructura imagen"
					// en caso de que toda una rama del arreglo se quiera eliminar basta con poner 'elemento'=array() y se eliminara ese elemento junto a la rama que el constitulle,
					// el primer elemento del arreglo $La_elementos ser� el primer elemento a buscar en el arreglo $datos_salida_appmod[id_aplicacion] o $datos_salida_appmod[id_aplicacion][modulos][id_modulo], segun corresponda  , y as� sucecivamente.
					// si su valor es vacio el procedimiento retorna el valor null
				
				//$tipo_accion es el tipo de modificacion que se utilizara con los posibles valores siguientes, 1 para leer 2 para escribir o modificar , 3 para eliminar, si su valor es diferente de los valores permitidos el procedimiento retorna el valor null, este parametro tambien debe coincidir con los permisos de escribir o eliminar que debe tener el proceso aplicacion o modulo actual (en ejecucion) sobre el proceso aplicacion o modulo de los datos a modificar o eliminar  
				//$condicion_modificacion tiene dos posibles estructuras, en dependencia del tipo de modificacion, si su valor es diferente de los valores permitidos el procedimiento retorna el valor null, a continuacion se explican
					
					//para $tipo_accion 2 (escribir o modificar) tiene la siguiente estructura:
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
					  
					  
					  //para $tipo_accion 3 (eliminar) tiene la siguiente estructura:
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
  
     	   		//este procedimiento retorna true si la operacion es satisfactoria y null si es insatisfactoria	
     	   		//el proceso aplicacion o modulo que solicita el procedimiento no tiene obligacion de haber inicializado seccion de datos en la instancia de esta clase con ecepcion de que quien solicite el procedimiento lo haga para modificar sus propios datos, en este caso si debe existir una apertura de seccion de datos con antelacion, para ello existe el procedimiento inicializar_datosalida_appmod en esta misma clase  
						
				
				//recuerda cuando utilices esta funcion y no haya modulo tienes que pasar un valor vacio pero no null
				//en la opcion de eliminar elimina por la clave de la rama de array no por el valor de la clave
                //si se declara un idaplicacion o idmodulo y este no existe en la estructura del arreglo de datos de salida entonces el procedimiento retorna el valor null
                
                public function acceder_datosalida_appmod( $id_aplicacion = 'hereda' ,$id_modulo = '' , $estructura_acceder = array() , $tipo_accion = 1 , $condicion_modificacion = 0 )
							{
								if ( !empty( $id_aplicacion ) && !empty( $this->EEoNucleo ) && ( ( $this->EEoNucleo->gedeeProcesoEjecucion() == 'aplicacion') || ( ( $this->EEoNucleo->gedeeProcesoEjecucion() == 'modulo') ) ) && ( $this->existencia_id_appmod( $id_aplicacion ) == 'aplicacion' ) && ( ( $tipo_accion == 1 ) || ( $tipo_accion == 2 ) || ( $tipo_accion == 3 ) ) )  
									{
										if ( empty( $estructura_acceder) && ( ( $tipo_accion == 2 ) || ( $tipo_accion == 3 ) ) )
											{
												return null ;
											}
                                        
										$id_aplicacion_actual = $this->EEoNucleo->aplicacion_ejecucion();
                                        $id_modulo_actual = $this->EEoNucleo->modulo_ejecucion();
                                                                                
                                        //////////////////////gestionando identificadores de alpicacion y modulo//////////////////////
                                        
                                        if ( strtolower( $id_aplicacion ) == 'hereda' )
											{
												$id_aplicacion = $id_aplicacion_actual ;
                                            }
                                        if ( !empty( $id_modulo ) )
                                            {
                                                if ( strtolower( $id_modulo ) == 'hereda' )
                                                    {
                                                        $id_modulo = $id_modulo_actual ;
                                                    }
                                            }
                                        $existencia_id_appmod = $this->existencia_id_appmod( $id_aplicacion , $id_modulo ) ;
                                        if ( empty( $existencia_id_appmod ) )
                                            {
                                                return null ;
                                            }
                                        ///////////////////////gestionando los permisos de acceso////////////////////
                                        
                                       $gedee_proceso_ejecucion = $this->EEoNucleo->gedeeProcesoEjecucion();
                                       if ( !$this->EEoSeguridad )
											{
												return null ;
											}
                                       $tipo_acceso = null ;
                                       switch ( $gedee_proceso_ejecucion )
											{
											    case 'aplicacion'     :     $tipo_acceso = $this->EEoSeguridad->clienteAccesoDatosProceso( $id_aplicacion );
												                             break ; 
												case 'modulo'         :     $tipo_acceso = $this->EEoSeguridad->clienteAccesoDatosProceso( $id_aplicacion , $id_modulo );
												                             break ; 
																						  	
											}
                                            
                                       if ( $tipo_acceso )
											{
												$acceso_leer = null ;
												$acceso_escribir = null ;
												$acceso_eliminar = null ;
																
												if ( is_string( $tipo_acceso ) )
													{
														$arreglo_acceso = explode( '::' , $tipo_acceso ) ;
														foreach ( $arreglo_acceso as $elemento)
															{
																switch ( $elemento )
																	{
																		case 'leer'     : $acceso_leer = 'leer' ;
																					      break ; 
																		case 'escribir' : $acceso_escribir = 'escribir' ;
																					      break ;
																		case 'eliminar' : $acceso_eliminar = 'eliminar' ;
																					      break ;			  	
																	}
															} 
													}
																
												if ( ( ( $tipo_modificacion == 1 ) && ( $acceso_leer != 'leer' ) ) || ( ( $tipo_modificacion == 2 ) && ( $acceso_escribir != 'escribir' ) ) || ( ( $tipo_modificacion == 3 ) && ( $acceso_eliminar != 'eliminar' ) ) )
													{
														return null ;
													}
											}
										else
											{
												return null ;
											} 
                                        ////////////////////////implementacion del acceso gestionado//////////////////////////////////
  
										$La_resultado = null;											
										
                                        switch ( $gedee_proceso_ejecucion )
											{
												case 'aplicacion' : switch ( $tipo_modificacion )
											                             {
												                                case 1 : //leer
														                                 if ( is_array( $estructura_acceder ) && empty( $estructura_acceder ) )
														 	                                {
														 		                               $La_resultado = $this->datos_salida_appmod[$id_aplicacion];
														 	                                }
														                                 elseif( is_string( $estructura_acceder ) && ( stripos( $estructura_acceder , ';' ) === false ) && ( stripos( $estructura_acceder , ')' ) === false ) && ( stripos( $estructura_acceder , '{' ) === false ) )
															                                 {
															
																                                $cadena_ejecutar = " if ( isset( \$this->datos_salida_appmod[\$id_aplicacion]$estructura_acceder ) )
																						                                  {
																							                                 \$La_resultado = \$this->datos_salida_appmod[\$id_aplicacion]$estructura_acceder ;
																						                                  }
																					                                ";
																                                eval( $cadena_ejecutar );
															                                 }
														                                 return $La_resultado ;
														 
												                                case 2 : //escribir o modificar
														                                 $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloModificarRecursivo( $estructura_acceder , $this->datos_salida_appmod[$id_aplicacion] , $condicion_modificacion );
														                                 break ;
														 
												                                case 3 : //eliminar
														                                 $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloEliminarRecursivo( $estructura_acceder , $this->datos_salida_appmod[$id_aplicacion] , $condicion_modificacion );
														                                 break  ;
										                                 }
                                                                    if ( ( $tipo_modificacion != 1 ) && !empty( $La_resultado ['arreglo_base'] ) )
											                             {
								                                            $this->datos_salida_appmod[$id_aplicacion] = $La_resultado ['arreglo_base'] ;
												                            return true ;
											                             }		 
												                    break ;
                                                                         
												case 'modulo'     : switch ( $tipo_modificacion )
											                             {
												                                case 1 : //leer
														                                 if ( is_array( $estructura_acceder ) && empty( $estructura_acceder ) )
														 	                                {
														 		                               $La_resultado = $this->datos_salida_appmod[$id_aplicacion]['modulos'][$id_modulo];
														 	                                }
														                                 elseif( is_string( $estructura_acceder ) && ( stripos( $estructura_acceder , ';' ) === false ) && ( stripos( $estructura_acceder , ')' ) === false ) && ( stripos( $estructura_acceder , '{' ) === false ) )
															                                 {
															
																                                $cadena_ejecutar = " if ( isset( \$this->datos_salida_appmod[\$id_aplicacion]['modulos'][\$id_modulo]$estructura_acceder ) )
																						                                  {
																							                                 \$La_resultado = \$this->datos_salida_appmod[\$id_aplicacion]['modulos'][\$id_modulo]$estructura_acceder ;
																						                                  }
																					                                ";
																                                eval( $cadena_ejecutar );
															                                 }
														                                 return $La_resultado ;
														 
												                                case 2 : //escribir o modificar
														                                 $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloModificarRecursivo( $estructura_acceder , $this->datos_salida_appmod[$id_aplicacion]['modulos'][$id_modulo] , $condicion_modificacion );
														                                 break ;
														 
												                                case 3 : //eliminar
														                                 $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloEliminarRecursivo( $estructura_acceder , $this->datos_salida_appmod[$id_aplicacion]['modulos'][$id_modulo] , $condicion_modificacion );
														                                 break ;
										                                 }
                                                                    if ( ( $tipo_modificacion != 1 ) && !empty( $La_resultado ['arreglo_base'] ) )
											                             {
								                                            $this->datos_salida_appmod[$id_aplicacion]['modulos'][$id_modulo] = $La_resultado ['arreglo_base'] ;
												                            return true ;
											                             }		 
												                    break ;
											}
                                     } 
                                return null ;
                           }
*/                            
            }
?>