<?php

namespace sistema;

/* Autor: William Fabrício Werling
 * Data: 19/08/2013
 * Descrição: Classe responsável por carregar os loaders no Sistema 
 */
class ClassLoader
{
	/*
	 * caso tenha um diretorio personalizado para ser carregado, deve ser informado aqui
	 */
	private $diretoriosClasses = array();
	
	/*
	 * caso tenha alguma classe que não deve ser carregada pelo autoload, deve-se informar nessa variável
	 * através do método addClasseExcecao
	 */
	private $classesExcecao = array();
	
	/*
	 * caso tenha algum diretorio que não deve ser carregada pelo autoload, deve-se informar nessa variável
	 * através do método addDiretorioExcecao
	 */
	private $diretoriosExcecao = array();
	
	public function __construct()
	{
		//diretórios padrões
		$this->diretoriosClasses = array();
		$this->diretoriosClasses['Sistema']      = BASE_DIR;		
		$this->diretoriosClasses['Helper']       = BASE_DIR . 'sistema/helpers/';
		$this->diretoriosClasses['Libs']         = BASE_DIR . 'libs/';
		
		//registra na SPL (Standard PHP Library) o método responsável pelo autoload de classes!!
		spl_autoload_register(array($this, 'carregarClasse'));
	}
	
	public function carregarClasse($classe)
	{
		$explode_class = explode('\\', $classe);
		$temp_dir = array_pop($explode_class); //recupera o diretorio
		
		/*
		 * Depois iremos verificar se a classe que irá ser carregada não está na lista de exceções,
		 * caso esteja, encerra o método por aqui
		 */	
		if(in_array($temp_dir, $this->diretoriosExcecao))
			return;
		
		$temp_class = array_pop($explode_class); //recupera a classe
		unset($explode_class); //destrói variável 
		
		/*
		 * Depois iremos verificar se a classe que irá ser carregada não está na lista de exceções,
		 * caso esteja, encerra o método por aqui
		 */		
		if(in_array($temp_class, $this->classesExcecao))
			return;
		
		foreach($this->diretoriosClasses as $dir)
		{
			$replace_classe = str_replace('\\', '/', $classe);
			
			$class_path = $dir . $replace_classe . '.php';			
		
			if(file_exists($class_path))
			{
		    	require_once ($class_path);
				break;
			}
		}
	}
	
	/* Caso deseja-se incluir novos diretórios para carregar classes
	 * em tempo de execução, deve-se usar este método
	 */
	public function addDiretorio($nome, $diretorio)
	{
		$this->diretoriosClasses[$nome] = $diretorio;
		return $this;
	}
	
	public function addClasseExcecao($classe)
	{	
		$this->classesExcecao[] = $classe;
		return $this;
	}
	
	public function addDiretorioExcecao($diretorio)
	{
		$this->diretoriosExcecao[] = $diretorio;
		return $this;
	}
}
