<?php
// require 'utility/authMiddeware.class.php';

$app->get('/[{name}]', function ($req, $res, $args) {
	echo $req->getUri()->getPath();
	// $route = $req->getAttribute('route');
	// var_dump($route);
})->add(AuthMiddleware::class);