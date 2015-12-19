<?php

namespace core;

class App extends Singleton {
	private $config;
	private $router;
	private $db;

	public function init(Config $config) {
		$this->config = $config;

		$this->router = new Router($this->config->routes);
	}

	public function start() {
		$this->router->start();
	}
}
