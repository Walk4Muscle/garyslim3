<?php
session_start();
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Http\Stream;

require 'vendor/autoload.php';
/**
 * init app
 **/

$configuration = require_once 'configuration/settings.php';
$app = new Slim\App($configuration);
$GLOBALS['app'] = $app;
/**
 * load dependency injection
 */
require_once 'configuration/dependencies.php';

$app->add($container->get('cors'));

$app->get('/', function ($req, $res, $args) {
	// $db = $this->get('db');
	// $data = $db->select("user", '*');

	// $model = new userModel();
	// $result = $model->update(['username' => 'username', 'email' => 'email@mail.com', 'password' => '']);
	// var_dump($result);
	// return $res->withBody($result);
	// $data = $db->insert("user", [
	// 	'username' => 'user',
	// 	'email' => 'user@domain.com',
	// 	'password' => 'userpwd',
	// ]);
	// var_dump($data);
	// echo $db->last_query();
	// echo 'index';
	// return $res->withHeader('Content-Length', '819');
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

require_once 'routes/routes.php';

$app->run();

?>