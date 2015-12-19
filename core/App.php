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
		$dbConfig = $this->config->db;

		$this->db = new lib\db($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['database'], true);
		$this->router->start();
	}

	private function getDb() {
		return $this->db;
	}
}
