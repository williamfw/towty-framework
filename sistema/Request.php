<?php
namespace sistema;

/* Autor: William Fabrício Werling
 * Data: 15/08/2013
 * Descrição: Classe responsável por tratar as requisições da URL. 
 */
class Request
{
	private $url;
    private $explode;
			
	public function __construct()
	{
		$this->setUrl();
        $this->setExplode();
	}
	
	private function setUrl()
	{
		$url = isset($_REQUEST['url']) ? $_REQUEST['url'] : '';
		$url = substr($url, -1) != '/' ? $url . '/' : $url;
			
		$this->url = $url;	
	}

    private function setExplode()
    {
        $this->explode = explode('/' , $this->url);
    }
	
	public function getUrl()
	{
		return $this->url;
	}
	
	public function getExplode()
	{
		return $this->explode;
	}
	
	public function getExplodePorIndice($index)
	{		
		if(sizeof($this->explode) > $index)
			return $this->explode[$index];
		else
			return null;		
	}
} 