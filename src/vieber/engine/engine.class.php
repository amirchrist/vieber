<?php

namespace Vieber;

class Engine {
	public static $app_path;
	public static $theme_path;
	public static $static_path;
	public static $static_url;
	public static $jscript_path;
	public static $dev_mode;
	public static $url;

	private static $_page = 'index';

	public static function start($params) {
		foreach ($params as $key => $value) {
			self::$$key = $value;
		}


		if (isset($_GET['page'])) {
			self::$_page = $_GET['page'];
		}

		$path = self::$app_path . 'controller' . VIEBER_DS . self::$_page . '.php';
		if (!file_exists($path)) {
			$path = self::$app_path . 'controller' . VIEBER_DS . self::$_page . VIEBER_DS . 'index.php';
			self::$_page = self::$_page . VIEBER_DS . 'index';
			if (!file_exists($path)) {
				exit('Page not found!');
			}
		}

		require($path);
	}

	public static function page() {
		return self::$_page;
	}
}

?>