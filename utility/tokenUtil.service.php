<?php
use \Firebase\JWT\JWT;

class Token extends JWT {

	private $key;

	public function __construct($key) {
		self::setKey($key);
	}

	public function setKey($key) {
		$this->key = (String) $key;
	}

	public function getKey() {
		return $this->key;
	}

	public function generateToken($data = null) {
		$issuedAt = time();
		// $notBefore = $issuedAt + 10;
		$expire = $issuedAt + 3600;
		$data = array_merge(
			[
				'iat' => $issuedAt,
				'exp' => $expire,
			],
			$data
		);
		return JWT::encode($data, $this->key);
	}
}