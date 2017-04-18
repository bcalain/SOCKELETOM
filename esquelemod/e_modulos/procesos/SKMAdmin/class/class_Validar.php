<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Clase para validar datos.
 * Incluye procedimientos de CodeIgniter. La licencia de CodeIgniter la puede encontrar
 * en la direccion mas abajo. SKMAdmin incuye una copia.
 * 
 * @license		http://codeigniter.com/user_guide/license.html
 *
 * @author Oscar
 */
class class_Validar
{
    /**
     * Filtra el dato que se le pasa como parametro
     * 
     * @access public
     * 
     * @param array $arrayDatos Se especifican las variables GET o POST que se desean filtrar.
     * @param string $tipo Tipo de filtros que se desean aplicar (string, int, email).
     * @param string $origen Origen de los datos que se van a filtrar (GET o POST).
     * 
     * @return bool 
     */
    public function filtrarSpecialChars($arrayDatos, $tipo = "string", $origen = "GET")
    {
        switch ($tipo) {
        case "string":
            foreach ($arrayDatos as $key => $valor) {
                $datoFiltrado = $this->_filtrarString($valor, $origen);
            }
            break;

        case "int":

            break;

        case "email":

            break;
        default:
            break;
        }

        return ($datoFiltrado == FALSE || $datoFiltrado == NULL)? FALSE : TRUE;
        
    }
    
    
    // --------------------------------------------------------------------
    
    /**
     * Comprueba si la cadena pasada es un string
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public function alpha($str)
    {
        return (!preg_match("/^([a-z])+$/i", $str)) ? FALSE : TRUE;
    }

    // --------------------------------------------------------------------
    
    /**
     * Modificado a partir del original de CodeIgniter
     *
     * @access	public
     * @param	string
     * @param	value
     * @return	bool
     */
    public function min_length($str, $val)
    {
        if (preg_match("/[^0-9]/", $val)) {
            return FALSE;
        }

        if (function_exists('mb_strlen')) {
            return (mb_strlen($str) < $val) ? FALSE : TRUE;
        }

        return (strlen($str) < $val) ? FALSE : TRUE;
    }


    // --------------------------------------------------------------------

    /**
     * Modificado a partir del original de CodeIgniter
     *
     * @access	public
     * @param	string
     * @param	value
     * @return	bool
     */
    public function max_length($str, $val)
    {
        if (preg_match("/[^0-9]/", $val)) {
            return FALSE;
        }

        if (function_exists('mb_strlen')) {
            return (mb_strlen($str) > $val) ? FALSE : TRUE;
        }

        return (strlen($str) > $val) ? FALSE : TRUE;
    }
    
    
    // --------------------------------------------------------------------
    /**
     * Modificado a partir del original de CodeIgniter
     *
     * @access	public
     * @param	string
     * @param	value
     * @return	bool
     */
    public function exact_length($str, $val)
    {
        if (preg_match("/[^0-9]/", $val)) {
            return FALSE;
        }

        if (function_exists('mb_strlen')) {
            return (mb_strlen($str) != $val) ? FALSE : TRUE;
        }

        return (strlen($str) != $val) ? FALSE : TRUE;
    }
    
    
    // --------------------------------------------------------------------
    
    /**
     * Modificado a partir del original de CodeIgniter
     * Valid Email
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public function valid_email($str)
    {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }

    // --------------------------------------------------------------------
    
    /**
     * Modificado a partir del original de CodeIgniter
     * Valid Emails
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public function valid_emails($str)
    {
        if (strpos($str, ',') === FALSE) {
            return $this->valid_email(trim($str));
        }

        foreach (explode(',', $str) as $email) {
            if (trim($email) != '' && $this->valid_email(trim($email)) === FALSE) {
                return FALSE;
            }
        }

        return TRUE;
    }

    
    // --------------------------------------------------------------------
    
    /**
     * Alpha-numeric
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public function alpha_numeric($str)
    {
        return (!preg_match("/^([a-z0-9])+$/i", $str)) ? FALSE : TRUE;
    }

    
    // --------------------------------------------------------------------
    
    /**
     * Decimal number
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public function decimal($str)
    {
        return (bool) preg_match('/^[\-+]?[0-9]+\.[0-9]+$/', $str);
    }

    
    // --------------------------------------------------------------------
    
    /**
     * Filtra la cadena que se le pase como parametro.
     * Es llamado por filtrarSpecialChars()
     *
     * @access	private
     * @param string $param Nombre del dato GET o POST a filtrar.
     * @param string $origen Describe si se van a filtrar datos recibidos por GET o POST.
     * @return	bool
     */   

    private function _filtrarString($param, $origen)
    {
        $filtro = [$param => ['filter' => FILTER_SANITIZE_STRING,
                              'flags'  => ['FILTER_FLAG_STRIP_LOW', 'FILTER_REQUIRE_ARRAY']]];

        if ($origen == "GET") 
        {
            return filter_input_array(INPUT_GET, $filtro);
        } 
        elseif ($origen == "POST") 
        {
            return filter_input_array(INPUT_POST, $filtro);
        }
    }

   // --------------------------------------------------------------------

    
    /**
     * Analiza $_GET o $_POST y convierte todos los caracteres aplicables a entidades HTML.
     *
     * @access	public
     * @param array $arr Arreglo $_GET o $_POST
     * @return	array Devuelve el array codificado.
     */    
    public function htmlentitiesGetPost($arr)
    {
        if (!is_array($arr)) {
            $arr = htmlentities($arr, ENT_QUOTES, "UTF-8");
        } else {
            foreach ($arr as $key => $value)
                $arr[$key] = $this->htmlentitiesGetPost($value);
        }
        return $arr;
    }
    //$_CLEAN['GET'] = clean($_GET);
    //$_CLEAN['POST'] = clean($_POST); 


    // --------------------------------------------------------------------
 
    /**
     * Tomado de CodeIgniter
     * Required
     *
     * @access	public
     * @param	string
     * @return	bool
     */
    public function required($str)
    {
        if (!is_array($str)) {
            return (trim($str) == '') ? FALSE : TRUE;
        } else {
            return (!empty($str));
        }
    }

}
