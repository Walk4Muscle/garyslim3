<?php

require 'vendor/autoload.php';
require_once 'utility/corsMiddleware.class.php';
require_once 'utility/authMiddleware.class.php';
$configuration = require_once 'settings.php';
$container = new Slim\Container($configuration);
$container['secret'] = $configuration['secret'];
$container['cors'] = function ($c) {
	return new CorsMiddleware($c['cors_settings']);
};
$container['db'] = $container->factory(function ($c) {
	return new medoo($c['db_settings']);
});
// var_dump($container);exit;
$container['auth'] = function ($c) {
	return new AuthMiddleware($c['auth_settings']);
};
// $basic_auth = new AuthMiddleware($configuration['auth_settings']);
// $container->register($basic_auth);
return $container;