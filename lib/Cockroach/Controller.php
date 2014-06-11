<?php
namespace Cockroach
{
	use Cockroach\Exception as Exception;
	use Cockroach\Request as Request;
	use Cockroach\Response as Response;
	use Cockroach\Configuration as Configuration;
	use Cockroach\View\Page as PageView;
	use Cockroach\View\JSON as JSONView;

	class Controller
	{
		protected $_request;
		protected $_response;
		protected $_configuration;
		protected static $db = null;

		public function __construct(Request $request, Response $response, Configuration $config)
		{
			$this->_request = $request;
			$this->_response = $response;
			$this->_configuration = $config;

			if($this->getRequest()->isAjax()){
				$this->getResponse()->setView(new JSONView());
			} else {
				$this->getResponse()->setView(new PageView());
			}

			$module = $this->getRequest()->getModule();
			$controller = $this->getRequest()->getController();
			$templateName = ucfirst($controller).".html";
			$template = join(DIRECTORY_SEPARATOR, array(APP_DIR, 'modules', $module, 'templates', $templateName));
			$this->getResponse()->getView()->setTemplate($template);
		}

		public function execute()
		{
			$view = $this->getResponse()->getView();

			$view->message = "This is a test message.";

			return $this->_response;
		}

		public function getRequest()
		{
			return $this->_request;
		}

		public function getResponse()
		{
			return $this->_response;
		}

		public function getConfiguration()
		{
			return $this->_configuration;
		}

		protected function _setUpDb()
		{
			$config = $this->getConfiguration();
			$dbname = $config->db->database;
			$host = $config->db->host;
			$user = $config->db->user;
			$pass = $config->db->password;
			$dsn = "mysql:dbname=$dbname;host=$host";

			try{
				self::$db = new \PDO($dsn, $user, $pass);
			} catch(\PDOException $e){
				throw new Exception($e->getMessage());
			}
		}
	}
}