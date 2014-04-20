<?php

namespace Vieber {

	define('VIEBER_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
	define('VIEBER_DS', DIRECTORY_SEPARATOR);

	spl_autoload_register(function($class) {
		$name = str_replace('\\', '/', str_replace('vieber\\', '', strtolower($class)));
		$folder = $name;

		$path = VIEBER_PATH . $folder . '/' . $name . '.class.php';
		if (substr($folder, 0, 4) == 'app/') {
			$parts = explode('app/', $name);
			$name = $parts[1];
			$path = Engine::$app_path . 'model' . VIEBER_DS . $name . '.class.php';
		}
		else if (!file_exists(VIEBER_PATH . $folder . '/' . $name . '.class.php')) {
			$path = VIEBER_PATH . $name . '.class.php';
		}

		if (!file_exists($path)) {
			echo substr($folder, 0, 3) . "<br />";
			exit('File not found: ' . $folder . ' -> ' . $name);
		}

		require($path);
	});

}

namespace {
	function d($mInfo, $bVarDump = false) {
		$bCliOrAjax = (PHP_SAPI == 'cli');
		(!$bCliOrAjax ? print '<pre style="text-align:left; padding-left:15px;">' : false);
		($bVarDump ? var_dump($mInfo) : print_r($mInfo));
		(!$bCliOrAjax ? print '</pre>' : false);
	}

	function p() {
		$aArgs = func_get_args();
		$bCliOrAjax = (PHP_SAPI == 'cli');
		foreach($aArgs as $sStr) {
			print ($bCliOrAjax ? '' : '<pre>') . "{$sStr}" . ($bCliOrAjax ? "\n" : '</pre><br />');
		}
	}
}