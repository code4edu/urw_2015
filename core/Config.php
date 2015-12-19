<?php

namespace core;

class Config {
	private $config;

	public function __construct(array $config) {
		$this->config = $config;
	}

	public function __get($key) {
		if ($this->config[$key] !== null) {
			return $this->config[$key];
		}

		return null;
	}

	public function __set($key, $value) {
		$this->config[$key] = $value;
	}
}
