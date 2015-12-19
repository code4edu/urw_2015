<?php

namespace core;

use core\helper\Input;

class App extends Singleton {
	private $config;
	private $router;

	private $models;
	private $currentUser = null;

	public $vars;

	public $db;

	public function init(Config $config) {
		$this->config = $config;
		
		$this->router = new Router($this->config->routes);
	}

	public function start() {
		$dbConfig = $this->config->db;
		
		$this->db = new lib\db($dbConfig['host'], $dbConfig['user'], $dbConfig['password'], $dbConfig['database'], true);
		
		$accessToken = Input::cookie('access_token');

		if ($accessToken !== null) {
			$this->currentUser = $this->User->getByAccessToken($accessToken);
		}

		$this->router->start();
	}

	public function auth($login, $password) {
		$user = $this->User->getByLoginData($login, $password);

		if ($user === null) {
			return false;
		}

		$accessToken = $this->User->setAccessToken($user->id);

		$_SESSION['access_token'] = $accessToken;
		$_COOKIE['access_token'] = $accessToken;

		$this->currentUser = $user;

		return true;
	}

	public function redirect($url = '/') {
		return $this->router->redirect($url);
	}

	public function getCurrentUser() {
		return $this->currentUser;
	}


	public function render($template, $vars = array()) {
		$this->vars = (object) array_merge((array) $this->vars, $vars);

		require 'view/' . $template . '.php';
	}
	
	public function renderPage($template, $vars = array()) {
		$vars['inner_template'] = $template;

		$this->render('_main-template', $vars);
	}

	public function __get($model) {
		if ($this->models[$model] === null) {
			$model = '\model\\' . $model;
			$this->models[$model] = $model::getInstance();
		}

		return $this->models[$model];
	}
}
