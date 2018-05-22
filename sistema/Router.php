<?php
namespace sistema;

use sistema\App;

/* Autor: William Fabrício Werling
 * Data: 14/08/2013
 * Descrição: Classe responsável por tratar a url requisitada e devolver para o usuário o controller/action desejado. 
 * OBS: Esta classe sempre deve ser trabalhada em conjunto com a classe Sistema\Request
 */
class Router
{
	const default_controller = 'home';
	const default_action = 'index';
	
	private $app;
	private $indiceControllerExplode;
	private $indiceActionExplode;		    
    private $controller;
    private $action;
    private $parametros;	
	private $request;
	private $diretorioControllers;	
	private $namespaceControllers;
			
	public function __construct(Request $request)
	{
		$this->request = $request;
		
		App::setApp($this->request->getExplodePorIndice(0));		
		
		/* VALORES PADRÕES:
		 * as variáveis indiceController e indiceAction são usadas para recuperar da Request o nome do
		 * controller e da action definida na URL.
		 * Caso o aplicativo atual selecionado pelo usuário não seja o aplicativo padrão, o indiceController
		 * e indiceAction ficam com os valores 1 e 2 respectivamente, pois o indice 0 é o nome do aplicativo. 
		 */
		$this->indiceControllerExplode = 0;
		$this->indiceActionExplode = 1;
				
		if(!App::getApp()->getPadrao())
		{
			$this->indiceControllerExplode = 1;
			$this->indiceActionExplode = 2;
		}
		
		$this->setDiretorioControllers();
		$this->setNamespaceControllers();
		$this->setController();		
        $this->setAction();
        $this->setParametros();
	}
	
	private function setDiretorioControllers()
	{
		$this->diretorioControllers = BASE_DIR . 'apps/' . App::getApp()->getNome() . '/' . 'controllers/';
	}
	
	private function setNamespaceControllers()
	{
		$this->namespaceControllers = 'apps\\' . App::getApp()->getNome() . '\\' . 'controllers\\';
	}   
	
	private function setController()
    {
		$this->controller = $this->request->getExplodePorIndice($this->indiceControllerExplode);
			
		if(empty($this->controller))
			$this->controller = self::default_controller;
    }
	
    private function setAction()
    {
    	$this->action = $this->request->getExplodePorIndice($this->indiceActionExplode);
		
		if(empty($this->action))
			$this->action = self::default_action;
    }

    private function setParametros()
    {
    	$explode = $this->request->getExplode();
		
    	if(!App::getApp()->getPadrao())
        	unset($explode[0], $explode[$this->indiceControllerExplode], $explode[$this->indiceActionExplode]);
		else
			unset($explode[$this->indiceControllerExplode], $explode[$this->indiceActionExplode]);
		
        array_pop($explode);

        if (end($explode) == null)
            array_pop($explode);

		$this->parametros = array();

        if(!empty($explode))
        {
            foreach ($explode as $var)
            {   
				$this->parametros[] = $var;                
            }
        }
    }
	
	public function getController()
    {
		return $this->controller;
    }
	
    public function getAction()
    {
    	return $this->action;
    }
	
	public function matchRoute()
	{
		//monta o nome do controller que será instânciado	
		$classeController = $this->namespaceControllers . ucfirst($this->controller) . 'Controller';
			
		//instância do controller
		$objController = new $classeController();
		
		//faz chamada da action e passa os parâmetros para a action, caso tenha.
		if(!empty($this->parametros))
			call_user_func_array(array($objController, $this->action), $this->parametros);
		else 				
			call_user_func(array($objController, $this->action));
	}
} 