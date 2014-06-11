<?php
namespace Cockroach {

	use Cockroach\Exception as Exception;

	class View
	{
		protected $_data = array();

		public function __get($key)
		{
			return $this->_data[$key];
		}

		public function __set($key, $value)
		{
			$this->_data[$key] = $value;
		}

		public function render()
		{
			return $this->_data;
		}

	}
}