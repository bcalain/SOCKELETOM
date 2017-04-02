<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class class_SessionControl
{

    public $path2loadAbs;

    function __construct($path2load)
    {
        $this->path2loadAbs = $path2load;
    }

    // --------------------------------------------------------------------
    
    /**
     * Función para comprobar el estado de la sesión.
     * Devuelve bool
     */
    public function is_session_started()
    {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return session_status() === PHP_SESSION_ACTIVE ? true : false;
            } else {
                return session_id() === '' ? false : true;
            }
        }
        return false;
    }

    // --------------------------------------------------------------------
    
    /**
     * Borrar fichero temporal para el control de la sesión
     */
    public function deleteTmpSession()
    {
        if (file_exists($this->path2loadAbs . 'tmp/' . session_id())) {
            @unlink($this->path2loadAbs . 'tmp/' . session_id());
        }
    }

    // --------------------------------------------------------------------
    
    /*
     * Comprobar IP contra id de sesión
     * Devuelve TRUE o FALSE
     */
    public function chkIP()
    {
        //$this->path2loadAbs = $path2loadAbs;
        if (file_exists($this->path2loadAbs . 'tmp/' . session_id())) {
            $arraytmp = file($this->path2loadAbs . "tmp/" . session_id(), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($arraytmp as $num_línea => $línea) {
                $arrayIP = explode("||", rtrim($línea));
                return(($arrayIP[1] == $_SERVER['REMOTE_ADDR']) && ($arrayIP[0] == session_id())) ? true : false;
            }
        } else {
            return FALSE;
        }
    }

}
