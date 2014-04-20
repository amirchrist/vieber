<?php

namespace Vieber;

class Db {
	private $_layer;

	public function __construct($host, $user, $pass, $name) {
		$this->_layer = new Db\Layer\Mysqli($host, $user, $pass, $name);
	}

	public function select($select) {
		return $this->_layer->select($select);
	}

	public function from($table) {
		return $this->_layer->from($table);
	}

	public function where(array $where) {
		return $this->_layer->where($where);
	}

	public function get() {
		return $this->_layer->get();
	}
}