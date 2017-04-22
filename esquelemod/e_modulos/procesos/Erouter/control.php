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
 * Control Proceso ERouter
 * @version 0.0.1
 * @author Alain Borrell Castellanos <bcalain@gmail.com>
 * @link https://github.com/bcalain/SOCKELETOM
 * @copyright Copyright 2017 Alain Borrell Castellanos
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
 */

$La_fich_interfaz_config_proc_router['Ls_pathfich_interfaz'] = 'hereda' ;
$La_fich_interfaz_config_proc_router['Ls_path_base'] = 'hereda' ;
$La_fich_datos_config_proc_router['Ls_pathfich_datos'] = 'configuracion/configuracion.cnf' ;
$La_fich_datos_config_proc_router['Ls_path_base'] = 'e_dir_proceso_ejecucion' ;

$datos_configuracion_prouter = $this->EEoInterfazDatos->gestionEjecucionInterfazSalida( $this->EEoNucleo->idProcesoEjecucion() , $La_fich_interfaz_config_proc_router , $La_fich_datos_config_proc_router , 'statu_procesos' ) ;


if ( !empty( $datos_configuracion_prouter['datos_seguridad'] ) && !empty( $datos_configuracion_prouter['propiedades_objeto_router'] ) )
	{
		if( empty( $datos_configuracion_prouter['propiedades_objeto_router']['nombre_dominio_web'] ) && !empty( $nombre_dominio_web = $this->EEoNucleo->nombreDominioWeb() ) )
			{
				$datos_configuracion_prouter['propiedades_objeto_router']['nombre_dominio_web'] = $nombre_dominio_web ;
			}
		elseif( empty( $datos_configuracion_prouter['propiedades_objeto_router']['nombre_dominio_web'] ) )
			{
				trigger_error('El Nombre del Dominio WEb contiene un valor vac&iacute;o', E_USER_ERROR ) ;
			}

		$this->EEoConfiguracion->iniciarDatosConfiguracionProceso( $datos_configuracion_prouter ) ;
		$this->EEoSeguridad->iniciarDatosSeguridadProceso( $datos_configuracion_prouter['datos_seguridad'] ) ;
	}
else 
	{
		trigger_error('Los datos de configuraci&oacute;n del proceso Router contienen un valor vac&iacute;o', E_USER_ERROR ) ;
	}	
require_once 'router_bib_funciones/class_erouter.php';

if (\Emod\Nucleo\Herramientas::existenciaEntidad ( '\Emod\Nucleo\Herramientas' , 'ETratamientoMIME' , 'ETratamientoMIME' ))
	{
		\Emod\Nucleo\Herramientas::entidad ( '\Emod\Nucleo\Herramientas' , 'ETratamientoMIME' , 'ETratamientoMIME' );
	}

$Lo_erouter = new \Emod\Nucleo\Routers\ERouter( $datos_configuracion_prouter['propiedades_objeto_router'] ) ;
 
$La_datos_salida['ERouter'] = $Lo_erouter ; 
$this->EEoDatos->iniciarDatosSalidaProceso($La_datos_salida) ;

$Lo_erouter->router( $datos_configuracion_prouter['propiedades_objeto_router'] , $datos_configuracion_prouter['propiedades_objeto_router']['objetivo_gestion'] ) ;
	
?>