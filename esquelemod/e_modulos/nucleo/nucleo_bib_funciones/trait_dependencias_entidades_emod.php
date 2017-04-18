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
   * DependenciasEntidadesEmod trait
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

    namespace Emod\Nucleo;

    trait DependenciasEntidadesEmod
        {
        
        protected $EEoNucleo = null ;
        protected $EEoInterfazDatos = null ;
        protected $EEoConfiguracion = null ;
        protected $EEoSeguridad = null ;
        protected $EEoDatos = null ;
        protected $EEoImplementacionProcesos = null ;
        protected $EEoErrores = null ;

        final public function cargarObjetosDependencia( $id_objeto , $class , $namespace )
            {
            if ( !empty( $id_objeto ) && ( \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace ) != null ) )
                {
                switch ( $id_objeto )
                    {
                    case 'EEoNucleo' : if ( $this->EEoNucleo == null )
                                          {
                                             $this->EEoNucleo = \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace ) ;
                                             if( empty( $this->EEoNucleo ) )
                            	               {
                            		              trigger_error("No se pudo referenciar la entidad EEoNucleo en __CLASS__", E_USER_ERROR);
                            	               }
                                             return true ;
                                          }
                                       break ;

                    case 'EEoInterfazDatos' : if ( $this->EEoInterfazDatos == null )
                                                 {
                                                    $this->EEoInterfazDatos = \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace ) ;
                                                    if( empty( $this->EEoInterfazDatos ) )
                            	                      {
                            		                     trigger_error("No se pudo referenciar la entidad EEoInterfazDatos en __CLASS__", E_USER_ERROR);
                            	                      }
                                                    return true ;
                                                 }
                                              break ;

                    case 'EEoSeguridad' : if ( $this->EEoSeguridad == null )
                                             {
                                                $this->EEoSeguridad = \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace ) ;
                                                if( empty( $this->EEoSeguridad ) )
                            	                  {	
                            		                 trigger_error("No se pudo referenciar la entidad EEoSeguridad en __CLASS__", E_USER_ERROR);
                            	                  }
                                                return true ;
                                             }
                                          break ;

                    case 'EEoConfiguracion' : if ( $this->EEoConfiguracion == null )
                                                 {
                                                    $this->EEoConfiguracion = \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace ) ;
                                                    if( empty( $this->EEoConfiguracion ) )
                            	                      {
                            		                     trigger_error("No se pudo referenciar la entidad EEoConfiguracion en __CLASS__", E_USER_ERROR);
                            	                      }
                                                    return true ;
                                                 }
                                              break ;

                    case 'EEoDatos' : if ( $this->EEoDatos == null )
                                         {
                                            $this->EEoDatos = \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace ) ;
                                            if( empty( $this->EEoDatos ) )
                            	              {
                            		             trigger_error("No se pudo referenciar la entidad EEoDatos en __CLASS__", E_USER_ERROR);
                           		              }
                                            return true ;
                                         }
                                      break ;

                    case 'EEoImplementacionProcesos' : if ( $this->EEoImplementacionProcesos == null )
                                                          {
                                                             $this->EEoImplementacionProcesos = \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace ) ;
                                                             if( empty( $this->EEoImplementacionProcesos ) )
                            	                               {
                            		                              trigger_error("No se pudo referenciar la entidad EEoImplementacionProcesos en __CLASS__", E_USER_ERROR);
                            	                               }
                                                             return true ;
                                                          }
                                                       break ;
                        
                    case 'EEoErrores' : if ( $this->EEoErrores == null )
                                           {
                                              $this->EEoErrores = \Emod\Nucleo\CropNucleo::referenciarObjeto( $id_objeto , $class , $namespace ) ;
                                              if( empty( $this->EEoErrores ) )
                            	                {
                            		               trigger_error("No se pudo referenciar la entidad EEoErrores en __CLASS__", E_USER_ERROR);
                            	                }
                                              return true ;
                                           }
                                        break ;     
                    }
                }
            return null ;
            }
      }      

?>
