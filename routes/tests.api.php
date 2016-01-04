<?php
// require 'utility/authMiddeware.class.php';

$app->get('/[{name}]', function ($req, $res, $args) {
	echo $req->getUri()->getPath();
	var_dump($this->get('auth'));
	// $route = $req->getAttribute('route');
	// var_dump($route);
	// })->add(AuthMiddleware::class);
})->add($this->get('auth'));