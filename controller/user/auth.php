<?php

use core\App;
use core\helper\Input;

$app = App::getInstance();

if ($app->getCurrentUser() !== null) {
	$app->redirect('/');
}

if (Input::isPost()) {
	
}

$app->render('auth', array(

));