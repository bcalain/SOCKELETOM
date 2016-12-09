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
                     if( !empty( $La_fich_interfaz['Ls_path_base'] ) )
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
         }	   
?>