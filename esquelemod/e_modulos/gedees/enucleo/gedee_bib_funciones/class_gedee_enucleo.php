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
   * GedeeENucleo class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

    namespace Emod\Nucleo\Gedees ;

    // clase parte o herramienta del nucleo esquelemod para gestionar cada dato de los diferentes espacios representados por las diferentes entidades que forman el nucleo del esquelemod
    class GedeeENucleo
        {

        //esta clase no tiene contenedor de datos propio, solo trabaja sobre estructuras de datos que se le asignan por parametros en los distintos procedimientos, las diferentes estructuras de datos que ejemplificaremos en cada seccion, son las formas que asumira esta clase para el tratamiento a los datos que le facilitaran 
        //objetos entidades del nucleo del esquelemod y que seran utilizados por los procedimientos de esta clase 
        static private $EEoNucleo = null ;
        static private $EEoSeguridad = null ;
        
        static private $classIniciacion = null ;
        
        static public function iniciarParametrosBase()
            {
            if ( empty( self::$classIniciacion ) && empty( self::$EEoNucleo ) && empty( self::$EEoSeguridad ) )
                {
                $EEoNucleo = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoNucleo' , 'NucleoControl' , 'Emod\Nucleo' ) ;
                $EEoSeguridad = \Emod\Nucleo\CropNucleo::referenciarObjeto( 'EEoSeguridad' , 'SeguridadProcesos' , 'Emod\Nucleo' ) ;
                if ( is_object( $EEoNucleo ) && is_object( $EEoSeguridad ) )
                    {
                    self::$EEoNucleo = $EEoNucleo ;
                    self::$EEoSeguridad = $EEoSeguridad ;
                    self::$classIniciacion = true ;
                    return true ;
                    }
                }
            return null ;
            }

        /* a continuacion una modalidad de seguridad que pudiera utilizarse

          //procedimiento para inicializar el parametro_seguridad_cliente, recibe el valor del parametro de seguridad conque comparara cada peticion siguiente
          //$parametro_seguridad_cliente variable de seguridad del proceso enucleo para la comunicacion de este con esta clase
          static public function inicializar_parametro_seguridad_cliente ( $parametro_seguridad_cliente )
          {
          if ( !empty( self::$classIniciacion ) && empty( self::$parametro_seguridad_cliente ) && !empty( $parametro_seguridad_cliente ) )
          {
          self::$parametro_seguridad_cliente = $parametro_seguridad_cliente ;
          return true ;
          }
          return null ;
          }

          //este procedimiento chequea si el que pide los servicios de un procedimiento de esta clase esta autorizado para hacerlo
          //$parametro_seguridad_cliente variable de seguridad del proceso enucleo para la comunicacion de este con esta clase
          static private function chequearSeguridadCliente ( $parametro_seguridad_cliente )
          {
          if ( !empty( self::$classIniciacion ) && !empty( self::$parametro_seguridad_cliente ) && !empty( $parametro_seguridad_cliente ) && ( $parametro_seguridad_cliente == self::$parametro_seguridad_cliente ) )
          {
          return true ;
          }
          return null ;
          }
         */

        //este procedimiento chequea si el que pide los servicios de un procedimiento de esta clase esta autorizado para hacerlo
        //$parametro_seguridad_cliente variable de seguridad del proceso enucleo para la comunicacion de este con esta clase 
        static private function chequearSeguridadCliente()
            {
            if ( !empty( self::$classIniciacion ) && ( self::$EEoNucleo->namespaceGedeeProcesoEjecucion() == self::$EEoNucleo->namespaceGedeeProcesoNucleo() ) && ( self::$EEoNucleo->claseGedeeProcesoEjecucion() == self::$EEoNucleo->claseGedeeProcesoNucleo() ) )
                {
                return true ;
                }
            return null ;
            }

        //procedimiento para buscar la existencia de un idproceso en los datos de seguridad
        //id_proceso lo toma automaticamente la funcion del id del nucleo en ese momento, es el identificador del proceso nucleo a nuevo ingreso de sus datos, si su valor es vacio el procedimiento retorna el valor null 
        //$fuente_datos_procesos es la estructura de datos donde se buscara la existencia del id_proceso, se trabaja sobre esta estructura por referencia no por valor, y se le dara tratamiento de tipo como un arreglo 
        //este procedimiento retorna true si la operacion es satisfactoria y null si es insatisfactoria

        static public function existenciaIdProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' )
            {
            if ( self::chequearSeguridadCliente() && !empty( $fuente_datos_procesos ) && !empty( $id_proceso ) )
                {
                if ( ( $id_proceso == 'hereda' ) )
                    {
                    $id_proceso = self::$EEoNucleo->idProcesoEjecucion() ;
                    }
                if ( !empty( $fuente_datos_procesos[ self::$EEoNucleo->namespaceGedeeProcesoNucleo() ][ self::$EEoNucleo->claseGedeeProcesoNucleo() ][ $id_proceso ] ) )
                    {
                    return true ;
                    }
                }
            return null ;
            }

        //procedimiento para crear o inicializar un nuevo espacio de datos perteneciente al proceso actual (ejecutandose)
        //El id_proceso para la inicializacion de los datos lo toma automaticamente la funcion del id del nucleo en ese momento, es el identificador del proceso nucleo a nuevo ingreso de sus datos, si su valor es vacio el procedimiento retorna el valor null 
        //$fuente_datos_procesos es la estructura de datos a la que se incrementaran los datos de esta inicializacion, se trabaja sobre esta estructura por referencia no por valor, y se le dara tratamiento de tipo como un arreglo 
        //$datos es la estructura de datos a guardar, no olvidar que esta debe ajustarse a una estructura preconsevida para esta clase, sino algunas de sus prestaciones no funcionaran con la estructura de datos atipica, si su valor es vacio el procedimiento retorna el valor null 
        //este procedimiento utiliza un procedimiento del objeto $EEoNucleo a travez de $this->EEoNucleo
        //este procedimiento retorna true si la operacion es satisfactoria y null si es insatisfactoria
        static public function iniciarDatosProceso( &$fuente_datos_procesos , $datos )
            {
            if ( self::chequearSeguridadCliente() && !empty( $datos ) && isset( $fuente_datos_procesos ) )
                {
                $namespace_gedee_proceso_nucleo = self::$EEoNucleo->namespaceGedeeProcesoNucleo() ;
                $clase_gedee_proceso_nucleo = self::$EEoNucleo->claseGedeeProcesoNucleo() ;
                $id_proceso_nucleo = self::$EEoNucleo->idProcesoNucleo() ;

                if ( !self::existenciaIdProceso( $fuente_datos_procesos , $id_proceso_nucleo ) )
                    {
                    $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso_nucleo ] = $datos ;
                    return true ;
                    }
                }
            return null ;
            }

