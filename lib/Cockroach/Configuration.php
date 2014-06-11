<?php

namespace Cockroach
{
	use Cockroach\Exception as Exception;

	class Configuration
	{
		protected $_data = array();

		public function __construct($data = array())
		{
			$this->_data = $data;
		}

		public static function load($file)
		{
			if(file_exists($file) && is_readable($file)){
				include($file);
				if(is_array($config)){
					return new self($config);
				} else {
					throw new Exception("Invalid configuration");
				}
			} else {
				throw new Exception("Configuration file $file was not found or could not be read");
			}
		}

		public function __get($key)
		{
			if(isset($this->_data[$key])){
				if(is_array($this->_data[$key])){
					return new self($this->_data[$key]);
				} else {
					return $this->_data[$key];
				}
			} else {
				return null;
			}
		}
	}
}