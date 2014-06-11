<?php
namespace Cockroach
{
	use Cockroach\Exception as Exception;

	class Request
	{
		protected $_module = null;

		protected $_controller = null;

		protected $_id = null;

		public function getModule()
		{
			if(!isset($this->_module)){
				$this->_parsePath();
			} 
			return $this->_module;
		}
		public function getController()
		{
			if(!isset($this->_controller)){
				$this->_parsePath();
			}
			return $this->_controller;
		}

		public function getId()
		{
			if(!isset($this->_id)){
				$this->_parsePath();
			}
			return $this->_id;
		}

		protected function _parsePath()
		{
			$path = isset($_GET['p']) ? $_GET['p'] : 'index/index';
			$segments = substr_count($path, "/");
			switch ($segments) {
				case 2:
					list($module, $controller, $id) = explode("/", $path);
					break;
				case 1:
					list($module, $controller) = explode("/", $path);
					$id = null;
					break;
				case 0:
					$module = $path;
					$controller = 'index';
					$id = null;
					break;
				default:
					$module = 'index';
					$controller = 'index';
					$id = null;
					break;
			}
			$this->_module = $module;
			$this->_controller = $controller;
			$this->_id = $id;
		}

		public function isAjax()
		{
			if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
				return true;
			} else {
				return false;
			}
		}

		public function getMethod()
		{
			return $_SERVER['REQUEST_METHOD'];
		}

		public function getParameter($parameter)
		{
			if(!isset($this->_parameters)){
				$parameters = array();
				foreach($_GET as $key => $value){
					$parameters[$key] = $value;
				}
				foreach($_POST as $key => $value){
					$parameters[$key] = $value;
				}
				$this->_parameters = $parameters;
			}

			return $this->_parameters[$parameter];
		}
	}
}