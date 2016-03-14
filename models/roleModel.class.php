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
		$result = $db->debug()->select("role_accesses", [
			"[>]role" => ["role_id" => "id"],
			"[>]accesses" => ['access_id' => "id"],
		], [
			// "role.id",
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
	public function addAccess($role_id, $access_ids) {
		$db = $this->getDB();
		$insert_data = [];
		foreach ($access_ids as $key => $value) {
			if (is_integer($value)) {
				array_push($insert_data, ['role_id' => $role_id, 'access_id' => $value]);
			} else if (isset($value['access_id'])) {
				array_push($insert_data, ['role_id' => $role_id, 'access_id' => (int) $value['access_id']]);
			} else {
				$error = ['status' => false, 'error' => 'Invalid data'];
				return $this->resultHander($error);
			}
		}
		$result = $db->insert("role_accesses", $insert_data);
		return $this->returnData($result);
	}

	/**
	 * @Author   Gary_Liu
	 * @DateTime 2016-03-10T17:00:55+0800
	 * @param    [type]
	 * @param    [type]
	 * @return   [type]
	 */
	public function rmAccess($role_id, $access_ids) {
		$db = $this->getDB();
		$result = $db->delete("role_accesses", [
			"AND" => [
				"role_id" => $role_id,
				"access_id" => $access_ids,
			],
		]);
		return $this->resultHander($error);
	}
}