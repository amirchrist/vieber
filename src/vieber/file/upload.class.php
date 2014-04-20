<?php

namespace Vieber\File;

class Upload extends \Vieber\Core {
	private $_file;
	private $_new_name;
	private $_ext;

	public function __construct($file) {
		$this->_file = $file;

		$this->_ext = pathinfo($this->_file['name'], PATHINFO_EXTENSION);
		$this->_new_name = md5(uniqid() . $this->_file['name']) . '.' . $this->_ext;
	}

	public function upload() {
		$path = \Vieber\Engine::$static_path . 'uploads' . VIEBER_DS . $this->_new_name;
		if (!move_uploaded_file($this->_file['tmp_name'], $path)) {
			return $this->error('Unable to move this file. Make sure the folder static/uploads/ has "write" access.');
		}

		return true;
	}

	public function url() {
		return \Vieber\Engine::$static_url . 'uploads/' . $this->_new_name;
	}

	public function name() {
		return $this->_new_name;
	}
}