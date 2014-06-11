<?php

use \Cockroach\Controller as Controller;
use \Cockroach\View as View;
use \Cockroach\JSONView as JSONView;
use \Cockroach\Exception as Exception;
use \Cockroach\Bug as Bug;

class EditController extends Controller
{
	public function execute()
	{

		$request = $this->getRequest();
		if($request->getMethod() == 'POST'){
			$title = $request->getParameter('title');
			$description = $request->getParameter('description');
			$status = $request->getParameter('status');
			$id = $request->getId();
			$now = date('Y-m-d H:i:s');


			if(!isset(self::$db)){
				$this->_setUpDb();
			}

			$sql = "select status from bugs where id=?";
			$statement = self::$db->prepare($sql);
			$statement->execute(array($id));

			$data = $statement->fetch();
			$old_status = $data['status'];

			$sql = "update bugs set title=?, description=?, status=?, modified=? where id=?";
			$statement = self::$db->prepare($sql);
			$statement->execute(array($title, $description, $status, $now, $id));

			if($old_status != $status){
				$sql = "insert into change_log (bug_id, change_date, from_status, to_status) values(:bug_id, :now, :old_status, :status)";
				$statement = self::$db->prepare($sql);
				$statement->execute(array(':bug_id' => $id, ':now' => $now, ':old_status' => $old_status, ':status' => $status));
			}

			$this->getResponse()->redirect('bugs', 'view', $id);

		} else {
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
}