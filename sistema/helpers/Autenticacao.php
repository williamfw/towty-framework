<?php

namespace sistema\helpers;

/* Autor: William Fabrício Werling
 * Data: 20/08/2013
 * Descrição: Classe responsável por realizar a autenticação de um usuário no sistema 
 */

use sistema\helpers\Session; 

class Autenticacao 
{
    private $session;
	private $modelAutenticacao;
	private $colunaUsuario;
	private $colunaSenha;
	
	private static $entityManager;

    public function __construct($entityManager)
    {
        $this->sessionHelper = new SessionHelper();		
		Autenticacao::$entityManager = $entityManager;
        return $this;
    }                

    public function setModelAutenticacao($model)
    {
        $this->modelAutenticacao = $model;
        return $this;
    }        

    public function setColunaUsuario($coluna)
    {
        $this->colunaUsuario = $coluna;
        return $this;
    }

    public function setColunaSenha($coluna)
    {
        $this->colunaSenha = $coluna;
        return $this;
    }
	
	public function login($login, $senha)
    {
        $qb = Autenticacao::$entityManager->createQueryBuilder();
        $usuario = $qb->select('u')
                      ->from($this->modelAutenticacao, 'u')
                      ->where('u.'.$this->colunaUsuario.' = :login')
                      ->andWhere('u.'.$this->colunaSenha.' = :senha')
                      ->setParameters(array('login' => $login, 'senha' => $senha))
                      ->getQuery()
                      ->getSingleResult();
					  
        if(!is_null($usuario))
		{
			$this->setUsuarioAtual($usuario);			
		}        
        
        return $this;
    }
	
	public function setUsuarioAtual($usuario)
	{
		$this->sessionHelper->criarSession('usuario', $usuario, true);
	}
    
    public static function UsuarioAtual()
    {
        try
        {
        	$staticSession = new SessionHelper();
			$usuarioAtual = $staticSession->selecionarSession('usuario', true); 
			
			return !is_null($usuarioAtual) ? Autenticacao::$entityManager->Merge($usuarioAtual) : null;
        }
        catch (Exception $ex)
        {
            return null;
        }
    }

    public function logout()
    {
        $this->sessionHelper->excluirSession('usuario');

        return $this;
    }

    public function checkLogin()
    {
        return $this->sessionHelper->checarSession('usuario');
    }
}