<?php

/**
 * Model class
 */
class Model {
	protected static $tableId;
	protected static $table;
	protected static $properties = [];
	protected static $join_args = [];
	protected static $group_args = [];
	protected static $order_args = [];

	function __construct($args = []) {
		$this->set($args);
	}

	function set($args = []) {
		if ($args) {
			foreach ($args as $key => $value) {
				if (in_array($key, static::$properties)) {
					$this->$key = $value;
				}
			}
		}

		return $this;		
	}

	public static function get($where_args, $default = 'AND') {	
		$obj = self::search($where_args, $default);
		if ($obj) {
			return $obj[0];
		}
		return false;
	}	

	public static function add_fields(...$new_fields) {
		if (is_array($new_fields)) {
			static::$properties = array_merge(static::$properties, $new_fields);
		}

		return $this;
	}

	public function getProperties() {
		return static::$properties;
	}

	public function save() {
		$sql_parts = [];

		$insert = false;
		$id = $this->{static::$tableId};
		if (!$id) {
			$insert = true;
			$this->{static::$tableId} = rand(0, 999999999);
		}

		foreach (static::$properties as $field) {
			$sql_parts[] = "'" . addslashes($field) . "' = '" . addslashes($this->$field) . "'";
		}

		if (!$insert) {
			$sql = "UPDATE " . static::$table . " SET " . implode(',', $sql_parts) . " WHERE " . static::$tableId . " = " . addslashes($id);
		} else {
			$sql = "REPLACE " . static::$table . " SET " . implode(',', $sql_parts);
		}

		query($sql);

		return $this;
	}

	/**
	 * Retrieve records
	 */
	public function retrieve($args, $default = 'AND') {
		$where_args = [];
		if (!is_array($args)) {
			$where_args[static::$tableId] = $args;
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

		return $this;
	}

	public function join($table, $compare, $type = 'INNER JOIN') {
		if ($table && $compare) {
			static::$join_args = array_merge(static::$join_args, $new_args);
		}

		return $this;
	}


	public static function query($sql, $limit = 0) {
		if (!$sql) {
			return;
		}

		$results = query($sql);

		$objects = [];
		foreach ($results as $result) {
			$objects[] = new static($result);
		}

		return $objects;		
	}

	public static function search($where_args, $default = 'AND') {
		if (!is_array($where_args) && static::$tableId) {
			$where_args = [static::$tableId => $where_args];
		}

		$where_fields = [];
		foreach (static::$properties as $field) {
			if (!isset($where_args[$field])) {
				continue;
			}
			$where_fields[] = "$field = '" . addslashes($where_args[$field]) . "'";
		}

		$sql = "SELECT * FROM " . static::$table . ($where_fields ? " WHERE " . implode($default, $where_fields) : " LIMIT 1");
		$results = query($sql);

		$objects = [];
		foreach ($results as $result) {
			$objects[] = new static($result);
		}

		return $objects;
	}

	public function delete($args, $default = 'AND') {
		$where_args = [];
		if (!is_array($args) && static::$tableId) {
			$where_args[static::$tableId] = $args;
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

		return $this;
	}

	/**
	 * Print summary of the Model
	 * @return model
	 */
	public function describe() {
	}
}

?>