<?php
	//file
	use Lablnet\Encryption; //se debe cargar esta clase externa
	/* se deben requerir estas clases en sus paths
    require_once($_SERVER["DOCUMENT_ROOT"].'/crypt/php-encryption-class/src/Encryption.php');
	require_once($_SERVER["DOCUMENT_ROOT"].'/crypt/php-encryption-class/src/Adapter/AbstractAdapter.php');
	require_once($_SERVER["DOCUMENT_ROOT"].'/crypt/php-encryption-class/src/Adapter/OpenSslEncryption.php');
	require_once($_SERVER["DOCUMENT_ROOT"].'/crypt/php-encryption-class/src/Adapter/SodiumEncryption.php');
	*/
//arreglo que se utilizara para configurar las claves a utilizar en los metodos de encriptamiento, ojo existen metodos que utilizan solo una clave y entonces hacen referencia a solo una clave dentro del arreglo
$array_key_crypt = [
    					'77c702ed4c7af0fa3878939c8b3de',
    					'65cbe4b8d72bda8a9bae256632a9703a6db',
    					'842e7a0',
    					'69a5910f8d8ada',
    					'828095afedc19f2bd97e18f',
    					'7366f097c38cf46a9741bb51aa',
    					'659a9e8b'
					] ;

/* *
 * Funcion encargada de encriptar una cadena utilizado llave y
 * codificacion base64
 *
 * Recibe dos parametros:
 * @param type string $string que es la cadena a encriptar
 * @param type string $key que es la llave para la encriptacion
 *
 * Devuelve un string con la cadena encriptada
 *
 * Ejemplo llamada a funcion:
 *
 * $key="lHk954di_-\\"
 * $cadena_codificada=encrypt($cadena_a_codificar, $key);
 *
 * SGM 130216
 */
function encrypt($string, $key) {
    $result = '';
    for($i=0; $i<strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)+ord($keychar));
        $result.=$char;
    }

    $result=base64_encode($result);
    $result = str_replace(array('+','/','='),array('-','_','.'),$result);
    return $result;
}
/* *
 * Funcion encargada de desencriptar una cadena utilizado llave y
 * codificacion base64
 *
 * Recibe dos parametros:
 * @param type string $string que es la cadena a encriptar
 * @param type string $key que es la llave para la encriptación
 *
 * Devuelve un string con la cadena encriptada
 *
 *
 * $key="lHk954di_-\\"
 * $cadena_descodificada=dencrypt($cadena_a_codificar, $key);
 *
 * SGM 130216
 */
function decrypt($string, $key) {
    $string = str_replace(array('-','_','.'),array('+','/','='),$string);
    $result = '';
    $string = base64_decode($string);
    for($i=0; $i<strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)-ord($keychar));
        $result.=$char;
    }
    return $result;
}
/* *
 * Funcion encargada de encriptar una cadena utilizado llave y
 * codificacion base64, las llaves las obtiene de un arreglo con indices numericos
 * las que va seleccionando de forma aleatoria en dependencia de los valores en los parametros
 *
 * Recibe cutro parametros:
 * @param type string $string que es la cadena a encriptar
 * @param type int $mod es el modulo de encriptamiento que se utilizara, los modulos contienen el algoritmo de encriptamiento
 * @param type array $array_keys que es el arreglo de llaves para el  encriptamiento
 * @param type boolean $key_aleatory define si se utilizaran keys aleatorias es decir si se utilizaran keys escogidas aleatoriamente del $array_keys para el encriptamiento
 *
 * Devuelve un string con la cadena encriptada
 *
 * Ejemplo llamada a funcion:
 *
 *$cadena_codificada=myencrypt($string, 2, $array_keys , true);
 *
 */
function myencrypt($string ,$mod ,$array_keys, $key_aleatory=false )
{
	$pos_key = 0 ;
	if($key_aleatory)
		{
			$cant_keys = count($array_keys);
			$pos_key=rand(0,$cant_keys);
		}
	$key=  $array_keys[$pos_key] ;
	switch ($mod)
		{
			case 1 :
						$cadena_encrypt = encrypt($string, $key);
						break ;
						
			case 2 :
						$encryption = new Encryption('openssl', $key);
						//Encrypt the message
						$cadena_encrypt = $encryption->encrypt($string);
						break ;
		}
	$cadena_encrypt = $pos_key.$cadena_encrypt ;
	return $cadena_encrypt;
}

/* *
* Funcion encargada de desencriptar una cadena utilizado llave y
* codificacion base64, las llaves las obtiene de un arreglo con indices numericos
* las que va seleccionando de forma aleatoria
*
* Recibe dos parametros:
* @param type string $cadena_encrypt que es la cadena a desencriptar
* @param type int $mod es el modulo de encriptamiento que se utilizara, los modulos contienen el algoritmo de encriptamiento
* @param type array $array_keys que es el arreglo de llaves para el  encriptamiento
*
*
* Devuelve un string con la cadena desencriptada
*
* Ejemplo llamada a funcion:
*
*$cadena_decodificada=mydecrypt($cadena_encrypt , 2 ,$array_keys);
*
*/
function mydecrypt( $cadena_encrypt, $mod, $array_keys )
{
	$pos_key = substr( $cadena_encrypt , 0,1) ;
	$key = $array_keys[$pos_key];
	$cadena_encrypt = substr( $cadena_encrypt , 1);
	switch ($mod)
		{
   			case 1 :
						$cadena_decrypt = decrypt($cadena_encrypt , $key);
						break ;
			case 2 :
						$encryption = new Encryption('openssl', $key);
						//Decrypt the message
						$cadena_decrypt = $encryption->decrypt($cadena_encrypt);
						break ;
		}
	return $cadena_decrypt;
	
}
/* *
* Funcion encargada de extraer de una url la porcion correspondiente a parametros get
* *
* Recibe un parametro:
* @param type string $string_url que es la url a porcionar
*
* Devuelve un string con la cadena correspondiente a parametros get
*
* Ejemplo llamada a funcion:
*
*$cadena_get=extract_str_get($string_url);
*
*/
//funcion que se omite por existencia de funcion php parse_url ( string $url [, int $component = -1 ] ) : mixed en PHP_URL_QUERY
/*
	function extract_str_get($string_url)
{
    if($position_char=stripos($string_url,'?'))
    {
        $string_get = substr($string_url, $position_char+1 );
        return $string_get ;
    }
    return null ;
}
*/


return $array_key_crypt ;

