<?php
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use \Psr\Http\Message\ResponseInterface;
use \Psr\Http\Message\ServerRequestInterface;

class AuthMiddleware implements ServiceProviderInterface {

	private $serect;

	public function __construct($settings) {
		if (isset($settings['serect'])) {
			$this->serect = $settings['serect'] ? $settings['serect'] : 'DEFAULT_SERECT';
		}
	}
	/**
	 * Register service provider
	 *
	 * @param \Pimple\Container $container
	 */
	public function register(Container $container) {
		$container['basic_auth'] = $this;
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
		$response->getBody()->write($request->getUri()->getPath());
		$response->getBody()->write($this->serect);
		$authToken = $this->getToken($request->getHeader('Authorization'));
		if (!$authToken) {
			$response = $response->withStatus(401);
		} else {
			$response->getBody()->write($authToken);
		}
		$response = $next($request, $response);

		return $response;
	}

	private function getToken($tokenString) {
		if (!$tokenString) {
			return null;
		}
		$token = str_replace("Bearer ", "", $tokenString);
		if (!$token) {
			return null;
		} else {
			return $token;
		}
	}

	private function expireToken() {

	}

}