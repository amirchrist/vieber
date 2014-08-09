<?php

namespace Vieber\Markup;

class Form {
	private $_form = [];
	private $_values = [];

	public function __construct($params) {
		$this->_form = $params;
	}

	public function values($values) {
		$this->_values = (array) $values;
	}

	public function get() {
		foreach ($this->_form as $name => $form) {
			$extra = '';
			if (isset($form['required'])) {
				$extra .= ' required="true" message="' . $form['message'] . '" ';
			}

			if (isset($this->_values[$name])) {
				$extra .= ' value="' . str_replace('"', '&#34;', json_encode($this->_values[$name])) . '" ';
			}

			echo '<m:form type="' . $form['type'] . '" name="' . $name . '" title="' . $form['title'] . '" ' . $extra . ' />';
		}
	}

	public function valid($val) {
		foreach ($this->_form as $name => $form) {
			if (isset($form['required']) && empty($val->$name)) {
				\Vieber\Error::set($form['message']);
			}
		}

		return (\Vieber\Error::failed() ? false : true);
	}
}