<?php
$app->put('/', function ($req, $res, $args) {
	if ($req->getParsedBody()) {
		$data = $req->getParsedBody();
		$model = new roleModel();
		$result = $model->add($data);
		// echo $db->last_query();
		return $res->write(json_encode($result));
	} else {
		return $res->withStatus(403)->write("No Post data!");
	}
});
$app->get('/{id:[0-9]+}', function ($req, $res, $args) {
	$model = new roleModel();
	$result = $model->get($args['id']);
	return $res->write(json_encode($result));
});
$app->post('/{id:[0-9]+}', function ($req, $res, $args) {
	if ($req->getParsedBody()) {
		$data = $req->getParsedBody();
		$model = new roleModel();
		// $data = isset($args['id']) ? $db->select('user', '*', ['id' => $args['id']]) : $db->select('user', '*', ['LIMIT' => 1]);
		$result = $model->update($data);
		return $res->write(json_encode($result));
	} else {
		return $res->withStatus(403)->write("No Post data!");
	}
});
$app->delete('/{id:[0-9]+}', function ($req, $res, $args) {
	// $db = $this->get('db');
	// $data = $db->delete('user', ['id' => $args['id']]);
	$model = new roleModel();
	$result = $model->delete($args['id']);
	return $res->write(json_encode($result));
});
$app->get('/list[/{page:[0-9]+}[/{size:[0-9]+}]]', function ($req, $res, $args) {
	$page = isset($args['page']) ? $args['page'] : 0;
	$size = isset($args['size']) ? $args['size'] : 10;
	$option['where'] = ['LIMIT' => [$page, $size]];
	$model = new roleModel();
	$result = $model->listData($option);
	return $res->write(json_encode($result));
});
$app->get('/getRoleAccess[/{id:[0-9]+}]', function ($req, $res, $args) {
	$where = [];
	if (isset($args['id'])) {
		$where['id'] = $args['id'];
	}
	$model = new roleModel();
	$result = $model->listView($where);
	return $res->write(json_encode($result));
});