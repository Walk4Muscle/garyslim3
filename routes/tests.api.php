<?php
// require 'utility/authMiddeware.class.php';
$app->get('/[{name}]', function ($req, $res, $args) {
	echo $req->getUri()->getPath();
	// var_dump($this->get('basic_auth'));
	$model = new userModel();
	$result = $model->db->select($model->_table, "*", ["id[>]" => 2]);
	var_dump($result);
	// $route = $req->getAttribute('route');
	// var_dump($route);
	// })->add(AuthMiddleware::class);
});