<?php

namespace core\helper;

class Input {
	static function post($key) {
		return isset($_POST[$key]) ? $_POST[$key] : null;
	}

	static function get($key) {
		return isset($_GET[$key]) ? $_GET[$key] : null;
	}

	static function cookie($key) {
		return isset($_COOKIE[$key]) ? $_COOKIE[$key] : null;
	}

	static function isPost() {
		return count($_POST) || strtolower($_SERVER['REQUEST_METHOD']) == 'post';
	}
	
	static function getURL() {
		return preg_replace('~\/{2,}~', '/', '/' . trim(self::get('url'), '/') . '/');
	}
}