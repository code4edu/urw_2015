<?php

use core\App;
use core\helper\Input;

$app = App::getInstance();

$app->checkAuth();

$currentUser = $app->getCurrentUser();

$user = $app->User->get($currentUser->id);

$app->renderPage('main', array(
	'user' => $user,
));
