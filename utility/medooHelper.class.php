<?php

class medooHelper {
	/**
	name of table
	 **/
	protected $_table;

	protected $db = null;

	protected $pk = 'id';
	protected $logger;
	protected $return_format = 'array'; //array||json
	protected $model_layout = 'Model';
	protected $enable_null_update = [];

	public function __construct() {
		$this->db = $GLOBALS['app']->getContainer()->get('db');
		$this->logger = $GLOBALS['app']->getContainer()->get('logger');
		// $data = $this->db->select("user", '*');
		// var_dump($data);
		if (empty($this->_table)) {
			$this->_table = $this->getClassName();
		}
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
		return $this->returndata($return);
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
		return $this->returndata($return);
	}

	public function delete($where) {
		$db = $this->db;
		if (is_array($where)) {
			$result = $db->delete($this->_table, $where);
		} else {
			$result = $db->delete($this->_table, [$this->pk => $where]);
		}
		$return = $this->resultHander($result);
		// if ($result > 0) {
		// 	$return = ['status' => true];
		// } else {
		// 	$return = ['status' => false, 'error' => $db->error()];
		// 	$log_item = array_merge($return, ['last_query' => $db->last_query()]);
		// 	$this->logError($log_item);
		// }
		return $this->returndata($return);
	}

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

	protected function returndata($data) {
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
			$return = ['status' => false, 'error' => $db->error()];
			$log_item = array_merge($return, ['last_query' => $db->last_query()]);
			$this->logError($log_item);
		}
		return $return;
	}
}