//////////////////////////////////// pocedimientos referentes a class ConfiguracionProcesos /////////////////////////////////////////////////////////////////
//a continuacion un ejemplo de la estructura de datos que consibe este gedee para la configuracion
//['id_proceso' = identificador del proceso] = 'datos_configuracion' = arreglo con datos de configuracion
//procedimiento para crear o inicializar un nuevo espacio de configuracion perteneciente al proceso actual (ejecutandose)
//El id_proceso para la inicializacion de los datos lo toma automaticamente la funcion del id del nucleo en ese momento, es el identificador del proceso nucleo a nuevo ingreso de sus datos, si su valor es vacio el procedimiento retorna el valor null 
//$fuente_datos_procesos es la estructura de datos a la que se incrementaran los datos de esta inicializacion, se trabaja sobre esta estructura por referencia no por valor, y se le dara tratamiento de tipo como un arreglo 
//$datos_configuracion es la estructura de datos de la configuracion a guardar, no olvidar que esta debe ajustarse a una estructura preconsevida para esta clase, sino algunas de sus prestaciones no funcionaran con la estructura de datos atipica, si su valor es vacio el procedimiento retorna el valor null 
//este procedimiento utiliza un procedimiento del objeto $EEoNucleo a travez de $this->EEoNucleo
//este procedimiento retorna true si la operacion es satisfactoria y null si es insatisfactoria
        static public function iniciarDatosConfiguracionProceso( &$fuente_datos_procesos , $datos_configuracion )
            {
            return self::iniciarDatosProceso( $fuente_datos_procesos , $datos_configuracion ) ;
            }

//procedimiento para modificar los datos de la configuracion de un proceso nucleo, para ello deberan cumplrse las siguientes condiciones
// - existir una seccion de configuracion del proceso al que se quieren modificar los datos en el parametro  $fuente_datos_procesos que se requiere en este mismo procedimiento
// - existir el id del proceso nucleo que ejecuta este procedimiento en la estructura $fuente_datos_procesos = array('id_proceso_cliente1' ,que se requiere en este mismo procedimiento 
//id_proceso es el identificador del proceso nucleo al que se quieren modificar los datos de configuracion, si el valor de este parametro es vacio el procedimiento retorna el valor null, 
//$fuente_datos_procesos es la estructura de datos a la que se accedera , se trabaja sobre esta estructura por referencia no por valor, y se le dara tratamiento de tipo como un arreglo
//$estructura_acceder //
//para valor 1 del parametro $tipo_accion (referencia) este puede contener un arreglo vacio para obtener todo el arreglo perteneciente al arreglo $datos_seguridad_procesos[id_proceso], array() un arreglo vacio es por defecto el valor que tiene, o se puede acceder solo a una parte de su estructura si se le da el valor a este parametro de una cadena con la esrtuctura a la que se quiere acceder, ejemlpo '[acceso_seguridad][procesos]' y el debolvera el elemento $datos_seguridad_procesos[id_proceso][acceso_seguridad][procesos], todo esto en dependencia de los permisos de acceso a esta estructura del proceso cliente 
//para valores 2 y 3 del parametro $tipo_accion (referencia) es un arreglo asociativo con los elementos que se quieren eliminar o modificar en el arreglo $datos_seguridad_procesos[id_proceso],
// esta matriz contendra la estructura exacta en la que se encuentra el elemento que se quiere eliminar o modificar,
// es como un mapa, una imagen de la matriz y su rama o elemento que se quiere eliminar o modificar, llamemosle de ahora en adelante "estructura imagen"
// en caso de que toda una rama del arreglo se quiera eliminar basta con poner 'elemento'=array() y se eliminara ese elemento junto a la rama que el constitulle,
// el primer elemento del arreglo $La_elementos ser� el primer elemento a buscar en el arreglo $datos_seguridad_procesos[id_proceso] , y as� sucecivamente.
// si su valor es vacio el procedimiento retorna el valor null
//$parametro_seguridad_cliente variable de seguridad del proceso enucleo para la comunicacion de este con esta clase
//$tipo_accion es el tipo de modificacion que se utilizara con los posibles valores siguientes, 1 para leer 2 para escribir o modificar , 3 para eliminar, si su valor es diferente de los valores permitidos el procedimiento retorna el valor null, este parametro tambien debe coincidir con los permisos de escribir o eliminar que debe tener el proceso actual (en ejecucion) sobre el proceso de los datos a modificar o eliminar  
//$condicion_modificacion tiene dos posibles estructuras, en dependencia del tipo de modificacion, si su valor es diferente de los valores permitidos el procedimiento retorna el valor null, a continuacion se explican
//para $tipo_accion 2 (escribir o modificar) tiene la siguiente estructura:
//el valor puede ser un string representando un binario ('011000001')o un decimal, en caso de ser un decimal se convierte a binario donde 
//si se escoge una condicion y esta no se cumple, el elemento base no es modificado. 
//quedaran representados de la siguiente manera
//
        //1er bit ( bit menos significativo, estremo derecho )en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si sus valores son iguales (==)
