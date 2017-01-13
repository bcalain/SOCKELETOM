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
   * e_interfaz_datos_txt_mono_string1 script
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/bcalain/SOCKELETOM
   * @copyright Copyright 2017 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

//Interfaz para datos txt

//esta interfaz buscara en ficheros txt pares llave:valor, separados por el caracter definido en la variable correspondiente
//para una correcta utilizacion de este script se debe consultar el procedimiento \Emod\Nucleo\Herramientas\EDatosFormatoTxt::filtrarLeerLineaDatos()
//para hacer un uso correcto de sus parametros
//como que este parser esta hecho para el trabajo con la entidad EEoInterfazDatos, es coveniente que los parametros del procedimiento mencionado anteriormente
//se pasen en el parametro $La_datos_complementarios del procedimiento EEoInterfazDatos->gestionEjecucionInterfazSalida(), con exepcion de $Ls_path_fich que tomaria el valor de $Ls_pathfinal_datos
//que se hereda de la entidad EEoInterfazDatos en el include que hace de este fichero parser
//si la gestion es acertada retornara un string, este strin es la llave, en el par llave:valor resultado condicionado por los parametros utilizados, de lo contrario retornara NULL . 
//esta interfaz necesita la variable de nombre $Ls_pathfinal_datos que se hereda de la entidad EEoInterfazDatos en el include que hace de este fichero parser, y como valor el path o camino del fichero txt que se debe parsear  

	$La_datos_result = NULL;
      
	include_once ( $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/nucleo/nucleo_bib_funciones/herramientas/class_eh_datfortxt.php' ) ;
	  
	$La_datos_result = \Emod\Nucleo\Herramientas\EDatosFormatoTxt::filtrarLeerLineaDatos( $La_datos_complementarios['La_estructura_llaves_base'] , $La_datos_complementarios['La_estructura_filtro'] , $La_datos_complementarios['Ls_separador'] , $Ls_pathfinal_datos , $La_datos_complementarios['Ls_llave_unica'] , 'array' );
	 
	if( !empty( $La_datos_result[0] ) )
		{
			return $La_datos_result[0][0] ; 
		}
	else 
		{ 
			trigger_error('No se ha gestionado el string objeto de la gesti&oacute;n del parser e_interfaz_datos_txt_mono_string1 ', E_USER_WARNING );
		}	
	
	return NULL ;
	
?>