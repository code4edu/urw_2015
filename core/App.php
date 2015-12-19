<?php

namespace core;

class App extends Singleton {
	private $config;
	private $router;
	private $db;

	private $models;

	public function init(Config $config) {
		$this->config = $config;

		$this->router = new Router($this->config->routes);
	}

	public function start() {
		$dbConfig = $this->config->db;

		// $this->db = new lib\db($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['database'], true);
		$this->router->start();
	}

	private function getDb() {
		return $this->db;
	}

	public function __get($model) {
		if ($this->models[$model] === null) {
			$model = '\model\\' . $model;
			$this->models[$model] = $model::getInstance();
		}

		return $this->models[$model];
	}
}
