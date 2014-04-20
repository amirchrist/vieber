<?php

namespace Vieber;

class Redis {
	private static $_socket = array();
	private static $_server;

	public static function connect($server = 'localhost:6379') {
		self::$_server = $server;
		if (!isset(self::$_socket[self::$_server])) {
			self::$_socket[self::$_server] = stream_socket_client(self::$_server);
		}
	}

	public static function socket() {
		return self::$_socket[self::$_server];
	}

	public function incr($key) {
		return $this->_call('incr', $key);
	}

	public function decr($key) {
		return $this->_call('decr', $key);
	}

	public function set($key, $value) {
		return $this->_call('set', $key, $value);
	}

	public function expire($key, $seconds) {
		return $this->_call('expire', $key, $seconds);
	}

	public function get($key) {
		return $this->_call('get', $key);
	}

	public function del($key) {
		return $this->_call('del', $key);
	}

	public function lrange($key, $from, $to) {
		return $this->_call('lrange', $key, $from, $to);
	}

	public function lpush($key, $data) {
		return $this->_call('lpush', $key, $data);
	}

	public function rpush($key, $data) {
		return $this->_call('rpush', $key, $data);
	}

	public function ltrim($key, $from, $to) {
		return $this->_call('ltrim', $key, $from, $to);
	}

	private function _call($method) {
		$args = func_get_args();
		unset($args[0]);

		array_unshift($args, $method);
		$cmd = '*' . count($args) . "\r\n";
		foreach ($args as $item) {
			$cmd .= '$' . strlen($item) . "\r\n" . $item . "\r\n";
		}
		fwrite(Redis::socket(), $cmd);
		$this->_cmd = $cmd;

		$response = $this->parse_response();

		return $response;
	}

	private function parse_response() {
		$line = fgets(Redis::socket());
		list($type, $result) = array($line[0], substr($line, 1, strlen($line) - 3));
		if ($type == '-') {
			trigger_error('CMD:' . $this->_cmd . '<br />' . $result, E_USER_ERROR);

			return false;
		}
		else if ($type == '$') {
			if ($result == -1) {
				$result = null;
			} else {
				$line = fread(Redis::socket(), $result + 2);
				$result = substr($line, 0, strlen($line) - 2);
			}
		}
		else if ($type == '*') {
			$count = (int) $result;
			for ($i = 0, $result = array(); $i < $count; $i++) {
				$m = $this->parse_response();

				$result[] = $m;
			}
		}

		return $result;
	}
}