<?php

namespace apps\site\controllers;

use sistema\BaseController;

abstract class MasterPageController extends BaseController
{
	public function __construct()
	{
		parent::__construct();		
		$this->setMasterPage('masterpage.phtml');
	}
}