<?php

// Define Path Constants

define('ROOT_DIR', dirname(dirname(__FILE__)));
define('APP_DIR', join(DIRECTORY_SEPARATOR, array (ROOT_DIR, 'app')));
define('PUBLIC_DIR', join(DIRECTORY_SEPARATOR, array (ROOT_DIR, 'public')));
define('LIB_DIR', join(DIRECTORY_SEPARATOR, array (ROOT_DIR, 'lib')));
define('CONFIG_DIR', join(DIRECTORY_SEPARATOR, array (ROOT_DIR, 'config')));

require join(DIRECTORY_SEPARATOR, array(LIB_DIR, 'autoload.php'));

use \Cockroach\Configuration as Configuration;
use \Cockroach\AppController as AppController;
use \Cockroach\Request as Request;
use \Cockroach\Response as Response;
use \Cockroach\PageController as PageController;

try {
	$configFile = join(DIRECTORY_SEPARATOR, array(CONFIG_DIR, 'config.php'));
	$config = Configuration::load($configFile);

	$app = new AppController($config);

	$response = $app->execute(new Request());
	$response->send();
} catch(Exception $e) {
	echo $e->getMessage();
}