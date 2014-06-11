<?php

use \Cockroach\Controller as Controller;
use \Cockroach\View as View;
use \Cockroach\JSONView as JSONView;
use \Cockroach\Exception as Exception;
use \Cockroach\Bug as Bug;

class CreateController extends Controller
{
	public function execute()
	{
		$request = $this->getRequest();
		if($request->getMethod() == 'POST'){
			$title = $request->getParameter('title');
			$description = $request->getParameter('description');
			$status = 'New';
			$now = date('Y-m-d H:i:s');

			if(!isset(self::$db)){
				$this->_setUpDb();
			}

			$sql = "insert into bugs (title, description, status, created, modified) VALUES(:title, :description, :status, :now, :now)";
			$statement = self::$db->prepare($sql);
			$statement->execute(array(':title' => $title, ':description' => $description, ':status' => $status, ':now' => $now));

			$id =self::$db->lastInsertId();

			$sql = "insert into change_log (bug_id, change_date, from_status, to_status) values(:bug_id, :now, null, :status)";
			$statement = self::$db->prepare($sql);
			$statement->execute(array(':bug_id' => $id, ':now' => $now, ':status' => $status));

			$this->getResponse()->redirect('bugs', 'view', $id);
		} else {
			$layout = join(DIRECTORY_SEPARATOR, array(APP_DIR, 'layouts', 'detail.html'));
			$this->getResponse()->getView()->setLayout($layout);
			return $this->getResponse();
		}

	}
}