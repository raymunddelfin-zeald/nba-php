<?php

include 'include/utils.php';

/**
 * Model class
 */
class Model {
	protected static $table;
	protected static $properties = [];

	function __construct($args = []) {
		if ($args) {
			foreach ($args as $key => $value) {
				if (in_array($key, static::$properties)) {
					$this->$key = $value;
				}
			}
		}
	}

	public static function add_fields(...$new_fields) {
		if (is_array($new_fields)) {
			static::$properties = array_merge(static::$properties, $new_fields);
		}
	}

	public function getProperties() {
		return static::$properties;
	}

	public function save() {
		$sql_parts = [];
		foreach (static::$properties as $field) {
			$sql_parts[] = "$field = '" . addslashes($this->$field) . "'";
		}

		$sql = "REPLACE {static::$table} SET " . implode(',', $sql_parts);

		query($sql);
	}

	public function retrieve($args, $default = 'AND') {
		$where_args = [];
		if (!is_array($args)) {
			$where_args['id'] = $args;
		} else {
			$where_args = $args;
		}

		$where_fields = [];
		foreach ($where_args as $key => $value) {
			$where_fields[] = "$key = '" . addslashes($value) . "'";
		}

		$sql = "SELECT * FROM " . self::$table . " WHERE " . implode($default, $where_fields);

		$result = query($sql);
		if ($result) {
			foreach ($result[0] as $key => $value) {
				$this->$key = $value;
			}
		}
	}

	public static function search($where_args, $default = 'AND') {
		if (!is_array($where_args)) {
			$where_args = ['id' => $where_args];
		}

		foreach (static::$properties as $field) {
			if (!isset($where_args[$field])) {
				continue;
			}
			$where_fields[] = "$field = '" . addslashes($where_args[$field]) . "'";
		}

		$sql = "SELECT * FROM " . static::$table . " WHERE " . implode($default, $where_fields);
		$results = query($sql);

		$objects = [];
		foreach ($results as $result) {
			$objects[] = new static($result);
		}

		return $objects;
	}

	public function delete($args, $default = 'AND') {
		$where_args = [];
		if (!is_array($args)) {
			$where_args['id'] = $args;
		} else {
			$where_args = $args;
		}

		$where_fields = [];
		foreach ($where_args as $key => $value) {
			$where_fields[] = "$key = '" . addslashes($value) . "'";
		}

		$sql = "DELETE FROM {self::$table} WHERE " . implode($default, $where_fields);

		$result = query($sql);
		if ($result) {
			foreach ($result[0] as $key => $value) {
				$this->$key = $value;
			}
		}
	}

}

?>