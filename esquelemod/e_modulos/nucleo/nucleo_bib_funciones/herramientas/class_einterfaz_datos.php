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
        
             private $lsPathFichInterfaz = '' ;
             
             private $lsPathBaseFicheroInterfaz = 'e_dir_interfaz_datos' ;	
             
             private $lsPathDirCache = 'adyacente' ;
				
             private $lsIniciacionInterfazDatos = null ;
			 			 
             public function iniciacionImplementacionInterfazDatos( $Ls_pathfich_interfaz = '' , $Ls_pathbase_fich_interfaz = '' , $Ls_pathdir_cache = '' )
                 {
                     $marca = null ;
                     if ( empty ( $this->lsIniciacionInterfazDatos ) )
                         {
                         	 $this->cargarObjetosDependencia('EEoNucleo', 'NucleoControl', 'Emod\Nucleo');
                         	                          	 
                         	 if ( !empty ( $Ls_pathfich_interfaz ) )
                                 {
                                     $this->lsPathFichInterfaz = $Ls_pathfich_interfaz ;
                                     $marca = true ;
                                 }
                             if ( !empty ( $Ls_pathbase_fich_interfaz ) && ( $Ls_pathbase_fich_interfaz != 'hereda' ) )
                                 {
                                 	$this->lsPathBaseFicheroInterfaz = $Ls_pathbase_fich_interfaz ;
                                 	$marca = true ;
                                 }
                             else
                                 {
                                 	$this->lsPathBaseFicheroInterfaz = $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/interfaz_datos' ;
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
			  
             
             final public function gestionEjecucionInterfazSalida ( $Ls_identificativo , $La_fich_interfaz , $La_fich_datos = null , $Ls_pathdir_cache = 'hereda' , $La_datos_complementarios = NULL )
                 {  
                     
                     $Lb_marca_fichdatos = false ;
                     $Lb_marca_fichinterfaz = false ;
                     
                     if ( empty( $Ls_identificativo ) )
                         {
                             echo '<br>Error, valor vacio en parametro $Ls_identificativo en: '.__METHOD__.'<br> ';
                             return null ;
                         }
                        
                     if ( empty( $La_fich_interfaz['Ls_pathfich_interfaz'] ) )    
                         { 
                             echo '<br>Error, valor vacio en parametro $La_fich_interfaz[\'Ls_pathfich_interfaz\'] en: '.__METHOD__.'<br> ';
                             return null ;
                         }
                     elseif ( ( ( strtolower( $La_fich_interfaz['Ls_pathfich_interfaz'] ) == 'hereda' ) || ( $La_fich_interfaz['Ls_pathfich_interfaz'] == $this->lsPathFichInterfaz ) ) && empty( $La_fich_interfaz['Ls_path_base'] ) )
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
                     elseif ( strtolower( $La_fich_interfaz['Ls_pathfich_interfaz'] ) == 'hereda' )
                     	 {
                     	 	if ( !empty( $this->lsPathFichInterfaz ) )
                     	 		{
                     	 			$La_fich_interfaz['Ls_pathfich_interfaz'] = $this->lsPathFichInterfaz ;
                     	 		}
                     	 }
                     if( !empty( $La_fich_interfaz['Ls_path_base'] ) )
                         {
                            if ( $La_fich_interfaz['Ls_path_base'] == 'hereda' )
                            	{
                            		$La_fich_interfaz['Ls_path_base'] = $this->lsPathBaseFicheroInterfaz ;
                            	}
                         	switch ( $La_fich_interfaz['Ls_path_base'] )
                            	{
                            		case	'e_dir_interfaz_datos'	:	$La_fich_interfaz['Ls_path_base'] = $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/interfaz_datos/' ;
                            											break ;
                            		case	'e_dir_proceso_ejecucion':	$La_fich_interfaz['Ls_path_base'] = $this->EEoNucleo->pathAbsolutoDirRaizProcesoEjecucion().'/' ;
                            											break ;
                            		case	'e_dir_procesos'		:	$La_fich_interfaz['Ls_path_base'] = $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/'.$this->EEoNucleo->pathDirRaizProcesos().'/' ;
                            											break ;
                            		case	'e_dir_gedees'			:	$La_fich_interfaz['Ls_path_base'] = $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/gedees/' ;
                            											break ;
                            		case 	'e_dir_esquelemod'		:	$La_fich_interfaz['Ls_path_base'] = $this->EEoNucleo->pathDirEsquelemod().'/' ;
                            											break ;
                            		case	'e_dir_modulos'			:	$La_fich_interfaz['Ls_path_base'] = $this->EEoNucleo->pathDirModulos().'/' ;
                            											break ;
                            		default							:	$La_fich_interfaz['Ls_path_base'] .= '/' ;
                             	}
                         }
                     else
                         {
                             $La_fich_interfaz['Ls_path_base'] = '' ;
                         }						                         
                         
                     
                     if ( empty( $La_fich_datos['Ls_pathfich_datos'] ) )
                         {
                             echo '<br>Atencion, valor vacio en parametro $La_fich_datos[\'Ls_pathfich_datos\'] en: '.__METHOD__.'<br> ' ;
                         } 
                     elseif ( !empty( $La_fich_datos['Ls_path_base'] ) )
                         {
                         	switch ( $La_fich_datos['Ls_path_base'] )
                         	{
                         		case	'e_dir_proceso_ejecucion':	$La_fich_datos['Ls_path_base'] = $this->EEoNucleo->pathAbsolutoDirRaizProcesoEjecucion().'/' ;
                         											break ;
                         		case	'e_dir_procesos'		:	$La_fich_datos['Ls_path_base'] = $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/'.$this->EEoNucleo->pathDirRaizProcesos().'/' ;
                         											break ;
                         		case	'e_dir_gedees'			:	$La_fich_datos['Ls_path_base'] = $this->EEoNucleo->pathDirEsquelemod().'/e_modulos/gedees/' ;
                         											break ;
                         		case 	'e_dir_esquelemod'		:	$La_fich_datos['Ls_path_base'] = $this->EEoNucleo->pathDirEsquelemod().'/' ;
                         											break ;
                         		case	'e_dir_modulos'			:	$La_fich_datos['Ls_path_base'] = $this->EEoNucleo->pathDirModulos().'/' ;
                         											break ;
                         		default							:	$La_fich_datos['Ls_path_base'] .= '/' ;
                         	}
                         }
                     else{
                     		 $La_fich_datos['Ls_path_base'] = '' ;
                     	 }    
                     
					 
                     if ( $Ls_pathdir_cache == 'hereda' )
                         {
                             $Ls_pathdir_cache = $this->lsPathDirCache ;
                         }
                     
                        
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
                         
                     if ( !empty( $Ls_pathdir_cache ) )
                         {
                             if ( !empty ( $Lb_marca_fichdatos  ) )
                                 {
                                     $Ls_pathfichreferen_datos = $Ls_pathfinal_datos ;  
                                 }
                             elseif ( !empty ( $Lb_marca_fichinterfaz  ) )
                                 {
                                     $Ls_pathfichreferen_datos = $Ls_pathfinal_interfaz ;
                                 }
								  
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
                                                                          echo '<br> Error, El fichero datos no existe en: '.__METHOD__.'<br>';
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
                             if ( !empty( $Ls_pathmutar_cache ) )
                                 {
                                     $pos_ult_apar1 = strripos ( $Ls_pathmutar_cache , '/' ) ;
                                     $Ls_pathraiz_cache = substr ( $Ls_pathmutar_cache , 0 ,$pos_ult_apar1 ) ;	 	
                                 }
                             
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
                                     $Ls_extfich_cache = 'php' ;
                                 }
                             $Ls_pathfich_cache = $Ls_pathraiz_cache.'/'.$Ls_identificativo.'_'.$Ls_idnombrefich_cache.'.'.$Ls_extfich_cache ;
							    
                         }
                     $datos_final = null ; 
                     if( !empty( $Ls_pathdir_cache ) && $this->chequeoVersionCache( $Ls_pathfichreferen_datos , $Ls_pathfich_cache ) )
                         {  
                             $datos_final = include ( $Ls_pathfich_cache ) ;
                         }
                     else 
                         {
                             if ( is_file ( $Ls_pathfinal_interfaz ) )
                                 {   
                                     $datos_final = include $Ls_pathfinal_interfaz ;
                                 }	  
                        				     	
                             if ( !empty( $Ls_pathdir_cache ) && ( empty( $Ls_pathfich_cache ) || empty( $datos_final ) || (! $this->creacionCache( $Ls_pathfich_cache , $datos_final ) ) ) )
                                 {
                                     echo '<p>Atencion, el fichero cache no pudo ser creado en:<p> '.__METHOD__.'<p>';
                                 }
                         }
                     if ( !empty ( $datos_final ) )
                         {
                             return $datos_final ;
                         }
                 
                     return null ;
                   
                 }
       }	   
?>