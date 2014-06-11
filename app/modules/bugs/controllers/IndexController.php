<?php

use \Cockroach\Controller as Controller;
use \Cockroach\View as View;
use \Cockroach\JSONView as JSONView;
use \Cockroach\Exception as Exception;
use \Cockroach\Bug as Bug;

class IndexController extends Controller
{
	public function execute()
	{
		if(!isset(self::$db)){
			$this->_setUpDb();
		}

		$statement = self::$db->prepare("select * from bugs order by id asc");
		$statement->execute();
		$bugData = $statement->fetchAll();

		$bugs = array();
		foreach ($bugData as $row) {
			$bug = new Bug();
			$bug->id = $row['id'];
			$bug->title = $row['title'];
			$bug->description = $row['description'];
			$bug->status = $row['status'];
			$bug->created = $row['created'];
			$bug->modified = $row['modified'];
			$bugs[] = $bug;
		}
		$this->getResponse()->getView()->bugs = $bugs;
		return $this->getResponse();
	}

}