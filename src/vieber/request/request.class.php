<?php

namespace Vieber;

class Request {
	private $_requests = [];

	public function __construct() {
		$this->_requests = array_merge($_GET, $_POST);
	}

	public function get($key = null) {
		if ($key === null) {
			return (object) $this->_requests;
		}

		return (isset($this->_requests[$key]) ? (object) $this->_requests[$key] : null);
	}
}