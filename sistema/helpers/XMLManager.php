<?php

namespace sistema\helpers;

/* Autor: William Fabrício Werling
 * Data: 23/01/2014
 * Descrição: Classe para manipulação de XML 
 */
class XMLManager
{
	private $xmlData;
	
	public function carregarXML($xml)
	{
		if(is_file($xml))
			$this->xmlData = simplexml_load_file($xml);
		else
			$this->xmlData = simplexml_load_string($xml);
		
		return $this;
	}
	
	public function getXML()
	{
		return $this->xmlData;
	}
}