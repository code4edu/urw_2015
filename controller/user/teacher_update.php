<?php

use core\App;
use core\helper\Input;

$app = App::getInstance();

$app->checkAuth();

$currentUser = $app->getCurrentUser();

$user = $app->User->get($currentUser->id);
$teacher = $app->User->getTeachers($currentUser->school_id);

$app->renderPage('teacher', array(
	'user' => $user,
	'teachers' => $teachers,
));
