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
   * InterfazDatos class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */
    namespace Emod\Nucleo\Herramientas ;
	
    class InterfazDatos extends \Emod\Nucleo\Herramientas\Multiton 
        {  	   	  
             use \Emod\Nucleo\DependenciasEntidadesEmod ;
        

             //recordatorio de los objetos dependencias que utilizamos en procedimientos de esta clase
             //protected $EEoNucleo = null ;
             								
             //esta propiedad contiene el path del fichero interfaz por defecto del objeto instancia de esta clase. se recomienda que sea absoluto y no relativo
             //en proximas versiones esta propiedad sera un arreglo y se guardaran un grupo de interfaces por defecto que vendran con el esquelemod  
             private $lsPathFichInterfaz = '' ;
				
             //esta propiedad contiene la forma de decidir el lugar donde se gestionaran (crear, actualizar o consultar) los ficheros cache de datos,
             //sus valores posibles son: 
             //1-'statu_procesos' es solo para los procesos, y creara la cache de datos en el directorio raiz_dir_proceso_ejecucion/statu/cache_datos/, es decir en el directorio statu/cahe_datos que se encuentra en el dierctorio raiz del proceso(ejecutandose) que solicita el procedimiento correspondiente a la gestion de datos. 	
             //2-'adyacente' se ejecutara primero adyacente_datos y si no es posible se ejecutara adyacente_interfaz, ambas opciones se explican a continuacion  
             //3-'adyacente_datos' es para cualquier proceso y creara la cache en el mismo directorio que se encuentra el fichero de datos si este existe y si no en el mismo directorio que se encuentra el fichero interfaz. 
             //4-'adyacente_interfaz' es para cualquier proceso y creara la cache en el mismo directorio que se encuentra el fichero interfaz. 
             //5-'un path personalizado' y que tendra como raiz la ubicacion del directorio que elija 
             //6-'' valor vacio que hace referencia a la no implementacion(crear, actualizar o consultar) de gestion de cache, solo se gestiona la interfaz y los datos y se debuelve el resultado
             private $lsPathDirCache = 'adyacente' ;
				
             //esta propiedad es para declarar la iniciacion del objeto  instancia de esta clase, con ello no se permite posteriormente la modificacion de algunas propiedades del objeto  
             private $lsIniciacionInterfazDatos = null ;
			 			 
             // este procedimiento existe porque el constructor esta finalizado en la herencia parent de esta clase
             // la instancia necesita el path de un analizador o interfaz para alpicar por herencia o defecto
             // se creara una instancia de esta clase en los comienzos del motor esquelemod y luego esta instancia seguira brindando servicio a los demas niveles 
             // es obligatorio pasar al menos un parámetro válido sino no se dará por iniciado la instancia de esta clase     
             
             public function iniciacionImplementacionInterfazDatos( $Ls_pathfich_interfaz = '' , $Ls_pathdir_cache = '' )
                 {
                     $marca = null ;
                     if ( empty ( $this->lsIniciacionInterfazDatos ) )
                         {
                             if ( !empty ( $Ls_pathfich_interfaz ) )
                                 {
                                     $this->lsPathFichInterfaz = $Ls_pathfich_interfaz ;
                                     $marca = true ;
                                 }
                             if ( !empty ( $Ls_pathdir_cache ) )
                                 {
                                     $this->lsPathDirCache = $Ls_pathdir_cache ;
                                     $marca = true ;
                                 }
                             if ( $marca == true )
                                 {
                                     $this->lsIniciacionInterfazDatos = true ;
                                 }								    	
                         }
                     return $marca ;
                 } 
                 
             private function chequeoVersionCache ( $Ls_pathfichreferen_datos , $Ls_pathfich_cache )
                 {
                     if ( empty( $Ls_pathfichreferen_datos ) || empty( $Ls_pathfich_cache ) )
                         {
                             echo '<br> Error, al menos un parametro de la funcion contiene valor vacio en: '.__METHOD__.'<br> ' ;
                         }
                     elseif ( file_exists( $Ls_pathfich_cache ) ) 
                         { 
                             if ( filemtime( $Ls_pathfichreferen_datos ) < filemtime( $Ls_pathfich_cache ) ) 
                                 { 
                                     return true ; 
                                 }
                         }   
                     return null ;
                 }
			  
             private function creacionCache( $Ls_pathfich_cache , $datos_contenido )
                 {   
                     if( empty( $Ls_pathfich_cache ) || empty( $datos_contenido ) )
                         {
                             echo '<br> ERROR, al menos un parametro de la funcion contiene valor vacio en: '.__METHOD__.'<br> ' ;
                             return null ;
                         } 
                     //se crea la estructura del fichero cache, en un futuro esta estructura se pudiera tomar de un fichero externo
                     $Ls_estruct_fichcache="<?php
                                             \n\n".
											 '$datos ='.var_export( $datos_contenido , true ).";\n".
                                             'return $datos ;'."\n\n
	                                      ?>";
                    
                     if ( file_put_contents( $Ls_pathfich_cache , $Ls_estruct_fichcache ) )
                         {
                             return true ;
                         }
                     else
                         {
                             return null ;
                         }	   
				   
                 }
			  
             
		   
             final public function gestionEjecucionInterfazSalida ( $Ls_identificativo , $La_fich_interfaz , $La_fich_datos = null , $Ls_pathdir_cache = 'hereda' )
                 {  
                     
                     //////////iniciacion de variables////////////
                 
                     $Lb_marca_fichdatos = false ;
                     $Lb_marca_fichinterfaz = false ;
                     
                     //////////chequeo de parametros de entrada////////////////////
                 
                     if ( empty( $Ls_identificativo ) )
                         {
                             echo '<br>Error, valor vacio en parametro $Ls_identificativo en: '.__METHOD__.'<br> ';
                             return null ;
                         }
                     
                     //parametros fichero interfaz
                     if ( empty( $La_fich_interfaz['Ls_pathfich_interfaz'] ) )    
                         {
                             echo '<br>Error, valor vacio en parametro $La_fich_interfaz[\'Ls_pathfich_interfaz\'] en: '.__METHOD__.'<br> ';
                             return null ;
                         }
                     elseif ( ( strtolower( $La_fich_interfaz['Ls_pathfich_interfaz'] ) == 'hereda' ) || ( $La_fich_interfaz['Ls_pathfich_interfaz'] == $this->lsPathFichInterfaz ) )
                         { 
                             if ( !empty( $this->lsPathFichInterfaz ) && is_file( $this->lsPathFichInterfaz ) )
                                 {
                                     $Ls_pathfinal_interfaz = $this->lsPathFichInterfaz ;
                                     $Lb_marca_fichinterfaz = true ;
                                 }
                             else
                                 {
                                     echo '<br>Error, El fichero interfaz heredado no existe, '.$this->lsPathFichInterfaz.' en: '.__METHOD__.'<br> ' ;
                                     return null ;
                                 }
                         }
                     elseif( !empty( $La_fich_interfaz['Ls_path_base'] ) )
                         {
                             $La_fich_interfaz['Ls_path_base'] .= '/' ;
                         }
                     else
                         {
                             $La_fich_interfaz['Ls_path_base'] = '' ;
                         }						                         
                         
                     
                     //parametros fichero datos
                     if ( empty( $La_fich_datos['Ls_pathfich_datos'] ) )
                         {
                             echo '<br>Atencion, valor vacio en parametro $La_fich_datos[\'Ls_pathfich_datos\'] en: '.__METHOD__.'<br> ' ;
                         } 
                     elseif ( !empty( $La_fich_datos['Ls_path_base'] ) )
                         {
                             $La_fich_datos['Ls_path_base'].='/' ;
                         }
                     
					 
                     if ( $Ls_pathdir_cache == 'hereda' )
                         {
                             $Ls_pathdir_cache = $this->lsPathDirCache ;
                         }
                     
                        
                     /////////////gestion de paths//////////////////////
                     
                     //gestion de path para fichero interfaz
                     if ( !empty( $La_fich_interfaz['Ls_path_operativo'] ) )
                         {
                             $Li_cant_aparece1 = substr_count( $La_fich_interfaz['Ls_path_operativo'], '/' );
                             if( $Li_cant_aparece1 == 0 )
                                 {
                                     $La_fich_interfaz['Ls_path_operativo'] .= '/' ;       
                                 }	
                         }
                     else
                         {
                             $Li_cant_aparece1 = 0 ;
                             $La_fich_interfaz['Ls_path_operativo'] = '' ;	
                         }
						 	 
                     if( $Li_cant_aparece1 == 0 )
                         {    
                             if ( $Lb_marca_fichinterfaz == false )
                                 {
                                     if( is_file ( $La_fich_interfaz['Ls_path_base'].$La_fich_interfaz['Ls_path_operativo'].$La_fich_interfaz['Ls_pathfich_interfaz'] ) )
                                         {
                                             $Ls_pathfinal_interfaz = $La_fich_interfaz['Ls_path_base'].$La_fich_interfaz['Ls_path_operativo'].$La_fich_interfaz['Ls_pathfich_interfaz'] ;
                                             $Lb_marca_fichinterfaz = true ;
                                         }
                                     else
                                         {
                                             echo '<br> Error, El fichero interfaz no existe en: '.__METHOD__.'<br> ';
                                             return null ;
                                         }   
                                 }
                         }
                     else
                         {
                             do
                                 {
                                     if ( ( $Lb_marca_fichinterfaz == false ) && ( is_file ( $La_fich_interfaz['Ls_path_base'].$La_fich_interfaz['Ls_path_operativo'].'/'.$La_fich_interfaz['Ls_pathfich_interfaz'] ) ) )
                                         {  
                                             $Ls_pathfinal_interfaz = $La_fich_interfaz['Ls_path_base'].$La_fich_interfaz['Ls_path_operativo'].'/'.$La_fich_interfaz['Ls_pathfich_interfaz'] ;
                                             $Lb_marca_fichinterfaz = true ;
                                             break ;	
                                         }
                                     $pos_ult_apar5 = strripos ( $La_fich_interfaz['Ls_path_operativo'] , '/' );
							 
                                     if ( !empty( $pos_ult_apar5 ) )
                                         {
                                             $La_fich_interfaz['Ls_path_operativo'] = substr ( $La_fich_interfaz['Ls_path_operativo'] , 0 , $pos_ult_apar5 );
                                         }
                                     else
                                         {
                                             break ;
                                         }
                                 }
                             while ( $Li_cant_aparece1-- );
                             if ( $Lb_marca_fichinterfaz == false )
                                 {
                                     echo '<br> Error, El fichero interfaz no existe en: '.__METHOD__.'<br>';
                                     return null ;
                                 }
                         }
                         
                     //gestion de path para fichero datos
                     if ( !empty( $La_fich_datos['Ls_path_operativo'] ) )
                         {
                             $Li_cant_aparece2 = substr_count( $La_fich_datos['Ls_path_operativo'], '/' );
                             if( $Li_cant_aparece2 == 0 )
                                 {
                                     $La_fich_datos['Ls_path_operativo'] .= '/' ;       
                                 }	
                         }
                     else
                         {
                             $Li_cant_aparece2 = 0 ;
                             $La_fich_datos['Ls_path_operativo'] = '' ;	
                         }
						 	 
                     if( $Li_cant_aparece2 == 0 )
                         {    
                             if ( $Lb_marca_fichdatos == false )
                                 {
                                     if( is_file ( $La_fich_datos['Ls_path_base'].$La_fich_datos['Ls_path_operativo'].$La_fich_datos['Ls_pathfich_datos'] ) )
                                         {
                                             $Ls_pathfinal_datos = $La_fich_datos['Ls_path_base'].$La_fich_datos['Ls_path_operativo'].$La_fich_datos['Ls_pathfich_datos'] ;
                                             $Lb_marca_fichdatos = true ;
                                         }
                                     else
                                         {
                                             echo '<br> Atencion, El fichero datos no existe en: '.__METHOD__.'<br> ';
                                         }   
                                 }
                         }
                     else
                         {
                             do
                                 {
                                     if ( ( $Lb_marca_fichdatos == false ) && ( is_file ( $La_fich_datos['Ls_path_base'].$La_fich_datos['Ls_path_operativo'].'/'.$La_fich_datos['Ls_pathfich_datos'] ) ) )
                                         {  
                                             $Ls_pathfinal_datos = $La_fich_datos['Ls_path_base'].$La_fich_datos['Ls_path_operativo'].'/'.$La_fich_datos['Ls_pathfich_datos'] ;
                                             $Lb_marca_fichdatos = true ;
                                             break ;	
                                         }
                                     $pos_ult_apar6 = strripos ( $La_fich_datos['Ls_path_operativo'] , '/' );
							 
                                     if ( !empty( $pos_ult_apar6 ) )
                                         {
                                             $La_fich_datos['Ls_path_operativo'] = substr ( $La_fich_datos['Ls_path_operativo'] , 0 , $pos_ult_apar6 );
                                         }
                                     else
                                         {
                                             break ;
                                         }
                                 }
                             while ( $Li_cant_aparece2-- );
                             if ( $Lb_marca_fichdatos == false )
                                 {
                                     echo '<br> Atencion, El fichero datos no existe en: '.__METHOD__.'<br>';
                                 }
                         }    
                    
                     /////implementacion de gestion de cache////
                 
                     if ( !empty( $Ls_pathdir_cache ) )
                         {
                             //if existe fichero de datos se busca por el nombre de este sino se busca por el nombre del interfaz
				 
                             if ( !empty ( $Lb_marca_fichdatos  ) )
                                 {
                                     //hago referencia al fichero datos por el nombre del fichero de datos
                                     $Ls_pathfichreferen_datos = $Ls_pathfinal_datos ;  
                                 }
                             elseif ( !empty ( $Lb_marca_fichinterfaz  ) )
                                 {
                                     //hago referencia al fichero datos por el nombre del fichero interfaz
                                     $Ls_pathfichreferen_datos = $Ls_pathfinal_interfaz ;
                                 }
								  
                             //$Ls_pathmutar_cache y $Ls_pathraiz_cache son omologos, con la diferencia que $Ls_pathmutar_cache hay que acerle cambios y se convierte en $Ls_pathraiz_cache. 
                             $Ls_pathmutar_cache = null ;                              
                             switch( $Ls_pathdir_cache )
                                 {
                                     case 'adyacente'          :  
                                     case 'adyacente_datos'    :  if ( !empty ( $Lb_marca_fichdatos ) )
                                                                      {
                                                                          $Ls_pathmutar_cache = $Ls_pathfinal_datos ; 
                                                                          break ;
                                                                      }
                                                                  elseif ( $this->lsPathDirCache == 'adyacente_datos' )
                                                                      {
                                                                          echo '<br> Error, El fichero interfaz no existe en: '.__METHOD__.'<br>';
                                                                          return null ;
                                                                      }   
                                     case 'adyacente_interfaz' :  $Ls_pathmutar_cache = $Ls_pathfinal_interfaz ;
                                                                  break ;
                                            
                                     case 'statu_procesos'     :  if ( !is_object( $this->EEoNucleo ) && !( $this->cargarObjetosDependencia( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ) )
                                                                      {
                                                                          echo '<p>ERROR, No es posible referenciar el objeto EEoNucleo y se interfiere con la correcta ejecucion de este procedimiento, en:<p> '.__METHOD__.'<p>';
                                                                          return null ;
                                                                      }
                                                                  $path_dirraiz_proceso = $this->EEoNucleo->pathDirRaizProcesos() ;
                                                                  if ( empty( $path_dirraiz_proceso ) )
                                                                      {
                                                                          echo '<p>ERROR, El valor EEoNucleo->pathDirRaizProcesos() tiene valor vacio e interfiere con la correcta ejecucion de este procedimiento, en:<p> '.__METHOD__.'<p>';
                                                                          return null ;
                                                                      }
								      
                                                                  $path_dir_statu_proceso = $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/'.$this->EEoNucleo->pathDirRaizProcesos().'/'.$this->EEoNucleo->pathDirRaizProcesoEjecucion().'/statu' ;
                                                                  
                                                                  if ( !( is_dir( $path_dir_statu_proceso.'/cache_datos' ) ) )
                                                                      {
                                                                          if ( !( is_dir( $path_dir_statu_proceso ) ) )
                                                                              {
                                                                                  mkdir( $path_dir_statu_proceso ) ;                                                                                  	
                                                                              }
                                                                          if ( !mkdir( $path_dir_statu_proceso.'/cache_datos' ) )
                                                                              {
                                                                                  echo '<p>ERROR, No existe o se puede crear el directorio cahe_datos para la opcion statu_procesos del procedimiento, en:<p> '.__METHOD__.'<p>';
                                                                                  return null ;                                                                                  	
                                                                              } 
                                                                      }
                                                                  $Ls_pathraiz_cache = $path_dir_statu_proceso.'/cache_datos' ;
																  
                                                                  break ;   
                        
                                     default                   :  $Ls_pathraiz_cache = $Ls_pathdir_cache ;
                                                                                 
                                 }
                             //elaboro el path del fichero cache
                             
                             if ( !empty( $Ls_pathmutar_cache ) )
                                 {
                                     $pos_ult_apar1 = strripos ( $Ls_pathmutar_cache , '/' ) ;
                                     $Ls_pathraiz_cache = substr ( $Ls_pathmutar_cache , 0 ,$pos_ult_apar1 ) ;	 	
                                 }
                             
                             //se elavoran o las partes del nombre del fichero cache sin concatenarle el identificador
                             $pos_ult_apar2 = strripos ( $Ls_pathfichreferen_datos , '/' ) ;
                             if ( !empty( $pos_ult_apar2 ) )
                                 {
                                     $Ls_nombrefich_cache = substr ( $Ls_pathfichreferen_datos , $pos_ult_apar2+1 ) ;
                                 }
                             $pos_ult_apar3 = strripos ( $Ls_nombrefich_cache , '.' ) ;
                             $Ls_idnombrefich_cache =	substr ( $Ls_nombrefich_cache , 0 ,$pos_ult_apar3 ).'_cache' ;
                             $Ls_extfich_cache = substr ( $Ls_nombrefich_cache , $pos_ult_apar3+1 ) ;
                             if ( $Ls_extfich_cache != 'php')
                                 {
                                     //se corrige la extencion del fichero cache 
                                     $Ls_extfich_cache = 'php' ;
                                 }
                             //se elavora el path y nombre del fichero cache con todas sus partes y el identificador
                             $Ls_pathfich_cache = $Ls_pathraiz_cache.'/'.$Ls_identificativo.'_'.$Ls_idnombrefich_cache.'.'.$Ls_extfich_cache ;
							    
                         }
                     $datos_final = null ;
                     //si existe cache temporal lo incluyo sino gestiono los datos y luego creo la cache    
                     if( !empty( $Ls_pathdir_cache ) && $this->chequeoVersionCache( $Ls_pathfichreferen_datos , $Ls_pathfich_cache ) )
                         {  
                             //incluyo cache temporal
                              
                             $datos_final = include ( $Ls_pathfich_cache ) ;
                         }
                     else 
                         {
                             ////////////implementaci�n de gestion de ficheros por no existencia de cache///////////////////////
                             // en este fragmento se incluye el fichero interfaz el cual puede trabajar con:
                             // la variable $Lb_marca_fichdatos para conocer si se ha encontrado un fichero de configuraci�n
                             // la variable $Ls_pathfinal_datos para obtener el path del fichero de configuraci�n, estos es si existe y elinterfaz lo necesita porque puede que el interfaz lo gestione independientemente, no se muestra en este c�digo pero el interfaz al ser incluido debe conoser de su existencia y rtabajar con �l.  
                             // la variable $La_datos_final que portar� los datos de la configuraci�n gestionada, y se emitir� como resultado de la funci�n. 
                             if ( is_file ( $Ls_pathfinal_interfaz ) )
                                 {    
                                     $datos_final = include $Ls_pathfinal_interfaz ;
                                 }	  
                        				     	
                             //creando fichero cache
                             if ( !empty( $Ls_pathdir_cache ) && ( empty( $Ls_pathfich_cache ) || empty( $datos_final ) || (! $this->creacionCache( $Ls_pathfich_cache , $datos_final ) ) ) )
                                 {
                                     echo '<p>Atencion, el fichero cache no pudo ser creado en:<p> '.__METHOD__.'<p>';
                                 }
                         }
                     //////////chequeo y retorno de los datos
                 
                     if ( !empty ( $datos_final ) )
                         {
                             return $datos_final ;
                         }
                 
                     return null ;
                   
                 }
             /*    
             final public function gestionEjecucionInterfazEntrada ( $La_fich_interfaz , $La_fich_datos = null , $La_datos_entrada = null )
                 {  
                     
                     //////////iniciacion de variables////////////
                 
                     $Lb_marca_fichdatos = false ;
                     $Lb_marca_fichinterfaz = false ;
                     
                     //////////chequeo de parametros de entrada////////////////////
                     //parametros fichero interfaz
                     if ( empty( $La_fich_interfaz['Ls_pathfich_interfaz'] ) )    
                         {
                             echo '<br>Error, valor vacio en parametro $La_fich_interfaz[\'Ls_pathfich_interfaz\'] en: '.__METHOD__.'<br> ';
                             return null ;
                         }
                     elseif ( ( strtolower( $La_fich_interfaz['Ls_pathfich_interfaz'] ) == 'hereda' ) || ( $La_fich_interfaz['Ls_pathfich_interfaz'] == $this->lsPathFichInterfaz ) )
                         { 
                             if ( !empty( $this->lsPathFichInterfaz ) && is_file( $this->lsPathFichInterfaz ) )
                                 {
                                     $Ls_pathfinal_interfaz = $this->lsPathFichInterfaz ;
                                     $Lb_marca_fichinterfaz = true ;
                                 }
                             else
                                 {
                                     echo '<br>Error, El fichero interfaz heredado no existe, '.$this->lsPathFichInterfaz.' en: '.__METHOD__.'<br> ' ;
                                     return null ;
                                 }
                         }
                     elseif( !empty( $La_fich_interfaz['Ls_path_base'] ) )
                         {
                             $La_fich_interfaz['Ls_path_base'] .= '/' ;
                         }
                     else
                         {
                             $La_fich_interfaz['Ls_path_base'] = '' ;
                         }						                         
                         
                     
                     //parametros fichero datos
                     if ( empty( $La_fich_datos['Ls_pathfich_datos'] ) )
                         {
                             echo '<br>Atencion, valor vacio en parametro $La_fich_datos[\'Ls_pathfich_datos\'] en: '.__METHOD__.'<br> ' ;
                         } 
                     elseif ( !empty( $La_fich_datos['Ls_path_base'] ) )
                         {
                             $La_fich_datos['Ls_path_base'].='/' ;
                         }
                     
					 /////////////gestion de paths//////////////////////
                     
                     //gestion de path para fichero interfaz
                     if ( !empty( $La_fich_interfaz['Ls_path_operativo'] ) )
                         {
                             $Li_cant_aparece1 = substr_count( $La_fich_interfaz['Ls_path_operativo'], '/' );
                             if( $Li_cant_aparece1 == 0 )
                                 {
                                     $La_fich_interfaz['Ls_path_operativo'] .= '/' ;       
                                 }	
                         }
                     else
                         {
                             $Li_cant_aparece1 = 0 ;
                             $La_fich_interfaz['Ls_path_operativo'] = '' ;	
                         }
						 	 
                     if( $Li_cant_aparece1 == 0 )
                         {    
                             if ( $Lb_marca_fichinterfaz == false )
                                 {
                                     if( is_file ( $La_fich_interfaz['Ls_path_base'].$La_fich_interfaz['Ls_path_operativo'].$La_fich_interfaz['Ls_pathfich_interfaz'] ) )
                                         {
                                             $Ls_pathfinal_interfaz = $La_fich_interfaz['Ls_path_base'].$La_fich_interfaz['Ls_path_operativo'].$La_fich_interfaz['Ls_pathfich_interfaz'] ;
                                             $Lb_marca_fichinterfaz = true ;
                                         }
                                     else
                                         {
                                             echo '<br> Error, El fichero interfaz no existe en: '.__METHOD__.'<br> ';
                                             return null ;
                                         }   
                                 }
                         }
                     else
                         {
                             do
                                 {
                                     if ( ( $Lb_marca_fichinterfaz == false ) && ( is_file ( $La_fich_interfaz['Ls_path_base'].$La_fich_interfaz['Ls_path_operativo'].'/'.$La_fich_interfaz['Ls_pathfich_interfaz'] ) ) )
                                         {  
                                             $Ls_pathfinal_interfaz = $La_fich_interfaz['Ls_path_base'].$La_fich_interfaz['Ls_path_operativo'].'/'.$La_fich_interfaz['Ls_pathfich_interfaz'] ;
                                             $Lb_marca_fichinterfaz = true ;
                                             break ;	
                                         }
                                     $pos_ult_apar5 = strripos ( $La_fich_interfaz['Ls_path_operativo'] , '/' );
							 
                                     if ( !empty( $pos_ult_apar5 ) )
                                         {
                                             $La_fich_interfaz['Ls_path_operativo'] = substr ( $La_fich_interfaz['Ls_path_operativo'] , 0 , $pos_ult_apar5 );
                                         }
                                     else
                                         {
                                             break ;
                                         }
                                 }
                             while ( $Li_cant_aparece1-- );
                             if ( $Lb_marca_fichinterfaz == false )
                                 {
                                     echo '<br> Error, El fichero interfaz no existe en: '.__METHOD__.'<br>';
                                     return null ;
                                 }
                         }
                         
                     //gestion de path para fichero datos
                     if ( !empty( $La_fich_datos['Ls_path_operativo'] ) )
                         {
                             $Li_cant_aparece2 = substr_count( $La_fich_datos['Ls_path_operativo'], '/' );
                             if( $Li_cant_aparece2 == 0 )
                                 {
                                     $La_fich_datos['Ls_path_operativo'] .= '/' ;       
                                 }	
                         }
                     else
                         {
                             $Li_cant_aparece2 = 0 ;
                             $La_fich_datos['Ls_path_operativo'] = '' ;	
                         }
						 	 
                     if( $Li_cant_aparece2 == 0 )
                         {    
                             if ( $Lb_marca_fichdatos == false )
                                 {
                                     if( is_file ( $La_fich_datos['Ls_path_base'].$La_fich_datos['Ls_path_operativo'].$La_fich_datos['Ls_pathfich_datos'] ) )
                                         {
                                             $Ls_pathfinal_datos = $La_fich_datos['Ls_path_base'].$La_fich_datos['Ls_path_operativo'].$La_fich_datos['Ls_pathfich_datos'] ;
                                             $Lb_marca_fichdatos = true ;
                                         }
                                     else
                                         {
                                             echo '<br> Atencion, El fichero datos no existe en: '.__METHOD__.'<br> ';
                                         }   
                                 }
                         }
                     else
                         {
                             do
                                 {
                                     if ( ( $Lb_marca_fichdatos == false ) && ( is_file ( $La_fich_datos['Ls_path_base'].$La_fich_datos['Ls_path_operativo'].'/'.$La_fich_datos['Ls_pathfich_datos'] ) ) )
                                         {  
                                             $Ls_pathfinal_datos = $La_fich_datos['Ls_path_base'].$La_fich_datos['Ls_path_operativo'].'/'.$La_fich_datos['Ls_pathfich_datos'] ;
                                             $Lb_marca_fichdatos = true ;
                                             break ;	
                                         }
                                     $pos_ult_apar6 = strripos ( $La_fich_datos['Ls_path_operativo'] , '/' );
							 
                                     if ( !empty( $pos_ult_apar6 ) )
                                         {
                                             $La_fich_datos['Ls_path_operativo'] = substr ( $La_fich_datos['Ls_path_operativo'] , 0 , $pos_ult_apar6 );
                                         }
                                     else
                                         {
                                             break ;
                                         }
                                 }
                             while ( $Li_cant_aparece2-- );
                             if ( $Lb_marca_fichdatos == false )
                                 {
                                     echo '<br> Atencion, El fichero datos no existe en: '.__METHOD__.'<br>';
                                 }
                         }    
                     $datos_final = null ;
                     
                     ////////////implementaci�n de gestion de ficheros por no existencia de cache///////////////////////
                     // en este fragmento se incluye el fichero interfaz el cual puede trabajar con:
                     // la variable $Lb_marca_fichdatos para conocer si se ha encontrado un fichero de configuraci�n
                     // la variable $Ls_pathfinal_datos para obtener el path del fichero de configuraci�n, estos es si existe y elinterfaz lo necesita porque puede que el interfaz lo gestione independientemente, no se muestra en este c�digo pero el interfaz al ser incluido debe conoser de su existencia y rtabajar con �l.  
                     // la variable $La_datos_final que portar� los datos de la configuraci�n gestionada, y se emitir� como resultado de la funci�n. 
                     if ( is_file ( $Ls_pathfinal_interfaz ) )
                         {    
                             $datos_final = include $Ls_pathfinal_interfaz ;
                         }	  
                     return $datos_final ;
                   
                 }*/
              
//en proximas versiones funciones filtro de datos que implementen a $this->gestionEjecucionInterfazSalida() y retornen los datos filtrados                
	   
/*	
	//////////////////////////////////////////////////////////////////////////////////////////////

	----InterfazDatos----

Clase para la gestion de datos a traves de una interfaz .

Ejemplo:
          $obj = \Emod\Nucleo\InterfazDatos::instanciar();
          
          se instancia de esta forma porque esta clase hereda de la clase Nucleo_entidad
          
        ///////////////////////////////funciones de esta clase/////////////////////////  
        
		----iniciacionImplementacionInterfazDatos----
		
		La funci�n inicializacion, como bien se ve en el ejemplo de inicializacion de la instancia, tiene los siguientes par�metros 
		
        public function iniciacionImplementacionInterfazDatos( $Ls_pathfich_interfaz = '' , $Ls_pathdir_cache = '' , $Ls_pathstatu_proceso = '' )
        
		$Ls_pathfich_interfaz(string) contendr� la direcci�n de un fichero interfaz para tomarlo como gestor o analizador de datsos, por defecto de la instancia de esta clase
		$Ls_pathdir_cache(string) contendr� la direcci�n de un directorio donde se crearan y/o leeran los ficheros cach� de las configuraciones, si se deja el valor por defecto o se introduce un valor vacio se crear�n o buscaran los ficheros cach� en la ubicaci�n donde est� la instancia de la clase.Para las aplicaciones y m�dulos de estas este directorio estar� en homeapp 
		$Ls_pathstatu_proceso(string) contendra la direccion o path del directorio e_statu_proceso para la gestion de la cache en caso de utilizar opciones de esta misma clase que hagan referencia a este directorio.  
        
		$resultado puede ser: en caso que exista al menos un par�metro que tenga valor no vac�o el procedimiento retorna true.
		                      en caso que todos los par�metros tengan valor vac�o el procedimiento retorna null.
		
		//////////////////////////////////////////////////////////////////////////////
		----chequeo_versioncahe----
		
		Esta funci�n se encarga de chequear, en correpondencia con los par�metros, si existe el fichero cache de la interfaz y si este fu� modificado en fecha y hora mas reciente que el fichero de interfaz.

        Descripci�n:

       ($resultado) chequeo_versioncahe_interfaz ( $Ls_fich_interfaz , $Ls_fich_cache )      
        
		alcance: private
		 
	    $Ls_fich_interfaz(string) contendr� la direcci�n o path del fichero de interfaz.
		$Ls_fich_cache(string) contendr� la direcci�n o path del fichero cach�.
	      
	    $resultado puede ser:
		                      true, si existe el fichero cach� y fu� modificado mas recientemente que el fichero de interfaz.
							  null, en caso de no ser true.
							  en caso que alguno de los par�metros tenga valor vac�o se emite mediante echo un mensaje de alerta y luego el valor null. 
							  
        ////////////////////////////////////////////////////////////////////////////////////////  
        
        ----creacionCache----

        Esta funci�n se encarga de crear un fichero (cach�) con una estructura de datos legibles para PHP, partiendo de los datos que se le transfieren a la funci�n a trav�s del par�metro $La_datos_contenido.

        Descripci�n: 
	   
	    alcance: private
	   
	   ($resultado) creacionCache( $Ls_path_fichcache , $datos_contenido )

        $Ls_path_fichcache(string) contendr� la direcci�n o path donde se crear� el fichero cach�, si existe se sobreescribe sino se crea.
		$datos_contenido(tipo) contendr� el valor a plasmar con una estructura de datos legibles para PHP en el fichero cach�. eldato introdicido tiene que ser capaz de ser procesado por la funcion var_export() de php   
	    
	    $resultado puede ser:
		                      true, si pudo crear el fichero con �xito.
							  null, si no es true.
							  en caso que alguno de los par�metros tenga valor vac�o se emite mediante echo un mensaje de alerta y luego el valor null.
							  
        ////////////////////////////////////////////////////////////////////////////////////////  
        
        ----gestionEjecucionInterfazSalida----

        Esta funci�n se encarga de gestionar y ejecutar la interfaz, si existen los datos de la interfaz en cach� y estos est�n actualizados los obtiene por esta v�a, si lo anterior no es posible, gestiona y ejecuta la interfaz y el fichero fuente de datos que analiza la interfaz en caso de que la interfaz obtenga los datos a travez del analisis de un fichero determinado, e intenta crear un fichero cach� con los datos obtenidos , luego emite los datos con return   ******** buscar coincidencias de nombre en el fichero alias en corespondencia con los par�metros introducidos*****

        Descripci�n: 
	   
	    alcance: public
	   
	   ($resultado) gestionEjecucionInterfazSalida ( $Ls_identificativo , $Ls_fich_interfaz = 'hereda' , $Ls_fich_datos = '' , $Ls_pathdir_cache = 'hereda' , $Ls_path_base = '' , $Ls_path_operat = ''  )

        $Ls_identificativo(string) es un identificativo que acompa�ar� al nombre de la interfaz o el fichero contenedor de datos y que conformar�n el nombre del fichero cach�, quedando como nombre del fichero cache $Ls_identificativo_nombredelficherointerfaz o $Ls_identificativo_nombredelficherodatos, segun corresponda y con preferencia a $Ls_identificativo_nombredelficherodatos .
		$Ls_fich_interfaz(string) contendr� el path del fichero interfaz teniendo como ra�z los directoros declarados en los par�metros $Ls_path_operat y $Ls_path_base. En el caso que se quiera utilizar el path que por defecto tiene asignado el objeto instancia de esta clase, entonces se puede poner el valor 'hereda' o el path explisitamente, de ser asi no se tienen en cuenta los parametros $Ls_path_operat y $Ls_path_base para el fichero interfaz, pero si para el fichero datos  
	    $Ls_pathdir_cache(string) contendr� el path del directorio cache, donde se va a crear, actualizar o consultar el fichero cache, este parametro tiene las sigientes opciones como valor:
	    	//1-'statu_procesos' es solo para procesos, es en el directorio statu/datos_cache/ que contendra cada procesos en su directorio raiz, de no encontrarse este directorio este procedimiento intentara crearlo, el nombre del fichero cache estara compuesto por el nombre del fichero datos si existe y en caso de no ser asi entonces el nombre del fichero interfaz  	
			//2-'adyacente' se ejecutara primero adyacente_datos y si no es posible se ejecutara adyacente_interfaz, ambas opciones se explican a continuacion, el nombre del fichero cache estara compuesto por el nombre del fichero datos si existe y en caso de no ser asi entonces el nombre del fichero interfaz   
            //3-'adyacente_datos' es para cualquier proceso y crear� la cache en el mismo directorio que se encuentra el fichero de datos, el nombre del fichero cache estara compuesto por el nombre del fichero datos si existe, si se escogio esta opcion en especifico y no existe fichero datos el procedimiento retornara null . 
			//4-'adyacente_interfaz' es para cualquier proceso y crear� la cache en el mismo directorio que se encuentra el fichero interfaz, el nombre del fichero cache estara compuesto por el nombre del fichero interfaz.  
			//5-'un path personalizado' y que tendr� como raiz la ubicacion del directorio que elija, el nombre del fichero cache estara compuesto por el nombre del fichero datos si existe y en caso de no ser asi entonces el nombre del fichero interfaz.  
			//6-'' valor vacio que hace referencia a la no implementacion(crear, actualizar o consultar) de gestion de cache, solo se gestiona la interfaz y los datos y se debuelve el resultado 
		$Ls_fich_datos(string) contendr� el path del fichero de datos teniendo como ra�z los directoros declarados en los par�metros $Ls_path_operat y $Ls_path_base.
	    $Ls_path_base(string) es el fragmento de path que tiene como ra�z el fichero interfaz y el fichero datos (de existir este) y que no se recorrer� hacia arriba en el �rbol de directorios en busca de estos ficheros mencionados anteriormente en caso de no existir estos ficheros en el path original. 
	    $Ls_path_operat(string) es el fragmento de path que tiene como ra�z el fichero interfaz y el fichero datos (de existir este) y que se recorrer� hacia arriba en el �rbol de directorios en busca de estos ficheros mencionados anteriormente en caso de no existir estos ficheros en el path original. La busqueda se hace por los path conformados de la sigiente forma $Ls_path_base/$Ls_path_operat/$Ls_fich_interfazodatos, la busqueda hacia arriba en el arbol de directorio solo se hace por el fragmento de path del parametro $Ls_path_operat y concatenando a este en cada iteracion el parametro $Ls_fich_interfazodatos   
		
		$resultado puede ser:
		                      array, contendr� en su estructura los datos gestionados.
							  NULL, en caso de ser cargado el fichero cach� y como resultado final de la gesti�n, contener la variable que emite la funci�n un valor vac�o o ser de un tipo diferente a array.
							  se emite mediante echo un mensaje de error y luego el valor null cuando:
							    1- el par�metro $Ls_identificativo contiene un valor vac�o.
							    2- el par�metro $Ls_path_operat contiene un valor vac�o.
							    3- el par�metro $Ls_fich_interfaz contiene un valor vac�o.
							    4- el par�metro $Ls_fich_interfaz contiene el valor 'hereda'�y no existe el fichero en el path especificado.
							    5- el par�metro $Ls_fich_interfaz contiene un valor determinado y no existe el fichero en el path especificado.
							    6- el fichero interfaz es incluido y como resultado de la gesti�n de datos se obtiene una variable con valor vac�o o de un tipo diferente a array.
							  se emite mediante echo un mensaje de alerta en caso que exista un valor admitido para la datos y el fichero cach� no pueda ser creado.	 
        //////////////////////////////////////////////////////////////////////////////////////////
        
        El esquelemod concidera la gesti�n de datos como un elemento indispensable a tener en cuenta para la escalabilidad, flexibilidad, personalizaci�n y portabilidad
		de un sistema o aplicaci�n, es por ello que separa la gesti�n de datos de la implementaci�n de estos. El sistema de gestion de datos del esquelemod implementa
		lo expuesto anteriormente, para el esquelemod la gesti�n de datos se realiza con el protagonismo de tres elementos que a continuaci�n explicamos:
		
		1- Instancia de la clase InterfazDatos es qui�n localiza el interfaz para la gesti�n de datos , adem�s de getionar el sistema de cacheo para
		   cada paquete de datos . Segun los datos introducidos a la instancia en los par�metros de sus m�todos, esta busca la localizaci�n del fichero interfaz 
		   para implementarlo mediante include, teniendo en el momento de esta implementaci�n localizado tambi�n al fichero de datos para que el interfaz pueda hacer 
		   su gesti�n de datos con el fichero datos en caso de existir. En la ayuda de la clase estan explicados las propiedades, los metodos y sus par�metros.       
		   
		2- Fichero interfaz es qui�n implementa la forma en que se extraer�n los datos , este fichero ser� implementado a trav�s de include.
		   Es este fichero qui�n contiene el c�digo php que interpreta o extrae los datos de determinada fuente, la fuente de datos puede ser
		   cualquiera, solo depende del interfaz servir como puente entre esa estructura y soporte de datos y la instancia gestionadora e implementadora de esta interfaz. Este
		   c�digo al ser incluido debe cumplir 2 requisitos
		    1-en caso de trabajar con un fichero de datos gestionado por la instancia de la clase InterfazDatos el path de este fichero de datos
			  gestionado se encuentra en una variable con nombre $Ls_pathfinal_datos, variable que hereda el interfaz del c�digo de la instacia, por ser el interfaz incluido
			  en el c�digo de la instancia.
			2-Por el mismo principio de ser el fichero interfaz incluido en el c�digo de la instancia, el codigo de la instancia espera el contenido de los datos a traves de un retorno (return) en el fichero interfaz
			  , para luego ser procezados por la instancia de la clase InterfazDatos.
			
			
		   no es obligatorio que el fichero interfaz procece un fichero de datos, puesto que el mismo fichero interfaz puede gestionar los datos de 
		   otras fuentes como bases de datos o pedidos a otros gestores.
		   
		   ejemplo de un interfaz
		   
		   <?php
		   
		      include_once ( 'spyc/Spyc.php' ) ;
   	          return Spyc::YAMLLoad( $Ls_pathfinal_datos );
				         
		   ?>
		3- Fichero datos es qui�n constituye la estructura de los datos en su forma personalizada o t�pica, ser� interpretado por el interfaz, puede existir o no en dependencia
		   de la gesti�n del interfaz         

        Los ficheros interfaz y de datos ser�n gestionados buscando primero sus path en la direcci�n exacta que se introduce como path en los par�metros de la instancia de la clase InterfazDatos
        y si no se encuentran se buscan hacia atras nivel por nivel de directorio segun el valor del parametro $Ls_path_operat, hasta encontrarlos indistintamente o llegar al path declarado en el par�metro $Ls_path_base, 
		para tener mayor conocimiento sobre el tema ver la ayuda de la clase InterfazDatos el procedimiento gestionEjecucionInterfazSalida .

        La instancia de esta clase antes de gestionar los datos, intentar� encontrar una cach� de estos datos, y si no la encuentra crear� una despu�s de gestionarlos a travez de la interfaz, todo esto en dependencia de los datos
		introducidos en los par�metros de los m�todos correspondientes a esta funcionalidad, y que se encuentran detallados en la ayuda de el procedimiento gestionEjecucionInterfazSalida() de la clase InterfazDatos,  
		
		el fichero cache debe tener la siguiente estructura
		
	    <?php
	          $datos = *datos*
	          
	          return($datos);
	          
         ?>
         
        El tratamiento del interfaz y el fichero de datos con el identificador como parametro en la funcion, se debe a que es permitido tener un solo interfaz para diferentes ficheros u opciones de datos y por ello cada ves que se crea una cache 
        de diferentes ficheros u opciones de datos pero con el mismo interfaz, esta cache debe tener un nombre que no sobreesciba otra cahe de otros datos.
        El fichero de datos se puede omitir, si y solo si el interfaz lo gestiona o gestiona por si solo los datos, en este caso el fichero cache toma el nombre $Ls_identificativo_nombredelficherointerfaz_cache.php   
        
        en el caso de la gestion de la cache las diferentes opciones estan a continuacion como parametro $Ls_pathdir_cache del procedimiento gestionEjecucionInterfazSalida()  
        $Ls_pathdir_cache(string) contendr� el path del directorio cache, donde se va a crear, actualizar o consultar el fichero cache, este parametro tiene las sigientes opciones como valor:
	    	//1-'statu_procesos' es solo para los procesos appmod y crear� la cahe de datos en el directorio e_home_appmod/aplicacion actual(ejecutandose))/cache	
			//2-'adyacente' se ejecutara primero adyacente_datos y si no es posible se ejecutara adyacente_interfaz, ambas opciones se explican a continuacion  
            //3-'adyacente_datos' es para cualquier proceso y crear� la cache en el mismo directorio que se encuentra el fichero de datos si este existe y si no en el mismo directorio que se encuentra el fichero interfaz. 
			//4-'adyacente_interfaz' es para cualquier proceso y crear� la cache en el mismo directorio que se encuentra el fichero interfaz. 
			//5-'un path personalizado' y que tendr� como raiz la ubicacion del directorio que elija 
			//6-'' valor vacio que hace referencia a la no implementacion(crear, actualizar o consultar) de gestion de cache, solo se gestiona la interfaz y los datos y se debuelve el resultado
        el fichero cache creado tendra como nombre $Ls_identificativo_nombredelficherodatosointerfaz_cache.php, nombredelficherodatosointerfaz segun corresponda con lo introducido en $Ls_pathdir_cache        
        
*/   
	   
	   
	   }	   
?>