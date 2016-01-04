<?php
return [
	'settings' => [
		'displayErrorDetails' => true,
	],
	'cors_settings' => [
		'origin' => '*',
		// 'headers' => '',
		// 'methods' => 'PUT',
		'age' => 43200,
	],
	'db_settings' => [
		/**
		Implement with Medoo
		reference http://medoo.in/api/new
		 **/
		// 'database_type' => 'mysql',
		// 'database_name' => 'test',
		// 'server' => 'localhost',
		// 'username' => 'root',
		// 'password' => 'root',
		// 'charset' => 'utf8',
		// // [optional]
		// 'port' => 3306,
		// // [optional] Table prefix
		// // 'prefix' => 'PREFIX_',
		// // driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
		// 'option' => [
		// 	PDO::ATTR_CASE => PDO::CASE_NATURAL,
		// ],
		'database_type' => 'sqlite',
		'database_file' => 'db/test.s3db',
	],
	'auth_settings' => [
		'serect' => 'garyAPIserver',
	],
];