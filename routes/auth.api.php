<?php
use \Firebase\JWT\JWT;
$this->get('/', function ($req, $res, $args) {
	$token = array(
		"iat" => 1356999524,
		"nbf" => 1357000000,
	);
	$jwt = JWT::encode($token, $this->get('secret'));
	echo $jwt;
});

$this->post('/login', function ($req, $res, $args) {

});

$this->get('/logout', function ($req, $res, $args) {

});