//2do bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si sus valores son diferentes (!= , <>)
//3er bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si sus valores son no identicos (!==)
//4to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es menor que el de la base (<)
//5to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es mayor que el de la base (>)
//6to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es menor o igual que el de la base (<=)
//7mo bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es mayor o igual que el de la base (>=)
//8vo bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n, pero si existe una estructura o elemento en la imagen que no existe en la base no es modificada la base, es decir no se transfiere el elemento de la imagen a la base.
//9no bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a registrar en los resultados, en el elemento 'fallos' de esta funci�n, los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores
//los valores sigientes son exepciones validas de aclarar
//binarios:
//000000000 (dec 0) modifica los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n, si existe una estructura o elemento en la imagen que no existe en la base es modificada la base con el elemento en cuestion, es decir se transfiere el elemento de la imagen a la base. 
//100000000 (dec 256) modifica los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n pero manteniendo el criterio de registrar en los resultados de esta funci�n, en el elemento 'fallos' de esta funci�n, los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores, ademas mantiene el comportamiento del 8vo bit segun su valor.
//110000000 (dec 384) modifica los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n pero manteniendo el criterio de registrar en los resultados de esta funci�n, en el elemento 'fallos' de esta funci�n, los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores, ademas mantiene el comportamiento del 8vo bit segun su valor.
//110000000+1 (dec mayor que 384)retorna un valor null
//si la l�gica de los bit del 1ro al 7mo activados equivalen a modificar todo el arreglo o existe redundancia, la funci�n retorna un valor null
//ej: 000000101 o 001010000
//el 8vo y 9no bit siempre pueden estar activados, no pertenece a la logica coparativa del lenguage    
//para $tipo_accion 3 (eliminar) tiene la siguiente estructura:
//el valor puede ser un string representando un binario ('011000001')o un decimal, en caso de ser un decimal se convierte a binario donde 
//si se escoge una condicion y esta no se cumple, el elemento base no es eliminado.
//quedaran representados de la siguiente manera
//
        //1er bit ( bit menos significativo, estremo derecho )en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si sus valores son iguales (==)
//2do bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si sus valores son identicos (===) 
//3er bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si sus valores son diferentes (!= , <>)
//4to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si sus valores son no identicos (!==)
//5to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es menor que el de la base (<)
//6to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es mayor que el de la base (>)
//7mo bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es menor o igual que el de la base (<=)
//8vo bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es mayor o igual que el de la base (>=)
//9no bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a registrar en los resultados de esta funci�n los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores
//los valores sigientes son exepciones validas de aclarar
//binarios:
//000000000 (dec 0) elimina los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir elimina todo sin citerios de comparaci�n 
//100000000 (dec 256) elimina los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir elimina todo sin citerios de comparaci�n pero manteniendo el criterio de registrar en los resultados de esta funci�n los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores
//110000000+1 (dec mayor que 384)retorna un valor null
//si la l�gica de los bit del 1ro al 8vo activados equivalen a eliminar todo el arreglo o existe redundancia, la funci�n retorna un valor null
//ej: 00000101 o 001010000
//entre el 1er y el 8vo bit solo pueden coexistir las convinaciones 2do y 3ro, o 2do y 5to, o 2do y 6to
//el 9no bit siempre puede estar activado, no pertenece a la logica coparativa del lenguage 
//este procedimiento retorna true si la operacion es satisfactoria y null si es insatisfactoria	
//el proceso que solicita el procedimiento tiene obligacion de haber inicializado seccion de configuracion
//
        //a los datos de configuracion del nucleo solo podra acceder el proceso nucleo	  

        static public function accederDatosConfiguracionProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' , $estructura_acceder = array( ) , $tipo_modificacion = 1 , $condicion_modificacion = 0 )
            {
            if ( self::chequearSeguridadCliente() && !empty( $fuente_datos_procesos ) && !empty( $id_proceso ) && ( ( $tipo_modificacion == 1 ) || ( $tipo_modificacion == 2 ) || ( $tipo_modificacion == 3 ) ) )
                {
                $namespace_gedee_proceso_nucleo = self::$EEoNucleo->namespaceGedeeProcesoNucleo() ;
                $clase_gedee_proceso_nucleo = self::$EEoNucleo->claseGedeeProcesoNucleo() ;

                $id_proceso_actual = self::$EEoNucleo->idProcesoEjecucion() ;

                if ( strtolower( $id_proceso ) == 'hereda' )
                    {
                    $id_proceso = $id_proceso_actual ;
                    }
                
                if ( !self::existenciaIdProceso( $fuente_datos_procesos , $id_proceso ) || ( empty( $estructura_acceder ) && ( ( $tipo_modificacion == 2 ) || ( $tipo_modificacion == 3 ) ) ) )
                    {
                    return null ;
                    }

                $La_resultado = null ;
                switch ( $tipo_modificacion )
                    {
                    case 1 : //leer
                        if ( is_array( $estructura_acceder ) && empty( $estructura_acceder ) )
                            {
                            $La_resultado = $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] ;
                            }
                        elseif ( is_string( $estructura_acceder ) && ( stripos( $estructura_acceder , ';' ) === false ) && ( stripos( $estructura_acceder , ')' ) === false ) && ( stripos( $estructura_acceder , '{' ) === false ) )
                            {

                            $cadena_ejecutar = " if ( isset( \$fuente_datos_procesos[\$namespace_gedee_proceso_nucleo][\$clase_gedee_proceso_nucleo][\$id_proceso]$estructura_acceder ) )
																						{
																							\$La_resultado = \$fuente_datos_procesos[\$namespace_gedee_proceso_nucleo][\$clase_gedee_proceso_nucleo][\$id_proceso]$estructura_acceder ;
																						}
																					" ;
                            eval( $cadena_ejecutar ) ;
                            }
                        return $La_resultado ;

                    case 2 : //escribir o modificar
                        $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloModificarRecursivo( $estructura_acceder , $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] , $condicion_modificacion ) ;
                        break ;

                    case 3 : //eliminar
                        $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloEliminarRecursivo( $estructura_acceder , $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] , $condicion_modificacion ) ;
                        break ;
                    }
                if ( ( $tipo_modificacion != 1 ) && !empty( $La_resultado [ 'arreglo_base' ] ) )
                    {
                    $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] = $La_resultado [ 'arreglo_base' ] ;
                    
                        return true ;
                    }
                }
            return null ;
            }

