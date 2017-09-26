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
   * nucleo_control script
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

        //seccion inclucion biliotecas de clases y funciones del nucleo
        
        require 'nucleo_bib_funciones/herramientas/class_epatron_multiton.php';
        require 'nucleo_bib_funciones/herramientas/class_ecro_permanente.php' ;
        require 'nucleo_bib_funciones/herramientas/class_ecro_variable.php' ;
        require 'nucleo_bib_funciones/herramientas/trait_egeco.php';
        
        require 'nucleo_bib_funciones/herramientas/class_herramienta_earreglo.php';
        require 'nucleo_bib_funciones/class_eherramientas.php';
        require 'nucleo_bib_funciones/class_eutiles.php' ;
        
        require 'nucleo_bib_funciones/class_ecrop_nucleo.php' ;
        require 'nucleo_bib_funciones/class_gedees.php' ;
        require 'nucleo_bib_funciones/trait_dependencias_entidades_emod.php';
        require 'nucleo_bib_funciones/trait_dependencias_estaticas_entidades_emod.php';
        require 'nucleo_bib_funciones/class_enucleo_entidad_base.php';
        require 'nucleo_bib_funciones/class_enucleo_control.php';
        require 'nucleo_bib_funciones/herramientas/class_einterfaz_datos.php' ;
        require 'nucleo_bib_funciones/class_econfiguracion_procesos.php' ;
        require 'nucleo_bib_funciones/class_eseguridad_procesos.php' ;
        require 'nucleo_bib_funciones/class_edatos_procesos.php' ;
        require 'nucleo_bib_funciones/class_eimplementacion_procesos.php' ;
        
        
        require 'nucleo_bib_funciones/class_e_errores.php';
        
        
    
    //seccion instanciacion de clases del nucleo
        
        $EEoNucleo = \Emod\Nucleo\NucleoControl::instanciar();
        $EEoInterfazDatos = \Emod\Nucleo\Herramientas\InterfazDatos::instanciar();
        $EEoConfiguracion = \Emod\Nucleo\ConfiguracionProcesos::instanciar();
        $EEoSeguridad = \Emod\Nucleo\SeguridadProcesos::instanciar();
        $EEoDatos = \Emod\Nucleo\DatosProcesos::instanciar();
        $EEoImplementacionProcesos = \Emod\Nucleo\ImplementacionProcesos::instanciar();
        
        
    //seccion actualizacion del contenedor de referencias permanentes a objetos del nucleo esquelemod
        
        \Emod\Nucleo\CropNucleo::ingresarNuevoObjeto ( 'EEoNucleo' , $EEoNucleo ) ;
        \Emod\Nucleo\CropNucleo::ingresarNuevoObjeto ( 'EEoInterfazDatos' , $EEoInterfazDatos ) ;
        \Emod\Nucleo\CropNucleo::ingresarNuevoObjeto ( 'EEoConfiguracion' , $EEoConfiguracion ) ;
        \Emod\Nucleo\CropNucleo::ingresarNuevoObjeto ( 'EEoSeguridad' , $EEoSeguridad ) ;
        \Emod\Nucleo\CropNucleo::ingresarNuevoObjeto ( 'EEoDatos' , $EEoDatos ) ;
        \Emod\Nucleo\CropNucleo::ingresarNuevoObjeto ( 'EEoImplementacionProcesos' , $EEoImplementacionProcesos ) ;
        
        
        
    
	
	
    //seccion gestion de dependencias entre objetos del nucleo
        
        $EEoNucleo->cargarObjetosDependencia( 'EEoInterfazDatos' , 'InterfazDatos' , 'Emod\Nucleo\Herramientas' );
        $EEoNucleo->cargarObjetosDependencia( 'EEoConfiguracion' , 'ConfiguracionProcesos' , 'Emod\Nucleo' );
        $EEoNucleo->cargarObjetosDependencia( 'EEoSeguridad' , 'SeguridadProcesos' , 'Emod\Nucleo' );
        $EEoNucleo->cargarObjetosDependencia( 'EEoImplementacionProcesos' , 'ImplementacionProcesos' , 'Emod\Nucleo' );
		
        
        $EEoInterfazDatos->cargarObjetosDependencia( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' );
        
        $EEoConfiguracion->cargarObjetosDependencia( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ;
        $EEoConfiguracion->cargarObjetosDependencia( 'EEoInterfazDatos' , 'InterfazDatos' , 'Emod\Nucleo\Herramientas' ) ;
        $EEoConfiguracion->cargarObjetosDependencia( 'EEoSeguridad' , 'SeguridadProcesos' , 'Emod\Nucleo' ) ;
        
        $EEoSeguridad->cargarObjetosDependencia( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ;
	    
        $EEoDatos->cargarObjetosDependencia( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ;
        $EEoDatos->cargarObjetosDependencia( 'EEoSeguridad' , 'SeguridadProcesos' , 'Emod\Nucleo' ) ;
	    
        $EEoImplementacionProcesos->cargarObjetosDependencia( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ;
        $EEoImplementacionProcesos->cargarObjetosDependencia( 'EEoInterfazDatos' , 'InterfazDatos' , 'Emod\Nucleo\Herramientas' ) ;
        $EEoImplementacionProcesos->cargarObjetosDependencia( 'EEoConfiguracion' , 'ConfiguracionProcesos' , 'Emod\Nucleo' );
        $EEoImplementacionProcesos->cargarObjetosDependencia( 'EEoSeguridad' , 'SeguridadProcesos' , 'Emod\Nucleo' ) ;
        $EEoImplementacionProcesos->cargarObjetosDependencia( 'EEoDatos' , 'DatosProcesos' , 'Emod\Nucleo' ) ;
		
    
    //seccion inicializacion de los objetos del nucleo que presizan inicializacion
        //inicializacion del objeto nucleo
        
        if ( !$EEoNucleo->iniciacionImplementacionNucleo() )
    	    {
    	        exit( '<p>ERROR FATAL, en: '.__FILE__.'->(Linea)'.__LINE__ ) ; 
    	    }
    		
		
				
        //inicializacion del objeto interfaz de datos
        
        $EEoInterfazDatos->iniciacionImplementacionInterfazDatos( 'yaml/e_interfaz_datos_yaml.php' , 'e_dir_interfaz_datos' ,  'adyacente' );
		
	


    //seccion carga de configuracion del sistema esquelemod
        
        $La_fich_interfaz_config['Ls_pathfich_interfaz'] = 'yaml/e_interfaz_datos_yaml.php' ;
	    $La_fich_interfaz_config['Ls_path_base'] = 'e_dir_interfaz_datos' ;
	    $La_fich_datos_config['Ls_pathfich_datos'] = 'e_sistema/e_sistema_config.cnf' ;
	    $La_fich_datos_config['Ls_path_base'] = 'e_dir_esquelemod' ;
	    
        if ( !$EEoNucleo->gestionIniciacionConfiguracionEsquelemod( $La_fich_interfaz_config , $La_fich_datos_config ) )
    	    {
    	        exit( '<p>ERROR FATAL, en: '.__FILE__.'->(Linea)'.__LINE__ ) ; 
    	    }
		unset( $La_fich_interfaz_config , $La_fich_datos_config ) ;
        
    //seccion carga de objeto EEoErrores gestor de errores del sistema esquelemod
      
        //es en la iniciacion del objeto nucleo del esquelemod donde este crea el objeto gestor de errores, ya que este gestor se define en la configuracion del sistema
        $existencia_objeto_errores = \Emod\Nucleo\CropNucleo::existenciaObjeto('EEoErrores', 'EErrores' , 'Emod\Nucleo\Errores') ;
        if( !empty( $existencia_objeto_errores ) )
            {
            $EEoErrores = \Emod\Nucleo\CropNucleo::referenciarObjeto('EEoErrores', 'EErrores' , 'Emod\Nucleo\Errores') ;
            $EEoImplementacionProcesos->cargarObjetosDependencia( 'EEoErrores' , 'EErrores' , 'Emod\Nucleo\Errores' ) ;
            }
        
    //seccion ejecucion del bloque de procesos configurado para el sistema esquelemod   
        
        $ejcucion_bloque_proceso = null ;
        $ejcucion_bloque_proceso = $EEoNucleo->ejecutarBloquesProcesos();
    
	
?>