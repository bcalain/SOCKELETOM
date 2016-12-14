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
   * ImplementacionProcesos class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

    namespace Emod\Nucleo ;

    class ImplementacionProcesos extends \Emod\Nucleo\NucleoEntidadBase
        {

        //protected $EEoNucleo = null ;
        //protected $EEoConfiguracion = null ;
        //protected $EEoSeguridad = null ;
        //protected $EEoDatos = null ;
        //protected $EEoInterfazDatos = null ;
        //funcion para controlar las referencias a objetos entidades del nucleo, ya que por error pueden ser cambiadas por cualquier proceso en ejecucion
        //$La_entidades puede tener valor null en este caso se chequean todas las entidades, o puede ser un arreglo no asociativo donde sus elementos sean strings con el valor de la entidad a chequear, los posibles valores de entidades son 'EEoNucleo','EEoConfiguracion', 'EEoSeguridad', 'EEoDatos', 'EEoInterfazDatos'    
        final private function controlEntidadesNucleo( $La_entidades = null )
            {
            $this->EEoImplementacionProcesos = $this ;
            if ( $La_entidades == null )
                {
                if ( $this->EEoNucleo !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) )
                    {
                    $this->EEoNucleo = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ;
                    }

                if ( $this->EEoConfiguracion !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoConfiguracion' , 'ConfiguracionProcesos' , 'Emod\Nucleo' ) )
                    {
                    $this->EEoConfiguracion = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoConfiguracion' , 'ConfiguracionProcesos' , 'Emod\Nucleo' ) ;
                    }

                if ( $this->EEoSeguridad !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoSeguridad' , 'SeguridadProcesos' , 'Emod\Nucleo' ) )
                    {
                    $this->EEoSeguridad = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoSeguridad' , 'SeguridadProcesos' , 'Emod\Nucleo' ) ;
                    }

                if ( $this->EEoDatos !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoDatos' , 'DatosProcesos' , 'Emod\Nucleo' ) )
                    {
                    $this->EEoDatos = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoDatos' , 'DatosProcesos' , 'Emod\Nucleo' ) ;
                    }

                if ( $this->EEoInterfazDatos !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoInterfazDatos' , 'InterfazDatos' , 'Emod\Nucleo\Herramientas' ) )
                    {
                    $this->EEoInterfazDatos = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoInterfazDatos' , 'InterfazDatos' , 'Emod\Nucleo\Herramientas' ) ;
                    }
                return true ;
                }
            elseif ( is_array( $La_entidades ) && !empty( $La_entidades ) )
                {
                $marca_entidad = false ;
                foreach ( $La_entidades as $entidad )
                    {
                    if ( $entidad == 'EEoNucleo' )
                        {
                        if ( !$marca_entidad )
                            {
                            $marca_entidad = true ;
                            }
                        if ( $this->EEoNucleo !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) )
                            {
                            $this->EEoNucleo = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ;
                            }
                        }
                    if ( $entidad == 'EEoConfiguracion' )
                        {
                        if ( !$marca_entidad )
                            {
                            $marca_entidad = true ;
                            }
                        if ( $this->EEoConfiguracion !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoConfiguracion' , 'ConfiguracionProcesos' , 'Emod\Nucleo' ) )
                            {
                            $this->EEoConfiguracion = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoConfiguracion' , 'ConfiguracionProcesos' , 'Emod\Nucleo' ) ;
                            }
                        }
                    if ( $entidad == 'EEoSeguridad' )
                        {
                        if ( !$marca_entidad )
                            {
                            $marca_entidad = true ;
                            }
                        if ( $this->EEoSeguridad !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoSeguridad' , 'SeguridadProcesos' , 'Emod\Nucleo' ) )
                            {
                            $this->EEoSeguridad = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoSeguridad' , 'SeguridadProcesos' , 'Emod\Nucleo' ) ;
                            }
                        }
                    if ( $entidad == 'EEoDatos' )
                        {
                        if ( !$marca_entidad )
                            {
                            $marca_entidad = true ;
                            }
                        if ( $this->EEoDatos !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoDatos' , 'DatosProcesos' , 'Emod\Nucleo' ) )
                            {
                            $this->EEoDatos = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoDatos' , 'DatosProcesos' , 'Emod\Nucleo' ) ;
                            }
                        }
                    if ( $entidad == 'EEoInterfazDatos' )
                        {
                        if ( !$marca_entidad )
                            {
                            $marca_entidad = true ;
                            }
                        if ( $this->EEoInterfazDatos !== \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoInterfazDatos' , 'InterfazDatos' , 'Emod\Nucleo\Herramientas' ) )
                            {
                            $this->EEoInterfazDatos = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoInterfazDatos' , 'InterfazDatos' , 'Emod\Nucleo\Herramientas' ) ;
                            }
                        }
                    }
                if ( $marca_entidad )
                    {
                    return true ;
                    }
                }
            return null ;
            }

        //funcion que controla si un proceso tiene permisos para ejecutar otro proceso o a si mismo segun su configuracion, esta funcion utiliza un procedimiento del objeto implementacion de la clase de seguridad, 
        //$id_proceso es el identificador del proceso al que se quiere chequear si es posible ejecutar por el proceso actual (en ejecucion)
        //si la gestion es satisfactoria el procedimiento devuelve el valor cadena 'ejecucion'(valor que corresponde al objeto seguridad), de no ser satisfactoria la gestion el procedimiento devuelve el valor NULL
        //si el $id_proceso no esta inicializado en el objeto seguridad $EEoSeguridad entonces por dfecto se permitira la ejecucion, de lo contrario se rige por la configuracion de este proceso para ser ejecutado o autoejecutarse, .
        final private function controlEjecucionProcesos( $Ls_id_proceso , $Ls_id_gedee_proceso , $Ls_clase_gedee_proceso , $Ls_namespace_gedee_proceso )
            {
            if ( is_object( $this->EEoNucleo ) && is_object( $this->EEoSeguridad ) )
                {
                if ( !empty( $Ls_id_proceso ) && !empty( $Ls_namespace_gedee_proceso ) && !empty( $Ls_clase_gedee_proceso ) )
                    {
                    if ( $Ls_id_proceso == 'hereda' )
                        {
                        $Ls_id_proceso = $this->EEoNucleo->idProcesoEjecucion() ;
                        }
                    if ( $Ls_id_gedee_proceso == 'hereda' )
                        {
                        $Ls_id_gedee_proceso = $this->EEoNucleo->idGedeeProcesoEjecucion() ;
                        }
                    if ( $Ls_clase_gedee_proceso == 'hereda' )
                        {
                        $Ls_clase_gedee_proceso = $this->EEoNucleo->claseGedeeProcesoEjecucion() ;
                        }
                    if ( $Ls_namespace_gedee_proceso == 'hereda' )
                        {
                        $Ls_namespace_gedee_proceso = $this->EEoNucleo->namespaceGedeeProcesoEjecucion() ;
                        }
                /////////////////////////////////////////////////////////////////////////////////
                    
                    $permiso_ejecucion = null ;
                        
                    //primero chequeo el permiso de ejecucion por parte del sistema     
                    if ( ( $this->EEoNucleo->idProcesoEjecucion() == $this->EEoNucleo->idProcesoNucleo() ) && ( $this->EEoNucleo->namespaceGedeeProcesoEjecucion() == $this->EEoNucleo->namespaceGedeeProcesoNucleo()) && ( $this->EEoNucleo->claseGedeeProcesoEjecucion() == $this->EEoNucleo->claseGedeeProcesoNucleo() ) && ( $Ls_namespace_gedee_proceso == $this->EEoNucleo->namespaceGedeeProcesoNucleo() ) && ( $Ls_clase_gedee_proceso == $this->EEoNucleo->claseGedeeProcesoNucleo() ) )
                        {//si es para un proceso nucleo y es ejecutado por el proceso nucleo actual, entonces se hace el chequeo
                        $permiso_ejecucion = $this->EEoNucleo->permisionProcesoNucleo( $Ls_id_proceso ) ;
                        if( empty( $permiso_ejecucion ) )
                        	{
                        	trigger_error('El proceso n&uacute;ucleo de id: '.$Ls_id_proceso.' no est&aacute; permitida su ejecuci&oacute;n, seg&uacute;n configuraci&oacute;n del sistema.' , E_USER_WARNING );
                        	}
                        }
                    else
                        {//si no es para un proceso nucleo se hace el chequeo, sino se emite un error
                        if( !( ( $Ls_namespace_gedee_proceso == $this->EEoNucleo->namespaceGedeeProcesoNucleo() ) && ( $Ls_clase_gedee_proceso == $this->EEoNucleo->claseGedeeProcesoNucleo() ) ) )
                        	 {
                        	 $permiso_ejecucion = $this->EEoNucleo->permisionProcesoCliente( $Ls_id_proceso , $Ls_clase_gedee_proceso , $Ls_namespace_gedee_proceso ) ;
                        	 }
                        if( empty( $permiso_ejecucion ) )
                        	 {
                        	 trigger_error('El proceso cliente de id: '.$Ls_id_proceso.' no est&aacute; permitida su ejecuci&oacute;n, seg&uacute;n configuraci&oacute;n del sistema.' , E_USER_WARNING );
                        	 }	 
                        }
                    //si el sistema permite la ejecucion entonces chequeo si el proceso a ejecutar permite que el proceso actual lo ejecute
                    if( $permiso_ejecucion == 'ejecucion' )
                        {//si el proceso que pide ejecutar es el propio proceso nucleo entonces se realiza la ejecucion, sino se controla la ejecucion en la estructura de seguridad del proceso a ejecutar, es decir si el proceso a ejecutar permite que el proceso actual lo ejecute 
                         if( ( $this->EEoNucleo->idProcesoEjecucion() != $this->EEoNucleo->idProcesoNucleo() ) || ( $this->EEoNucleo->namespaceGedeeProcesoEjecucion() != $this->EEoNucleo->namespaceGedeeProcesoNucleo() ) || ( $this->EEoNucleo->claseGedeeProcesoEjecucion() != $this->EEoNucleo->claseGedeeProcesoNucleo() ) || ( $this->EEoNucleo->idGedeeProcesoEjecucion() != $this->EEoNucleo->idGedeeProcesoNucleo() ) )    
                             {
                             return $this->EEoSeguridad->clienteEjecucionProceso( $Ls_id_proceso , $Ls_id_gedee_proceso , $Ls_clase_gedee_proceso , $Ls_namespace_gedee_proceso  ) ;
                             }
                         return $permiso_ejecucion ;    
                        }    
                    }
                }

            return null ;
            }

        //(funcion que ejecuta los controles y debuelve los datos de interes para el control padre, el proceso raiz o #1 es el proceso principal o nucleo )
        // $Ls_id_control_proceso es el id que tiene cada proceso, los siguientes numeros son reservados para el sistema 1-nucleo_proceso 2-sistem_configuration_process
        // $La_entrada_datos_proceso es una matriz con todos los datos que el proceso necesita para su correcto desempe�o 
        // $La_entrada_datos_proceso[ 'Ls_path_control_script'] es el path hasta el script control que se quiere incluir, tener muy presente que este path tendra como raiz el directorio esquelemod/e_modulos de la estructura de directorios del sistema esquelemod 
        // $La_entrada_datos_proceso [ 'Li_obligatoriedad' ] es la obligatoriedad de ejecucion del proceso ej 4-include, 3-include_once, 2-require, 1-require_once, 5-eval; cada forma con los riesgos y especificidades que implican estas construcciones del lenguaje, por defecto se ejecutar� la 4
        // cada proceso que carga esta funcion debe asignar un valor a la propiedad statu_ejecucion_proceso de de esta instancia que es la propiedad que retornar� este procedimiento para informar al nucleo del estado de la ejecuci�n del proceso actual, por defecto la propiedad statu_ejecucion_proceso retorna null
        final public function cargaControlProcesos( $Ls_id_proceso , $Ls_id_gedee_proceso , $Ls_clase_gedee_proceso , $Ls_namespace_gedee_proceso , $La_entrada_datos_proceso )
            {
            $ejecucion_proceso = null ;

            if ( !$this->controlEntidadesNucleo() )
                {
                //exit( "<p> ERROR FATAL, procedimiento: ".__METHOD__.", el control a entidades del nucleo no se puede realizar <p>" ) ;
                trigger_error('El control a entidades del n&uacute;cleo no se puede realizar ' , E_USER_ERROR ) ;
                }

            if ( !empty( $Ls_id_proceso ) && !empty( $Ls_namespace_gedee_proceso ) && !empty( $Ls_clase_gedee_proceso ) && is_array( $La_entrada_datos_proceso ) && !empty( $La_entrada_datos_proceso[ 'path_raiz' ] ) && !empty( $La_entrada_datos_proceso[ 'path_arranque' ] ) && is_file( $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/'.$this->EEoNucleo->pathDirRaizProcesos().'/'.$La_entrada_datos_proceso[ 'path_raiz' ].'/'.$La_entrada_datos_proceso[ 'path_arranque' ] ) )
                {
                if ( $Ls_id_proceso == 'hereda' )
                    {
                    $Ls_id_proceso = self::$EEoNucleo->idProcesoEjecucion() ;
                    }
                if ( $Ls_id_gedee_proceso == 'hereda' )
                    {
                    $Ls_id_gedee_proceso = self::$EEoNucleo->idGedeeProcesoEjecucion() ;
                    }
                if ( $Ls_clase_gedee_proceso == 'hereda' )
                    {
                    $Ls_clase_gedee_proceso = self::$EEoNucleo->claseGedeeProcesoEjecucion() ;
                    }
                if ( $Ls_namespace_gedee_proceso == 'hereda' )
                    {
                    $Ls_namespace_gedee_proceso = self::$EEoNucleo->namespaceGedeeProcesoEjecucion() ;
                    }
                
                ///////////////////////////////////////////////////////////////////////////////////////////////
                //gestionamos el permisos de ejecucion del proceso     
                $permiso_ejecucion = $this->controlEjecucionProcesos( $Ls_id_proceso , $Ls_id_gedee_proceso , $Ls_clase_gedee_proceso , $Ls_namespace_gedee_proceso ) ; 
                ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////  
                if ( $permiso_ejecucion == 'ejecucion' )
                    {
                    //actualizando al proceso nucleo de la ejecucion de un proceso

                    $id_clave_ejecucion = $this->EEoNucleo->actualizacionComienzoProceso( $Ls_id_proceso , $La_entrada_datos_proceso[ 'path_raiz' ] , $Ls_id_gedee_proceso , $Ls_namespace_gedee_proceso , $Ls_clase_gedee_proceso , __CLASS__.'::'.__METHOD__.'::'.__LINE__ ) ;

                    if ( empty( $id_clave_ejecucion ) )
                        {
                        return null ;
                        }

                    ////////////////////////                          

                    $this->statu_ejecucion_proceso = null ;

                    if ( empty( $La_entrada_datos_proceso [ 'obligatoriedad' ] ) )
                        {
                        $La_entrada_datos_proceso [ 'obligatoriedad' ] = 4 ;
                        }


                    //recordar capturar cualquier excepcion que ocurra en los procesos para poder darle tratamiento						  
                    switch ( $La_entrada_datos_proceso [ 'obligatoriedad' ] )
                        {
                        case 1 : require_once ( $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/'.$this->EEoNucleo->pathDirRaizProcesos().'/'.$La_entrada_datos_proceso[ 'path_raiz' ].'/'.$La_entrada_datos_proceso[ 'path_arranque' ] ) ;
                            break ;

                        case 2 : require ( $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/'.$this->EEoNucleo->pathDirRaizProcesos().'/'.$La_entrada_datos_proceso[ 'path_raiz' ].'/'.$La_entrada_datos_proceso[ 'path_arranque' ] ) ;
                            break ;

                        case 3 : include_once ( $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/'.$this->EEoNucleo->pathDirRaizProcesos().'/'.$La_entrada_datos_proceso[ 'path_raiz' ].'/'.$La_entrada_datos_proceso[ 'path_arranque' ] ) ;
                            break ;

                        case 4 : include ( $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/'.$this->EEoNucleo->pathDirRaizProcesos().'/'.$La_entrada_datos_proceso[ 'path_raiz' ].'/'.$La_entrada_datos_proceso[ 'path_arranque' ] ) ;
                            break ;

                        case 5 : eval( $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/'.$this->EEoNucleo->pathDirRaizProcesos().'/'.$La_entrada_datos_proceso[ 'path_raiz' ].'/'.$La_entrada_datos_proceso[ 'path_arranque' ] ) ;
                            break ;
                        }
                    //esta variable espera un true o un exit que emite el procedimiento que invoca

                    if ( !$this->controlEntidadesNucleo( $La_entidades = array( 'EEoNucleo' ) ) )
                        {
                        //exit( "<p> ERROR FATAL, procedimiento: ".__METHOD__.", el control a entidades del nucleo no se puede realizar <p>" ) ;
                        trigger_error('El control a entidades del n&uacute;cleo no se puede realizar ' , E_USER_ERROR ) ;
                        }
                    $ejecucion_proceso = $this->EEoNucleo->actualizacionFinalizacionProceso( $id_clave_ejecucion , __CLASS__.'::'.__METHOD__.'::'.__LINE__ ) ;
                    }
                }
            return $ejecucion_proceso ;
            }

        //(procedimiento que ejecuta los controles(scripts principal) de procesos, y debuelve los datos de interes para el control padre, el proceso raiz o #1 es el proceso principal o nucleo )
        // $La_bloque_procesos es un arreglo con una llave asociativa de nombre 'procesos' y como valor de esta llave un arreglo con los procesos y sus datos a ejecutar 
        //este procedimiento toma el parmatro $La_bloque_procesos y lo recorre recursivamente tomando sus valores y pasandolos como parámetros al procedimiento cargaControlProcesos() de esta misma clase
        //por lo que los valores referentes a los procesos declarados en $La_bloque_procesos deben cumplir con las normas de los parámetros del rocedimiento cargaControlProcesos() de esta misma clase.
        //este procedimiento retorna el valor de retorno del ultimo proceso ejecutado segun el orden de los procesos en $La_bloque_procesos.
        final public function ejecutarBloqueProcesos( $La_bloque_procesos )
            {
            	if ( !empty( $La_bloque_procesos ) && is_array( $La_bloque_procesos ) )
            		{
            		$ejecucion_proceso = NULL ;
            		foreach ( $La_bloque_procesos['procesos'] as $id_proceso => $valores_proceso )
            			{
            			if ( !empty( $valores_proceso ) && is_array( $valores_proceso ) )
            				{
            				if ( !empty( $valores_proceso['gedee_proceso'] ) )
            					{
            					$Ls_namespace_gedee_proceso_ejecucion = $valores_proceso['gedee_proceso']['namespace'];
            					$Ls_clase_gedee_proceso_ejecucion     = $valores_proceso['gedee_proceso']['clase'];
            					$Ls_id_gedee_proceso_ejecucion = $valores_proceso['gedee_proceso']['id_entidad'];
            					}
            				else
            					{
            					//exit( "<p> ERROR FATAL, procedimiento: " . __METHOD__ . ", no se encontr&oacute; gedee para el proceso $id_proceso " );
            					trigger_error('No se encontr&oacute; gedee para el proceso '.$id_proceso , E_USER_ERROR ) ;
            					}
            
            				if ( !empty( $valores_proceso['propiedades_implementacion_proceso']['condicion_ejecucion'] ) )
            					{
            					$continue  = true;
            					$condicion = 'if( ' . $valores_proceso['propiedades_implementacion_proceso']['condicion_ejecucion'] . ' )
												{
													$continue = false ;
												}';
            					eval( $condicion );
            
            					if ( $continue == true )
            						{
            						continue;
            						}
            					}
            				$ejecucion_proceso = $this->cargaControlProcesos( $id_proceso , $Ls_id_gedee_proceso_ejecucion , $Ls_clase_gedee_proceso_ejecucion , $Ls_namespace_gedee_proceso_ejecucion , $valores_proceso['propiedades_implementacion_proceso'] );
            				if ( !$ejecucion_proceso )
            					{
            					//echo "<p>ADVERTENCIA, El proceso: $id_proceso, de id gedee: $Ls_id_gedee_proceso_ejecucion, clase gedee: $Ls_namespace_gedee_proceso_ejecucion\\$Ls_clase_gedee_proceso_ejecucion no se pudo ejecutar satisfact&oacute;riamente<p>" ;
            					trigger_error('El proceso: '.$id_proceso.', de id gedee: '.$Ls_id_gedee_proceso_ejecucion.', clase gedee: '.$Ls_namespace_gedee_proceso_ejecucion.'\\'.$Ls_clase_gedee_proceso_ejecucion.' no se pudo ejecutar satisfact&oacute;riamente en '.__CLASS__ , E_USER_WARNING ) ;
            					}
            				}
            			}
            		return $ejecucion_proceso ;
            		}
            	trigger_error("El bloque de procesos no tiene valores o el tipo asociado a este dato en __METHOD__" , E_USER_ERROR ) ;
            }
            
        //(procedimiento que ejecuta el control (scripts principal) de un proceso determinado, y debuelve los datos de interes para el control padre )
        // $Ls_id_proceso_ejecutar es el identificador o nombre del proceso que se quiere ejecutar, este proceso a ejecutar se busca recursivamente en el arreglo $La_bloque_procesos para tomar los datos correspondientes a la ejecución.
        // $La_bloque_procesos es un arreglo con una llave asociativa de nombre 'procesos' y como valor de esta llave un arreglo con los procesos y sus datos a ejecutar
        //este procedimiento toma el parmatro $La_bloque_procesos y lo recorre recursivamente buscando el proceso con id igual al parametro $Ls_id_proceso_ejecutar, para tomar sus valores y pasarlos como parámetros al procedimiento cargaControlProcesos() de esta misma clase
        //por lo que los valores referentes a los procesos declarados en $La_bloque_procesos deben cumplir con las normas de los parámetros del rocedimiento cargaControlProcesos() de esta misma clase.
        //este procedimiento retorna el valor de retorno del proceso ejecutado en caso de haber coincidencias con el parámetro  $Ls_id_proceso_ejecutar .
        final public function ejecutarProcesoBloque( $La_bloque_procesos , $Ls_id_proceso_ejecutar )
            {
            	if ( !empty( $La_bloque_procesos ) && is_array( $La_bloque_procesos ) && !empty( $Ls_id_proceso_ejecutar ) )
            		{
            		$ejecucion_proceso = NULL ;
            		foreach ( $La_bloque_procesos['procesos'] as $id_proceso => $valores_proceso )
            			{
            			if ( ($id_proceso == $Ls_id_proceso_ejecutar ) && !empty( $valores_proceso ) && is_array( $valores_proceso ) )
            				{
            				if ( !empty( $valores_proceso['gedee_proceso'] ) )
            					{
            					$Ls_namespace_gedee_proceso_ejecucion = $valores_proceso['gedee_proceso']['namespace'];
            					$Ls_clase_gedee_proceso_ejecucion     = $valores_proceso['gedee_proceso']['clase'];
            					$Ls_id_gedee_proceso_ejecucion = $valores_proceso['gedee_proceso']['id_entidad'];
            					}
            				else
            					{
            					//exit( "<p> ERROR FATAL, procedimiento: " . __METHOD__ . ", no se encontr&oacute; gedee para el proceso $id_proceso " );
            					trigger_error('No se encontr&oacute; gedee para el proceso '.$id_proceso , E_USER_ERROR ) ;
            					}
            
            				if ( !empty( $valores_proceso['propiedades_implementacion_proceso']['condicion_ejecucion'] ) )
            					{
            					$continue  = true;
            					$condicion = 'if( ' . $valores_proceso['propiedades_implementacion_proceso']['condicion_ejecucion'] . ' )
												{
													$continue = false ;
												}' ;
            					eval( $condicion );
            
            					if ( $continue == true )
            						{
            						continue;
            						}
            					}
            				$ejecucion_proceso = $this->cargaControlProcesos( $id_proceso , $Ls_id_gedee_proceso_ejecucion , $Ls_clase_gedee_proceso_ejecucion , $Ls_namespace_gedee_proceso_ejecucion , $valores_proceso['propiedades_implementacion_proceso'] );
            				if ( !$ejecucion_proceso )
            					{
            					//echo "<p>ADVERTENCIA, El proceso: $id_proceso, de id gedee: $Ls_id_gedee_proceso_ejecucion, clase gedee: $Ls_namespace_gedee_proceso_ejecucion\\$Ls_clase_gedee_proceso_ejecucion no se pudo ejecutar satisfact&oacute;riamente<p>" ;
            					trigger_error('El proceso: '.$id_proceso.', de id gedee: '.$Ls_id_gedee_proceso_ejecucion.', clase gedee: '.$Ls_namespace_gedee_proceso_ejecucion.'\\'.$Ls_clase_gedee_proceso_ejecucion.' no se pudo ejecutar satisfact&oacute;riamente en '.__CLASS__ , E_USER_WARNING ) ;
            					}
            				}
            			}
            
            		return $ejecucion_proceso ;
            		}
            	trigger_error("El bloque de procesos o el id del proceso a ejecutar, no tienen valores o el tipo asociado a estos datos en __METHOD__" , E_USER_ERROR ) ;
            }
            
        }

?>