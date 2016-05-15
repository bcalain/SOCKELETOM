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
			}	
?>		