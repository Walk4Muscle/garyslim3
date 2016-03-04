<?php

require_once 'utility/corsMiddleware.class.php';
require_once 'utility/authMiddleware.class.php';
require_once 'utility/tokenUtil.service.php';
$container = $app->getContainer();

$container['secret'] = function ($c) {
	return $c->get('settings')['secret'];
};
$container['cors'] = function ($c) {
	return new CorsMiddleware($c->get('settings')['cors']);
};
$container['db'] = $container->factory(function ($c) {
	return new medoo($c->get('settings')['db']);
});
$container['logger'] = function ($c) {
	$settings = $c->get('settings');
	$logger = new \Monolog\Logger($settings['logger']['name']);
	$logger->pushProcessor(new \Monolog\Processor\UidProcessor());
	$logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['logger']['path'], \Monolog\Logger::DEBUG));
	return $logger;
};

$container['token'] = function ($c) {
	return new Token($c['secret']);
};

$container['initPWD'] = function ($c) {
	return $c->get('settings')['initPWD'];
};
// $basic_auth = new AuthMiddleware($container['secret']);
// $container->register($basic_auth);
// return $container;

/**
include all model classes
 **/
$model_dir = 'models';
// foreach (scandir($model_dir, 1) as $file) {
// 	include_once $model_dir . '/' . $file;
// }
if ($handle = opendir($model_dir)) {

	while (false !== ($entry = readdir($handle))) {

		if ($entry != "." && $entry != "..") {

			include_once $model_dir . '/' . $entry;
		}
	}

	closedir($handle);
}