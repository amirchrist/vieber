<?php

error_reporting(E_ALL);

require('../src/vieber/boot.php');

Vieber\Engine::start([
	'app_path' => dirname(__FILE__) . '/app/',
	'theme_path' => dirname(__FILE__) . '/theme/',
	'jscript_path' => dirname(__FILE__) . '/jscript/',
	'static_path' => dirname(__FILE__) . '/static/',
	'static_url' => 'http://localhost/moxi9/vieber/example/static/',
	'url' => 'http://localhost/moxi9/vieber/example/',
	'dev_mode' => true
]);
?>