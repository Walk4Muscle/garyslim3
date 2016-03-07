<?php
require_once '/utility/medooHelper.class.php';

class roleModel extends medooHelper {
	public function listView() {
		$db = $this->getDB();
		$result = $db->select("role", [
			"[>]role_accesses" => ["id" => "role_id"],
			"[>]accesses" => ['role_accesses.access_id' => "accesses.id"],
		], [
			"role.id",
			"role.alias(role_alias)",
			"role_accesses.id(role_access_id)",
			"accesses.id(accesses_id)",
			"accesses.service(service)",
			"accesses.action(action)",
			"accesses.alias(accesses_alias)",
		]);
		var_dump($db->error());
		return $this->returnData($result);
	}
}