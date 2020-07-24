<?php
	//sign
	ini_set('display_errors', 1);
	$passphrase1='655e97a6514b307c782f3b326';
	$passphrase2='85bfb9af3a58';
	$passphrase3='8454b180edc3e9834204';
	$passphrase4='791d3af6a7fc5e619dd58a6a38bc5552';
	$passphrase5='82bbabc81626803b';
	$passphrase6='32e0a7328ef31610b232a37a6f78b';
	$passphrase7='326810b0';
	$filekey = 'pair_key.pem';
	
	function mysignkey()
		{
			global $passphrase1, $filekey ;
			
			// crear unas claves publica y privada nuevas
			$new_key_pair = openssl_pkey_new(array(
				"private_key_bits" => 2048,
				"private_key_type" => OPENSSL_KEYTYPE_RSA,
			));
			
			return openssl_pkey_export_to_file ( $new_key_pair , $filekey , $passphrase);
		}
	
	
	function mysign($data_tosign)
		{
			global $passphrase, $filekey ;
			$data_signed = null ;
			//buscando key pprivado en archivo
			$idkey=openssl_pkey_get_private ( $filekey ,$passphrase );
			
			// crear la firma
			openssl_sign($data_tosign, $data_signed, $idkey, OPENSSL_ALGO_SHA256);
			
			// liberar la clave de la memoria
			openssl_free_key($idkey);
			
			return $data_signed ;
			
		}
	// me quede en provar todo esto
	//echo mysignkey();
	//echo 'llllllllllllll';
