<?php

namespace Vieber;

class Error {
	private static $_errors = [];

	public static function set($error) {
		self::$_errors[] = $error;
	}

	public static function get($show = false) {
		return ($show ? implode(' ', self::$_errors) : self::$_errors);
	}

	public static function failed() {
		return (count(self::$_errors) ? true : false);
	}
}