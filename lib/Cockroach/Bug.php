<?php
namespace Cockroach {

	use Cockroach\Exception as Exception;
	use Cockroach\Configuration as Configuration;

	class Bug
	{

		public $id;

		public $title;

		public $status;

		public $created;

		public $modified;

		public $changes = array();

	}
}