<?php
use \Psr\Http\Message\ResponseInterface;
use \Psr\Http\Message\ServerRequestInterface;

class CorsMiddleware {

	private $cors_origin;
	private $cors_header;
	// private $cors_methods;
	private $cors_age;

	public function __construct($settings) {
		// var_dump($settings);
		if (isset($settings['origin'])) {
			$this->cors_origin = $settings['origin'];
		}
		if (isset($settings['headers'])) {
			$this->cors_header = is_string($settings['headers']) ? $settings['headers'] : implode("," . " ", $settings['headers']);
		}
		if (isset($settings['methods'])) {
			$this->cors_methods = is_string($settings['methods']) ? $settings['methods'] : implode("," . " ", $settings['methods']);
		}
		if (isset($settings['age'])) {
			$this->cors_age = $settings['age'];
		}
	}

	/**
	 * Example middleware invokable class
	 *
	 * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
	 * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
	 * @param  callable                                 $next     Next middleware
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next) {
		// $response = $response->withHeader('Content-Length', '100000000000');
		if (isset($this->cors_origin)) {
			$response = $response->withHeader("Access-Control-Allow-Origin", $this->cors_origin);
		}
		if (isset($this->cors_header)) {
			$response = $response->withHeader("Access-Control-Allow-Headers", $this->cors_header);
		}
		if (isset($this->cors_methods)) {
			$response = $response->withHeader("Access-Control-Allow-Methods", $this->cors_methods);
		}
		if (isset($this->cors_age)) {
			$response = $response->withHeader("Access-Control-Max-Age", $this->cors_age);
		}
		$response = $next($request, $response);
		return $response;
	}

}