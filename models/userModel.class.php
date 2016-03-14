<?php
require_once '/utility/medooHelper.class.php';

class userModel extends medooHelper {
	public function getPermission($userId) {
		$db = $this->getDB();
		$scope_array = [];
		$roleModel = new roleModel();
		$list = $roleModel->listView([
			$this->getTable() . ".id" => $userId,
		]);
		foreach ($list as $key => $value) {
			array_push($scope_array, "{$value['service']}.{$value['action']}");
		}
		var_dump($scope_array);
		return $scope_array;
	}
}