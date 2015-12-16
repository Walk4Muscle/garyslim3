<?php
session_start();
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\Stream;
require 'vendor/autoload.php';

$container = require_once 'configuration/container.php';
$app = new Slim\App($container);

$app->add($container->get('cors'));

$app->get('/', function ($req, $res, $args) {
	$db = $this->get('db');

	//return $res->withHeader('Content-Length', '100000000000');
});

$app->get('/image', function (Request $request, Response $response, $args) {
	$image = '123.jpg';
	$body = new Stream(fopen($image, 'r'));
	return $response
		->withStatus(200, 'OK')
		->withHeader('Content-Type', 'image/jpeg')
		->withHeader('Content-Length', filesize($image))
		->withBody($body);
});

$app->group('/tests', function () {
	require_once 'routes/tests.api.php';
});

$app->group('/root', function () {
	$app->get('/leaf1', function () {
		echo 'leaf1';
	});
	$app->group('/leaf2', function () {
		$app->get('/leaf3', function () {
			echo 'leaf3 in leaf2';
		});
	});
});

$app->run();

?>