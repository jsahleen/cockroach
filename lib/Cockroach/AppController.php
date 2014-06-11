<?php
namespace Cockroach
{
	use Cockroach\Exception as Exception;
	use Cockroach\Request as Request;
	use Cockroach\Response as Response;
	use Cockroach\Controller as Controller;

	class AppController
	{
		protected $_config;

		protected $_request;

		protected $_response;

		public function __construct(Configuration $config)
		{
			$this->_config = $config;
		}

		public function getConfig()
		{
			return $this->_config;
		}

		public function execute(Request $request)
		{
			$this->_request = $request;
			$this->_response = new Response();

			$module = $this->_request->getModule();
			$controller = $this->_request->getController();

			$path = join(DIRECTORY_SEPARATOR, array(APP_DIR, 'modules', $module, 'controllers'));
			$class = ucfirst($controller).'Controller';
			$file = $path.DIRECTORY_SEPARATOR.$class.'.php';
			if(file_exists($file) && is_readable($file)){
				require $file;
			} else {
				throw new Exception("File $file could not be found or is not readable");
				
			}

			$c = new $class($this->_request, $this->_response, $this->_config);
			if($c instanceof Controller){
				return $c->execute();
			} else {
				throw new Exception("Controller $class could not be loaded");
				
			}
		}
	}
}