<?php

namespace Vieber;

class Curl {
	private $_url;
	private $_type;
	private $_curl;
	private $_params;
	private $_headers = [];

	public function __construct($url, $type = null) {
		$this->_url = $url;
		if ($type !== null) {
			$this->_type = $type;
		}

		$this->_curl = curl_init();
		curl_setopt($this->_curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->_curl, CURLOPT_HEADER, false);
	}

	public function set($params) {
		$this->_params = http_build_query($params);

		return $this;
	}

	public function header($headers) {
		$this->_headers = $headers;

		return $this;
	}

	public function auth($user, $pass) {

		curl_setopt($this->_curl, CURLOPT_USERPWD, $user . ':' . $pass);

		return $this;
	}

	public function post() {
		return $this->_process('POST');
	}

	public function get() {
		return $this->_process('GET');
	}

	private function _process($method) {

		if (is_array($this->_headers) && count($this->_headers)) {
			$headers = [];
			foreach ($this->_headers as $key => $value) {
				$headers[] = $key . ': ' . $value;
			}
			curl_setopt($this->_curl, CURLOPT_HTTPHEADER, $headers);
		}

		curl_setopt($this->_curl, CURLOPT_URL, (($method == 'GET' && !empty($this->_params)) ? $this->_url . '?' . ltrim($this->_params, '&') : $this->_url));

		if ($method == 'POST') {
			curl_setopt($this->_curl, CURLOPT_POST, true);
			curl_setopt($this->_curl, CURLOPT_POSTFIELDS, $this->_params);
		}

		$data = curl_exec($this->_curl);

		if ($this->_type == 'json') {
			$data = json_decode($data);
		}

		return $data;
	}
}