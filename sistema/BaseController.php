<?php

namespace sistema;

/* Autor: William Fabrício Werling
 * Data: 20/08/2013
 * Descrição: Classe base dos controllers! Ela é abstrata pois não pode ser instânciada, somente herdada. 
 */

use sistema\helpers\Redirector;

abstract class BaseController
{
	protected $redirector;
	protected $masterPage;
	protected $baseView;
	protected $diretorioView;
	protected $diretorioMasterPage;
	protected $diretorioWidgets;
	protected $diretorioFisicoIncludes;
	protected $diretorioVirtualIncludes;
	protected $urlAction;

	protected $dados;
	
	public function __construct() 
	{
		if(!App::getApp()->getPadrao())
			$this->redirector = new Redirector(App::getApp()->getNome());
		else
			$this->redirector = new Redirector();
		
		$this->setBaseView();
		$this->setDiretorioFisicoIncludes();
		$this->setDiretorioVirtualIncludes();
		$this->setDiretorioMasterPage();
		$this->setDiretorioWidgets();
		$this->setUrlAction();
	}
	
	/*******************************************
	 * MÉTODOS PRIVADOS 
	 *******************************************/	
	private function setBaseView()
	{
		$this->baseView = BASE_DIR . 'apps/' . App::getApp()->getNome() . '/views/';
	}
	
	private function setDiretorioFisicoIncludes()
	{
		$this->diretorioFisicoIncludes = BASE_DIR . 'apps/' . App::getApp()->getNome() . '/includes/';
	}
	
	private function setDiretorioVirtualIncludes()
	{
		$this->diretorioVirtualIncludes = BASE_URL . 'apps/' . App::getApp()->getNome() . '/includes/';
	}
	
	private function setDiretorioMasterPage()
	{
		$this->diretorioMasterPage = BASE_DIR . 'apps/' . App::getApp()->getNome() . '/masterpages/';
	}
	
	private function setDiretorioWidgets()
	{
		$this->diretorioWidgets = BASE_DIR . 'apps/' . App::getApp()->getNome() . '/widgets/';
	}
	
	private function setUrlAction()
	{
		if(App::getApp()->getPadrao())
			$this->urlAction = BASE_URL;
		else 
			$this->urlAction = BASE_URL . App::getApp()->getNome() . '/';
	}
	
	/*******************************************
	 * MÉTODOS PROTEGIDOS 
	 *******************************************/	
	protected function setMasterPage($masterPage)
	{
		$this->masterPage = $this->diretorioMasterPage . $masterPage;
	}
	
	protected function setDiretorioView($diretorioView)
	{
		$this->diretorioView = $this->baseView . $diretorioView . '/';
	}
	
	protected function getBaseView()
	{
		return $this->baseView;
	}
	
	protected function view($nome, $vars = null)
	{
		//define o caminho absoluto da view.
        $arquivoView = $this->diretorioView . $nome.'.phtml';
		
		//verifica se a view existe
		if(!file_exists($arquivoView))
			die('View inexistente.');
		
		/* Ativa o buffer de saída!!! Significa que enquanto ativo, nada é exibido na saída do script ( fica armazenado na memória).
		 * Com isso, posso incluir a view desejada, passar todos os valores do controller pra view e jogar todo o conteudo da view
		 * para a variável $conteudoView através do ob_get_contents(). Após isso encerro o buffer e faço requisição da masterpage,
		 * só então é exibido o conteúdo da página, funcionando de forma semelhante ao asp.net!! 
		 */ 
		ob_start();
		
		if(is_array($vars) && count($vars) > 0)
            extract ($vars);
		
		include_once($arquivoView);
			
		$conteudoView = ob_get_contents();
		
		ob_end_clean();        
        
        require_once($this->masterPage);        
    }
}
