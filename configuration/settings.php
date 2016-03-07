<?php
return [
	'settings' => [
		'displayErrorDetails' => true,
		'initPWD' => '123456',
		'secret' => 'garyAPIserverserectKey',
		'logger' => [
			'name' => 'slimApp',
			'path' => __DIR__ . '/../log/app_' . date("Y-m-d") . '.log',
		],
		'cors' => [
			'origin' => '*',
			'headers' => 'Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With',
			'methods' => 'PUT,POST,GET,DELETE,OPTIONS',
			'age' => 43200,
		],
		'db' => [
			/**
			Implement with Medoo
			reference http://medoo.in/api/new
			 **/
			// 'database_type' => 'mysql',
			// 'database_name' => 'test',
			// 'server' => 'localhost',
			// 'username' => 'root',
			// 'password' => '',
			// 'charset' => 'utf8',
			// // [optional]
			// 'port' => 3306,
			// // [optional] Table prefix
			// // 'prefix' => 'PREFIX_',
			// // driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
			'option' => [
				PDO::ATTR_CASE => PDO::CASE_NATURAL,
			],
			'database_type' => 'sqlite',
			'database_file' => 'db/test.s3db',
		],
		'auth' => [
			'secret' => 'garyAPIserverserectKey',
		],
	],

];