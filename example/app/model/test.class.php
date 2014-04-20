<?php

namespace App;

class Test extends \Vieber\Model {
	public function foo() {
		$foo = $this->db->select('*')
			->from('test')
			->where(['foo' => 'bar'])
			->get();

		return $foo;
	}
}