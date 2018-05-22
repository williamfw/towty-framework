<?php

namespace sistema\helpers;

/* Autor: William Fabrício Werling
 * Data: 20/08/2013
 * Descrição: Classe com alguns métodos uteis que podem ser usados no sistema 
 */
class Util
{
	public static function toDecimal($valor)
    {
        $source = array('.', ',');
        $replace = array('', '.');
        
        return str_replace($source, $replace, $valor);
    }
    
    //Trata uma URL do youtube para recuperar o código do vídeo
    public static function tratarUrlYouTube($url)
    {
        if(stripos($url, 'youtu'))
        {
            $codigo = '';        

            $regex = "#youtu(be.com|.b)(/embed/|/v/|/watch\\?v=|e/|/watch(.+)v=)(.{11})#";
            preg_match_all($regex , $url, $matches);

            if(!empty($matches[4]))
            {
                $codigo = $matches[4][0];
            }

            return $codigo;
        }
        else
            return $url;
    }
    
    public static function tratarUrl($url)
    {
        if(stripos($url, 'http') === false)
            $url = 'http://'.$url;
        
        return $url;
    }
    
    public static function getUF()
    {
        $arrEstados = array(
                'AM' => 'AM',
                'AC' => 'AC',
                'AL' => 'AL',
                'AP' => 'AP',
                'CE' => 'CE',
                'DF' => 'DF',
                'ES' => 'ES',
                'MA' => 'MA',
                'PR' => 'PR',
                'PE' => 'PE',
                'PI' => 'PI',
                'RN' => 'RN',
                'RS' => 'RS',
                'RO' => 'RO',
                'RR' => 'RR',
                'SC' => 'SC',
                'SE' => 'SE',
                'TO' => 'TO',
                'PA' => 'PA',
                'BH' => 'BH',
                'GO' => 'GO',
                'MT' => 'MT',
                'MS' => 'MS',
                'RJ' => 'RJ',
                'SP' => 'SP',
                'RS' => 'RS',
                'MG' => 'MG',
                'PB' => 'PB',
        );
        
        return $arrEstados;
    }
	
	public static function getSexos()
	{
		$arrSexos = array(
			'0' => 'Masculino',
			'1' => 'Feminino'
		);
		
		return $arrSexos;
	}
	
	public static function getTiposPessoa()
	{
		$arrTiposPessoa = array(
			'0' => 'Pessoa Física',
			'1' => 'Pessoa Jurídica'
		);
		
		return $arrTiposPessoa;
	}
	
	public static function getTiposTelefone()
	{
		$arrTiposTelefone = array(
			'0' => 'Residêncial',
			'1' => 'Comercial',
			'2' => 'Celular'
		);
		
		return $arrTiposTelefone;
	}
}