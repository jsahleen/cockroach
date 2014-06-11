<?php

require_once join(DIRECTORY_SEPARATOR, array(LIB_DIR, 'SplClassLoader.php'));

$autoloader = new SplClassLoader('Cockroach', LIB_DIR);

$autoloader->register();