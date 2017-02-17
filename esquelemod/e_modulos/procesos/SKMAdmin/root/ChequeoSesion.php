<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!isset($path2loadAbs)) {
    $path2loadAbs = $this->EEoNucleo->pathAbsolutoDirRaizProcesoEjecucion() . '/';
}

if (!@include_once $path2loadAbs . 'class/class_SessionControl.php') {
    die("Error. Imposible chequear la sesi&oacute;n. " . basename(__FILE__) . '. Linea:' . __LINE__);
} else {
    $obj = new class_SessionControl($path2loadAbs);
    if ($obj->is_session_started() === FALSE)
        session_start();
    if ($obj->chkIP() === FALSE)
        die('ERROR al crear la sesi&oacute;n');
}


