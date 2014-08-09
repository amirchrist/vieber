<?php

namespace Vieber;

class Request {
	private $_requests = [];
	private static $_urls = [];

	public function __construct() {
		$this->_requests = array_merge($_GET, $_POST);
	}

	public static function set($url) {
		self::$_urls = explode('/', trim($url, '/'));
	}

	public function get($key = null) {
		if ($key === null) {
			return (object) $this->_requests;
		}

		return (isset($this->_requests[$key]) ? (is_array($this->_requests[$key]) ? (object) $this->_requests[$key] : $this->_requests[$key]) : null);
	}

	public function url($key = null) {
		if ($key === null) {
			return self::$_urls;
		}

		$key--;
		return (isset(self::$_urls[$key]) ? self::$_urls[$key] : '');
	}
}