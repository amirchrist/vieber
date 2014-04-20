<?php

namespace Vieber;

class Core {
	public function error($error = null) {
		if ($error === null) {
			return Error::failed();
		}

		Error::set($error);

		return false;
	}

	public function error_msg() {
		return Error::get(true);
	}
}