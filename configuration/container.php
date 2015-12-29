<?php

require 'vendor/autoload.php';
require 'utility/corsMiddeware.class.php';
require 'utility/authMiddeware.class.php';
$configuration = require_once 'settings.php';
$container = new Slim\Container($configuration);
$container['cors'] = function ($c) {
	return new CorsMiddleware($c['cors_settings']);
};
$container['db'] = $container->factory(function ($c) {
	return new medoo($c['db_settings']);
});
// var_dump($container);exit;
$container['auth'] = $container->factory(function ($c) {
	return new AuthMiddleware();
});
return $container;