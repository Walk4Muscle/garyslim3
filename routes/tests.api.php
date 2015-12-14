<?php
$app->get('/[{name}]', function ($req, $res, $args) {
	echo json_encode($args);
});