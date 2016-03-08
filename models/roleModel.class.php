<?php
require_once '/utility/medooHelper.class.php';

class roleModel extends medooHelper {
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
		return $this->returnData($result);
	}
}