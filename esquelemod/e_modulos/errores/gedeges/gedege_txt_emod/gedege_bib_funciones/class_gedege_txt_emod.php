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
        
        //esta clase trabaja directamente con una clase herramienta que hace su gestion sobre ficheros txt y esta propiedead es la que va a recivir el puntero a instancia o clase y namespace de la clase herraamienta  
        private $EDatosFormatoTxt = null ;
        
        
        //procedimiento que inicia esta clase con propiedades imprescindibles para ella
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
            
        
        // este procedimiento filtra un arreglo asociativo con pares $Ls_key=>$Ls_valor aportado por el cliente (arreglo cliente) comparandolo con un arreglo que es matriz de las $Ls_key( $La_matriz_elementos_error['miembros_errorlog'] o $La_matriz_elementos_error['miembros_error'] ) y formando un arreglo nuevo ($La_datos_error_filtro_result) con los pares $Ls_key=>$Ls_valor que coincidieron los $Ls_key del arreglo cliente y el arreglo matriz. ademas de los elementos coincidentes se recojen los elemntos que estan en la matriz pero no en el arreglo cliente y se pondra como valor el id del key entre parentesis('key')  
        // el elemento key que exista en arreglo cliente y no en la matriz, no pasa a formar parte del arreglo resultante $La_datos_error_filtro_result
	    // $La_datos_error_filtro es un arreglo con los pares $Ls_key=>$Ls_valor a filtrar.
        //$laMatrizElementosError
            //$laMatrizElementosError['miembros_errorlog']
            //propiedad que define los campos o elementos que se gestionaran para un contenedor de registros de errores, a esta propiedad siempre se le adicionan los elementos de la propiedad $La_miembro_error 
	        //un ejemplo puede ser array( 'date' , 'aplicacion' , 'modulo' , 'opcion' )
            
            //$laMatrizElementosError['miembros_error']
            //propiedad que define los campos o elementos que se gestionaran para un mensaje u otro destino de errores
	        //un ejemplo puede ser array( 'id' , 'tipo' , 'tratamiento' , 'alcance' , 'mensaje' ) 
        //$La_formato_filtrado['filtrado']['marca_ausente'] boolean, true define que si existe un elemento en $laMatrizElementosError y no existe en $La_datos_error_filtro se incorpora al arreglo resultante del filtrado, la llave entre parentesis del elemento faltante en su ubicacion      
	    // $tipo_error integer, define el arreglo matriz de keys por los que se filtraran los keiz del arreglo $La_datos_error_filtro
	    // sus posibles valores son: 1- se tomara como arreglo matriz el definido en $La_matriz_elementos_error['miembros_errorlog'], 2- se tomara como arreglo matriz el definido en $La_matriz_elementos_error['miembros_error']
	    // el orden de los elementos key del arreglo resultante $La_datos_error_filtro_result los define el orden de los elementos del arreglo matriz.    
	        
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
                //echo 'Error, se han introducido valores vac�os o incompatibles como par�metros en la funci�n . <p>' ;
		        return null ;    
	        }
            
        // este procedimiento crea una nueva linea de datos error en un fichero declarado en $La_fuente_datos_error['path_fich_error'], con una estructura determinada
	    // $La_datos_error_filtro es un arreglo con pares $key -> $valor que es recorrido para formar una linea que se adicionara al fichero error declarado en $La_fuente_datos_error['path_fich_error']
        // este arreglo es filtrado con el procedimiento $this->filtrarDatosErrores de esta clase
	    // $laMatrizElementosError
            //$laMatrizElementosError['miembros_errorlog']
            //propiedad que define los campos o elementos que se gestionaran para un contenedor de registros de errores, a esta propiedad siempre se le adicionan los elementos de la propiedad $La_miembro_error 
	        //un ejemplo puede ser array( 'date' , 'aplicacion' , 'modulo' , 'opcion' )
            
            //$laMatrizElementosError['miembros_error']
            //propiedad que define los campos o elementos que se gestionaran para un mensaje u otro destino de errores
	        //un ejemplo puede ser array( 'id' , 'tipo' , 'tratamiento' , 'alcance' , 'mensaje' ) 
        // $La_fuente_datos_error['path_fich_error'] es el path donde se encuentra el fichero a incorporar la nueva linea y en caso de no existir el fichero se intentara crear
        // $La_formato_filtrado
            // $La_formato_filtrado['filtrado']['marca_ausente'] boolean, true define que si existe un elemento en $laMatrizElementosError y no existe en $La_datos_error_filtro se incorpora al arreglo resultante del filtrado, la llave entre parentesis del elemento faltante en su ubicacion      
	        // $La_formato_filtrado['formato']['separador'] es el o los caracteres que se utilizaran como separador de los elementos de la linea de datos de error que se gurdara en el fichero correspondiente
	    // $tipo_error define el arreglo matriz de keys por los que se filtraran los keiz del arreglo $La_datos_error_filtro
	    // sus posibles valores son: 1- se tomara como arreglo matriz el definido en $La_matriz_elementos_error['miembros_errorlog'], 2- se tomara como arreglo matriz el definido en $La_matriz_elementos_error['miembros_error']
	    // este procedimiento retorna true si su gestion fue satisfactoria y null si fue insatisfactoria
        
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
		                        //echo 'El nuevo error se ha creado correctamente. <p>';
		                        return true ;
		                    }
                                }
                            }
                        //echo 'Error, se han introducido valores vacios o incompatibles como parametros en la funcion . <p>' ;
		        return null ;    
                }
 
        // este procedimiento elimina lineas del fichero que contiene los datos error, si estas lineas en su estructura de datos contienen elementos que coincidan con un grupo de datos que serviran como filtro y que se pasan a la funcion en uno de sus parametros
	    // $La_datos_error_filtro es un arreglo con los pares $llave -> $valor que hacen funcion de filtro, para eliminar las lineas de datos del fichero error, deben coincidir en la o las lineas de fichero a eliminar, puede ser un par $llave -> $valor o varios, si son varios pares $llave -> $valor como regla de filtrado para eliminar la linea de fichero, tienen que coincidir todos para que sea eliminada la linea
	    // $laMatrizElementosError
            //$laMatrizElementosError['miembros_errorlog']
            //propiedad que define los campos o elementos que se gestionaran para un contenedor de registros de errores, a esta propiedad siempre se le adicionan los elementos de la propiedad $La_miembro_error 
	        //un ejemplo puede ser array( 'date' , 'aplicacion' , 'modulo' , 'opcion' )
            
            //$laMatrizElementosError['miembros_error']
            //propiedad que define los campos o elementos que se gestionaran para un mensaje u otro destino de errores
	        //un ejemplo puede ser array( 'id' , 'tipo' , 'tratamiento' , 'alcance' , 'mensaje' ) 
        // $La_fuente_datos_error['path_fich_error'] es el path donde se encuentra el fichero al que se hara el filtrado
        // $La_formato_filtrado
            // $La_formato_filtrado['formato']['separador'] stream, es el string separador de los elemento de la linea del fichero txt
            // $La_formato_filtrado['filtrado']['llave_unica'] stream, define una llave de las contenidas en el arreglo $La_datos_error_filtro como condicion para que cuando esta llave y su valor sean encontrados en la linea del txt, se detenga la busqueda por las lineas restantes del fichero, es decir se detenga el proceso de filtrado y se pase al termino de la gestion de este procedimiento
            // si su valor es vacio no se tomara en cuenta como condicion, esta llave puede estar sola o acompanada de otras en $La_datos_error_filtro
        // $tipo_error define el arreglo matriz de keys por los que se filtraran las lineas del fichero $La_fuente_datos_error['path_fich_error']
	    // sus posibles valores son: 1- se tomara como arreglo matriz el definido en $La_matriz_elementos_error['miembros_errorlog'], 2- se tomara como arreglo matriz el definido en $La_matriz_elementos_error['miembros_error']
	    // retorna true si encuentra elemento al que aplicar la condicion de filtrado y lo realiza satisfactoriamente
        // retorna false si encuentra elemento al que aplicar la condicion de filtrado y no le es posible realizar los cambios en el fichero o no encuentra elemento al que aplicar la condicion de filtrado.
        // retorna null si se le pasan valores incompatibles a los parametros del procedimiento
        
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
	            //echo 'Error, se han introducido valores incompatibles como parametros en la funcion . <p>' ;
		        return null ;
            }
        
        // este procedimiento lee lineas del fichero que contiene los datos error, si estas lineas en su estructura de datos contienen elementos que coincidan con un grupo de datos que serviran como filtro y que se pasan a la funcion en uno de sus parametros
	    // $La_datos_error_filtro es un arreglo con los pares $llave -> $valor que hacen funcion de filtro, para leer las lineas de datos del fichero error, deben coincidir en la o las lineas de fichero a eliminar, puede ser un par $llave -> $valor o varios, si son varios pares $llave -> $valor como regla de filtrado para leer la linea de fichero, tienen que coincidir todos para que sea leida la linea
	    // $laMatrizElementosError
            //$laMatrizElementosError['miembros_errorlog']
            //propiedad que define los campos o elementos que se gestionaran para un contenedor de registros de errores, a esta propiedad siempre se le adicionan los elementos de la propiedad $La_miembro_error 
	        //un ejemplo puede ser array( 'date' , 'aplicacion' , 'modulo' , 'opcion' )
            
            //$laMatrizElementosError['miembros_error']
            //propiedad que define los campos o elementos que se gestionaran para un mensaje u otro destino de errores
	        //un ejemplo puede ser array( 'id' , 'tipo' , 'tratamiento' , 'alcance' , 'mensaje' ) 
        // $La_fuente_datos_error['path_fich_error'] es el path donde se encuentra el fichero al que se hara el filtrado
        // $La_formato_filtrado
            // $La_formato_filtrado['formato']['separador'] stream, es el string separador de los elemento de la linea del fichero txt
            // $La_formato_filtrado['filtrado']['llave_unica'] stream, define una llave de las contenidas en el arreglo $La_datos_error_filtro como condicion para que cuando esta llave y su valor sean encontrados en la linea del txt, se detenga la busqueda por las lineas restantes del fichero, es decir se detenga el proceso de filtrado y se pase al termino de la gestion de este procedimiento
            // si su valor es vacio no se tomara en cuenta como condicion, esta llave puede estar sola o acompanada de otras en $La_datos_error_filtro
        // $tipo_error define el arreglo matriz de keys por los que se filtraran las lineas del fichero $La_fuente_datos_error['path_fich_error']
	    // sus posibles valores son: 1- se tomara como arreglo matriz el definido en $La_matriz_elementos_error['miembros_errorlog'], 2- se tomara como arreglo matriz el definido en $La_matriz_elementos_error['miembros_error']
	    // retorna arreglo multidimencional donde el primer nivel de llaves o  indices es de tipo numerico automatico y en cada uno de estos elementos si existira un arreglo asociativo(con idices o llaves de tipo string) donde cada uno de sus elementos contendra como valor un string correspondiente con las secciones o propiedades que contenian las lineas del txt que coincidieron con el filtrado, cada arreglo contenido en los indices numericos representa los datos de una linea del txt que coincidieron con el filtrado
        // retorna null si se le pasan valores incompatibles a los parametros del procedimiento
        
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
	            //echo 'Error, se han introducido valores incompatibles como parametros en la funcion . <p>' ;
		    return NULL ;
                }
        
        // este procedimiento modifica lineas del fichero datos error si estas coinciden con la regla de filtrado
	    // $La_datos_error_filtro es un arreglo con los pares $llave -> $valor que hacen funcion de filtro, para modificar las lineas de datos del fichero error, deben coincidir en la o las lineas de fichero a eliminar, puede ser un par $llave -> $valor o varios, si son varios pares $llave -> $valor como regla de filtrado para modificar la linea de fichero, tienen que coincidir todos para que sea modificada la linea
	    // (importante) en caso de querer modificar valores en todas las lineas del fichero, este par�metro soporta el valor '*', que le indica al procedimiento que realize la sustituci�n en todas las lineas del fichero sin hacer filtrado
        // $La_datos_sustitutos es un arreglo con los pares $llave -> $valor que se sustituiran en la linea del txt si coincide la combinacion de filtrado, estos pares pueden o no ser parte de los pares de la combinacion de filtrado
        // $laMatrizElementosError
            //$laMatrizElementosError['miembros_errorlog']
            //propiedad que define los campos o elementos que se gestionaran para un contenedor de registros de errores, a esta propiedad siempre se le adicionan los elementos de la propiedad $La_miembro_error 
	        //un ejemplo puede ser array( 'date' , 'aplicacion' , 'modulo' , 'opcion' )
            
            //$laMatrizElementosError['miembros_error']
            //propiedad que define los campos o elementos que se gestionaran para un mensaje u otro destino de errores
	        //un ejemplo puede ser array( 'id' , 'tipo' , 'tratamiento' , 'alcance' , 'mensaje' ) 
        // $La_fuente_datos_error['path_fich_error'] es el path donde se encuentra el fichero al que se hara el filtrado
        // $La_formato_filtrado
            // $La_formato_filtrado['formato']['separador'] stream, es el string separador de los elemento de la linea del fichero txt
            // $La_formato_filtrado['filtrado']['llave_unica'] stream, define una llave de las contenidas en el arreglo $La_datos_error_filtro como condicion para que cuando esta llave y su valor sean encontrados en la linea del txt, se detenga la busqueda por las lineas restantes del fichero, es decir se detenga el proceso de filtrado y se pase al termino de la gestion de este procedimiento
            // si su valor es vacio no se tomara en cuenta como condicion, esta llave puede estar sola o acompanada de otras en $La_datos_error_filtro
        // $tipo_error define el arreglo matriz de keys por los que se filtraran las lineas del fichero $La_fuente_datos_error['path_fich_error']
	    // sus posibles valores son: 1- se tomara como arreglo matriz el definido en $La_matriz_elementos_error['miembros_errorlog'], 2- se tomara como arreglo matriz el definido en $La_matriz_elementos_error['miembros_error']
	    // retorna true si encuentra elemento al que aplicar la condicion de filtrado y lo realiza satisfactoriamente
        // retorna false si encuentra elemento al que aplicar la condicion de filtrado y no le es posible realizar los cambios en el fichero o no encuentra elemento al que aplicar la condicion de filtrado.
        // retorna null si se le pasan valores incompatibles a los parametros del procedimiento
        
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
	            //echo 'Error, se han introducido valores incompatibles como parametros en la funcion . <p>' ;
		        return NULL ;
            }
        
        // este procedimiento crea un fichero contenedor de datos error
	    // $La_fuente_datos_error['path_fich_error'] path del fichero error a crear
	    // $Ls_cadena_inicio cadena a escribir en el fichero error,cadena que conforma el cuerpo del fichero error, este procedimiento trabaja con la funcion file_put_contents de php
	    // este procedimiento retorna true si su gestion fue satisfactoria y null si fue insatisfactoria

	    public function crearFuenteDatosError( $La_fuente_datos_error , $Ls_cadena_inicio = '' )
	        {
	            if ( file_put_contents( $La_fuente_datos_error['path_fich_error'] , $Ls_cadena_inicio ) )
		            {
		                //echo 'El fichero error se crea satisfactoriamente. <p>' ;
		                return true ;
		            }
	            else
		            {
		                //echo 'No se pudo crear el fichero error. <p>' ;
		                return NULL ;
		            }
	        }

        // este procedimiento elimina un fichero error
	    // $La_fuente_datos_error['path_fich_error'] es el path del fichero a eliminar
	    // este procedimiento retorna true si su gestion fue satisfactoria y null si fue insatisfactoria

	    public function eliminarFuenteDatosError( $La_fuente_datos_error )
	        {
	            if ( unlink( $La_fuente_datos_error['path_fich_error'] ) )
		            {
		                //echo 'El fichero error se elimino satisfactoriamente. <p>' ;
		                return true ;
		            }
	            else
		            {
		                //echo 'No se pudo eliminar el fichero error. <p>' ;
		                return NULL ;
		            }
	        }
            
           
        /////////////////////////////////////////////////////////////////////////////////////////////////
            
        // este procedimiento filtra un arreglo asociativo con pares $Ls_key=>$Ls_valor aportado por el cliente (arreglo cliente) comparandolo con un arreglo que es matriz de las $Ls_key( $laMatrizElementosErrorlog ) y formando un arreglo nuevo ($La_datos_error_filtro_result) con los pares $Ls_key=>$Ls_valor que coincidieron los $Ls_key del arreglo cliente y el arreglo matriz. ademas de los elementos coincidentes se recojen los elemntos que estan en la matriz pero no en el arreglo cliente y se pondra como valor el id del key entre parentesis('key')  
        // el elemento key que exista en arreglo cliente y no en la matriz, no pasa a formar parte del arreglo resultante $La_datos_error_filtro_result
	    // $La_datos_errorlog_filtro es un arreglo con los pares $Ls_key=>$Ls_valor a filtrar.
	    // el orden de los elementos key del arreglo resultante $La_datos_error_filtro_result los define el orden de los elementos del arreglo matriz.    
	    //$laMatrizElementosErrorlog
            //$laMatrizElementosErrorlog['miembros_errorlog']
            //propiedad que define los campos o elementos que se gestionaran para un contenedor de registros de errores, a esta propiedad siempre se le adicionan los elementos de la propiedad $La_miembro_error 
	        //un ejemplo puede ser array( 'date' , 'aplicacion' , 'modulo' , 'opcion' )
            
            //$laMatrizElementosErrorlog['miembros_error']
            //propiedad que define los campos o elementos que se gestionaran para un mensaje u otro destino de errores
	        //un ejemplo puede ser array( 'id' , 'tipo' , 'tratamiento' , 'alcance' , 'mensaje' ) 
        //$La_formato_filtrado['filtrado']['marca_ausente'] boolean, true define que si existe un elemento en $laMatrizElementosError y no existe en $La_datos_errorlog_filtro se incorpora al arreglo resultante del filtrado, la llave entre parentesis del elemento faltante en su ubicacion      
	        
        public function filtrarDatosErrorlog( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog  )
	        {
	            return $this->filtrarDatosError( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog , 1 ) ;    
            }
          

        // este procedimiento crea una nueva linea de datos errorlog en un fichero declarado en $La_fuente_datos_errorlog['path_fich_errorlog'], con una estructura determinada
	    // $La_datos_errorlog_filtro es un arreglo con pares $key -> $valor que es recorrido para formar una linea que se adicionara al fichero errorlog declarado en $La_fuente_datos_errorlog['path_fich_errorlog']
        // este arreglo es filtrado con el procedimiento $this->filtrarDatosErrores de esta clase
	    //$laMatrizElementosErrorlog
            //$laMatrizElementosErrorlog['miembros_errorlog']
            //propiedad que define los campos o elementos que se gestionaran para un contenedor de registros de errores, a esta propiedad siempre se le adicionan los elementos de la propiedad $La_miembro_error 
	        //un ejemplo puede ser array( 'date' , 'aplicacion' , 'modulo' , 'opcion' )
            
            //$laMatrizElementosErrorlog['miembros_error']
            //propiedad que define los campos o elementos que se gestionaran para un mensaje u otro destino de errores
	        //un ejemplo puede ser array( 'id' , 'tipo' , 'tratamiento' , 'alcance' , 'mensaje' ) 
        // $La_fuente_datos_errorlog['path_fich_errorlog'] es el path donde se encuentra el fichero a incorporar la nueva linea y en caso de no existir el fichero se intentara crear
        // $La_formato_filtrado
            // $La_formato_filtrado['filtrado']['marca_ausente'] boolean, true define que si existe un elemento en $laMatrizElementosErrorlog y no existe en $La_datos_errorlog_filtro se incorpora al arreglo resultante del filtrado, la llave entre parentesis del elemento faltante en su ubicacion      
	        // $La_formato_filtrado['formato']['separador'] es el o los caracteres que se utilizaran como separador de los elementos de la linea de datos de errorlog que se gurdara en el fichero correspondiente
	    // este procedimiento retorna true si su gestion fue satisfactoria y null si fue insatisfactoria
         
        
	    public function crearDatosErrorLog( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog )
	        {
	            if ( !empty( $La_fuente_datos_errorlog['path_fich_errorlog'] ) )
                    {
                        $La_fuente_datos_errorlog['path_fich_error'] = $La_fuente_datos_errorlog['path_fich_errorlog'] ;
                        unset($La_fuente_datos_errorlog['path_fich_errorlog']) ;
                    }
                return $this->crearDatosError( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog , 1 ) ;    
            }
     
        // este procedimiento elimina lineas del fichero que contiene los datos errorlog, si estas lineas en su estructura de datos contienen elementos que coincidan con un grupo de datos que serviran como filtro y que se pasan a la funcion en uno de sus parametros
	    // $La_datos_errorlog_filtro es un arreglo con los pares $llave -> $valor que hacen funcion de filtro, para eliminar las lineas de datos del fichero errorlog, deben coincidir en la o las lineas de fichero a eliminar, puede ser un par $llave -> $valor o varios, si son varios pares $llave -> $valor como regla de filtrado para eliminar la linea de fichero, tienen que coincidir todos para que sea eliminada la linea
	    //$laMatrizElementosErrorlog
            //$laMatrizElementosErrorlog['miembros_errorlog']
            //propiedad que define los campos o elementos que se gestionaran para un contenedor de registros de errores, a esta propiedad siempre se le adicionan los elementos de la propiedad $La_miembro_error 
	        //un ejemplo puede ser array( 'date' , 'aplicacion' , 'modulo' , 'opcion' )
            
            //$laMatrizElementosErrorlog['miembros_error']
            //propiedad que define los campos o elementos que se gestionaran para un mensaje u otro destino de errores
	        //un ejemplo puede ser array( 'id' , 'tipo' , 'tratamiento' , 'alcance' , 'mensaje' ) 
        // $La_fuente_datos_errorlog['path_fich_errorlog'] es el path donde se encuentra el fichero a eliminar los datos 
        // $La_formato_filtrado
            // $La_formato_filtrado['formato']['separador'] es el o los caracteres que se utilizaran como separador de los elementos de la linea de datos de errorlog que se gurdara en el fichero correspondiente
            // $La_formato_filtrado['filtrado']['llave_unica'] stream, define una llave de las contenidas en el arreglo $La_datos_errorlog_filtro como condicion para que cuando esta llave y su valor sean encontrados en la linea del txt, se detenga la busqueda por las lineas restantes del fichero, es decir se detenga el proceso de filtrado y se pase al termino de la gestion de este procedimiento
            // si su valor es vacio no se tomara en cuenta como condicion, esta llave puede estar sola o acompanada de otras en $La_datos_errorlog_filtro
        // retorna true si encuentra elemento al que aplicar la condicion de filtrado y lo realiza satisfactoriamente
        // retorna false si encuentra elemento al que aplicar la condicion de filtrado y no le es posible realizar los cambios en el fichero o no encuentra elemento al que aplicar la condicion de filtrado.
        // retorna null si se le pasan valores incompatibles a los parametros del procedimiento
        // es obligatorio que antes de ejecutar este procedimiento se halla ejecutado el procedimiento matrizFiltroErrores de esta clase, de lo contrario este procedimiento retornara null 
        
	    public function eliminarDatosErrorLog( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog )
	        {
	            if ( !empty( $La_fuente_datos_errorlog['path_fich_errorlog'] ) )
                    {
                        $La_fuente_datos_errorlog['path_fich_error'] = $La_fuente_datos_errorlog['path_fich_errorlog'] ;
                        unset($La_fuente_datos_errorlog['path_fich_errorlog']) ;
                    }
                return $this->eliminarDatosError( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog , 1 ) ;    
            }
     
        // este procedimiento lee lineas del fichero que contiene los datos errorlog, si estas lineas en su estructura de datos contienen elementos que coincidan con un grupo de datos que serviran como filtro y que se pasan a la funcion en uno de sus parametros
	    // $La_datos_errorlog_filtro es un arreglo con los pares $llave -> $valor que hacen funcion de filtro, para leer las lineas de datos del fichero errorlog, deben coincidir en la o las lineas de fichero a leer, puede ser un par $llave -> $valor o varios, si son varios pares $llave -> $valor como regla de filtrado para leer la linea de fichero, tienen que coincidir todos para que sea leida la linea
	    //$laMatrizElementosErrorlog
            //$laMatrizElementosErrorlog['miembros_errorlog']
            //propiedad que define los campos o elementos que se gestionaran para un contenedor de registros de errores, a esta propiedad siempre se le adicionan los elementos de la propiedad $La_miembro_error 
	        //un ejemplo puede ser array( 'date' , 'aplicacion' , 'modulo' , 'opcion' )
            
            //$laMatrizElementosErrorlog['miembros_error']
            //propiedad que define los campos o elementos que se gestionaran para un mensaje u otro destino de errores
	        //un ejemplo puede ser array( 'id' , 'tipo' , 'tratamiento' , 'alcance' , 'mensaje' ) 
        // $La_fuente_datos_errorlog['path_fich_errorlog'] es el path donde se encuentra el fichero a leer los datos 
        // $La_formato_filtrado
            // $La_formato_filtrado['formato']['separador'] es el o los caracteres que se utilizaran como separador de los elementos de la linea de datos de errorlog que se leera en el fichero correspondiente
            // $La_formato_filtrado['filtrado']['llave_unica'] stream, define una llave de las contenidas en el arreglo $La_datos_errorlog_filtro como condicion para que cuando esta llave y su valor sean encontrados en la linea del txt, se detenga la busqueda por las lineas restantes del fichero, es decir se detenga el proceso de filtrado y se pase al termino de la gestion de este procedimiento
            // si su valor es vacio no se tomara en cuenta como condicion, esta llave puede estar sola o acompanada de otras en $La_datos_errorlog_filtro
        // retorna arreglo no asociativo donde cada uno de sus elementos contendra como valor un string que seran las lineas del txt que coincidieron con el filtrado
        // retorna false si encuentra elemento al que aplicar la condicion de filtrado y no le es posible realizar los cambios en el fichero o no encuentra elemento al que aplicar la condicion de filtrado.
        // retorna null si se le pasan valores incompatibles a los parametros del procedimiento
        // es obligatorio que antes de ejecutar este procedimiento se halla ejecutado el procedimiento matrizFiltroErrores de esta clase, de lo contrario este procedimiento retornara null 
        
	    public function leerDatosErrorLog( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog )
	        {
	            if ( !empty( $La_fuente_datos_errorlog['path_fich_errorlog'] ) )
                    {
                        $La_fuente_datos_errorlog['path_fich_error'] = $La_fuente_datos_errorlog['path_fich_errorlog'] ;
                        unset($La_fuente_datos_errorlog['path_fich_errorlog']) ;
                    }
                return $this->leerDatosError( $La_datos_errorlog_filtro , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog , 1 ) ;    
            }    
        
        // este procedimiento modifica lineas del fichero datos errorlog si estas coinciden con la regla de filtrado
	    // $La_datos_errorlog_filtro es un arreglo con los pares $llave -> $valor que hacen funcion de filtro, para modificar las lineas de datos del fichero errorlog, deben coincidir en la o las lineas de fichero a modificar, puede ser un par $llave -> $valor o varios, si son varios pares $llave -> $valor como regla de filtrado para modificar la linea de fichero, tienen que coincidir todos para que sea modificada la linea
	    // (importante) en caso de querer modificar valores en todas las lineas del fichero, este par�metro soporta el valor '*', que le indica al procedimiento que realize la sustituci�n en todas las lineas del fichero sin hacer filtrado
        // $La_datos_sustitutos es un arreglo con los pares $llave -> $valor que se sustituiran en la linea del txt si coincide la combinacion de filtrado, estos pares pueden o no ser parte de los pares de la combinacion de filtrado
        //$laMatrizElementosErrorlog
            //$laMatrizElementosErrorlog['miembros_errorlog']
            //propiedad que define los campos o elementos que se gestionaran para un contenedor de registros de errores, a esta propiedad siempre se le adicionan los elementos de la propiedad $La_miembro_error 
	        //un ejemplo puede ser array( 'date' , 'aplicacion' , 'modulo' , 'opcion' )
            
            //$laMatrizElementosErrorlog['miembros_error']
            //propiedad que define los campos o elementos que se gestionaran para un mensaje u otro destino de errores
	        //un ejemplo puede ser array( 'id' , 'tipo' , 'tratamiento' , 'alcance' , 'mensaje' ) 
        // $La_fuente_datos_errorlog['path_fich_errorlog'] es el path donde se encuentra el fichero a modificar los datos 
        // $La_formato_filtrado
            // $La_formato_filtrado['formato']['separador'] es el o los caracteres que se utilizaran como separador de los elementos de la linea de datos de errorlog que se modificara en el fichero correspondiente
            // $La_formato_filtrado['filtrado']['llave_unica'] stream, define una llave de las contenidas en el arreglo $La_datos_errorlog_filtro como condicion para que cuando esta llave y su valor sean encontrados en la linea del txt, se detenga la busqueda por las lineas restantes del fichero, es decir se detenga el proceso de filtrado y se pase al termino de la gestion de este procedimiento
            // si su valor es vacio no se tomara en cuenta como condicion, esta llave puede estar sola o acompanada de otras en $La_datos_errorlog_filtro
        // retorna true si encuentra elemento al que aplicar la condicion de filtrado y lo realiza satisfactoriamente
        // retorna false si encuentra elemento al que aplicar la condicion de filtrado y no le es posible realizar los cambios en el fichero o no encuentra elemento al que aplicar la condicion de filtrado.
        // retorna null si se le pasan valores incompatibles a los parametros del procedimiento
        // es obligatorio que antes de ejecutar este procedimiento se halla ejecutado el procedimiento matrizFiltroErrores de esta clase, de lo contrario este procedimiento retornara null 
        
	    public function modificarDatosErrorLog( $La_datos_errorlog_filtro , $La_datos_sustitutos , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog )
	        {
	            if ( !empty( $La_fuente_datos_errorlog['path_fich_errorlog'] ) )
                    {
                        $La_fuente_datos_errorlog['path_fich_error'] = $La_fuente_datos_errorlog['path_fich_errorlog'] ;
                        unset($La_fuente_datos_errorlog['path_fich_errorlog']) ;
                    }
                return $this->modificarDatosError( $La_datos_errorlog_filtro , $La_datos_sustitutos , $La_formato_filtrado , $La_matriz_elementos_errorlog , $La_fuente_datos_errorlog , 1 ) ;    
            }
        
        // este procedimiento crea un fichero contenedor de datos errorlog
	    // $La_fuente_datos_errorlog['path_fich_errorlog'] path del fichero errorlog a crear
	    // $Ls_cadena_inicio cadena a escribir en el fichero errorlog,cadena que conforma el cuerpo del fichero errorlog, este procedimiento trabaja con la funcion file_put_contents de php
	    // este procedimiento retorna true si su gestion fue satisfactoria y null si fue insatisfactoria

	    public function crearFuenteDatosErrorLog( $La_fuente_datos_errorlog , $Ls_cadena_inicio = '' )
	        {
	            if ( !empty( $La_fuente_datos_errorlog['path_fich_errorlog'] ) )
                    {
                        $La_fuente_datos_errorlog['path_fich_error'] = $La_fuente_datos_errorlog['path_fich_errorlog'] ;
                        unset($La_fuente_datos_errorlog['path_fich_errorlog']) ;
                    }
                return $this->crearFicheroError( $La_fuente_datos_errorlog , $Ls_cadena_inicio ) ;    
            }

        // este procedimiento elimina un fichero errorlog
	    // $La_fuente_datos_errorlog['path_fich_errorlog'] es el path del fichero a eliminar
	    // este procedimiento retorna true si su gestion fue satisfactoria y null si fue insatisfactoria

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
