<?php

namespace Vieber;

class Model {
	protected $db;

	public function __construct() {
		$this->db = new Db('localhost', 'root', 'phpfox', 'vieber');
	}
}

