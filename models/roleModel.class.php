<?php
require_once '/utility/medooHelper.class.php';

class roleModel extends medooHelper {
	/**
	 * view role - role_access - access table
	 *
	 * @Author   Gary_Liu
	 * @DateTime {{datatime}}
	 * @param    array
	 * @return   [type]
	 */
	public function listView($where = []) {
		$db = $this->getDB();
		$result = $db->select("role_accesses", [
			"[>]role" => ["role_id" => "id"],
			"[>]accesses" => ['access_id' => "id"],
		], [
			"role.id",
			"role.alias(role_alias)",
			"role_accesses.id(role_access_id)",
			"accesses.id(accesses_id)",
			"accesses.service(service)",
			"accesses.action(action)",
			"accesses.alias(accesses_alias)",
		], $where);
		// var_dump($db->error());
		return $this->returnData($result);
	}

	/**
	 * @Author   Gary Liu
	 * @DateTime 2016-03-09T23:18:37+0800
	 * @param    [integer] $role_id
	 * @param    [array(integer)|array(object)] $access_ids
	 * @return   [array]
	 */
	public function access($role_id, $access_ids) {
		$db = $this->getDB();
		$insert_data = [];
		foreach ($access_ids as $key => $value) {
			if (is_integer($value)) {
				array_push($insert_data, ['role_id' => $role_id, 'access_id' => $value]);
			}
			if (isset($value['access_id'])) {
				array_push($insert_data, ['role_id' => $role_id, 'access_id' => $value['access_id']]);
			} else {
				$error = ['status' => false, 'error' => 'Invalid data'];
			}
		}
		$result = $db->select("role_accesses", $insert_data);
		return $this->returnData($result);
	}
}