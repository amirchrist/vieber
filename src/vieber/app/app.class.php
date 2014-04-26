<?php

namespace Vieber;

class App {
	private $_title;
	private $_header;
	private $_footer;

	public $request;

	public function __construct() {

		$this->request = new Request();

		if (Engine::$dev_mode) {
			$css = Engine::$theme_path . 'css' . VIEBER_DS;
			if (is_dir($css)) {
				$css_content = '';
				foreach (scandir($css) as $file) {
					if (substr($file, -4) != '.css') {
						continue;
					}
					$css_content .= file_get_contents($css . $file);
				}
				file_put_contents(Engine::$static_path . 'css' . VIEBER_DS . 'bundle.css', $css_content);
			}

			$script = Engine::$jscript_path;
			if (is_dir($script)) {
				$script_content = '';
				foreach (scandir($script) as $file) {
					if (substr($file, -3) != '.js') {
						continue;
					}
					$script_content .= file_get_contents($script . $file);
				}
				file_put_contents(Engine::$static_path . 'jscript' . VIEBER_DS . 'bundle.js', $script_content);
			}
		}
	}

	public function header($header = null) {
		if ($header === null) {
			if (file_exists(Engine::$static_path . 'css' . VIEBER_DS . 'bundle.css')) {
				$this->_header .= '<link rel="stylesheet" type="text/css" href="' . Engine::$static_url . 'css/bundle.css?v=' . time() . '" />' . "\n";
			}

			return $this->_header;
		}


	}

	public function footer($footer = null) {
		if ($footer === null) {
			if (file_exists(Engine::$static_path . 'jscript' . VIEBER_DS . 'bundle.js')) {
				$this->_footer .= '<script type="text/javascript" src="' . Engine::$static_url . 'jscript/bundle.js?v=' . time() . '"></script>' . "\n";
			}

			return $this->_footer;
		}


	}

	public function title($title = null) {
		if ($title === null) {
			return $this->_title;
		}

		$this->_title .= $title;

		return $this;
	}

	public function content() {

		// $static_path = Engine::$static_path . 'cache' . VIEBER_DS . 'view_' . str_replace('/', '_', Engine::page()) . '.html.php';

		$content = file_get_contents(Engine::$app_path . 'view' . VIEBER_DS . Engine::page() . '.html');
		$theme = new Theme\Cache($this, $content);
		// file_put_contents($static_path, $theme->parsed());

		return $theme->parsed();
	}
}