<?php
$app->get('/{id:[0-9]+}', function ($req, $res, $args) {
	$db = $this->get('db');
	// $data = isset($args['id']) ? $db->select('user', '*', ['id' => $args['id']]) : $db->select('user', '*', ['LIMIT' => 1]);
	$data = $db->select('user', '*', ['id' => $args['id']]);
	// echo $db->last_query();
	return $res->write(json_encode($data));
});

$app->delete('/{id}', function ($req, $res, $args) {
	$db = $this->get('db');
	$data = $db->delete('user', ['id' => $args['id']]);
	var_dump($db->error());
	echo $data;
});

$app->get('/list[/{page:[0-9]+}[/{size:[0-9]+}]]', function ($req, $res, $args) {
	$page = isset($args['page']) ? $args['page'] : 0;
	$size = isset($args['size']) ? $args['size'] : 10;
	// var_dump($req->getQueryParams());
	$db = $this->get('db');
	$data = $db->select('user', '*', ['LIMIT' => [$page, $size]]);
	return $res->write(json_encode($data));
});