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

        //(funcion que ejecuta los controles y debuelve los datos de interes para el control principal, donde primero se usa esta funcion es en la llamada al proceso configuracion para el cual  el id de proceso es 2 por defecto e el esquelemod, como es 1 para el proceso principal o nucleo )
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

        }

?>