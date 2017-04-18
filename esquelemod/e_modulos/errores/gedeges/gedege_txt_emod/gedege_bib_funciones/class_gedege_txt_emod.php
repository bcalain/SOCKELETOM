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
   * GedegeTxtEmod class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

    namespace Emod\Nucleo\Errores\Gedege ;

    class GedegeTxtEmod
    {
        
        private $EDatosFormatoTxt = null ;
        
        
        public function __construct()
            {
                if ( \Emod\Nucleo\Herramientas::existenciaEntidad( '\Emod\Nucleo\Herramientas' , 'EDatosFormatoTxt' , 'EDatosFormatoTxt' ) )
                   {
                      $this->EDatosFormatoTxt = \Emod\Nucleo\Herramientas::entidad( '\Emod\Nucleo\Herramientas' , 'EDatosFormatoTxt' , 'EDatosFormatoTxt' ) ;
                      
                      return true ;
                   }
                else 
                    {
                    throw new \Exception('Error de instanciacion,'.__METHOD__.' no se encuentra la herramienta de clase base \Emod\Nucleo\Herramientas\EDatosFormatoTxt.');   
                    } 
            }
            
        
        public function filtrarDatosError( $La_datos_error_filtro , $La_formato_filtrado , $La_matriz_elementos_error , $tipo_error = 2 )
	        {
	            if ( !empty( $La_datos_error_filtro ) && is_array( $La_datos_error_filtro ) && !empty( $La_matriz_elementos_error['miembros_errorlog'] ) && !empty( $La_matriz_elementos_error['miembros_error'] )  && isset( $La_formato_filtrado['filtrado']['marca_ausente'] ) && ( ($tipo_error == 1) || ($tipo_error == 2) ) )
		            {
		                foreach ( $La_datos_error_filtro as $Ls_llave => &$Ls_valor )
		                    {
		                        $Ls_valor = trim( $Ls_valor ) ;
		                    }
                        $La_error_llaves = ( $tipo_error == 1 ) ? array_merge(  $La_matriz_elementos_error['miembros_errorlog'] , $La_matriz_elementos_error['miembros_error'] ) : $La_matriz_elementos_error['miembros_error'] ;
		                $La_datos_error_filtro_result = array( ) ;
	                    foreach ( $La_error_llaves as $Ls_error_llave )
			                {
                                if ( !empty( $La_datos_error_filtro[$Ls_error_llave] ) )
                                    {
                                        $La_datos_error_filtro_result[$Ls_error_llave] = trim( $La_datos_error_filtro[$Ls_error_llave] ) ;
                                    }
                                else
                                    {
                                       if ( $La_formato_filtrado['filtrado']['marca_ausente'] )
                                           {
                                               $La_datos_error_filtro_result[$Ls_error_llave] = "( $Ls_error_llave )" ;
                                           } 
                                    }
                            }
                                
                        if ( !empty( $La_datos_error_filtro_result )  )
                            {
                                return $La_datos_error_filtro_result ;
                            }
                    }
                return null ;    
	        }
            
        public function crearDatosError( $La_datos_error_filtro , $La_formato_filtrado , $La_matriz_elementos_error , $La_fuente_datos_error , $tipo_error = 2 )
	        {
	            if ( !empty( $La_datos_error_filtro ) && is_array( $La_datos_error_filtro ) && !empty( $La_matriz_elementos_error ) && !empty( $La_fuente_datos_error['path_fich_error'] ) && !empty( $La_formato_filtrado['formato']['separador'] ) && isset( $La_formato_filtrado['filtrado']['marca_ausente'] ) && ( ( $tipo_error == 1 ) || ( $tipo_error == 2 ) ) )
		            {
		            	$La_datos_error_filtro_filtrado = $this->filtrarDatosError( $La_datos_error_filtro , $La_formato_filtrado , $La_matriz_elementos_error , $tipo_error ) ;
	                    if($La_datos_error_filtro_filtrado)
                            {
                                $Ls_datos_error_linea = "\n" ;
                                end( $La_datos_error_filtro_filtrado );
                                $Ls_key_elemen_final = key( $La_datos_error_filtro_filtrado ); 
	                        	foreach ( $La_datos_error_filtro_filtrado as $key_dato_error => $valor_dato_error )
		                    		{
	                        			$Ls_datos_error_linea .= $valor_dato_error ;
	                        			if ( $key_dato_error == $Ls_key_elemen_final )
		                            		{
		                              		  break ;
		                           			}
	                        			$Ls_datos_error_linea .= $La_formato_filtrado['formato']['separador'] ;
		                    		}
 
	                        	if ( file_put_contents( $La_fuente_datos_error['path_fich_error'] , $Ls_datos_error_linea , FILE_APPEND ) )
		                    		{
		                        		return true ;
		                   			}
                            }
                    }
                return null ;    
            }
 
        public function eliminarDatosError( $La_datos_error_filtro , $La_formato_filtrado , $La_matriz_elementos_error , $La_fuente_datos_error , $tipo_error = 2 )
	        {
	            if ( !empty( $La_datos_error_filtro ) && is_array( $La_datos_error_filtro ) && !empty( $La_matriz_elementos_error ) && !empty( $La_fuente_datos_error['path_fich_error'] ) && !empty( $La_formato_filtrado['formato']['separador'] ) && ( ( $tipo_error == 1 ) || ( $tipo_error == 2 ) ) )
		            {
		                if ( empty( $La_formato_filtrado['filtrado']['llave_unica'] ) )
                            { 
                                $La_formato_filtrado['filtrado']['llave_unica'] = null ;
                            }
                        $La_error_llaves = ( $tipo_error == 1 ) ? array_merge(  $La_matriz_elementos_error['miembros_errorlog'] , $La_matriz_elementos_error['miembros_error'] ) : $La_matriz_elementos_error['miembros_error'] ;
	                    return \Emod\Nucleo\Herramientas\EDatosFormatoTxt::filtrarEliminarLineaDatos( $La_error_llaves , $La_datos_error_filtro , $La_formato_filtrado['formato']['separador'] , $La_fuente_datos_error['path_fich_error'] , $La_formato_filtrado['filtrado']['llave_unica'] ) ;
                    }
	            return null ;
            }
        
        public function leerDatosError( $La_datos_error_filtro , $La_formato_filtrado , $La_matriz_elementos_error , $La_fuente_datos_error , $tipo_error = 2 )
	        { 
	            if ( !empty( $La_datos_error_filtro ) && is_array( $La_datos_error_filtro )  && !empty( $La_matriz_elementos_error ) && !empty( $La_fuente_datos_error['path_fich_error'] ) && !empty( $La_formato_filtrado['formato']['separador'] ) && ( ( $tipo_error == 1 ) || ( $tipo_error == 2 ) ) )
		    		{
		        		if ( empty( $La_formato_filtrado['filtrado']['llave_unica'] ) )
                            { 
                                $La_formato_filtrado['filtrado']['llave_unica'] = null ;
                            }
                        $La_error_llaves = ( $tipo_error == 1 ) ? array_merge(  $La_matriz_elementos_error['miembros_errorlog'] , $La_matriz_elementos_error['miembros_error'] ) : $La_matriz_elementos_error['miembros_error'] ;
                        
                        $La_resultado = \Emod\Nucleo\Herramientas\EDatosFormatoTxt::filtrarLeerLineaDatos( $La_error_llaves , $La_datos_error_filtro , $La_formato_filtrado['formato']['separador'] , $La_fuente_datos_error['path_fich_error'] , $La_formato_filtrado['filtrado']['llave_unica'] ) ;
                        if( $La_resultado )
                            {
                                $La_resultado_datos_error = null ;
                                if ( !empty( $La_resultado ) && is_array( $La_resultado ) )
                                    {
                                        foreach ( $La_resultado as $Ls_linea_error )
                                           {
                                               $La_linea_error = explode( $La_formato_filtrado['formato']['separador'] , $Ls_linea_error ) ;
                                               $La_erreglo_combinado = null ;
                                               $La_erreglo_combinado = array_combine( $La_error_llaves, $La_linea_error ) ;
                                               if ( !empty( $La_erreglo_combinado ) )
                                                   {
                                                        $La_resultado_datos_error[] = $La_erreglo_combinado ;
                                                   }
                                           }
                                    }
                                if ( !empty( $La_resultado_datos_error ) )
                                    {
                                        return $La_resultado_datos_error ; 
                                    }
                            }
                    }
	            return NULL ;
            }
        
        public function modificarDatosError( $La_datos_error_filtro , $La_datos_sustitutos , $La_formato_filtrado , $La_matriz_elementos_error , $La_fuente_datos_error , $tipo_error = 2 )
	        {
	            if ( !empty( $La_datos_error_filtro ) && is_array( $La_datos_error_filtro ) && is_array( $La_datos_sustitutos ) && !empty( $La_datos_sustitutos ) && !empty( $La_matriz_elementos_error ) && !empty( $La_fuente_datos_error['path_fich_error'] ) && !empty( $La_formato_filtrado['formato']['separador'] ) && ( ( $tipo_error == 1 ) || ( $tipo_error == 2 ) ) )
		            {
                        if ( empty( $La_formato_filtrado['filtrado']['llave_unica'] ) )
                            { 
                                $La_formato_filtrado['filtrado']['llave_unica'] = null ;
                            }
                        $La_error_llaves = ( $tipo_error == 1 ) ? array_merge(   $La_matriz_elementos_error['miembros_errorlog'] , $La_matriz_elementos_error['miembros_error'] ) : $La_matriz_elementos_error['miembros_error'] ;
                        return \Emod\Nucleo\Herramientas\EDatosFormatoTxt::fltrarModificarLineaDatos( $La_error_llaves , $La_datos_error_filtro , $La_datos_sustitutos , $La_formato_filtrado['formato']['separador'] , $La_fuente_datos_error['path_fich_error'] , $La_formato_filtrado['filtrado']['llave_unica'] ) ;
                    }
	            return NULL ;
            }
        
        public function crearFuenteDatosError( $La_fuente_datos_error , $Ls_cadena_inicio = '' )
	        {
	            if ( file_put_contents( $La_fuente_datos_error['path_fich_error'] , $Ls_cadena_inicio ) )
		            {
		                return true ;
		            }
	            else
		            {
		                return NULL ;
		            }
	        }

        public function eliminarFuenteDatosError( $La_fuente_datos_error )
	        {
	            if ( unlink( $La_fuente_datos_error['path_fich_error'] ) )
		            {
		                return true ;
		            }
	            else
		            {
		                return NULL ;
		            }
	        }
            
        public function filtrarDatosErrorlog( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog  )
	        {
	            return $this->filtrarDatosError( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog , 1 ) ;    
            }
          
		public function crearDatosErrorLog( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog )
	        {
	            if ( !empty( $La_fuente_datos_errorlog['path_fich_errorlog'] ) )
                    {
                        $La_fuente_datos_errorlog['path_fich_error'] = $La_fuente_datos_errorlog['path_fich_errorlog'] ;
                        unset($La_fuente_datos_errorlog['path_fich_errorlog']) ;
                    }
                return $this->crearDatosError( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog , 1 ) ;    
            }
     
        public function eliminarDatosErrorLog( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog )
	        {
	            if ( !empty( $La_fuente_datos_errorlog['path_fich_errorlog'] ) )
                    {
                        $La_fuente_datos_errorlog['path_fich_error'] = $La_fuente_datos_errorlog['path_fich_errorlog'] ;
                        unset($La_fuente_datos_errorlog['path_fich_errorlog']) ;
                    }
                return $this->eliminarDatosError( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog , 1 ) ;    
            }
     
        public function leerDatosErrorLog( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog )
	        {
	            if ( !empty( $La_fuente_datos_errorlog['path_fich_errorlog'] ) )
                    {
                        $La_fuente_datos_errorlog['path_fich_error'] = $La_fuente_datos_errorlog['path_fich_errorlog'] ;
                        unset($La_fuente_datos_errorlog['path_fich_errorlog']) ;
                    }
                return $this->leerDatosError( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog , 1 ) ;    
            }    
        
        public function modificarDatosErrorLog( $La_datos_errorlog_filtro , $La_datos_sustitutos , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog )
	        {
	            if ( !empty( $La_fuente_datos_errorlog['path_fich_errorlog'] ) )
                    {
                        $La_fuente_datos_errorlog['path_fich_error'] = $La_fuente_datos_errorlog['path_fich_errorlog'] ;
                        unset($La_fuente_datos_errorlog['path_fich_errorlog']) ;
                    }
                return $this->modificarDatosError( $La_datos_errorlog_filtro , $La_datos_sustitutos , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog , 1 ) ;    
            }
        
        public function crearFuenteDatosErrorLog( $La_fuente_datos_errorlog , $Ls_cadena_inicio = '' )
	        {
	            if ( !empty( $La_fuente_datos_errorlog['path_fich_errorlog'] ) )
                    {
                        $La_fuente_datos_errorlog['path_fich_error'] = $La_fuente_datos_errorlog['path_fich_errorlog'] ;
                        unset($La_fuente_datos_errorlog['path_fich_errorlog']) ;
                    }
                return $this->crearFicheroError( $La_fuente_datos_errorlog , $Ls_cadena_inicio ) ;    
            }

        public function eliminarFuenteDatosErrorLog( $La_fuente_datos_errorlog )
	        {
	            if ( !empty( $La_fuente_datos_errorlog['path_fich_errorlog'] ) )
                    {
                        $La_fuente_datos_errorlog['path_fich_error'] = $La_fuente_datos_errorlog['path_fich_errorlog'] ;
                        unset($La_fuente_datos_errorlog['path_fich_errorlog']) ;
                    }
                return $this->eliminarFicheroError( $La_fuente_datos_errorlog ) ;    
            }
        
    }
        
?>
