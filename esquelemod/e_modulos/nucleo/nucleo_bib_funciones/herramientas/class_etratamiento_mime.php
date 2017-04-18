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
 * ETratamientoMIME class
 * @version 0.0.1
 * @author Alain Borrell Castellanos <bcalain@gmail.com>
 * @link https://github.com/bcalain/SOCKELETOM
 * @copyright Copyright 2017 Alain Borrell Castellanos
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL License
 */

 namespace Emod\Nucleo\Herramientas ;
 
 class ETratamientoMIME 
	{
		static private $lsPathFicheroInfoMIME = 'FILEINFO_MIME_TYPE' ;
		
		static public function ficheroInfoMimeTypeDefecto( $Ls_path_fichero_info_mime = NULL )
			{
				if ( !empty( $Ls_path_fichero_info_mime ) && is_file( $Ls_path_fichero_info_mime ) )
					{
						self::$lsPathFicheroInfoMIME = $Ls_path_fichero_info_mime ;
						return TRUE ;
					}
				return NULL ;
			}
		static public function salidaRecursoMIME( $Ls_path_recurso , $Ls_path_fichero_info_mime = 'hereda' )
			{
				if ( !empty( $Ls_path_recurso ) && !empty( $Ls_path_fichero_info_mime ) )
					{
						if ( ( $Ls_path_fichero_info_mime == 'FILEINFO_MIME_TYPE' ) || ( $Ls_path_fichero_info_mime == 'hereda' ) || is_file( $Ls_path_fichero_info_mime ) )
							{
								if ( $Ls_path_fichero_info_mime == 'FILEINFO_MIME_TYPE' )
									{
										$finfo = finfo_open( FILEINFO_MIME_TYPE ) ;
									}
								elseif ( $Ls_path_fichero_info_mime == 'hereda' )
									{
										$finfo = finfo_open( self::$lsPathFicheroInfoMIME ) ;
									}
								else 
									{
										$finfo = finfo_open( $Ls_path_fichero_info_mime ) ;
									}
									
								$tipo_mime_recurso = finfo_file( $finfo, $Ls_path_recurso ) ;
						
								finfo_close($finfo) ;
						
								header("Content-type: $tipo_mime_recurso") ;
								readfile( $Ls_path_recurso ) ;
								die() ;
							}
					}
				trigger_error('El recurso MIME o el path del fichero info MIME no contienen valores v&aacute;lidos para la gesti&oacute;n satisfactoria de este procedimiento' , E_USER_ERROR ) ;	
			}
	}
 
 



?>