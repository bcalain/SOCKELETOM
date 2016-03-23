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
   * SeguridadProcesos class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

    namespace Emod\Nucleo ; 

	class SeguridadProcesos extends \Emod\Nucleo\NucleoEntidadBase
			{
				/////////////////////////////////PROCESOS////////////////////////////////////////////////////////////////////////////////
                
                /*
				(valores que los procesos (bloques, controles, etc) crean para luego ser chequeados con motivo de seguridad para la ejecucion de sus procedimientos  )
 				
 				['id_proceso' = identificador del proceso] = array ( 
				 														'propiedades' = array ( 'clave_proceso' = '' , 'alias' = '' , 'version' = '' , 'dependencias' = '' , 'conflictos' = '', statu = '' ), statu tiene como objetivo informar sobre el desempeno de la ejecucion del proceso
				 														'permiso_ejecucion' = array(
																		 								'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																										'procesos' = array ('id_proceso_cliente1','id_proceso_clienteN') se evaluar� en dependencia del ambito declarado, 
				 																				  )
																		'acceso_seguridad' = array(
																		 								'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																										'procesos' = array ('id_proceso_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, si se pone un id con valor vacio es como si no existiera o estubiera declarado para los procedimientos que hacen uso de estos datos 
				 																				  )
																		'acceso_datos' = array(
																		 							'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																									'procesos' = array ('id_proceso_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, si se pone un id con valor vacio es como si no existiera o estubiera declarado para los procedimientos que hacen uso de estos datos
																							   )
																		'acceso_configuracion = array(
																		 							      'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																									      'procesos' = array ('id_proceso_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, si se pone un id con valor vacio es como si no existiera o estubiera declarado para los procedimientos que hacen uso de estos datos
																							         )
																	);
 													 										
 				si 'acceso_datos' o 'acceso_seguridad' no existe o es un arreglo vacio, se concidera que solo el proceso en si puede acceder a sus datos
				  
				*/ 
				private $datosSeguridadProcesos = array() ;
				
				//procedimiento para la iniciacion de los datos de seguridad de un proceso deterinado, la estructura de estos datos estara definida por el gedee del proceso que inicializa sus datos de seguridad
				//en este procedimiento se utilizan listas variables de parametros por lo que se debe tener en cuenta el orden de estos para un correcto desempeno del procedimiento 
                //el primer argumento, argumentos[0] sera el arreglo de datos de la seguridad a inicializar
                
				public function iniciarDatosSeguridadProceso()
							{
								$La_argumentos = func_get_args();
							
								return $this->implementarProcedimientosEE( $this->datosSeguridadProcesos , __FUNCTION__ , $La_argumentos ) ;
							
							}
							
				//procedimiento para la indagacion de existencia de los datos de seguridad de un proceso determinado, la estructura de estos datos estara definida por el gedee del proceso que inicializa sus datos de seguridad
				//en este procedimiento se utilizan listas variables de parametros por lo que se debe tener en cuenta el orden de estos para un correcto desempeno del procedimiento 
                //el primer argumento, argumentos[0] sera el arreglo de datos de la seguridad a inicializar
                
				public function existenciaIdProceso()
							{
								$La_argumentos = func_get_args();
							
								return $this->implementarProcedimientosEE( $this->datosSeguridadProcesos , __FUNCTION__ , $La_argumentos , true ) ;
							
							}
							
				//prcedimiento para acceder los datos de seguridad de un proceso deterinado, la estructura de estos datos estara definida por el gedee del proceso que accede sus datos de seguridad 
				//en este procedimiento se utilizan listas variables de parametros por lo que se debe tener en cuenta el orden de estos para un correcto desempeno del procedimiento 
                //el primer argumento, argumentos[0] sera el arreglo de datos de la configuracion a acceder
                
				public function accederDatosSeguridadProceso()
							{
								$La_argumentos = func_get_args();
								
								return $this->implementarProcedimientosEE( $this->datosSeguridadProcesos , __FUNCTION__ , $La_argumentos , true ) ;
							
							}
				
				//prcedimiento para chequear si proceso deterinado puede ejecutar otro proceso, la estructura de estos datos estara definida por el gedee del proceso que desea ejecutar. 
				//en este procedimiento se utilizan listas variables de parametros por lo que se debe tener en cuenta el orden de estos para un correcto desempeno del procedimiento 
                //el primer argumento, argumentos[0] sera el arreglo de datos de la configuracion a acceder
                
				public function clienteEjecucionProceso()
							{
								$La_argumentos = func_get_args();
							
								return $this->implementarProcedimientosEE( $this->datosSeguridadProcesos , __FUNCTION__ , $La_argumentos , true ) ;
							
							}
				
				//este procedimiento gestiona si un proceso idcliente (ejecutandose , actual) tiene acceso a los datos de salida de otro proceso, y de ser sierto obtener el tipo de acceso, este acceso es referente a los datos contenidos en la clase DatosProcesos  
				//en este procedimiento se utilizan listas variables de parametros por lo que se debe tener en cuenta el orden de estos para un correcto desempeno del procedimiento 
                //el primer argumento, argumentos[0] sera el arreglo de datos de la configuracion a acceder
                  
				public function clienteAccesoDatosProceso()
							{
								$La_argumentos = func_get_args();
							
								return $this->implementarProcedimientosEE( $this->datosSeguridadProcesos , __FUNCTION__ , $La_argumentos , true ) ;
							
							}
				
				//este procedimiento gestiona si un proceso idcliente (ejecutandose , actual) tiene acceso a los datos de configuracion de otro proceso, y de ser sierto obtener el tipo de acceso, este acceso es referente a los datos contenidos en la clase Configuracion_gestor  
				//en este procedimiento se utilizan listas variables de parametros por lo que se debe tener en cuenta el orden de estos para un correcto desempeno del procedimiento 
                //el primer argumento, argumentos[0] sera el arreglo de datos de la configuracion a acceder
                  
				public function clienteAccesoConfiguracionProceso()
							{
								$La_argumentos = func_get_args();
							
								return $this->implementarProcedimientosEE( $this->datosSeguridadProcesos , __FUNCTION__ , $La_argumentos , true ) ;
							
							}
				
				//borrar es solo para pruebas
				public function acceder_estructura_completa()
							{
								
								echo '<p> ESTE METODO ES SOLO PARA EL DEBUGGEO'.__METHOD__.'<p>' ;
								return $this->datosSeguridadProcesos ;
							
							}
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				/////////////////////////////////APLICACIONES Y MODULOS////////////////////////////////////////////////////////////////////////////////
                 
				/*
				(valores que las aplicaciones crean para luego ser chequeados con motivo de seguridad para la ejecucion de sus procedimientos  )
 				
 				['id_aplicacion1' = identificador de la aplicacion] = array ( 
				 														     'propiedades' = array ( 'clave_aplicacion' = '' , 'alias' = '' , 'version' = '' , especificidad_servidor = 'aplicacion' , 'dependencias' = '' , 'conflictos' = '', status = '' ), especificidad_servidor puede tener el valor aplicacion o modulo en dependencia de este valor el sistema de seguridad trabaja sus datos- si es 'aplicacion' los datos de seguridad son aplicados por igual a todos los modulos de esta aplicacion, si es 'modulo' el sistema buscar� cada modulo en especifico y si no encuentra el modulo debuelbe null,  statu tiene como objetivo informar sobre el desempeno de la ejecucion de la aplicacion
				 														     'permiso_ejecucion' = array(
																		 							      	'ambito' = 'restrictivo' o 'permisivo',//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
								                                            								'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                        'id_modulo_cliente1', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                        'id_modulo_cliente2', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                        'id_modulo_clienteN' //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                     ),
                                                                                                                                     'id_aplicacion_cliente2 ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion y  se evaluar�n en dependencia del ambito declarado,
                                                                                                                                     'id_aplicacion_clienteN = array (
                                                                                                                                                                        'id_modulo_cliente1', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                        'id_modulo_cliente2', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                        'id_modulo_clienteN' //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                      )
                                                                                                                                    )     
				 																				          ),
																		      'acceso_seguridad' = array(
																		 								     'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																										     'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                        'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                        'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                        'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                      ),
                                                                                                                                     'id_aplicacion_cliente2 = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion 
                                                                                                                                     'id_aplicacion_clienteN = array (
                                                                                                                                                                        'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                        'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                        'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                      )
                                                                                                                                    ) 
                                                                                                          ),
																		      'acceso_datos' = array(
																		 							      'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																									      'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                        'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                        'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                        'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                   ),
                                                                                                                                     'id_aplicacion_cliente2 = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion 
                                                                                                                                     'id_aplicacion_clienteN = array (
                                                                                                                                                                        'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                        'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                        'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                      )
                                                                                                                                    )
																							         ),
																		      'acceso_configuracion' = array(
																		 							           'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																									           'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                            'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                            'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                            'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                         ),
                                                                                                                                        'id_aplicacion_cliente2 = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion 
                                                                                                                                        'id_aplicacion_clienteN = array (
                                                                                                                                                                            'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                            'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                            'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                        )
                                                                                                                                    )
																							                 )
																	       );
                                                                           
                ['id_aplicacion2' = identificador de la aplicacion2] = array ( 
				 														     'propiedades' = array ( 'clave_aplicacion' = '' , 'alias' = '' , 'version' = '' , especificidad_servidor = 'modulo' , 'dependencias' = '' , 'conflictos' = '', statu = '' ), especificidad_servidor puede tener el valor aplicacion o modulo en dependencia de este valor el sistema de seguridad trabaja sus datos- si es 'aplicacion' los datos de seguridad son aplicados por igual a todos los modulos de esta aplicacion, si es 'modulo' el sistema buscar� cada modulo en especifico , statu tiene como objetivo informar sobre el desempeno de la ejecucion de la aplicacion
				 														     'permiso_ejecucion' = array(
																		 							      	'ambito' = 'restrictivo' o 'permisivo',//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
								                                            								'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                        'id_modulo_cliente1', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                        'id_modulo_cliente2', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                        'id_modulo_clienteN' //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                     ),
                                                                                                                                     'id_aplicacion_cliente2 ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion y  se evaluar�n en dependencia del ambito declarado,
                                                                                                                                     'id_aplicacion_clienteN = array (
                                                                                                                                                                        'id_modulo_cliente1', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                        'id_modulo_cliente2', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                        'id_modulo_clienteN' //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                      )
                                                                                                                                    )     
				 																				          ),
																		      'acceso_seguridad' = array(
																		 								     'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																										     'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                        'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                        'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                        'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                      ),
                                                                                                                                     'id_aplicacion_cliente2 = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion 
                                                                                                                                     'id_aplicacion_clienteN = array (
                                                                                                                                                                        'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                        'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                        'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                      )
                                                                                                                                    ) 
                                                                                                          ),
																		      'acceso_datos' = array(
																		 							      'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																									      'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                        'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                        'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                        'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                   ),
                                                                                                                                     'id_aplicacion_cliente2 = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion 
                                                                                                                                     'id_aplicacion_clienteN = array (
                                                                                                                                                                        'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                        'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                        'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                      )
                                                                                                                                    )
																							         ),
																		      'acceso_configuracion' = array(
																		 							           'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																									           'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                            'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                            'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                            'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                         ),
                                                                                                                                        'id_aplicacion_cliente2 = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion 
                                                                                                                                        'id_aplicacion_clienteN = array (
                                                                                                                                                                            'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                            'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                            'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                        )
                                                                                                                                    )
																							                 )
                                                                               'modulos' = array(
																		 							'id_modulo1' = array (
                                                                                                                                 'propiedades' = array ( 'clave_aplicacion' = '' , 'alias' = '' , 'version' = '' , 'dependencias' = '' , 'conflictos' = '', statu = '' ), especificidad_servidor puede tener el valor aplicacion o modulo en dependencia de este valor el sistema de seguridad trabaja sus datos- si es 'aplicacion' los datos de seguridad son aplicados por igual a todos los modulos de esta aplicacion, si es 'modulo' el sistema buscar� cada modulo en especifico , statu tiene como objetivo informar sobre el desempeno de la ejecucion de la aplicacion
				 														                                                         'permiso_ejecucion' = array(
																		 							      	                                                   'ambito' = 'restrictivo' o 'permisivo',//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
								                                            								                                                    'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                                                                            'id_modulo_cliente1', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                                                                            'id_modulo_cliente2', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                                                                            'id_modulo_clienteN' //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                                                                         ),
                                                                                                                                                                                         'id_aplicacion_cliente2 ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion y  se evaluar�n en dependencia del ambito declarado,
                                                                                                                                                                                         'id_aplicacion_clienteN = array (
                                                                                                                                                                                                                            'id_modulo_cliente1', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                                                                            'id_modulo_cliente2', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                                                                            'id_modulo_clienteN' //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                                                                          )
                                                                                                                                                                                        )     
				 																				                                                              ),
																		                                                          'acceso_seguridad' = array(
																		 								                                                         'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																										                                                         'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                                                                            'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                            'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                            'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                          ),
                                                                                                                                                                                         'id_aplicacion_cliente2 = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion 
                                                                                                                                                                                         'id_aplicacion_clienteN = array (
                                                                                                                                                                                                                            'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                            'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                            'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                          )
                                                                                                                                                                                        ) 
                                                                                                                                                              ),
																		                                                          'acceso_datos' = array(
																		 							                                                          'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																									                                                          'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                                                                            'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                            'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                            'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                       ),
                                                                                                                                                                                         'id_aplicacion_cliente2 = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion 
                                                                                                                                                                                         'id_aplicacion_clienteN = array (
                                                                                                                                                                                                                            'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                            'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                            'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                          )
                                                                                                                                                                                        )
																							                                                             ),
																		                                                          'acceso_configuracion' = array(
																		 							                                                               'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																									                                                               'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                                                                                'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                                'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                                'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                             ),
                                                                                                                                                                                            'id_aplicacion_cliente2 = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion 
                                                                                                                                                                                            'id_aplicacion_clienteN = array (
                                                                                                                                                                                                                                'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                                'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                                'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                            )
                                                                                                                                                                                            )
																							                                                                     )          
	                                                   																	)
                                                                                                                           
                                                                                                      'id_moduloN' = array (
                                                                                                                                 'propiedades' = array ( 'clave_aplicacion' = '' , 'alias' = '' , 'version' = '' , 'dependencias' = '' , 'conflictos' = '', statu = '' ), statu tiene como objetivo informar sobre el desempeno de la ejecucion de la aplicacion
				 														                                                         'permiso_ejecucion' = array(
																		 							      	                                                   'ambito' = 'restrictivo' o 'permisivo',//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
								                                            								                                                    'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                                                                            'id_modulo_cliente1', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                                                                            'id_modulo_cliente2', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                                                                            'id_modulo_clienteN' //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                                                                         ),
                                                                                                                                                                                         'id_aplicacion_cliente2 ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion y  se evaluar�n en dependencia del ambito declarado,
                                                                                                                                                                                         'id_aplicacion_clienteN = array (
                                                                                                                                                                                                                            'id_modulo_cliente1', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                                                                            'id_modulo_cliente2', //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                                                                            'id_modulo_clienteN' //se evaluar� en dependencia del ambito declarado,
                                                                                                                                                                                                                          )
                                                                                                                                                                                        )     
				 																				                                                              ),
																		                                                          'acceso_seguridad' = array(
																		 								                                                         'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																										                                                         'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                                                                            'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                            'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                            'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                          ),
                                                                                                                                                                                         'id_aplicacion_cliente2 = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion 
                                                                                                                                                                                         'id_aplicacion_clienteN = array (
                                                                                                                                                                                                                            'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                            'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                            'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                          )
                                                                                                                                                                                        ) 
                                                                                                                                                              ),
																		                                                          'acceso_datos' = array(
																		 							                                                          'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																									                                                          'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                                                                            'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                            'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                            'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                       ),
                                                                                                                                                                                         'id_aplicacion_cliente2 = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion 
                                                                                                                                                                                         'id_aplicacion_clienteN = array (
                                                                                                                                                                                                                            'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                            'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                            'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                          )
                                                                                                                                                                                        )
																							                                                             ),
																		                                                          'acceso_configuracion' = array(
																		 							                                                               'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
																									                                                               'aplicaciones' = array ('id_aplicacion_cliente1 = array (
                                                                                                                                                                                                                                'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                                'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                                'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                             ),
                                                                                                                                                                                            'id_aplicacion_cliente2 = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta ,//si no se especifica modulos el permiso se extiende a todos los modulos de la aplicacion 
                                                                                                                                                                                            'id_aplicacion_clienteN = array (
                                                                                                                                                                                                                                'id_modulo_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                                'id_modulo_cliente2' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, 
                                                                                                                                                                                                                                'id_modulo_clienteN' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta,
                                                                                                                                                                                                                            )
                                                                                                                                                                                            )
																							                                                                     )          
	                                                   																	)     
                          																	     )
                                                                            );
                                                
 													 										
 				si 'acceso_datos' o 'acceso_seguridad' no existe o es un arreglo vacio, se concidera que solo el proceso en si puede acceder a sus datos
				  
				*/ 
//                private $datos_seguridad_appmod = array() ;
                
				
                /////////////////////////////////PROCESOS////////////////////////////////////////////////////////////////////////////////
                
                
                //procedimiento para buscar la existencia de un idproceso en los datos de seguridad
				//$id_proceso es el id del proceso que se quiere buscar si existe, si se le da el valor 'hereda' este hara referencia al proceso actual en ejecucion', por defecto tiene el valor hereda, si su valor es vacio el procedimiento retorna el valor null
				//este procedimiento retorna true si la operacion es satisfactoria y null si es insatisfactoria
/*				public function existencia_id_proceso_comun( $id_proceso = 'hereda' )
		 		 			{
		 		 				if ( !empty ($id_proceso) )
									{
										if ( $id_proceso == 'hereda' && is_object( $this->EEoNucleo ) )
											{
												$id_proceso = $this->EEoNucleo->idProcesoEjecucion() ;	
											}
										if ( !empty ( $this->datosSeguridadProcesos[$id_proceso] ) )
											{
												return true ;
											}
									}
								return null ;
		 		 			}
*/							  
				//procedimiento para crear o inicializar un nuevo espacio de seguridad perteneciente al proceso actual (ejecutandose)
				//El $id_proceso para la inicializacion de los datos lo toma automaticamente la funcion del proceso que se ejecuta en ese momento, es el identificador del proceso a nuevo ingreso de sus datos, y es el proceso que se encuentra como activo en ese momento en el objeto nucleo, si su valor es vacio el procedimiento retorna el valor null 
				//$datos_seguridad es la estructura de datos de seguridad a guardar, no olvidar que esta debe ajustarse a una estructura preconsevida para esta clase, sino algunas de sus prestaciones no funcionaran con la estructura de datos atipica, si su valor es vacio el procedimiento retorna el valor null 
				//este procedimiento utiliza un procedimiento del objeto $EEoNucleo a travez de $this->EEoNucleo
				//este procedimiento retorna true si la operacion es satisfactoria y null si es insatisfactoria
/*				public function iniciarDatosSeguridadProceso_comun( $datos_seguridad )
							{
								if( !empty( $this->EEoNucleo ) )
									{
										$id_proceso = $this->EEoNucleo->idProcesoEjecucion() ;
										if ( !empty( $id_proceso ) && !$this->existencia_id_proceso_comun( $id_proceso ) && !empty ( $datos_seguridad ) )
										{
											$this->datosSeguridadProcesos[ $id_proceso ] = $datos_seguridad ;
											return true ;
										}
									}
								return null ;
							}
*/							
				//procedimiento para modificar los datos de seguridad de un proceso determinado, para ello deberan cumplrse las siguientes condiciones
				// - existir una seccion de seguridad del proceso al que se quieren modificar los datos en la propiedad $datos_seguridad_procesos de esta misma clase
				// - existir el id del proceso que ejecuta este procedimiento en la estructura 'acceso_seguridad' = array('id_proceso_cliente1' = 'tipo de acceso'' = 'leer::escribir::eliminar'),perteneciente a la seccion de seguridad del proceso al que se quieren modificar los datos, en la propiedad $datos_seguridad_procesos de esta misma clase y corresponderse con los permisos otorgados, solo se prescinde de esta condicion si el proceso intenta acceder a sus propios datos 
				//$id_proceso es el identificador del proceso al que se quieren modificar los datos de seguridad, si se quieren modificar los datos del proceso actual(en ejecucion) se introduce el valor 'hereda', o el id que le corresponde, por defecto este par�metro tiene el valor 'hereda', si el valor de este parametro es vacio el procedimiento retorna el valor null, 
				//$estructura_acceder //
				
					//para valor 1 del parametro $tipo_accion (referencia) este puede contener un arreglo vacio para obtener todo el arreglo perteneciente al arreglo $datos_seguridad_procesos[id_proceso], array() un arreglo vacio es por defecto el valor que tiene, o se puede acceder solo a una parte de su estructura si se le da el valor a este parametro de una cadena con la esrtuctura a la que se quiere acceder, ejemlpo '[acceso_seguridad][procesos]' y el debolvera el elemento $datos_seguridad_procesos[id_proceso][acceso_seguridad][procesos], todo esto en dependencia de los permisos de acceso a esta estructura del proceso cliente 
				
					//para valores 2 y 3 del parametro $tipo_accion (referencia) es un arreglo asociativo con los elementos que se quieren eliminar o modificar en el arreglo $datos_seguridad_procesos[id_proceso],
					// esta matriz contendra la estructura exacta en la que se encuentra el elemento que se quiere eliminar o modificar,
					// es como un mapa, una imagen de la matriz y su rama o elemento que se quiere eliminar o modificar, llamemosle de ahora en adelante "estructura imagen"
					// en caso de que toda una rama del arreglo se quiera eliminar basta con poner 'elemento'=array() y se eliminara ese elemento junto a la rama que el constitulle,
					// el primer elemento del arreglo $La_elementos ser� el primer elemento a buscar en el arreglo $datos_seguridad_procesos[id_proceso] , y as� sucecivamente.
					// si su valor es vacio el procedimiento retorna el valor null
				
				//$tipo_accion es el tipo de modificacion que se utilizara con los posibles valores siguientes, 1 para leer 2 para escribir o modificar , 3 para eliminar, si su valor es diferente de los valores permitidos el procedimiento retorna el valor null, este parametro tambien debe coincidir con los permisos de escribir o eliminar que debe tener el proceso actual (en ejecucion) sobre el proceso de los datos a modificar o eliminar  
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
     	   		//el proceso que solicita el procedimiento no tiene obligacion de haber inicializado seccion de seguridad en la instancia de esta clase con ecepcion de que quien solicite el procedimiento lo haga para modificar sus propios datos, en este caso si debe existir una apertura de seccion de seguridad con antelacion, para ello existe el procedimiento iniciarDatosSeguridadProceso_comun en esta misma clase
				//	  
						
/*				public function accederDatosSeguridadProceso_comun( $id_proceso = 'hereda' , $estructura_acceder = array() , $tipo_accion = 1 , $condicion_modificacion = 0 )
							{
								if ( !empty( $id_proceso ) && !empty( $this->EEoNucleo ) && $this->existencia_id_proceso_comun( $id_proceso ) && ( ( $tipo_accion == 1 ) || ( $tipo_accion == 2 ) || ( $tipo_accion == 3 ) ) )  
									{
										if ( empty( $estructura_acceder) && ( ( $tipo_accion == 2 ) || ( $tipo_accion == 3 ) ) )
											{
												return null ;
											}
										$id_proceso_actual = $this->EEoNucleo->idProcesoEjecucion();
										if ( strtolower( $id_proceso ) == 'hereda' || ( $id_proceso == $id_proceso_actual ) )
											{
												$id_proceso = $id_proceso_actual ;
											}
										if (  $id_proceso != $id_proceso_actual )
											{
												$tipo_acceso = null ;
												
												if ( !empty( $this->datosSeguridadProcesos[$id_proceso]['acceso_seguridad']['ambito'] ) && ( ( $this->datosSeguridadProcesos[$id_proceso]['acceso_seguridad']['ambito'] == 'restrictivo' ) || ( $this->datosSeguridadProcesos[$id_proceso]['acceso_seguridad']['ambito'] == 'permisivo' ) ) )
													{
														$ambito_seguridad_operativo = $this->datosSeguridadProcesos[$id_proceso]['acceso_seguridad']['ambito'] ; 
													}
												else
													{
														$ambito_seguridad_operativo = $this->ambito_seguridad ;
													}
												
												if ( $ambito_seguridad_operativo == 'restrictivo' )
													{
														if ( !empty( $this->datosSeguridadProcesos[$id_proceso]['acceso_seguridad']['procesos'][$id_proceso_actual] ) )
															{
																$tipo_acceso = $this->datosSeguridadProcesos[$id_proceso]['acceso_seguridad']['procesos'][$id_proceso_actual] ;
															}
														elseif ( !empty( $this->datosSeguridadProcesos[$id_proceso]['acceso_seguridad']['procesos']['*'] ) )
															{
																$tipo_acceso = $this->datosSeguridadProcesos[$id_proceso]['acceso_seguridad']['procesos']['*'] ;
															}
														else
															{
																return null ;	
															}
															
														$tipo_acceso = $this->datosSeguridadProcesos[$id_proceso]['acceso_seguridad']['procesos'][$id_proceso_actual] ;
																
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
																
														if ( ( ( $tipo_accion == 1 ) && ( $acceso_leer != 'leer' ) ) || ( ( $tipo_accion == 2 ) && ( $acceso_escribir != 'escribir' ) ) || ( ( $tipo_accion == 3 ) && ( $acceso_eliminar != 'eliminar' ) ) )
															{
																return null ;
															}
													}
												elseif( $ambito_seguridad_operativo == 'permisivo' )
													{
														if ( !empty( $this->datosSeguridadProcesos[$id_proceso]['acceso_seguridad']['procesos'][$id_proceso_actual] ) ) 
															{
																$varcorta = &$this->datosSeguridadProcesos[$id_proceso]['acceso_seguridad']['procesos'][$id_proceso_actual] ;	
															}
														elseif ( !empty( $this->datosSeguridadProcesos[$id_proceso]['acceso_seguridad']['procesos']['*'] ) )
															{
																$varcorta = &$this->datosSeguridadProcesos[$id_proceso]['acceso_seguridad']['procesos']['*'] ;
															}
														if ( isset( $varcorta ) )
															{	
																if ( ( $varcorta == 'leer::escribir::eliminar' ) || ( $varcorta == 'leer::eliminar::escribir' ) || ( $varcorta == 'eliminar::leer::escribir' ) || ( $varcorta == 'eliminar::escribir::leer' ) || ( $varcorta == 'escribir::eliminar::leer' ) || ( $varcorta == 'escribir::leer::eliminar' ) )
																	{
																		return null ;	
																	}
																				
																$tipo_acceso = $varcorta ;	
																
																$acceso_leer = 'leer' ;
																$acceso_escribir = 'escribir' ;
																$acceso_eliminar = 'eliminar' ;
																
																if ( is_string( $tipo_acceso ) )
																	{
																		$arreglo_acceso = explode( '::' , $tipo_acceso ) ;
																		foreach ( $arreglo_acceso as $elemento)
																			{
																				switch ( $elemento )
																					{
																						case 'leer'     : $acceso_leer = null ;
																									      break ; 
																						case 'escribir' : $acceso_escribir = null ;
																									      break ;
																						case 'eliminar' : $acceso_eliminar = null ;
																									      break ;			  	
																					}
																			} 
																	}
																
																if ( ( ( $tipo_accion == 1 ) && ( $acceso_leer != 'leer' ) ) || ( ( $tipo_accion == 2 ) && ( $acceso_escribir != 'escribir' ) ) || ( ( $tipo_accion == 3 ) && ( $acceso_eliminar != 'eliminar' ) ) )
																	{
																		return null ;
																	}
															}
													}
												else
													{
														return null ;
													}
											}
										$La_resultado = null;											
										switch ( $tipo_accion )
											{
												case 1 : //leer
														 if ( is_array( $estructura_acceder ) && empty( $estructura_acceder ) )
														 	{
														 		$La_resultado = $this->datosSeguridadProcesos[$id_proceso];
														 	}
														 elseif( is_string( $estructura_acceder ) && ( stripos( $estructura_acceder , ';' ) === false ) && ( stripos( $estructura_acceder , ')' ) === false ) && ( stripos( $estructura_acceder , '{' ) === false ) )
															{
															
																$cadena_ejecutar = " if ( isset( \$this->datosSeguridadProcesos[\$id_proceso]$estructura_acceder ) )
																						{
																							\$La_resultado = \$this->datosSeguridadProcesos[\$id_proceso]$estructura_acceder ;
																						}
																					";
																eval( $cadena_ejecutar );
															}
														 return $La_resultado ;
														 break ;
												
												case 2 : //escribir o modificar
														 $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloModificarRecursivo( $estructura_acceder , $this->datosSeguridadProcesos[$id_proceso] , $condicion_modificacion );
														 break ;
														 
												case 3 : //eliminar
														 $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloEliminarRecursivo( $estructura_acceder , $this->datosSeguridadProcesos[$id_proceso] , $condicion_modificacion );
														 break ;
											}
										if ( ( $tipo_accion != 1 ) && !empty( $La_resultado ['arreglo_base'] ) )
											{
												$this->datosSeguridadProcesos[$id_proceso] = $La_resultado ['arreglo_base'] ;
												return true ;
											}
									}
								return null ;	
							}	
*/	
				//este procedimiento gestiona si un proceso idcliente (ejecutandose , actual) tiene permiso a ejecutar otro proceso   
				//$id_proceso es el identificador del proceso al que se quiere chequear si el proceso actual (en ejecucion) puede ejecutar, si su valor es vacio el procedimiento retorna el valor null
				//si el proceso actual(ejecutandose) es cliente de ejecutar el proceso al que se chequea, este procedimiento debuelve la cadena 'ejecucion' 
				//este procedimiento retorna null si es insatisfactorio o si el proceso actual no tiene permiso de ejecutar el proceso analizado . 
				//si el $id_proceso no existe en la propiedad datos_seguridad_procesos de este objeto entonces retornanra el valor ejecucion
				  
/*				public function clienteEjecucionProceso_comun( $id_proceso )
							{
								if ( !empty( $this->EEoNucleo ) )
									{
										$id_proceso_ejecucion = $this->EEoNucleo->idProcesoEjecucion() ;
									}
								
								if ( !empty( $id_proceso ) && !empty( $id_proceso_ejecucion ) )
									{
*/										/*
                                        if ( $id_proceso == 'hereda' )
											{
												$id_proceso = $id_proceso_ejecucion ;
											}
                                        */
/*										$existencia_id_proceso_comun = $this->existencia_id_proceso_comun( $id_proceso ) ;
										if ( !empty( $existencia_id_proceso_comun ) )
											{
												if ( !empty( $this->datosSeguridadProcesos[$id_proceso]['permiso_ejecucion']['ambito'] ) && ( ( $this->datosSeguridadProcesos[$id_proceso]['permiso_ejecucion']['ambito'] == 'retrictivo' ) || ( $this->datosSeguridadProcesos[$id_proceso]['permiso_ejecucion']['ambito'] == 'permisivo' ) ) )
													{
														$ambito_seguridad_operativo = $this->datosSeguridadProcesos[$id_proceso]['permiso_ejecucion']['ambito'] ; 
													}
												else
													{
														$ambito_seguridad_operativo = $this->ambito_seguridad ;
													}
										
												if ( $ambito_seguridad_operativo == 'restrictivo' )
													{
														if ( !empty( $this->datosSeguridadProcesos[$id_proceso]['permiso_ejecucion']['procesos'] ) && is_array( $this->datosSeguridadProcesos[$id_proceso]['permiso_ejecucion']['procesos'] ) )
															{
																foreach( $this->datosSeguridadProcesos[$id_proceso]['permiso_ejecucion']['procesos'] as $proceso_cliente )
																	{
																		if ( $proceso_cliente == $id_proceso_ejecucion )
																			{
																				return 'ejecucion' ;	
																			}
																	}
															}
													}
												elseif ( $ambito_seguridad_operativo == 'permisivo' )
													{
														$ejecucion = true ;
														if ( !empty( $this->datosSeguridadProcesos[$id_proceso]['permiso_ejecucion']['procesos'] ) && is_array( $this->datosSeguridadProcesos[$id_proceso]['permiso_ejecucion']['procesos'] ) )
															{
																foreach( $this->datosSeguridadProcesos[$id_proceso]['permiso_ejecucion']['procesos'] as $proceso_cliente )
																	{
																		if ( $proceso_cliente == $id_proceso_ejecucion )
																			{
																				$ejecucion = false ;
																				break ;	
																			}
																	}
																if ( $ejecucion == true )
																	{
																		return 'ejecucion' ;
																	}
															}
													}	
											}
										else
											{
												return 'ejecucion' ;
											}
									}
								return null ;
							}
*/					
				//este procedimiento gestiona si un proceso idcliente (ejecutandose , actual) tiene acceso a los datos de otro proceso, y de ser sierto obtener el tipo de acceso, este acceso es referente a los datos contenidos en la clase DatosProcesos  
				//$id_proceso es el identificador del proceso al que se quiere chequear si el proceso actual (en ejecucion) puede tener acceso a sus datos, si su valor es vacio el procedimiento retorna el valor null
				//si el proceso actual(ejecutandose) es cliente de los datos del proceso al que se chequea, este procedimiento debuelve el tipo de acceso permitido(siempre el permitido, nunca el denegado)('leer', 'escribir', 'eliminar') con la estructura siguiente 'leer::escribir::eliminar' omitiendose el acceso no deseado (ver estructura del arreglo $datos_seguridad_procesos) declarado, ej:'leer' o 'leer::eliminar' 
				//este procedimiento retorna null si es insatisfactorio o si el proceso actual no tiene acceso alguno a los datos del proceso analizado . 
				  
/*				public function clienteAccesoDatosProceso_comun( $id_proceso )
							{
								if ( !empty ( $id_proceso ) && $this->existencia_id_proceso_comun( $id_proceso ) && !empty( $this->EEoNucleo ) )
									{
										if ( !empty( $this->datosSeguridadProcesos[$id_proceso]['acceso_datos']['ambito'] ) && ( ( $this->datosSeguridadProcesos[$id_proceso]['acceso_datos']['ambito'] == 'restrictivo' ) || ( $this->datosSeguridadProcesos[$id_proceso]['acceso_datos']['ambito'] == 'permisivo' ) ) )
													{
														$ambito_seguridad_operativo = $this->datosSeguridadProcesos[$id_proceso]['acceso_datos']['ambito'] ; 
													}
												else
													{
														$ambito_seguridad_operativo = $this->ambito_seguridad ;
													}
										
										if ( $ambito_seguridad_operativo == 'restrictivo' )
											{
												if ( !empty( $this->datosSeguridadProcesos[$id_proceso]['acceso_datos']['procesos'][$this->EEoNucleo->idProcesoEjecucion()] ) )
													{
														return $this->datosSeguridadProcesos[$id_proceso]['acceso_datos']['procesos'][$this->EEoNucleo->idProcesoEjecucion()] ;
													}
												elseif ( !empty( $this->datosSeguridadProcesos[$id_proceso]['acceso_datos']['procesos']['*'] ) )
													{
														return $this->datosSeguridadProcesos[$id_proceso]['acceso_datos']['procesos']['*'] ;
													}
												
											}
										elseif ( $ambito_seguridad_operativo == 'permisivo' )
											{
												if ( !empty( $this->datosSeguridadProcesos[$id_proceso]['acceso_datos']['procesos'][$this->EEoNucleo->idProcesoEjecucion()] ) )
													{
														$tipo_acceso = $this->datosSeguridadProcesos[$id_proceso]['acceso_datos']['procesos'][$this->EEoNucleo->idProcesoEjecucion()] ;
													}
												elseif ( !empty( $this->datosSeguridadProcesos[$id_proceso]['acceso_datos']['procesos']['*'] ) )
													{
														$tipo_acceso = $this->datosSeguridadProcesos[$id_proceso]['acceso_datos']['procesos']['*'] ;
													}
												else 
													{
														return 'leer::escribir::eliminar';
													}
												if ( !empty( $tipo_acceso ) )
													{
														$acceso_leer = 'leer' ;
														$acceso_escribir = 'escribir' ;
														$acceso_eliminar = 'eliminar' ;
																
														if ( is_string( $tipo_acceso ) )
															{
																$arreglo_acceso = explode( '::' , $tipo_acceso ) ;
																foreach ( $arreglo_acceso as $elemento)
																	{
																		switch ( $elemento )
																			{
																				case 'leer'     : $acceso_leer = null ;
																							      break ; 
																				case 'escribir' : $acceso_escribir = null ;
																							      break ;
																				case 'eliminar' : $acceso_eliminar = null ;
																							      break ;			  	
																			}
																	} 
															}
														if ( !empty( $acceso_leer ) && ( !empty( $acceso_escribir ) || !empty( $acceso_eliminar ) ) )
															{
																$acceso_leer.='::' ;
															}
														if ( !empty( $acceso_escribir ) &&  !empty( $acceso_eliminar ) )
															{
																$acceso_escribir.='::' ;
															}
														$tipo_acceso = $acceso_leer.$acceso_escribir.$acceso_eliminar ;
														if ( !empty($tipo_acceso))
                                                            {
                                                                return $tipo_acceso ;
                                                            }	
                                                    }
											}
									}
								return null ;
							}
*/							
				//este procedimiento gestiona si un proceso idcliente (ejecutandose , actual) tiene acceso a los datos de configuracion de otro proceso, y de ser sierto obtener el tipo de acceso, este acceso es referente a los datos contenidos en la clase Configuracion_gestor  
				//$id_proceso es el identificador del proceso al que se quiere chequear si el proceso actual (en ejecucion) puede tener acceso a sus datos de configuracion, si su valor es vacio el procedimiento retorna el valor null
				//si el proceso actual(ejecutandose) es cliente de los datos del proceso al que se chequea, este procedimiento debuelve el tipo de acceso permitido(siempre el permitido, nunca el denegado)('leer', 'escribir', 'eliminar') con la estructura siguiente 'leer::escribir::eliminar' omitiendose el acceso no deseado (ver estructura del arreglo $datos_seguridad_procesos) declarado, ej:'leer' o 'leer::eliminar' 
				//este procedimiento retorna null si es insatisfactorio o si el proceso actual no tiene acceso alguno a los datos de configuracion del proceso analizado . 
				  
/*				public function clienteAccesoConfiguracionProceso_comun( $id_proceso )
							{
								if ( !empty ( $id_proceso ) && $this->existencia_id_proceso_comun( $id_proceso ) && !empty( $this->EEoNucleo ) )
									{
										if ( !empty( $this->datosSeguridadProcesos[$id_proceso]['acceso_configuracion']['ambito'] ) && ( ( $this->datosSeguridadProcesos[$id_proceso]['acceso_configuracion']['ambito'] == 'restrictivo' ) || ( $this->datosSeguridadProcesos[$id_proceso]['acceso_configuracion']['ambito'] == 'permisivo' ) ) )
													{
														$ambito_seguridad_operativo = $this->datosSeguridadProcesos[$id_proceso]['acceso_configuracion']['ambito'] ; 
													}
												else
													{
														$ambito_seguridad_operativo = $this->ambito_seguridad ;
													}
										
										if ( $ambito_seguridad_operativo == 'restrictivo' )
											{
												if ( !empty( $this->datosSeguridadProcesos[$id_proceso]['acceso_configuracion']['procesos'][$this->EEoNucleo->idProcesoEjecucion()] ) )
													{
														return $this->datosSeguridadProcesos[$id_proceso]['acceso_configuracion']['procesos'][$this->EEoNucleo->idProcesoEjecucion()] ;
													}
												elseif ( !empty( $this->datosSeguridadProcesos[$id_proceso]['acceso_configuracion']['procesos']['*'] ) )
													{
														return $this->datosSeguridadProcesos[$id_proceso]['acceso_configuracion']['procesos']['*'] ;
													}
												
											}
										elseif ( $ambito_seguridad_operativo == 'permisivo' )
											{
												if ( !empty( $this->datosSeguridadProcesos[$id_proceso]['acceso_configuracion']['procesos'][$this->EEoNucleo->idProcesoEjecucion()] ) )
													{
														$tipo_acceso = $this->datosSeguridadProcesos[$id_proceso]['acceso_configuracion']['procesos'][$this->EEoNucleo->idProcesoEjecucion()] ;
													}
												elseif ( !empty( $this->datosSeguridadProcesos[$id_proceso]['acceso_configuracion']['procesos']['*'] ) )
													{
														$tipo_acceso = $this->datosSeguridadProcesos[$id_proceso]['acceso_configuracion']['procesos']['*'] ;
													}
												else 
													{
														return 'leer::escribir::eliminar';
													}
												if ( !empty( $tipo_acceso ) )
													{
														$acceso_leer = 'leer' ;
														$acceso_escribir = 'escribir' ;
														$acceso_eliminar = 'eliminar' ;
																
														if ( is_string( $tipo_acceso ) )
															{
																$arreglo_acceso = explode( '::' , $tipo_acceso ) ;
																foreach ( $arreglo_acceso as $elemento)
																	{
																		switch ( $elemento )
																			{
																				case 'leer'     : $acceso_leer = null ;
																							      break ; 
																				case 'escribir' : $acceso_escribir = null ;
																							      break ;
																				case 'eliminar' : $acceso_eliminar = null ;
																							      break ;			  	
																			}
																	} 
															}
														if ( !empty( $acceso_leer ) && ( !empty( $acceso_escribir ) || !empty( $acceso_eliminar ) ) )
															{
																$acceso_leer.='::' ;
															}
														if ( !empty( $acceso_escribir ) &&  !empty( $acceso_eliminar ) )
															{
																$acceso_escribir.='::' ;
															}
														$tipo_acceso = $acceso_leer.$acceso_escribir.$acceso_eliminar ;
														if ( !empty($tipo_acceso))
                                                            {
                                                                return $tipo_acceso ;
                                                            }	
													}
											}
									}
								return null ;
							}
*/
				
                /////////////////////////////////APLICACIONES Y MODULOS////////////////////////////////////////////////////////////////////////////////
                    
                
                //procedimiento para buscar la existencia de un idaplicacion o modulo de aplicacion en el contenedor de datos de seguridad de las aplicaciones y modulos
				//$id_aplicacion es el id de la alpicacion que se quiere buscar si existe, si se le da el valor 'hereda' este hara referencia a la aplicacion actual en ejecucion', si su valor es vacio el procedimiento retorna el valor null
                //$id_modulo es el id del modulo que se quiere buscar si existe, si se le da el valor 'hereda' este hara referencia al mmodulo actual en ejecucion', los modulos tienen obligatoriamente que estar asociados con una aplicacion, si se hace una busqueda de modulo y este no existe pero si la alpicacion correspondiente el metodo debuelve el string 'aplicacion', de no existir ninguno de los dos el metodo debuelve null
				//este procedimiento retorna la cadena 'aplicacion' en caso de ser una busqueda de aplicacion solamente y haber sido satisfactoria la operacion, retorna la cadena 'modulo' en caso de ser una busqueda de modulo y haber sido satisfactoria la operacion, si es insatisfactoria la operacion el valor retornado por este procedimiento es null 
/*				public function existencia_id_appmod( $id_aplicacion = 'hereda' , $id_modulo = '' )
		 		 			{
		 		 				if ( !empty ( $id_aplicacion ) )
									{
										if ( $id_aplicacion == 'hereda' && is_object( $this->EEoNucleo ) )
											{
												$id_aplicacion = $this->EEoNucleo->aplicacion_ejecucion() ;	
											}
										if ( !empty ( $this->datos_seguridad_appmod[$id_aplicacion] ) )
											{
												if ( !empty ( $id_modulo ) )
                                                    {
                                                        if ( $id_modulo == 'hereda' && is_object( $this->EEoNucleo ) )
											                 {
												                $id_modulo = $this->EEoNucleo->modulo_ejecucion() ;	
											                 }
                                                        if ( !empty ( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo] ) )
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
*/                
                //procedimiento para crear o inicializar un nuevo espacio de seguridad perteneciente a la aplicacion o modulo correspondiente
				//El $id_aplicacion y/o $id_modulo para la inicializacion de los datos lo toma automaticamente la funcion de la aplicacion y/o modulo que se ejecuta en ese momento, es el identificador de la aplicacion y/o modulo a nuevo ingreso de sus datos, y es la aplicacion y/o modulo que se encuentra como activo en ese momento en el objeto nucleo, si su valor es vacio el procedimiento retorna el valor null 
				//$datos_seguridad es la estructura de datos de seguridad a guardar, no olvidar que esta debe ajustarse a una estructura preconsevida para esta clase, sino algunas de sus prestaciones no funcionaran con la estructura de datos atipica, si su valor es vacio el procedimiento retorna el valor null 
				//$tipo es para definir si los datos a inicializar seran de una aplicacion $tipo = 'aplicacion', un modulo de aplicacion $tipo = 'modulo', en caso de contener un valor diferente de los mencionados el procedimiento retorna el valor null
                //este procedimiento utiliza un procedimiento del objeto $EEoNucleo a travez de $this->EEoNucleo
				//este procedimiento retorna true si la operacion es satisfactoria y null si es insatisfactoria
				//si se intenta inicializar datos en espacios corespondientes a datos inicialisados ya, el procedimiento retorna el valor null
/*                public function inicializar_datoseguridad_appmod( $datos_seguridad )
							{
								if( !empty( $this->EEoNucleo ) && !empty ( $datos_seguridad  ) && ( ( $this->EEoNucleo->gedeeProcesoEjecucion() == 'aplicacion' ) || ( $this->EEoNucleo->gedeeProcesoEjecucion() == 'modulo' ) ) )
									{
										$id_aplicacion = $this->EEoNucleo->aplicacion_ejecucion() ;
                                        if ( !empty( $id_aplicacion ) )
										  {
                                                switch( $this->EEoNucleo->gedeeProcesoEjecucion() )
                                                    {
                                                        case 'aplicacion' :  if( $this->existencia_id_appmod( $id_aplicacion ) == null )
                                                                                {
                                                                                    $this->datos_seguridad_appmod[ $id_aplicacion ] = $datos_seguridad ;
                                                                                    return true ;
                                                                                }
                                                                             break ;
                                                        
                                                        case 'modulo' :  $id_modulo = $this->EEoNucleo->modulo_ejecucion() ;
                                                                             if( !empty( $id_modulo ) && ( $this->existencia_id_appmod( $id_aplicacion , $id_modulo ) != 'modulo' ) )
                                                                                {
                                                                                    $this->datos_seguridad_appmod[ $id_aplicacion ]['modulos'][ $id_modulo ] = $datos_seguridad ;
                                                                                    return true ;
                                                                                }
                                                                              break ;    
                                                    }
										  }
									}
								return null ;
							}
*/                            
                //procedimiento para modificar los datos de seguridad de un proceso aplicacion o modulo de aplicacion, para ello deberan cumplrse las siguientes condiciones
                //este procedimiento se corresponde con la estructura 'acceso_seguridad' de las aplicaciones y/o modulos en la propiedad datos_seguridad_appmod de esta clase
				// - existir una seccion de seguridad de la aplicacion o modulo proceso al que se quieren leer o modificar los datos en la propiedad $datos_seguridad_appmod de esta misma clase
				// - existir el id de la aplicacion o modulo proceso que ejecuta este procedimiento en la estructura 'acceso_seguridad',perteneciente a la seccion de seguridad de la aplicacion o modulo proceso al que se quieren modificar los datos, en la propiedad $datos_seguridad_appmod de esta misma clase y corresponderse con los permisos otorgados, solo se prescinde de esta condicion si el proceso aplicacion o modulo intenta acceder a sus propios datos 
				//$id_aplicacion es el identificador del proceso aplicacion al que se quieren modificar los datos de seguridad, si se quieren modificar los datos del proceso aplicacion actual(en ejecucion) se introduce el valor 'hereda', o el id que le corresponde, por defecto este par�metro tiene el valor 'hereda', si el valor de este parametro es vacio el procedimiento retorna el valor null, 
				//$id_modulo es el identificador del proceso modulo al que se quieren modificar los datos de seguridad, si se quieren modificar los datos del proceso modulo actual(en ejecucion) se introduce el valor 'hereda', o el id que le corresponde, por defecto este par�metro tiene el valor '' (string vacio), el trabajo con este parametro depende del elemento especificidad_servidor que forma parte de la propiedad $datos_seguridad_appmod de esta misma clase, para complementar esta aayuda debe verse la ayuda de la propiedad $datos_seguridad_appmod de esta misma clase.
				//$estructura_acceder //
				
					//para valor 1 del parametro $tipo_accion (referencia) este puede contener un arreglo vacio para obtener todo el arreglo perteneciente al arreglo $datos_seguridad_appmod[id_aplicacion], array() un arreglo vacio es por defecto el valor que tiene, o se puede acceder solo a una parte de su estructura si se le da el valor a este parametro de una cadena con la esrtuctura a la que se quiere acceder, ejemlpo '[acceso_seguridad][aplicaciones]' y el debolvera el elemento $datos_seguridad_appmod[id_aplicacion][acceso_seguridad][aplicaciones], todo esto en dependencia de los permisos de acceso a esta estructura del proceso aplicacion o modulo cliente, de igual forma funciona para la estructura de un modulo de aplicacion 
				
					//para valores 2 y 3 del parametro $tipo_accion (referencia) es un arreglo asociativo con los elementos que se quieren eliminar o modificar en el arreglo $datos_seguridad_appmod[id_aplicacion],de igual forma funciona para la estructura de un modulo de aplicacion
					// esta matriz contendra la estructura exacta en la que se encuentra el elemento que se quiere eliminar o modificar,
					// es como un mapa, una imagen de la matriz y su rama o elemento que se quiere eliminar o modificar, llamemosle de ahora en adelante "estructura imagen"
					// en caso de que toda una rama del arreglo se quiera eliminar basta con poner 'elemento'=array() y se eliminara ese elemento junto a la rama que el constitulle,
					// el primer elemento del arreglo $La_elementos ser� el primer elemento a buscar en el arreglo $datos_seguridad_appmod[id_proceso] , y as� sucecivamente.
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
     	   		//el proceso aplicacion o modulo que solicita el procedimiento no tiene obligacion de haber inicializado seccion de seguridad en la instancia de esta clase con ecepcion de que quien solicite el procedimiento lo haga para modificar sus propios datos, en este caso si debe existir una apertura de seccion de seguridad con antelacion, para ello existe el procedimiento inicializar_datoseguridad_appmod en esta misma clase  
						
				
				//la especificidad_servidor es a que nivel estructural se evaluaran los permisos
                //si la especificidad_servidor declarada es 'aplicacion' pero en este procedimiento se declara un $id_modulo diferente de vacio entonces el procedimiento se ejecutara con especificidad_servidor a nivel de modulo, con todos sus requisitos
                //cuando se heredan la aplicacion y el modulo no se tiene en cuanta la especificidad_servidor porque estan accediendo a sus propios datos 
                //si la especificidad_servidor declarada es modulos y quien solicita este procedimiento es la aplicacion actual(ejecutandose), sin que haya un modulo actual(ejecutandose), entonces este procedimiento cambia la especificidad_servidor a aplicacion para que esta aplicacion pueda gestionar sus propios datos, se aclara solo la aplicacion no sus modulo y solo la aplicacion actual 
                //recuerda cuando utilices esta funcion y no haya modulo tienes que pasar un valor vacio pero no null
				//en la opcion de eliminar elimina por la clave de la rama de array no por el valor de la clave
                //si se declara un idaplicacion o idmodulo y este no existe en la estructura del arreglo de datos de seguridad entonces el procedimiento retorna el valor null
                //si en la propiedad 'especificidad_servidor' de esta estructura de datos se encuentra el valor aplicacion pero se introduce un $id_modulo en este procedimiento que existe en la estructura de datos, el procedimiento trabajara con el modulo existente, convirtiendo el valor de 'especificidad_servidor' a modulo
/*                public function acceder_datoseguridad_appmod( $id_aplicacion = 'hereda' ,$id_modulo = '' , $estructura_acceder = array() , $tipo_accion = 1 , $condicion_modificacion = 0 )
							{
								if ( !empty( $id_aplicacion ) && !empty( $this->EEoNucleo ) && ( $this->existencia_id_appmod( $id_aplicacion ) == 'aplicacion' ) && ( ( $tipo_accion == 1 ) || ( $tipo_accion == 2 ) || ( $tipo_accion == 3 ) ) )  
									{
										if ( empty( $estructura_acceder) && ( ( $tipo_accion == 2 ) || ( $tipo_accion == 3 ) ) )
											{
												return null ;
											}
										$id_aplicacion_actual = $this->EEoNucleo->aplicacion_ejecucion();
                                        $id_modulo_actual = $this->EEoNucleo->modulo_ejecucion();
                                        $aplicacion_ejecutandose = false ;
                                        $modulo_ejecutandose = false ; 
                                        //////////////////////gestionando accesos a nivel de aplicacion servidor//////////////////////
                                        
                                        if ( strtolower( $id_aplicacion ) == 'hereda' )
											{
												$id_aplicacion = $id_aplicacion_actual ;
                                            }
                                        /////////////////////declarando especificidad_servidor de la gestion/////////////////////////////
                                        
                                        $especificidad_servidor = null ;
										if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['propiedades']['especificidad_servidor'] ) )
                                        	{
                                        		$especificidad_servidor = $this->datos_seguridad_appmod[$id_aplicacion]['propiedades']['especificidad_servidor'];
                                        	}
										
                                        if ( ( $id_aplicacion == $id_aplicacion_actual ) && empty( $id_modulo ) )
                                            {
                                                $aplicacion_ejecutandose = true ;
                                            }
                                        if ( ( ( $especificidad_servidor != 'aplicacion' ) && ( $especificidad_servidor != 'modulo' ) ) || ( $aplicacion_ejecutandose && ( $especificidad_servidor == 'modulo' ) ) )
                                            {
                                                $especificidad_servidor = 'aplicacion' ;
                                            }
                                                                                    
                                        ///////////////////////////////////////////////////////////////////////////////////////////////
										
                                        ////////////////////////////existencia de espacio modulo////////////////////////
                                        
                                        if ( !empty( $id_modulo ) )
                                            {
                                                if ( strtolower( $id_modulo ) == 'hereda' )
                                                    {
                                                        $id_modulo = $id_modulo_actual ;
                                                    }
                                                if ( $this->existencia_id_appmod( $id_aplicacion , $id_modulo ) == 'modulo' )
                                                    {
                                                        $especificidad_servidor = 'modulo' ;
                                                    }   
                                                else
                                                    {
                                                        return null ; 
                                                    }   
                                            }
                                        elseif ( $especificidad_servidor == 'modulo' )
                                            {
                                                return null ;
                                            }
                                        
                                        ///////fin existencia de espacio modulo y continuacion de gestion de accesos a nivel de aplicacion//////////////////////////////////////////////////////////////////////////
										                                        
                                        if ( ( $id_aplicacion != $id_aplicacion_actual ) && ( $especificidad_servidor == 'aplicacion' ) )
											{
												$tipo_acceso = null ;
                                                
												////////////////////////declarando ambito de seguridad en aplicacion servidor/////////////////////////////////
												if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['ambito'] ) && ( ( $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['ambito'] == 'restrictivo' ) || ( $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['ambito'] == 'permisivo' ) ) )
													{
														$ambito_seguridad_operativo = $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['ambito'] ; 
													}
												else
													{
														$ambito_seguridad_operativo = $this->ambito_seguridad ;
													}
												
                                                
                                                ///////////////////////////////////ambito de seguridad restrictivo/////////////////////////////////////
												if ( $ambito_seguridad_operativo == 'restrictivo' )
													{
														/////////////////////declarando especificidad_cliente de la gestion/////////////////////////////
                                        
                                			            $especificidad_cliente = null ;
													    if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'] ) )
                                        				    {
                                        					   $especificidad_cliente = $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'];
                                    				           //aqui debajo se podria tener en cuenta tambien si existiera un modulo actual y no existieran sus datos en el arreglo, dandole entonces los de la aplicacion actual,pero estaria violando un poco la especificidad
                                   			                   if ( ( ( $especificidad_cliente != 'aplicacion' ) && ( $especificidad_cliente != 'modulo' ) ) || ( ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) ) )
                                            			            {
                                                			            $especificidad_cliente = 'aplicacion' ;
                                            			            }
                                                                elseif ( ( $especificidad_cliente == 'aplicacion' ) && !empty( $id_modulo_actual ) && !empty( $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ) )
                                                                    {
                                                                        $especificidad_cliente = 'modulo' ;
                                                                    }
                                                            }
										                 
                                                        /////////////////////gestionando valor $tipo_acceso/////////////////////////////
														
														if ( $especificidad_cliente == 'aplicacion' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['acceso'] ) )
                                                                    {
                                                                        $tipo_acceso = $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['acceso'] ;
                                                                    }
                                                                else
                                                                    {
                                                                        return null ;
                                                                    }
															}
														elseif ( $especificidad_cliente == 'modulo' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ) )
                                                                    {
                                                                        $tipo_acceso = $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ;
                                                                    }
                                                                else
                                                                    {
                                                                        return null ;
                                                                    }
															}
														
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
												    }
											
												///////////////////////////////////ambito de seguridad permisivo/////////////////////////////////////
                                                elseif( $ambito_seguridad_operativo == 'permisivo' )
                                                    {
                                                        /////////////////////declarando especificidad_cliente de la gestion/////////////////////////////
                                                         
                                			            $especificidad_cliente = null ;
													    if ( isset( $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual] ) && empty( $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual] ) )
                                                            {
                                                                return null ;
                                                            }
                                                        if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual] ) )
                                        				    {
                                        					    if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'] ) )
                                                                    {
                                                                        $especificidad_cliente = $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'];
                                                                    } 
                                                                //aqui debajo se podria tener en cuenta tambien si existiera un modulo actual y no existieran sus datos en el arreglo, dandole entonces los de la aplicacion actual,pero estaria violando un poco la especificidad
                                    			                if ( ( ( $especificidad_cliente != 'aplicacion' ) && ( $especificidad_cliente != 'modulo' ) ) || ( ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) ) )
                                            			            {
                                                			             $especificidad_cliente = 'aplicacion' ;
                                            			            }
                                                                elseif ( ( $especificidad_cliente == 'aplicacion' ) && !empty( $id_modulo_actual ) && !empty( $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ) )
                                                                    {
                                                                        $especificidad_cliente = 'modulo' ;
                                                                    }
                                                            }
										                 
                                                        //////////////////////gestionando valor $tipo_acceso /////////////////////////////////////////////////////////////////////////
                                                
													    if( ( $especificidad_cliente == 'aplicacion' ) || ( $especificidad_cliente == 'modulo' ) )
                                                            {
                                                                if ( $especificidad_cliente == 'aplicacion' )
														          	{
																        if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['acceso'] ) )
                                                                            {
                                                                                $varcorta1 = &$this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['acceso'];
                                                                                if ( ( $varcorta1 == 'leer::escribir::eliminar' ) || ( $varcorta1 == 'leer::eliminar::escribir' ) || ( $varcorta1 == 'eliminar::leer::escribir' ) || ( $varcorta1 == 'eliminar::escribir::leer' ) || ( $varcorta1 == 'escribir::eliminar::leer' ) || ( $varcorta1 == 'escribir::leer::eliminar' ) )
                                                                                    {
                                                                                        return null ;
                                                                                    }
                                                                                $tipo_acceso = $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['acceso'] ;
                                                                            }
                                                                        else
                                                                            {
                                                                                return null ;
                                                                            }
															         }
														         elseif ($especificidad_cliente == 'modulo' )
															         {
																        if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ) )
                                                                            {
                                                                                $varcorta2 = &$this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'];
                                                                                if ( ( $varcorta2 == 'leer::escribir::eliminar' ) || ( $varcorta2 == 'leer::eliminar::escribir' ) || ( $varcorta2 == 'eliminar::leer::escribir' ) || ( $varcorta2 == 'eliminar::escribir::leer' ) || ( $varcorta2 == 'escribir::eliminar::leer' ) || ( $varcorta2 == 'escribir::leer::eliminar' ) )
                                                                                    {
                                                                                        return null ;
                                                                                    }
                                                                                $tipo_acceso = $this->datos_seguridad_appmod[$id_aplicacion]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ;
                                                                            }
                                                                        else
                                                                            {
                                                                                return null ;
                                                                            }
															         }
                                                             }   
														$acceso_leer = 'leer' ;
														$acceso_escribir = 'escribir' ;
														$acceso_eliminar = 'eliminar' ;
																
														if ( is_string( $tipo_acceso ) )
															{
																$arreglo_acceso = explode( '::' , $tipo_acceso ) ;
																foreach ( $arreglo_acceso as $elemento)
																	{
																		switch ( $elemento )
																			{
																				case 'leer'     : $acceso_leer = null ;
																							      break ; 
																				case 'escribir' : $acceso_escribir = null ;
																							      break ;
																				case 'eliminar' : $acceso_eliminar = null ;
																							      break ;			  	
																			}
																	} 
															}
													}
												else
													{
														return null ;
													}
                                                if (  ( ( $tipo_accion == 1 ) && ( $acceso_leer != 'leer' ) ) || ( ( $tipo_accion == 2 ) && ( $acceso_escribir != 'escribir' ) ) || ( ( $tipo_accion == 3 ) && ( $acceso_eliminar != 'eliminar' ) ) )
											        {
												        return null ;
											        }
											}
                                        
                                        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                        
                                        //////////////////////gestionando accesos a nivel de modulo servidor/////////////////////////////////////////
                                      
                                        elseif ( ( $id_modulo != $id_modulo_actual ) && ( $especificidad_servidor == 'modulo' ) )
											{
											     
                                                $tipo_acceso = null ;
												
                                                ////////////////////////declarando ambito de seguridad en modulo servidor/////////////////////////////////
												if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['ambito'] ) && ( ( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['ambito'] == 'restrictivo' ) || ( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['ambito'] == 'permisivo' ) ) )
													{
														$ambito_seguridad_operativo = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['ambito'] ; 
													}
												else
													{
														$ambito_seguridad_operativo = $this->ambito_seguridad ;
													}
												
												///////////////////////////////////ambito de seguridad restrictivo/////////////////////////////////////
                                                if ( $ambito_seguridad_operativo == 'restrictivo' )
													{
														/////////////////////declarando especificidad_cliente de la gestion/////////////////////////////
                                        
                                			            $especificidad_cliente = null ;
													    if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'] ) )
                                        				    {
                                        					   $especificidad_cliente = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'];
                                    				           //aqui debajo se podria tener en cuenta tambien si existiera un modulo actual y no existieran sus datos en el arreglo, dandole entonces los de la aplicacion actual,pero estaria violando un poco la especificidad
                                   			                   if ( ( ( $especificidad_cliente != 'aplicacion' ) && ( $especificidad_cliente != 'modulo' ) ) || ( ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) ) )
                                            			            {
                                                			            $especificidad_cliente = 'aplicacion' ;
                                            			            }
                                                                elseif ( ( $especificidad_cliente == 'aplicacion' ) && !empty( $id_modulo_actual ) && !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ) )
                                                                    {
                                                                        $especificidad_cliente = 'modulo' ;
                                                                    }
                                                            }
										                 
                                                        ///////////////////////////////////////////////////////////////////////////////////////////////
                                                
                                                        /////////////////////gestionando valor $tipo_acceso/////////////////////////////
														
														if ( $especificidad_cliente == 'aplicacion' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['acceso'] ) )
                                                                    {
                                                                        $tipo_acceso = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['acceso'] ;
                                                                    }
                                                                else
                                                                    {
                                                                        return null ;
                                                                    }
															}
														elseif ( $especificidad_cliente == 'modulo' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ) )
                                                                    {
                                                                        $tipo_acceso = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ;
                                                                    }
                                                                else
                                                                    {
                                                                        return null ;
                                                                    }
															}
                                                        																
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
													}
												///////////////////////////////////ambito de seguridad permisivo/////////////////////////////////////
                                                elseif( $ambito_seguridad_operativo == 'permisivo' )
													{
														/////////////////////declarando especificidad_cliente de la gestion/////////////////////////////
                                        
                                			            $especificidad_cliente = null ;
													    if ( isset( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual] ) && empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual] ) )
                                                            {
                                                                return null ;
                                                            }
                                                        if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual] ) )
                                        				    {
                                        					    if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'] ) )
                                                                    {
                                                                        $especificidad_cliente = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'];
                                                                    } 
                                                                //aqui debajo se podria tener en cuenta tambien si existiera un modulo actual y no existieran sus datos en el arreglo, dandole entonces los de la aplicacion actual,pero estaria violando un poco la especificidad
                                    			                if ( ( ( $especificidad_cliente != 'aplicacion' ) && ( $especificidad_cliente != 'modulo' ) ) || ( ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) ) )
                                            			            {
                                                			             $especificidad_cliente = 'aplicacion' ;
                                            			            }
                                                                elseif ( ( $especificidad_cliente == 'aplicacion' ) && !empty( $id_modulo_actual ) && !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ) )
                                                                    {
                                                                        $especificidad_cliente = 'modulo' ;
                                                                    }
                                                            }
										                 
                                                        //////////////////////gestionando valor $tipo_acceso /////////////////////////////////////////////////////////////////////////
                                                
													    if( ( $especificidad_cliente == 'aplicacion' ) || ( $especificidad_cliente == 'modulo' ) )
                                                            {
                                                                if ( $especificidad_cliente == 'aplicacion' )
														          	{
																        if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['acceso'] ) )
                                                                            {
                                                                                $varcorta1 = &$this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['acceso'];
                                                                                if ( ( $varcorta1 == 'leer::escribir::eliminar' ) || ( $varcorta1 == 'leer::eliminar::escribir' ) || ( $varcorta1 == 'eliminar::leer::escribir' ) || ( $varcorta1 == 'eliminar::escribir::leer' ) || ( $varcorta1 == 'escribir::eliminar::leer' ) || ( $varcorta1 == 'escribir::leer::eliminar' ) )
                                                                                    {
                                                                                        return null ;
                                                                                    }
                                                                                $tipo_acceso = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['acceso'] ;
                                                                            }
                                                                        else
                                                                            {
                                                                                return null ;
                                                                            }
															         }
														         elseif ($especificidad_cliente == 'modulo' )
															         {
																        if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ) )
                                                                            {
                                                                                $varcorta2 = &$this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'];
                                                                                if ( ( $varcorta2 == 'leer::escribir::eliminar' ) || ( $varcorta2 == 'leer::eliminar::escribir' ) || ( $varcorta2 == 'eliminar::leer::escribir' ) || ( $varcorta2 == 'eliminar::escribir::leer' ) || ( $varcorta2 == 'escribir::eliminar::leer' ) || ( $varcorta2 == 'escribir::leer::eliminar' ) )
                                                                                    {
                                                                                        return null ;
                                                                                    }
                                                                                $tipo_acceso = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['acceso_seguridad']['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ;
                                                                            }
                                                                        else
                                                                            {
                                                                                return null ;
                                                                            }
															         }
                                                             }   
														$acceso_leer = 'leer' ;
														$acceso_escribir = 'escribir' ;
														$acceso_eliminar = 'eliminar' ;
																
														if ( is_string( $tipo_acceso ) )
															{
																$arreglo_acceso = explode( '::' , $tipo_acceso ) ;
																foreach ( $arreglo_acceso as $elemento)
																	{
																		switch ( $elemento )
																			{
																				case 'leer'     : $acceso_leer = null ;
																							      break ; 
																				case 'escribir' : $acceso_escribir = null ;
																							      break ;
																				case 'eliminar' : $acceso_eliminar = null ;
																							      break ;			  	
																			}
																	} 
															}
													}
												else
													{
														return null ;
													}
                                                if (  ( ( $tipo_accion == 1 ) && ( $acceso_leer != 'leer' ) ) || ( ( $tipo_accion == 2 ) && ( $acceso_escribir != 'escribir' ) ) || ( ( $tipo_accion == 3 ) && ( $acceso_eliminar != 'eliminar' ) ) )
											        {
												        return null ;
											        }    
                                            }
                                        
                                        //////////////////////ejecucion de las acciones de accesos permitidas/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
										$La_resultado = null;											
										switch ( $tipo_accion )
											{
												case 1 : //leer
														 if ( is_array( $estructura_acceder ) && empty( $estructura_acceder ) )
														 	{
														 		if ( $especificidad_servidor == 'aplicacion' )
                                                                    {
                                                                        $La_resultado = $this->datos_seguridad_appmod[$id_aplicacion];
                                                                    }
                                                                elseif ( $especificidad_servidor == 'modulo' )
                                                                    {
                                                                        $La_resultado = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo];
                                                                    }
                                                            }
														 elseif( is_string( $estructura_acceder ) && ( stripos( $estructura_acceder , ';' ) === false ) && ( stripos( $estructura_acceder , ')' ) === false ) && ( stripos( $estructura_acceder , '{' ) === false ) )
															{
															
																if( $especificidad_servidor == 'aplicacion' )
                                                                    {
                                                                        $cadena_ejecutar = " if ( isset( \$this->datos_seguridad_appmod[\$id_aplicacion]$estructura_acceder ) )
																					           	{
																						          	\$La_resultado = \$this->datos_seguridad_appmod[\$id_aplicacion]$estructura_acceder ;
																						          }
																					       ";
                                                                    }
                                                                elseif ( $especificidad_servidor == 'modulo' )
                                                                    {
                                                                        $cadena_ejecutar = " if ( isset( \$this->datos_seguridad_appmod[\$id_aplicacion]['modulos'][\$id_modulo]$estructura_acceder ) )
																					           	{
																						          	\$La_resultado = \$this->datos_seguridad_appmod[\$id_aplicacion]['modulos'][\$id_modulo]$estructura_acceder ;
																						          }
																					       ";
                                                                    }
                                                                
																eval( $cadena_ejecutar );
															}
														 return $La_resultado ;
														 break ;
												
												case 2 : //escribir o modificar
														 
                                                         if ( $especificidad_servidor == 'aplicacion' )
                                                            {
                                                                $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloModificarRecursivo( $estructura_acceder , $this->datos_seguridad_appmod[$id_aplicacion] , $condicion_modificacion );
                                                            }
                                                         elseif ( $especificidad_servidor == 'modulo' )
                                                            {
                                                                $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloModificarRecursivo( $estructura_acceder , $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo] , $condicion_modificacion );
                                                            }
                                                         break ;
														 
												case 3 : //eliminar
														 if ( $especificidad_servidor == 'aplicacion' )
                                                            {
                                                                $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloEliminarRecursivo( $estructura_acceder , $this->datos_seguridad_appmod[$id_aplicacion] , $condicion_modificacion );
                                                            }
                                                         elseif ( $especificidad_servidor == 'modulo' )
                                                            {
                                                                $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloEliminarRecursivo( $estructura_acceder , $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo] , $condicion_modificacion );
                                                            }
                                                         break ;
											}
										///////////////estructuracion y retorno del resultado final de la gestion de este procedimiento////////////////////////////////////
										if ( ( $tipo_accion != 1 ) && !empty( $La_resultado ['arreglo_base'] ) )
											{
												
												if ( $especificidad_servidor == 'aplicacion' )
                                                    {
                                                        $this->datos_seguridad_appmod[$id_aplicacion] = $La_resultado ['arreglo_base'] ;
                                                        return true ;
                                                    }
                                                elseif ( $especificidad_servidor == 'modulo' )
                                                    {
                                                        $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo] = $La_resultado ['arreglo_base'] ;
                                                        return true ;
                                                    }
                                            }
									}
								return null ;	
							}
*/							
				//este procedimiento gestiona si un proceso aplicacion id_aplicacion o modulo id_modulo (ejecutandose , actual) tiene permiso a ejecutar otro proceso aplicacion o modulo  
				//este procedimiento se corresponde con la estructura 'permiso_ejecucion' de las aplicaciones y/o modulos en la propiedad datos_seguridad_appmod de esta clase 
				//$id_aplicacion es el identificador del proceso aplicacion al que se quiere chequear si el proceso aplicacion o modulo actual (en ejecucion) puede ejecutar, si el valor de este parametro es vacio el procedimiento retorna el valor null
				//$id_modulo es el identificador del proceso modulo al que se quiere chequear si el proceso aplicacion o modulo actual (en ejecucion) puede ejecutar,por defecto este par�metro tiene el valor '' (string vacio), el trabajo con este parametro depende del elemento especificidad_servidor que forma parte de la propiedad $datos_seguridad_appmod de esta misma clase, para complementar esta aayuda debe verse la ayuda de la propiedad $datos_seguridad_appmod de esta misma clase.
				//si el proceso actual(ejecutandose) es cliente de ejecutar el proceso al que se chequea, este procedimiento debuelve la cadena 'ejecucion' 
				//este procedimiento retorna null si es insatisfactorio o si el proceso actual no tiene permiso de ejecutar el proceso analizado . 
				  
				//en el cliente ejecucion se deben incluir los datos de la aplicacion actual y sus modulos ya que se debe definir tambien si ellas se pueden ejecutar recursivamente
				//si ambito_seguridad_operativo == 'restrictivo' y y el valor de [$id_aplicacion_actual]['especificidad_cliente'] es vacio el procedimiento retornara null', si tiene un valor pero es diferente de aplicacion o modulo entonses se le asigna automaticamente el valor de aplicacion, si ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) se le asigna automaticamente el valor de aplicacion a $especificidad_cliente 
				//si $ambito_seguridad_operativo == 'permisivo' && isset ['aplicaciones'][$id_aplicacion_actual]&& empty ['aplicaciones'][$id_aplicacion_actual] el procedimiento retornara null 
				//si en la propiedad 'especificidad_servidor' de esta estructura de datos se encuentra el valor aplicacion pero se introduce un $id_modulo en este procedimiento que existe en la estructura de datos, el procedimiento trabajara con el modulo existente, convirtiendo el valor de 'especificidad_servidor' a modulo
                
/*				public function cliente_ejecucion_appmod( $id_aplicacion ,$id_modulo = '' )
							{
								if ( !empty( $id_aplicacion ) && !empty( $this->EEoNucleo ) && ( $this->existencia_id_appmod( $id_aplicacion ) == 'aplicacion' ) )  
									{
										$id_aplicacion_actual = $this->EEoNucleo->aplicacion_ejecucion();
                                        $id_modulo_actual = $this->EEoNucleo->modulo_ejecucion();
                                        $aplicacion_ejecutandose = false ;
                                        $modulo_ejecutandose = false ; 
                                        //////////////////////gestionando ejecucion a nivel de aplicacion servidor//////////////////////
*/                                        /*
                                        if ( $id_aplicacion == 'hereda')
                                            {
                                                $id_aplicacion = $id_aplicacion_actual ;
                                            }
                                        */
                                        /////////////////////declarando especificidad_servidor de la gestion/////////////////////////////
                                        
/*                                        $especificidad_servidor = null ;
										if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['propiedades']['especificidad_servidor'] ) )
                                        	{
                                        		$especificidad_servidor = $this->datos_seguridad_appmod[$id_aplicacion]['propiedades']['especificidad_servidor'];
                                        	}
										
                                        if ( ( $id_aplicacion == $id_aplicacion_actual ) && empty( $id_modulo ) )
                                            {
                                                $aplicacion_ejecutandose = true ;
                                            }
                                        if ( ( ( $especificidad_servidor != 'aplicacion' ) && ( $especificidad_servidor != 'modulo' ) ) || ( $aplicacion_ejecutandose && ( $especificidad_servidor == 'modulo' ) ) )
                                            {
                                                $especificidad_servidor = 'aplicacion' ;
                                            }
                                                                                    
                                        ///////////////////////////////////////////////////////////////////////////////////////////////
										
                                        ////////////////////////////existencia de espacio modulo////////////////////////
                                        
                                        if ( !empty( $id_modulo ) )
                                            {
                                                if ( strtolower( $id_modulo ) == 'hereda' )
                                                    {
                                                        $id_modulo = $id_modulo_actual ;
                                                    }
             							        if ( $this->existencia_id_appmod( $id_aplicacion , $id_modulo ) == 'modulo' )
                                                    {
                                                        $especificidad_servidor = 'modulo' ;
                                                    }   
                                                else
                                                    {
                                                        return null ; 
                                                    }   
                                            }
                                        elseif ( $especificidad_servidor == 'modulo' )
                                            {
                                                return null ;
                                            }
                                        
                                        ///////fin existencia de espacio modulo y continuacion de gestion de ejecucion a nivel de aplicacion//////////////////////////////////////////////////////////////////////////
										                                        
                                        if ( $especificidad_servidor == 'aplicacion' )
											{
												///////////////////////declarando ambito de seguridad en aplicacion servidor/////////////////////////////////
												if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['ambito'] ) && ( ( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['ambito'] == 'restrictivo' ) || ( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['ambito'] == 'permisivo' ) ) )
													{
														$ambito_seguridad_operativo = $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['ambito'] ; 
													}
												else
													{
														$ambito_seguridad_operativo = $this->ambito_seguridad ;
													}
												
                                                
                                                ///////////////////////////////////ambito de seguridad restrictivo/////////////////////////////////////
												if ( $ambito_seguridad_operativo == 'restrictivo' )
													{
														/////////////////////declarando especificidad_cliente de la gestion/////////////////////////////
                                        
                                			            $especificidad_cliente = null ;
													    if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'] ) )
                                        				    {
                                        					   $especificidad_cliente = $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'];
                                    				           //aqui debajo se podria tener en cuenta tambien si existiera un modulo actual y no existieran sus datos en el arreglo, dandole entonces los de la aplicacion actual,pero estaria violando un poco la especificidad
                                   			                   if ( ( ( $especificidad_cliente != 'aplicacion' ) && ( $especificidad_cliente != 'modulo' ) ) || ( ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) ) )
                                            			            {
                                                			            $especificidad_cliente = 'aplicacion' ;
                                            			            }
                                						    }
										                 else
										                 	{
										                 		return null ;
										                 	}
                                                        /////////////////////gestionando permiso a ejecucion/////////////////////////////
														
														if ( $especificidad_cliente == 'aplicacion' )
															{
																return 'ejecucion' ;
                                                            }
														elseif ( $especificidad_cliente == 'modulo' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['modulos'] ) && is_array( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['modulos'] ) )
																	{
																		foreach( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['modulos'] as $appmod_cliente )
																			{
																				if ( $appmod_cliente == $id_modulo_actual )
																					{
																						return 'ejecucion' ;	
																					}
																			}
																	}
																return null ;
                                                            }
													}
											
												///////////////////////////////////ambito de seguridad permisivo/////////////////////////////////////
                                                elseif( $ambito_seguridad_operativo == 'permisivo' )
                                                    {
                                                        /////////////////////declarando especificidad_cliente de la gestion/////////////////////////////
                                                         
                                			            $especificidad_cliente = null ;
													    if ( isset( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual] ) && empty( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual] ) )
                                                            {
                                                                return null ;
                                                            }
                                                        if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual] ) )
                                        				    {
                                        					    if ( empty( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'] ) )
                                                                    {
                                                                       return null ; 
                                                                    }
																$especificidad_cliente = $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente']; 
                                                                //aqui debajo se podria tener en cuenta tambien si existiera un modulo actual y no existieran sus datos en el arreglo, dandole entonces los de la aplicacion actual,pero estaria violando un poco la especificidad
                                    			                if ( ( ( $especificidad_cliente != 'aplicacion' ) && ( $especificidad_cliente != 'modulo' ) ) || ( ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) ) )
                                            			            {
                                                			             $especificidad_cliente = 'aplicacion' ;
                                            			            }
                                            				}
										                 else
										                 	{
										                 		return 'ejecucion' ;
										                 	}
                                                        //////////////////////gestionando permiso a ejecucion /////////////////////////////////////////////////////////////////////////
                                                
													    if ( $especificidad_cliente == 'aplicacion' )
															{
																return null ;
                                                            }
														elseif ( $especificidad_cliente == 'modulo' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['modulos'] ) && is_array( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['modulos'] ) )
																	{
																		foreach( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['modulos'] as $appmod_cliente )
																			{
																				if ( $appmod_cliente == $id_modulo_actual )
																					{
																						return null ;	
																					}
																			}
																	}
																return null ;
                                                            }
														return 'ejecucion' ;
													}
											}
                                        
                                        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                        
                                        //////////////////////gestionando accesos a nivel de modulo servidor/////////////////////////////////////////
                                      
                                        elseif ( $especificidad_servidor == 'modulo' )
											{
											    ////////////////////////declarando ambito de seguridad en modulo servidor/////////////////////////////////
												if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['permiso_ejecucion']['ambito'] ) && ( ( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['permiso_ejecucion']['ambito'] == 'restrictivo' ) || ( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['permiso_ejecucion']['ambito'] == 'permisivo' ) ) )
													{
														$ambito_seguridad_operativo = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['permiso_ejecucion']['ambito'] ; 
													}
												else
													{
														$ambito_seguridad_operativo = $this->ambito_seguridad ;
													}
												
												///////////////////////////////////ambito de seguridad restrictivo/////////////////////////////////////
                                                if ( $ambito_seguridad_operativo == 'restrictivo' )
													{
														/////////////////////declarando especificidad_cliente de la gestion/////////////////////////////
                                        
                                			            $especificidad_cliente = null ;
													    if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'] ) )
                                        				    {
                                        					   $especificidad_cliente = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'];
                                    				           //aqui debajo se podria tener en cuenta tambien si existiera un modulo actual y no existieran sus datos en el arreglo, dandole entonces los de la aplicacion actual,pero estaria violando un poco la especificidad
                                   			                   if ( ( ( $especificidad_cliente != 'aplicacion' ) && ( $especificidad_cliente != 'modulo' ) ) || ( ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) ) )
                                            			            {
                                                			            $especificidad_cliente = 'aplicacion' ;
                                            			            }
                                						    }
										                 else
										                 	{
										                 		return null ;
										                 	}
																																						                 
                                                        ///////////////////////////////////////////////////////////////////////////////////////////////
                                                
                                                        /////////////////////gestionando permiso a ejecucion/////////////////////////////
														
														if ( $especificidad_cliente == 'aplicacion' )
															{
																return 'ejecucion' ;
                                                            }
														elseif ( $especificidad_cliente == 'modulo' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['modulos'] ) && is_array( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['modulos'] ) )
																	{
																		foreach( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['modulos'] as $appmod_cliente )
																			{
																				if ( $appmod_cliente == $id_modulo_actual )
																					{
																						return 'ejecucion' ;	
																					}
																			}
																	}
																return null ;
                                                            }
                                                    }
												///////////////////////////////////ambito de seguridad permisivo/////////////////////////////////////
                                                elseif( $ambito_seguridad_operativo == 'permisivo' )
													{
														/////////////////////declarando especificidad_cliente de la gestion/////////////////////////////
                                        
                                			            $especificidad_cliente = null ;
													    if ( isset( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual] ) && empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual] ) )
                                                            {
                                                                return null ;
                                                            }
                                                        if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual] ) )
                                        				    {
                                        					    if ( empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'] ) )
                                                                    {
                                                                       return null ; 
                                                                    }
																$especificidad_cliente = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente']; 
                                                                //aqui debajo se podria tener en cuenta tambien si existiera un modulo actual y no existieran sus datos en el arreglo, dandole entonces los de la aplicacion actual,pero estaria violando un poco la especificidad
                                    			                if ( ( ( $especificidad_cliente != 'aplicacion' ) && ( $especificidad_cliente != 'modulo' ) ) || ( ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) ) )
                                            			            {
                                                			             $especificidad_cliente = 'aplicacion' ;
                                            			            }
                                            				}
										                 else
										                 	{
										                 		return 'ejecucion' ;
										                 	}
														
																								                 
                                                        //////////////////////gestionando permiso a ejecucion /////////////////////////////////////////////////////////////////////////
                                                
													    if ( $especificidad_cliente == 'aplicacion' )
															{
																return null ;
                                                            }
														elseif ( $especificidad_cliente == 'modulo' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['modulos'] ) && is_array( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['modulos'] ) )
																	{
																		foreach( $this->datos_seguridad_appmod[$id_aplicacion]['permiso_ejecucion']['aplicaciones'][$id_aplicacion_actual]['modulos'] as $appmod_cliente )
																			{
																				if ( $appmod_cliente == $id_modulo_actual )
																					{
																						return null ;	
																					}
																			}
																	}
																return null ;
                                                            }
														return 'ejecucion' ;
													}
											}
                                    }
								return null ;
							}
*/                
                //este procedimiento gestiona si un proceso aplicacion id_aplicacion o modulo id_modulo (ejecutandose , actual) tiene permiso a leer, escribir o eliminar los datos de otro proceso aplicacion o modulo, estos datos son los que se econtrar�n en el espacio que para ello brinda el objeto que implementa la clase corespondiente al parametro $estructura en la estructura de este arreglo   
				//este procedimiento se corresponde con la estructura $estructura de las aplicaciones y/o modulos en la propiedad datos_seguridad_appmod de esta clase 
				//$id_aplicacion es el identificador del proceso aplicacion al que se quiere chequear si el proceso aplicacion o modulo actual (en ejecucion) puede acceder sus datos, si el valor de este parametro es vacio el procedimiento retorna el valor null
				//$id_modulo es el identificador del proceso modulo al que se quiere chequear si el proceso aplicacion o modulo actual (en ejecucion) puede acceder sus datos, por defecto este par�metro tiene el valor '' (string vacio), el trabajo con este parametro depende del elemento especificidad_servidor que forma parte de la propiedad $datos_seguridad_appmod de esta misma clase, para complementar esta aayuda debe verse la ayuda de la propiedad $datos_seguridad_appmod de esta misma clase.
				//si el proceso actual(ejecutandose) es cliente de leer, escribir o eliminar los datos del proceso al que se chequea, este procedimiento debuelve la cadena con el acceso cocedido, esta cadena tendra la estructura 'leer::escribir::eliminar' en correspondencia con el aceso permitido. 
				//este procedimiento retorna null si es insatisfactorio o si el proceso actual no tiene permiso de acceder a los datos del proceso analizado . 
				  
				//si ambito_seguridad_operativo == 'restrictivo' y y el valor de [$id_aplicacion_actual]['especificidad_cliente'] es vacio el procedimiento retornara null', si tiene un valor pero es diferente de aplicacion o modulo entonses se le asigna automaticamente el valor de aplicacion, si ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) se le asigna automaticamente el valor de aplicacion a $especificidad_cliente 
				//si $ambito_seguridad_operativo == 'permisivo' && isset ['aplicaciones'][$id_aplicacion_actual]&& empty ['aplicaciones'][$id_aplicacion_actual] el procedimiento retornara null            
                //si en la propiedad 'especificidad_servidor' de esta estructura de datos se encuentra el valor aplicacion pero se introduce un $id_modulo en este procedimiento que existe en la estructura de datos, el procedimiento trabajara con el modulo existente, convirtiendo el valor de 'especificidad_servidor' a modulo 
/*                private function cliente_acceso_appmod( $id_aplicacion , $id_modulo = '' , $estructura = 'acceso_datos' )
							{
								if ( !empty( $id_aplicacion ) && !empty( $this->EEoNucleo ) && ( $this->existencia_id_appmod( $id_aplicacion ) == 'aplicacion' ) )  
									{
										$id_aplicacion_actual = $this->EEoNucleo->aplicacion_ejecucion();
                                        $id_modulo_actual = $this->EEoNucleo->modulo_ejecucion();
                                        $aplicacion_ejecutandose = false ;
                                        $modulo_ejecutandose = false ; 
                                        //////////////////////gestionando ejecucion a nivel de aplicacion servidor//////////////////////
                                        
                                        /////////////////////declarando especificidad_servidor de la gestion/////////////////////////////
                                        
                                        $especificidad_servidor = null ;
										if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['propiedades']['especificidad_servidor'] ) )
                                        	{
                                        		$especificidad_servidor = $this->datos_seguridad_appmod[$id_aplicacion]['propiedades']['especificidad_servidor'];
                                        	}
										
                                        if ( ( $id_aplicacion == $id_aplicacion_actual ) && empty( $id_modulo ) )
                                            {
                                                $aplicacion_ejecutandose = true ;
                                            }
                                        if ( ( ( $especificidad_servidor != 'aplicacion' ) && ( $especificidad_servidor != 'modulo' ) ) || ( $aplicacion_ejecutandose && ( $especificidad_servidor == 'modulo' ) ) )
                                            {
                                                $especificidad_servidor = 'aplicacion' ;
                                            }
                                                                                    
                                        ///////////////////////////////////////////////////////////////////////////////////////////////
										
                                        ////////////////////////////existencia de espacio modulo////////////////////////
                                        
                                        if ( !empty( $id_modulo ) )
                                            {
                                                if ( $this->existencia_id_appmod( $id_aplicacion , $id_modulo ) == 'modulo' )
                                                    {
                                                        $especificidad_servidor = 'modulo' ;
                                                    }   
                                                else
                                                    {
                                                        return null ; 
                                                    }   
                                            }
                                        elseif ( $especificidad_servidor == 'modulo' )
                                            {
                                                return null ;
                                            }
                                        
                                        ///////fin existencia de espacio modulo y continuacion de gestion de ejecucion a nivel de aplicacion//////////////////////////////////////////////////////////////////////////
										                                        
                                        if ( $especificidad_servidor == 'aplicacion' )
											{
												///////////////////////declarando ambito de seguridad en aplicacion servidor/////////////////////////////////
												if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['ambito'] ) && ( ( $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['ambito'] == 'restrictivo' ) || ( $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['ambito'] == 'permisivo' ) ) )
													{
														$ambito_seguridad_operativo = $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['ambito'] ; 
													}
												else
													{
														$ambito_seguridad_operativo = $this->ambito_seguridad ;
													}
												
                                                
                                                ///////////////////////////////////ambito de seguridad restrictivo/////////////////////////////////////
												if ( $ambito_seguridad_operativo == 'restrictivo' )
													{
														/////////////////////declarando especificidad_cliente de la gestion/////////////////////////////
                                        
                                			            $especificidad_cliente = null ;
													    if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'] ) )
                                        				    {
                                        					   $especificidad_cliente = $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'];
                                    				           //aqui debajo se podria tener en cuenta tambien si existiera un modulo actual y no existieran sus datos en el arreglo, dandole entonces los de la aplicacion actual,pero estaria violando un poco la especificidad
                                   			                   if ( ( ( $especificidad_cliente != 'aplicacion' ) && ( $especificidad_cliente != 'modulo' ) ) || ( ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) ) )
                                            			            {
                                                			            $especificidad_cliente = 'aplicacion' ;
                                            			            }
                                						    }
										                 else
										                 	{
										                 		return null ;
										                 	}
                                                        /////////////////////gestionando permiso a ejecucion/////////////////////////////
														
														if ( $especificidad_cliente == 'aplicacion' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['aplicaciones'][$id_aplicacion_actual]['acceso'] ) )
													               {
														              return $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['aplicaciones'][$id_aplicacion_actual]['acceso'] ;
													               }
                                                            }
														elseif ( $especificidad_cliente == 'modulo' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ) )
													               {
														              return $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ;
													               }
                                                            }
													}
											
												///////////////////////////////////ambito de seguridad permisivo/////////////////////////////////////
                                                elseif( $ambito_seguridad_operativo == 'permisivo' )
                                                    {
                                                        /////////////////////declarando especificidad_cliente de la gestion/////////////////////////////
                                                         
                                			            $especificidad_cliente = null ;
													    if ( isset( $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['aplicaciones'][$id_aplicacion_actual] ) && empty( $this->datos_seguridad_appmod[$id_aplicacion]['acceso_datos']['aplicaciones'][$id_aplicacion_actual] ) )
                                                            {
                                                                return null ;
                                                            }
                                                        if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['aplicaciones'][$id_aplicacion_actual] ) )
                                        				    {
                                        					    if ( empty( $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'] ) )
                                                                    {
                                                                       return null ; 
                                                                    }
																$especificidad_cliente = $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente']; 
                                                                //aqui debajo se podria tener en cuenta tambien si existiera un modulo actual y no existieran sus datos en el arreglo, dandole entonces los de la aplicacion actual,pero estaria violando un poco la especificidad
                                    			                if ( ( ( $especificidad_cliente != 'aplicacion' ) && ( $especificidad_cliente != 'modulo' ) ) || ( ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) ) )
                                            			            {
                                                			             $especificidad_cliente = 'aplicacion' ;
                                            			            }
                                            				}
										                 else
										                 	{
										                 		return 'leer::escribir::eliminar' ;
										                 	}
                                                        //////////////////////gestionando permiso a ejecucion /////////////////////////////////////////////////////////////////////////
                                                
													    if ( $especificidad_cliente == 'aplicacion' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['aplicaciones'][$id_aplicacion_actual]['acceso'] ) )
													               {
														              $tipo_acceso = $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['aplicaciones'][$id_aplicacion_actual]['acceso'] ;	
																	
														              $acceso_leer = 'leer' ;
														              $acceso_escribir = 'escribir' ;
														              $acceso_eliminar = 'eliminar' ;
																
														              if ( is_string( $tipo_acceso ) )
															             {
																                $arreglo_acceso = explode( '::' , $tipo_acceso ) ;
																                foreach ( $arreglo_acceso as $elemento)
																	               {
																		              switch ( $elemento )
																			             {
																				                case 'leer'     : $acceso_leer = null ;
																							                      break ; 
																				                case 'escribir' : $acceso_escribir = null ;
																							                      break ;
																				                case 'eliminar' : $acceso_eliminar = null ;
																							                      break ;			  	
																			             }
																	               } 
															             }
														              if ( !empty( $acceso_leer ) && ( !empty( $acceso_escribir ) || !empty( $acceso_eliminar ) ) )
															             {
																                $acceso_leer.='::' ;
															             }
														              if ( !empty( $acceso_escribir ) &&  !empty( $acceso_eliminar ) )
															             {
																                $acceso_escribir.='::' ;
															             }
														              $tipo_acceso = $acceso_leer.$acceso_escribir.$acceso_eliminar ;
                                                                      if ( !empty($tipo_acceso))
                                                                          {
                                                                                return $tipo_acceso ;
                                                                          }	
													               }
                                                                
                                                            }
														elseif ( $especificidad_cliente == 'modulo' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ) ) 
																	{
																	   $tipo_acceso = $this->datos_seguridad_appmod[$id_aplicacion][$estructura]['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ;	
																	
														               $acceso_leer = 'leer' ;
														               $acceso_escribir = 'escribir' ;
														               $acceso_eliminar = 'eliminar' ;
																
														               if ( is_string( $tipo_acceso ) )
															              {
																                $arreglo_acceso = explode( '::' , $tipo_acceso ) ;
																                foreach ( $arreglo_acceso as $elemento)
																	               {
																		              switch ( $elemento )
																			             {
																				                case 'leer'     : $acceso_leer = null ;
																							                      break ; 
																				                case 'escribir' : $acceso_escribir = null ;
																							                      break ;
																				                case 'eliminar' : $acceso_eliminar = null ;
																							                      break ;			  	
																			             }
																	               } 
															              }
														               if ( !empty( $acceso_leer ) && ( !empty( $acceso_escribir ) || !empty( $acceso_eliminar ) ) )
															              {
																                $acceso_leer.='::' ;
															              }
														               if ( !empty( $acceso_escribir ) &&  !empty( $acceso_eliminar ) )
															              {
																                $acceso_escribir.='::' ;
															              }
														               $tipo_acceso = $acceso_leer.$acceso_escribir.$acceso_eliminar ;
                                                                       if ( !empty($tipo_acceso))
                                                                          {
                                                                                return $tipo_acceso ;
                                                                          }		
																	}
															}
													}
											}
                                        
                                        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                                        
                                        //////////////////////gestionando accesos a nivel de modulo servidor/////////////////////////////////////////
                                      
                                        elseif ( $especificidad_servidor == 'modulo' )
											{
											    ////////////////////////declarando ambito de seguridad en modulo servidor/////////////////////////////////
												if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['ambito'] ) && ( ( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['ambito'] == 'restrictivo' ) || ( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['ambito'] == 'permisivo' ) ) )
													{
														$ambito_seguridad_operativo = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['ambito'] ; 
													}
												else
													{
														$ambito_seguridad_operativo = $this->ambito_seguridad ;
													}
												
												///////////////////////////////////ambito de seguridad restrictivo/////////////////////////////////////
                                                if ( $ambito_seguridad_operativo == 'restrictivo' )
													{
														/////////////////////declarando especificidad_cliente de la gestion/////////////////////////////
                                        
                                			            $especificidad_cliente = null ;
													    if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'] ) )
                                        				    {
                                        					   $especificidad_cliente = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'];
                                    				           //aqui debajo se podria tener en cuenta tambien si existiera un modulo actual y no existieran sus datos en el arreglo, dandole entonces los de la aplicacion actual,pero estaria violando un poco la especificidad
                                   			                   if ( ( ( $especificidad_cliente != 'aplicacion' ) && ( $especificidad_cliente != 'modulo' ) ) || ( ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) ) )
                                            			            {
                                                			            $especificidad_cliente = 'aplicacion' ;
                                            			            }
                                						    }
										                 else
										                 	{
										                 		return null ;
										                 	}
																																						                 
                                                        ///////////////////////////////////////////////////////////////////////////////////////////////
                                                
                                                        /////////////////////gestionando permiso a ejecucion/////////////////////////////
														
														if ( $especificidad_cliente == 'aplicacion' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['aplicaciones'][$id_aplicacion_actual]['acceso'] ) )
													               {
														              return $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['aplicaciones'][$id_aplicacion_actual]['acceso'] ;
													               }
                                                            }
														elseif ( $especificidad_cliente == 'modulo' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ) )
													               {
														              return $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ;
													               }
                                                            }
                                                    }
												///////////////////////////////////ambito de seguridad permisivo/////////////////////////////////////
                                                elseif( $ambito_seguridad_operativo == 'permisivo' )
													{
														/////////////////////declarando especificidad_cliente de la gestion/////////////////////////////
                                        
                                			            $especificidad_cliente = null ;
													    if ( isset( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['aplicaciones'][$id_aplicacion_actual] ) && empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['aplicaciones'][$id_aplicacion_actual] ) )
                                                            {
                                                                return null ;
                                                            }
                                                        if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['aplicaciones'][$id_aplicacion_actual] ) )
                                        				    {
                                        					    if ( empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente'] ) )
                                                                    {
                                                                       return null ; 
                                                                    }
																$especificidad_cliente = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['aplicaciones'][$id_aplicacion_actual]['especificidad_cliente']; 
                                                                //aqui debajo se podria tener en cuenta tambien si existiera un modulo actual y no existieran sus datos en el arreglo, dandole entonces los de la aplicacion actual,pero estaria violando un poco la especificidad
                                    			                if ( ( ( $especificidad_cliente != 'aplicacion' ) && ( $especificidad_cliente != 'modulo' ) ) || ( ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) ) )
                                            			            {
                                                			             $especificidad_cliente = 'aplicacion' ;
                                            			            }
                                            				}
										                 else
										                 	{
										                 		return 'leer::escribir::eliminar' ;
										                 	}
														
																								                 
                                                        //////////////////////gestionando permiso a ejecucion /////////////////////////////////////////////////////////////////////////
                                                
													    if ( $especificidad_cliente == 'aplicacion' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['aplicaciones'][$id_aplicacion_actual]['acceso'] ) )
													               {
														              $tipo_acceso = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['aplicaciones'][$id_aplicacion_actual]['acceso'] ;	
																	
														              $acceso_leer = 'leer' ;
														              $acceso_escribir = 'escribir' ;
														              $acceso_eliminar = 'eliminar' ;
																
														              if ( is_string( $tipo_acceso ) )
															             {
																                $arreglo_acceso = explode( '::' , $tipo_acceso ) ;
																                foreach ( $arreglo_acceso as $elemento)
																	               {
																		              switch ( $elemento )
																			             {
																				                case 'leer'     : $acceso_leer = null ;
																							                      break ; 
																				                case 'escribir' : $acceso_escribir = null ;
																							                      break ;
																				                case 'eliminar' : $acceso_eliminar = null ;
																							                      break ;			  	
																			             }
																	               } 
															             }
														              if ( !empty( $acceso_leer ) && ( !empty( $acceso_escribir ) || !empty( $acceso_eliminar ) ) )
															             {
																                $acceso_leer.='::' ;
															             }
														              if ( !empty( $acceso_escribir ) &&  !empty( $acceso_eliminar ) )
															             {
																                $acceso_escribir.='::' ;
															             }
														              $tipo_acceso = $acceso_leer.$acceso_escribir.$acceso_eliminar ;
														              if ( !empty($tipo_acceso))
                                                                          {
                                                                                return $tipo_acceso ;
                                                                          }	
													               }
                                                            }
														elseif ( $especificidad_cliente == 'modulo' )
															{
																if ( !empty( $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ) ) 
																	{
																	   $tipo_acceso = $this->datos_seguridad_appmod[$id_aplicacion]['modulos'][$id_modulo][$estructura]['aplicaciones'][$id_aplicacion_actual]['modulos'][$id_modulo_actual]['acceso'] ;	
																	
														               $acceso_leer = 'leer' ;
														               $acceso_escribir = 'escribir' ;
														               $acceso_eliminar = 'eliminar' ;
																
														               if ( is_string( $tipo_acceso ) )
															              {
																                $arreglo_acceso = explode( '::' , $tipo_acceso ) ;
																                foreach ( $arreglo_acceso as $elemento)
																	               {
																		              switch ( $elemento )
																			             {
																				                case 'leer'     : $acceso_leer = null ;
																							                      break ; 
																				                case 'escribir' : $acceso_escribir = null ;
																							                      break ;
																				                case 'eliminar' : $acceso_eliminar = null ;
																							                      break ;			  	
																			             }
																	               } 
															              }
														               if ( !empty( $acceso_leer ) && ( !empty( $acceso_escribir ) || !empty( $acceso_eliminar ) ) )
															              {
																                $acceso_leer.='::' ;
															              }
														               if ( !empty( $acceso_escribir ) &&  !empty( $acceso_eliminar ) )
															              {
																                $acceso_escribir.='::' ;
															              }
														               $tipo_acceso = $acceso_leer.$acceso_escribir.$acceso_eliminar ;
														               if ( !empty($tipo_acceso))
                                                                          {
                                                                                return $tipo_acceso ;
                                                                          }	
																	}
                                                            }
													}
											}
                                    }
								return null ;
							}
*/                            
                //este procedimiento gestiona si un proceso aplicacion id_aplicacion o modulo id_modulo (ejecutandose , actual) tiene permiso a leer, escribir o eliminar los datos de otro proceso aplicacion o modulo, estos datos son los que se econtrar�n en el espacio que para ello brinda el objeto que implementa la clase DatosProcesos, para mas informaci�n al respecto ver clase DatosProcesos   
				//este procedimiento se corresponde con la estructura 'acceso_datos' de las aplicaciones y/o modulos en la propiedad datos_seguridad_appmod de esta clase 
				//$id_aplicacion es el identificador del proceso aplicacion al que se quiere chequear si el proceso aplicacion o modulo actual (en ejecucion) puede acceder sus datos, si el valor de este parametro es vacio el procedimiento retorna el valor null
				//$id_modulo es el identificador del proceso modulo al que se quiere chequear si el proceso aplicacion o modulo actual (en ejecucion) puede acceder sus datos, por defecto este par�metro tiene el valor '' (string vacio), el trabajo con este parametro depende del elemento especificidad_servidor que forma parte de la propiedad $datos_seguridad_appmod de esta misma clase, para complementar esta aayuda debe verse la ayuda de la propiedad $datos_seguridad_appmod de esta misma clase.
				//si el proceso actual(ejecutandose) es cliente de leer, escribir o eliminar los datos del proceso al que se chequea, este procedimiento debuelve la cadena con el acceso cocedido, esta cadena tendra la estructura 'leer::escribir::eliminar' en correspondencia con el aceso permitido. 
				//este procedimiento retorna null si es insatisfactorio o si el proceso actual no tiene permiso de acceder a los datos del proceso analizado . 
				  
				//si ambito_seguridad_operativo == 'restrictivo' y y el valor de [$id_aplicacion_actual]['especificidad_cliente'] es vacio el procedimiento retornara null', si tiene un valor pero es diferente de aplicacion o modulo entonses se le asigna automaticamente el valor de aplicacion, si ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) se le asigna automaticamente el valor de aplicacion a $especificidad_cliente 
				//si $ambito_seguridad_operativo == 'permisivo' && isset ['aplicaciones'][$id_aplicacion_actual]&& empty ['aplicaciones'][$id_aplicacion_actual] el procedimiento retornara null            
                //si en la propiedad 'especificidad_servidor' de esta estructura de datos se encuentra el valor aplicacion pero se introduce un $id_modulo en este procedimiento que existe en la estructura de datos, el procedimiento trabajara con el modulo existente, convirtiendo el valor de 'especificidad_servidor' a modulo 
/*                public function cliente_acceso_datos_appmod( $id_aplicacion , $id_modulo = '' )
                            {
                                return $this->cliente_acceso_appmod( $id_aplicacion , $id_modulo );
                            }
*/                    
				//este procedimiento gestiona si un proceso aplicacion id_aplicacion o modulo id_modulo (ejecutandose , actual) tiene permiso a leer, escribir o eliminar los datos de configuracion de otro proceso aplicacion o modulo, estos datos son los que se econtrar�n en el espacio que para ello brinda el objeto que implementa la clase Configuracion_gestor, para mas informaci�n al respecto ver clase Configuracion_gestor   
				//este procedimiento se corresponde con la estructura 'acceso_configuracion' de las aplicaciones y/o modulos en la propiedad datos_seguridad_appmod de esta clase 
				//$id_aplicacion es el identificador del proceso aplicacion al que se quiere chequear si el proceso aplicacion o modulo actual (en ejecucion) puede acceder sus datos de configuracion, si el valor de este parametro es vacio el procedimiento retorna el valor null
				//$id_modulo es el identificador del proceso modulo al que se quiere chequear si el proceso aplicacion o modulo actual (en ejecucion) puede acceder sus datos de configuracion, por defecto este par�metro tiene el valor '' (string vacio), el trabajo con este parametro depende del elemento especificidad_servidor que forma parte de la propiedad $datos_seguridad_appmod de esta misma clase, para complementar esta aayuda debe verse la ayuda de la propiedad $datos_seguridad_appmod de esta misma clase.
				//si el proceso actual(ejecutandose) es cliente de leer, escribir o eliminar los datos del proceso al que se chequea, este procedimiento debuelve la cadena con el acceso cocedido, esta cadena tendra la estructura 'leer::escribir::eliminar' en correspondencia con el aceso permitido. 
				//este procedimiento retorna null si es insatisfactorio o si el proceso actual no tiene permiso de acceder a los datos del proceso analizado . 
				  
				//si ambito_seguridad_operativo == 'restrictivo' y y el valor de [$id_aplicacion_actual]['especificidad_cliente'] es vacio el procedimiento retornara null', si tiene un valor pero es diferente de aplicacion o modulo entonses se le asigna automaticamente el valor de aplicacion, si ( $especificidad_cliente == 'modulo' ) && empty( $id_modulo_actual ) se le asigna automaticamente el valor de aplicacion a $especificidad_cliente 
				//si $ambito_seguridad_operativo == 'permisivo' && isset ['aplicaciones'][$id_aplicacion_actual]&& empty ['aplicaciones'][$id_aplicacion_actual] el procedimiento retornara null            
                //si en la propiedad 'especificidad_servidor' de esta estructura de datos se encuentra el valor aplicacion pero se introduce un $id_modulo en este procedimiento que existe en la estructura de datos, el procedimiento trabajara con el modulo existente, convirtiendo el valor de 'especificidad_servidor' a modulo 
/*                public function cliente_acceso_configuracion_appmod( $id_aplicacion , $id_modulo = '' )
                            {
                                return $this->cliente_acceso_appmod( $id_aplicacion , $id_modulo , 'acceso_configuracion' );
                            }		
*/                    		
				/////////////////SECCION SIMPLIFICACION DEL ACCESO A LOS PROCEDIMIENTOS DE ESTA CLASE
                
                
                //esta funcion diferencia el trabajo entre los procesos comunes y los appmod
/*                public function existenciaIdProceso( $id_proceso = 'hereda' , $id_modulo = '' )
                            {
                                if ( !empty( $this->EEoNucleo ) && is_object( $this->EEoNucleo ) )
                                    {
                                        $tipo_proceso = $this->EEoNucleo->gedeeProcesoEjecucion() ;
                                        
                                        switch ( $tipo_proceso )
                                            {
                                                case 'comun' :  return $this->existencia_id_proceso_comun( $id_proceso ) ;
                                                                
                                            
                                                case 'aplicacion' : 
                                                case 'modulo' : return $this->existencia_id_appmod( $id_proceso , $id_modulo ) ;
                                                                
                                            }
                                    }
                                return null ;
                            }
*/              
				//esta funcion diferencia el trabajo entre los procesos comunes y los appmod            
/*                public function iniciarDatosSeguridadProceso( $datos_seguridad )
                            {
                                if ( !empty( $this->EEoNucleo ) && is_object( $this->EEoNucleo ) )
                                    {
                                        $tipo_proceso = $this->EEoNucleo->gedeeProcesoEjecucion() ;
                                        
                                        switch ( $tipo_proceso )
                                            {
                                                case 'comun' :  return $this->iniciarDatosSeguridadProceso_comun( $datos_seguridad ) ;
                                                                
                                            
                                                case 'aplicacion' : 
                                                case 'modulo' : return $this->inicializar_datoseguridad_appmod( $datos_seguridad ) ;
                                                                
                                            }
                                    }
                                return null ;
                            }
*/                
				//esta funcion diferencia el trabajo entre los procesos comunes y los appmod            
/*                public function accederDatosSeguridadProceso( $id_proceso = 'hereda' , $id_modulo = '' , $estructura_acceder = array() , $tipo_accion = 1 , $condicion_modificacion = 0 )
                            {
                                if ( !empty( $this->EEoNucleo ) && is_object( $this->EEoNucleo ) )
                                    {
                                        $tipo_proceso = $this->EEoNucleo->gedeeProcesoEjecucion() ;
                                        
                                        switch ( $tipo_proceso )
                                            {
                                                case 'comun' :  return $this->accederDatosSeguridadProceso_comun( $id_proceso , $estructura_acceder , $tipo_accion , $condicion_modificacion ) ;
                                                                
                                            
                                                case 'aplicacion' : 
                                                case 'modulo' : return $this->acceder_datoseguridad_appmod( $id_proceso ,$id_modulo , $estructura_acceder , $tipo_accion , $condicion_modificacion ) ;
                                                                
                                            }
                                    }
                                return null ;
                            }
*/                
				//esta funcion diferencia el trabajo entre los procesos comunes y los appmod            
/*                public function clienteEjecucionProceso( $id_proceso , $tipo_proceso = null )
                            {
                                if ( !empty( $this->EEoNucleo ) && is_object( $this->EEoNucleo ) )
                                    {
                                        
                                       
                                        if ( empty( $tipo_proceso ) )
                                        	{
                                        		$tipo_proceso = $this->EEoNucleo->gedeeProcesoEjecucion() ;
                                        	}
										
										if ( $tipo_proceso == 'aplicacion' )
											{
												$id_aplicacion = $id_proceso ;	
												$id_modulo = '' ;
          									}
										elseif ( $tipo_proceso == 'modulo' )
											{
												$id_aplicacion = $this->EEoNucleo->aplicacion_ejecucion();	
												$id_modulo = $id_proceso ;
          									}
   										 echo "ppppppp $id_proceso > $tipo_proceso pppppppp";
          		///////////////////////chequear si es obligatorio trabajar con aplicacion modulos	
   										switch ( $tipo_proceso )
                                         	{
                                                case 'comun' :  return $this->clienteEjecucionProceso_comun( $id_proceso ) ;
                                                                
                                            	case 'aplicacion' : 
                                                case 'modulo' : return $this->cliente_ejecucion_appmod( $id_aplicacion , $id_modulo ) ;
                                                                
                                            }
                                    }
                                return null ;
                            }
                //esta funcion diferencia el trabajo entre los procesos comunes y los appmod            
                public function clienteAccesoDatosProceso( $id_proceso , $id_modulo = '' )
                            {
                                if ( !empty( $this->EEoNucleo ) && is_object( $this->EEoNucleo ) )
                                    {
                                        $tipo_proceso = $this->EEoNucleo->gedeeProcesoEjecucion() ;
                                        
                                        switch ( $tipo_proceso )
                                            {
                                                case 'comun' :  return $this->clienteAccesoDatosProceso_comun( $id_proceso ) ;
                                                                
                                            
                                                case 'aplicacion' : 
                                                case 'modulo' : return $this->cliente_acceso_datos_appmod( $id_proceso , $id_modulo ) ;
                                                                
                                            }
                                    }
                                return null ;
                            }
*/                
				//esta funcion diferencia el trabajo entre los procesos comunes y los appmod            
/*                public function clienteAccesoConfiguracionProceso( $id_proceso , $id_modulo = '' )
                            {
                                if ( !empty( $this->EEoNucleo ) && is_object( $this->EEoNucleo ) )
                                    {
                                        $tipo_proceso = $this->EEoNucleo->gedeeProcesoEjecucion() ;
                                        
                                        switch ( $tipo_proceso )
                                            {
                                                case 'comun' :  return $this->clienteAccesoConfiguracionProceso_comun( $id_proceso ) ;
                                                                
                                            
                                                case 'aplicacion' : 
                                                case 'modulo' : return $this->cliente_acceso_configuracion_appmod( $id_proceso , $id_modulo ) ;
                                                                
                                            }
                                    }
                                return null ;
                            }
*/                            
                //en versiones futuras ver si vale la pena o es obligatorio cambiar el uso que se le da en algunos procedimientos de esta clase a $this->EEoNucleo->aplicacion_ejecucion() y $this->EEoNucleo->modulo_ejecucion()por $this->EEoNucleo->gedeeProcesoEjecucion(), debido a que este ultimo no existia cuando se comenzo la programacion de esta clase                                                                                                             		
			}	
?>		