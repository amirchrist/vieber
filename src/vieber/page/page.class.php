<?php

namespace Vieber;

class Page {
	public function __construct($function) {
		$app = new App();

		call_user_func($function, $app);

		$static_path = Engine::$static_path . 'cache' . VIEBER_DS . str_replace('/', '_', Engine::page()) . '.html.php';
		$content = file_get_contents(Engine::$theme_path . 'html' . VIEBER_DS . 'layout.html');
		$theme = new Theme\Cache($app, $content);

		file_put_contents($static_path, $theme->parsed());

		require($static_path);
	}
}