//hacer un procedimiento que debuelba una estructura y sus valores, porcion de la estructura configuracion que se hereda por un nivel o capa sigiente    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// pocedimientos referentes a class SeguridadProcesos /////////////////////////////////////////////////////////////////
//a continuacion un ejemplo de la estructura de datos que consibe este gedee para la seguridad 
        /*
          ['id_proceso' = identificador del proceso] = array (
          'propiedades' = array ( 'clave_proceso' = '' , 'alias' = '' , 'version' = '' , 'dependencias' = '' , 'conflictos' = '', statu = '' ), statu tiene como objetivo informar sobre el desempeno de la ejecucion del proceso
          'permiso_ejecucion' = array(
          'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
          'procesos' = array ('id_proceso_cliente1','id_proceso_clienteN') se evaluar� en dependencia del ambito declarado,
          )
          'acceso_seguridad' = array(
          'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
          'procesos' = array ('id_proceso_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, si se pone un id con valor vacio es como si no existiera o estubiera declarado para los procedimientos que hacen uso de estos datos
          )
          'acceso_datos' = array(
          'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
          'procesos' = array ( 'gedeeX' = array(
          'id_proceso_clienteX' = 'tipo de acceso'' ***'leer::escribir::eliminar'***, //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, si se pone un id con valor vacio es como si no existiera o estubiera declarado para los procedimientos que hacen uso de estos datos
          'id_proceso_clienteZ' = 'tipo de acceso'' ***'leer::escribir::eliminar'*** //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, si se pone un id con valor vacio es como si no existiera o estubiera declarado para los procedimientos que hacen uso de estos datos
          '*' = 'tipo de acceso'' ***'leer::escribir::eliminar'*** //si existe este elemento sera entendido como --todos los procesos de este gedee-- y el tratamiento a su valor sera identico a los valores de elementos independientes, como los ejemplos que anteceden a este aqui arriba, la funcion conciderara todos los procesos de este gedee en dependencia del ambito declarado, la busqueda de este elemento especifico '*' se hace despues de haber hecho la busqueda del elemento correpondiente al proceso actual en el gedee actual , es decir que tiene prioridad 1 la existencia del elemento correpondiente al proceso actual, prioridad 2 la existencia de '*' en el gedee actual, y prioridad 3 la exitencia de '*' en el elemento [procesos] del id_proceso servidor en general
          ),
          'gedeeZ' = array(
          'id_proceso_clienteX' = 'tipo de acceso'' ***'leer::escribir::eliminar'***, //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, si se pone un id con valor vacio es como si no existiera o estubiera declarado para los procedimientos que hacen uso de estos datos
          'id_proceso_clienteZ' = 'tipo de acceso'' ***'leer::escribir::eliminar'*** //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, si se pone un id con valor vacio es como si no existiera o estubiera declarado para los procedimientos que hacen uso de estos datos
          '*' = 'tipo de acceso'' ***'leer::escribir::eliminar'*** //si existe este elemento sera entendido como --todos los procesos de este gedee-- y el tratamiento a su valor sera identico a los valores de elementos independientes, como los ejemplos que anteceden a este aqui arriba, la funcion conciderara todos los procesos de este gedee en dependencia del ambito declarado, la busqueda de este elemento especifico '*' se hace despues de haber hecho la busqueda del elemento correpondiente al proceso actual en el gedee actual , es decir que tiene prioridad 1 la existencia del elemento correpondiente al proceso actual, prioridad 2 la existencia de '*' en el gedee actual, y prioridad 3 la exitencia de '*' en el elemento [procesos] del id_proceso servidor en general
          )
          '*' = 'tipo de acceso'' ***'leer::escribir::eliminar'*** //si existe este elemento sera entendido como --todos los procesos de todos los gedees-- , y el tratamiento a su valor sera identico a los valores de elementos independientes, como los ejemplos que anteceden a este mas arriba, la funcion conciderara todos los procesos de todos los gedees en dependencia del ambito declarado, la busqueda de este elemento especifico '*' se hace despues de haber hecho la busqueda del elemento correpondiente al proceso actual en el gedee actual y despues tambien de la busqueda de este mismo elemento '*' en el gedee actual, es decir que tiene prioridad 1 la existencia del elemento correpondiente al proceso actual, prioridad 2 lal existencia de '*' en el gedee actual, y prioridad 3 la exitencia de '*' en el elemento [procesos] del id_proceso servidor en general .
          )
          )
          'acceso_configuracion = array(
          'ambito' = 'restrictivo' o 'permisivo'//si es restrictivo se restringe todo y solo se permite lo declarado, si es permisivo se permite todo y solo se restrige lo declarado, si no existe este parametro los procedimientos declaradaos en esta clase y que trabajan con el parametro ambito tomaran el valor por defecto que se declara en la propiedad $ambito_seguridad de esta clase.
          'procesos' = array ('id_proceso_cliente1' = 'tipo de acceso'' ***'leer::escribir::eliminar'***), //tanto el id de cliente como el tipo de acceso se evaluar� en dependencia del ambito declarado, el tipo de acceso se declara con los :: como separadores y no tienen un orden fijo, y no se permiten valores vacios o '::::::' ya que el efecto sera nulo para el id correspondiente, se debe explicitar el o los tipos de aceso de forma correcta, si se pone un id con valor vacio es como si no existiera o estubiera declarado para los procedimientos que hacen uso de estos datos
          )
          );
         */

