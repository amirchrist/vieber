<?php

namespace Vieber\Db\Layer;

class Mysqli {
	private $_mysqli;
	private $_query;

	public function __construct($host, $user, $pass, $name) {
		$this->_mysqli = new \Mysqli($host, $user, $pass, $name);
	}

	public function query($query) {
		$obj = $this->_mysqli->query($query);
		if (!$obj) {
			exit($this->_mysqli->error);
		}

		return $obj;
	}

	public function select($select) {
		$this->_set('SELECT', $select);

		return $this;
	}

	public function from($table) {
		$this->_set('FROM', $table);

		return $this;
	}

	public function where(array $where) {
		$this->_set('WHERE', $where);

		return $this;
	}

	public function get() {
		$objects = array();

		$query = $this->query($this->_query());
		while ($row = $query->fetch_object()) {
			$objects[] = $row;
		}

		return $objects;
	}

	private function _query() {
		$sql = 'SELECT ' . $this->_query['SELECT'] . ' ';
		$sql .= 'FROM ' . $this->_query['FROM'] . ' ';

		if (!empty($this->_query['JOINS'])) {
			$sql .= implode('', $this->_query['JOINS']) . ' ';
		}

		if (!empty($this->_query['WHERE'])) {
			$sql .= 'WHERE ';
			$sql .= $this->_where($this->_query['WHERE']) . ' ';
		}

		if (!empty($this->_query['ORDER'])) {
			$sql .= 'ORDER BY ';
			$sql .= $this->_query['ORDER'] . ' ';
		}

		if (!empty($this->_query['GROUP'])) {
			$sql .= 'GROUP BY ';
			$sql .= $this->_query['GROUP'] . ' ';
		}

		if (!empty($this->_query['HAVING'])) {
			$sql .= 'HAVING ';
			$sql .= $this->_query['HAVING'] . ' ';
		}

		if (!empty($this->_query['LIMIT'])) {
			$sql .= $this->_query['LIMIT'] . ' ';
		}

		$this->_query = array();

		return $sql;
	}

	private function _where($wheres) {
		$sql = '';
		foreach ($wheres as $key => $value) {
			if (is_array($value)) {
				foreach ($value as $action => $new_value) {
					switch ($action) {
						case '==':
							$sql .= $key .' = ' . $new_value;
							$sql .= ' AND ';
							break;
						case 'IN':
							$sql .= $key .' IN(' . implode(',', $new_value) . ')';
							$sql .= ' AND ';
							break;
					}
				}
				continue;
			}
			$sql .= $key .' = \'' . mysqli_real_escape_string($this->_mysqli, $value) . '\'';
			$sql .= ' AND ';
		}

		$sql = rtrim($sql, ' AND ');

		return $sql;
	}

	private function _set($key, $value) {
		if (!isset($this->_query[$key])) {
			if (is_array($value)) {
				$this->_query[$key] = [];
			} else {
				$this->_query[$key] = '';
			}
		}

		if (is_array($value)) {
			$this->_query[$key] = array_merge($this->_query[$key], $value);
		} else {
			$this->_query[$key] .= $value;
		}
	}
}