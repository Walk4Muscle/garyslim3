<?php
// phpinfo();
require 'vendor/autoload.php';
$db = new medoo([
	'database_type' => 'mysql',
	'database_name' => 'test',
	'server' => 'localhost',
	'username' => 'root',
	'password' => '',
	'option' => [
		PDO::ATTR_CASE => PDO::CASE_NATURAL,
	],
]);
$r = $db->insert("user", []);
var_dump($r);
var_dump($db->log());
var_dump($db->error());