//procedimiento para crear o inicializar un nuevo espacio de seguridad perteneciente al proceso actual (ejecutandose)
//El id_proceso para la inicializacion de los datos lo toma automaticamente la funcion del id del nucleo en ese momento, es el identificador del proceso nucleo a nuevo ingreso de sus datos, si su valor es vacio el procedimiento retorna el valor null 
//$fuente_datos_procesos es la estructura de datos a la que se incrementaran los datos de esta inicializacion, se trabaja sobre esta estructura por referencia no por valor, y se le dara tratamiento de tipo como un arreglo 
//$datos_seguridad es la estructura de datos de seguridad a guardar, no olvidar que esta debe ajustarse a una estructura preconsevida para esta clase, sino algunas de sus prestaciones no funcionaran con la estructura de datos atipica, si su valor es vacio el procedimiento retorna el valor null 
//este procedimiento utiliza un procedimiento del objeto $EEoNucleo a travez de $this->EEoNucleo
//este procedimiento retorna true si la operacion es satisfactoria y null si es insatisfactoria
        static public function iniciarDatosSeguridadProceso( &$fuente_datos_procesos , $datos_seguridad )
            {
            return null ;
            }

//procedimiento para modificar los datos de seguridad de un proceso nucleo, para ello deberan cumplrse las siguientes condiciones
// - existir una seccion de seguridad del proceso al que se quieren modificar los datos en el parametro  $fuente_datos_procesos que se requiere en este mismo procedimiento
// - existir el id del proceso nucleo que ejecuta este procedimiento en la estructura $fuente_datos_procesos = array('id_proceso_cliente1' ,que se requiere en este mismo procedimiento 
//id_proceso es el identificador del proceso nucleo al que se quieren modificar los datos de seguridad, si el valor de este parametro es vacio el procedimiento retorna el valor null, 
//$fuente_datos_procesos es la estructura de datos a la que se accedera , se trabaja sobre esta estructura por referencia no por valor, y se le dara tratamiento de tipo como un arreglo
//$estructura_acceder //
//para valor 1 del parametro $tipo_accion (referencia) este puede contener un arreglo vacio para obtener todo el arreglo perteneciente al arreglo $datos_seguridad_procesos[id_proceso], array() un arreglo vacio es por defecto el valor que tiene, o se puede acceder solo a una parte de su estructura si se le da el valor a este parametro de una cadena con la esrtuctura a la que se quiere acceder, ejemlpo '[acceso_seguridad][procesos]' y el debolvera el elemento $datos_seguridad_procesos[id_proceso][acceso_seguridad][procesos], todo esto en dependencia de los permisos de acceso a esta estructura del proceso cliente 
//para valores 2 y 3 del parametro $tipo_accion (referencia) es un arreglo asociativo con los elementos que se quieren eliminar o modificar en el arreglo $datos_seguridad_procesos[id_proceso],
// esta matriz contendra la estructura exacta en la que se encuentra el elemento que se quiere eliminar o modificar,
// es como un mapa, una imagen de la matriz y su rama o elemento que se quiere eliminar o modificar, llamemosle de ahora en adelante "estructura imagen"
// en caso de que toda una rama del arreglo se quiera eliminar basta con poner 'elemento'=array() y se eliminara ese elemento junto a la rama que el constitulle,
// el primer elemento del arreglo $La_elementos ser� el primer elemento a buscar en el arreglo $datos_seguridad_procesos[id_proceso] , y as� sucecivamente.
// si su valor es vacio el procedimiento retorna el valor null
//$tipo_accion es el tipo de modificacion que se utilizara con los posibles valores siguientes, 1 para leer 2 para escribir o modificar , 3 para eliminar, si su valor es diferente de los valores permitidos el procedimiento retorna el valor null, este parametro tambien debe coincidir con los permisos de escribir o eliminar que debe tener el proceso actual (en ejecucion) sobre el proceso de los datos a modificar o eliminar  
//$condicion_modificacion tiene dos posibles estructuras, en dependencia del tipo de modificacion, si su valor es diferente de los valores permitidos el procedimiento retorna el valor null, a continuacion se explican
//para $tipo_accion 2 (escribir o modificar) tiene la siguiente estructura:
//el valor puede ser un string representando un binario ('011000001')o un decimal, en caso de ser un decimal se convierte a binario donde 
//si se escoge una condicion y esta no se cumple, el elemento base no es modificado. 
//quedaran representados de la siguiente manera
//
        //1er bit ( bit menos significativo, estremo derecho )en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si sus valores son iguales (==)
