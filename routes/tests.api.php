<?php
// require 'utility/authMiddeware.class.php';

$app->get('/[{name}]', function ($req, $res, $args) {
	$route = $req->getAttribute('route');
})->add(AuthMiddleware::class);