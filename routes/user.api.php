<?php
$app->put('/', function ($req, $res, $args) {
	// var_dump($req->getParsedBody());
	// $this->get('logger')->info(json_encode($req->getParsedBody()));
	if ($req->getParsedBody()) {
		$data = $req->getParsedBody();
		$data['password'] = base64_encode(hash_hmac("sha256", ($data['password'] ? $data['password'] : $this->get('initPWD')), $this->get('secret'), true)
		);
		// $data = $db->insert('user', $data);
		$model = new userModel();
		$result = $model->add($data);
		// echo $db->last_query();
		return $res->write(json_encode($result));
	} else {
		return $res->withStatus(403)->write("No Post data!");
	}
});
$app->get('/{id:[0-9]+}', function ($req, $res, $args) {
	// $db = $this->get('db');
	// $data = isset($args['id']) ? $db->select('user', '*', ['id' => $args['id']]) : $db->select('user', '*', ['LIMIT' => 1]);
	// $data = $db->select('user', '*', ['id' => $args['id']]);
	$model = new userModel();
	$result = $model->get($args['id']);
	// echo $db->last_query();
	return $res->write(json_encode($result));
});
$app->post('/{id:[0-9]+}', function ($req, $res, $args) {
	if ($req->getParsedBody()) {
		$data = $req->getParsedBody();
		$model = new userModel();
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
	$model = new userModel();
	$result = $model->delete($args['id']);
	return $res->write(json_encode($result));
});
$app->get('/list[/{page:[0-9]+}[/{size:[0-9]+}]]', function ($req, $res, $args) {
	$page = isset($args['page']) ? $args['page'] : 0;
	$size = isset($args['size']) ? $args['size'] : 10;
	// var_dump($req->getQueryParams());
	// $db = $this->get('db');
	// $data = $db->select('user', '*', ['LIMIT' => [$page, $size]]);
	$option['where'] = ['LIMIT' => [$page, $size]];
	$model = new userModel();
	$result = $model->listData($option);
	return $res->write(json_encode($result));
});
$app->post('/pwd/{id:[0-9]+}', function ($req, $res, $args) {
	// if ($req->getParsedBody()) {
	$data = $req->getParsedBody();
	$data['password'] = base64_encode(hash_hmac("sha256", (isset($data['password']) ? $data['password'] : $this->get('initPWD')), $this->get('secret'), true)
	);
	$data['id'] = $args['id'];
	$model = new userModel();
	$result = $model->update($data);
	return $res->write(json_encode($result));
	// } else {
	// 	return $res->withStatus(403)->write("No Post data!");
	// }
});