//2do bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si sus valores son diferentes (!= , <>)
//3er bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si sus valores son no identicos (!==)
//4to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es menor que el de la base (<)
//5to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es mayor que el de la base (>)
//6to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es menor o igual que el de la base (<=)
//7mo bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es mayor o igual que el de la base (>=)
//8vo bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n, pero si existe una estructura o elemento en la imagen que no existe en la base no es modificada la base, es decir no se transfiere el elemento de la imagen a la base.
//9no bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a registrar en los resultados, en el elemento 'fallos' de esta funci�n, los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores
//los valores sigientes son exepciones validas de aclarar
//binarios:
//000000000 (dec 0) modifica los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n, si existe una estructura o elemento en la imagen que no existe en la base es modificada la base con el elemento en cuestion, es decir se transfiere el elemento de la imagen a la base. 
//100000000 (dec 256) modifica los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n pero manteniendo el criterio de registrar en los resultados de esta funci�n, en el elemento 'fallos' de esta funci�n, los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores, ademas mantiene el comportamiento del 8vo bit segun su valor.
//110000000 (dec 384) modifica los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n pero manteniendo el criterio de registrar en los resultados de esta funci�n, en el elemento 'fallos' de esta funci�n, los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores, ademas mantiene el comportamiento del 8vo bit segun su valor.
//110000000+1 (dec mayor que 384)retorna un valor null
//si la l�gica de los bit del 1ro al 7mo activados equivalen a modificar todo el arreglo o existe redundancia, la funci�n retorna un valor null
//ej: 000000101 o 001010000
//el 8vo y 9no bit siempre pueden estar activados, no pertenece a la logica coparativa del lenguage    
//para $tipo_accion 3 (eliminar) tiene la siguiente estructura:
//el valor puede ser un string representando un binario ('011000001')o un decimal, en caso de ser un decimal se convierte a binario donde 
//si se escoge una condicion y esta no se cumple, el elemento base no es eliminado.
//quedaran representados de la siguiente manera
//
        //1er bit ( bit menos significativo, estremo derecho )en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si sus valores son iguales (==)
//2do bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si sus valores son identicos (===) 
//3er bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si sus valores son diferentes (!= , <>)
//4to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si sus valores son no identicos (!==)
//5to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es menor que el de la base (<)
//6to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es mayor que el de la base (>)
//7mo bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es menor o igual que el de la base (<=)
//8vo bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es mayor o igual que el de la base (>=)
//9no bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a registrar en los resultados de esta funci�n los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores
//los valores sigientes son exepciones validas de aclarar
//binarios:
//000000000 (dec 0) elimina los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir elimina todo sin citerios de comparaci�n 
//100000000 (dec 256) elimina los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir elimina todo sin citerios de comparaci�n pero manteniendo el criterio de registrar en los resultados de esta funci�n los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores
//110000000+1 (dec mayor que 384)retorna un valor null
//si la l�gica de los bit del 1ro al 8vo activados equivalen a eliminar todo el arreglo o existe redundancia, la funci�n retorna un valor null
//ej: 00000101 o 001010000
//entre el 1er y el 8vo bit solo pueden coexistir las convinaciones 2do y 3ro, o 2do y 5to, o 2do y 6to
//el 9no bit siempre puede estar activado, no pertenece a la logica coparativa del lenguage 
//este procedimiento retorna true si la operacion es satisfactoria y null si es insatisfactoria	
//el proceso que solicita el procedimiento tiene obligacion de haber inicializado seccion de seguridad
//
        //a los datos de seguridad del nucleo solo podra acceder el proceso nucleo	  

        static public function accederDatosSeguridadProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' , $estructura_acceder = array( ) , $tipo_modificacion = 1 , $condicion_modificacion = 0 )
            {
            return null ;
            }

//solo pueden ejecutar procesos nucleo, otro proceso nucleo, o un proceso no nucleo que este autorisado en la seguridad, pero para esto debe aberse cargado primero el proceso nucleo y haber creado los datos de seguridad con el permiso en cuestion, este procedimiento no funciona como el omologo del gedeeecomun que si permite a un proceso que no se haya ejecutado ser ejecutado por cualquier otro proceso  procedimiento existe para mantener la compatibilidad con las demas clases gedee procesos, ya que este proceso nucleo no se puede ejecutar por otro proceso 
        static public function clienteEjecucionProceso()
            {
            if ( self::chequearSeguridadCliente() )
                {
                   return 'ejecucion' ;
                }
            return null ;
            }

//este procedimiento gestiona si un proceso idcliente (ejecutandose , actual) tiene acceso a los datos del proceso nucleo, y de ser sierto obtener el tipo de acceso, este acceso es referente a los datos contenidos en la clase DatosProcesos  
//id_proceso es el identificador del proceso nucleo que se quiere chequear si el proceso actual (en ejecucion) puede tener acceso a sus datos, si su valor es vacio el procedimiento retorna el valor null
//si el proceso actual(ejecutandose) es cliente de los datos del proceso nucleo al que se chequea, este procedimiento debuelve el tipo de acceso permitido(siempre el permitido, nunca el denegado)('leer', 'escribir', 'eliminar') con la estructura siguiente 'leer::escribir::eliminar' omitiendose el acceso no deseado (ver estructura del arreglo $datos_seguridad_procesos) declarado, ej:'leer' o 'leer::eliminar' 
//este procedimiento retorna null si es insatisfactorio o si el proceso actual no tiene acceso alguno a los datos del proceso analizado . 

        static public function clienteAccesoDatosProceso()
            {
            if ( self::chequearSeguridadCliente() )
                {
                return 'leer::escribir::eliminar' ;
                }
            return null ;
            }

//este procedimiento existe para mantener la compatibilidad con las demas clases gedee procesos, ya que este proceso nucleo no permite el acceso a sus datos de configuracion a otros procesos 

        static public function clienteAccesoConfiguracionProceso()
            {           
            if ( self::chequearSeguridadCliente() )
                {
                return 'leer::escribir::eliminar' ;
                }
            return null ;
            }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////// pocedimientos referentes a class DatosProcesos /////////////////////////////////////////////////////////////////
//procedimiento para crear o inicializar un nuevo espacio de datos perteneciente al proceso actual (ejecutandose)
//El id_proceso para la inicializacion de los datos lo toma automaticamente la funcion del id del nucleo en ese momento, es el identificador del proceso nucleo a nuevo ingreso de sus datos, si su valor es vacio el procedimiento retorna el valor null 
//$fuente_datos_procesos es la estructura de datos a la que se incrementaran los datos de esta inicializacion, se trabaja sobre esta estructura por referencia no por valor, y se le dara tratamiento de tipo como un arreglo 
//$datos es la estructura de datos a guardar, no olvidar que esta debe ajustarse a una estructura preconsevida para esta clase, sino algunas de sus prestaciones no funcionaran con la estructura de datos atipica, si su valor es vacio el procedimiento retorna el valor null 
//este procedimiento utiliza un procedimiento del objeto $EEoNucleo a travez de $this->EEoNucleo
//este procedimiento retorna true si la operacion es satisfactoria y null si es insatisfactoria
        static public function iniciarDatosSalidaProceso( &$fuente_datos_procesos , $datos_salida )
            {
            return self::iniciarDatosProceso( $fuente_datos_procesos , $datos_salida ) ;
            }

