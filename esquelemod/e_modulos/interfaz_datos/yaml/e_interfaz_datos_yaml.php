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
   * e_interfaz_datos_yaml script
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

//Interfaz para datos YAML 
 
//necesita una variable de nombre $Ls_pathfinal_datos y como valor el path o camino del fichero yaml que se debe parsear  
//devuelve un arreglo con los datos del fichero parseado 
      //no se utiliza una referencia a spyc en Herramientas porque esta interfaz es utilizada en la gestion de configuracion del nucleo, momento en el que todavia no se a creado el gestor de herramientas 
	  include_once ( $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/nucleo/nucleo_bib_funciones/herramientas/spyc.php' ) ;
   	  return \Emod\Nucleo\Herramientas\Spyc::YAMLLoad( $Ls_pathfinal_datos );

?>