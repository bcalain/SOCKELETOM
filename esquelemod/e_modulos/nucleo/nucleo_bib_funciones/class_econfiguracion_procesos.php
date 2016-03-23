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
   * ConfiguracionProcesos class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */
    namespace Emod\Nucleo ;

    class ConfiguracionProcesos extends \Emod\Nucleo\NucleoEntidadBase
        {

        //protected $EEoNucleo = null ;
        //protected $EEoInterfazDatos = null ;
        //protected $EEoSeguridad = null ;
        /////////////////////////////////PROCESOS////////////////////////////////////////////////////////////////////////////////
        //(valores que los procesos (bloques, controles, etc) guardan como configuracion y tienen la estructura en dependencia de la gestion de seguridad del gedee que tiene sus datos aqui )

        private $datosConfiguracionProcesos = array( ) ;

        //en este procedimiento se utilizan listas variables de parametros por lo que se debe tener en cuenta el orden de estos para un correcto desempeno del procedimiento 
        //el primer argumento, argumentos[0] sera el arreglo de datos de la configuracion a inicializar
        public function iniciarDatosConfiguracionProceso()
            {
            $La_argumentos = func_get_args() ;

            return $this->implementarProcedimientosEE( $this->datosConfiguracionProcesos , __FUNCTION__ , $La_argumentos ) ;
            }

        //procedimiento para la indagacion de existencia de los datos de cnfiguracion de un proceso determinado, la estructura de estos datos estara definida por el gedee del proceso que inicializa sus datos de seguridad
        //en este procedimiento se utilizan listas variables de parametros por lo que se debe tener en cuenta el orden de estos para un correcto desempeno del procedimiento 
        //el primer argumento, argumentos[0] sera el arreglo de datos de la seguridad a inicializar

        public function existenciaIdProceso()
            {
            $La_argumentos = func_get_args() ;

            return $this->implementarProcedimientosEE( $this->datos_seguridad_procesos , __FUNCTION__ , $La_argumentos , true ) ;
            }

        //en este procedimiento se utilizan listas variables de parametros por lo que se debe tener en cuenta el orden de estos para un correcto desempeno del procedimiento 
        //el primer argumento, argumentos[0] sera el arreglo de datos de la configuracion a acceder
        public function accederDatosConfiguracionProceso()
            {
            $La_argumentos = func_get_args() ;

            return $this->implementarProcedimientosEE( $this->datosConfiguracionProcesos , __FUNCTION__ , $La_argumentos , true ) ;
            }
            
        //borrar es solo para pruebas
	public function acceder_estructura_completa()
	    {
		echo '<p> ESTE METODO ES SOLO PARA EL DEBUGGEO'.__METHOD__.'<p>' ;
		return $this->datosConfiguracionProcesos ;
							
	    }

//recuerda si las cosas no funcionan quitar este llave de abajo           
        }

    /*




      /////////////////////////////////APLICACIONES Y MODULOS////////////////////////////////////////////////////////////////////////////////

      //procedimiento para buscar la existencia de un idaplicacion o modulo de aplicacion en el contenedor de datos de salida de las aplicaciones y modulos
      //$id_aplicacion es el id de la aplicacion que se quiere buscar si existe, si se le da el valor 'hereda' este hara referencia a la aplicacion actual en ejecucion', si su valor es vacio el procedimiento retorna el valor null
      //$id_modulo es el id del modulo que se quiere buscar si existe, si se le da el valor 'hereda' este hara referencia al mmodulo actual en ejecucion', los modulos tienen obligatoriamente que estar asociados con una aplicacion
      //este procedimiento retorna la cadena 'aplicacion' en caso de ser una busqueda de aplicacion solamente y haber sido satisfactoria la operacion, retorna la cadena 'modulo' en caso de ser una busqueda de modulo y haber sido satisfactoria la operacion, si es una busqueda de modulo y este no es ncontrado en la estructura del arreglo datos_salida_appmod se retorna null  ,si es insatisfactoria la operacion el valor retornado por este procedimiento es null
      public function existencia_id_appmod( $id_aplicacion = 'hereda' , $id_modulo = '' )
      {
      if ( !empty ( $id_aplicacion ) )
      {
      if ( $id_aplicacion == 'hereda' && is_object( $this->EEoNucleo ) )
      {
      $id_aplicacion = $this->EEoNucleo->aplicacion_ejecucion() ;
      }
      if ( !empty ( $this->datos_configuracion_appmod[$id_aplicacion] ) )
      {
      if ( !empty ( $id_modulo ) )
      {
      if ( $id_modulo == 'hereda' && is_object( $this->EEoNucleo ) )
      {
      $id_modulo = $this->EEoNucleo->modulo_ejecucion() ;
      }
      if ( !empty ( $this->datos_configuracion_appmod[$id_aplicacion]['modulos'][$id_modulo] ) )
      {
      return 'modulo' ;
      }
      return null ;
      }
      return 'aplicacion' ;
      }
      }
      return null ;
      }

      //procedimiento para crear o inicializar un nuevo espacio de seguridad perteneciente a la aplicacion o modulo correspondiente
      //El $id_aplicacion y/o $id_modulo para la inicializacion de los datos lo toma automaticamente la funcion de la aplicacion y/o modulo que se ejecuta en ese momento, es el identificador de la aplicacion y/o modulo a nuevo ingreso de sus datos, y es la aplicacion y/o modulo que se encuentra como activo en ese momento en el objeto nucleo, si su valor es vacio el procedimiento retorna el valor null
      //$datos_seguridad es la estructura de datos de seguridad a guardar, no olvidar que esta debe ajustarse a una estructura preconsevida para esta clase, sino algunas de sus prestaciones no funcionaran con la estructura de datos atipica, si su valor es vacio el procedimiento retorna el valor null
      //$tipo es para definir si los datos a inicializar seran de una aplicacion $tipo = 'aplicacion', un modulo de aplicacion $tipo = 'modulo', en caso de contener un valor diferente de los mencionados el procedimiento retorna el valor null
      //este procedimiento utiliza un procedimiento del objeto $EEoNucleo a travez de $this->EEoNucleo
      //este procedimiento retorna true si la operacion es satisfactoria y null si es insatisfactoria
      //si se intenta inicializar datos en espacios corespondientes a datos inicialisados ya, el procedimiento retorna el valor null
      public function inicializar_datosalida_appmod( $datos_configuracion )
      {
      if( !empty( $this->EEoNucleo ) && !empty ( $datos_configuracion  ) && ( ( $this->EEoNucleo->gedeeProcesoEjecucion() == 'aplicacion' ) || ( $this->EEoNucleo->gedeeProcesoEjecucion() == 'modulo' ) ) )
      {
      $id_aplicacion = $this->EEoNucleo->aplicacion_ejecucion() ;
      if ( !empty( $id_aplicacion ) )
      {
      switch( $this->EEoNucleo->gedeeProcesoEjecucion() )
      {
      case 'aplicacion' :  if( $this->existencia_id_appmod( $id_aplicacion ) == null )
      {
      $this->datos_configuracion_appmod[ $id_aplicacion ] = $datos_configuracion ;
      return true ;
      }
      break ;

      case 'modulo' :  $id_modulo = $this->EEoNucleo->modulo_ejecucion() ;
      if( !empty( $id_modulo ) && ( $this->existencia_id_appmod( $id_aplicacion , $id_modulo ) != 'modulo' ) )
      {
      $this->datos_configuracion_appmod[ $id_aplicacion ]['modulos'][ $id_modulo ] = $datos_configuracion ;
      return true ;
      }
      break ;
      }
      }
      }
      return null ;
      }

      //procedimiento para modificar los datos de salida de un proceso aplicacion o modulo de aplicacion que se encuentran en la propiedad datos_salida_appmod de esta clase, para ello deberan cumplrse las siguientes condiciones
      // - existir una seccion de seguridad de la aplicacion o modulo proceso al que se quieren leer o modificar los datos en la propiedad $datos_seguridad_appmod de la instancia de la clase seguridad procesos
      // - existir el id de la aplicacion o modulo proceso que ejecuta este procedimiento en la estructura 'acceso_datos',perteneciente a la seccion de seguridad de la aplicacion o modulo proceso al que se quieren modificar los datos, en la propiedad $datos_seguridad_appmod de la instancia de la clase seguridad procesos, y corresponderse con los permisos otorgados, solo se prescinde de esta condicion si el proceso aplicacion o modulo intenta acceder a sus propios datos
      //$id_aplicacion es el identificador del proceso aplicacion al que se quieren modificar los datos de seguridad, si se quieren modificar los datos del proceso aplicacion actual(en ejecucion) se introduce el valor 'hereda', o el id que le corresponde, por defecto este par�metro tiene el valor 'hereda', si el valor de este parametro es vacio el procedimiento retorna el valor null,
      //$id_modulo es el identificador del proceso modulo al que se quieren modificar los datos de seguridad, si se quieren modificar los datos del proceso modulo actual(en ejecucion) se introduce el valor 'hereda', o el id que le corresponde, por defecto este par�metro tiene el valor '' (string vacio), para complementar esta aayuda debe verse la ayuda de la propiedad $datos_seguridad_appmod de la clase seguridad procesos.
      //$estructura_acceder //

      //para valor 1 del parametro $tipo_accion (referencia) este puede contener un arreglo vacio para obtener todo el arreglo perteneciente al arreglo $datos_salida_appmod[id_aplicacion], array() un arreglo vacio es por defecto el valor que tiene, o se puede acceder solo a una parte de su estructura si se le da el valor a este parametro de una cadena con la esrtuctura a la que se quiere acceder, ejemplo '[modulos][idmodulo][datox]' y el debolvera el elemento $datos_seguridad_appmod[id_aplicacion][modulos][idmodulo][datox], todo esto en dependencia de los permisos de acceso a esta estructura del proceso aplicacion o modulo cliente

      //para valores 2 y 3 del parametro $tipo_accion (referencia) es un arreglo asociativo con los elementos que se quieren eliminar o modificar en el arreglo $datos_seguridad_appmod[id_aplicacion] o $datos_seguridad_appmod[id_aplicacion][modulos][id_modulo], segun corresponda
      // esta matriz contendra la estructura exacta en la que se encuentra el elemento que se quiere eliminar o modificar,
      // es como un mapa, una imagen de la matriz y su rama o elemento que se quiere eliminar o modificar, llamemosle de ahora en adelante "estructura imagen"
      // en caso de que toda una rama del arreglo se quiera eliminar basta con poner 'elemento'=array() y se eliminara ese elemento junto a la rama que el constitulle,
      // el primer elemento del arreglo $La_elementos ser� el primer elemento a buscar en el arreglo $datos_salida_appmod[id_aplicacion] o $datos_salida_appmod[id_aplicacion][modulos][id_modulo], segun corresponda  , y as� sucecivamente.
      // si su valor es vacio el procedimiento retorna el valor null

      //$tipo_accion es el tipo de modificacion que se utilizara con los posibles valores siguientes, 1 para leer 2 para escribir o modificar , 3 para eliminar, si su valor es diferente de los valores permitidos el procedimiento retorna el valor null, este parametro tambien debe coincidir con los permisos de escribir o eliminar que debe tener el proceso aplicacion o modulo actual (en ejecucion) sobre el proceso aplicacion o modulo de los datos a modificar o eliminar
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
      //el proceso aplicacion o modulo que solicita el procedimiento no tiene obligacion de haber inicializado seccion de datos en la instancia de esta clase con ecepcion de que quien solicite el procedimiento lo haga para modificar sus propios datos, en este caso si debe existir una apertura de seccion de datos con antelacion, para ello existe el procedimiento inicializar_datosalida_appmod en esta misma clase


      //recuerda cuando utilices esta funcion y no haya modulo tienes que pasar un valor vacio pero no null
      //en la opcion de eliminar elimina por la clave de la rama de array no por el valor de la clave
      //si se declara un idaplicacion o idmodulo y este no existe en la estructura del arreglo de datos de salida entonces el procedimiento retorna el valor null

      public function acceder_datosconfiguracion_appmod( $id_aplicacion = 'hereda' ,$id_modulo = '' , $estructura_acceder = array() , $tipo_accion = 1 , $condicion_modificacion = 0 )
      {
      if ( !empty( $id_aplicacion ) && !empty( $this->EEoNucleo ) && ( ( $this->EEoNucleo->gedeeProcesoEjecucion() == 'aplicacion') || ( ( $this->EEoNucleo->gedeeProcesoEjecucion() == 'modulo') ) ) && ( $this->existencia_id_appmod( $id_aplicacion ) == 'aplicacion' ) && ( ( $tipo_accion == 1 ) || ( $tipo_accion == 2 ) || ( $tipo_accion == 3 ) ) )
      {
      if ( empty( $estructura_acceder) && ( ( $tipo_accion == 2 ) || ( $tipo_accion == 3 ) ) )
      {
      return null ;
      }

      $id_aplicacion_actual = $this->EEoNucleo->aplicacion_ejecucion();
      $id_modulo_actual = $this->EEoNucleo->modulo_ejecucion();

      //////////////////////gestionando identificadores de alpicacion y modulo//////////////////////

      if ( strtolower( $id_aplicacion  ) == 'hereda' )
      {
      $id_aplicacion = $id_aplicacion_actual ;
      }
      if ( !empty( $id_modulo ) )
      {
      if ( strtolower( $id_modulo ) == 'hereda' )
      {
      $id_modulo = $id_modulo_actual ;
      }
      }
      $existencia_id_appmod = $this->existencia_id_appmod( $id_aplicacion , $id_modulo ) ;
      if ( empty( $existencia_id_appmod ) )
      {
      return null ;
      }
      ///////////////////////gestionando los permisos de acceso////////////////////

      $gedee_proceso_ejecucion = $this->EEoNucleo->gedeeProcesoEjecucion();
      if ( !$this->EEoSeguridad )
      {
      return null ;
      }
      $tipo_acceso = null ;
      switch ( $gedee_proceso_ejecucion )
      {
      case 'aplicacion'     :     $tipo_acceso = $this->EEoSeguridad->clienteAccesoConfiguracionProceso( $id_aplicacion );
      break ;
      case 'modulo'         :     $tipo_acceso = $this->EEoSeguridad->clienteAccesoConfiguracionProceso( $id_aplicacion , $id_modulo );
      break ;

      }

      if ( $tipo_acceso )
      {
      $acceso_leer = null ;
      $acceso_escribir = null ;
      $acceso_eliminar = null ;

      if ( is_string( $tipo_acceso ) )
      {
      $arreglo_acceso = explode( '::' , $tipo_acceso ) ;
      foreach ( $arreglo_acceso as $elemento)
      {
      switch ( $elemento )
      {
      case 'leer'     : $acceso_leer = 'leer' ;
      break ;
      case 'escribir' : $acceso_escribir = 'escribir' ;
      break ;
      case 'eliminar' : $acceso_eliminar = 'eliminar' ;
      break ;
      }
      }
      }

      if ( ( ( $tipo_modificacion == 1 ) && ( $acceso_leer != 'leer' ) ) || ( ( $tipo_modificacion == 2 ) && ( $acceso_escribir != 'escribir' ) ) || ( ( $tipo_modificacion == 3 ) && ( $acceso_eliminar != 'eliminar' ) ) )
      {
      return null ;
      }
      }
      else
      {
      return null ;
      }
      ////////////////////////implementacion del acceso gestionado//////////////////////////////////

      $La_resultado = null;

      switch ( $gedee_proceso_ejecucion )
      {
      case 'aplicacion' : switch ( $tipo_modificacion )
      {
      case 1 : //leer
      if ( is_array( $estructura_acceder ) && empty( $estructura_acceder ) )
      {
      $La_resultado = $this->datos_configuracion_appmod[$id_aplicacion];
      }
      elseif( is_string( $estructura_acceder ) && ( stripos( $estructura_acceder , ';' ) === false ) && ( stripos( $estructura_acceder , ')' ) === false ) && ( stripos( $estructura_acceder , '{' ) === false ) )
      {

      $cadena_ejecutar = " if ( isset( \$this->datos_configuracion_appmod[\$id_aplicacion]$estructura_acceder ) )
      {
      \$La_resultado = \$this->datos_configuracion_appmod[\$id_aplicacion]$estructura_acceder ;
      }
      ";
      eval( $cadena_ejecutar );
      }
      return $La_resultado ;

      case 2 : //escribir o modificar
      $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloModificarRecursivo( $estructura_acceder , $this->datos_configuracion_appmod[$id_aplicacion] , $condicion_modificacion );
      break ;

      case 3 : //eliminar
      $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloEliminarRecursivo( $estructura_acceder , $this->datos_configuracion_appmod[$id_aplicacion] , $condicion_modificacion );
      break  ;
      }
      if ( ( $tipo_modificacion != 1 ) && !empty( $La_resultado ['arreglo_base'] ) )
      {
      $this->datos_configuracion_appmod[$id_aplicacion] = $La_resultado ['arreglo_base'] ;
      return true ;
      }
      break ;

      case 'modulo'     : switch ( $tipo_modificacion )
      {
      case 1 : //leer
      if ( is_array( $estructura_acceder ) && empty( $estructura_acceder ) )
      {
      $La_resultado = $this->datos_configuracion_appmod[$id_aplicacion]['modulos'][$id_modulo];
      }
      elseif( is_string( $estructura_acceder ) && ( stripos( $estructura_acceder , ';' ) === false ) && ( stripos( $estructura_acceder , ')' ) === false ) && ( stripos( $estructura_acceder , '{' ) === false ) )
      {

      $cadena_ejecutar = " if ( isset( \$this->datos_configuracion_appmod[\$id_aplicacion]['modulos'][\$id_modulo]$estructura_acceder ) )
      {
      \$La_resultado = \$this->datos_configuracion_appmod[\$id_aplicacion]['modulos'][\$id_modulo]$estructura_acceder ;
      }
      ";
      eval( $cadena_ejecutar );
      }
      return $La_resultado ;

      case 2 : //escribir o modificar
      $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloModificarRecursivo( $estructura_acceder , $this->datos_configuracion_appmod[$id_aplicacion]['modulos'][$id_modulo] , $condicion_modificacion );
      break ;

      case 3 : //eliminar
      $La_resultado = \Emod\Nucleo\Herramientas\EArreglo::arregloEliminarRecursivo( $estructura_acceder , $this->datos_configuracion_appmod[$id_aplicacion]['modulos'][$id_modulo] , $condicion_modificacion );
      break ;
      }
      if ( ( $tipo_modificacion != 1 ) && !empty( $La_resultado ['arreglo_base'] ) )
      {
      $this->datos_configuracion_appmod[$id_aplicacion]['modulos'][$id_modulo] = $La_resultado ['arreglo_base'] ;
      return true ;
      }
      break ;
      }
      }
      return null ;
      }

      }

     */
    /* 	
      $miobjeto = Configuracion_gestor::instanciar();
      $miobjeto ->inicializacion ('', 'home_app') ;
      $arreglo=$miobjeto->gestion_config('id_','1/2/3','parser/e_config_parser.php','configuracion/spyc.yaml');
      echo var_dump($arreglo);
     */
    /* 	
      //////////////////////////////////////////////////////////////////////////////////////////////

      ----e_gestor_config----

      Clase para la gestion de configuraciones .

      Ejemplo:
      $obj = new e_gestor_config( $Ls_pathfich_parser = '' , $Ls_pathdir_cache = '' );

      ///////////////////////////////funciones de esta clase/////////////////////////

      ----inicializacion----

      La funci�n inicializacion, como bien se ve en el ejemplo de inicializacion de la instancia, tiene los siguientes par�metros

      $Ls_pathfich_parser(string) contendr� la direcci�n de un fichero parser para tomarlo como parser por defecto de la instancia de esta clase
      $Ls_pathdir_cache(string) contendr� la direcci�n de un directorio donde se crearan y/o leeran los ficheros cach� de las configuraciones, si se deja el valor por defecto o se introduce un valor vacio se crear�n o buscaran los ficheros cach� en la ubicaci�n donde est� la instancia de la clase.Para las aplicaciones y m�dulos de estas este directorio estar� en homeapp

      $resultado puede ser:
      en caso que alguno de los par�metros tenga valor vac�o se emite mediante echo un mensaje de alerta y contin�a la instanciaci�n.

      //////////////////////////////////////////////////////////////////////////////
      ----chequeo_cahe_config----

      Esta funci�n se encarga de chequear, en correpondencia con los par�metros, si existe el fichero cache de la configuraci�n y si este fu� modificado en fecha y hora mas reciente que el fichero de configuraci�n.

      Descripci�n:

      ($resultado) chequeo_cahe_config ( $Ls_fich_config , $Ls_fich_cache )

      alcance: private

      $Ls_fich_config(string) contendr� la direcci�n o path del fichero de configuraci�n.
      $Ls_fich_cache(string) contendr� la direcci�n o path del fichero cach�.

      $resultado puede ser:
      true, si existe el fichero cach� y fu� modificado mas recientemente que el fichero de configuraci�n.
      null, en caso de no ser true.
      en caso que alguno de los par�metros tenga valor vac�o se emite mediante echo un mensaje de alerta y luego el valor null.

      ////////////////////////////////////////////////////////////////////////////////////////

      ----creacion_cache_config----

      Esta funci�n se encarga de crear un fichero (cach�) con una estructura de datos legibles para PHP, partiendo de los datos que se le transfieren a la funci�n a trav�s del par�metro $La_datos_contenido.

      Descripci�n:

      alcance: private

      ($resultado) creacion_cache_config ( $Ls_path_fichcache , $La_datos_contenido )

      $Ls_path_fichcache(string) contendr� la direcci�n o path donde se crear� el fichero cach�, si existe se sobreescribe sino se crea.
      $La_datos_contenido(tipo) contendr� el valor a plasmar con una estructura de datos legibles para PHP en el fichero cach�.

      $resultado puede ser:
      true, si pudo crear el fichero con �xito.
      null, si no es true.
      en caso que alguno de los par�metros tenga valor vac�o se emite mediante echo un mensaje de alerta y luego el valor null.

      ////////////////////////////////////////////////////////////////////////////////////////

      ----gestion_config----

      Esta funci�n se encarga de gestionar los datos de configuraci�n, si existen en cach� y estos est�n actualizados los obtiene por esta v�a, si lo anterior no es posible, gestiona el parser y el fichero de configuraci�n en correspondencia con los par�metros de la funci�n e intenta crear un fichero cach� con los datos de configuraci�n, luego emite la configuraci�n     buscar coincidencias de nombre en el fichero alias en corespondencia con los par�metros introducidos

      Descripci�n:

      alcance: public

      ($resultado) gestion_config ( $Ls_identifica , $Ls_path_operat , $Ls_fich_parser , $Ls_fich_conf = '' , $Ls_path_base = '' )

      $Ls_identifica(string) es un identificativo que acompa�ar� al nombre de la configuraci�n o el paser y que conformar�n el nombre del fichero cach�, quedando como nombre del fichero cache $Ls_identifica_nombredelficheroconfiguracion o $Ls_identifica_nombredelficheroparser, segun corresponda .
      $Ls_path_operat(string) es el fragmento de path que tiene como ra�z el fichero parser y el fichero configuraci�n (de existir este) y que se recorrer� hacia arriba en el �rbol de directorios en busca de estos ficheros mencionados anteriormente en caso de no existir estos ficheros en el path original.
      $Ls_fich_parser(string) contendr� el path del fichero parser teniendo como ra�z los directoros declarados en los par�metros $Ls_path_operat y $Ls_path_base.
      $Ls_fich_conf(string) contendr� el path del fichero de configuraci�n teniendo como ra�z los directoros declarados en los par�metros $Ls_path_operat y $Ls_path_base.
      $Ls_path_base(string) es el fragmento de path que tiene como ra�z el fichero parser y el fichero configuraci�n (de existir este) y que no se recorrer� hacia arriba en el �rbol de directorios en busca de estos ficheros mencionados anteriormente en caso de no existir estos ficheros en el path original.

      $resultado puede ser:
      array, contendr� en su estructura la configuraci�n gestionada.
      NULL, en caso de ser cargado el fichero cach� y como resultado final de la gesti�n, contener la variable que emite la funci�n un valor vac�o o ser de un tipo diferente a array.
      se emite mediante echo un mensaje de error y luego el valor null cuando:
      1- el par�metro $Ls_identifica contiene un valor vac�o.
      2- el par�metro $Ls_path_operat contiene un valor vac�o.
      3- el par�metro $Ls_fich_parser contiene un valor vac�o.
      4- el par�metro $Ls_fich_parser contiene el valor 'hereda'�y no existe el fichero en el path especificado.
      5- el par�metro $Ls_fich_parser contiene un valor determinado y no existe el fichero en el path especificado.
      6- el fichero parser es incluido y como resultado de la gesti�n de configuraci�n se obtiene una variable con valor vac�o o de un tipo diferente a array.
      se emite mediante echo un mensaje de alerta en caso que exista un valor admitido para la configuraci�n y el fichero cach� no pueda ser creado.
      //////////////////////////////////////////////////////////////////////////////////////////

      El esquelemod concidera la gesti�n de datos como un elemento indispensable a tener en cuenta para la escalabilidad, flexibilidad, personalizaci�n y portabilidad
      de un sistema o aplicaci�n, es por ello que separa la gesti�n de datos de la implementaci�n de estos. El sistema de gestion de configuraciones del esquelemod implementa
      lo expuesto anteriormente, para el esquelemod la gesti�n de configuraciones se realiza con el protagonismo de tres elementos que a continuaci�n explicamos:

      1- Instancia de la clase e_gestor_config es qui�n localiza la configuraci�n y/o el parser para la gesti�n de datos de esta configuraci�n, adem�s de getionar el sistema de cacheo para
      cada paquete de datos configuraci�n. Segun los datos introducidos a la instancia en los par�metros de sus m�todos, esta busca la localizaci�n del fichero parser
      para implementarlo mediante include, teniendo en el momento de esta implementaci�n localizado tambi�n al fichero de configuraci�n para que el parser pueda hacer
      su gesti�n de datos con el fichero configuraci�n. En la ayuda de la clase estan explicados las propiedades, los metodos y sus par�metros.

      2- Fichero parser es qui�n implementa la forma en que se extraer�n los datos de configuraci�n, este fichero ser� implementado a trav�s de include.
      Es este fichero qui�n contiene el c�digo php que interpreta o extrae los datos de configuraci�n de determinada fuente, la fuente de datos puede ser
      cualquiera, solo depende del parser servir como puente entre esa estructura y soporte de datos y la instancia gestionadora de configuraciones. Este
      c�digo al ser incluido debe cumplir 3 requisitos
      1-en caso de trabajar con un fichero de configuraci�n gestionado por la instancia de la clase e_gestor_config el path de este fichero de configuraci�n
      gestionado se encuentra en una variable con nombre $Ls_pathfinal_config, variable que hereda el parser del c�digo de la instacia por ser el parser incluido
      en el c�digo de la instancia.
      2-Por el mismo principio de ser el fichero parser incluido en el c�digo de la instancia, debe contener una variable de nombre $La_config_final y de tipo arreglo donde
      se introduciran los datos correspondientes a la configuraci�n gestionada, para luego ser trabajados por la instancia.
      3-no se debe terminar el script o debolver datos con return.

      no es obligatorio que el fichero parser tenga en cuenta un fichero de configuraci�n, puesto que el mismo fichero parser puede gestionar los datos de configuraci�n de
      otras fuentes como bases de datos o pedidos a otros gestores.

      ejemplo de un parser

      <?php

      include_once ( 'spyc/Spyc.php' ) ;
      $La_config_final = Spyc::YAMLLoad( $Ls_pathfinal_config );

      ?>
      3- Fichero configuraci�n es qui�n constituye la estructura de la configuraci�n en su forma personalizada o t�pica, ser� interpretado por el parser, puede existir o no en dependencia
      de la gesti�n del parser

      Los ficheros parser y de configuraci�n ser�n gestionados buscando primero sus path en la direcci�n exacta uqe se introduce como path en los par�metros de la instancia
      y si no se encuentran se buscan hacia atras nivel por nivel de directorio, hasta encontrarlos indistintamente o llegar a la raiz del path declarado en el par�metro del m�todo de la instancia,
      para tener mayor conocimiento sobre el tema ver la ayuda de la clase e_gestor_config.

      La instancias de esta clase antes de gestionar los datos de configuraciones intentar�n encontrar una cach� de estos datos, y si no la encuentra crear� una, todo esto en dependencia de los datos
      introducidos en los par�metros de los m�todos correspondientes a esta funcionalidad, y que se encuentran detallados en la ayuda de la clase,

      el fichero cache debe tener la siguiente estructura

      <?php
      $La_config_cache= *datos del arreglo*

      return($La_config_cache);

      ?>

      El tratamiento del parser y el fichero de configuraci�n con el identificador como parametro en la funcion, se debe a que se permite tener un solo parser para diferentes ficheros de configuracion y por ello cada ves que se crea una cache
      de diferentes ficheros de configuracion pero con el mismo parser, esta cache debe tener un nombre que no sobreesciba otra cahe de otro archivo de configuracion.
      El fichero de configuracion se puede omitir, si y solo si el parser lo gestiona o gestiona por si solo los datos, en este caso el fichero cache toma el nombre $Ls_identifica_nombredelficheroparser
     */
?>