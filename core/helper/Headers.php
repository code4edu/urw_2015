<?php

namespace core\helper;

class Headers
{
	
	private static $headers = array();
	private static $contentType = 'text/html';
	private static $charset = 'UTF-8';
	
	public static function send() {
		self::add('Content-type: ' . self::$contentType . ';charset=' . self::$charset);
		
		foreach (self::$headers as $header) {
			header($header);
		}
	}
	
	public static function add($header) {
		self::$headers[] = $header;
	}
	
	public static function setContentType($contentType) {
		self::$contentType = $contentType;
	}
	
	public static function setCharset($charset) {
		self::$charset = $charset;
	}
	
}