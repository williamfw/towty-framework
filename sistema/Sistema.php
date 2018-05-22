<?php

namespace sistema;

require_once(BASE_DIR . 'sistema\ClassLoader.php');

use sistema\Router;
use sistema\Request;
use sistema\ClassLoader;
use sistema\helpers\XMLManager;

/* Autor: William Fabrício Werling
 * Data: 07/08/2013 
 * Descrição: Classe principal do sistema. Ela é responsável por centralizar todas as principais funcionalidades do sistema, como
 * o Router, o Request e o ClassLoader. 
 * 
 * Versão: 2.0.0
 */
class Sistema
{
	private $router;
	private $request;		
	private $classLoader;	
	
	public function __construct()
	{
		try
		{	
			//instância da classe responsável em fazer o load das clases essenciais para o funcionamento do Towty Framework.			
			$this->classLoader = new ClassLoader();
			
			//instância da classe responsável em tratar a URL
			$this->request = new Request();
		}
		catch(Exception $ex)
		{
			throw new Exception("Erro ao inicializar sistema. " . $ex->getMessage());
		}
	}
		
	//Método principal, ele que irá rodar o sistema. 
	public function executar()
	{
		//instância da classe responsável em mostrar para o usuário o controller e action desejada. Também define o app atual	
		$this->router = new Router($this->request);
		$this->router->matchRoute();
	}
	
	public static function getVersao() {
		$xmlManager = new XMLManager();
		$xmlData = $xmlManager->carregarXML(BASE_DIR . 'configs/sysConfig.xml')->getXML();
		
		return $xmlData->versao;
	}
}