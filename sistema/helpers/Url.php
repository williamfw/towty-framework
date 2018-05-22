<?php

namespace sistema\helpers;

/* Autor: William Fabrício Werling
 * Data: 20/08/2013
 * Descrição: Classe para manipulação de URL 
 */

class Url
{
	/* Este método pega uma string comum, remove todos os caracteres especiais e 
	 * separa cada palavra por '-', para que se torne parte de uma URL amigável.
	 */ 
	public static function toUrlAmigavel($string, $replace = array(), $delimitador = '-') 
	{
	    if(!empty($replace)) 
	    {
	        $string = str_replace((array)$replace, ' ', $string);
	    }
	 
	    $urlLimpa = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
	    $urlLimpa = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $urlLimpa);
	    $urlLimpa = strtolower(trim($urlLimpa, '-'));
	    $urlLimpa = preg_replace("/[\/_|+ -]+/", $delimitador, $urlLimpa);
	 
	    return $urlLimpa;
	}
}