//procedimiento para acceder a los datos del espacio de datos de un proceso nucleo, para ello deberan cumplrse las siguientes condiciones
// - existir una seccion de datos del proceso al que se quieren acceder los datos 
// - existir una seccion de seguridad del proceso nucleo al que se quieren acceder los datos en la propiedad $datos_seguridad_procesos de la instancia de la clase seguridad_procesos 
// - existir el id del proceso que ejecuta este procedimiento en la estructura 'acceso_seguridad' = array('id_proceso_cliente1' = 'tipo de acceso'' = 'leer::escribir::eliminar'),perteneciente a la seccion de seguridad del proceso al que se quieren modificar los datos, en la propiedad $datos_seguridad_procesos de la instancia de clase seguridad_procesos, y corresponderse con los permisos otorgados, solo se prescinde de esta condicion si el proceso intenta acceder a sus propios datos 
//$fuente_datos_procesos es la estructura de datos a la que se accedera , se trabaja sobre esta estructura por referencia no por valor, y se le dara tratamiento de tipo como un arreglo
//id_proceso es el identificador del proceso nucleo al que se quieren modificar los datos de salida del proceso, si se quieren modificar los datos del proceso actual(en ejecucion) se introduce el valor 'hereda' o el id que le corresponde,si el valor de este parametro es vacio el procedimiento retorna el valor null
//$estructura_acceder //
//para valor 1 del parametro $tipo_modificacion (referencia) este puede contener un arreglo vacio para obtener todo el arreglo perteneciente al arreglo $datos_salida_procesos[id_proceso], array() un arreglo vacio es por defecto el valor que tiene, o se puede acceder solo a una parte de su estructura si se le da el valor a este parametro de una cadena con la esrtuctura a la que se quiere acceder, ejemlpo '[dato1][dato2]' y el debolvera el elemento $datos_salida_procesos[id_proceso][dato1][dato2], todo esto en dependencia de los permisos de acceso a esta estructura del proceso cliente 
//para valores 2 y 3 del parametro $tipo_modificacion (referencia) es un arreglo asociativo con los elementos que se quieren eliminar o modificar en el arreglo $datos_salida_procesos[id_proceso],
// esta matriz contendra la estructura exacta en la que se encuentra el elemento que se quiere eliminar o modificar,
// es como un mapa, una imagen de la matriz y su rama o elemento que se quiere eliminar o modificar, llamemosle de ahora en adelante "estructura imagen"
// en caso de que toda una rama del arreglo se quiera eliminar basta con poner 'elemento'=array() y se eliminara ese elemento junto a la rama que el constitulle,
// el primer elemento del arreglo $La_elementos ser� el primer elemento a buscar en el arreglo $datos_salida_procesos[id_proceso] , y as� sucecivamente.
// si su valor es vacio el procedimiento retorna el valor null
//$tipo_modificacion es el tipo de modificacion que se utilizara con los posibles valores siguientes, 1 para leer 2 para escribir o modificar , 3 para eliminar, si su valor es diferente de los valores permitidos el procedimiento retorna el valor null, este parametro tambien debe coincidir con los permisos de escribir o eliminar que debe tener el proceso actual (en ejecucion) sobre el proceso de los datos a modificar o eliminar  
//$condicion_modificacion tiene dos posibles estructuras, en dependencia del tipo de modificacion, si su valor es diferente de los valores permitidos el procedimiento retorna el valor null, a continuacion se explican
//para $tipo_modificacion 2 (escribir o modificar) tiene la siguiente estructura:
//el valor puede ser un string representando un binario ('011000001')o un decimal, en caso de ser un decimal se convierte a binario donde 
//si se escoge una condicion y esta no se cumple, el elemento base no es modificado. 
//quedaran representados de la siguiente manera
//
        //1er bit ( bit menos significativo, estremo derecho )en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si sus valores son iguales (==)
//2do bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si sus valores son diferentes (!= , <>)
//3er bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si sus valores son no identicos (!==)
//4to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es menor que el de la base (<)
//5to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es mayor que el de la base (>)
//6to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es menor o igual que el de la base (<=)
//7mo bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los elementos si el valor de la imagen es mayor o igual que el de la base (>=)
//8vo bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a modificar los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n, pero si existe una estructura o elemento en la imagen que no existe en la base no es modificada la base, es decir no se transfiere el elemento de la imagen a la base.
//9no bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a registrar en los resultados, en el elemento 'fallos' de esta funci�n, los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores
//los valores sigientes son exepciones validas de aclarar
//binarios:
//000000000 (dec 0) modifica los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n, si existe una estructura o elemento en la imagen que no existe en la base es modificada la base con el elemento en cuestion, es decir se transfiere el elemento de la imagen a la base. 
//100000000 (dec 256) modifica los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n pero manteniendo el criterio de registrar en los resultados de esta funci�n, en el elemento 'fallos' de esta funci�n, los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores, ademas mantiene el comportamiento del 8vo bit segun su valor.
//110000000 (dec 384) modifica los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir modifica todo sin citerios de comparaci�n pero manteniendo el criterio de registrar en los resultados de esta funci�n, en el elemento 'fallos' de esta funci�n, los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores, ademas mantiene el comportamiento del 8vo bit segun su valor.
//110000000+1 (dec mayor que 384)retorna un valor null
//si la l�gica de los bit del 1ro al 7mo activados equivalen a modificar todo el arreglo o existe redundancia, la funci�n retorna un valor null
//ej: 000000101 o 001010000
//el 8vo y 9no bit siempre pueden estar activados, no pertenece a la logica coparativa del lenguage    
//para $tipo_modificacion 3 (eliminar) tiene la siguiente estructura:
//el valor puede ser un string representando un binario ('011000001')o un decimal, en caso de ser un decimal se convierte a binario donde 
//si se escoge una condicion y esta no se cumple, el elemento base no es eliminado.
//quedaran representados de la siguiente manera
//
        //1er bit ( bit menos significativo, estremo derecho )en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si sus valores son iguales (==)
