<?php

namespace Vieber;

class Url {
	public function link($page) {
		$url = Engine::$url . '?page=' . $page;

		return $url;
	}
}