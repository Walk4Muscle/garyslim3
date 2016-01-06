<?php
$app->get('/dir', function ($req, $res) {
	echo __DIR__;
});
$app->group('/tests', function () use ($app) {
	require_once 'tests.api.php';
});

$app->group('/user', function () use ($app) {
	require_once 'user.api.php';
});

$app->group('/auth', function () use ($app) {
	require_once 'auth.api.php';
});

$app->group('/root', function () {
	$this->get('/leaf1', function () {
		echo 'leaf1';
	});
	$this->group('/leaf2', function () {
		$this->get('/leaf3', function () {
			echo 'leaf3 in leaf2';
		});
	});
});
