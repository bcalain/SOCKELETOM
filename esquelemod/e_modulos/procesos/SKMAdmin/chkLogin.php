<?php
/*
    SKM Config Herramienta para la configuración de SOCKELETOM (SKM)  
    Copyright (C) 2016  Oscar Luis Inguanzo Martínez

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

    email-contact oscarlim@nauta.cu
*/

$path2loadAbs = $this->EEoNucleo->pathAbsolutoDirRaizProcesoEjecucion()."/";
$user_input = filter_input(INPUT_POST,'inputUser',FILTER_SANITIZE_SPECIAL_CHARS);
$user_pass  = filter_input(INPUT_POST,'inputPass',FILTER_SANITIZE_SPECIAL_CHARS);


/* Comprobamos y leemos el fichero passwd */
if(file_exists($path2loadAbs."passwd")){
    $arrayFilePasswd = file($path2loadAbs."passwd",FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
    foreach ($arrayFilePasswd as $num_línea => $línea) {
        $arrayUserPass = explode("::", rtrim($línea));
        if($arrayUserPass[0] == $user_input){
            // Si login correcto creamos las variables de sesión y redireccionamos
            if (crypt($user_pass, $arrayUserPass[1]) == $arrayUserPass[1]) {
                session_start();
                session_regenerate_id();
                $_SESSION['SessionUser'] = $user_input;
                $_SESSION['SessionIP'] = $_SERVER['REMOTE_ADDR'];
                
                // Guardamos en un tmp la sessionid+IP+usuario para mayor seguridad
                file_put_contents($path2loadAbs."tmp/".session_id(), session_id()."||".$_SESSION['SessionIP']."||".$_SESSION['SessionUser'],LOCK_EX);

                if ($_SESSION['SessionUser'] == "root") {
                    header('Location: ?app=inicioconfig&tab=0');
                }
                die();
            }else{
                header('Location: ?app=config&login=false');
                die();
            }           
        }
    }
    echo "No se pudo comprobar su nombre de usuario y contrase&ntilde;a";
    die();
}else{
    die("No se puede comprobar su nombre de usuario y contraseña");
}

