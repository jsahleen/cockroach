<?php

use \Cockroach\Controller as Controller;
use \Cockroach\View as View;
use \Cockroach\JSONView as JSONView;
use \Cockroach\Exception as Exception;

class IndexController extends Controller
{
	public function execute()
	{
		$this->getResponse()->getView()->message = "This is the bug listing page.";
		$this->getResponse()->redirect('bugs');
		return $this->getResponse();
	}
}