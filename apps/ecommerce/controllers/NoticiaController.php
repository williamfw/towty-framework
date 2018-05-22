<?php

namespace apps\site\controllers;

class NoticiaController extends MasterPageController
{
	public function __construct()
	{
		parent::__construct();
		$this->setDiretorioView('noticia');
	}
	
	public function Index()
	{	
		$this->dados['titulo'] = 'Gecko\'s CMS';		
		$this->view('index');
	}
}