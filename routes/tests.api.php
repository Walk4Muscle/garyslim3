<?php
// require 'utility/authMiddeware.class.php';
$app->get('/[{name}]', function ($req, $res, $args) {
	// var_export($this->get('cors'));exit;
	// echo $req->getUri()->getPath();
	// var_dump($this->get('basic_auth'));
	// $db = $GLOBALS['app']->getContainer()->get('db');
	// $db = new medoo([
	// 	'database_type' => 'mysql',
	// 	'database_name' => 'test',
	// 	'server' => 'localhost',
	// 	'username' => 'root',
	// 	'password' => '',
	// ]);
	// $r = $db->insert("user", ["username" => "", "email" => ""]);
	// var_dump($r);
	// var_dump($db->log());
	// var_dump($db->error());
	// $model = new roleModel();
	// $result = $model->listview();
	// var_dump($result);
	$model = new userModel();
	$result = $model->getPermission(1);
	var_dump($result);
	// foreach ($result as $key => $value) {
	// 	$value['displayname'] = $value['username'];
	// 	$model->update($value);
	// }
	// $route = $req->getAttribute('route');
	// var_dump($route);
	// })->add(AuthMiddleware::class);
});
$app->post('/', function ($req, $res, $args) {
	var_export($req->getParsedBody());
});