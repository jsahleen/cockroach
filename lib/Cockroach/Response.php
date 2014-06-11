<?php
namespace Cockroach
{
	use Cockroach\Exception as Exception;
	use Cockroach\View as View;

	class Response
	{
		protected $_view = null;

		protected $_headers = array();

		public function send()
		{
			$this->sendHeaders();
			$output = $this->getView()->render();
			echo $output;
		}

		public function setView(View $view)
		{
			$this->_view = $view;
		}

		public function getView()
		{
			return $this->_view;
		}

		public function setHeader($name, $headerString, $replace, $code)
		{
			$this->_headers[$name] = array($headerString, $replace, $code);
		}

		public function getHeaders()
		{
			return $this->_headers;
		}

		public function clearHeader($name)
		{
			unset($this->_headers[$name]);
		}


		public function sendHeaders()
		{
			$headers = $this->getHeaders();
			foreach ($headers as $header) {
				header($header[0], $header[1], $header[2]);
			}
		}

		public function redirect($module = 'index', $controller = 'index', $id = null)
		{
			$location = "/$module";
			if($controller != "index"){
				$location .= "/$controller";
			}
			if($id != null){
				$location .= "/$id";
			}
			header("Location: $location");
		}

	}
}