<?php

namespace core;

abstract class Model extends Singleton {
	protected $table;

	protected $app;

	final public function __construct() {
		$this->app = App::getInstance();
	}

	public function get($id) {
		return $this->app->db->query('
			SELECT *
			FROM ' . $this->table . '
			WHERE id = ' . (int) $id . '
		')->result();
	}

	public function get_list($ids = array()) {
		return $this->app->db->query('
			SELECT *
			FROM ' . $this->table . '
			WHERE is_deleted = 0
		')->result();
	}
}
