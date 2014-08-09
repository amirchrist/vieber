<?php

namespace Vieber\Markup;

class Url {
	public function redirect($url) {
		echo 'redirect:' . $url;
		exit;
	}
}