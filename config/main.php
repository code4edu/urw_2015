<?php

return array(
	'routes' => array(
		'/' => 'main',
		'/auth/' => 'user/auth',

		'/teacher/' => 'user/teacher',
		'/teacher/add/' => 'user/teacher_update',
		'/teacher/\d+/update/' => 'user/teacher_update',
	),

	'db' => array(
		'host' => 'localhost',
		'user' => 'root',
		'password' => '',
		'database' => 'urw_dev',
	)
);
