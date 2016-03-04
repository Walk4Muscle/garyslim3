<?php
$this->get('/', function ($req, $res, $args) {
	$token = array(
		"iat" => 1357999524,
		"nbf" => 1357000000,
	);
	$jwt = $this->get('token')->encode($token, $this->get('secret'));
	echo __DIR__;
});
$this->post('/login', function ($req, $res, $args) {
	if ($req->getParsedBody()) {
		$data = $req->getParsedBody();
		// $data['password'] = base64_encode($data['password'] . $this->get('secret'));
		$data['password'] = base64_encode(hash_hmac("sha256", ($data['password'] ? $data['password'] : $this->get('initPWD')), $this->get('secret'), true));
		$db = $this->get('db');
		if ($db->has('user', ['username' => $data['username']])) {
			if ($db->has('user', ['AND' => $data])) {
				// var_dump($this->get('token'));
				return $res->write(json_encode(['access_token' => $this->get('token')->generateToken($data)]));
			} else {
				// echo $db->last_query();
				return $res->withStatus(401)->write("Password error.");
			}
		} else {
			return $res->withStatus(403)->write("No such Username \"{$data['username']}\".");
		}
		// echo base64_encode($data['password'] . $this->get('secret'));
	} else {
		return $res->withStatus(403)->write("No Post Username or password!");
	}
})->setName('login');
$this->get('/logout', function ($req, $res, $args) {
});