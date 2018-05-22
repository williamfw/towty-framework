<?php 

namespace sistema\helpers;

/* Autor: William Fabrício Werling
 * Data: 20/08/2013
 * Descrição: Classe para redirecionamento de URL 
 */

class Redirector
{
	/* variavél utilizada como complemento do controller caso o aplicativo não seja o padrão,
	 * desta forma, o desenvolvedor não precisa informar o nome do aplicativo toda vez que usar o Redirector
	 */
	private $aplicativo;
	
    protected $parameters = array();
	
	public function __construct($aplicativo = null)
	{
		if(!is_null($aplicativo))
			$this->aplicativo = $aplicativo; 
	}

    protected function go($url)
    {        
        header('Location: ' . $url);
        exit;
    }

    public function setUrlParameter($nome, $valor)
    {
        $this->parameters[$nome] = $valor;
        return $this;
    }

    protected function getUrlParameters()
    {
        $params = "";

        foreach($this->parameters as $nome => $valor)
        {
            $params .= '/'.$nome.'/'.$valor;
        }

        return $params;
    }

    public function goToController($controller)
    {
    	if(isset($this->aplicativo))
        	$this->go(ROOT_URL . $this->aplicativo . '/' . $controller . '/index' . $this->getUrlParameters());
		else
			$this->go(ROOT_URL . $controller . '/index' . $this->getUrlParameters());
    }

    public function goToAction($action)
    {
    	if(isset($this->aplicativo))
			$this->go(ROOT_URL . $this->aplicativo . '/' . $this->getCurrentController() . '/' . $action . $this->getUrlParameters());
		else
			$this->go(ROOT_URL . $this->getCurrentController() . '/' . $action . $this->getUrlParameters());
    }

    public function goToControllerAction($controller, $action)
    {
    	if(isset($this->aplicativo))
        	$this->go(ROOT_URL . $this->aplicativo . '/' . $controller . '/' . $action . $this->getUrlParameters());
		else
			$this->go(ROOT_URL . $controller . '/' . $action . $this->getUrlParameters());
    }

    public function goToIndex()
    {
        $this->go(ROOT_URL . 'index.php');
    }

    public function goToUrl($url)
    {
        $this->go($url);
    }

    public function getCurrentController()
    {
        global $sistema;
        return $sistema->getRouter()->getController();
    }

    public function getCurrentAction()
    {
        global $sistema;
        return $sistema->getRouter()->getAction();
    }
}