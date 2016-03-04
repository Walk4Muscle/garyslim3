<?php
class medooHelper {
	/**
	 * name of table
	 **/
	public $_table;
	public $db = null;
	protected $pk = 'id';
	protected $logger;
	protected $return_format = 'array'; //array||json
	protected $model_layout = 'Model';
	protected $enable_null_update = [];
	const LEFT_JOIN = "[>]";
	const RIGH_JOIN = "[<]";
	const FULL_JOIN = "[<>]";
	const INNER_JOIN = "[><]";
	public function __construct() {
		$this->db = $GLOBALS['app']->getContainer()->get('db');
		$this->logger = $GLOBALS['app']->getContainer()->get('logger');
		// $data = $this->db->select("user", '*');
		// var_dump($data);
		if (empty($this->_table)) {
			$this->_table = $this->getClassName();
		}
	}
	public function get($id, $field = null) {
		$db = $this->db;
		$result = $db->select($this->_table, $field ? $field : '*', [$this->pk => $id]);
		return $this->returnData($result);
	}
	public function add($data) {
		$db = $this->db;
		$result = $db->insert($this->_table, $data);
		$return = $this->resultHander($result);
		// if ($result > 0) {
		// 	$return = ['status' => true];
		// } else {
		// 	$return = ['status' => false, 'error' => $db->error()];
		// 	$log_item = array_merge($return, ['last_query' => $db->last_query()]);
		// 	$this->logError($log_item);
		// }
		return $this->returnData($return);
	}
	public function update($data, $where = null) {
		$db = $this->db;
		$id = $data[$this->pk];
		unset($data[$this->pk]);
		// http://www.php.net/manual/en/function.array-filter.php
		$data = array_filter($data, function ($v, $k) {
			return (in_array($k, $this->enable_null_update) || $v);
		}, ARRAY_FILTER_USE_BOTH);
		// var_dump($data);
		if (empty($where)) {
			$where = ['id' => $id];
		}
		$result = $db->update($this->_table, $data, $where);
		$return = $this->resultHander($result);
		// if ($result > 0) {
		// 	$return = ['status' => true];
		// } else {
		// 	$return = ['status' => false, 'error' => $db->error()];
		// 	$log_item = array_merge($return, ['last_query' => $db->last_query()]);
		// 	$this->logError($log_item);
		// }
		return $this->returnData($return);
	}
	public function delete($where) {
		$db = $this->db;
		if (is_array($where)) {
			$result = $db->delete($this->_table, $where);
		} else {
			$result = $db->delete($this->_table, [$this->pk => $where]);
		}
		$return = $this->resultHander($result);
		return $this->returnData($return);
	}
	/**
	 * $option array
	 * $option['field'] string
	 * $option['where'] array http://medoo.in/api/where
	 **/
	public function listData($option = null) {
		$db = $this->db;
		if (!isset($option)) {
			$result = $db->select($this->_table, '*');
		} else {
			if (isset($option['field']) && isset($option['where'])) {
				$result = $db->select($this->_table, $option['field'], $option['where']);
			} elseif (isset($option['field'])) {
				# code...
				$result = $db->select($this->_table, $option['field']);
			} elseif (isset($option['where'])) {
				$result = $db->select($this->_table, '*', $option['where']);
			}
		}
		return $this->returnData($result);
	}
	/**
	 * http://medoo.in/api/select
	 * select($table, $columns, $where)
	table [string]
	The table name.
	columns [string/array]
	The target columns of data will be fetched.
	where (optional) [array]
	The WHERE clause to filter records.
	 * select($table, $join, $columns, $where)
	 **/
	// public function select($option) {
	// 	$db = $this->db;
	// }

	public function getClassName() {
		if (empty($this->name)) {
			$name = substr(get_class($this), 0, -strlen($this->model_layout));
			if ($pos = strrpos($name, '\\')) {
				$this->name = substr($name, $pos + 1);
			} else {
				$this->name = $name;
			}
		}
		return $this->name;
	}
	protected function returnData($data) {
		switch ($this->return_format) {
		case 'array':
			# code...
			return $data;
			break;
		case 'json':
			return json_encode($data);
			break;
		default:
			# code...
			return $data;
			break;
		}
	}
	private function logError($data) {
		$this->logger->error(json_encode($data));
	}
	private function resultHander($result) {
		if ($result > 0) {
			$return = ['status' => true];
		} else {
			$return = ['status' => false, 'error' => $this->db->error()];
			$log_item = array_merge($return, ['last_query' => $this->db->last_query()]);
			$this->logError($log_item);
		}
		return $return;
	}
}