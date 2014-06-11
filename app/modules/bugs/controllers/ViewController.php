<?php

use \Cockroach\Controller as Controller;
use \Cockroach\View as View;
use \Cockroach\JSONView as JSONView;
use \Cockroach\Exception as Exception;
use \Cockroach\Bug as Bug;

class ViewController extends Controller
{
	public function execute()
	{
		$id = $this->getRequest()->getId();
		
		$layout = join(DIRECTORY_SEPARATOR, array(APP_DIR, 'layouts', 'detail.html'));
		$this->getResponse()->getView()->setLayout($layout);

		if(!isset(self::$db)){
			$this->_setUpDb();
		}

		$statement = self::$db->prepare("select * from bugs where id = :id");
		$statement->execute(array(':id' => $id));

		$bugData = $statement->fetch();

		$bug = new Bug();
		$bug->id = $bugData['id'];
		$bug->title = $bugData['title'];
		$bug->description = $bugData['description'];
		$bug->status = $bugData['status'];
		$bug->created = $bugData['created'];
		$bug->modified = $bugData['modified'];

		$statement = self::$db->prepare("select * from change_log where bug_id = :bug_id order by change_date desc");
		$statement->execute(array(':bug_id' => $bug->id));
		$changes = $statement->fetchAll();
		foreach ($changes as $change) {
			$bug->changes[] = $change;
		}

		$this->getResponse()->getView()->bug = $bug;

		return $this->getResponse();
	}
}