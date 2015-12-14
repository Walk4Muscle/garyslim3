<?php
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\Stream;
require 'vendor/autoload.php';
require 'utility/corsMiddeware.class.php';
$configuration = [
	'settings' => [
		'displayErrorDetails' => true,
	],
	'cors_settings' => [
		'origin' => '*',
		// 'headers' => '',
		// 'methods' => 'PUT',
		'age' => 43200,
	],
];
$c = new Slim\Container($configuration);
$c['cors'] = function ($c) {
	return new CorsMiddleware($c['cors_settings']);
};

$app = new Slim\App($c);
// $app->add(function (Request $req, Response $res, $next) {
// 	// $res->getBody()->write(json_encode($req->getHeaders()));
// 	// return $res->withHeader("Access-Control-Allow-Origin", '*');
// 	$response = $next($req, $res);
// 	return $response->withHeader("Access-Control-Allow-Origin", '*');
// });

$app->add($c->get('cors'));

$app->get('/', function ($req, $res, $args) use ($app) {
	return $res->withHeader('Content-Length', '100000000000');
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
$app->get('/container', function ($req, $res, $args) use ($app) {
	echo 123;
});

$app->group('/tests', function () use ($app) {
	require_once 'routes/tests.api.php';
});

$app->group('/root', function () use ($app) {
	$app->get('/leaf1', function () use ($app) {
		echo 'leaf1';
	});
	$app->group('/leaf2', function () use ($app) {
		$app->get('/leaf3', function () use ($app) {
			echo 'leaf3 in leaf2';
		});
	});
});

$app->run();

?>