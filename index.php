<?php
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\Stream;
require 'vendor/autoload.php';

$configuration = [
	'settings' => [
		'displayErrorDetails' => true,
	],
];
$c = new Slim\Container($configuration);

$app = new Slim\App($c);

$app->add(function (Request $req, Response $res, $next) {
	return $res->withHeader("Access-Control-Allow-Origin", '*');
});
// $app->map(['OPTIONS'], '/:x+', function ($x) {
// 	http_response_code(200);
// });
$app->get('/', function (Request $request, Response $response, $args) {
	$image = '123.jpg';
	$body = new Stream(fopen($image, 'r'));
	return $response
		->withStatus(200, 'OK')
		->withHeader('Content-Type', 'image/jpeg')
		->withHeader('Content-Length', filesize($image))
		->withBody($body);
});

$app->group('/tests', function () {
	$this->get('/[{name}]', function ($req, $res, $args) {
		echo json_encode($args);
	});
});

$app->run();

?>