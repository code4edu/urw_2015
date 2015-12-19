<?php

namespace core;

abstract class Model extends Singleton {
	protected $table;

	protected $app;

	final public function __construct() {
		$this->app = \core\App::getInstance();
	}

	public function get($id) {
		
	}

	public function get_list($ids = array()) {
		
	}
}
