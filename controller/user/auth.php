<?php

use core\App;
use core\helper\Input;

$app = App::getInstance();

if ($app->getCurrentUser() !== null) {
	$app->redirect('/');
}

$error = null;

if (Input::isPost()) {
	$login = trim(htmlspecialchars(Input::post('login')));
	$password = Input::post('password');

	if ($app->auth($login, $password)) {
		$app->redirect('/');
	}
	else {
		$error = "Неверные данные для входа";
	}
}

$app->render('auth', array(
	'error' => $error,
));