<?php

namespace apps\site\controllers;

use sistema\Sistema;
use sistema\Doctrine;

class HomeController extends MasterPageController
{
	public function __construct()
	{
		parent::__construct();
		$this->setDiretorioView('home');
	}
	
	public function Index()
	{
		$this->dados['titulo'] = 'Gecko\'s CMS';		
		$this->view('index', $this->dados);
	}
}