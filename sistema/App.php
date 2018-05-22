<?php

namespace sistema;

use Sistema\Helpers\XMLManager;

/* Autor: William Fabrício Werling
 * Data: 23/01/2014 
 * Descrição: Classe para controle de apps do framework, com ele é possivel selecionar uma app para poder utilizar seus recursos 
 */
class App
{
	private $nome;
	private $alias;
	private $padrao;
	private $dirUploads;
		
	private static $app;
	
	public function __construct($nome, $alias, $padrao, $dirUploads)
	{
		$this->nome = $nome;
		$this->alias = $alias;
		$this->padrao = $padrao;
		$this->dirUploads = $dirUploads;
	}
	
	public function getNome()
	{
		return $this->nome;
	}
	
	public function getAlias()
	{
		return $this->alias;
	}
	
	public function getPadrao()
	{
		return $this->padrao;
	}
	
	public function getdirUploads()
	{
		return $this->dirUploads;
	}
	
	/**************************************
	 * MÉTODOS ESTÁTICOS
	 */
	static function setApp($aliasOuNomeApp)
	{
		$xmlManager = new XMLManager();
		
		$arraySimpleXMLElement =  $xmlManager->carregarXML(BASE_DIR . 'configs/appConfig.xml')->getXML();
		
		//primeiro verifico dentro das apps que não são padrões
		foreach ($arraySimpleXMLElement as $sxe) 
		{
			//verifico se existe alias ou nome informado
			if($sxe['padrao'] == 'false' && ($sxe['alias'] == $aliasOuNomeApp || $sxe['nome'] == $aliasOuNomeApp))
			{
				self::$app = new App($sxe['nome'], $sxe['alias'], $sxe['padrao'] == 'false' ? false : true, (String)$sxe->diretorios->uploads);
				return;
			}	
		}
		
		//se não encontrou um app não padrão, busco o padrão
		foreach ($arraySimpleXMLElement as $sxe) 
		{
			if($sxe['padrao'] == 'true')
			{		
				self::$app = new App($sxe['nome'], $sxe['alias'], $sxe['padrao'] == 'true' ? true : false, (String)$sxe->diretorios->imagens);
				return;
			}	
		}
	}
	
	static function getApp()
	{
		return self::$app;
	}
}