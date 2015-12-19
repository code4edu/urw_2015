<?php

namespace core;

abstract class Singleton {
	static $instances = array();

	final public static function getInstance() {
		$class = get_called_class();

		if (!isset(self::$instances[$class])) {
			self::$instances[$class] = new $class();
		}

		return self::$instances[$class];
	}

	protected function __construct() { }
	
	final private function __clone() { }
}