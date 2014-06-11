<?php
namespace Cockroach\View {
	
	use Cockroach\Exception as Exception;
	use Cockroach\View as View;

	class Page extends View
	{
		protected $_template = null;

		protected $_layout = null;

		protected $_useLayout = true;

		public function __construct()
		{
			$this->_layout = join(DIRECTORY_SEPARATOR, array(APP_DIR, 'layouts', 'layout.html'));
		}

		public function setTemplate($template)
		{
			$this->_template = $template;
		}

		public function getTemplate()
		{
			return $this->_template;
		}

		public function render()
		{
			if($this->_useLayout == true){
				$output = $this->renderLayout();
			} else {
				$ouput = $this->renderTemplate();
			}
			return $output;
		}

		public function setUseLayout($boolean)
		{
			$this->_useLayout = $boolean;
		}

		public function setLayout($layout)
		{
			$this->_layout = $layout;
		}

		public function getLayout()
		{
			return $this->_layout;
		}

		public function renderLayout()
		{
			ob_start();
			include $this->getLayout();
			$output = ob_get_clean();
			return $output;
		}
		public function renderTemplate()
		{
			ob_start();
			include $this->getTemplate();
			$output = ob_get_clean();
			return $output;
		}
	}
}