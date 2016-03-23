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
   * Control GedeeEComun script
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

	    $La_fich_interfaz_config_gedee_comun['Ls_pathfich_interfaz'] = 'hereda' ;
	    $La_fich_datos_config_gedee_comun['Ls_pathfich_datos'] = 'gedee_configuracion.cnf' ;
	    $La_fich_datos_config_gedee_comun['Ls_path_base'] = self::$EEoNucleo->pathDirEsquelemod().'/e_modulos/'.self::$lsPathDirRaizEntidades.'/'.'ecomun' ;
		
            $EEoInterfazDatos = \Emod\Nucleo\CropNucleo::referenciarObjeto('EEoInterfazDatos' , 'InterfazDatos' , 'Emod\Nucleo\Herramientas') ;
	        
            $datos_config = $EEoInterfazDatos->gestionEjecucionInterfazSalida( 'gedee' , $La_fich_interfaz_config_gedee_comun , $La_fich_datos_config_gedee_comun , 'adyacente' ) ;
		// en datos config no debe aparecer referencia_path_entidad ya que como este control incluye el fichero clase debe debolver solo el parametro path_entidad_clase ya con el valor del path absoluto    
		if ( is_file( self::$EEoNucleo->pathDirEsquelemod().'/e_modulos/'.self::$lsPathDirRaizEntidades.'/ecomun/gedee_bib_funciones/class_gedee_ecomun.php' ) )
        	{ 
            
            	require_once self::$EEoNucleo->pathDirEsquelemod().'/e_modulos/'.self::$lsPathDirRaizEntidades.'/ecomun/gedee_bib_funciones/class_gedee_ecomun.php';
            	Emod\Nucleo\Gedees\GedeeEComun::iniciarParametrosBase( 'GedeeEComun' );
            	//path_entidad_clase es obligatorio ponerlo aqui porque para el ingreso de la herramienta se chequea que exista el fichero en esta dierccion  
                $datos_config['path_entidad_clase'] = self::$EEoNucleo->pathDirEsquelemod().'/e_modulos/'.self::$lsPathDirRaizEntidades.'/ecomun/gedee_bib_funciones/class_gedee_ecomun.php' ; 
                
            	return $datos_config ;
           
        	}
		else
			{
				exit( '<p>ERROR FATAL, '.__FILE__.', no se encuentra el fichero clase responsable de manejar las estructuras de datos del gedee * ecomun * en los diferentes espacios entidades del nucleo esquelemod<p>' ) ;
			}		 
?>