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
   * GedeeEPadre class
   * @version 0.0.1
   * @author Alain Borrell Castellanos <bcalain@gmail.com>
   * @link https://github.com/
   * @copyright Copyright 2010 Alain Borrell Castellanos
   * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
   */	

    namespace Emod\Nucleo\Gedees ;

    abstract class GedeeEPadre
        {

         abstract public function existenciaIdProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' ) ;
            
        //////////////////////////////////// pocedimientos referentes a class ConfiguracionProcesos /////////////////////////////////////////////////////////////////
       
         abstract public function iniciarDatosConfiguracionProceso( &$fuente_datos_procesos ) ;
            
         abstract public function accederDatosConfiguracionProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' ) ;
         
        //////////////////////////////////// pocedimientos referentes a class SeguridadProcesos /////////////////////////////////////////////////////////////////
        
         abstract public function iniciarDatosSeguridadProceso( &$fuente_datos_procesos ) ;
            
         abstract public function accederDatosSeguridadProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' ) ;
            
         abstract public function clienteEjecucionProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' ) ;
            
         abstract public function clienteAccesoDatosProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' ) ;
            
         abstract public function clienteAccesoConfiguracionProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' ) ;
            
        //////////////////////////////////// pocedimientos referentes a class DatosProcesos, datos salida de este proces /////////////////////////////////////////////////////////////////
        
         abstract public function iniciarDatosSalidaProceso( &$fuente_datos_procesos ) ;
            
         abstract public function accederDatosSalidaProceso( &$fuente_datos_procesos , $id_proceso = 'hereda' ) ;
            
        }

?>		