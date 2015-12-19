<?php

namespace core;

abstract class Singleton {
	static $instances = array();

	final public static function getInstance() {
		$class = get_called_class();

		if (!isset($instances[$class])) {
			$instances[$class] = new $class();
		}

		return $instances[$class];
	}

	protected function __construct() { }
	
	final private function __clone() { }
}