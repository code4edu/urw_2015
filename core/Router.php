<?php

namespace core;

class Router {
	private $routes;
	private $controller;

	public function __construct(array $routes) {
		$this->routes = $routes;
	}

	public function start() {
		$this->controller = $this->findController();

		$path = 'controller/' . $this->controller . '.php';

		if (file_exists($path)) {
			require($path);
		}
		else {
			// $this->pageNotFound();
		}
	}

	public function findController() {
		$controller = null;

		foreach($this->routes as $pattern => $route) {
			$url = helper\Input::getURL();
			$pattern = preg_replace('/\//', '\/', $pattern);

			if(preg_match('/^' . $pattern . '$/i', helper\Input::getURL())) {
				$controller = $route;
				break;
			}
		}

		return $controller !== null ? $controller : '404';
	}

	public function pageNotFound() {
		exit('404');
	}

	public function redirect($url = '/') {
		helper\Headers::add('Location: ' . $url);
		helper\Headers::send();

		exit();
	}
}