//2do bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si sus valores son identicos (===) 
//3er bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si sus valores son diferentes (!= , <>)
//4to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si sus valores son no identicos (!==)
//5to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es menor que el de la base (<)
//6to bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es mayor que el de la base (>)
//7mo bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es menor o igual que el de la base (<=)
//8vo bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a eliminar los elementos si el valor de la imagen es mayor o igual que el de la base (>=)
//9no bit en cero desactivado) no se tiene en cuenta
//        en 1 (activado)corresponde a registrar en los resultados de esta funci�n los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores
//los valores sigientes son exepciones validas de aclarar
//binarios:
//000000000 (dec 0) elimina los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir elimina todo sin citerios de comparaci�n 
//100000000 (dec 256) elimina los valores sin tener en cuenta las condicionantes de l�gica de comparaci�n, es decir elimina todo sin citerios de comparaci�n pero manteniendo el criterio de registrar en los resultados de esta funci�n los elementos existentes en el arreglo imagen que no existen en el arreglo base, solo los elementos no sus valores
//110000000+1 (dec mayor que 384)retorna un valor null
//si la l�gica de los bit del 1ro al 8vo activados equivalen a eliminar todo el arreglo o existe redundancia, la funci�n retorna un valor null
//ej: 00000101 o 001010000
//entre el 1er y el 8vo bit solo pueden coexistir las convinaciones 2do y 3ro, o 2do y 5to, o 2do y 6to    
//el 9no bit siempre puede estar activado, no pertenece a la logica coparativa del lenguage 
//este procedimiento retorna true si la operacion es satisfactoria y null si es insatisfactoria
//el proceso que solicita el procedimiento no tiene obligacion de haber inicializado seccion de datos en la instancia de la clase DatosProcesos ni en la instancia de la clase seguridad_proceso con ecepcion de que quien solicite el procedimiento lo haga para modificar sus propios datos, en este caso si debe existir una apertura de seccion de datos con antelacion, para ello existe el procedimiento iniciarDatosSalidaProceso en esta misma clase  

        public function accederDatosSalidaProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' , $estructura_acceder = array( ) , $tipo_modificacion = 1 , $condicion_modificacion = 0 )
            {
            if ( self::chequearSeguridadCliente() && !empty( $fuente_datos_procesos ) && !empty( $id_proceso ) && ( ( $tipo_modificacion == 1 ) || ( $tipo_modificacion == 2 ) || ( $tipo_modificacion == 3 ) ) )
                {
                $namespace_gedee_proceso_nucleo = self::$EEoNucleo->namespaceGedeeProcesoNucleo() ;
                $clase_gedee_proceso_nucleo = self::$EEoNucleo->claseGedeeProcesoNucleo() ;

                $id_proceso_actual = self::$EEoNucleo->idProcesoEjecucion() ;

                if ( strtolower( $id_proceso ) == 'hereda' )
                    {
                    $id_proceso = $id_proceso_actual ;
                    }

                if ( !self::existenciaIdProceso( $fuente_datos_procesos , $id_proceso ) || ( empty( $estructura_acceder ) && ( ( $tipo_modificacion == 2 ) || ( $tipo_modificacion == 3 ) ) ) )
                    {
                    return null ;
                    }

                $La_resultado = null ;
                switch ( $tipo_modificacion )
                    {
                    case 1 : //leer
                        if ( is_array( $estructura_acceder ) && empty( $estructura_acceder ) )
                            {
                            $La_resultado = $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] ;
                            }
                        elseif ( is_string( $estructura_acceder ) && ( stripos( $estructura_acceder , ';' ) === false ) && ( stripos( $estructura_acceder , ')' ) === false ) && ( stripos( $estructura_acceder , '{' ) === false ) )
                            {

                            $cadena_ejecutar = " if ( isset( \$fuente_datos_procesos[\$namespace_gedee_proceso_nucleo][\$clase_gedee_proceso_nucleo][\$id_proceso]$estructura_acceder ) )
																						{
																							\$La_resultado = \$fuente_datos_procesos[\$namespace_gedee_proceso_nucleo][\$clase_gedee_proceso_nucleo][\$id_proceso]$estructura_acceder ;
																						}
																					" ;
                            eval( $cadena_ejecutar ) ;
                            }
                        return $La_resultado ;

                    case 2 : //escribir o modificar
                        $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloModificarRecursivo( $estructura_acceder , $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] , $condicion_modificacion ) ;
                        break ;

                    case 3 : //eliminar
                        $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloEliminarRecursivo( $estructura_acceder , $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] , $condicion_modificacion ) ;
                        break ;
                    }
                if ( ( $tipo_modificacion != 1 ) && !empty( $La_resultado [ 'arreglo_base' ] ) )
                    {
                    $fuente_datos_procesos[ $namespace_gedee_proceso_nucleo ][ $clase_gedee_proceso_nucleo ][ $id_proceso ] = $La_resultado [ 'arreglo_base' ] ;
                    return true ;
                    }
                }
            return null ;
            }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//hacer un destructor que destruya los datos de este proceso, esto es en caso de morir el proceso o algo asi   
        }

?>		